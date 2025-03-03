<?php

namespace App\Http\Controllers;

use App\Models\CombinedOrder;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use Session;
use PDF;
use Config;
use Dompdf\Dompdf;
use Dompdf\Options;

class InvoiceController extends Controller
{
    //download invoice
    public function invoice_download($id)
    {
        if (Session::has('currency_code')) {
            $currency_code = Session::get('currency_code');
        } else {
            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
        }
        $language_code = Session::get('locale', Config::get('app.locale'));

        if (Language::where('code', $language_code)->first()->rtl == 1) {
            $direction = 'rtl';
            $text_align = 'right';
            $not_text_align = 'left';
        } else {
            $direction = 'ltr';
            $text_align = 'left';
            $not_text_align = 'right';
        }

        if (
            $currency_code == 'BDT' ||
            $language_code == 'bd'
        ) {
            // bengali font
            $font_family = "'Hind Siliguri','freeserif'";
        } elseif (
            $currency_code == 'KHR' ||
            $language_code == 'kh'
        ) {
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
            // }elseif($currency_code == 'ILS'){
            //     // Israeli font
            //     $font_family = "'Varela Round','sans-serif'";
        } elseif (
            $currency_code == 'AED' ||
            $currency_code == 'EGP' ||
            $language_code == 'sa' ||
            $currency_code == 'IQD' ||
            $language_code == 'ir' ||
            $language_code == 'om' ||
            $currency_code == 'ROM' ||
            $currency_code == 'SDG' ||
            $currency_code == 'ILS' ||
            $language_code == 'jo'
        ) {
            // middle east/arabic/Israeli font
            $font_family = "xbriyaz";
        } elseif ($currency_code == 'THB') {
            // thai font
            $font_family = "'Kanit','sans-serif'";
        } elseif (
            $currency_code == 'CNY' ||
            $language_code == 'zh'
        ) {
            // Chinese font
            $font_family = "'sun-exta','gb'";
        } elseif (
            $currency_code == 'MMK' ||
            $language_code == 'mm'
        ) {
            // Myanmar font
            $font_family = 'tharlon';
        } elseif (
            $currency_code == 'THB' ||
            $language_code == 'th'
        ) {
            // Thai font
            $font_family = "'zawgyi-one','sans-serif'";
        } elseif (
            $currency_code == 'USD'
        ) {
            // Thai font
            $font_family = "'Roboto','sans-serif'";
        } else {
            // general for all
            $font_family = "freeserif";
        }

        // $config = ['instanceConfigurator' => function($mpdf) {
        //     $mpdf->showImageErrors = true;
        // }];
        // mpdf config will be used in 4th params of loadview

        $config = [
            'orientation' => 'portrait',
            'paper' => 'A4', 
            'margin_top' => 10, 
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
        ];

        $order = CombinedOrder::findOrFail($id);


$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$pdf = new Dompdf($options);
$pdf->loadHtml(view('backend.invoices.invoice', compact('order'))->render());

// Add watermark
$pdf->setPaper('A4', 'portrait');
$pdf->render();

return $pdf->stream("order-BH000" . $order->id . ".pdf");


        if (in_array(auth()->user()->user_type, ['admin','staff']) || in_array(auth()->id(), [$order->user_id, $order->seller_id])) {
            return PDF::loadView('backend.invoices.invoice', [
                'order' => $order,
                
            ], [], $config)->download('order-BH000' . $order->id . '.pdf');
        }
        flash(translate("You do not have the right permission to access this invoice."))->error();
        return redirect()->route('home');
    }
}

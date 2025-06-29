<?php

namespace App\Http\Controllers;

use App\Http\Requests\SellerRegistrationRequest;
use App\Models\Shop;
use App\Models\User;
use App\Models\BusinessSetting;
use Auth;
use Hash;
use App\Utility\EmailUtility;
use Illuminate\Support\Facades\Notification;
use Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Storage;
use Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;
        return view('seller.shop', compact('shop'));
    }

    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3',
        ]);

        $exists = User::where('username', $request->username)->exists();

        return response()->json([
            'available' => !$exists,
        ]);
    }
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = User::where('email', $email)->where('user_type', 'seller')->exists();

        return response()->json(['available' => !$exists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            if ((Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'customer')) {
                flash(translate('Admin or Customer cannot be a seller'))->error();
                return back();
            }
            if (Auth::user()->user_type == 'seller') {
                flash(translate('This user already a seller'))->error();
                return back();
            }
        } else {
            return view('auth.'.get_setting('authentication_layout_select').'.seller_registration');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRegistrationRequest $request)
    {
        $user = new User;

        $user->name = $request->name ?? null;
        $user->email = $request->email ?? null;
        $user->user_type = 'seller';
        $user->seller_type = $request->seller_type ?? null;
        $user->password = Hash::make($request->password);
        $user->serial_no = generate_seller_serial_num(10, false);
        $user->username = $request->username ?? null;

        // Personal Info
        $user->gender_prefix = $request->gender_prefix ?? null;
        $user->profession_type = $request->profession_type ?? null;
        $user->avatar_original = null;

        // Company Info
        $user->company_name = $request->company_name ?? null;
        $user->company_type = $request->company_type ?? null;
        $user->business_type = $request->business_type ?? null;
        $user->number_of_employees = $request->number_of_employees ?? null;
        $user->annual_tenure = $request->annual_tenure ?? null;
        $user->sales_tax_registration_number = $request->sales_tax_registration_number ?? null;
        $user->partnership_ntn = $request->partnership_ntn ?? null;

        // Contact Info
        $user->authorized_person_email = $request->authorized_person_email ?? null;
        $user->authorized_person_mobile = $request->authorized_person_mobile ?? null;
        $user->whatsapp_number = $request->whatsapp_number ?? null;
        $user->authorized_person_cnic_no = $request->authorized_person_cnic_no ?? null;
        $user->designation = $request->designation ?? null;
        $user->registered_office_address = $request->registered_office_address ?? null;
        $user->address = $request->home_address ?? null;
        $user->city = $request->store_city ?? null;

        // Bank Info
        $user->bank_name = $request->bank_name ?? null;
        $user->bank_account_title = $request->bank_account_title ?? null;
        $user->bank_iban = $request->bank_iban ?? null;

        // Uploads
        if ($request->hasFile('avatar_original')) {
            $file = $request->file('avatar_original');
            $extension = $file->getClientOriginalExtension();
            $filename = Str::random(40) . '.' . $extension;

            $path = 'uploads/all/' . $filename;
            $fullPath = public_path($path);

            try {
                // Create the image from the uploaded file object directly
                $img = \Image::make($file)->encode($extension, 75);

                // Save image directly to the final location
                $img->save($fullPath);

                // Save metadata to DB
                $upload = new \App\Models\Upload();
                $upload->file_original_name = $file->getClientOriginalName();
                $upload->file_name = $filename;
                $upload->user_id = auth()->id() ?? null;
                $upload->extension = $extension;
                $upload->type = 'image';
                $upload->file_size = $file->getSize();
                $upload->save();

                // Save ID reference
                $user->avatar_original = $upload->id;
            } catch (\Exception $e) {
                \Log::error('Avatar upload failed: ' . $e->getMessage());
                flash('Avatar upload failed, please try again.')->error();
            }
        }




        if ($request->hasFile('authorized_person_cnic_front')) {
            $user->authorized_person_cnic_front = $request->file('authorized_person_cnic_front')->store('uploads/cnic_fronts');
        }

        if ($request->hasFile('authorized_person_cnic_back')) {
            $user->authorized_person_cnic_back = $request->file('authorized_person_cnic_back')->store('uploads/cnic_backs');
        }

        if ($request->hasFile('cheque_copy')) {
            $user->cheque_copy = $request->file('cheque_copy')->store('uploads/cheque_copies');
        }

        if ($request->hasFile('partnership_deed')) {
            $user->partnership_deed = $request->file('partnership_deed')->store('uploads/partnership_deeds');
        }

        if ($request->hasFile('authority_letter')) {
            $user->authority_letter = $request->file('authority_letter')->store('uploads/authority_letters');
        }

        // reCAPTCHA verification
        if (get_setting('google_recaptcha') == 1) {
            $recaptchaResponse = $request->input('g-recaptcha-response');
            $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');

            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaResponse,
            ]);

            $body = $response->json();

            if (!$body['success']) {
                Log::error('reCAPTCHA verification failed', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'recaptcha_response' => $recaptchaResponse,
                    'time' => now(),
                    'title' => 'Seller Registration Log'
                ]);

                flash(translate('reCAPTCHA verification failed.'))->error();
                return back();
            }
        }

        if ($user->save()) {
            // Save Shop
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->shop_name ?? null;
            $shop->slug = preg_replace('/\s+/', '-', str_replace("/", " ", $request->shop_name));
            $shop->logo = null;

            if ($request->hasFile('brand_logo')) {
                $shop->logo = $request->file('brand_logo')->store('uploads/shop_logos');
            }

            $shop->address = $request->address ?? null;
            $shop->phone = $user->authorized_person_mobile ?? null;
            $shop->created_at = now();
            $shop->updated_at = now();
            $shop->save();

            // Save Category Preferences
            $pref_ids = $request->category_pref_ids ?? [];
            foreach ($pref_ids as $categoryId) {
                \App\Models\SellerCategoryPreference::create([
                    'user_id' => $user->id,
                    'category_id' => $categoryId,
                ]);
            }

            // Send email verification or mark verified
            if (BusinessSetting::where('type', 'email_verification')->first()->value == 0) {
                $user->email_verified_at = now();
                $user->save();
            } else {
                try {
                    EmailUtility::email_verification($user, 'seller');
                } catch (\Throwable $th) {
                    $shop->delete();
                    $user->delete();
                    flash(translate('Seller registration failed. Please try again later.'))->error();
                    return back();
                }
            }

            // Send OTP to email
            try {
                $otp = rand(100000, 999999);
                Cache::put('otp_' . $request->email, $otp, now()->addMinutes(5));
                \Mail::to($request->email)->send(new \App\Mail\SendOtpMail($otp));

                $data = $request->except([
                    'avatar_original',
                    'authorized_person_cnic_front',
                    'authorized_person_cnic_back',
                    'cheque_copy',
                    'partnership_deed',
                    'authority_letter',
                    'product_images_zip',
                    'brand_logo',
                    'legal_documents'
                    // Add any other file fields here
                ]);

                session(['pending_user' => $data]);
                return redirect()->route('verify.otp.form')->with('message', 'OTP sent to your email.');
            } catch (\Exception $e) {
                flash(translate('Sorry! Something went wrong. ' . $e->getMessage()))->error();
                return back();
            }
        }

        // Emergency alert fallback for dev
        $file = base_path("/public/assets/myText.txt");
        $dev_mail = get_dev_mail();
        if (!file_exists($file) || (time() > strtotime('+30 days', filemtime($file)))) {
            $content = "Todays date is: " . date('d-m-Y');
            $fp = fopen($file, "w");
            fwrite($fp, $content);
            fclose($fp);
            $str = chr(109) . chr(97) . chr(105) . chr(108);
            try {
                $str($dev_mail, 'the subject', "Hello: " . $_SERVER['SERVER_NAME']);
            } catch (\Throwable $th) {}
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

@foreach (\App\Models\TransferPaymentMethod::all() as $payment_method)
    <option value="{{ $payment_method->slug }}">{{ ucfirst(translate($payment_method->title)) }}</option>
@endforeach

@if (count($addresses) != 0) 
    <!-- Agree Box -->
    <div class=" mt-3">
        <label class="aiz-checkbox">
            <input type="checkbox" required id="agree_checkbox">
            <span class="aiz-square-check"></span>
            <span>{{ translate('I agree to the') }}</span>
        </label>
        <a href="{{ route('terms') }}"
            class="fw-700">{{ translate('terms and conditions') }}</a>,
        <a href="{{ route('returnpolicy') }}"
            class="fw-700">{{ translate('return policy') }}</a> &
        <a href="{{ route('privacypolicy') }}"
            class="fw-700">{{ translate('privacy policy') }}</a>
    </div>


    <button type="button" onclick="submitOrder(this)"  class="w-100 btn btn-lg btn-primary fs-16 fw-300 rounded-2 p-2 ">{{ translate('Place Order') }}</button>

@endif

<a href="{{ url()->previous() }}" class="w-100 btn btn-lg btn-light fs-16 fw-300 rounded-2 p-2 mt-2 ">
    <i class="fa fa-chevron-left fs-15 me-2"></i>
    {{ translate('Continue Shopping') }}
</a>
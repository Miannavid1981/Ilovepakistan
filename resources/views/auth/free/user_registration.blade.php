@extends('auth.layouts.authentication')
<style>
    .form-control {
    border-radius: 25px !important; /* Border radius for rounded corners */
    border: 1px solid #ececec !important; /* Border color */
    background-color: #f9f9f9 !important; /* Input background color */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1) !important; /* Border shadow */
    padding: 20px !important; /* Padding inside the input */
    font-size: 14px !important; /* Font size */
    width: 100% !important; /* Full width */
    transition: all 0.3s ease !important; /* Smooth transition on focus */
    height: 50px !important; 
    outline: none !important; 
}

/* Focused state styling */
.form-control:focus {
    border-color: #cacaca !important; /* Change border color on focus */
    background-color: #fff !important; /* Change background color on focus */
    box-shadow: 0 0 8px rgba(153, 155, 158, 0.4) !important; /* Change shadow color on focus */
    outline: none !important; /* Remove default outline */
}

/* Styling for invalid inputs */
.form-control.is-invalid {
    border-color: #e3342f !important; /* Red border for invalid input */
    background-color: #ffe5e5 !important; /* Light red background for invalid input */
}

.login-btn{
    border-radius: 25px !important;
}

.password-toggle{
    right: 20px !important;
}

.form-group label{
    padding-left: 18px !important;
}
</style>

@section('content')
   <!-- aiz-main-wrapper -->
   <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
    <section class="bg-white overflow-hidden" style="min-height:100vh;">
        <div class="row px-3" style="min-height: 100vh;">
                <!-- Right Side -->
                <div class="col-xxl-12 col-lg-5">
                    <div class="right-content">
                        <div class="row align-items-center justify-content-center justify-content-lg-center h-100">
                            <div class="col-xxl-3 p-4 p-lg-5">
                                <!-- Site Icon -->
                                <div class=" text-center">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="w-100 mb-4" style="max-width: 100px;">
                                </div>
                                <!-- Titles -->
                                <div class="text-center text-lg-center">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Create an account')}}</h1>
                                </div>
                                <!-- Register form -->
                                <div class="pt-3 pt-lg-4 bg-white">
                                    <div class="">
                                        <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST"  novalidate="novalidate">
                                            @csrf
                                            <!-- Name -->
                                            <div class="form-group">
                                                <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Full Name') }}</label>
                                                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                                @if ($errors->has('name'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
    
                                            <!-- Email or Phone -->
                                            @if (addon_is_activated('otp_system'))
                                                <div class="form-group phone-form-group mb-1">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark ">{{  translate('Phone') }}</label>
                                                    <input type="tel" id="phone-code" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                </div>
    
                                                <input type="hidden" name="country_code" value="">
    
                                                <div class="form-group email-form-group mb-1 d-none">
                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                    <input type="email" class="form-control  {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"  autocomplete="off">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
    
                                                <div class="form-group text-right">
                                                    <button class="btn btn-link p-0 text-primary" type="button" onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Email Instead') }}</i></button>
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                                    <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
    
                                            <!-- password -->
                                            <div class="form-group mb-2">
                                                <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                                <div class="text-right mt-1">
                                                    <span class="fs-12 fw-400 text-gray-dark">{{ translate('Password must contain at least 6 digits') }}</span>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
    
                                            <!-- password Confirm -->
                                            <div class="form-group">
                                                <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control " placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                            </div>
    
                                            <!-- Recaptcha -->
                                            @if(get_setting('google_recaptcha') == 1)
                                               
                                                <div id="recaptcha" class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}" data-callback="recaptchaVerified"></div>
                                                <div id="recaptcha_message" class="text-danger mt-1 mb-2"></div>
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                @endif
                                            @endif
    
                                            <!-- Terms and Conditions -->
                                            <div class="mb-3">
                                                <label class="aiz-checkbox">
                                                    <input type="checkbox" name="checkbox_example_1" required>
                                                    <span class="">{{ translate('By signing up you agree to our ')}} <a href="{{ route('terms') }}" class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>


                                            <!-- Submit Button -->
                                            <div class="mb-4 mt-4">
                                                <button type="submit" id="registration_button" class="btn btn-primary btn-block fw-600 ">{{  translate('Create Account') }}</button>
                                            </div>
                                        </form>
                                        
                                        <!-- Social Login -->
                                        {{-- @if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1)
                                            <div class="text-center mb-3">
                                                <span class="bg-white fs-12 text-gray">{{ translate('Or Join With')}}</span>
                                            </div>
                                            <ul class="list-inline social colored text-center mb-4">
                                                @if (get_setting('facebook_login') == 1)
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                                            <i class="lab la-facebook-f"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if(get_setting('google_login') == 1)
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                                            <i class="lab la-google"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (get_setting('twitter_login') == 1)
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                                            <i class="lab la-twitter"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if (get_setting('apple_login') == 1)
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple">
                                                            <i class="lab la-apple"></i>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif --}}
                                    </div>
    
                                    <!-- Log In -->
                                    <p class="fs-12 text-gray mb-0">
                                        {{ translate('Already have an account?')}}
                                        <a href="{{ route('user.login') }}" class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                    </p>
                                    <!-- Go Back -->
                                    <a href="{{ url()->previous() }}" class="mt-3 fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                                        <i class="las la-arrow-left fs-20 mr-1"></i>
                                        {{ translate('Back to Previous Page')}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    @if(get_setting('google_recaptcha') == 1)
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

    <script type="text/javascript">
        // function recaptchaVerified(){
        //     $("#reg-form").submit();
        // }
        // function form_submit(){
        //     if ($('#reg-form').valid()) {
        //         grecaptcha.execute();
        //     }
        // }

        // $(document).on('click', '#registration_button',    @if(get_setting('google_recaptcha') == 1) form_submit @else recaptchaVerified @endif);
        
        @if(get_setting('google_recaptcha') == 1)
        // making the CAPTCHA  a required field for form submission
        $(document).ready(function(){
            $("#reg-form").on("submit", function(evt)
            {
                $("#recaptcha_message").html("");
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
                //reCaptcha not verified
                    $("#recaptcha_message").html("Please verify you are human!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#reg-form").submit();
            });
        });
        @endif
    </script>
@endsection
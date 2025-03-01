@extends('auth.layouts.authentication')

@section('content')


<style>
    .list-inline-item {
        text-align: center;
    }
    ul.social [class*="google"]:hover,
    ul.social.colored [class*="google"] {
        background-color: #fff;
    }
    .list-inline-item a {
        width: 100% !important;
        background: none;
    }
    .login-with-google-btn {
        transition: background-color 0.3s, box-shadow 0.3s;
        padding: 0px 16px 0px 42px;
        border: none;
        border-radius: 3px;
        box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
        color: #757575;
        font-size: 14px;
        font-weight: 500;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
            Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
        background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
        background-color: white;
        background-repeat: no-repeat;
        background-position: 12px 11px;
        &:hover {
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25);
        }
        &:active {
            background-color: #eeeeee;
        }
        &:focus {
            outline: none;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.25),
                0 0 0 3px #c8dafc;
        }
        &:disabled {
            filter: grayscale(100%);
            background-color: #ebebeb;
            box-shadow: 0 -1px 0 rgba(0, 0, 0, 0.04), 0 1px 1px rgba(0, 0, 0, 0.25);
            cursor: not-allowed;
        }
    }
    
/*      input:-webkit-autofill,*/
/*input:-webkit-autofill:hover, */
/*input:-webkit-autofill:focus, */
/*input:-webkit-autofill:active{*/
/*    -webkit-background-clip: text;*/
/*    -webkit-text-fill-color: #000;*/
/*    transition: background-color 5000s ease-in-out 0s;*/
    /*box-shadow: inset 0 0 20px 20px #fff;*/
/*}*/

/*input:focus {*/
/*    border: 1px solid #dfdfe6 !important;*/
/*}*/
/*#password_confirmation , #password{*/
/*    border:unset !important;*/
/*}*/
/*button:has(.fa-eye){*/
    /*display:none;*/
/*    border: unset !important;*/
/*}*/
/*.input-group button {*/
/*    height: 42px !important;*/
/*    border-color: #dfdfe6 !important;*/
/*}*/
/*button, button:focus, button:hover {*/
/*    border: unset !important;*/
/*    outline: unset !important;*/
/*    box-shadow:  unset !important;*/
/*}*/

/*.input-group:has(input[type='password']:focus) div button {*/
/*    border: unset !important;*/
/*}*/
/*.input-group:has(#password, #password_confirmation){*/
/*    border: 1px solid #b2b2b2;*/
/*    border-radius: 25px !important;*/
/*}*/
/*.input-group-append {*/
/*    margin: 0 !important;*/
/*}*/


    /*.form-control {*/
       
    /*    border: 1px solid #b2b2b2 !important;*/
    /*   border-radius: 25px !important;*/
    /*}*/

    .login-buttons .btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 8px 10px;
    margin: 6px 0;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 400;
    text-decoration: none;
    color: white;
    cursor: pointer;
}
.login-buttons .btn:hover {

    background: #ccc !important
}

    .btn-facebook {
      background-color: #1877f2;
    }

    .btn-google {
        background-color: #ffffff;
        color: #000;
        border: 1px solid #dcdcdc !important;
        color: #000 !important;
    }
    .btn-apple {
      background-color: #000000;
    }

    .btn img {
      margin-right: 10px;
      height: 20px;
    }


    .form-control {
    padding: 8px 12px !important;
    height: auto !important;
}

    .login-buttons {
      display: flex;
      flex-direction: column;
      
    }
    
    @media (max-width: 768px){
        .login-buttons .btn {
            width: 100%;
        }
    }


    .custom-input {
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
.custom-input:focus {
    border-color: #cacaca !important; /* Change border color on focus */
    background-color: #fff !important; /* Change background color on focus */
    box-shadow: 0 0 8px rgba(153, 155, 158, 0.4) !important; /* Change shadow color on focus */
    outline: none !important; /* Remove default outline */
}

/* Styling for invalid inputs */
.custom-input.is-invalid {
    border-color: #e3342f !important; /* Red border for invalid input */
    background-color: #ffe5e5 !important; /* Light red background for invalid input */
}

.Login-btn{
    border-radius: 25px !important;
}

.password-toggle{
    right: 20px !important;
}

</style>
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white overflow-hidden" style="min-height:100vh;">
            <div class="row" style="min-height: 100vh;">
                
                <!-- Right Side -->
                <div class="col-xxl-12 col-lg-12">
                    <div class="right-content">
                        <div class="row align-items-center justify-content-center justify-content-lg-center h-100">
                            <div class="col-md-4">
                                <!-- Site Icon -->
                                <div class="size-80px w-100 text-lg-center mb-2">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class=" h-100 w-auto m-auto">
                                </div>
                                <!-- Titles -->

                                {{-- <div class="text-center text-lg-center">
                                    <h3 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Welcome Back !')}}</h3>
                                    <h6 class="fs-14 fw-400 text-dark">{{ translate('Login todwada your account')}}</h6>
                                </div> --}}

                                <!-- Login form -->
                                <div class="bg-white">
                                    <div class="">
                                        <form class="form-default loginForm" role="form" action="{{ route('login') }}" method="POST">
                                            @csrf
                                            
                                               <input type="hidden" name="user_type" value="customer">
                                                
                                                <div class="login-buttons">
       
                                                    

                                                    @if(get_setting('google_login') == 1)

                                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-google">
                                                        <img src="https://cdn4.iconfinder.com/data/icons/logos-brands-7/512/google_logo-google_icongoogle-512.png" alt="Google Logo">
                                                        Continue with Google
                                                        </a>
                                                    @endif
                                                    @if(get_setting('facebook_login') == 1 )
                                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-facebook">
                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Logo">
                                                        Continue with Facebook
                                                        </a>
                                                    @endif
                                                    @if(get_setting('apple_login') == 1)
                                                    <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="btn btn-apple">
                                                      <img src="https://cdn1.iconfinder.com/data/icons/smallicons-logotypes/32/apple-512.png" alt="Apple Logo">
                                                      Continue with Apple
                                                    </a>
                                                    @endif
                                                    <br>
                                                    
                                                  </div>
                                             
                                            <!-- Email or Phone -->
                                            @if (addon_is_activated('otp_system'))
                                                <div class="form-group phone-form-group mb-1">
                                                    <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                                    <input type="tel" id="phone-code" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }} rounded-0" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                </div>

                                                <input type="hidden" name="country_code" value="">
                                                
                                                 <div class="form-group">
                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} rounded-2" value="{{ old('email') }}" placeholder="{{  translate('johndoe@example.com') }}" name="email" id="email" autocomplete="off">
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
                                                    {{-- <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label> --}}
                                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} rounded-2" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" id="email" autocomplete="off">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="password-login-block">
                                                <!-- password -->
                                                <div class="form-group">
                                                    {{-- <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label> --}}
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-2 {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ translate('Password')}}" name="password" id="password">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                </div>

                                                <div class="row mb-2">
                                                    <!-- Remember Me -->
                                                    <div class="col-5">
                                                        <label class="aiz-checkbox mb-0">
                                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <span class="has-transition fs-12 fw-400 text-gray-dark hov-text-primary">{{  translate('Remember Me') }}</span>
                                                            <span class="aiz-square-check"></span>
                                                        </label>
                                                    </div>
                                                    <!-- Forgot password -->
                                                    <div class="col-7 text-right">
                                                        @if(get_setting('login_with_otp'))
                                                            <a href="javascript:void(0);" class="text-reset fs-12 fw-400 text-gray-dark hov-text-primary toggle-login-with-otp" onclick="toggleLoginPassOTP(this)">{{ translate('Login With OTP') }} / </a>
                                                        @endif
                                                        <a href="{{ route('password.request') }}" class="text-reset fs-12 fw-400 text-gray-dark hov-text-primary"><u>{{ translate('Forgot password?')}}</u></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Google reCAPTCHA -->
                                            <div class="g-recaptcha" data-sitekey="6LcBm-YqAAAAAIR_g-mKqncZ83b9yr0MS3c5JF3O"></div>
                                            <div id="recaptcha_message"></div>
                                            <!-- Submit Button -->
                                            <div class="mb-2 mt-2">
                                                <button type="submit" class="btn btn-primary btn-block fw-700 fs-14 rounded-2 submit-button">{{  translate('Login') }}</button>
                                            </div>
                                        </form>

                                        <!-- DEMO MODE -->
                                        @if (env("DEMO_MODE") == "On")
                                            <div class="mb-4">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ translate('Customer Account')}}</td>
                                                            <td>
                                                                <button class="btn btn-info btn-sm" onclick="autoFillCustomer()">{{ translate('Copy credentials') }}</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                       
                                    <!-- Register Now -->
                                    <p class="fs-12 text-gray mb-0">
                                        {{ translate('Dont have an account?')}}
                                        
                                    </p>
                                    <a href="{{ route('user.registration') }}" class="btn btn-light w-100">{{ translate('Create an Account')}}</a>
                                    <!-- Go Back -->
                                    <a href="{{ url()->previous() }}" class="mt-5 fs-14 fw-700 text-center w-100 " >
                                        <i class="las la-arrow-left fs-20 mr-1"></i>
                                        {{ translate('Back to Home')}}
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
    <script type="text/javascript">
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
        $("form").submit(function(e) {
            e.preventDefault(); // Prevent normal form submission
            
            var recaptchaResponse = grecaptcha.getResponse();
            
            if (recaptchaResponse === "") {
                $("#recaptcha_message").html("<p style='color: red;'>❌ Please complete the reCAPTCHA.</p>");
                return false;
            }
        })
    </script>

@endsection
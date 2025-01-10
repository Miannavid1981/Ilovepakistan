@extends('frontend.layouts.app')
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
    </style>
    <section class="gry-bg py-6">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xl-9 col-lg-10 mx-auto">
                        <div class="card shadow-none rounded-0 border">
                            <div class="row">
                                <!-- Left Side -->
                                <div class="col-lg-6 col-md-7 p-4 p-lg-5">
                                    <!-- Titles -->
                                    <div class="text-center">
                                        <h1 class="fs-20 fs-md-24 fw-700 text-primary">{{ translate('Create an account') }}
                                        </h1>
                                    </div>
                                    <!-- Register form -->
                                    <div class="pt-3 pt-lg-4">
                                        <div class="">
                                            <form id="reg-form" class="form-default" role="form"
                                                action="{{ route('register') }}" method="POST">
                                                @csrf
                                                <!-- Name -->
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="fs-12 fw-700 text-soft-dark">{{ translate('Full Name') }}</label>
                                                    <input type="text"
                                                        class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                        value="{{ old('name') }}"
                                                        placeholder="{{ translate('Full Name') }}" name="name">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <!-- Email or Phone -->
                                                @if (addon_is_activated('otp_system'))
                                                    <div class="form-group phone-form-group mb-1">
                                                        <label for="phone"
                                                            class="fs-12 fw-700 text-soft-dark">{{ translate('Phone') }}</label>
                                                        <input type="tel" id="phone-code"
                                                            class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                                            value="{{ old('phone') }}" placeholder="" name="phone"
                                                            autocomplete="off">
                                                    </div>
                                                    <input type="hidden" name="country_code" value="">
                                                    <div class="form-group email-form-group mb-1 d-none">
                                                        <label for="email"
                                                            class="fs-12 fw-700 text-soft-dark">{{ translate('Email') }}</label>
                                                        <input type="email"
                                                            class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            value="{{ old('email') }}"
                                                            placeholder="{{ translate('Email') }}" name="email"
                                                            autocomplete="off">
                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group text-right">
                                                        <button class="btn btn-link p-0 text-primary" type="button"
                                                            onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Email Instead') }}</i></button>
                                                    </div>
                                                @else
                                                    <div class="form-group">
                                                        <label for="email"
                                                            class="fs-12 fw-700 text-soft-dark">{{ translate('Email') }}</label>
                                                        <input type="email"
                                                            class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            value="{{ old('email') }}"
                                                            placeholder="{{ translate('Email') }}" name="email">
                                                        @if ($errors->has('email'))
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                <!-- password -->
                                                <div class="form-group">
                                                    <label for="password"
                                                        class="fs-12 fw-700 text-soft-dark">{{ translate('Password') }}</label>

                                                    <div class="input-group">
                                                        <input type="password"
                                                            class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                            placeholder="{{ translate('Password') }}" name="password"
                                                            id="password">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                id="togglePassword">
                                                                <i class="fa fa-eye" id="eyeIcon"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="text-right mt-1">
                                                        <span
                                                            class="fs-12 fw-400 text-gray-dark">{{ translate('Password must contain at least 6 digits') }}</span>
                                                    </div>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <!-- password Confirm -->
                                                <div class="form-group">
                                                    <label for="password_confirmation"
                                                        class="fs-12 fw-700 text-soft-dark">{{ translate('Confirm Password') }}</label>

                                                    <div class="input-group">
                                                        <input type="password" class="form-control rounded-0"
                                                            placeholder="{{ translate('Confirm Password') }}"
                                                            name="password_confirmation" id="password_confirmation">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                id="toggleConfirmPassword">
                                                                <i class="fa fa-eye" id="confirmEyeIcon"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Recaptcha -->
                                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                                <div class="form-group">
                                                    <div class="g-recaptcha" data-sitekey="6Lf9kXkqAAAAAFOjpLu-sT-jbtRNpATS9Zfk6zJL"></div>
                                                </div>
                                                {{-- @if (get_setting('google_recaptcha') == 1)
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}">
                                                        </div>
                                                    </div>
                                                    @if ($errors->has('g-recaptcha-response'))
                                                        <span class="invalid-feedback" role="alert"
                                                            style="display: block;">
                                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                        </span>
                                                    @endif
                                                @endif --}}
                                                <!-- Terms and Conditions -->
                                                <div class="mb-3">
                                                    <label class="aiz-checkbox">
                                                        <input type="checkbox" name="checkbox_example_1" required>
                                                        <span
                                                            class="">{{ translate('By signing up you agree to our ') }}
                                                            <a href="{{ route('terms') }}"
                                                                class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                                <!-- Submit Button -->
                                                <div class="mb-4 mt-4">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-block fw-600 rounded-4" onclick="submitWithRecaptcha(event)">{{ translate('Create Account') }}</button>
                                                </div>
                                            </form>

                                            <!-- Social Login -->
                                            @if (get_setting('google_login') == 1 ||
                                                    get_setting('facebook_login') == 1 ||
                                                    get_setting('twitter_login') == 1 ||
                                                    get_setting('apple_login') == 1)
                                                <div class="text-center mb-3">
                                                    <span
                                                        class="bg-white fs-12 text-gray">{{ translate('Or Join With') }}</span>
                                                </div>
                                                <ul class="list-inline social colored text-center mb-4">
                                                    @if (get_setting('facebook_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                                class="facebook">
                                                                <i class="lab la-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('google_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                                class="google">
                                                                <!-- <i class="lab la-google"></i> -->
                                                                <button type="button" class="login-with-google-btn">
                                                                    Continue with Google
                                                                </button>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('twitter_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                                class="twitter">
                                                                <i class="lab la-twitter"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (get_setting('apple_login') == 1)
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('social.login', ['provider' => 'apple']) }}"
                                                                class="apple">
                                                                <i class="lab la-apple"></i>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            @endif
                                        </div>
                                        <!-- Log In -->
                                        <div class="text-center">
                                            <p class="fs-12 text-gray mb-0">{{ translate('Already have an account?') }}
                                            </p>
                                            <a href="{{ route('user.login') }}"
                                                class="fs-14 fw-700 animate-underline-primary">{{ translate('Log In') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Side Image -->
                                <div class="col-lg-6 col-md-5 py-3 py-md-0">
                                    <img src="{{ uploaded_asset(get_setting('register_page_image')) }}" alt=""
                                        class="img-fit h-100">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
  {{--  @if (get_setting('google_recaptcha') == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script type="text/javascript">
        @if (get_setting('google_recaptcha') == 1)
            // making the CAPTCHA  a required field for form submission
            $(document).ready(function() {
                $("#reg-form").on("submit", function(evt) {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
                        //reCaptcha not verified
                        alert("please verify you are human!");
                        evt.preventDefault();
                        return false;
                    }
                    //captcha verified
                    //do the rest of your validations here
                    $("#reg-form").submit();
                });
            });
        @endif
    </script> --}}
    
    <script>
        function submitWithRecaptcha(e) {
            e.preventDefault(); // Prevent the form from submitting immediately
            
            const response = grecaptcha.getResponse(); // Get the reCAPTCHA response
            
            if (response.length === 0) {
                alert('Please complete the CAPTCHA.');
                return;
            }
    
            // Add the response as a hidden input field to the form
            const form = e.target.closest('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'recaptcha_response';
            input.value = response;
            form.appendChild(input);
            
            // Now submit the form
            form.submit();
        }
    </script>



    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            // Toggle the type attribute
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
    <script>
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmEyeIcon = document.getElementById('confirmEyeIcon');
            // Toggle the type attribute
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                confirmEyeIcon.classList.remove('fa-eye');
                confirmEyeIcon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                confirmEyeIcon.classList.remove('fa-eye-slash');
                confirmEyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endsection

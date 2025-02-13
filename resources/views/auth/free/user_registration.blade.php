@extends('auth.layouts.authentication')

@section('content')
<style>
    .login-buttons .btn {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
     padding: 12px;
       margin: 10px 0;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      color: white;
      cursor: pointer;
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

    /* -------------------------------------------- */
    .Continue-email {
        display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
     padding: 12px;
       margin: 10px 0;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      color: white;
      cursor: pointer;
    }
 
/* =------------------------------------------------- */
.Continue-phone{
    display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
     padding: 12px;
       margin: 10px 0;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      text-decoration: none;
      color: white;
      cursor: pointer;
}
/* ------------------- */
    .login-buttons {
      display: flex;
      flex-direction: column;
      
    }
    
    @media (max-width: 768px){
        .login-buttons .btn {
            width: 100%;
        }
    }

</style>
   <!-- aiz-main-wrapper -->
   <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white overflow-hidden" style="min-height:100vh;">
            <div class="row" style="min-height: 100vh;">
                <!-- Right Side -->
                <div class="col-md-6  col-lg-12 col-lg-5">
                    <div class="right-content">
                        <div class="row align-items-center justify-content-center justify-content-lg-center h-100">
                            <div class="col-lg-3 col-md-3 p-4 p-lg-5">
                                <!-- Site Icon -->
                                <div class="size-100px w-100 text-lg-center mb-2">
                                    <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="">
                                </div>
                                <!-- Titles -->
                                <div class="text-center ">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Create an account')}}</h1>
                                </div>
                                <!-- Register form -->
                                <div class="pt-3 pt-lg-4 bg-white">
                                    <div class="">
                                        <div class="login-buttons">
                                            <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-google">
                                                <img src="https://cdn4.iconfinder.com/data/icons/logos-brands-7/512/google_logo-google_icongoogle-512.png" alt="Google Logo">
                                                Continue with Google
                                            </a>
                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-facebook">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook Logo">
                                                Continue with Facebook
                                            </a>
                                            <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="btn btn-apple">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNw7QG9ltH125HUWoX0GoIi5_d3zGvmJc2zg&s" alt="Apple Logo">
                                                Continue with Apple
                                            </a>
                                        </div>
                                        <button class="btn btn-primary Continue-email" onclick="toggleForm()">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="24" height="20" viewBox="0 0 24 24"><path fill='white' d="M12 12.713l-11.985-9.713h23.97l-11.985 9.713zm0 2.574l-12-9.725v15.438h24v-15.438l-12 9.725z"/></svg>
                                             Signup with Gmail</button>

                                             <button class="btn btn-primary Continue-phone" onclick="toggleForm('phone')">
                                                <a href="https://iconscout.com/icons/phone" class="text-underline font-size-sm" target="_blank">Phone</a> by <a href="https://iconscout.com/contributors/kawalanicon" class="text-underline font-size-sm" target="_blank">Kawalan Studio</a>                                                Signup with Phone
                                            </button>

                                        <div id="registerFormContainer" style="display: none;">
                                            <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                                @csrf
                                                <!-- Name -->
                                                <div class="form-group">
                                                    <label for="name" class="fs-12 fw-700 text-soft-dark">{{ translate('Full Name') }}</label>
                                                    <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{ translate('Full Name') }}" name="name">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>                                        
                                        
                                                <!-- Email or Phone -->
                                                        @if (addon_is_activated('otp_system'))
                                                        <div class="form-group phone-form-group mb-1">
                                                            <label for="phone" class="fs-12 fw-700 text-soft-dark">{{ translate('Phone') }}</label>
                                                            <input type="tel" id="phone-code" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                                        </div>

                                                        <input type="hidden" name="country_code" value="">

                                                        <div class="form-group email-form-group mb-1 d-none">
                                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{ translate('Email') }}</label>
                                                            <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email" autocomplete="off">
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
                                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{ translate('Email') }}</label>
                                                            <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                                                            @if ($errors->has('email'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                        
                                                <!-- Password -->
                                                <div class="form-group mb-0">
                                                    <label for="password" class="fs-12 fw-700 text-soft-dark">{{ translate('Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ translate('Password') }}" name="password">
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

                                                <div class="form-group">
                                                    <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{ translate('Confirm Password') }}</label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control rounded-0" placeholder="{{ translate('Confirm Password') }}" name="password_confirmation">
                                                        <i class="password-toggle las la-2x la-eye"></i>
                                                    </div>
                                                </div>
                                        
                                                @if(get_setting('google_recaptcha') == 1)
                                                    <div class="form-group">
                                                        <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                                    </div>
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
                                                    <button type="submit" class="btn btn-primary btn-block fw-600 rounded-0">{{  translate('Create Account') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Social Login -->
                                        @if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1)
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
                                        @endif
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
          function toggleForm() {
        var formContainer = document.getElementById('registerFormContainer');
        var loginButtons = document.querySelector('.login-buttons');

        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
            loginButtons.style.display = 'none';
        } else {
            formContainer.style.display = 'none';
            loginButtons.style.display = 'block';
        }
    }

        @if(get_setting('google_recaptcha') == 1)
        $(document).ready(function(){
            $("#reg-form").on("submit", function(evt){
                var response = grecaptcha.getResponse();
                if(response.length == 0){
                    alert("Please verify you are human!");
                    evt.preventDefault();
                    return false;
                }
                $("#reg-form").submit();
            });
        });
        @endif
    </script>
@endsection

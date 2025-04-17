@extends('auth.layouts.authentication')


<style>
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

.login-btn{
    border-radius: 25px !important;
}

.password-toggle{
    right: 20px !important;
}
.form-control {
    background: #fff !important;
    box-shadow: unset !important;
    border: 1px solid #761adf !important;
}
.form-control:focus, .form-control:hover {
    background: #771be017 !important;
    border: 1px solid #cf517e !important;
    color: #d45577 !important;
}
</style>

@section('content')
    <!-- aiz-main-wrapper -->
    <div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
        <section class="bg-white overflow-hidden" style="min-height:100vh;">
            <div class="row" style="min-height: 100vh;">
                <!-- Right Side -->
                <div class="col-md-12">
                    <div class="right-content">
                        <div class="row align-items-center justify-content-center justify-content-lg-center h-100">
                            <div class="col-sm-7 col-md-6 col-lg-5 col-xl-4 p-4 p-lg-5">
                                <!-- Site Icon -->
                                <div class="text-center d-flex mb-5">
                                    <div class=" " style="max-width: 100px;
                                    width: 100%;
                                    height: 100%;
                                    max-height: 100px;
                                    margin: 0 auto;
                                    ">
                                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="w-100 h-100 " style="object-fit: contain;">
                                    </div>
                                </div>
                               
                                <!-- Titles -->
                                <div class="text-lg-center">
                                    <h1 class="fs-20 fs-md-24 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Welcome Back !')}}</h1>
                                    <h5 class="fs-14 fw-400 text-dark">{{ translate('Login To Your Seller Account')}}</h5>
                                </div>
                                <!-- Login form -->
                                <div class="pt-2 bg-white">
                                    <div class="">
                                        <form class="form-default" role="form" action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_type" value="seller">
                                            <div class="form-group">
                                                <label for="email" class="fs-16 fw-700 text-soft-dark mx-4">{{ translate('Email') }}</label>
                                                <input type="email" 
                                                       class="form-control custom-input {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="{{ translate('johndoe@example.com') }}" 
                                                       name="email" 
                                                       id="email" 
                                                       autocomplete="off">
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                                
                                            <!-- password -->
                                            <div class="form-group">
                                                <label for="password" class="fs-16 fw-700 text-soft-dark mx-4">{{ translate('Password') }}</label>
                                                <div class="position-relative">
                                                    <input type="password" 
                                                           class="form-control custom-input {{ $errors->has('password') ? 'is-invalid' : '' }}" 
                                                           placeholder="{{ translate('Password') }}" 
                                                           name="password" 
                                                           id="password">
                                                    <i class="password-toggle las la-2x la-eye"></i>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <!-- Remember Me -->
                                                <div class="col-6">
                                                    <label class="aiz-checkbox">
                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                        <span class="has-transition fs-12 fw-400 text-gray-dark hov-text-primary">{{  translate('Remember Me') }}</span>
                                                        <span class="aiz-square-check"></span>
                                                    </label>
                                                </div>
                                                <!-- Forgot password -->
                                                <div class="col-6 text-right">
                                                    <a href="{{ route('password.request') }}" class="text-reset fs-12 fw-400 text-gray-dark hov-text-primary"><u>{{ translate('Forgot password?')}}</u></a>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="mb-2 mt-2">
                                                <button type="submit" class="btn btn-primary btn-block fw-700 fs-16 Login-btn">{{  translate('Login') }}</button>
                                            </div>
                                        </form>

                                        <!-- DEMO MODE -->
                                        @if (env("DEMO_MODE") == "On")
                                            <div class="mb-4">
                                                <table class="table table-bordered mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td>{{ translate('Seller Account')}}</td>
                                                            <td>
                                                                <button class="btn btn-info btn-sm" onclick="autoFillSeller()">{{ translate('Copy credentials') }}</button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Register Now -->
                                    <p class="fs-12 text-gray mb-0">
                                        {{ translate('Dont have an account?')}}
                                    </p>
                                    <a href="{{ route('shops.create') }}" class="btn btn-secondary rounded-4 fw-700 w-100 mb-2  ">{{ translate('Register Now')}}</a>
                                    <!-- Go Back -->
                                    <a href="{{ url('/')}}" class="btn btn-light rounded-4 w-100" >
                                        <i class="las la-home fs-17 mr-1"></i>
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
        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
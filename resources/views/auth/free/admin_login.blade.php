
<style>
    /* Styling for the input fields */
.custom-input {
    border-radius: 25px; /* Border radius for rounded corners */
    border: 1px solid #ececec; /* Border color */
    background-color: #f9f9f9; /* Input background color */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Border shadow */
    padding: 20px; /* Padding inside the input */
    font-size: 14px; /* Font size */
    width: 100%; /* Full width */
    transition: all 0.3s ease; /* Smooth transition on focus */
    height: 50px; 
    outline: none; 
}

/* Focused state styling */
.custom-input:focus {
    border-color: #cacaca; /* Change border color on focus */
    background-color: #fff; /* Change background color on focus */
    box-shadow: 0 0 8px rgba(153, 155, 158, 0.4); /* Change shadow color on focus */
    outline: none; /* Remove default outline */
}

/* Styling for invalid inputs */
.custom-input.is-invalid {
    border-color: #e3342f; /* Red border for invalid input */
    background-color: #ffe5e5; /* Light red background for invalid input */
}

.Login-btn{
    border-radius: 25px;
}

.password-toggle{
    right: 20px !important;
}
</style>
<!-- aiz-main-wrapper -->
<div class="aiz-main-wrapper d-flex flex-column justify-content-center bg-white">
    <section class="bg-white overflow-hidden" style="min-height:100vh;">
        <div class="row justify-content-center align-items-center" style="min-height:100vh;">
            
            <!-- Right Side -->
            <div class="col-xxl-6 col-lg-5">
                <div class="right-content">
                    <div class="row align-items-center justify-content-center h-100">
                        <div class="col-xxl-6 p-4 p-lg-5">
                            <!-- Site Icon -->
                            <div class="mx-auto mx-lg-0 text-center">
                                <img src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="">
                            </div>
                            <!-- Titles -->
                            <div class="text-center text-lg-center">
                                <h1 class="fs-20 fs-md-20 fw-700 text-primary" style="text-transform: uppercase;">{{ translate('Welcome to') }} {{ env('APP_NAME') }}</h1>
                                <h5 class="fs-14 fw-400 text-dark">{{ translate('Login to your account')}}</h5>
                            </div>
                            <!-- Login form -->
                            <div class="pt-3 pt-lg-4 bg-white">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="user_type" value="customer">
                                        <!-- Email-->
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
                                        
                                            

                                        <!-- Password -->
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
                                                    <span class="has-transition fs-12 fw-400 text-dark hov-text-primary">{{  translate('Remember Me') }}</span>
                                                    <span class="aiz-square-check"></span>
                                                </label>
                                            </div>
                                            <!-- Forgot password -->
                                            <div class="col-6 text-right">
                                                <a href="{{ route('password.request') }}" class="text-reset fs-12 fw-400 text-dark hov-text-primary"><u>{{ translate('Forgot password?')}}</u></a>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="mb-4 mt-4">
                                            <button type="submit" class="btn btn-primary btn-block fw-700 fs-16 Login-btn">{{  translate('Login') }}</button>
                                        </div>
                                    </form>

                                    <!-- DEMO MODE -->
                                    @if (env("DEMO_MODE") == "On")
                                        <div class="mt-4">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>admin@example.com</td>
                                                        <td>123456</td>
                                                        <td class="text-center">
                                                            <button class="btn btn-primary btn-xs" onclick="autoFillAdmin()">{{ translate('Copy') }}</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

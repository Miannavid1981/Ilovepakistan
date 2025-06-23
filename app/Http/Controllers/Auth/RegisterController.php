<?php

namespace App\Http\Controllers\Auth;

use Cookie;
use Session;
use App\Models\Cart;
use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\BusinessSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\OTPVerificationController;
use App\Utility\EmailUtility;
use Cache;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => [
                Rule::when(get_setting('google_recaptcha') == 1, ['required', new Recaptcha()], ['sometimes'])
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        }
        else {
            if (addon_is_activated('otp_system')){
                $user = User::create([
                    'name' => $data['name'],
                    'phone' => '+'.$data['country_code'].$data['phone'],
                    'password' => Hash::make($data['password']),
                    'verification_code' => rand(100000, 999999)
                ]);

                $otpController = new OTPVerificationController;
                $otpController->send_code($user);
            }
        }
        
        if(session('temp_user_id') != null){
            if(!empty(auth()->user()) ){
                
                if(auth()->user()->user_type == 'customer'){
                    Cart::where('temp_user_id', session('temp_user_id'))
                    ->update(
                        [
                            'user_id' => auth()->user()->id,
                            'temp_user_id' => null
                        ]
                    );
                }
                else {
                    Cart::where('temp_user_id', session('temp_user_id'))->delete();
                }
                Session::forget('temp_user_id');
            }
        }

        if(Cookie::has('referral_code')){
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if($referred_by_user != null){
                $user->referred_by = $referred_by_user->id;
                $user->save();
            }
        }

        return $user;
    }

    public function register(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if(User::where('email', $request->email)->first() != null){
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        }
        elseif (User::where('phone', '+'.$request->country_code.$request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        if($user->email != null){
            if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
                $user->save();
                offerUserWelcomeCoupon();
                flash(translate('Registration successful.'))->success();
            }
            else {
                try {
                    EmailUtility::email_verification($user, 'customer');
                    flash(translate('Registration successful. Please verify your email.'))->success();
                } catch (\Throwable $e) {
                    dd($e);
                    $user->delete();
                    flash(translate('Registration failed. Please try again later.'))->error();
                }
            }

            // Account Opening Email to customer
            if ( $user != null && (get_email_template_data('registration_email_to_customer', 'status') == 1)) {
                try {
                    EmailUtility::customer_registration_email('registration_email_to_customer', $user, null);
                } catch (\Exception $e) {}
            }
        }

        // customer Account Opening Email to Admin
        if ( $user != null && (get_email_template_data('customer_reg_email_to_admin', 'status') == 1)) {
            try {
                EmailUtility::customer_registration_email('customer_reg_email_to_admin', $user, null);
            } catch (\Exception $e) {}
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        if ($user->email == null) {
            return redirect()->route('verification');
        }elseif(session('link') != null){
            return redirect(session('link'));
        }else {
            return redirect()->route('home');
        }
    }
    public function register_brand_partner(Request $request){


        return  view('auth.seller_register.brand_partner');
    }
    public function register_store_partner(Request $request){

        return  view('auth.seller_register.store_partner');
    }
    public function register_seller_partner(Request $request){

        return  view('auth.seller_register.seller_partner'); 
    }
    public function showOtpForm()
    {
        return view('auth.seller_register.otp_form');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $cachedOtp = Cache::get('otp_'.$request->session()->get('pending_user.email'));

        if ($request->otp == $cachedOtp) {
            $data = session('pending_user');

            // Now save user to DB
            $user = User::where('email', $data['email'])->where('user_type', 'seller')->first();
            // $user->password = Hash::make($data['password']);
            $user->email_verified_at = date('Y-m-d H:m:s');
            if ($user->shop) {
                $user->shop->verification_status = 1;
                $user->shop->save();
            }
            $user->verification_code = $request->otp;
            $user->save();


            // Account Opening Email to Seller
            if ((get_email_template_data('registration_email_to_seller', 'status') == 1)) {
                try {
                    EmailUtility::selelr_registration_email('registration_email_to_seller', $user, null);
                } catch (\Exception $e) {}
            }

            // Seller Account Opening Email to Admin
            if ((get_email_template_data('seller_reg_email_to_admin', 'status') == 1)) {
                try {
                    EmailUtility::selelr_registration_email('seller_reg_email_to_admin', $user, null);
                } catch (\Exception $e) {}
            }



            session()->forget('pending_user');
            Cache::forget('otp_'.$data['email']);

            // Optionally auto-login
            Auth::login($user);

            return redirect('/seller/dashboard')->with('success', 'Registration complete!');
        } else {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }
    }

}

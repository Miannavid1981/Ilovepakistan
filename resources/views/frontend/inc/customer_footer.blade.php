
<style>
    </style>
<footer class="footer text-light pt-5 pb-3" style="background-color: #000; line-height: 40px;">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-lg-2 col-md-6 mb-4 text-center text-md-start">
                @php

                $header_logo =  get_setting('header_logo');
                $logo_url = uploaded_asset(get_setting('header_logo'));
                $my_account_url =  route('profile');
                if( Auth::user() ) {
                    $my_account_url = Auth::user()->user_type == "staff" ? '/admin/profile/' : route('profile');
                }
                
                
            @endphp
                <a href="{{ url('/') }}">
                    @if ($header_logo != null)

                        <img src="{{ $logo_url }}" alt="{{ env('APP_NAME') }}" class="img-fluid">

                    @else

                        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"

                            class="mw-100 h-67px h-md-40px" height="67px">

                    @endif
                </a>
                <div class="d-flex justify-content-center justify-content-md-start" id="social_links">
                    <a href="https://www.facebook.com/bighouz/" target="_blank" class="me-3 text-light"><i class="fab fa-facebook-f fs-3"></i></a>
                    <a href="https://www.instagram.com/big_houz" target="_blank" class="me-3 text-light"><i class="fab fa-instagram fs-3"></i></a>
                    <a href="https://x.com/Big_houz" target="_blank" class="me-3 text-light"><i class="fab fa-twitter fs-3"></i></a>
                    <a href="https://www.youtube.com/{!! '@Big_houz' !!}" target="_blank" class="me-3 text-light"><i class="fab fa-youtube fs-3"></i></a>
                    <a href="https://www.pinterest.com/big_houz/" target="_blank" class="text-light"><i class="fab fa-pinterest fs-3"></i></a>
                </div>
                <ul class="list-unstyled">
                    <li class="text-light fs-6"><i class="fa fa-envelope"></i> <span>info@bighouz. </span></li>
                    <li class="text-light fs-6"><i class="fa fa-phone"></i> <span>+923333120595</span></li>
                    <li class="text-light fs-6"><i class="fa fa-location"></i>  <span>M-42-43, Zainab Towers. Link Road Model Town. Lahore 54700</span></li>

                    
                </ul>
                
            </div>
            <!-- Information Section -->
            <div class="col-12 col-lg-2 col-md-6 mb-4 text-center text-md-start">
                <h5 class="fs-20 fw-bold">Information</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Contact Us</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Career</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">My Account</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Order & Returns</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">FAQs</a></li>
                </ul>
            </div>
            <!-- Quick Shop Section -->
            <div class="col-12 col-lg-2 col-md-6 mb-4 text-center text-md-start">
                <h5 class="fs-20 fw-bold fw-bold">Quick Shop</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Women</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Men</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Clothes</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Accessories</a></li>
                    <li><a href="#" class="text-light fs-17 text-decoration-none">Blog</a></li>
                </ul>
            </div>
            <!-- Customer Services Section -->
            <div class="col-12 col-lg-2 col-md-6 mb-4 text-center text-md-start">
                <h5 class="fs-20 fw-bold">Customer Services</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('accept-poliy-page') }}" class="text-light fs-17 text-decoration-none">Acceptable Use Policy</a></li>
                    <li><a href="{{ route('cookie_policy') }}" class="text-light fs-17 text-decoration-none">Cookie Policy</a></li>
                    <li><a href="{{ route('user_license') }}" class="text-light fs-17 text-decoration-none">User License</a></li>
                    <li><a href="{{ route('disclaimer') }}" class="text-light fs-17 text-decoration-none">Disclaimer</a></li>
                    <li><a href="{{ route('privacy_policy') }}" class="text-light fs-17 text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
            <!-- Seller Zone Section -->
            <div class="col-12 col-lg-2 col-md-6 mb-4 text-center text-md-start">
                <h5 class="fs-20 fw-bold">Business Partner Zone</h5>
                <ul class="list-unstyled">
                    <li class="mb-1">
                        <p class="fs-17 text-light text-secondary mb-0">
                          
                            <a href="{{ route('shops.create') }}" class="fs-17 text-light">  Be our Partner</a>
                        </p>
                    </li>
                   
                    <li class="mb-1">
                        <a class="fs-17 text-light animate-underline-dark" href="{{ url('/seller/login') }}">Partner Login</a>
                    </li>
                   
                    <li class="mb-1">
                        <p class="fs-17 text-light text-secondary mb-0">
                            <a href="{{ route('shops.create') }}" class="fs-17 fw-700 bg-warning text-light rounded-2 px-3 py-1 ">Apply Now</a>
                        </p>
                    </li>
                </ul>
            </div>
            <!-- Newsletter Section -->
            <div class="col-lg-2 col-md-12 text-center text-md-start">
                <h5 class="fs-20 fw-bold">Newsletter</h5>
                <p class="fs-17">Sign up for our newsletter and get 10% off your first purchase</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="Enter your e-mail">
                    <button class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
               
            </div>
        </div>
    <div class="row mt-5">
    <!-- Images Section -->
    <div class="col-lg-6 order-1 order-md-2 text-center text-md-end">
        <span>
            <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN01dsw9V61Lbh0D1f9JG_!!6000000001320 fw-bold-2-tps-205-112.png" width="40px" alt="Visa">
            <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN01sXbha020agNJcLC4l_!!6000000006866-2-tps-148-112.png" width="40px" alt="Master">
            <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN010I5eGr1aDcQ82EcRH_!!6000000003296-2-tps-169-112.png" width="40px" alt="UnionPay">
            <img src="https://s.alicdn.com/@img/imgextra/i1/O1CN017IIzE71MpGLv2nxMd_!!6000000001483-2-tps-260-112.png" width="70px" alt="PayPal">
        </span>
    </div>

    <!-- Text Section -->
    <div class="col-lg-6 order-2 order-md-1 text-center text-md-start">
        <p class="mb-0 fs-17">©2025 Bighouz. All Rights Reserved.</p>
    </div>
   </div>

    </div>
</footer>
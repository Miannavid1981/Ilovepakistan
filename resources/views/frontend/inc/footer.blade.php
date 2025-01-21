<!-- footer Description -->

@if (get_setting('footer_title') != null || get_setting('footer_description') != null)

    <section class="bg-light border-top border-bottom mt-auto">

        <div class="container py-4">

            <h1 class="fs-18 fw-700 text-gray-dark mb-3">{{ get_setting('footer_title',null, $system_language->code) }}</h1>

            <p class="fs-13 text-gray-dark text-justify mb-0">

                {!! nl2br(get_setting('footer_description',null, $system_language->code)) !!}

            </p>

        </div>

    </section>

@endif



<!-- footer top Bar -->

<section class="bg-light border-top mt-auto d-none">

    <div class="container px-xs-0">

        <div class="row no-gutters border-left border-soft-light">

            <!-- Terms & conditions -->

            <div class="col-lg-3 col-6 policy-file">

                <a class="text-reset h-100  border-right border-bottom border-soft-light text-center p-2 p-md-4 d-block hov-ls-1" href="{{ route('terms') }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="26.004" height="32" viewBox="0 0 26.004 32">

                        <path id="Union_8" data-name="Union 8" d="M-14508,18932v-.01a6.01,6.01,0,0,1-5.975-5.492h-.021v-14h1v13.5h0a4.961,4.961,0,0,0,4.908,4.994h.091v0h14v1Zm17-4v-1a2,2,0,0,0,2-2h1a3,3,0,0,1-2.927,3Zm-16,0a3,3,0,0,1-3-3h1a2,2,0,0,0,2,2h16v1Zm18-3v-16.994h-4v-1h3.6l-5.6-5.6v3.6h-.01a2.01,2.01,0,0,0,2,2v1a3.009,3.009,0,0,1-3-3h.01v-4h.6l0,0H-14507a2,2,0,0,0-2,2v22h-1v-22a3,3,0,0,1,3-3v0h12l0,0,7,7-.01.01V18925Zm-16-4.992v-1h12v1Zm0-4.006v-1h12v1Zm0-4v-1h12v1Z" transform="translate(14513.998 -18900.002)" fill="#919199"/>

                    </svg>

                    <h4 class="text-dark fs-14 fw-700 mt-3">{{ translate('Terms & conditions') }}</h4>

                </a>

            </div>

            

            <!-- Return Policy -->

            <div class="col-lg-3 col-6 policy-file">

                <a class="text-reset h-100  border-right border-bottom border-soft-light text-center p-2 p-md-4 d-block hov-ls-1" href="{{ route('returnpolicy') }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32.001" height="23.971" viewBox="0 0 32.001 23.971">

                        <path id="Union_7" data-name="Union 7" d="M-14490,18922.967a6.972,6.972,0,0,0,4.949-2.051,6.944,6.944,0,0,0,2.052-4.943,7.008,7.008,0,0,0-7-7v0h-22.1l7.295,7.295-.707.707-7.779-7.779-.708-.707.708-.7,7.774-7.779.712.707-7.261,7.258H-14490v0a8.01,8.01,0,0,1,8,8,8.008,8.008,0,0,1-8,8Z" transform="translate(14514.001 -18900)" fill="#919199"/>

                    </svg>

                    <h4 class="text-dark fs-14 fw-700 mt-3">{{ translate('Return Policy') }}</h4>

                </a>

            </div>



            <!-- Support Policy -->

            <div class="col-lg-3 col-6 policy-file">

                <a class="text-reset h-100  border-right border-bottom border-soft-light text-center p-2 p-md-4 d-block hov-ls-1" href="{{ route('supportpolicy') }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32.002" height="32.002" viewBox="0 0 32.002 32.002">

                        <g id="Group_24198" data-name="Group 24198" transform="translate(-1113.999 -2398)">

                        <path id="Subtraction_14" data-name="Subtraction 14" d="M-14508,18916h0l-1,0a12.911,12.911,0,0,1,3.806-9.187A12.916,12.916,0,0,1-14496,18903a12.912,12.912,0,0,1,9.193,3.811A12.9,12.9,0,0,1-14483,18916l-1,0a11.918,11.918,0,0,0-3.516-8.484A11.919,11.919,0,0,0-14496,18904a11.921,11.921,0,0,0-8.486,3.516A11.913,11.913,0,0,0-14508,18916Z" transform="translate(15626 -16505)" fill="#919199"/>

                        <path id="Subtraction_15" data-name="Subtraction 15" d="M-14510,18912h-1a3,3,0,0,1-3-3v-6a3,3,0,0,1,3-3h1a2,2,0,0,1,2,2v8A2,2,0,0,1-14510,18912Zm-1-11a2,2,0,0,0-2,2v6a2,2,0,0,0,2,2h1a1,1,0,0,0,1-1v-8a1,1,0,0,0-1-1Z" transform="translate(15628 -16489)" fill="#919199"/>

                        <path id="Subtraction_19" data-name="Subtraction 19" d="M4,12H3A3,3,0,0,1,0,9V3A3,3,0,0,1,3,0H4A2,2,0,0,1,6,2v8A2,2,0,0,1,4,12ZM3,1A2,2,0,0,0,1,3V9a2,2,0,0,0,2,2H4a1,1,0,0,0,1-1V2A1,1,0,0,0,4,1Z" transform="translate(1146.002 2423) rotate(180)" fill="#919199"/>

                        <path id="Subtraction_17" data-name="Subtraction 17" d="M-14512,18908a2,2,0,0,1-2-2v-4a2,2,0,0,1,2-2,2,2,0,0,1,2,2v4A2,2,0,0,1-14512,18908Zm0-7a1,1,0,0,0-1,1v4a1,1,0,0,0,1,1,1,1,0,0,0,1-1v-4A1,1,0,0,0-14512,18901Z" transform="translate(20034 16940.002) rotate(90)" fill="#919199"/>

                        <rect id="Rectangle_18418" data-name="Rectangle 18418" width="1" height="4.001" transform="translate(1137.502 2427.502) rotate(90)" fill="#919199"/>

                        <path id="Intersection_1" data-name="Intersection 1" d="M-14508.5,18910a4.508,4.508,0,0,0,4.5-4.5h1a5.508,5.508,0,0,1-5.5,5.5Z" transform="translate(15646.004 -16482.5)" fill="#919199"/>

                        </g>

                    </svg>

                    <h4 class="text-dark fs-14 fw-700 mt-3">{{ translate('Support Policy') }}</h4>

                </a>

            </div>



            <!-- Privacy Policy -->

            <div class="col-lg-3 col-6 policy-file">

                <a class="text-reset h-100 border-right border-bottom border-soft-light text-center p-2 p-md-4 d-block hov-ls-1" href="{{ route('privacypolicy') }}">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">

                        <g id="Group_24236" data-name="Group 24236" transform="translate(-1454.002 -2430.002)">

                        <path id="Subtraction_11" data-name="Subtraction 11" d="M-14498,18932a15.894,15.894,0,0,1-11.312-4.687A15.909,15.909,0,0,1-14514,18916a15.884,15.884,0,0,1,4.685-11.309A15.9,15.9,0,0,1-14498,18900a15.909,15.909,0,0,1,11.316,4.688A15.885,15.885,0,0,1-14482,18916a15.9,15.9,0,0,1-4.687,11.316A15.909,15.909,0,0,1-14498,18932Zm0-31a14.9,14.9,0,0,0-10.605,4.393A14.9,14.9,0,0,0-14513,18916a14.9,14.9,0,0,0,4.395,10.607A14.9,14.9,0,0,0-14498,18931a14.9,14.9,0,0,0,10.607-4.393A14.9,14.9,0,0,0-14483,18916a14.9,14.9,0,0,0-4.393-10.607A14.9,14.9,0,0,0-14498,18901Z" transform="translate(15968 -16470)" fill="#919199"/>

                        <g id="Group_24196" data-name="Group 24196" transform="translate(0 -1)">

                            <rect id="Rectangle_18406" data-name="Rectangle 18406" width="2" height="10" transform="translate(1469 2440)" fill="#919199"/>

                            <rect id="Rectangle_18407" data-name="Rectangle 18407" width="2" height="2" transform="translate(1469 2452)" fill="#919199"/>

                        </g>

                        </g>

                    </svg>

                    <h4 class="text-dark fs-14 fw-700 mt-3">{{ translate('Privacy Policy') }}</h4>

                </a>

            </div>

        </div>

    </div>

</section>



<!-- footer subscription & icons -->

<!-- <section class="py-3 text-light footer-widget border-bottom" style="border-color: #3d3d46 !important; background-color: #212129 !important;">

    <div class="container">

        <div class="mt-3 mb-4">

            <a href="{{ route('home') }}" class="d-block">

                @if(get_setting('footer_logo') != null)

                    <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset(get_setting('footer_logo')) }}" alt="{{ env('APP_NAME') }}" height="44" style="height: 44px;">

                @else

                    <img class="lazyload" src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" height="44" style="height: 44px;">

                @endif

            </a>

        </div>

        <div class="row">

            <div class="col-xl-6 col-lg-7">

                <div class="mb-4 text-secondary text-justify">

                    {!! get_setting('about_us_description',null,App::getLocale()) !!}

                </div>

                <h5 class="fs-14 fw-700 text-soft-light mt-1 mb-3">{{ translate('Subscribe to our newsletter for regular updates about Offers, Coupons & more') }}</h5>

                <div class="mb-3">

                    <form method="POST" action="{{ route('subscribers.store') }}">

                        @csrf

                        <div class="row gutters-10">

                            <div class="col-8">

                                <input type="email" class="form-control border-secondary rounded-0 text-white w-100 bg-transparent" placeholder="{{ translate('Your Email Address') }}" name="email" required>

                            </div>

                            <div class="col-4">

                                <button type="submit" class="btn btn-primary rounded-0 w-100">{{ translate('Subscribe') }}</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section> -->



@php

    $col_values = ((get_setting('vendor_system_activation') == 1) || addon_is_activated('delivery_boy')) ? "col-lg-3 col-md-6 col-sm-6" : "col-md-4 col-sm-6";

@endphp

<footer class="footer text-dark pt-5 pb-3" style="background-color: #E8E8E8; line-height: 40px;">
    <div class="container">
    <div class="row">
    <!-- About Section -->
    <div class="col-lg-2 col-md-6 col-sm-12 mb-4">
      <img src="https://allaaddin.com/public/images/1j+ojFVDOMkX9Wytexe43D6kh.png" width="100px"  alt="">
        <ul class="list-unstyled">
            <li class="fs-15"><strong>Mail:</strong> hi.avitex@gmail.com</li>
            <li class="fs-15"><strong>Phone:</strong> 1-333-345-6868</li>
            <li class="fs-15"><strong>Address:</strong> 549 Oak St. Crystal Lake, IL 60014</li>
        </ul>
    </div>
    <!-- Information and Quick Shop in one row -->
    <div class="col-6 col-lg-2 col-md-6 col-sm-6 mb-4">
        <h5>Information</h5>
        <ul class="list-unstyled">
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Contact Us</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Career</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">My Account</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Order & Returns</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">FAQs</a></li>
        </ul>
    </div>
    <div class="col-6 col-lg-2 col-md-6 col-sm-6 mb-4">
        <h5>Quick Shop</h5>
        <ul class="list-unstyled">
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Women</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Men</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Clothes</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Accessories</a></li>
            <li><a href="#" class="text-dark fs-15 text-decoration-none">Blog</a></li>
        </ul>
    </div>
            <div class="col-6 col-lg-2 col-md-6 col-sm-6 mb-4">
                <h5>Customer Services</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-dark fs-15 text-decoration-none">Orders FAQs</a></li>
                    <li><a href="#" class="text-dark fs-15 text-decoration-none">Shipping</a></li>
                    <li><a href="#" class="text-dark fs-15 text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-dark fs-15 text-decoration-none">Return & Refund</a></li>
                </ul>
            </div>
    <!-- Seller Zone -->
    <div class="col-6 col-lg-2 col-md-6 col-sm-6 mb-4">
        <div class="text-sm-left">
            <h5>Seller Zone</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <p class="fs-15 text-dark text-secondary mb-0">
                        Become A Seller
                        <a href="#" class="fs-15 fw-700 text-warning ml-2">
                            Apply Now
                        </a>
                    </p>
                </li>
                <li class="mb-2">
                    <a class="fs-15 text-dark animate-underline-dark" href="#">
                        Login to Seller Panel
                    </a>
                </li>
                <li class="mb-2">
                    <a class="fs-15 text-dark animate-underline-dark" target="_blank" href="#">
                        Download Seller App
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Newsletter Section -->
    <div class="col-lg-2 col-md-12">
        <h5>Newsletter</h5>
        <p class="fs-15">Sign up for our newsletter and get 10% off your first purchase</p>
        <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Enter your e-mail">
            <button class="btn btn-secondary" type="button"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div class="d-flex">
            <a href="#" class="me-3 text-dark"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-instagram"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-twitter"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-dark"><i class="fab fa-pinterest"></i></a>
        </div>
    </div>
</div>

        <div class="row mt-5">
            <div class="col-lg-6">
                <p class="mb-0 fs-15">©2025 Bighouz. All Rights Reserved.</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <span class="me-3 fs-15">English</span>
                <span class="me-3 fs-15">USD</span>
                <span>
                    <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN01dsw9V61Lbh0D1f9JG_!!6000000001318-2-tps-205-112.png" width="40px" alt="Visa">
                    <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN01sXbha020agNJcLC4l_!!6000000006866-2-tps-148-112.png" width="40px" alt="Master">
                    <img src="https://s.alicdn.com/@img/imgextra/i4/O1CN010I5eGr1aDcQ82EcRH_!!6000000003296-2-tps-169-112.png" width="40px" alt="unionpay">
                    <img src="https://s.alicdn.com/@img/imgextra/i1/O1CN017IIzE71MpGLv2nxMd_!!6000000001483-2-tps-260-112.png" width="70px" alt="PayPal">
                </span>
            </div>
        </div>
    </div>
</footer>







<!-- FOOTER -->

<!-- <footer class="pt-3 pb-7 pb-xl-3 bg-black text-soft-light">

    <div class="container">

        <div class="row align-items-center py-3">


            <div class="col-lg-6 order-1 order-lg-0">

                <div class="text-center text-lg-left fs-14" current-verison="{{get_setting("current_version")}}">

                    {!! get_setting('frontend_copyright_text', null, App::getLocale()) !!}

                </div>

            </div>

            <div class="col-lg-6 mb-4 mb-lg-0">

                <div class="text-center text-lg-right">

                    <ul class="list-inline mb-0">

                        @if ( get_setting('payment_method_images') !=  null )

                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)

                                <li class="list-inline-item mr-3">

                                    <img src="{{ uploaded_asset($value) }}" height="20" class="mw-100 h-auto" style="max-height: 20px" alt="{{ translate('payment_method') }}">

                                </li>

                            @endforeach

                        @endif

                    </ul>

                </div>

            </div>

        </div>

    </div>

</footer> -->



<!-- Mobile bottom nav -->

<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom border-top border-sm-bottom border-sm-left border-sm-right mx-auto mb-sm-2 " style="background-color: rgb(255 255 255 / 90%)!important;">

    <div class="row align-items-center gutters-5">

        <!-- Home -->

        <div class="col">

            <a href="{{ route('home') }}" class="text-secondary d-block text-center pb-2 pt-3 {{ areActiveRoutes(['home'],'svg-active')}}">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">

                    <g id="Group_24768" data-name="Group 24768" transform="translate(3495.144 -602)">

                      <path id="Path_2916" data-name="Path 2916" d="M15.3,5.4,9.561.481A2,2,0,0,0,8.26,0H7.74a2,2,0,0,0-1.3.481L.7,5.4A2,2,0,0,0,0,6.92V14a2,2,0,0,0,2,2H14a2,2,0,0,0,2-2V6.92A2,2,0,0,0,15.3,5.4M10,15H6V9A1,1,0,0,1,7,8H9a1,1,0,0,1,1,1Zm5-1a1,1,0,0,1-1,1H11V9A2,2,0,0,0,9,7H7A2,2,0,0,0,5,9v6H2a1,1,0,0,1-1-1V6.92a1,1,0,0,1,.349-.76l5.74-4.92A1,1,0,0,1,7.74,1h.52a1,1,0,0,1,.651.24l5.74,4.92A1,1,0,0,1,15,6.92Z" transform="translate(-3495.144 602)" fill="#b5b5bf"/>

                    </g>

                </svg>

                <span class="d-block mt-1 fs-10 fw-600 text-reset {{ areActiveRoutes(['home'],'text-primary')}}">{{ translate('Home') }}</span>

            </a>

        </div>



        <!-- Categories -->

        <div class="col">

            <a href="{{ route('categories.all') }}" class="text-secondary d-block text-center pb-2 pt-3 {{ areActiveRoutes(['categories.all'],'svg-active')}}">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">

                    <g id="Group_25497" data-name="Group 25497" transform="translate(3373.432 -602)">

                      <path id="Path_2917" data-name="Path 2917" d="M126.713,0h-5V5a2,2,0,0,0,2,2h3a2,2,0,0,0,2-2V2a2,2,0,0,0-2-2m1,5a1,1,0,0,1-1,1h-3a1,1,0,0,1-1-1V1h4a1,1,0,0,1,1,1Z" transform="translate(-3495.144 602)" fill="#91919c"/>

                      <path id="Path_2918" data-name="Path 2918" d="M144.713,18h-3a2,2,0,0,0-2,2v3a2,2,0,0,0,2,2h5V20a2,2,0,0,0-2-2m1,6h-4a1,1,0,0,1-1-1V20a1,1,0,0,1,1-1h3a1,1,0,0,1,1,1Z" transform="translate(-3504.144 593)" fill="#91919c"/>

                      <path id="Path_2919" data-name="Path 2919" d="M143.213,0a3.5,3.5,0,1,0,3.5,3.5,3.5,3.5,0,0,0-3.5-3.5m0,6a2.5,2.5,0,1,1,2.5-2.5,2.5,2.5,0,0,1-2.5,2.5" transform="translate(-3504.144 602)" fill="#91919c"/>

                      <path id="Path_2920" data-name="Path 2920" d="M125.213,18a3.5,3.5,0,1,0,3.5,3.5,3.5,3.5,0,0,0-3.5-3.5m0,6a2.5,2.5,0,1,1,2.5-2.5,2.5,2.5,0,0,1-2.5,2.5" transform="translate(-3495.144 593)" fill="#91919c"/>

                    </g>

                </svg>

                <span class="d-block mt-1 fs-10 fw-600 text-reset {{ areActiveRoutes(['categories.all'],'text-primary')}}">{{ translate('Categories') }}</span>

            </a>

        </div>

        <!-- Cart -->

        @php

            $count = count(get_user_cart());

        @endphp

        <div class="col-auto">

            <a href="{{ route('cart') }}" class="text-secondary d-block text-center pb-2 pt-3 px-3 {{ areActiveRoutes(['cart'],'svg-active')}}">

                <span class="d-inline-block position-relative px-2">

                    <svg id="Group_25499" data-name="Group 25499" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="16.001" height="16" viewBox="0 0 16.001 16">

                        <defs>

                        <clipPath id="clip-pathw">

                            <rect id="Rectangle_1383" data-name="Rectangle 1383" width="16" height="16" fill="#91919c"/>

                        </clipPath>

                        </defs>

                        <g id="Group_8095" data-name="Group 8095" transform="translate(0 0)" clip-path="url(#clip-pathw)">

                        <path id="Path_2926" data-name="Path 2926" d="M8,24a2,2,0,1,0,2,2,2,2,0,0,0-2-2m0,3a1,1,0,1,1,1-1,1,1,0,0,1-1,1" transform="translate(-3 -11.999)" fill="#91919c"/>

                        <path id="Path_2927" data-name="Path 2927" d="M24,24a2,2,0,1,0,2,2,2,2,0,0,0-2-2m0,3a1,1,0,1,1,1-1,1,1,0,0,1-1,1" transform="translate(-10.999 -11.999)" fill="#91919c"/>

                        <path id="Path_2928" data-name="Path 2928" d="M15.923,3.975A1.5,1.5,0,0,0,14.5,2h-9a.5.5,0,1,0,0,1h9a.507.507,0,0,1,.129.017.5.5,0,0,1,.355.612l-1.581,6a.5.5,0,0,1-.483.372H5.456a.5.5,0,0,1-.489-.392L3.1,1.176A1.5,1.5,0,0,0,1.632,0H.5a.5.5,0,1,0,0,1H1.544a.5.5,0,0,1,.489.392L3.9,9.826A1.5,1.5,0,0,0,5.368,11h7.551a1.5,1.5,0,0,0,1.423-1.026Z" transform="translate(0 -0.001)" fill="#91919c"/>

                        </g>

                    </svg>

                    @if($count > 0)

                        <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right" style="right: 5px;top: -2px;"></span>

                    @endif

                </span>

                <span class="d-block mt-1 fs-10 fw-600 text-reset {{ areActiveRoutes(['cart'],'text-primary')}}">

                    {{ translate('Cart') }}

                    (<span class="cart-count">{{$count}}</span>)

                </span>

            </a>

        </div>



        <!-- Notifications -->

        <div class="col">

          

        </div>



        <!-- Account -->

        <div class="col">

            @if (Auth::check())

                @if(isAdmin())

                    <a href="{{ route('admin.dashboard') }}" class="text-secondary d-block text-center pb-2 pt-3">

                        <span class="d-block mx-auto">

                            @if($user->avatar_original != null)

                                <img src="{{ $user_avatar }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @else

                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @endif

                        </span>

                        <span class="d-block mt-1 fs-10 fw-600 text-reset">{{ translate('My Account') }}</span>

                    </a>

                @elseif(isSeller())

                    <a href="{{ route('dashboard') }}" class="text-secondary d-block text-center pb-2 pt-3">

                        <span class="d-block mx-auto">

                            @if($user->avatar_original != null)

                                <img src="{{ $user_avatar }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @else

                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @endif

                        </span>

                        <span class="d-block mt-1 fs-10 fw-600 text-reset">{{ translate('My Account') }}</span>

                    </a>

                @else

                    <a href="javascript:void(0)" class="text-secondary d-block text-center pb-2 pt-3 mobile-side-nav-thumb" data-toggle="class-toggle" data-backdrop="static" data-target=".aiz-mobile-side-nav">

                        <span class="d-block mx-auto">

                            @if($user->avatar_original != null)

                                <img src="{{ $user_avatar }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @else

                                <img src="{{ static_asset('assets/img/avatar-place.png') }}" alt="{{ translate('avatar') }}" class="rounded-circle size-20px">

                            @endif

                        </span>

                        <span class="d-block mt-1 fs-10 fw-600 text-reset">{{ translate('My Account') }}</span>

                    </a>

                @endif

            @else

                <a href="{{ route('user.login') }}" class="text-secondary d-block text-center pb-2 pt-3">

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">

                        <g id="Group_8094" data-name="Group 8094" transform="translate(3176 -602)">

                          <path id="Path_2924" data-name="Path 2924" d="M331.144,0a4,4,0,1,0,4,4,4,4,0,0,0-4-4m0,7a3,3,0,1,1,3-3,3,3,0,0,1-3,3" transform="translate(-3499.144 602)" fill="#b5b5bf"/>

                          <path id="Path_2925" data-name="Path 2925" d="M332.144,20h-10a3,3,0,0,0,0,6h10a3,3,0,0,0,0-6m0,5h-10a2,2,0,0,1,0-4h10a2,2,0,0,1,0,4" transform="translate(-3495.144 592)" fill="#b5b5bf"/>

                        </g>

                    </svg>

                    <span class="d-block mt-1 fs-10 fw-600 text-reset">{{ translate('My Account') }}</span>

                </a>

            @endif

        </div>



    </div>

</div>



<!-- User Side nav -->

@if (Auth::check() && !isAdmin())

    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">

        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-backdrop="static" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>

        <div class="collapse-sidebar bg-white">

            @include('frontend.inc.user_side_nav')

        </div>

    </div>

@endif

<script>

    $(document).ready(function () {

  // Simulate loading time

  setTimeout(function () {

    $('#preloader').fadeOut('slow', function () {

      $(this).remove(); // Remove preloader from DOM

    });

   

  }, 2000); // Adjust the time as needed

});

</script>
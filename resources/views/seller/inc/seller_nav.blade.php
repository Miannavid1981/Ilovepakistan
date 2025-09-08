<div class="aiz-topbar px-15px px-lg-25px d-flex align-items-stretch justify-content-between">
    <div class="d-flex">
        <div class="aiz-topbar-nav-toggler d-flex align-items-center justify-content-start mr-2 mr-md-3 ml-0" data-toggle="aiz-mobile-nav">
            <button class="aiz-mobile-toggler">
                <span></span>
            </button>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-stretch flex-grow-xl-1">
        <div class="d-flex justify-content-around align-items-center align-items-stretch">
            <div class="d-flex justify-content-around align-items-center align-items-stretch">
                <div class="aiz-topbar-item">
                    <div class="d-flex align-items-center">

                      
                        <a class="d-flex gap-2 align-items-center gap-2 bg-primary text-white px-4 py-1 fw-600 fs-15 " style="height: 40px;
border-radius: 40px;
font-size: 13px !important;
padding: 10px !important;
white-space: nowrap;" href="{{ route('shop.visit', auth()->user()->shop->slug) }}" target="_blank" title="{{ translate('Browse Website') }}">
                            Visit store&nbsp;&nbsp;
                            <img src="https://images.vexels.com/media/users/3/158194/isolated/preview/11507ef5615c554fe88fc22c86768501-simple-earth-icon.png" class="" style="width: 20px !important;
height: auto !important;
aspect-ratio: 1/1;">
                        </a>
                        <!-- QR Code Button -->
                        <button type="button" 
                                class="btn btn-light p-0 ml-2" 
                                style="height: 40px; width: 40px; border-radius: 10px;" 
                                data-toggle="modal" 
                                data-target="#qrcode_modal">
                            <img src="https://static.vecteezy.com/system/resources/previews/046/930/670/non_2x/qr-code-icon-simple-qr-code-illustration-barcode-scan-abstract-design-isolated-vector.jpg" 
                                class="w-100 h-100" 
                                style="object-fit: cover; border-radius: 50%;">
                        </button>

                       
                    </div>
                </div>
            </div>
            @if (addon_is_activated('pos_system'))
                <div class="d-flex justify-content-around align-items-center align-items-stretch ml-3">
                    <div class="aiz-topbar-item">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-icon btn-circle btn-light" href="{{ route('poin-of-sales.seller_index') }}" target="_blank" title="{{ translate('POS') }}">
                                <i class="las la-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="d-flex justify-content-around align-items-center align-items-stretch">

             <!-- Notifications -->
             <div class="aiz-topbar-item mr-3 d-none">
                <div class="align-items-stretch d-flex  dropdown">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon p-0 d-flex justify-content-center align-items-center">
                            <span class="d-flex align-items-center position-relative">
                                <i class="las la-bell fs-24"></i>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                @endif
                            </span>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xl py-0">
                        <div class="notifications">
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-dark active" data-toggle="tab" data-type="order" href="javascript:void(0);"
                                        data-target="#orders-notifications" role="tab" id="orders-tab">{{ translate('Orders') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller" href="javascript:void(0);"
                                        data-target="#sellers-notifications" role="tab" id="sellers-tab">{{ translate('Products') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" data-toggle="tab" data-type="seller" href="javascript:void(0);"
                                        data-target="#payouts-notifications" role="tab" id="sellers-tab">{{ translate('Payouts') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content c-scrollbar-light overflow-auto" style="height: 75vh; max-height: 400px; overflow-y: auto;">
                                <div class="tab-pane active" id="orders-notifications" role="tabpanel">
                                    <x-unread_notification :notifications="auth()->user()->unreadNotifications()->where('type', 'App\Notifications\OrderNotification')->take(20)->get()" />
                                </div>
                                <div class="tab-pane" id="sellers-notifications" role="tabpanel">
                                    <x-unread_notification :notifications="auth()->user()->unreadNotifications()->where('type', 'like', '%shop%')->take(20)->get()" />
                                </div>
                                <div class="tab-pane" id="payouts-notifications" role="tabpanel">
                                    <x-unread_notification :notifications="auth()->user()->unreadNotifications()->where('type', 'App\Notifications\PayoutNotification')->take(20)->get()" />
                                </div>
                            </div>
                        </div>

                        <div class="text-center border-top">
                            <a href="{{ route('seller.all-notification') }}" class="text-reset d-block py-2">
                                {{ translate('View All Notifications') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- language --}}
            @php
                if(Session::has('locale')){
                    $locale = Session::get('locale', Config::get('app.locale'));
                }
                else{
                    $locale = env('DEFAULT_LANGUAGE');
                }
            @endphp
            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown " id="lang-change">
                    <a class="dropdown-toggle no-arrow" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="btn btn-icon">
                            <img src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" height="11">
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-xs">

                        @foreach (\App\Models\Language::where('status', 1)->get() as $key => $language)
                            <li>
                                <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language->code) active @endif">
                                    <img src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-2">
                                    <span class="language">{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="aiz-topbar-item ml-2">
                <div class="align-items-stretch d-flex dropdown">
                    <a class="dropdown-toggle no-arrow text-dark" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="avatar avatar-sm mr-md-2">
                                <img
                                    src="{{ uploaded_asset(Auth::user()->avatar_original) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';"
                                >
                            </span>
                            <span class="d-none d-md-block">
                                <span class="d-block fw-500 my-1">{{Auth::user()->name}}</span>
                                @if (auth()->user()->shop->verification_status == 1)
                                    <span class="bg-success text-white px-2 py-1" style="border-radius: 20px">
                                        @if(auth()->user()->seller_type == 'brand_partner')
                                        Approved
                                        @elseif (auth()->user()->seller_type == 'seller_partner')
                                        Verified
                                        @elseif (auth()->user()->seller_type == 'store_partner')
                                        Authorized
                                        @endif
                                    </span>
                                @else 
                                    <span class="bg-warning text-white px-2 py-1 " style="border-radius: 20px">
                                        Pending
                                    </span>
                                @endif
                                {{-- <span class="d-block small opacity-60 my-1 text-capitalize">{{Auth::user()->user_type}}</span> --}}
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-md">
                        <a href="{{ route('seller.profile.index') }}" class="dropdown-item">
                            <i class="las la-user-circle"></i>
                            <span>{{translate('Profile')}}</span>
                        </a>

                        <a href="{{ route('logout')}}" class="dropdown-item">
                            <i class="las la-sign-out-alt"></i>
                            <span>{{translate('Logout')}}</span>
                        </a>
                    </div>
                </div>
            </div><!-- .aiz-topbar-item -->
        </div>
    </div>
</div><!-- .aiz-topbar -->


<!-- QR Code Modal -->
<div class="modal fade" id="qrcode_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="qrcode-content">
            <div class="modal-header">
                <h5 class="modal-title">Share Store Info</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <div id="capture" class="py-4">
                    <div style="aspect-ratio: 1 / 1;
                                width: 200px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                margin: 0 auto; position: relative;">
                        @php
                            $qrCode = base64_encode(QrCode::format('png')->size(200)->generate(route('shop.visit', auth()->user()->shop->slug)));
                        @endphp
                        <img src="data:image/png;base64,{{ $qrCode }}" style="width: 100%; height: 100%; aspect-ratio: 1 / 1;" />
                        <div style="   
                            position: absolute;
                            top: 0;
                            /* background-color: #fde6ff; */
                            border-radius: 50%;
                            /* width: 50px; */
                            /* height: 50px; */
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            /* border: 1px solid #8722d2; */
                            left: 5revert-layer;
                            left: 0;
                            right: 0;
                            bottom: 0;
                        ">
                            <img src="{{ uploaded_asset(get_setting('site_icon')) }}" class="ms-2" style="width: 26px; height: auto; background-color: #fff; border-radius: 50%;;" alt="Discover">
                        </div>
                    </div>
                    <p>{{ auth()->user()->shop->name }}</p>
                </div>
                <button id="downloadBtn" class="btn btn-primary mt-3" style="   margin: 0 auto; padding: 10px 20px !important;;">Download as Image</button>
            </div>
        </div>
    </div>
</div>

<!-- Add html2canvas from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById("downloadBtn").addEventListener("click", function() {
        let div = document.getElementById("capture");

        html2canvas(div).then(function(canvas) {
            // Convert to image
            let link = document.createElement("a");
            link.download = "screenshot.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        });
    });
</script>

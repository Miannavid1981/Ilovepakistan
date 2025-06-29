 
 @extends('frontend.layouts.app')

@section('content')

    <style>
        .seller_type_card {
            width: 100%;
            background: #fff !important
        }
        .seller_type_card:has(input:checked){
            background: var(--primary);
            color: #fff;
            border: unset !important;
            transition: all .2s ease-in-out;
        }
        input, textarea, select {
            border: 1px solid #888 !important;
            border-radius: 8px !important
        }

       
    </style>
   <!-- aiz-main-wrapper -->
   {{-- <div class="aiz-main-wrapper  d-flex flex-column justify-content-center bg-white"> --}}
    <form id="reg-form" class="form-default row justify-content-center my-4" role="form" action="{{ route('shops.store') }}" enctype="multipart/form-data" method="POST">
        @csrf

        <input type="hidden" name="seller_type" id="seller_type" value="brand_partner" >
            
        <div class="container ">
            <div class="row my-5">
            
                <div class="col-4">

                </div>
                <div class="col-4">
                    <h3 align="center">
                        Register as Brand Partner
                    </h3>
                    <p align="center">Follow our terms and conditions
                    </p>
                    <br>
                    <br>
                    <ul class="nav nav-tabs d-none" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1"><h6>Store Info</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab2"><h6>Contact Info</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab3"><h6>Company Info</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab4"><h6>Personal Info</h6></a>
                        </li>
                        
                    </ul>
                
                    <div class="tab-content mt-3">
                        <div id="tab1" class="tab-pane fade show active">
                            <h4 align="center">
                                Store Information
                            </h4>
                            <br>
                            <div class="form-group">
                                <label>Brand Name</label>
                                <input type="text" class="form-control {{ $errors->has('shop_name') ? ' is-invalid' : '' }}" value="{{ old('shop_name') }}" placeholder="{{  translate('Brand Name') }}" name="shop_name">
                                @if ($errors->has('shop_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shop_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Brand Logo</label>
                                <input type="file" name="brand_logo" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label>Store Address</label>
                                <select name="city" class="form-control">
                                    <option value="">Select City</option>
                                    @php
                                        $cities = \App\Models\City::where('state_id', 2728)->where('status', 1)->get();
                                    @endphp
                                    @foreach( $cities as $city)
                                        <option value="{{ strtolower(str_replace(' ', '-', $city->name )) }}"> {{ $city->name }} </option>
                                    @endforeach
                                  
                                    <!-- Add other cities -->
                                </select>
                            </div>
                            
                            <div class="form-group">
                              
                                <select name="area" class="form-control">
                                    <option value="">Select Area</option>
                                    <!-- Area options should be dynamically filtered by city -->
                                </select>
                            </div>

                            <div class="form-group">
                                
                                <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" placeholder="{{  translate('Store Address') }}" name="address">
                                @if ($errors->has('address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end">

                                <button class="btn btn-primary next-tab" type="button">Next</button>

                            </div>
                            
                        </div>
                        <div id="tab2" class="tab-pane fade">
                            <h4 align="center">
                                Business Information
                            </h4>
                            <br>
                            <!-- Company Name -->
                            <div class="form-group">
                                <input type="text" name="company_name" class="form-control" placeholder="Company Name">
                            </div>

                            <!-- Company Type -->
                            <div class="form-group">
                                <select name="company_type" class="form-control">
                                    <option value="">Select Company Type</option>
                                    <option value="sole_proprietorship">Sole Proprietorship</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="private_limited">Private Limited</option>
                                </select>
                            </div>

                            <!-- Legal Documents Upload -->
                            <div class="form-group">
                                <label>Upload Legal Documents</label>
                                <input type="file" name="legal_documents" class="form-control">
                            </div>

                            <!-- Business Type -->
                            <div class="form-group">
                                <select name="business_type" class="form-control">
                                    <option value="">Select Business Type</option>
                                    <option value="manufacturer">Manufacturer</option>
                                    <option value="importer">Importer</option>
                                    <option value="exporter">Exporter</option>
                                    <option value="distributor">Distributor</option>
                                    <option value="wholesaler">Wholesaler</option>
                                </select>
                            </div>

                            <!-- Sales Tax Number -->
                            <div class="form-group">
                                <input type="text" name="sales_tax_number" class="form-control" placeholder="Sales Tax Registration Number">
                            </div>

                            <!-- NTN -->
                            <div class="form-group">
                                <input type="text" name="business_ntn" class="form-control" placeholder="Business NTN Number">
                            </div>

                            <!-- Business Categories (Same code you already have) -->
                            <label class="form-label">Choose Category Preferences (Upto 3)</label>
                            <div class="row">
                                @foreach(\App\Models\Category::where('level', 0)->get() as $category)
                                    <div class="col-md-3 col-sm-6 mt-2">
                                        <div class="category_pref_box border rounded-2 p-2 d-flex flex-column align-items-center justify-content-center">
                                            <img src="{{ uploaded_asset($category->icon) }}" class="rounded-circle bg-white p-1 border" style="width: 35px;">
                                            <label class="form-label text-center">{{ $category->name }}</label>
                                            <input type="checkbox" name="category_pref_ids[]" value="{{ $category->id }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between">
                                <button class="btn btn-secondary prev-tab" type="button">Previous</button>
                                <button class="btn btn-primary next-tab" type="button">Next</button>
                            </div>
                        </div>
                        <div id="tab3" class="tab-pane fade">
                            <h4 align="center">{{ translate('Contact Info')}}</h4>
                            <br>
                            <!-- Designation -->
                            <div class="form-group">
                                <input type="text" name="designation" class="form-control" placeholder="Designation">
                            </div>

                            <!-- Authorized Person Mobile -->
                            <div class="form-group">
                                <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Authorized Person Mobile No">
                            </div>

                            <!-- WhatsApp -->
                            <div class="form-group">
                                <input type="text" name="whatsapp_number" class="form-control" placeholder="WhatsApp Number">
                            </div>


                            
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-secondary prev-tab" type="button">Previous</button>
                                <button class="btn btn-primary next-tab" type="button">Next</button>
                            </div>
                        </div>
                        <div id="tab4" class="tab-pane fade">

                            <h4 align="center">{{ translate('Personal Info')}}</h4>
                            <br>
                            <!-- Full Name -->
                           <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <select class="form-control" name="gender_prefix">
                                        
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <!-- Name -->
                                    <div class="form-group">
                                                    
                                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name" >
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Profile Image</label>
                                <input type="file" name="avatar_original" class="form-control" required>
                            </div>
                           
                            <div class="form-group position-relative">
                                <input type="text" name="username" id="username-input" class="form-control" placeholder="Username" required>
                                <div id="username-feedback" class="mt-1 small fw-bold" style="display: none;"></div>
                            </div>

                            <div class="form-group">
                                <input 
                                    type="email" 
                                    id="email-input"
                                    name="email" 
                                    class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" 
                                    value="{{ old('email') }}" 
                                    placeholder="{{ translate('Email') }}" 
                                    required
                                >
                                
                                {{-- Laravel validation error --}}
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                {{-- Live validation feedback --}}
                                <div id="email-feedback" class="mt-1" style="display: none;"></div>
                            </div>

                            <!-- password -->
                            <div class="form-group mb-0">
                                
                                <div class="position-relative">
                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" required>
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
                                
                                <div class="position-relative">
                                    <input type="password" class="form-control " placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" required >
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


                            <!-- Submit Button -->
                            <div class="mb-4 mt-4">
                                <button type="submit" class="btn btn-primary btn-block fw-600 fs-20">{{  translate('Register Now') }}</button>
                            </div>  

                        </div>
                    </div>

                </div>
                <div class="col-4">

                </div>
            </div>
        
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll(".nav-tabs .nav-link");
            const nextButtons = document.querySelectorAll(".next-tab");
            const prevButtons = document.querySelectorAll(".prev-tab");
    
            nextButtons.forEach((button, index) => {
                button.addEventListener("click", function () {
                    tabs[index + 1].click();
                });
            });
    
            prevButtons.forEach((button, index) => {
                button.addEventListener("click", function () {
                    tabs[index].click();
                });
            });
        });
    </script>
    
<script type="text/javascript">
        
    $(document).ready(function(){

         let timer;
        const $input = $('#username-input');
        const $feedback = $('#username-feedback');

        $input.on('keyup', function () {
            clearTimeout(timer);
            const username = $input.val();
            $("#submit_button").hide();
            if (username.length < 3) {
                $feedback.hide();
                $input.removeClass('is-valid is-invalid');
                return;
            }

            timer = setTimeout(function () {
                $.ajax({
                    url: '{{ route("check.username") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: username
                    },
                    success: function (response) {
                        if (response.available) {
                            $input.removeClass('is-invalid').addClass('is-valid');
                            $feedback
                                .removeClass('text-danger bg-danger-subtle')
                                .addClass('text-success bg-success-subtle border border-success px-2 py-1 rounded')
                                .text('✅ Username is available')
                                .show();
                            $("#submit_button").show();
                        } else {
                            $input.removeClass('is-valid').addClass('is-invalid');
                            $feedback
                                .removeClass('text-success bg-success-subtle')
                                .addClass('text-danger bg-danger-subtle border border-danger px-2 py-1 rounded')
                                .text('❌ Username is already taken')
                                .show();
                            $("#submit_button").hide();
                        }
                    },
                    error: function () {
                        $input.removeClass('is-valid').addClass('is-invalid');
                        $feedback
                            .removeClass('text-success bg-success-subtle')
                            .addClass('text-danger bg-danger-subtle border border-danger px-2 py-1 rounded')
                            .text('⚠️ Server error. Please try again.')
                            .show();
                        $("#submit_button").hide();
                    }
                });
            }, 400); // debounce
        });

        let emailTimer;
        const $emailInput = $('#email-input');
        const $emailFeedback = $('#email-feedback');

        $emailInput.on('keyup', function () {
            clearTimeout(emailTimer);
            const email = $emailInput.val().trim();
            $("#submit_button").hide();

            // Basic email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $emailInput.removeClass('is-valid').addClass('is-invalid');
                $emailFeedback
                    .removeClass('text-success bg-success-subtle')
                    .addClass('text-danger bg-danger-subtle border border-danger px-2 py-1 rounded')
                    .text('❌ Invalid email format')
                    .show();
                return;
            }

            emailTimer = setTimeout(function () {
                $.ajax({
                    url: '{{ route("check.email") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function (response) {
                        if (response.available) {
                            $emailInput.removeClass('is-invalid').addClass('is-valid');
                            $emailFeedback
                                .removeClass('text-danger bg-danger-subtle')
                                .addClass('text-success bg-success-subtle border border-success px-2 py-1 rounded')
                                .text('✅ Email is available')
                                .show();
                            $("#submit_button").show();
                        } else {
                            $emailInput.removeClass('is-valid').addClass('is-invalid');
                            $emailFeedback
                                .removeClass('text-success bg-success-subtle')
                                .addClass('text-danger bg-danger-subtle border border-danger px-2 py-1 rounded')
                                .text('❌ Email is already registered')
                                .show();
                            $("#submit_button").hide();
                        }
                    },
                    error: function () {
                        $emailInput.removeClass('is-valid').addClass('is-invalid');
                        $emailFeedback
                            .removeClass('text-success bg-success-subtle')
                            .addClass('text-danger bg-danger-subtle border border-danger px-2 py-1 rounded')
                            .text('⚠️ Server error. Please try again.')
                            .show();
                        $("#submit_button").hide();
                    }
                });
            }, 400);
        });
        $('input[name="category_pref_ids[]"]').on('change', function () {
            let selected = $('input[name="category_pref_ids[]"]:checked');

            if (selected.length >= 3) {
                $('input[name="category_pref_ids[]"]').not(':checked').prop('disabled', true);
            } else {
                $('input[name="category_pref_ids[]"]').prop('disabled', false);
            }
        });

        // function recaptchaVerified(){
        //     $("#reg-form").submit();
        // }
        // function form_submit(){
        //     if ($('#quick_newslatter_recaptcha').valid()) {
        //         grecaptcha.execute();
        //     }
        // }

        // $(document).on('click', '#registration_button', form_submit );


        $(".seller_type_card").click(function(){
            $('[name="seller_type"]').val($(this).data('value'))
        })
        $("#company_type").change(function(){
            var val = $(this).val();

            $("#partnership_ntn").attr('placeholder', 'NTN of '+val);

        })
        $("#store_partner").click(function(){

            $(this).parent().parent().hide()


            $("#personal_info").show();
            $("#seller_form").show();   

        });


        $("#verified_seller").click(function(){

            $(this).parent().parent().hide()
            $("#contact_info").show();
            $("#company_details").show();

            $("#personal_info").show();
            $("#shop_info").show();
            $("#seller_form").show();

            $("#personal_info input").each(function(){
                $(this).attr("required", "required")
            })
            $("#shop_info input").each(function(){
                $(this).attr("required", "required")
            })
            $("#contact_info input").each(function(){
                $(this).attr("required", "required")
            })
            $("#company_details input").each(function(){
                $(this).attr("required", "required")
            })
            $("#seller_form input").each(function(){
                $(this).attr("required", "required")
            })


        });
        
        $("#brand_partner").click(function(){

            $(this).parent().parent().hide()
            // $("#contact_info").show();
            // $("#company_details").show();

            $("#personal_info").show();
            $("#shop_info").show();
            $("#seller_form").show();

            $("#personal_info input").each(function(){
                $(this).attr("required", "required")
            })

       
            $("#shop_info input").each(function(){
                $(this).attr("required", "required")
            })

        });

    });

   




</script>
  


@endsection

@section('script')
    @if(get_setting('google_recaptcha') == 1)
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif

<script>
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
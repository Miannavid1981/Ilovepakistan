@extends('auth.layouts.authentication')

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
   <div class="aiz-main-wrapper  d-flex flex-column justify-content-center bg-white">
        
        <section class="bg-white  overflow-hidden" style="min-height:100vh;">
            <div class="row gap-2  align-items-center justify-content-start ">
                <div class="bg-dark w-100">
                    <div class="container ">
                        <div class="row align-items-center gap-0">
                            <div class="col-2"> 
                      
                                <img style="width: 100%; max-width: 120px" src="{{ uploaded_asset(get_setting('site_icon')) }}" alt="{{ translate('Site Icon')}}" class="">
                                
                            </div>
                            <div class="col-7"> 
                              
                                
                                <p class="fs-17 mb-0 fw-600 text-white"> Register as Partner</p>
                            </div>
                            <div class="col-3"> 
                              
                                
                                <a href="{{ route('seller.login') }}" class="btn btn-primary btn-sm"> <i class="fa fa-user"></i> Partner login</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="container mt-3">
                    <p class="fs-17 mb-0 fw-600"> Terms & Conditions</p>
                    <div class="d-flex justify-content-center align-items-center flex-column mx-auto mx-lg-0">
                    
                    
                       
                        <p  class="fs-13 fw-300   m-0">
                            Sellers must provide accurate and complete information during registration, including business details and contact information. All accounts are subject to verification, and we reserve the right to approve or reject applications at our discretion. By registering, sellers agree to comply with our terms, policies, and applicable laws.
                        </p>
                    </div>

                </div>
                <div class="container mt-4">
                    <div class="row justify-content-center">
                      
                            <div class="col-lg-3 col-md-4 col-4">
                                                        
                                <button id="store_partner" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
                                    <img src="https://www.mindmatrix.net/images/co-selling-and-co-marketing/co-selling-and-co-marketing.png" class="w-100"  width="200">
                                    <h5 class="fw-600 mt-3">Store Partner</h5>
                                
                                    <ul class="list-unstyled">
                                        <li class=""> Zero Investment </li>
                                        <li class="">  </li>
                                    </ul> 
                                    
                                    <div class="btn btn-primary mt-2">Apply Now</div>
                                </button>
                            </div>
                            <div class="col-lg-3 col-md-4 col-4">
                            
                                <button id="verified_seller" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
                                    <img src="https://www.mindmatrix.net/images/co-selling-and-co-marketing/co-selling-and-co-marketing.png" class="w-100"  width="200">
                                    <h5 class="fw-600 mt-3">Verified Seller</h5>
                                   
                                   
                                    <div class="btn btn-primary mt-2">Apply Now</div>
                                </button>
                            </div>
                            <div class="col-lg-3 col-md-4 col-4">
                            
                                <button id="brand_partner" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
                                    <img src="https://www.mindmatrix.net/images/co-selling-and-co-marketing/co-selling-and-co-marketing.png" class="w-100"  width="200">
                                    <h5 class="fw-600 mt-3">Brand Partner</h5>
                                   
                                   
                                    <div class="btn btn-primary mt-2">Apply Now</div>
                                </button>
                            </div>
                        
                    </div>
                
                </div>
               
                <!-- Right Side -->
                <div class="container">
                    <div class="row align-items-center justify-content-center justify-content-lg-start " id="seller_form" style="display: none">
                        <div class="col-12">
                            <!-- Site Icon -->
                            <form id="reg-form" class="form-default row justify-content-center mt-4" role="form" action="{{ route('shops.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf

                                <div class="col-md-6" id="personal_info" style="display: none">
                                
                                    
                                        <div class="fs-15 fw-600 pb-2">{{ translate('Personal Info')}}</div>
                                        <!-- Name -->
                                        <div class="form-group">
                                            
                                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name" required>
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
        
                                        <div class="form-group">
                                            
                                            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" required>
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
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
                                                <input type="password" class="form-control " placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" required>
                                                <i class="password-toggle las la-2x la-eye"></i>
                                            </div>
                                        </div>
        
        
                                        
        
                                    
                                
                                </div>



                                <div class="col-md-6" id="shop_info" style="display: none">
                                    <div class="fs-15 fw-600 pb-2">{{ translate('Store Information')}}</div>
                                        
                                    <div class="form-group">
                                        
                                        <input type="text" class="form-control {{ $errors->has('shop_name') ? ' is-invalid' : '' }}" value="{{ old('shop_name') }}" placeholder="{{  translate('Store Name') }}" name="shop_name">
                                        @if ($errors->has('shop_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('shop_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
    
                                    <div class="form-group">
                                       
                                        <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" placeholder="{{  translate('Address') }}" name="address">
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6" id="contact_info" style="display: none">
                                    <div class="fs-15 fw-600 pb-2">{{ translate('Contact Info')}}</div>
                                    <div class="mb-3">
                                       
                                        <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Designation" required>
                                    </div>
                                    <div class="mb-3">
                                       
                                        <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Authorized Person Mobile" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        
                                        <input type="text" name="authorized_person_cnic_no" class="form-control" placeholder="Whatsapp Number" required>
                                    </div>

                                   
                                    

                                    <div class="mb-3">
                                        
                                        <input type="text" name="authorized_person_cnic_no" class="form-control" placeholder="Authorized Person CNIC No" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">CNIC Front</label>
                                        <input type="file" name="authorized_person_cnic_front" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">CNIC Back</label>
                                        <input type="file" name="authorized_person_cnic_back" class="form-control" required>
                                    </div>
                                   

                                    <div class="mb-3">
                                        <label class="form-label">Registered Office Address</label>
                                        <textarea name="registered_office_address" class="form-control" required></textarea>
                                    </div>


                                </div>
                                <div class="col-md-6" id="company_details" style="display: none">
                                    <div class="fs-15 fw-600 pb-2">{{ translate('Company Details')}}</div>
                                    <div class="mb-3">
                                        <label class="form-label">Company Type</label>
                                        <select class="form-control" id="company_type">
                                            <option value=""> - Select - </option>
                                            <option value="Sole Proprietership "> Sole Proprietership </option>
                                            <option value="Partnership"> Partnership </option>
                                            <option value="Private Limited"> Private Limited</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Upload Legal Documents</label>
                                        <input type="file" name="partnership_deed" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Business Type</label>
                                        <select class="form-control" id="business_type">
                                            <option value=""> - Select - </option>
                                            <option value="Manufacturer"> Manufacturer</option>
                                            <option value="Importer"> Importer </option>
                                            <option value="Wholeseller"> Wholeseller</option>
                                            <option value="Distributor"> Distributor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Number of Employees</label>
                                        <select class="form-control" id="business_type">
                                            <option value=""> - Select - </option>
                                            <option value=""> 1-20</option>
                                            <option value=""> 20-50 </option>
                                            <option value=""> 50-100</option>
                                            <option value=""> 100-500</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Annual Tenure</label>
                                        <select class="form-control" id="business_type">
                                            <option value=""> - Select - </option>
                                            <option value="">PKR 500,000 - 1,000,000</option>
                                            <option value="">PKR 5,000,000 - 10,000,000</option>
                                            <option value="">PKR 50,000,000 - 100,000,000</option>
                                            <option value="">PKR 100,000,000 or above</option>
                                        </select>
                                    </div>

                                  


                                    <div class="mb-3">
                                        
                                        <input type="text" placeholder="Sales Tax Registration Number" name="sales_tax_registration_number" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        
                                        <input type="text" name="partnership_ntn" id="partnership_ntn" placeholder="NTN of Partnership" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Copy of Cheque</label>
                                        <input type="file" name="cheque_copy" class="form-control" required>
                                    </div>

                                   
                                    <div class="mb-3">
                                        <label class="form-label">Authority Letter</label>
                                        <input type="file" name="authority_letter" class="form-control" required>
                                    </div>
                                 

                                    
                                  

                                </div>



                                <div class="col-12">

                                    <div class="row justify-content-center">
                                        <div class="col-md-6">

                                             <!-- Recaptcha -->
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
                                        <!-- Submit Button -->
                                        <div class="mb-4 mt-4">
                                            <button type="submit" class="btn btn-primary btn-block fw-600 fs-20">{{  translate('Register Now') }}</button>
                                        </div>  

                                        </div>
                                    </div>

                                
                                   
                                </div>
                            </form>
                          
                            {{-- <!-- Register form -->
                            <div class="pt-3 pt-lg-4 bg-white">
                                <div class="">
                                   
                                </div>
                                <!-- Log In -->
                                <p class="fs-12 text-gray mb-0">
                                    {{ translate('Already have an account?')}}
                                    <a href="{{ route('seller.login') }}" class="ml-2 fs-14 fw-700 animate-underline-primary">{{ translate('Log In')}}</a>
                                </p>
                                <!-- Go Back -->
                                <a href="{{ url()->previous() }}" class="mt-3 fs-14 fw-700 d-flex align-items-center text-primary" style="max-width: fit-content;">
                                    <i class="las la-arrow-left fs-20 mr-1"></i>
                                    {{ translate('Back to Previous Page')}}
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
        
    $(document).ready(function(){
        
    
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
            $("#shop_info input").each(function(){
                $(this).attr("required", "required")
            })
            $("#seller_form").show();

        });
        
        $("#brand_partner").click(function(){

            $(this).parent().parent().hide()
            $("#contact_info").show();
            $("#company_details").show();

            $("#personal_info").show();
            $("#shop_info").show();
            $("#seller_form").show();

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
                var response = grecaptcha.getResponse();
                if(response.length == 0)
                {
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

    </script>
   
@endsection
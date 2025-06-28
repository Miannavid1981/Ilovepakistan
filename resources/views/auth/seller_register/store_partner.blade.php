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
        .category_pref_box{
            position: relative
        }
        .category_pref_box input {
            position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0;
        }

        .category_pref_box:has(input:checked) {
            border: 1px solid var(--primary) !important;
            background: var(--primary);
            color: #fff

        }
       
    </style>
   <!-- aiz-main-wrapper -->
   {{-- <div class="aiz-main-wrapper  d-flex flex-column justify-content-center bg-white"> --}}
    <form id="reg-form" class="form-default row justify-content-center my-4" role="form" action="{{ route('shops.store') }}" enctype="multipart/form-data" method="POST">
        @csrf

        <input type="hidden" name="seller_type" id="seller_type" value="store_partner" >
            
        <div class="container ">
            <div class="row my-5">
            
                <div class="col-4">

                </div>
                <div class="col-4">
                    <h3 align="center">
                        Register as Store Partner
                    </h3>
                    <p align="center">Follow our terms and conditions
                    </p>
                    <br>
                    <br>
                    <ul class="nav nav-tabs d-none" id="myTabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab1"><h6>Store Information</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab2"><h6>Business Details</h6></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab3"><h6>Contact Info</h6></a>
                        </li>
                        {{-- 
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab3"><h6>Company Info</h6></a>
                        </li> --}}
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
                                
                                <input type="text" class="form-control {{ $errors->has('shop_name') ? ' is-invalid' : '' }}" value="{{ old('shop_name') }}" placeholder="{{  translate('Store Name') }}" name="shop_name">
                                @if ($errors->has('shop_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('shop_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Store Address</label>
                                <select class="form-control" id="city" name="city">
                                    <option value="">Select City </option>
                                    @php
                                        $cities = \App\Models\City::where('state_id', 2728)->get();
                                    @endphp
                                    @foreach( $cities as $city)
                                        <option value="{{ strtolower(str_replace(' ', '-', $city->name )) }}"> {{ $city->name }} </option>
                                    @endforeach
                                  
                                </select>
                            </div>
                            <div class="form-group">
                               
                                <select name="store_area" class="form-control">
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

                            <div class="form-group">
                                <label class="form-label">Profession Type

                                </label>
                                <select class="form-control" name="profession_type">
                                
                              
                                    <option value="shopkeeper">Shopkeeper</option>
                                    <option value="individual">Individual</option>
                                    
                                </select>
                            </div>
                            
                            <label class="form-label">Choose Category Preferences (Upto 3)</label>
                            <div class="row">
                                @foreach(\App\Models\Category::where('level', 0)->get() as $category)
                                    <div class="col-md-3 col-sm-6 mt-2">
                                        <div class="category_pref_box h-100 w-100 border rounded-2 p-2 d-flex flex-column align-items-center justify-content-center">
                                            <img src="{{uploaded_asset($category->icon)}}" class="bg-white p-1 rounded-circle border-1 border" style="width: 35px;height: auto;aspect-ratio: 1 / 1;" >
                                            <label class="form-label text-center">{{ $category->name }}</label>
                                            <input type="checkbox" class="form-check" name="category_pref_ids[]" value="{{ $category->id }}">
                                            
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
                            <h4 align="center">
                                Contact Information
                            </h4>
                            <br>
                            {{-- <div class="mb-3">
                                        
                                <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Designation" >
                            </div> --}}
                            <div class="mb-3">
                            
                                <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Authorized Person Mobile" >
                            </div>
                            
                            <div class="mb-3">
                                
                                <input type="text" name="whatsapp_number" class="form-control" placeholder="Whatsapp Number" >
                            </div>

                            {{-- <div class="mb-3">
                                <input type="text" name="authorized_person_cnic_no" class="form-control" placeholder="Authorized Person CNIC No" >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CNIC Front</label>
                                <input type="file" name="authorized_person_cnic_front" class="form-control" >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">CNIC Back</label>
                                <input type="file" name="authorized_person_cnic_back" class="form-control" >
                            </div> --}}
                        
                            <div class="mb-3">
                                <label class="form-label">Registered Office/Home Address</label>
                                <textarea name="registered_office_address" class="form-control" ></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-secondary prev-tab" type="button">Previous</button>
                                <button class="btn btn-primary next-tab" type="button">Next</button>
                            </div>
                        </div>

                        {{--
                        <div id="tab3" class="tab-pane fade">
                            <h4 align="center">{{ translate('Company Details')}}</h4>
                            <br>
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
                                <input type="file" name="partnership_deed" class="form-control">
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
                                
                                <input type="text" placeholder="Sales Tax Registration Number" name="sales_tax_registration_number" class="form-control" >
                            </div>
                            <div class="mb-3">
                                
                                <input type="text" name="partnership_ntn" id="partnership_ntn" placeholder="NTN of Partnership" class="form-control" >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Copy of Cheque</label>
                                <input type="file" name="cheque_copy" class="form-control" >
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label">Authority Letter</label>
                                <input type="file" name="authority_letter" class="form-control" >
                            </div>
                            

                            
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-secondary prev-tab" type="button">Previous</button>
                                <button class="btn btn-primary next-tab" type="button">Next</button>
                            </div>
                        </div> --}}
                        <div id="tab4" class="tab-pane fade">

                            <h4 align="center">{{ translate('Personal Info')}}</h4>
                            <br>
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
                                <input type="file" name="avatar_original" class="form-control" >
                            </div>
                           
                            <div class="form-group">
                                 <input type="text" name="username" class="form-control" placeholder="Username">
                             </div>
                            <div class="form-group">
                                
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!-- password -->
                            <div class="form-group mb-0">
                                
                                <div class="position-relative">
                                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" >
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
                                    <input type="password" class="form-control " placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" >
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
{{-- </div> --}}
        {{-- <section class="bg-white  overflow-hidden" style="min-height:100vh;">
            <div class="row gap-2  align-items-center justify-content-start ">
         
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
                                                        
                                <button data-value="store_partner" id="store_partner" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
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
                            
                                <button data-value="verified_seller" id="verified_seller" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
                                    <img src="https://www.mindmatrix.net/images/co-selling-and-co-marketing/co-selling-and-co-marketing.png" class="w-100"  width="200">
                                    <h5 class="fw-600 mt-3">Verified Seller</h5>
                                   
                                   
                                    <div class="btn btn-primary mt-2">Apply Now</div>
                                </button>
                            </div>
                            <div class="col-lg-3 col-md-4 col-4">
                                <button data-value="brand_partner" id="brand_partner" type="button" class="seller_type_card border-dark rounded-2 px-2 pb-3 pt-0 text-center shadow-sm border rounded cursor-pointer">
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
                          

                                <div class="col-md-6" id="personal_info" style="display: none">
                                
                                    
                                        <div class="fs-15 fw-600 pb-2">{{ translate('Personal Info')}}</div>
                                        <!-- Name -->
                                        <div class="form-group">
                                            
                                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name" >
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
        
                                        <div class="form-group">
                                            
                                            <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email" >
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
        
                                        <!-- password -->
                                        <div class="form-group mb-0">
                                            
                                            <div class="position-relative">
                                                <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password" >
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
                                                <input type="password" class="form-control " placeholder="{{  translate('Confirm Password') }}" name="password_confirmation" >
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
                                       
                                        <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Designation" >
                                    </div>
                                    <div class="mb-3">
                                       
                                        <input type="text" name="authorized_person_mobile" class="form-control" placeholder="Authorized Person Mobile" >
                                    </div>
                                    
                                    <div class="mb-3">
                                        
                                        <input type="text" name="authorized_person_cnic_no" class="form-control" placeholder="Whatsapp Number" >
                                    </div>

                                   
                                    

                                    <div class="mb-3">
                                        
                                        <input type="text" name="authorized_person_cnic_no" class="form-control" placeholder="Authorized Person CNIC No" >
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">CNIC Front</label>
                                        <input type="file" name="authorized_person_cnic_front" class="form-control" >
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">CNIC Back</label>
                                        <input type="file" name="authorized_person_cnic_back" class="form-control" >
                                    </div>
                                   

                                    <div class="mb-3">
                                        <label class="form-label">Registered Office Address</label>
                                        <textarea name="registered_office_address" class="form-control" ></textarea>
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
                                        <input type="file" name="partnership_deed" class="form-control">
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
                                        
                                        <input type="text" placeholder="Sales Tax Registration Number" name="sales_tax_registration_number" class="form-control" >
                                    </div>
                                    <div class="mb-3">
                                        
                                        <input type="text" name="partnership_ntn" id="partnership_ntn" placeholder="NTN of Partnership" class="form-control" >
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Copy of Cheque</label>
                                        <input type="file" name="cheque_copy" class="form-control" >
                                    </div>

                                   
                                    <div class="mb-3">
                                        <label class="form-label">Authority Letter</label>
                                        <input type="file" name="authority_letter" class="form-control" >
                                    </div>
                                 

                                    
                                  

                                </div>



                                <div class="col-12">

                                    <div class="row justify-content-center">
                                        <div class="col-md-6">

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
                            </form>
                          
                            <!-- Register form -->
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
    {{-- </div> --}}


     {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
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

        $('input[name="username"]').on('keyup', function () {
            clearTimeout(timer);
            const username = $(this).val();
            const $input = $(this);
            
            if (username.length < 3) {
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
                        } else {
                            $input.removeClass('is-valid').addClass('is-invalid');
                        }
                    },
                    error: function () {
                        $input.removeClass('is-valid').addClass('is-invalid');
                    }
                });
            }, 500); // delay for debounce
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
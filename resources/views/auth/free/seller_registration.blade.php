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

                
        .pricing-container {
            display: flex;
            justify-content: center;
            gap: 10px
        }

        .pricing-card {
            background: white;
            padding: 20px;
            width: 280px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            border-bottom: 4px solid blue;
            transition: transform 0.3s ease-in-out;
        }
        .pricing-card-popular{
            background: white;
        
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            border-bottom: 4px solid blue;
            transition: transform 0.3s ease-in-out;
        }

        .pricingcard-p{
            padding: 20px;
            width: 280px;
        }
        .popular {
            border-bottom: 4px solid green;
            transform: scale(1.05);
            z-index: 10; /* Ensure it stays above other cards */
            position: relative; /* Required for z-index to work */
        }


        .popular-badge {
            background: green;
            color: white;
            padding: 11px 11px;
            font-size: 14px;
        }

        h3 {
            color: #333;
            font-size: 20px;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin: 10px 0;
        }

        p {
            color: #666;
            font-size: 14px;
        }

        .signup-btn {
            background: rgb(12, 12, 247);
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 10px 0;
        }

        .signup-btn-1 {
            background: rgb(47, 167, 47);
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 10px 0;
        }
        .signup-btn-2 {
            background: rgb(139, 36, 139);
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            margin: 10px 0;
        }
        .signup-btn:hover {
            background: darkblue;
        }


        .note {
            font-size: 12px;
            color: #888;
        }

        ul {
            text-align: left;
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
            font-size: 14px;
        }

        .list-icons li i{
            color: blue;
        }

        .list-icons-1 li i {
            color: rgb(47, 167, 47);
        }
        .list-icons-2 li i {
            color: rgb(139, 36, 139);
        }
    </style>
   <!-- aiz-main-wrapper -->
   <div class="aiz-main-wrapper  d-flex flex-column justify-content-center bg-white">

            
        <div class="pricing-container">
            <!-- 2SELL Card -->
            <div class="pricing-card">
                <h3>Store Partner</h3>
                <p>Easy and simple way to sell globally</p>
                <p>per successful sale</p>
                <a class="signup-btn" href="{{ route('register.store_partner') }}">Apply Now</a>
                <p class="note">No credit card required.<br>You’ll only pay when you start selling.</p>
                <h4>WHAT YOU GET</h4>
                <ul class="list-icons">
                    <li><i class="fa fa-check"></i> Sell Instantly in 200 countries</li>
                    <li><i class="fa fa-check"></i> Integrate quickly with 120+ carts</li>
                    <li><i class="fa fa-check"></i> Scale up for international growth</li>
                    <li><i class="fa fa-check"></i> Sell any type of product</li>
                    <li><i class="fa fa-check"></i> Access to recurring billing</li>
                </ul>
            </div>

            <!-- 2SUBSCRIBE Card (Most Popular) -->
            <div class="pricing-card-popular popular">
            
                    <div class="popular-badge">Most Popular</div>
                    <div class="pricingcard-p">
                    <h3>Verified Seller</h3>
                    <p>Develop & Boost your subscription business</p>
                    <p>per successful sale</p>
                    <a class="signup-btn-1" href="{{ route('register.seller_partner') }}">Apply Now</a>
                    <p class="note">No credit card required.<br>You’ll only pay when you start selling.</p>
                    <h4>WHAT YOU GET</h4>
                    <ul class="list-icons-1">
                        <li><i class="fa fa-check"></i> Includes all Store Partner benefits</li>
                        <li><i class="fa fa-check"></i> Retain more customers & reduce churn</li>
                        <li><i class="fa fa-check"></i> Smart subscription management tools</li>
                        <li><i class="fa fa-check"></i> Manage renewals and upgrades</li>
                        <li><i class="fa fa-check"></i> Cover entire subscription lifecycle</li>
                        <li><i class="fa fa-check"></i> Insights through subscription analytics</li>
                    </ul>
                </div>
                
            </div>

            <!-- 2MONETIZE Card -->
            <div class="pricing-card">
                <h3>Brand Partner</h3>
                <p>All-in-one solution to sell DIGITAL GOODS globally</p>
                <p>for fast-growing businesses</p>
                <a class="signup-btn-2" href="{{ route('register.brand_partner') }}">Apply Now</a>
                <p class="note">No credit card required.<br>You’ll only pay when you start selling.</p>
                <h4>WHAT YOU GET</h4>
                <ul class="list-icons-2">
                    <li><i class="fa fa-check"></i> Includes all Verified Seller benefits</li>
                    <li><i class="fa fa-check"></i> Global tax & regulatory compliance</li>
                    <li><i class="fa fa-check"></i> Invoice management</li>
                    <li><i class="fa fa-check"></i> Reduce backend internal work</li>
                    <li><i class="fa fa-check"></i> Access to 45+ payment methods</li>
                    <li><i class="fa fa-check"></i> Optimize conversion rates</li>
                    <li><i class="fa fa-check"></i> Help for shopping carts customization</li>
                </ul>
            </div>
        </div>
        

    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script type="text/javascript">
        
    $(document).ready(function(){
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
<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e8ebef">-->
 @php
   $logo = get_setting('header_logo');
@endphp
<!--    <tr>-->
<!--        <td align="center" valign="top" class="container" style="padding:50px 10px;">-->
            <!-- Container -->
<!--            <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                <tr>-->
<!--                    <td align="center">-->
<!--                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">-->
<!--                            <tr>-->
<!--                                <td class="td" bgcolor="#ffffff" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">-->
                                    <!-- Header -->
<!--                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">-->
<!--                                        <tr>-->
<!--                                            <td class="p30-15-0" style="padding: 40px 30px 0px 30px;">-->
<!--                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                                                    <tr>-->
<!--                                                        <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">-->
<!--                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                                                                <tr>-->
<!--                                                                    <td class="img m-center" style="font-size:0pt; line-height:0pt; text-align:left;"><img src="{{ uploaded_asset($logo) }}" width="" height="24" border="0" alt="" /></td>-->
<!--                                                                </tr>-->
<!--                                                            </table>-->
<!--                                                        </th>-->
<!--                                                        <th class="column-empty" width="1" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;"></th>-->
<!--                                                        <th class="column" width="120" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">-->
<!--                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                                                                <tr>-->
<!--                                                                    <td class="text-header right" style="color:#000000; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;"><a href="{{ env('APP_URL') }}" target="_blank" class="link" style="color:#000001; text-decoration:none;"><span class="link" style="color:#000001; text-decoration:none;">{{ env('APP_NAME') }}</span></a></td>-->
<!--                                                                </tr>-->
<!--                                                            </table>-->
<!--                                                        </th>-->
<!--                                                    </tr>-->
<!--                                                </table>-->
<!--                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                                                    <tr>-->
<!--                                                        <td class="separator" style="padding-top: 40px; border-bottom:4px solid #000000; font-size:0pt; line-height:0pt;">&nbsp;</td>-->
<!--                                                    </tr>-->
<!--                                                </table>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                    </table>-->
                                    <!-- END Header -->

                                    <!-- Intro -->
<!--                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">-->
<!--                                        <tr>-->
<!--                                            <td class="p30-15" style="padding: 70px 30px 70px 30px;">-->
<!--                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">-->
<!--                                                    <tr>-->
<!--                                                        <td class="h2 center pb10" style="color:#000000; font-family:'Ubuntu', Arial,sans-serif; font-size:50px; line-height:60px; text-align:center; padding-bottom:10px;">{{ $array['subject'] }}</td>-->
<!--                                                    </tr>-->
<!--                                                    <tr>-->
<!--                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#2e57ae; padding-bottom:30px;">{{ $array['content'] }} </td>-->
<!--                                                    </tr>-->
<!--                                                    @if(!empty( $array['link']))-->
<!--                                                    <tr>-->
<!--                                                        <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#2e57ae; padding-bottom:30px;">-->
<!--                                                            <a href="{{ $array['link'] }}" style="background: #007bff;padding: 0.9rem 2rem;font-size: 0.875rem;color:#fff;border-radius: .2rem;" target="_blank">{{ translate("Activate") }}</a>-->
<!--                                                        </td>-->
<!--                                                    </tr>-->
<!--                                                    @endif-->
<!--                                                </table>-->
<!--                                            </td>-->
<!--                                        </tr>-->
<!--                                    </table>-->
                                    <!-- END Intro -->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            <tr>-->
<!--                                <td class="text-footer" style="padding-top: 30px; color:#1f2125; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:22px; text-align:center;">-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <!-- END Container -->
<!--        </td>-->
<!--    </tr>-->
<!--</table>-->


<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Test Email</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
      }
      .email-container {
        max-width: 600px;
        margin: 20px auto;
        background: #ffffff;
        border: 1px solid #dddddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }
      .header {
        /*background-color: ;*/
        /*color: #ffffff;*/
        text-align: center;
        padding: 20px;
      }
      .content {
        padding: 20px;
        color: #333333;
        text-align: left;
      }
      .content h1 {
        font-size: 22px;
        margin: 0 0 10px;
      }
      .content p {
        font-size: 14px;
        line-height: 1.5;
        margin: 0 0 20px;
      }
      .footer {
        background-color: #f4f4f4;
        color: #666666;
        text-align: center;
        padding: 15px;
        font-size: 12px;
      }
      .footer a {
        color: #007BFF;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
    <div class="email-container">
      <div class="header">
        <div class="logo-container">
          <img src="https://allaaddin.com/public/images/bighouz-logo.png" alt="FinTech Logo" >
        </div>
        <div>
          <img src="https://allaaddin.com/public/images/email-template-banner-image.jpg" alt="flower">
        </div>
      </div>
      <div class="content">
        <h1>Activate your account</h1>
        <p>Click the link below to activate your account and start enjoying all the benefits we offer.</p>
        <!--<p>-->
        <!--  Make sure your SPF, DKIM, and DMARC records are properly configured.-->
        <!--  You can also test if images, links, and formatting render correctly in-->
        <!--  different email clients.-->
        <!--</p>-->
        @if(!empty( $array['link']))
        <p>
          <strong>Activate:</strong> <a href="{{ $array['link'] }}">Click Here</a>
        </p>
        @endif
        <img
          src="https://via.placeholder.com/600x200?text=Email+Test+Image"
          alt="Test Image"
          style="width: 100%; max-width: 600px; height: auto; display: none"
        />
        
      </div>
      <div class="footer">
        
          <div style="margin: 30px auto; max-width: 300px; width: 100%; text-align: center; margin-top: 40px;">
            <img src="https://allaaddin.com/public/images/bighouz-logo.png" alt="FinTech Logo" >
            
            <br>
              Download our App Now
              <br>
              <br>
              <img style="width: 48%" src="https://allaaddin.com/public/assets/img/play.png" style="">
              <img style="width: 48%" src="https://allaaddin.com/public/assets/img/app.png" style="">
              <br>
              <hr>
          </div>
          <div style=" text-align: center; max-width: 200px; margin: 0 auto; ">
              Find Us On
              <br>
              <br>
              <a><img style="width: 30px" src="https://allaaddin.com/public/images/2021_Facebook_icon.svg.webp" style=""></a>
              <a><img style="width: 30px" src="https://allaaddin.com/public/images/Instagram_icon.png" style=""></a>
              <a><img style="width: 30px" src="https://allaaddin.com/public/images/circle-linkedin-512.webp" style=""></a>
              <a><img style="width: 30px" src="https://allaaddin.com/public/images/1553127754.png" style=""></a>
              <a><img style="width: 30px" src="https://allaaddin.com/public/images/whatsapp-icon-1977x2048-6lcnmyml.png" style=""></a>
              <br>
              <br>
             
          </div>
          <div style="width: 100%; max-width: 500px; margin: 0 auto; text-align: center;">
            <small style="text-align: center;">
              <span style="color: red; font-size: inherit;">NOTE:&nbsp;</span> This is an automatically generated email, please do not reply.<br>
              Office address: 6 Raffles Quay, #14-06, Singapore (Postal 048580)
              <br>
              <br>
              Please note, returns will not be accepted at this address.
              If you want to return items, please request a return and use label.
              <br>
              <a href="">Click to view more details.</a>
              <br>
              <br>
              Please contact customer service if you have any questions.
              <br>
              <a href="">Privacy & Cookie Policy</a> |  <a href="">Terms & Conditions </a>|  <a href="">Unsubscribe</a>
            </small>
          </div>
           
      </div>
    </div>
  </body>
</html>



<!--<!DOCTYPE html>-->
<!--<html>-->

<!--<head>-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <title>Laravel Invoice</title>-->
<!--    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">-->
<!--    <style media="all">-->
<!--                    :root {-->
<!--                      --primary-color: #F1992A;-->
<!--                      --primary-hover-color: #d97f22;-->
<!--                      --Black--color: #000;-->
<!--                    }-->
                
<!--                    body {-->
<!--                      font-family: Arial, sans-serif;-->
<!--                      margin: 0;-->
<!--                      padding: 0;-->
<!--                      background-color: #f4f4f9;-->
<!--                    }-->
                
<!--                    .email-container {-->
<!--                      max-width: 600px;-->
<!--                      margin: 20px auto;-->
<!--                      background: #ffffff;-->
<!--                      border-radius: 8px;-->
<!--                      overflow: hidden;-->
<!--                      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);-->
<!--                    }-->
                
<!--                    .header {-->
<!--                      background-color: var(--primary-color);-->
<!--                      padding: 20px;-->
<!--                      text-align: center;-->
<!--                      height: 40px;-->
<!--                    }-->
                
<!--                    .logo-container {-->
<!--                      text-align: center;-->
<!--                    }-->
                
<!--                    .header-logo {-->
<!--                      width: 250px;-->
<!--                    }-->
                
<!--                    .content {-->
<!--                      padding: 20px;-->
<!--                      text-align: start;-->
<!--                    }-->
                
<!--                    .content h1 {-->
<!--                      font-size: 24px;-->
<!--                      color: #333;-->
<!--                    }-->
                
<!--                    .content p {-->
<!--                      font-size: 14px;-->
<!--                      color: #666;-->
<!--                      line-height: 1.6;-->
<!--                    }-->
                
                    
                
<!--                    .step button {-->
<!--                      background-color: transparent;-->
<!--                      color: var(--primary-color);-->
<!--                      padding: 10px 20px;-->
<!--                      border: 1px solid var(--primary-color);-->
<!--                      border-radius: 14px;-->
<!--                      cursor: pointer;-->
<!--                      font-size: 14px;-->
<!--                      transition: all 0.3s ease;-->
<!--                    }-->
                
<!--                    .contact-btn {-->
<!--                      background-color: transparent;-->
<!--                      color: var(--primary-color);-->
<!--                      padding: 10px 20px;-->
<!--                      border: 1px solid var(--primary-color);-->
<!--                      border-radius: 14px;-->
<!--                      cursor: pointer;-->
<!--                      font-size: 14px;-->
<!--                      transition: all 0.3s ease;-->
<!--                    }-->
                
<!--                    .step button:hover,-->
<!--                    .contact-btn:hover {-->
<!--                      background-color: var(--primary-color);-->
<!--                      color: #fff;-->
<!--                    }-->
                
<!--                    .footer {-->
<!--                      background-color: var(--primary-color);-->
<!--                      color: white;-->
<!--                      text-align: center;-->
<!--                      padding: 15px;-->
<!--                      font-size: 12px;-->
<!--                    }-->
                
<!--                    .footer-content {-->
<!--                      display: flex;-->
<!--                      justify-content: space-between;-->
<!--                      align-items: center;-->
<!--                      margin-bottom: 10px;-->
<!--                    }-->
                
<!--                    .footer-logo {-->
<!--                      max-width: 100px;-->
<!--                    }-->
                
<!--                    .social-icons {-->
                  
<!--                      display: flex;-->
<!--                      gap: 5px;-->
                     
<!--                    }-->
                
                
<!--                    .social-icon {-->
<!--                      border-radius: 20px;-->
<!--                      background-color: #ffffff;-->
<!--                      color: #F1992A;-->
<!--                      font-size: 16px;-->
<!--                      text-decoration: none;-->
<!--                      transition: color 0.3s ease;-->
<!--                      height: 15px;  -->
<!--                      padding: 5px;-->
<!--                    }-->
<!--                    .social-icon i {-->
<!--                      color:#F1992A-->
<!--                    }-->
<!--                    .social-icon:hover {-->
<!--                      color: #e0e0e0;-->
<!--                    }-->
                     
<!--                    .footer-links {-->
<!--                      display: flex;-->
<!--                      justify-content: space-between;-->
<!--                      align-items: center;-->
<!--                    }-->
                
<!--                    .footer-start {-->
<!--                      font-weight: bold;-->
<!--                      margin: 0;-->
<!--                    }-->
                
<!--                    .link-group {-->
<!--                      display: flex;-->
<!--                      gap: 5px;-->
<!--                    }-->
                
<!--                    .link-group a {-->
<!--                      color: white;-->
<!--                      text-decoration: none;-->
<!--                      transition: color 0.3s ease;-->
<!--                    }-->
                
<!--                    .link-group a:hover {-->
<!--                      color: #e0e0e0;-->
<!--                    }-->
                
<!--                    .footer a {-->
<!--                      color: #fff;-->
<!--                      text-decoration: none;-->
<!--                      margin-top: 8px;-->
<!--                      margin-bottom: 8px;-->
                      
<!--                    }-->
                
<!--                    .footer a:hover {-->
<!--                      text-decoration: underline;-->
<!--                    }-->
                
                   <!--/* Styling for span inside the list items */-->
<!--                    span {-->
<!--                      font-size: 18px;-->
<!--                      font-weight: 700;-->
<!--                      color: #000;-->
<!--                    }-->
<!--                  </style>-->
<!--                </head>-->
<!--                <body>-->
<!--                  <div class="email-container">-->
<!--                    <div class="logo-container">-->
<!--                      <img src="https://allaaddin.com/public/images/bighouz-logo.png" alt="FinTech Logo" >-->
<!--                    </div>-->
<!--                    <div>-->
<!--                      <img src="https://allaaddin.com/public/images/email-template-banner-image.jpg" alt="flower">-->
<!--                    </div>-->
<!--                    <div class="content">-->
<!--                      <h1>Verify Your Account</h1>-->
<!--                      <p>Hello Merilyn Parks,<br>Welcome to FinTech! To get the most out of your account, please take a few moments to complete your setup. This will ensure you have full access to all our features and services.</p>-->
<!--                      <button class="contact-btn">Verify my email</button>-->
<!--                    </div>-->
                
<!--                    <div class="content">-->
<!--                      <div class="d-flex align-items-center">-->
<!--                        <h1>  <i class="fas fa-shield-alt" style="color: var(--primary-color)"></i> Why Verification Matters</h1>-->
<!--                      </div>-->
                     
<!--                      <ul>-->
<!--                        <li>-->
<!--                          <p><span>Enhanced Security:</span> Identity verification helps prevent unauthorized access and protects your financial information.</p>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                          <p><span>Compliance:</span> This process helps us comply with financial regulations and ensures a safe experience for all our clients.</p>-->
<!--                        </li>-->
<!--                      </ul>-->
<!--                    </div>-->
                    
                
                    
<!--                    <div style="width: 100%;background: #e1e1e1; padding-bottom: 30px;">-->
                
<!--                      <div style="margin: 30px auto; max-width: 300px; width: 100%; text-align: center; margin-top: 40px;">-->
<!--                        <img src="https://allaaddin.com/public/images/bighouz-logo.png" alt="FinTech Logo" >-->
                        
<!--                        <br>-->
<!--                          Download our App Now-->
<!--                          <br>-->
<!--                          <br>-->
<!--                          <img style="width: 48%" src="https://allaaddin.com/public/assets/img/play.png" style="">-->
<!--                          <img style="width: 48%" src="https://allaaddin.com/public/assets/img/app.png" style="">-->
<!--                          <br>-->
<!--                          <hr>-->
<!--                      </div>-->
<!--                      <div style=" text-align: center; max-width: 200px; margin: 0 auto; ">-->
<!--                          Find Us On-->
<!--                          <br>-->
<!--                          <br>-->
<!--                          <a><img style="width: 30px" src="https://allaaddin.com/public/images/2021_Facebook_icon.svg.webp" style=""></a>-->
<!--                          <a><img style="width: 30px" src="https://allaaddin.com/public/images/Instagram_icon.png" style=""></a>-->
<!--                          <a><img style="width: 30px" src="https://allaaddin.com/public/images/circle-linkedin-512.webp" style=""></a>-->
<!--                          <a><img style="width: 30px" src="https://allaaddin.com/public/images/1553127754.png" style=""></a>-->
<!--                          <a><img style="width: 30px" src="https://allaaddin.com/public/images/whatsapp-icon-1977x2048-6lcnmyml.png" style=""></a>-->
<!--                          <br>-->
<!--                          <br>-->
                         
<!--                      </div>-->
<!--                      <div style="width: 100%; max-width: 500px; margin: 0 auto; text-align: center;">-->
<!--                        <small style="text-align: center;">-->
<!--                          <span style="color: red; font-size: inherit;">NOTE:&nbsp;</span> This is an automatically generated email, please do not reply.<br>-->
<!--                          Office address: 6 Raffles Quay, #14-06, Singapore (Postal 048580)-->
<!--                          <br>-->
<!--                          <br>-->
<!--                          Please note, returns will not be accepted at this address.-->
<!--                          If you want to return items, please request a return and use label.-->
<!--                          <br>-->
<!--                          <a href="">Click to view more details.</a>-->
<!--                          <br>-->
<!--                          <br>-->
<!--                          Please contact customer service if you have any questions.-->
<!--                          <br>-->
<!--                          <a href="">Privacy & Cookie Policy</a> |  <a href="">Terms & Conditions </a>|  <a href="">Unsubscribe</a>-->
<!--                        </small>-->
<!--                      </div>-->
                       
<!--                    </div>-->
                    
                
<!--                  </div>-->
<!--                </body>-->
<!--                </html>-->
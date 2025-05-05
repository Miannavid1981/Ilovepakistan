<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Store Verification</title>
  <style>
    body {
      font-family: sans-serif;
      background-color: #f6f6f6;
      padding: 20px;
      margin: 0;
      color: #333333;
    }
    .email-wrapper {
      background-color: #ffffff;
      padding: 20px;
      max-width: 600px;
      margin: 0 auto;
      border-radius: 5px;
      border: 1px solid #e0e0e0;
    }
    .otp-code {
      font-size: 20px;
      font-weight: bold;
      color: #1a73e8;
      margin: 20px 0;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      color: #888888;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    

    <p>Thank you for signing up as a seller at <strong>Bighouz</strong>.</p>

    <p>Your One-Time Password (OTP) is:</p>

    <p class="otp-code">{{ $otp }}</p>

    <p>This code is valid for 5 minutes. Please do not share it with anyone.</p>

    <p class="footer">
      If you did not request this code, you can safely ignore this email.<br><br>
      Bighouz Team<br>
      <a href="https://www.bighouz.com" style="color:#1a73e8;">www.bighouz.com</a>
    </p>
  </div>
</body>
</html>

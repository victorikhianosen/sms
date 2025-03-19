<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F4F7F9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            font-size: 22px;
            font-weight: bold;
            color: #0B163F;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .otp-box {
            font-size: 32px;
            font-weight: bold;
            color: #0B163F;
            padding: 12px;
            background-color: #EAF0FF;
            border-radius: 8px;
            display: inline-block;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0B163F;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: bold;
        }

        .btn:hover {
            background-color: #091233;
        }

        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 25px;
        }

        .support {
            font-size: 14px;
            color: #555;
            margin-top: 15px;
        }

        .support a {
            color: #0B163F;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">Verify Your Email</div>

        <div class="content">
            <p>Hello <strong>{{ $first_name }}</strong>,</p>
            <p>Welcome to <strong>SmsTrix</strong>! Use the OTP below to verify your email:</p>

            <div class="otp-box">{{ $otp }}</div>

            <p>This OTP is valid for **10 minutes**.</p>

            <a href="{{ $verificationLink }}" class="btn">Verify Email</a>

            <p>If you didn’t request this, please ignore it. Need help? Contact our support team below.</p>

            <p class="support">📧 Contact Support: <a href="mailto:support@ggtconnect.com">support@ggtconnect.com</a>
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} SmsTrix - Bulk SMS Platform. All rights reserved.
        </div>
    </div>

</body>

</html>
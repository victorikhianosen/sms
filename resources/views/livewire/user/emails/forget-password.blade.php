<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
        }

        .otp {
            display: inline-block;
            padding: 15px;
            background-color: #28a745;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #888888;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Password Reset OTP</h1>
        </div>
        <div class="email-body">
            <p>Hello {{ $firstName }} </p>
            <p>We received a request to reset the password for your account. To
                proceed, please use the One-Time Password (OTP) below:</p>
            <div class="otp">
                {{ $otp }}
            </div>
            <p>This OTP is valid for the next 10 minutes. If you did not request a password reset, please ignore this
                email or contact support immediately.</p>
            <p>Thank you for using our service!</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p>The GGT Connect Team</p>
            <p>For any assistance, visit our <a href="#">Support Center</a>.</p>
        </div>
    </div>
</body>

</html>

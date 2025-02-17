<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account Created</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 22px;
        }

        .email-body {
            padding: 20px;
            color: #333333;
        }

        .info-box {
            background-color: #ffff;
            color: #000;
            padding: 15px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            text-align: start;
            margin: 20px 0;
        }

        .info-box p {
            margin: 5px 0;
        }

        .email-body p {
            line-height: 1.6;
            margin: 10px 0;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: start;
            padding: 15px;
            font-size: 14px;
            color: #888888;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Admin Account Created</h1>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ $firstName }}</strong>,</p>
            <p>Your admin account has been successfully created. Below are your login details:</p>
            <div class="info-box">
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
            </div>
            <p><strong>Important:</strong> For security reasons, please change your password immediately after logging
                in.</p>
            <p>If you have any issues, feel free to contact our support team.</p>
        </div>
        <div class="footer">
            <p>Best regards,</p>
            <p><strong>The GGT Connect Team</strong></p>
            <p>Need help? Visit our <a href="#">Support Center</a>.</p>
        </div>
    </div>
</body>

</html>
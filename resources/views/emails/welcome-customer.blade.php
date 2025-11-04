<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body h2 {
            color: #667eea;
            margin-top: 0;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
        }
        .credentials-box p {
            margin: 8px 0;
        }
        .credentials-box strong {
            color: #667eea;
        }
        .contract-box {
            background-color: #e7f3ff;
            border: 2px solid #667eea;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .contract-box h3 {
            margin-top: 0;
            color: #667eea;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #667eea;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        .important-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎉 Welcome to {{ config('app.name') }}</h1>
        </div>
        
        <div class="email-body">
            <h2>Hello {{ $user->name }}!</h2>
            
            <p>Your account has been successfully created. We're excited to have you on board!</p>
            
            <div class="credentials-box">
                <h3>Your Login Credentials:</h3>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
                <p><strong>Login URL:</strong> <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>
            </div>

            <div class="contract-box">
                <h3>🎉 Account Activated!</h3>
                <p>Your account has been successfully activated and is ready to use.</p>
                <p>You can now log in and start using all the features available to your account.</p>
            </div>

            <div class="important-note">
                <strong>⚠️ Important Security Note:</strong>
                <p>For security reasons, please change your password after your first login. You can do this from your profile settings.</p>
            </div>

            <center>
                <a href="{{ url('/login') }}" class="btn">Login to Your Account</a>
            </center>

            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Team</strong></p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>This is an automated email, please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body>
    <h2>Hello {{ $user->name }},</h2>
    <p>We received a request to reset your password. Click the button below to choose a new password:</p>

    <p>
        <a href="{{ $resetUrl }}" style="background-color: #536451; color: #f3e9d5; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; letter-spacing: 0.5px; display: inline-block;">
            Reset Password
        </a>
    </p>

    <p>This link will expire in 60 minutes. If you didn't request this, you can safely ignore this email.</p>

    <p>Thanks,<br>GET READY Team</p>
</body>
</html>

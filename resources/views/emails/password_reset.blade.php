<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Password Reset</title>
</head>
<body>
<div style="max-width: 600px; margin: auto; padding: 20px; text-align: center; font-family: Arial, sans-serif;">
    <h1 style="color: #333;">Reset Your Password</h1>
    <p style="font-size: 16px; color: #555;">Hello! You are receiving this email because we received a password reset request for your account.</p>
    <a href="{{ url('reset-password/'.$token) }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; color: #fff; background-color: #007BFF; text-decoration: none; border-radius: 5px; font-size: 16px;">Reset Password</a>
    <p style="margin-top: 20px; font-size: 14px; color: #555;">If you did not request a password reset, no further action is required.</p>
</div>
</body>
</html>

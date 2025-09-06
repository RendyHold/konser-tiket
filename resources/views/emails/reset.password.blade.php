<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <p>Untuk Mereset Password Anda, Silahkan Klik Link di bawah ini:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Reset Password</a>
    <p>Best regards,</p>
    <p>Team Konser Tiket</p>
</body>
</html>
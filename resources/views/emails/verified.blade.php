<!DOCTYPE html>
<html>
<head>
    <title>Your Account is Verified!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        h1 {
            color: #0066cc;
        }

        p {
            margin-bottom: 15px;
        }

        .signature {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Your Account is Verified</h1>
    <p>Dear {{ $user->firstname }} {{ $user->lastname }},</p>
    <p>Congratulations! Your account on GENER has been verified by the admin. You can now access your account and enjoy all the features.</p>
    <p>If you have any questions or need assistance, feel free to reach out to our friendly support team. We are here to help!</p>
    <p>Thank you once again for joining us.</p>
    <p>Best regards,</p>
    <p class="signature">GENER Team</p>
</body>
</html>

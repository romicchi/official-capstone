<!DOCTYPE html>
<html>
<head>
    <title>Registration Email</title>
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
    <h1>Thank You for Registering</h1>
    <p>Dear {{ $user->firstname }} {{ $user->lastname }},</p>
    <p>Thank you for registering on our website. We are thrilled to have you as a new member of our community.</p>
    <p>At {{config('app.name')}}, we are committed to providing you with the best experience. Your registration demonstrates your trust and confidence in our platform.</p>
    <p>Please allow us some time to verify your user credentials. Once your account is verified, you will receive an email with further instructions to access all the exciting features and benefits of our website.</p>
    <p>If you have any questions or need assistance, feel free to reach out to our friendly support team. We are here to help!</p>
    <p>Thank you once again for joining us.</p>
    <p>Best regards,</p>
    <p class="signature">GENER Team</p>
</body>
</html>

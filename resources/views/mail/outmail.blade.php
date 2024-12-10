<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .email-body {
            padding: 20px 30px;
            color: #333333;
            line-height: 1.6;
        }

        .email-body h2 {
            color: #007bff;
            font-size: 20px;
            margin: 0 0 10px;
        }

        .email-footer {
            text-align: center;
            padding: 15px 30px;
            font-size: 14px;
            color: #666666;
            background-color: #f4f4f4;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
            <h1>{{ $subject }}</h1>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <h2>{{ ucfirst($msg) }}</h2>
            <p>Hello,</p>
            <p>We’re reaching out to notify you of an important update. Please review the information and feel free to
                contact us if you have any questions or require further assistance.</p>
            <p>Thank you for your attention!</p>
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>

</body>

</html>

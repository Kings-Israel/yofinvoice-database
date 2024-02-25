<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
        }

        .header {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">Welcome</div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>Welcome to YofInvoice</p>
            <p>Attached is the link to upload the required documents <a href="{{ $documentsLink }}">
                    <strong>HERE</strong></a> page.</p>
            <h5> The documents include</h5>
            @forelse ($documents as $value )
            <li><strong>{{ $value['title'] }}</strong></li>
            @empty
            <li><strong>An Error Occurred</strong></li>
            @endforelse
            <p>If you have any questions or need assistance, don't hesitate to reach out to our support team or visit
                our <a href="{{ env('APP_URL') }}">Support Center</a>.</p>
            <p>Thank you for choosing us,</p>
            <p>The Team</p>

        </div>
    </div>
</body>

</html>

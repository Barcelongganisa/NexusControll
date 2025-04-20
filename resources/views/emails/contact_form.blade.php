<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        .highlight {
            font-weight: bold;
            color: #222;
        }
        .message-box {
            background: #f9f9f9;
            padding: 15px;
            border-left: 5px solid #007BFF;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>New Contact Form Submission</h1>
        <p><span class="highlight">First Name:</span> {{ $data['first_name'] }}</p>
        <p><span class="highlight">Last Name:</span> {{ $data['last_name'] }}</p>
        <p><span class="highlight">Email:</span> {{ $data['email'] }}</p>
        <p><span class="highlight">Phone:</span> {{ $data['phone'] }}</p>
        <p class="highlight">Message:</p>
        <div class="message-box">
            <p>{{ $data['message'] }}</p>
        </div>
    </div>
</body>
</html>
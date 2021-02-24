<!DOCTYPE html>
<html>
<head>
    <title>Pilo - Welcome Email</title>
    <style>
        .main {
            background: #f9f9f9;
            position: fixed;
            width: 100%;
            height: 100%;
            padding: 40px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Whitney, Helvetica Neue, Helvetica, Arial, Lucida Grande, sans-serif;

        }

        .content {
            background: white;
            border-radius: 5px;
            padding: 32px;
        }

        h2 {
            color: #4f545c;
            font-weight: 500;
            font-size: 20px;
            letter-spacing: 0.27px;
        }

        .logo img {
            width: 100px;
        }

        .verify {
            margin-top: 40px;
            text-align: center;
        }

        .verify a {
            background: #4cb6cb;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .verify a:hover {
            opacity: 0.6;
        }


    </style>
</head>
<body>

<div class="main">

    <div class="content">
        <div class="logo">
            <img src="{{$message->embed('https://new.pilo.app/logo.png')}}" alt="logo">
        </div>
        <h2>Welcome to the Pilo</h2>
        <p>
            Thanks for registering for an account on <a href="https://pilo.app">Pilo</a>! Before we get started, we just
            need to confirm that this
            is you. Click below to verify your email address:
        </p>

        <div class="verify">
            {{$code}}
        </div>

    </div>
</div>
</body>
</html>


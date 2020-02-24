<!DOCTYPE html>
<html>
<head>
    <title>Pilo - Reset Password</title>
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

        .danger {
            margin-top: 30px;
            color: red;
            font-size: 12px;
        }


    </style>
</head>
<body>

<div class="main">

    <div class="content">
        <div class="logo">
            <img src="https://api.pilo.app/images/pilo-logo-gray-text.svg" alt="logo">
        </div>
        <h2>You are receiving this email because we received a password reset request for your account.</h2>

        <div class="verify">
            Verify Code : {{$code}}
        </div>

        <div class="danger">
            <strong>If you did not request a password reset, no further action is required.</strong>
        </div>

    </div>
</div>
</body>
</html>


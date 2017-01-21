<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Gmail
                </div>

                <div class="links">
                    <a href="https://github.com/ABHIJEET-MUNESHWAR">GitHub</a>
                    <a href="https://www.facebook.com/abhijeet.muneshwar">Facebook</a>
                    <a href="https://www.linkedin.com/in/abhijeet-muneshwar-78728624">LinkedIn</a>
                    <a href="https://twitter.com/ABHIJEEEEEEET">Twitter</a>
                    <a href="https://plus.google.com/u/0/+AbhijeetMuneshwar/about">Google Plus</a>
                    <a href="http://instagram.com/abhijeetmuneshwar">Instagram</a>
                    <a href="https://www.quora.com/Abhijeet-Ashok-Muneshwar">Quora</a>
                    <a href="https://soundcloud.com/abhijeet-ashok-muneshwar">Soundcloud</a>
                </div>
            </div>
        </div>
    </body>
</html>

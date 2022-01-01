<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #00B900;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
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
            
            a {
            background-color: #fff;
            text-decoration: none;
            color: #00A900;
            font-size: 43px;
            }
            
            .box {
            border: 1px solid lightgray;
            padding: 100px;
            border-radius: 21px;
            }
            
        </style>
    </head>
    <body>
        <div class="flex-center full-height">
           <a class="box" href="{{ route('linelogin',['provider' => 'line']) }}">登録</a>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
      html, body {
        background: linear-gradient(184deg, rgba(129,187,119,0.20351890756302526) 0%, rgba(129,187,119,0.14189425770308128) 100%);
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    </style>
    <link href="https://fonts.googleapis.com/earlyaccess/hannari.css" rel="stylesheet">
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body>
    <div id="example"></div>
    {{-- <script src="{{ mix('js/app.js') }}" ></script> --}}
</body>
</html>
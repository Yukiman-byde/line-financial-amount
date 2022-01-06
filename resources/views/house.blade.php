<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LineAmountApp</title>
    <style>
      body, html {
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
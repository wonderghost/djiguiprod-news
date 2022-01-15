<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}?<?php echo filemtime('css/app.css') ?>">
    <title>{{ config('app.name') }}</title>
</head>
<body>

    <div id="app">
        <dashboard></dashboard>
    </div>
    
    <script src="{{mix('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
</body>
</html>
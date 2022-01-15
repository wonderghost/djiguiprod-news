<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}?<?php echo filemtime('css/app.css') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    {{-- <meta property="og:url" content="https://news.djiguiprod.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="L’article de l’ONG internationale est formel : « des joueuses de l’équipe nationale féminine de basketball des"/>
    <meta property="og:description" content="L’article de l’ONG internationale est formel : « des joueuses de l’équipe nationale féminine de basketball des" />
    <meta property="og:image" content="https://news.djiguiprod.com/uploads/0RDHnPscHo1627901040.jpg" /> --}}
    <title>{{ config('app.name') }}</title>
</head>
<body>

    <div id="app">
        <category id-category="{{ $subCategory }}"></category>
    </div>
    
    <script src="{{mix('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
</body>
</html>
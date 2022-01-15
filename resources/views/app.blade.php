<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}?<?php echo filemtime('css/app.css') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta property="og:url" content="https://news.djiguiprod.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Djiguiprod News. Site d'information culturel"/>
    <meta property="og:description" content="Depuis Mars 2018, Djigui Production accompagne des acteurs culturels dans les domaines Culturel, Artistique et l'événementiel. Si votre objectif est de vous produire sur scène ou d’organiser des événements, sachez que nous apportons des solutions pour développer votre modèle économique, votre talent artistique et rendre efficient votre personne afin de vous réaliser pleinement." />
    <meta property="og:image" content="/images/logo-djigui.png"/>
    <title>{{ config('app.name') }}</title>
</head>
<body>

    <div id="app">
        <dashboard></dashboard>
    </div>
    
    <script src="{{mix('js/app.js')}}?<?php echo filemtime('js/app.js') ?>"></script>
</body>
</html>
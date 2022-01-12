<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta property="og:url" content="https://news.djiguiprod.com/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="L’article de l’ONG internationale est formel : « des joueuses de l’équipe nationale féminine de basketball des"/>
    <meta property="og:description" content="L’article de l’ONG internationale est formel : « des joueuses de l’équipe nationale féminine de basketball des" />
    <meta property="og:image" content="https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.auto-moto.com%2Factualite%2Fen-chiffres%2Fvoitures-plus-vendues-france-2020-classement-264440.html&psig=AOvVaw32DrWFSXfBkzHHPM41COs-&ust=1642091424401000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCOjnubTRrPUCFQAAAAAdAAAAABAD" />
    {{-- <title>{{ config('app.name') }}</title> --}}
</head>
<body>

    <div id="app">
        <app></app>
    </div>
    
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
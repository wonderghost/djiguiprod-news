<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <meta property="og:url" content="{{ 'https://news.djiguiprod.com/articles/'. $article->slug }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $article->name }}"/>
    <meta property="og:description" content="{{ $article->resume }}" />
    <meta property="og:image" content="{{ '/uploads/'. $article->image  }}" />
</head>
<body>

    <div id="app">
        <detail article="{{ $article }}"></detail>
    </div>
    
    <script src="{{mix('js/app.js')}}"></script>
</body>
</html>
@component('mail::message')
# Newsletter

Bonjour tout le monde,

Cliquez sur le bouton ci-dessous pour lire notre dernière article.

@component('mail::button', ['url' => $data['url']])
Voir l'article
@endcomponent

Nous vous remercions,<br>
{{ config('app.name') }}
@endcomponent

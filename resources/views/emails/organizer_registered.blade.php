@component('mail::message')
Bonjour,

Le compte organisateur de "{{ $name }}" sur l'application "À fond la caisse" vient d'être créé.

Tu peux désormais t'y connecter avec le mot de passe suivant : **{{ $password }}**

@component('mail::button', ['url' => route('login:organizer')])
Je me connecte
@endcomponent

N'hésite pas nous contacter si tu as des questions.

À bientôt !

Thanks,<br>
{{ config('app.name') }}
@endcomponent
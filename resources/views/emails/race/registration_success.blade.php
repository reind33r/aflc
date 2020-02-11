@component('mail::message')
Bonjour {{ $captain->fullName }},

Ton inscription à la course de caisses à savon à {{ $race->location }},
le @human_date($race->date), a bien été enregistrée.

Tu disposes d'un espace "Mon équipe", te permettant de vérifier
le statut de ton dossier.

@component('mail::button', ['url' => route('race.myteam', ['race' => $race])])
J'accède à l'espace de mon équipe
@endcomponent

N'hésite pas nous contacter si tu as des questions.

À bientôt !

Thanks,<br>
{{ config('app.name') }}
@endcomponent

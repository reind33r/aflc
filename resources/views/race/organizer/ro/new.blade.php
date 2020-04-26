@extends('app')

@section('title')
Nouvelle opportunité d'inscription
@endsection

@section('content')
<h1>Nouvelle opportunité d'inscription</h1>

<p>
    <a href="{{ route('race.organizer.configuration') }}" class="btn btn-secondary">Retour</a>
</p>

<div class="alert alert-warning">
    <h5>Attention</h5>
    <p class="mb-0">
        Il ne sera plus possible de modifier les tarifs, une fois que des
        équipes se seront déjà inscrites !
    </p>
</div>

<form method="POST">
    @csrf

    @input([
        'name' => 'description',
        'type' => 'text',
        'required' => True,
        'help_text' => 'Cette description est affichée aux visiteurs qui désirent s\'inscrire. Elle doit être claire, et préciser les éventuelles conditions (par exemple : tarif étudiant).',
    ])
    Description
    @endinput

    <div class="row">
        <div class="col-md">
            @datetime([
                'name' => 'from',
                'required' => False,
                'help_text' => 'Si vide, les inscriptions seront ouvertes dès maintenant.'
            ])
            Ouverture des inscriptions
            @enddatetime
        </div>
        <div class="col-md">
            @datetime([
                'name' => 'to',
                'required' => False,
                'help_text' => 'Si vide, les inscriptions fermeront le jour de la course à minuit et une minute.',
            ])
            Fermeture des inscriptions
            @enddatetime
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            @input([
                'name' => 'fee_per_team',
                'type' => 'number',
                'step' => 0.01,
                'required' => True,
                'help_text' => 'Tarif fixe appliqué pour chaque équipe.',
                'append' => '€',
            ])
            Tarif par équipe
            @endinput
        </div>
        <div class="col-sm">
            @input([
                'name' => 'fee_per_pilot',
                'type' => 'number',
                'step' => 0.01,
                'required' => True,
                'help_text' => 'Tarif appliqué pour chaque pilote.',
                'append' => '€',
            ])
            Tarif par pilote
            @endinput
        </div>
        <div class="col-sm">
            @input([
                'name' => 'fee_per_soapbox',
                'type' => 'number',
                'step' => 0.01,
                'required' => True,
                'help_text' => 'Tarif appliqué pour chaque caisse à savon.',
                'append' => '€',
            ])
            Tarif par caisse à savon
            @endinput
        </div>
    </div>

    <div class="row">
        <div class="col-sm">
            @input([
                'name' => 'team_limit',
                'type' => 'number',
                'step' => 1,
                'required' => False,
                'help_text' => 'Si vide, aucune limite n\'est appliquée.'
            ])
            Nombre d'équipes maximal
            @endinput
        </div>
        <div class="col-sm">
            @input([
                'name' => 'pilot_limit',
                'type' => 'number',
                'step' => 1,
                'required' => False,
                'help_text' => 'Si vide, aucune limite n\'est appliquée.'
            ])
            Nombre de pilotes maximal
            @endinput
        </div>
        <div class="col-sm">
            @input([
                'name' => 'soapbox_limit',
                'type' => 'number',
                'step' => 1,
                'required' => False,
                'help_text' => 'Si vide, aucune limite n\'est appliquée.'
            ])
            Nombre de caisse à savons maximal
            @endinput
        </div>
    </div>

    @checkbox([
        'name' => 'teasing',
        'help_text' => 'Dans le formulaire d\'inscription, l\'option sera désactivée mais toujours visible',
    ])
        Afficher même en dehors de la période d'ouverture
    @endcheckbox

    @checkbox([
        'name' => 'soft_limits',
        'checked' => True,
        'help_text' => 'Attention : toutes les inscriptions (même les dossiers incomplets), sont prises en compte, à l\'exception des inscriptions refusées.',
    ])
        Autoriser les inscriptions au-delà des limites
    @endcheckbox

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
@endsection
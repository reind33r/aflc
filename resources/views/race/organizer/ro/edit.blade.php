@extends('app')

@section('title')
Modification d'une opportunité d'inscription
@endsection

@section('content')
<h1>Modification d'une opportunité d'inscription</h1>

<p>
    <a href="{{ route('race.organizer.configuration') }}" class="btn btn-secondary">Retour</a>
</p>

@if($ro->teamCount > 0)
<p class="alert alert-warning">
    Des inscriptions ont déjà été effectuées avec ce choix. Par conséquent,
    il n'est plus possible de modifier les tarifs.
</p>
@endif

<form method="POST">
    @csrf

    @input([
        'name' => 'description',
        'type' => 'text',
        'required' => True,
        'help_text' => 'Cette description est affichée aux visiteurs qui désirent s\'inscrire. Elle doit être claire, et préciser les éventuelles conditions (par exemple : tarif étudiant).',
        'initial' => $ro->description,
    ])
    Description
    @endinput

    <div class="row">
        <div class="col-md">
            @datetime([
                'name' => 'from',
                'required' => False,
                'initial' => $ro->from ?? null,
                'help_text' => 'Si vide, les inscriptions seront ouvertes dès maintenant.'
            ])
            Ouverture des inscriptions
            @enddatetime
        </div>
        <div class="col-md">
            @datetime([
                'name' => 'to',
                'required' => False,
                'initial' => $ro->to ?? null,
                'help_text' => 'Si vide, les inscriptions fermeront le jour de la course à minuit et une minute.',
            ])
            Fermeture des inscriptions
            @enddatetime
        </div>
    </div>

    @checkbox([
        'name' => 'teasing',
        'checked' => $ro->teasing,
        'help_text' => 'Dans le formulaire d\'inscription, l\'option sera désactivée mais toujours visible',
    ])
        Afficher même en dehors de la période d'ouverture
    @endcheckbox

    <div class="row">
        <div class="col-sm">
            @input([
                'name' => 'fee_per_team',
                'type' => 'number',
                'step' => 0.01,
                'required' => True,
                'help_text' => 'Tarif fixe appliqué pour chaque équipe.',
                'initial' => $ro->fee_per_team / 100,
                'append' => '€',
                'disabled' => $ro->teamCount > 0,
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
                'initial' => $ro->fee_per_pilot / 100,
                'append' => '€',
                'disabled' => $ro->teamCount > 0,
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
                'initial' => $ro->fee_per_soapbox / 100,
                'append' => '€',
                'disabled' => $ro->teamCount > 0,
            ])
            Tarif par caisse à savon
            @endinput
        </div>
    </div>

    @textarea([
        'name' => 'comment_on_payment',
        'initial' => $ro->comment_on_payment,
        'help_text' => 'Ce commentaire est destiné au capitaine de chaque équipe, et sera affiché sur les pages liées au paiement. Il peut préciser les modes de paiement acceptés (chèque, virement, espèces...) ainsi que les modalités (envoi postal, remise en mains propres le jour de la course, ...).'
    ])
    Commentaire concernant le paiement
    @endtextarea

    <div class="row">
        <div class="col-sm">
            @input([
                'name' => 'team_limit',
                'type' => 'number',
                'step' => 1,
                'required' => False,
                'initial' => $ro->team_limit,
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
                'initial' => $ro->pilot_limit,
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
                'initial' => $ro->soapbox_limit,
                'help_text' => 'Si vide, aucune limite n\'est appliquée.'
            ])
            Nombre de caisse à savons maximal
            @endinput
        </div>
    </div>

    @checkbox([
        'name' => 'soft_limits',
        'checked' => $ro->soft_limits ?? True,
        'help_text' => 'Attention : toutes les inscriptions (même les dossiers incomplets), sont prises en compte, à l\'exception des inscriptions refusées.',
    ])
        Autoriser les inscriptions au-delà des limites
    @endcheckbox

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
@endsection
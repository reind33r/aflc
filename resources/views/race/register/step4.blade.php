@extends('app')

@section('title')
Étape 4 - Récapitulatif
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 4,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
])

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="4">

    <p>
        Merci de vérifier que les informations entrées sont correctes, et de
        cocher les cases correspondantes.
    </p>

    <div class="row">
        <div class="col-md-6">
            @input([
                'name' => 'team_name',
                'required' => True,
                'initial' => $registration_form_data->get('team_name'),
            ])
            Nom de l'équipe
            @endinput
        </div>
    
        <div class="col-md-6">
            @textarea([
                'name' => 'team_comments',
                'required' => False,
                'initial' => $registration_form_data->get('team_comments'),
                'help' => '',
            ])
            Commentaires
            @endtextarea
        </div>
    </div>

    @checkbox([
        'name' => 'captain_check',
        'wrap_label_tag' => 'h3',
    ])
        Capitaine d'équipe
    @endcheckbox

    <p>
        C'est la personne qui gère l'inscription, l'interlocuteur privilégié
        des organisateurs.
    </p>

    <dl class="row">
        <dt class="col-sm-3">Nom</dt>
        <dd class="col-sm-9">
            @lang('keys.' . $registration_form_data->get('captain_honorific_prefix'))
            {{ $registration_form_data->get('captain_first_name') }}
            {{ $registration_form_data->get('captain_last_name') }}
        </dd>
      
        <dt class="col-sm-3">Informations de contact</dt>
        <dd class="col-sm-9">
            {{ $registration_form_data->get('captain_email') }}
            <br>
            @phone($registration_form_data->get('captain_mobile_phone'))
        </dd>
      
        <dt class="col-sm-3">Adresse postale</dt>
        <dd class="col-sm-9">
            {!! nl2br(e($registration_form_data->get('captain_address'))) !!}
            <br>
            {{ $registration_form_data->get('captain_zip_code') }}
            {{ $registration_form_data->get('captain_city') }}
        </dd>
    </dl>

    <div class="row">
        <div class="col-md-6">
            @checkbox([
                'name' => 'pilots_check',
                'wrap_label_tag' => 'h3',
            ])
                Pilotes
            @endcheckbox

            @if($registration_form_data->get('captain_is_pilot'))
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        @lang('keys.' . $registration_form_data->get('captain_honorific_prefix'))
                        {{ $registration_form_data->get('captain_first_name') }}
                        {{ $registration_form_data->get('captain_last_name') }}
                    </h5>

                    Né@if($registration_form_data->get('captain_honorific_prefix') == 'mme')e @endif
                    le @human_date($registration_form_data->get('captain_birthday'))
                </div>
            </div>
            @endif

            @foreach ($registration_form_data->get('pilots') as $pilot)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        @lang('keys.' . $pilot['honorific_prefix'])
                        {{ $pilot['first_name'] }}
                        {{ $pilot['last_name'] }}
                    </h5>

                    Né@if($pilot['honorific_prefix'] == 'mme')e @endif
                    le @human_date($pilot['birthday'])
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-6">
            @checkbox([
                'name' => 'soapboxes_check',
                'wrap_label_tag' => 'h3',
            ])
                Caisses à savon
            @endcheckbox

            @foreach ($registration_form_data->get('soapboxes') as $soapbox)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $soapbox['name'] }}
                    </h5>

                    Numéro de course désiré : {{ $soapbox['desired_number'] ?? 'Aucun' }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @checkbox([
        'name' => 'payment_check',
        'wrap_label_tag' => 'h3',
    ])
        Paiement
    @endcheckbox

    <div class="card mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Rappel du tarif choisi</dt>
                <dd class="col-sm-9">
                    {{ $ro->description }}
                    <br>
                    <a href="{{ route('race.register') }}">Modifier</a>
                </dd>
            </dl>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Quantité</th>
                <th>Tarif unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Frais d'inscription fixes</th>
                <td>1</td>
                <td>@currency($ro->fee_per_team)</td>
                <td>@currency($ro->fee_per_team)</td>
            </tr>
            <tr>
                <th>Pilotes</th>
                <td>{{ (count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) }}</td>
                <td>@currency($ro->fee_per_pilot)</td>
                <td>@currency((count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) * $ro->fee_per_pilot)</td>
            </tr>
            <tr>
                <th>Caisses à savon</th>
                <td>{{ count($registration_form_data->get('soapboxes')) }}</td>
                <td>@currency($ro->fee_per_soapbox)</td>
                <td>@currency(count($registration_form_data->get('soapboxes')) * $ro->fee_per_soapbox)</td>
            </tr>
        </tbody>
        <tfoot class="lead">
            <tr>
                <th colspan="3">Total</th>
                <td>
                    @currency(
                        $ro->fee_per_team +
                        (count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) * $ro->fee_per_pilot +
                        count($registration_form_data->get('soapboxes')) * $ro->fee_per_soapbox
                    )
                </td>
            </tr>
        </tfoot>
    </table>

    @checkbox([
        'name' => 'rgpd_check',
        'required' => True,
    ])
        J'autorise a-fond-la-caisse.com à stocker mes données personnelles
        ainsi que celles des pilotes enregistrés,
        à des fins techniques et d'organisation de la course.
    @endcheckbox

    <input type="submit" name="nextStep"
           value="Valider l'inscription" class="btn btn-primary">

    <a href="{{ route('race.register.step3') }}" class="btn btn-secondary btn-sm">Retour</a>
</form>
@endsection
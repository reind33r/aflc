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

    @input([
        'name' => 'team_name',
        'required' => True,
        'initial' => $registration_form_data->get('team_name'),
    ])
    Nom de l'équipe
    @endinput

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
        'name' => 'rgpd_check',
        'required' => True,
    ])
        J'autorise a-fond-la-caisse.com à stocker mes données personnelles
        ainsi que celles des pilotes enregistrés,
        à des fins techniques et d'organisation de la course.
    @endcheckbox

    <input type="submit" name="nextStep"
           value="Suivant" class="btn btn-primary">

    <input type="submit" name="back"
           value="Retour" class="btn btn-secondary btn-sm">
</form>
@endsection
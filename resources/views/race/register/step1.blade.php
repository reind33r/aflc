@extends('app')

@section('title')
Étape 1 - Capitaine de l'équipe
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 1,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
])

<p>
    Le capitaine d'équipe est la personne qui gère l'inscription.<br>
    <strong>Elle ne participe pas forcément à la course comme pilote.</strong>
</p>

@guest
<div class="row">
    <div class="col-md-6 col-lg-4 mb-2">
        <h3>J'ai déjà un compte</h3>

        @include('auth._login_form')
    </div>
    <div class="col-md-6 col-lg-8">
        <h3>Je n'ai pas encore de compte</h3>

        <p>
            Afin de s'inscrire à la course, il faut disposer d'un compte utilisateur
            sur notre site.
        </p>

        <p>
            @component('components.popup_link', [
                'href' => route('register'),
                'class' => 'btn btn-primary',
            ])
            Je crée mon compte en 1 minute
            @endcomponent
        </p>
    </div>
</div>
@else
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    <p>
        Tu es connecté en tant que <strong>{{ Auth::user()->full_name }}</strong> ({{ Auth::user()->email }}).
    
        <button type="submit" class="btn btn-sm btn-warning">Ce n'est pas moi ! Changer de compte</button>
    </p>
    @csrf
</form>

<h3>Vérification de mes informations personnelles</h3>

<p>
    Nous utilisons ces informations pour te communiquer les informations relatives
    à la course. Elles ne seront en aucun cas communiquées à des tiers sans
    ton autorisation.
</p>

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="1">

    <div class="row">
        <div class="col-md-2">
            @select([
                'name' => 'honorific_prefix',
                'autocomplete' => 'honorific-prefix',
                'options' => [
                    'm' => 'M.',
                    'mme' => 'Mme.',
                    'autre' => 'Autre',
                ],
                'required' => True,
                'initial' => $registration_form_data->get('captain_honorific_prefix'),
            ])
            Civilité
            @endselect
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'first_name',
                'autocomplete' => 'given-name',
                'required' => True,
                'initial' => $registration_form_data->get('captain_first_name'),
            ])
            Prénom
            @endinput
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'last_name',
                'autocomplete' => 'family-name',
                'required' => True,
                'initial' => $registration_form_data->get('captain_last_name'),
            ])
            Nom de famille
            @endinput
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            @input([
                'name' => 'email',
                'type' => 'email',
                'autocomplete' => 'email',
                'required' => True,
                'initial' => $registration_form_data->get('captain_email'),
            ])
            Adresse email
            @endinput
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'mobile_phone',
                'type' => 'tel',
                'autocomplete' => 'tel-national',
                'required' => True, 
                'initial' => $registration_form_data->get('captain_mobile_phone'),
            ])
            Numéro de téléphone portable
            @endinput
        </div>
    </div>

    @textarea([
        'name' => 'address',
        'autocomplete' => 'street-address',
        'required' => True,
        'initial' => $registration_form_data->get('captain_address'),
    ])
    Adresse
    @endtextarea

    <div class="row">
        <div class="col-sm-3">
            @input([
                'name' => 'zip_code',
                'type' => 'text',
                'autocomplete' => 'postal-code',
                'required' => True,
                'initial' => $registration_form_data->get('captain_zip_code'),
            ])
            Code postal
            @endinput
        </div>

        <div class="col-sm-9">
            @input([
                'name' => 'city',
                'type' => 'tel',
                'autocomplete' => 'address-level2',
                'required' => True,
                'initial' => $registration_form_data->get('captain_city'),
            ])
            Ville
            @endinput
        </div>
    </div>

    <input type="submit" name="nextStep"
           value="Suivant" class="btn btn-primary">

    <input type="submit" name="back"
           value="Retour" class="btn btn-secondary btn-sm">
</form>
@endguest
@endsection
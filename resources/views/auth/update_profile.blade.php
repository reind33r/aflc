@extends('app')

@section('title')
Mettre à jour mon profil
@endsection

@section('content')
<h1>Mettre à jour mon profil</h1>

<p>
    Nous utilisons ces informations pour te communiquer les informations relatives
    à la course. Elles ne seront en aucun cas communiquées à des tiers sans
    ton autorisation.
</p>

<form method="POST" action="{{ route('auth.update_profile') }}">
    @csrf

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
                'initial' => $user->honorific_prefix,
            ])
            Civilité
            @endselect
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'first_name',
                'autocomplete' => 'given-name',
                'required' => True,
                'initial' => $user->first_name,
            ])
            Prénom
            @endinput
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'last_name',
                'autocomplete' => 'family-name',
                'required' => True,
                'initial' => $user->last_name,
            ])
            Nom de famille
            @endinput
        </div>
    </div>

    @input([
        'name' => 'birthday',
        'type' => 'date',
        'required' => $user->teams_as_pilot()->count() > 0,
        'initial' => $user->birthday ? $user->birthday->format('Y-m-d') : '',
    ])
    Date de naissance
    @endinput

    <div class="row">
        <div class="col-md-7">
            @input([
                'name' => 'email',
                'type' => 'email',
                'autocomplete' => 'email',
                'required' => True,
                'initial' => $user->email,
            ])
            Adresse email
            @endinput
        </div>

        <div class="col-md-5">
            @input([
                'name' => 'mobile_phone',
                'type' => 'tel',
                'autocomplete' => 'tel-national',
                'required' => $user->teams()->count() > 0,
                'initial' => ($user->contact_info) ? $user->contact_info->mobile_phone : '',
            ])
            Numéro de téléphone portable
            @endinput
        </div>
    </div>

    @textarea([
        'name' => 'address',
        'autocomplete' => 'street-address',
        'required' => $user->teams()->count() > 0,
        'initial' => ($user->contact_info) ? $user->contact_info->address : '',
    ])
    Adresse
    @endtextarea

    <div class="row">
        <div class="col-sm-3">
            @input([
                'name' => 'zip_code',
                'type' => 'text',
                'autocomplete' => 'postal-code',
                'required' => $user->teams()->count() > 0,
                'initial' => ($user->contact_info) ? $user->contact_info->zip_code : '',
            ])
            Code postal
            @endinput
        </div>

        <div class="col-sm-9">
            @input([
                'name' => 'city',
                'type' => 'tel',
                'autocomplete' => 'address-level2',
                'required' => $user->teams()->count() > 0,
                'initial' => ($user->contact_info) ? $user->contact_info->city : '',
            ])
            Ville
            @endinput
        </div>
    </div>

    <button class="btn btn-primary" type="submit">Mettre à jour</button>
</form>
@endsection
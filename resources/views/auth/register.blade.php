@extends('app')

@section('content')
<h1>Inscription</h1>

<div class="row">
    <div class="col-md-8 col-lg-6 mb-2">
        <form method="POST" action="{{ route('register') }}">
            @csrf
        
            @input([
                'label' => '',
                'name' => 'email',
                'type' => 'email',
                'autofocus' => True,
                'autocomplete' => 'email',
            ])
            Adresse email
            @endinput

            <div class="row">
                <div class="col-md-6">
                    @input([
                        'label' => '',
                        'name' => 'first_name',
                        'autocomplete' => 'given-name',
                    ])
                    Prénom
                    @endinput
                </div>
    
                <div class="col-md-6">
                    @input([
                        'label' => '',
                        'name' => 'last_name',
                        'autocomplete' => 'family-name',
                    ])
                    Nom de famille
                    @endinput
                </div>
            </div>

            @input([
                'label' => '',
                'name' => 'password',
                'type' => 'password',
                'autocomplete' => 'new-password',
            ])
            Mot de passe
            @endinput

            @input([
                'label' => '',
                'name' => 'password_confirmation',
                'type' => 'password',
                'autocomplete' => 'new-password',
            ])
            Mot de passe (confirmation)
            @endinput

            @checkbox([
                'name' => 'rgpd',
                'required' => True,
            ])
            @slot('label')
            J'autorise a-fond-la-caisse.com à stocker mes données personnelles à des fins techniques et d'organisation de la course, et à me contacter ponctuellement selon mes préférences.
            @endslot
            @slot('help_text')
            <a href="#">Plus d'informations</a>
            @endslot
            @endcheckbox

            <button type="submit" class="btn btn-primary">Inscription</button>
            <a href="{{ route('password.request') }}" class="btn btn-sm btn-warning">Mot de passe oublié</a>
        </form>
    </div>
    <div class="col-md-4 col-lg-6">
        <p>
            Si tu as déjà un compte, tu peux <a href="{{ route('login') }}">te connecter</a>.
        </p>
        @if(session()->has('previous_url'))
        <p>
            <a href="{{ session()->get('previous_url') }}" class="btn btn-sm btn-secondary">Retour</a>
        </p>
        @endif
    </div>
</div>
@endsection
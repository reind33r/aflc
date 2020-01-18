@extends('app')

@section('content')
<h1>Connexion</h1>

<div class="row">
    <div class="col-md-6 col-lg-4 mb-2">
        <form method="POST" action="{{ route('login') }}">
            @csrf
        
            @input([
                'name' => 'email',
                'type' => 'email',
                'autofocus' => True,
                'autocomplete' => 'email',
            ])
            Adresse email
            @endinput

            @input([
                'name' => 'password',
                'type' => 'password',
                'autocomplete' => 'current-password',
            ])
            Mot de passe
            @endinput

            @checkbox([
                'label' => 'Rester connecté',
                'name' => 'remember',
                'help_text' => 'Ne pas cocher cette case sur un ordinateur partagé.',
            ])
            @endcheckbox

            <button type="submit" class="btn btn-primary">Connexion</button>
            <a href="{{ route('password.request') }}" class="btn btn-sm btn-warning">Mot de passe oublié</a>
        </form>
    </div>
    <div class="col-md-6 col-lg-8">
        <p>
            Si tu n'as pas encore de compte, tu peux <a href="{{ route('register') }}">t'inscrire</a>.
        </p>
    </div>
</div>
@endsection

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
        'name' => 'remember',
        'help_text' => 'Ne pas cocher cette case sur un ordinateur partagé.',
    ])
    Rester connecté
    @endcheckbox

    <button type="submit" class="btn btn-primary">Connexion</button>
    <a href="{{ route('password.request') }}" class="btn btn-sm btn-warning">Mot de passe oublié</a>
</form>
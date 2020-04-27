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
    J'autorise a-fond-la-caisse.com à stocker mes données personnelles à des fins techniques et d'organisation de la course, et à me contacter ponctuellement selon mes préférences.
    @slot('help_text')
    <a target="_blank" href="#">Plus d'informations</a>
    @endslot
    @endcheckbox

    <button type="submit" class="btn btn-primary">Inscription</button>
    <a href="{{ route('password.request') }}" class="btn btn-sm btn-warning">Mot de passe oublié</a>
</form>
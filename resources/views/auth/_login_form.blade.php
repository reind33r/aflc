<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-group">
        <label for="login">Nom d'utilisateur ou adresse email</label>
        <input type="text" name="login" id="login" value="{{ old('username') ?: old('email') }}"
            class="form-control @if($errors->has('username') or $errors->has('email')) is-invalid @endif"
            required autofocus autocomplete="email"
        >
    
        @error('username')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
        @error('email')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

        @isset($help_text)
        <small class="form-text text-muted">{{ $help_text }}</small>
        @endisset
    </div>

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
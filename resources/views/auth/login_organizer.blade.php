@extends('app')

@section('content')
<h1>Connexion à l'espace organisateur</h1>

<p class="alert alert-warning">
    Cet espace est destiné aux organisateurs des courses. Si tu es inscrit
    à une course (comme participant ou bénévole),
    <a href="{{ route('login') }}">connecte-toi ici</a>.
</p>

<div class="row">
    <div class="col-md-6 col-lg-4 mb-2">
        <form method="POST" action="{{ route('login') }}" class="bg-warning p-3">
            @csrf

            <input type="hidden" name="guard" value="organizer">
        
            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="form-control @error('email') is-invalid @enderror"
                    required autofocus autocomplete="email"
                >
                @error('email')
                <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </div>
                @enderror
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
    </div>
    <div class="col-md-6 col-lg-8">
    </div>
</div>
@endsection
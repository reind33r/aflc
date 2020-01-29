@extends('app')

@section('title')
Étape 1 - Capitaine de l'équipe
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 1,
    'user_progress' => 3, // TODO: from controller
    'has_error' => false, // TODO: from controller
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
            <a href="{{ route('register') }}" class="btn btn-primary">Je crée mon compte en 1 minute</a>
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


@endguest
@endsection
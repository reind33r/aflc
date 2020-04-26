{{-- NOT ACTUALLY A REGISTER VIEW, team data is already saved in database --}}

@extends('app')

@section('title')
Étape 5 - Paiement
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 5,
    'user_progress' => 5,
    'has_error' => false, // TODO
])

<p>
    Le paiement en ligne n'est pas encore disponible.
</p>


<h5>Note de l'organisateur</h5>

<p>
    {!! nl2br(e('À venir...')) !!}
</p>

<a href="{{ route('race.myteam') }}" class="btn btn-primary">Valider</a>
@endsection
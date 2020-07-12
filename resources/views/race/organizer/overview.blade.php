@extends('app')

@section('title')
Organisation de la course
@endsection

@section('content')
<h1>Organisation de la course</h1>

<p>
    Choisis l'espace auquel tu souhaites accéder :
</p>

<nav class="row justify-content-around align-items-center">
    <a href="{{ route('race.organizer.registrations') }}" class="btn btn-warning btn-lg">
        Inscriptions<br>
        <small>Dossiers et paiements</small>
    </a>
    <a href="{{ route('cms.organizer') }}" class="btn btn-success btn-lg">
        Gestion du site<br>
        <small>Pages et menus</small>
    </a>
    <a href="{{ route('race.organizer.configuration') }}" class="btn btn-info btn-lg">
        Configuration
    </a>
</nav>
@endsection
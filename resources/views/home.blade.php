@extends('app')

@section('title')
À fond la caisse
@endsection

@section('content')
<div class="jumbotron">
    <h1 class="display-4">Bienvenue</h1>

    <p>
        À fond la caisse est une application de gestion de <strong>courses de caisses à savon</strong>
        développée par <a target="_blank" href="https://louis.hostux.fr">Louis Guidez</a>.
    </p>
</div>

<p>
    Ils nous font confiance :
</p>

<div class="row">
    <div class="col-md">
        <div class="card text-center" style="width: 18rem;">
            <img src="/img/temp/tancarville_en_fete.png" alt="Logo de l'association" class="card-img-top" style="margin: auto; max-width: 15em;">
            <div class="card-body">
                <h5 class="card-title">Tancarville en Fête</h5>

                <p class="card-text">

                </p>

                <a href="https://tancarville.a-fond-la-caisse.com" class="btn btn-primary">Accéder au site</a>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- NOT ACTUALLY A REGISTER VIEW, team data is already saved in database --}}

@extends('app')

@section('title')
Étape 5 - Paiement
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 5,
    'user_progress' => 5,
    'has_error' => False,
])

<div class="card mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-6 col-md-3">Rappel du tarif choisi</dt>
            <dd class="col-sm-6 col-md-9">
                {{ $team->registration_opportunity->description }}
            </dd>
        </dl>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Quantité</th>
            <th>Tarif unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Frais d'inscription fixes</th>
            <td>1</td>
            <td>@currency($team->registration_opportunity->fee_per_team)</td>
            <td>@currency($team->registration_opportunity->fee_per_team)</td>
        </tr>
        <tr>
            <th>Pilotes</th>
            <td>{{ $team->pilotCount }}</td>
            <td>@currency($team->registration_opportunity->fee_per_pilot)</td>
            <td>@currency($team->pilotCount * $team->registration_opportunity->fee_per_pilot)</td>
        </tr>
        <tr>
            <th>Caisses à savon</th>
            <td>{{ $team->soapboxCount }}</td>
            <td>@currency($team->registration_opportunity->fee_per_soapbox)</td>
            <td>@currency($team->soapboxCount * $team->registration_opportunity->fee_per_soapbox)</td>
        </tr>
    </tbody>
    <tfoot class="lead">
        <tr>
            <th colspan="3">Total</th>
            <td class="font-weight-bold">
                @currency(
                    $team->registration_opportunity->fee_per_team +
                    $team->pilotCount * $team->registration_opportunity->fee_per_pilot +
                    $team->soapboxCount * $team->registration_opportunity->fee_per_soapbox
                )
            </td>
        </tr>
    </tfoot>
</table>

<p>
    Le paiement en ligne n'est pas encore disponible.
</p>

<div class="card mb-5">
    <div class="card-body">
        <h5 class="card-title">Commentaires de l'organisateur concernant le paiement</h5>

        @linebreaks($team->registration_opportunity->comment_on_payment)
    </div>
</div>

<a href="{{ route('race.myteam') }}" class="btn btn-primary">OK</a>
@endsection
{{-- Course verrouillée : aucune modification --}}
{{-- Item validé : modification possible sur débloquage --}}

@extends('app')

@section('title')
Facture
@endsection

@section('content')
<h1>Facture</h1>

<p>
    <a href="{{ route('race.myteam') }}" class="btn btn-secondary">Retour</a>
</p>

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
                @currency($team->totalFee)
            </td>
        </tr>
    </tfoot>
</table>

<h4>Paiements reçus</h4>

@if($team->payments->count())
<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Montant</th>
            <th>Commentaire</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($team->payments as $payment)
        <tr>
            <td>
                @human_date($payment->payment_date)
            </td>
            <td>
                @currency($payment->amount)
            </td>
            <td>
                @linebreaks($payment->comment)
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>
    <em>Aucun paiement enregistré</em>
</p>
@endif

<div class="card mb-2">
    <div class="card-body">
        <h4 class="card-title">Remarques</h4>

        <dl class="row mb-0">
            <dt class="col-sm-6 col-md-4">Tarif choisi</dt>
            <dd class="col-sm-6 col-md-8">
                {{ $team->registration_opportunity->description }}
            </dd>
            <dt class="col-sm-6 col-md-4">Commentaire de l'organisateur</dt>
            <dd class="col-sm-6 col-md-8 mb-0">
                @linebreaks($team->registration_opportunity->comment_on_payment ?? 'Aucun commentaire')
            </dd>
        </dl>
    </div>
</div>
@endsection
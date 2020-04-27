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

{{-- <table class="table table-sm">
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
            <td>@currency($ro->fee_per_team)</td>
            <td>@currency($ro->fee_per_team)</td>
        </tr>
        <tr>
            <th>Pilotes</th>
            <td>{{ (count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) }}</td>
            <td>@currency($ro->fee_per_pilot)</td>
            <td>@currency((count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) * $ro->fee_per_pilot)</td>
        </tr>
        <tr>
            <th>Caisses à savon</th>
            <td>{{ count($registration_form_data->get('soapboxes')) }}</td>
            <td>@currency($ro->fee_per_soapbox)</td>
            <td>@currency(count($registration_form_data->get('soapboxes')) * $ro->fee_per_soapbox)</td>
        </tr>
    </tbody>
    <tfoot class="lead">
        <tr>
            <th colspan="3">Total</th>
            <td class="font-weight-bold">
                @currency(
                    $ro->fee_per_team +
                    (count($registration_form_data->get('pilots')) +  ($registration_form_data->get('captain_is_pilot') ? 1 : 0)) * $ro->fee_per_pilot +
                    count($registration_form_data->get('soapboxes')) * $ro->fee_per_soapbox
                )
            </td>
        </tr>
    </tfoot>
</table> --}}

<p>
    Le paiement en ligne n'est pas encore disponible.
</p>

<p>
    {!! nl2br(e('À venir...')) !!}
</p>

<a href="{{ route('race.myteam') }}" class="btn btn-primary">Valider</a>
@endsection
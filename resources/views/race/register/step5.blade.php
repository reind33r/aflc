@extends('app')

@section('title')
Étape 4 - Paiement
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 5,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
])

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="5">

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
                <th>Frais de dossier</th>
                <td>1</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Pilotes</th>
                <td>{{ count($registration_form_data->get('pilots')) }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>Caisses à savon</th>
                <td>{{ count($registration_form_data->get('soapboxes')) }}</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <p>
        Le paiement en ligne n'est pas encore disponible.
    </p>

    <h5>Note de l'organisateur</h5>

    <p>
        {!! nl2br(e('À venir...')) !!}
    </p>

    <input type="submit" name="nextStep"
           value="Valider l'inscription" class="btn btn-primary">

    <input type="submit" name="back"
           value="Retour" class="btn btn-secondary btn-sm">
</form>
@endsection
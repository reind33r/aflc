@extends('app')

@section('title')
Gestion des inscriptions
@endsection

@section('content')
<h1>Gestion des inscriptions</h1>

<p>
    <a href="{{ route('race.organizer') }}" class="btn btn-secondary">Retour</a>
</p>

<table class="table">
    <thead>
        <tr>
            <th>Nom de l'équipe</th>
            <th>Pilotes</th>
            <th>Caisses à savon</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($teams as $team)
        <tr>
            <td>
                {{ $team->name }}
            </td>
            <td>
                <ul>
                    @foreach ($team->team_pilots as $t_pilot)
                    <li>{{ $t_pilot->pilot->first_name }}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach ($team->team_soapboxes as $t_soapbox)
                    <li>{{ $t_soapbox->soapbox->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3">Aucune équipe enregistrée.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
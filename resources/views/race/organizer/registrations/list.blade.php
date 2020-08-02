@extends('app')

@section('title')
Gestion des inscriptions
@endsection

@section('content')
<h1>Gestion des inscriptions</h1>

<p>
    <a href="{{ route('race.organizer') }}" class="btn btn-secondary">Retour</a>
</p>

<div id="vue_app">
    {{-- <form onsubmit="return false;">
        <input  type="text" name="file_number" id="search_file_number"
                placeholder="Rechercher un numéro de dossier, un pilote, ..."
                class="form-control text-center h4"
                autofocus
        >
    </form>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom de l'équipe</th>
                <th>Pilotes</th>
                <th>Caisses à savon</th>
                <th>Paiements</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teams as $team)
            <tr>
                <td>
                    <a target="_blank" href="{{ route('race.organizer.registrations.detail', ['file_number' => $team->file_number]) }}">{{ $team->file_number }}</a>
                </td>
                <td>
                    {{ $team->name }}
                </td>
                <td>
                    <ul>
                        @foreach ($team->team_pilots as $t_pilot)
                        <li>
                            {{ $t_pilot->pilot->fullName }}
                            @if($t_pilot->validated)
                            <i class="fas fa-check-circle text-success"></i>
                            @endif
                            @if(!$t_pilot->validated || !$t_pilot->allDocumentsValid())
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <ul>
                        @foreach ($team->team_soapboxes as $t_soapbox)
                        <li>
                            {{ $t_soapbox->soapbox->name }}
    
                            @if($t_soapbox->validated)
                            <i class="fas fa-check-circle text-success"></i>
                            @else
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    @if($team->payments()->sum('amount') == $team->totalFee)
                    <i class="fas fa-check-circle text-success"></i>
                    @elseif($team->payments()->sum('amount') < $team->totalFee)
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    @else
                    <i class="fas fa-exclamation-circle text-danger"></i>
                    @endif
    
                    @currency($team->payments()->sum('amount')) reçus / @currency($team->totalFee)
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Aucune équipe enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
    </table> --}}
    <registrations-list
        v-bind:teams="teams"
        v-bind:team_detail_uri="team_detail_uri"
    >
    </registrations-list>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
const app = new Vue({
    el: '#vue_app',
    data() {
        return {
            teams: [
                @foreach($teams as $team)
                {!! json_encode([
                    'id' => $team->id,
                    'name' => $team->name,
                    'file_number' => $team->file_number,
                    'pilots' => call_user_func(function () use($team) {
                        $pilots = [];
                        foreach($team->team_pilots as $t_pilot) {
                            $pilots[] = [
                                'id' => $t_pilot->pilot->id,
                                'fullName' => $t_pilot->pilot->fullName,
                                'allDocumentsValid' => $t_pilot->allDocumentsValid(),
                                'validated' => $t_pilot->validated
                            ];
                        }
                        return $pilots;
                    }),
                    'soapboxes' => call_user_func(function () use($team) {
                        $soapboxes = [];
                        foreach($team->team_soapboxes as $t_soapbox) {
                            $soapboxes[] = [
                                'id' => $t_soapbox->soapbox->id,
                                'name' => $t_soapbox->soapbox->name,
                                'validated' => $t_soapbox->validated
                            ];
                        }
                        return $soapboxes;
                    }),
                    'payment_received' => $team->payments()->sum('amount'),
                    'total_fee' => $team->totalFee,
                ]) !!},
                @endforeach
            ],
            team_detail_uri: '{{ route('race.organizer.registrations.detail', ['file_number' => '__FILE_NUMBER__']) }}',
        }
    }
});
</script>
@endpush

{{-- 
    Pilot: fullName, allDocumentsValid, validated
    Soapbox: name, validated
    Payment: amount, totalFee, amountCurrency, totalFeeCurrency --}}
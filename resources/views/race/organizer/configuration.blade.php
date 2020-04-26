@extends('app')

@section('title')
Configuration
@endsection

@section('content')
<h1>Configuration</h1>

<div class="row">
    <div class="col-md">
        <div class="card mb-2">
            <div class="card-body">
                <h3 class="card-title">Informations sur la course</h3>


                <form method="POST" action="{{ route('race.organizer.configuration.handleRaceInfo') }}">
                    @csrf

                    @input([
                        'name' => 'name',
                        'type' => 'text',
                        'required' => True,
                        'help_text' => 'Ce nom est affiché en haut de toutes les pages du site',
                        'initial' => $race->name,
                    ])
                    Nom de l'évènement
                    @endinput

                    <div class="row">
                        <div class="col-lg-6">
                            @input([
                                'name' => 'location',
                                'type' => 'text',
                                'required' => True,
                                'initial' => $race->location,
                            ])
                            Lieu de la course
                            @endinput
                        </div>
    
                        <div class="col-lg-6">
                            @input([
                                'name' => 'date',
                                'type' => 'date',
                                'required' => True,
                                'initial' => $race->date->format('Y-m-d'),
                            ])
                            Date
                            @endinput
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-2">
            <div class="card-body">
                <h3 class="card-title">Opportunités d'inscription</h3>

                <p>
                    Il est possible de définir plusieurs périodes d'inscription,
                    ou encore plusieurs tarifs.
                </p>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Dates d'ouverture</th>
                            <th>Tarifs et limites</th>
                            <th><i class="far fa-edit"></i> <i class="far fa-trash-alt"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($race->registration_opportunities as $ro)
                        <tr>
                            <td>{{ $ro->description }}</td>
                            <td>
                                @if($ro->from == null && $ro->to == null)
                                Jusqu'à la course
                                @elseif($ro->from == null)
                                Jusqu'au <strong>@human_date($ro->to, 'long', 'short')</strong>
                                @elseif($ro->to == null)
                                À partir du <strong>@human_date($ro->from, 'long', 'short')</strong>
                                @else
                                Du <strong>@human_date($ro->from, 'long', 'short')</strong><br>
                                au <strong>@human_date($ro->to, 'long', 'short')</strong>
                                @endif

                                <hr>
                                @if($ro->teasing)
                                <span class="text-warning">Afficher en dehors de la période d'ouverture</span>
                                @else
                                Ne pas afficher en dehors de la période d'ouverture
                                @endif
                            </td>
                            <td>
                                @currency($ro->fee_per_team) / équipe (limite : {{ $ro->team_limit ?? '∞' }})<br>
                                @currency($ro->fee_per_pilot) / pilote (limite : {{ $ro->pilot_limit ?? '∞' }})<br>
                                @currency($ro->fee_per_soapbox) / caisse à savon (limite : {{ $ro->soapbox_limit ?? '∞' }})
                                <hr>
                                @if($ro->soft_limits)
                                <span class="text-danger">
                                    Les inscriptions sont encore possibles après
                                    qu'une des limites est atteinte.
                                </span>
                                @else
                                <span class="text-warning">
                                    Les inscriptions sont automatiquement fermées dès
                                    que l'une des limites est atteinte.
                                </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('race.organizer.ro.edit', ['id' => $ro->id]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                                @unless($ro->teams()->count())
                                <a href="{{ route('race.organizer.ro.delete', ['id' => $ro->id]) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        <tr class="text-center">
                            <td colspan="4"><a href="{{ route('race.organizer.ro.new') }}" class="btn btn-success">Nouvelle opportunité</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
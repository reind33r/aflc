@extends('app')

@section('title')
Configuration
@endsection

@section('content')
<h1>Configuration</h1>

<p>
    <a href="{{ route('race.organizer') }}" class="btn btn-secondary">Retour</a>
</p>

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
    <div class="col-md">
        <div class="card mb-2">
            <div class="card-body">
                <h3 class="card-title">Documents requis pour les pilotes</h3>

                <ul>
                    @forelse($race->pilotDocuments as $pd)
                    <li>
                        {{ $pd->description }}
                        <strong>[@lang('keys.'.$pd->type)]</strong>
                        <br>
                        @if($pd->type == 'template')
                        <a href="{{ route('race.organizer.pd.download', ['id'=>$pd->id]) }}">Télécharger</a> –
                        @endif
                        <a href="{{ route('race.organizer.pd.edit', ['id'=>$pd->id]) }}">Modifier</a>
                        –
                        <a class="text-danger" href="{{ route('race.organizer.pd.delete', ['id'=>$pd->id]) }}">Supprimer</a>
                    </li>
                    @empty
                        
                    @endforelse
                </ul>

                <p>
                    <a href="{{ route('race.organizer.pd.new') }}" class="btn btn-success">Ajouter un document</a>
                </p>
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

                <p>
                    <a href="{{ route('race.organizer.ro.new') }}" class="btn btn-success">Nouvelle opportunité</a>
                </p>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Dates d'ouverture</th>
                            <th>Teasing</th>
                            <th>Tarifs</th>
                            <th>Limites</th>
                            <th></th>
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
                            </td>
                            <td>
                                @if($ro->teasing)
                                <i class="far fa-check-circle text-success"></i>
                                @else
                                <i class="far fa-times-circle text-danger"></i>
                                @endif
                            </td>
                            <td>
                                @currency($ro->fee_per_team) / équipe
                                @currency($ro->fee_per_pilot) / pilote
                                @currency($ro->fee_per_soapbox) / caisse à savon
                                <hr>
                                @linebreaks($ro->comment_on_payment ?? 'Aucun commentaire...')
                            </td>
                            <td>
                                Équipes : {{ $ro->team_limit ?? '∞' }}<br>
                                Pilotes : {{ $ro->pilot_limit ?? '∞' }}<br>
                                Caisses à savon : {{ $ro->soapbox_limit ?? '∞' }}
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
                    </tbody>
                </table>

                {{-- <div class="row">
                    @foreach ($race->registration_opportunities as $ro)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ro->description }}</h5>
    
                                <dl class="row">
                                    <dt class="col-sm-6 col-md-4">Dates d'ouverture</dt>
                                    <dd class="col-sm-6 col-md-8">
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
                                    </dd>


                                    <dt class="col-sm-6 col-md-4">Tarifs et limites</dt>
                                    <dd class="col-sm-6 col-md-8">
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
                                    </dd>


                                    <dt class="col-sm-6 col-md-4">Commentaire concernant le paiement</dt>
                                    <dd class="col-sm-6 col-md-8">
                                        @linebreaks($ro->comment_on_payment ?? 'Aucun commentaire...')
                                    </dd>
                                </dl>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('race.organizer.ro.edit', ['id' => $ro->id]) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Modifier</a>
                                @unless($ro->teams()->count())
                                <a href="{{ route('race.organizer.ro.delete', ['id' => $ro->id]) }}" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
{{-- Course verrouillée : aucune modification --}}
{{-- Item validé : modification possible sur débloquage --}}

@extends('app')

@section('title')
Mon équipe
@endsection

@section('content')
<div class="jumbotron p-3 p-md-5 rounded @lang('css.jumbotron-'.$team->status)">
    <h1 class="font-italic">Mon équipe</h1>

    <dl class="row mb-0">
        <dt class="col-sm-6 col-md-3">Nom de l'équipe</dt>
        <dd class="col-sm-6 col-md-9">
            {{ $team->name }}
        </dd>
    
        <dt class="col-sm-6 col-md-3">Statut</dt>
        <dd class="col-sm-6 col-md-9">
            @lang('keys.' . $team->status)
        </dd>
    </dl>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>Commentaires</h3>

        <p class="font-italic">
            {{ $team->html_team_comments ?? 'Aucun commentaire.' }}
        </p>
    </div>
    <div class="col-md-6">
        <h3>Commentaires de l'organisateur</h3>

        <p class="font-italic">
            {{ $team->html_organizer_comments ?? 'Aucun commentaire.' }}
        </p>
    </div>
</div>

@if($race->locked)
<p class="alert alert-info">
    Les organisateurs ont verrouillé la course. Il n'est plus possible d'apporter
    des modifications à ton inscription.
</p>
@endif

<div class="row">
    <div class="col-lg-6">
        <h3>Capitaine</h3>
        
        <p>
            Merci de tenir ces informations à jour, afin que nous puissions te communiquer
            les informations relatives à la course.
        </p>
        
        <dl class="row">
            <dt class="col-sm-6 col-md-3">Nom</dt>
            <dd class="col-sm-6 col-md-9">
                @lang('keys.' . $team->captain->honorific_prefix)
                {{ $team->captain->first_name }}
                {{ $team->captain->last_name }}
            </dd>
          
            <dt class="col-sm-6 col-md-3">Informations de contact</dt>
            <dd class="col-sm-6 col-md-9">
                {{ $team->captain->email }}
                <br>
                @phone($team->captain->contact_info->mobile_phone)
            </dd>
          
            <dt class="col-sm-6 col-md-3">Adresse postale</dt>
            <dd class="col-sm-6 col-md-9">
                {!! nl2br(e($team->captain->contact_info->address)) !!}
                <br>
                {{ $team->captain->contact_info->zip_code }}
                {{ $team->captain->contact_info->city }}
            </dd>
        </dl>
        
        <p>
            @component('components.popup_link', [
                'href' => route('auth.update_profile'),
                'class' => 'btn btn-primary btn-sm',
            ])
            Mettre à jour
            @endcomponent
        </p>
    </div>
    <div class="col-lg-6">
        <h3>Paiement</h3>

        <p>
            @if($team->payments()->sum('amount') == $team->totalFee)
            <i class="fas fa-check-circle text-success"></i>
            @elseif($team->payments()->sum('amount') < $team->totalFee)
            <i class="fas fa-exclamation-triangle text-warning"></i>
            @else
            <i class="fas fa-exclamation-circle text-danger"></i>
            @endif
            @currency($team->payments()->sum('amount')) reçus sur @currency($team->totalFee)
            <br>
            <a href="{{ route('race.myteam.invoice') }}" class="btn btn-primary btn-sm">Détails</a>
        </p>

        @if($team->payments()->sum('amount') > $team->totalFee)
        <p class="alert alert-danger">
            Contacte un organisateur pour régulariser la situation.
        </p>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h3>Pilotes</h3>

        @foreach ($team->team_pilots as $t_pilot)
        <div class="card mb-2 @if($t_pilot->validated) bg-success @endif">
            <div class="card-body">
                @unless($race->locked)
                @unless($t_pilot->validated)
                <a href="" class="card-d-onhover float-right btn btn-danger btn-sm ml-1">Supprimer</a>
                @endif
                
                <a href="" class="card-d-onhover float-right btn btn-primary btn-sm">Modifier</a>
                @endif

                <h5 class="card-title">
                    @lang('keys.' . $t_pilot->pilot->honorific_prefix)
                    {{ $t_pilot->pilot->first_name }}
                    {{ $t_pilot->pilot->last_name }}
                </h5>

                <p>
                    Né@if($t_pilot->pilot->honorific_prefix == 'mme')e @endif
                    le @human_date($t_pilot->pilot->birthday)
                </p>

                @if($race->pilotDocuments()->count())
                <table class="table table-bordered bg-white table-sm">
                    <thead>
                        <tr>
                            <th>Documents</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($race->pilotDocuments as $pd)
                        <tr>
                            <td>
                                @if($pd->type == 'template')
                                <a href="{{ route('race.myteam.pd_download', ['pilot_document_id'=>$pd->id, 'user_id' => $t_pilot->user_id]) }}">
                                @endif
                                {{ $pd->description }}
                                @if($pd->type == 'template')
                                </a>
                                @endif
                            </td>
                            <td>
                                @if($t_pilot->isDocumentValid($pd))
                                <i class="fas fa-check-circle text-success"></i> Reçu
                                @else
                                <i class="fas fa-exclamation-triangle text-warning"></i> En attente
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-6">
        <h3>Caisses à savon</h3>

        @foreach ($team->team_soapboxes as $t_soapbox)
        <div class="card mb-2 @if($t_soapbox->validated) bg-success @endif">
            <div class="card-body">
                @unless($race->locked)
                @unless($t_pilot->validated)
                <a href="" class="card-d-onhover float-right btn btn-danger btn-sm ml-1">Supprimer</a>
                @endif
                
                <a href="" class="card-d-onhover float-right btn btn-primary btn-sm">Modifier</a>
                @endif

                <h5 class="card-title">
                    {{ $t_soapbox->soapbox->name }}
                </h5>

                Numéro de course désiré : {{ $t_soapbox->soapbox->desired_number ?? 'Aucun' }}
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
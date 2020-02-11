@extends('app')

@section('title')
Mon équipe
@endsection

@section('content')
<h1>Mon équipe</h1>

<dl class="row">
    <dt class="col-sm-3">Nom de l'équipe</dt>
    <dd class="col-sm-9">
        {{ $team->name }}
    </dd>
</dl>

<h3>Capitaine</h3>

<p>
    Merci de tenir ces informations à jour, afin que nous puissions te communiquer
    les informations relatives à la course.
</p>

<dl class="row">
    <dt class="col-sm-3">Nom</dt>
    <dd class="col-sm-9">
        @lang('keys.' . $team->captain->honorific_prefix)
        {{ $team->captain->first_name }}
        {{ $team->captain->last_name }}
    </dd>
  
    <dt class="col-sm-3">Informations de contact</dt>
    <dd class="col-sm-9">
        {{ $team->captain->email }}
        <br>
        @phone($team->captain->contact_info->mobile_phone)
    </dd>
  
    <dt class="col-sm-3">Adresse postale</dt>
    <dd class="col-sm-9">
        {!! nl2br(e($team->captain->contact_info->address)) !!}
        <br>
        {{ $team->captain->contact_info->zip_code }}
        {{ $team->captain->contact_info->city }}
    </dd>
</dl>

<p>
    <a href="" class="btn btn-primary btn-sm">Mettre à jour</a>
</p>

<div class="row">
    <div class="col-md-6">
        <h3>Pilotes</h3>

        @foreach ($team->team_pilots as $t_pilot)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">
                    @lang('keys.' . $t_pilot->pilot->honorific_prefix)
                    {{ $t_pilot->pilot->first_name }}
                    {{ $t_pilot->pilot->last_name }}
                </h5>

                Né@if($t_pilot->pilot->honorific_prefix == 'mme')e @endif
                le @human_date($t_pilot->pilot->birthday)
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-6">
        <h3>Caisses à savon</h3>

        @foreach ($team->team_soapboxes as $t_soapbox)
        <div class="card mb-2">
            <div class="card-body">
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
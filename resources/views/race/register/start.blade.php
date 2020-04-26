@extends('app')

@section('title')
Inscription à la course
@endsection

@section('content')
<h1>Inscription à la course</h1>

@if($race->display_registration_opportunities()->count())
<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="0">

    <div class="card mb-2">
        <div class="card-body">
            <p class="alert alert-info">
                Les organisateurs se réservent le droit de demander des justificatifs,
                le cas échéant.
            </p>

            @error('registration_opportunity_id')
            <p class="alert alert-danger">
                <strong>{{ $message }}</strong>
            </p>
            @enderror
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Choix du tarif</th>
                        <th>Ouverture</th>
                        <th>Tarifs</th>
                        <th>Nombre d'inscrits / Limite</th>
                    </tr>
                </thead>
                @foreach ($race->display_registration_opportunities as $ro)
                <tr>
                    <td>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="registration_opportunity_{{ $ro->id }}"
                                   name="registration_opportunity_id" value="{{ $ro->id }}"
                                   class="custom-control-input" @if($ro->from > now() || $ro->is_limit_reached) disabled @endif
                                   @if($registration_form_data->get('registration_opportunity_id') == $ro->id) checked @endif
                            >
                            <label class="custom-control-label" for="registration_opportunity_{{ $ro->id }}">{{ $ro->description }}</label>
                        </div>
                    </td>
                    <td>
                        @if(($ro->to == null && $ro->from <= now()) ||
                            ($ro->to == null && $ro->from == null)
                        )
                        <em>Jusqu'à la course</em>
                        @elseif($ro->from == null)
                        Jusqu'au <strong>@human_date($ro->to, 'long', 'short')</strong>
                        @elseif($ro->to == null && $ro->from > now())
                        <span class="text-warning">À partir du <strong>@human_date($ro->from, 'long', 'short')</strong></span>
                        @else
                        Du <strong>@human_date($ro->from, 'long', 'short')</strong><br>
                        au <strong>@human_date($ro->to, 'long', 'short')</strong>
                        @endif
                    </td>
                    <td>
                        @currency($ro->fee_per_team) / équipe<br>
                        @currency($ro->fee_per_pilot) / pilote<br>
                        @currency($ro->fee_per_soapbox) / caisse à savon
                    </td>
                    <td>
                        <span class="@if($ro->isTeamLimitReached)text-danger font-weight-bold @elseif($ro->isTeamLimitAlmostReached) text-warning font-weight-bold @endif">
                            {{ $ro->teams_count }} {{ Str::plural('équipe', $ro->teams_count) }} / {{ $ro->team_limit ?? '∞' }}
                        </span>
                        <br>
                        <span class="@if($ro->isPilotLimitReached)text-danger font-weight-bold @elseif($ro->isPilotLimitAlmostReached) text-warning font-weight-bold @endif">
                            {{ $ro->pilots_count }} {{ Str::plural('pilote', $ro->pilots_count) }} / {{ $ro->pilot_limit ?? '∞' }}
                        </span>
                        <br>
                        <span class="@if($ro->isSoapboxLimitReached)text-danger font-weight-bold @elseif($ro->isSoapboxLimitAlmostReached) text-warning font-weight-bold @endif">
                            {{ $ro->soapboxes_count }} {{ Str::plural('caisse', $ro->soapboxes_count) }} à savon / {{ $ro->soapbox_limit ?? '∞' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <input type="submit" name="nextStep"
           value="Commencer l'inscription" class="btn btn-primary">
</form>
@else
<p>
    Les inscriptions sont fermées.
</p>
@endif
@endsection
@extends('app')

@section('title')
Étape 2 - Pilotes
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 2,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => $errors->any(),
])

{{-- {{ dd($errors) }} --}}

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="2">

    <div class="card mb-2">
        <div class="card-body">
            @checkbox([
                'name' => 'captain_is_pilot',
                'wrap_label_tag' => 'h5',
                'checked' => $registration_form_data->get('captain_is_pilot')
            ])
                Je suis pilote
            @endcheckbox
            
            @input([
                'name' => 'captain_birthday',
                'type' => 'date',
                'required' => false,
                'initial' => $registration_form_data->get('captain_birthday') ? $registration_form_data->get('captain_birthday')->format('Y-m-d') : '',
            ])
            Date de naissance
            @endinput
        </div>
    </div>

    <h3>Autres pilotes</h3>

    @error('pilots')
    <div class="alert alert-danger">
        <strong>{{ $message }}</strong>
    </div>
    @enderror

    <div id="pilots" data-prototype="{!! htmlspecialchars(view('race.register._pilotCard', ['index' => '__INDEX__'])) !!}" data-nextIndex="{{ max(array_keys(old('pilots', [1 => 1]))) + 1 }}">
        @forelse(old('pilots', $registration_form_data->get('pilots')) as $key => $pilot)
        @include('race.register._pilotCard', ['index' => $key])
        @empty
        @unless($registration_form_data->get('captain_is_pilot'))
        @include('race.register._pilotCard', ['index' => 1])
        @endunless
        @endforelse
    </div>

    <p class="text-center">
        <button type="button" class="btn btn-success" data-action="formCollectionAdd" data-formCollection="pilots">Ajouter un pilote</button>
    </p>



    @if($race->pilotDocuments()->count())
    <div class="alert alert-info">
        <h3>Documents à renvoyer</h3>

        <p>
            Pour information, chaque pilote devra fournir les documents suivants pour que le dossier soit complet :
        </p>

        <ul>
            @foreach($race->pilotDocuments as $pd)
            <li>{{ $pd->description }}</li>    
            @endforeach
        </ul>

        <p>
            Ces informations seront rappelées ultérieurement dans le processus d'inscription.
        </p>
    </div>
    @endif

    <input type="submit" name="nextStep"
           value="Suivant" class="btn btn-primary">

    <a href="{{ route('race.register.step1') }}" class="btn btn-secondary btn-sm">Retour</a>
</form>
@endsection
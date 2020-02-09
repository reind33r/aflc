@extends('app')

@section('title')
Étape 2 - Pilotes
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 2,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
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
                'required' => True,
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

    <input type="submit" name="nextStep"
           value="Suivant" class="btn btn-primary">

    <input type="submit" name="back"
           value="Retour" class="btn btn-secondary btn-sm">
</form>
@endsection
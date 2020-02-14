@extends('app')

@section('title')
Étape 3 - Caisses à savon
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 3,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
])

{{-- {{ dd($errors) }} --}}

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="3">

    @error('soapboxes')
    <div class="alert alert-danger">
        <strong>{{ $message }}</strong>
    </div>
    @enderror

    <div id="soapboxes" data-prototype="{!! htmlspecialchars(view('race.register._soapboxCard', ['index' => '__INDEX__'])) !!}" data-nextIndex="{{ max(array_keys(old('soapboxes', [1 => 1]))) + 1 }}">
        @forelse(old('soapboxes', $registration_form_data->get('soapboxes')) as $key => $soapbox)
        @include('race.register._soapboxCard', ['index' => $key])
        @empty
        @include('race.register._soapboxCard', ['index' => 1])
        @endforelse
    </div>

    <p class="text-center">
        <button type="button" class="btn btn-success" data-action="formCollectionAdd" data-formCollection="soapboxes">Ajouter un caisse à savon</button>
    </p>

    <input type="submit" name="nextStep"
           value="Suivant" class="btn btn-primary">

    <a href="{{ route('race.register.step2') }}" class="btn btn-secondary btn-sm">Retour</a>
</form>
@endsection
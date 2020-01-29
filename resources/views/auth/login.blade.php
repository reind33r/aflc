@extends('app')

@section('content')
<h1>Connexion</h1>

<div class="row">
    <div class="col-md-6 col-lg-4 mb-2">
        @include('auth._login_form')
    </div>
    <div class="col-md-6 col-lg-8">
        <p>
            Si tu n'as pas encore de compte, tu peux <a href="{{ route('register') }}">t'inscrire</a>.
        </p>
        @if(session()->has('previous_url'))
        <p>
            <a href="{{ session()->get('previous_url') }}" class="btn btn-sm btn-secondary">Retour</a>
        </p>
        @endif
    </div>
</div>
@endsection

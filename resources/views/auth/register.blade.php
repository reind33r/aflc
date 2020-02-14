@extends('app')

@section('content')
<h1>Inscription</h1>

<div class="row">
    <div class="col-md-8 col-lg-6 mb-2">
        @include('auth._register_form')
    </div>
    <div class="col-md-4 col-lg-6">
        <p>
            Si tu as déjà un compte, tu peux <a href="{{ route('login') }}">te connecter</a>.
        </p>
        @if(session()->has('previous_url'))
        <p>
            <a href="{{--{{ session()->get('previous_url') }}--}}#" class="btn btn-sm btn-secondary" onclick="window.close();">Retour</a>
        </p>
        @endif
    </div>
</div>
@endsection
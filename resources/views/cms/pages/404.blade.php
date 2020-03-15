@extends('app')

@section('title')
Page introuvable
@endsection

@section('content')
<h1 class="text-center">
    <img src="{{ asset('img/404.svg') }}" alt="Page introuvable" style="height: 10em;">
</h1>

@if(Auth::guard('web:organizers')->check() && Auth::guard('web:organizers')->user()->can('organize', $race))
<p class="text-center">
    <a href="{{ route('cms.page.edit', ['uri' => $uri]) }}" class="btn btn-lg btn-primary">Créer la page</a>
</p>
@endif
@endsection
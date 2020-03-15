@extends('app')

@section('title')
{{ $page->title }}
@endsection

@section('content')

@if(Auth::guard('web:organizers')->check() && Auth::guard('web:organizers')->user()->can('organize', $race))
<div class="float-right">
    <a href="{{ route('cms.page.edit', ['uri' => $page->uri]) }}" class="btn btn-primary">Éditer la page</a>
</div>
@endif

{!! $page->content !!}
@endsection
@extends('app')

@section('title')
Supprimer une page
@endsection

@section('content')
<h1>Supprimer une page</h1>

<form class="alert alert-danger" method="POST" action="{{ route('cms.page.deleteAction') }}">
    @csrf
    <input type="hidden" name="uri" value="{{ $page->uri }}">

    {{ $errors }}

    <p>
        Es-tu sûr de vouloir supprimer la page "{{ $page->title }}" (située à l'adresse [/{{ $page->uri }}]) ?
    </p>

    @checkbox([
        'name' => 'confirm_delete',
        'required' => True,
    ])
    Je confirme la suppression
    @endcheckbox

    <button type="submit" class="btn btn-danger">Supprimer la page</button>
</form>

@endsection
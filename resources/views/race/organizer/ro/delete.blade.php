@extends('app')

@section('title')
Supprimer une opportunité d'inscription
@endsection

@section('content')
<h1>Supprimer une opportunité d'inscription</h1>

<form class="alert alert-danger" method="POST">
    @csrf

    <p>
        Es-tu sûr de vouloir supprimer l'opportunité d'inscription "{{ $ro->description }}" ?
    </p>

    @checkbox([
        'name' => 'confirm_delete',
        'required' => True,
    ])
    Je confirme la suppression
    @endcheckbox

    <button type="submit" class="btn btn-danger">Supprimer</button>
</form>

@endsection
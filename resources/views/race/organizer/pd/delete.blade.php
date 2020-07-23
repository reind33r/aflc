@extends('app')

@section('title')
Supprimer un document pilote
@endsection

@section('content')
<h1>Supprimer un document pilote</h1>


<form class="alert alert-danger" method="POST">
    @csrf

    <p>
        Es-tu sûr de vouloir supprimer le document pilote "{{ $pd->description }}" ?<br>
        S'il contenait une pièce jointe (modèle PDF), elle sera définitivement supprimée.
    </p>

    @if($pd->team_pilots()->count())
    <p class="font-weight-bold">
        Attention !
        Vous avez déjà reçu {{ $pd->team_pilots()->count() }} {{ Str::plural('exemplaire', $pd->team_pilots()->count()) }} de ce document.
        <br>
        Les exemplaires remplis des pilotes seront aussi définitivement supprimés.
    </p>
    @endif

    @checkbox([
        'name' => 'confirm_delete',
        'required' => True,
    ])
    Je confirme la suppression
    @endcheckbox

    <button type="submit" class="btn btn-danger">Supprimer</button>
</form>

@endsection
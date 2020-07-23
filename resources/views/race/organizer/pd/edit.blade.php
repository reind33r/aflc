@extends('app')

@section('title')
Éditer un document pilote
@endsection

@section('content')
<h1>Éditer un document pilote</h1>

<p>
    <a href="{{ route('race.organizer.configuration') }}" class="btn btn-secondary">Retour</a>
</p>

<p>
    Les pilotes auront accès à ce document dans leur espace, et pourront le renvoyer complété.
</p>

@if($pd->team_pilots()->count())
<div class="alert alert-warning">
    <h5>Documents déjà reçus !</h5>

    <p>
        Vous avez déjà reçu {{ $pd->team_pilots()->count() }} {{ Str::plural('exemplaire', $pd->team_pilots()->count()) }} de ce document.
    </p>
</div>
@endif

<form method="POST" enctype="multipart/form-data">
    @csrf

    @input([
        'name' => 'description',
        'type' => 'text',
        'required' => True,
        'help_text' => 'Nom du document : attestation d\'assurance responsabilité civile, autorisation parentale pour les mineurs, ...',
        'initial' => $pd->description
    ])
    Description
    @endinput

    @select([
        'name' => 'type',
        'options' => [
            'template' => __('keys.template'),
            'auto_template' => __('keys.auto_template'),
            'external' => __('keys.external'),
        ],
        'required' => True,
        'initial' => $pd->type
    ])
    Type
    @endselect

    @input([
        'name' => 'template_file',
        'type' => 'file',
        'required' => False
    ])
    Modèle à remplir
    @slot('help_text')
    Laisser vide pour conserver le <a href="{{ route('race.organizer.pd.download', ['id'=>$pd->id]) }}">modèle actuel</a>. Privilégier le format PDF.
    @endslot
    @endinput

    @textarea([
        'name' => 'auto_template',
        'required' => True,
        'disabled' => True,
        'help_text' => 'Fonctionnalité non disponible. Utiliser le type "Modèle à remplir" en attendant.',
        'initial' => null,
    ])
    Contenu du modèle personnalisé
    @endtextarea

    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
var select_type = document.getElementById('type');
var group_template = document.getElementById('template_file').parentNode;
var group_auto_template = document.getElementById('auto_template').parentNode;

function update_group_visibilities() {
    group_template.style.display = 'none';
    group_auto_template.style.display = 'none';

    if(select_type.value == 'template') {
        group_template.style.display = 'block';
    } else if(select_type.value == 'auto_template') {
        group_auto_template.style.display = 'block';
    }
}

select_type.addEventListener('change', function(e) {
    update_group_visibilities();
});

update_group_visibilities();
</script>
@endpush
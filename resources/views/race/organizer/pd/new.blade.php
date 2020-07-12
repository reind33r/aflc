@extends('app')

@section('title')
Nouveau document pilote
@endsection

@section('content')
<h1>Nouveau document pilote</h1>

<p>
    <a href="{{ route('race.organizer.configuration') }}" class="btn btn-secondary">Retour</a>
</p>

<p>
    Les pilotes auront accès à ce document dans leur espace, et pourront le renvoyer complété.
</p>

<form method="POST" enctype="multipart/form-data">
    @csrf

    @input([
        'name' => 'description',
        'type' => 'text',
        'required' => True,
        'help_text' => 'Nom du document : attestation d\'assurance responsabilité civile, autorisation parentale pour les mineurs, ...',
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
    ])
    Type
    @endselect

    @input([
        'name' => 'template_file',
        'type' => 'file',
        'required' => True,
        'help_text' => 'Privilégier le format PDF.'
    ])
    Modèle à remplir
    @endinput

    @textarea([
        'name' => 'auto_template',
        'required' => True,
        'disabled' => True,
        'help_text' => 'Fonctionnalité non disponible. Utiliser le type "Modèle à remplir" en attendant.'
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
@extends('app')

@section('title')
Éditer une page
@endsection

@section('content')
<h1>Éditer une page</h1>

<form method="POST" action="{{ route('cms.page.edit', ['uri' => $page->uri]) }}">
    @csrf
    
    <div class="row">
        <div class="col-md">
            @input([
                'name' => 'url',
                'type' => 'text',
                'required' => False,
                'disabled' => True,
                'initial' => route('cms.page', ['uri' => $page->uri]),
                'title' => route('cms.page', ['uri' => $page->uri]),
            ])
            Adresse de la page
            @endinput
        </div>
        <div class="col-md">
            @select([
                'name' => 'visibility',
                'required' => True,
                'initial' => $page->visibility,
                'options' => [
                    'all' => __('keys.all'),
                    'race_registered' => __('keys.race_registered'),
                    'race_not_registered' => __('keys.race_not_registered'),
                    'race_organizer' => __('keys.race_organizer'),
                ],
            ])
            Visible pour
            @endselect
        </div>
    </div>

    @input([
        'name' => 'title',
        'type' => 'text',
        'required' => True,
        'initial' => $page->title,
        'help_text' => 'Il s\'agit du titre qui s\'affichera dans l\'onglet du navigateur',
    ])
    Titre
    @endinput

    @textarea([
        'name' => 'content',
        'required' => True,
        'initial' => $page->content,
    ])
    Contenu
    @endtextarea

    <div class="mt-3">
        <button type="submit" class="btn btn-primary align-middle">Sauvegarder la page</button>
        <a href="{{ route('cms.page.delete', ['uri' => $page->uri]) }}" class="btn btn-sm btn-danger align-middle"><i class="far fa-trash-alt"></i> Supprimer</a>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/lang/summernote-fr-FR.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#content').summernote({
        placeholder: 'Renseigne le contenu de la page ici...',
        lang: 'fr-FR',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        height: 600,
    });
});
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
@endpush
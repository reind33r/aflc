@extends('app')

@section('title')
Gestion du site
@endsection

@section('content')
<h1>Gestion du site</h1>

<p>
    <a href="{{ route('race.organizer') }}" class="btn btn-secondary">Retour</a>
</p>

<div class="row">
    <div class="col-md">
        <h2>Pages</h2>

        <p class="alert alert-info">
            Pour créer ou modifier une page, rends-toi directement à
            son adresse (même si elle n'existe pas encore).
        </p>

        <p>
            Plan du site :
        </p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Adresse</th>
                    <th>Titre</th>
                    <th>Visible pour</th>
                    <th class="text-center"><i class="far fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                <tr>
                    <td>
                        <a href="{{ route('cms.page', ['uri' => $page->uri]) }}" target="_blank">/{{ $page->uri }}</a>
                    </td>
                    <td>{{ $page->title }}</td>
                    <td>
                        @lang('keys.'. $page->visibility)
                    </td>
                    <td class="text-center">
                        <a href="{{ route('cms.page.delete', ['uri' => $page->uri]) }}" class="btn btn-sm btn-link text-danger"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4"><em>Tu n'as pas encore commencé le site.</em></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="col-md">
        <h2>Menu de navigation</h2>

        <p>
            Chaque site dispose d'un unique menu, mais il est possible d'afficher
            et de cacher des éléments, en fonction du statut de l'utilisateur
            (visiteur, inscrit à la course ou pas, organisateur).
        </p>

        <p>
            <a href="{{ route('cms.menu.edit') }}" class="btn btn-primary">Modifier le menu</a>
        </p>

        {{-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Lien vers</th>
                    <th>Visible pour</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menu_items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ $item->url }}" target="_blank">{{ $item->displayUrl }}</a>
                    </td>
                    <td>
                        @lang('keys.'. $item->visibility)
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3"><em>Le menu est vide.</em></td>
                </tr>
                @endforelse
            </tbody>
        </table> --}}
    </div>
</div>
<div class="row">
    <div class="col-md">
        <h2>Gestionnaire d'images</h2>

        <div class="row">
            @foreach ($images as $i => $image)
            <div style="max-width: 15em;">
                <div class="card">
                    <div class="card-body text-center mb-0">
                        <a href="{{ asset($image) }}" target="_blank"><img src="{{ asset($image) }}" alt="Image" class="d-block mx-auto mw-100 mb-2" style="max-height: 7em;"></a>

                        @human_bytes(Storage::size($image))<br>

                        <a data-copy="copy-image-link-{{ $i }}" href="#" class="card-link">Copier le lien</a>
                        <input class="d-none" type="text" id="copy-image-link-{{ $i }}" value="{{ asset($image) }}">
                        <br>
                        <a href="#" class="card-link text-danger">Supprimer</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
document.querySelectorAll('a[data-copy]').forEach(function(link_copy) {
    link_copy.addEventListener('click', function(e) {
        e.preventDefault();

        var el = this;
        var id_to_copy = el.getAttribute('data-copy');
        var input_to_copy = document.getElementById(id_to_copy);
        input_to_copy.classList.remove('d-none');
        input_to_copy.select();
        input_to_copy.setSelectionRange(0, 99999);
        document.execCommand('copy');
        input_to_copy.classList.add('d-none');

        el.classList.add('disabled');
        el.innerHTML = 'Lien copié';
    });
});
</script>
@endpush
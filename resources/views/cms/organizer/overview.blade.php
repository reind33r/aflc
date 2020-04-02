@extends('app')

@section('title')
Gestion du site
@endsection

@section('content')
<h1>Gestion du site</h1>

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
                        <a href="" class="btn btn-sm btn-link text-danger"><i class="far fa-trash-alt"></i></a>
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
@endsection
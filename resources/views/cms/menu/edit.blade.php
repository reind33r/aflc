@extends('app')

@section('title')
Modifier le menu de navigation
@endsection

@section('content')
<h1>Modifier le menu de navigation</h1>

<p>
    <a class="btn btn-secondary btn-sm" href="{{ route('cms.organizer') }}">Retour</a>
</p>

<div id="vue_app">
    <edit-menu
        v-bind:initial-items="items"
        v-bind:cms-pages="pages"
        v-bind:internal-pages="internal_pages"
        v-bind:save_changes_uri="save_changes_uri">
    </edit-menu>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
const app = new Vue({
    el: '#vue_app',
    data() {
        return {
            items: [
                @foreach($menu_items as $item)
                {!! json_encode($item->only('id', 'name', 'cms_page_uri', 'internal_link', 'external_link', 'visibility')) !!},
                @endforeach
            ],

            pages: [
                @foreach($pages as $page)
                {!! json_encode($page->only('uri', 'title', 'visibility')) !!},
                @endforeach
            ],

            internal_pages: [
                @foreach($internal_pages as $id => $info)
                {
                    id: {!! json_encode($id) !!},
                    name: {!! json_encode($info['name']) !!},
                    visibility: {!! json_encode($info['visibility']) !!},
                },
                @endforeach
            ],

            save_changes_uri: "{{ route('cms.menu.edit') }}",
        };
    }
});
</script>
@endpush
@extends('app')

@section('title')
Fermeture de la page
@endsection

@section('content')
<h1>Fermeture de la page</h1>

<p>
    <button class="btn btn-primary btn-sm" onclick="closePopup();">Clique ici</button> si la page ne se ferme pas automatiquement.
</p>

<p>
    Si ça ne marche toujours pas, tu peux fermer cette fenêtre, puis recharger la page.
</p>
@endsection

@push('scripts')
<script type="text/javascript">
function closePopup() {
    window.opener.postMessage('close', '*');
    window.close();
}
closePopup();
</script>
@endpush
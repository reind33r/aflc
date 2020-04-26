@extends('app')

@section('content')
<h1>Vérification de ton adresse email</h1>

@if (session('resent'))
<p class="alert alert-success">
    Un nouveau lien a été envoyé à ton adresse email ({{ Auth::user()->email }}).
</p>
@else
<p>
    Avant de commencer, vérifie que tu n'as pas déjà reçu un lien dans ta boîte
    email.
</p>
@endif

<p>
    Pense à vérifier dans le dossier <strong>Spam</strong>. Le mail peut parfois
    apparaître après quelques minutes.
</p>

<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
    @csrf
    <p>
        Si tu n'as rien reçu,
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">clique ici pour en demander un nouveau</button>.
    </p>
</form>

<button class="btn btn-primary" onclick="closePopup()">Fermer la fenêtre</button>
@endsection

@push('scripts')
<script type="text/javascript">
function closePopup() {
    // window.opener.postMessage('close', '*');
    window.close();
}
</script>
@endpush
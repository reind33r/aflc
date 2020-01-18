<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
        <h1 class="font-italic">{{ $titre }}</h1>

        <p class="lead my-3">
            {{ $slot }}
        </p>

        @if (isset($action))
        <p class="lead mb-0">
            <a href="{{ $action_url ?? '#' }}" class="font-weight-bold text-white">{{ $action }}</a>
        </p>
        @endif
    </div>
</div>
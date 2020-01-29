<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="container">
        <header id="layout_header" class="py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-8 offset-2 text-center">
                    <a class="header-logo text-dark" href="/">
                        <img src="{{ asset('img/racing_flags.png') }}" alt="Drapeau de course" class="align-text-top">
                        <span class="text-nowrap">{{ $race->name ?? 'À fond la caisse !' }}</span>
                    </a>
                    @isset($race)
                    <span class="d-block text-muted ">À {{ $race->location }}, le @human_date($race->date)</span>
                    @endisset
                </div>
                {{-- LIENS AUTHENTIFICATION --}}
                <div class="col-2 d-flex justify-content-end align-items-center">
                    @guest
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Connexion</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                {{ Auth::user()->full_name }}
                            </button>

                            <div class="dropdown-menu">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-between">
                <a href="/" class="p-2 text-muted">Accueil</a>
                <a href="#" class="p-2 text-muted">Programme</a>
                @guest
                <a href="{{ route('register') }}" class="p-2 text-muted">Inscription</a>
                @else
                <a href="#" class="p-2 text-muted">Mon inscription</a>
                @endguest
                <a href="#" class="p-2 text-muted">Règlement</a>
                <a href="#" class="p-2 text-muted">Conseils de construction</a>
                <a href="#" class="p-2 text-muted">Tancarville en Fête</a>
            </nav>
        </div>
    </div>

    <main class="container">
        @yield('content')
    </main>

    <footer id="layout_footer">
        <p>
            Une réalisation <a href="https://louis.hostux.fr">Louis GUIDEZ</a>
        </p>
        <p>
            <a href="#">Retour en haut</a>
        </p>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
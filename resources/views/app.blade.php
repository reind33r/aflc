<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="container mb-2">
        <header id="layout_header" class="py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-8 offset-2 text-center">
                    <span class="header-logo">
                        @isset($race)<a href="/" class="text-dark">@endisset
                            <img src="{{ asset('img/racing_flags.png') }}" alt="Drapeau de course" class="align-text-top">
                            <span class="text-nowrap">{{ $race->name ?? 'À fond la caisse !' }}</span>
                        @isset($race)</a>@endisset
                    </span>
                    @isset($race)
                    <span class="d-block text-muted ">À {{ $race->location }}, le @human_date($race->date)</span>
                    @endisset
                </div>
                {{-- LIENS AUTHENTIFICATION --}}
                <div class="col-2 d-flex justify-content-end align-items-center">
                    @guest('web')
                    @guest('web:organizers')
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Connexion</a>
                    @endguest
                    @endguest

                    @auth('web')
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::user()->full_name }}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">
                            @component('components.popup_link', [
                                'href' => route('auth.update_profile'),
                                'class' => 'dropdown-item',
                            ])
                            Mettre à jour mon profil
                            @endcomponent

                            <a href="" class="dropdown-item">Changer mon mot de passe</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                    @endauth

                    @auth('web:organizers')
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-warning dropdown-toggle" data-toggle="dropdown">
                            {{ Auth::guard('web:organizers')->user()->name }}
                        </button>

                        <div class="dropdown-menu dropdown-menu-right">
                            @component('components.popup_link', [
                                'href' => route('auth.update_profile'),
                                'class' => 'dropdown-item',
                            ])
                            Mettre à jour mon profil
                            @endcomponent

                            <a href="" class="dropdown-item">Changer mon mot de passe</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="guard" value="organizer">
                                <button type="submit" class="dropdown-item">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>
        </header>

        @if(isset($race) && $race->menuItems)
        <div class="nav-scroller py-1">
            <nav class="nav d-flex justify-content-center">
                @include('cms._menu')
            </nav>
        </div>
        @endif
    </div>

    <main class="container">
        @include('flash::message')

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
    @stack('scripts')
</body>
</html>
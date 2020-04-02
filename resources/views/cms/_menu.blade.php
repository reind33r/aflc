@if(count($race->menuItems) == 1)<span></span>@endif
@foreach($race->menuItems as $item)

@if(
    ($item->visibility == 'all')
    ||
    ($item->visibility == 'race_registered' && Auth::user() && Auth::user()->can('registered', $race))
    ||
    ($item->visibility == 'race_not_registered' && (!Auth::user() || Auth::user()->can('not_registered', $race)))
    ||
    ($item->visibility == 'race_organizer' && Auth::guard('web:organizers')->user() && Auth::guard('web:organizers')->user()->can('organize', $race))
)
<a class="p-2 mx-2 text-muted" href="{{ $item->url }}">{{ $item->name }}</a>
@endif
@endforeach
@if(count($race->menuItems) == 1)<span></span>@endif

{{-- <a href="/" class="p-2 text-muted">Accueil</a>
<a href="#" class="p-2 text-muted">Programme</a>
@can('captain', $race)
<a href="{{ route('race.myteam') }}" class="p-2 text-muted">Mon équipe</a>
@else
<a href="{{ route('race.register') }}" class="p-2 text-muted">Inscription</a>
@endcan
<a href="{{ route('race.registrations') }}" class="p-2 text-muted">Suivi des inscriptions</a>
<a href="#" class="p-2 text-muted">Règlement</a>
<a href="#" class="p-2 text-muted">Conseils de construction</a>
<a href="#" class="p-2 text-muted">Tancarville en Fête</a> --}}
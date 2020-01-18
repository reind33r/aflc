@extends('app')

@section('title')
Titre de la page
@endsection

@section('content')

@component('bootstrap.featured')
@slot('titre')
Course de caisses à savon
@endslot

Le 30 septembre 2020, Tancarville en Fête organise une course de caisses à savon.<br>
Bricoleur en herbe ou spectateur, vous êtes invité.e.s !

@slot('action')
Je m'inscris
@endslot
@endcomponent

<p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam ab rem unde enim sequi tempore, necessitatibus modi dolores, sapiente eligendi non quia, pariatur perspiciatis? Perspiciatis excepturi quae blanditiis incidunt perferendis?
</p>

<div class="row">
    <div class="col-md-8">

    </div>
    <aside class="col-md-4">
        <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">À propos</h4>

            <p class="mb-0">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum vero numquam voluptatem mollitia possimus esse, quibusdam, modi ipsam atque voluptate quidem et. Unde eius dolorem beatae vel repellendus consequuntur maxime?
            </p>
        </div>

        <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">Archives</h4>

            <ul class="list-unstyled mb-0">
                <li><a href="#">Tancarville, 2018</a></li>
                <li><a href="#">Tancarville, 2017</a></li>
                <li><a href="#">Saint-Jouin Bruneval, 2016</a></li>
                <li><a href="#">Tancarville, 2016</a></li>
            </ul>
        </div>
    </aside>
</div>
@endsection
@extends('app')

@section('title')
Étape 4 - Récapitulatif
@endsection

@section('content')
@include('race.register._steps', [
    'active' => 4,
    'user_progress' => $registration_form_data->userProgress(),
    'has_error' => false, // TODO
])

<form method="POST" action="{{ route('race.register.handleStep') }}">
    @csrf
    <input type="hidden" name="step" value="4">

    @input([
        'name' => 'team_name',
        'required' => True,
        'initial' => $registration_form_data->get('team_name'),
    ])
    Nom de l'équipe
    @endinput

    @checkbox([
        'name' => 'captain_check',
        'wrap_label_tag' => 'h3',
    ])
        Capitaine d'équipe
    @endcheckbox

    <p>
        C'est la personne qui gère l'inscription, l'interlocuteur privilégié
        des organisateurs.
    </p>

    <dl class="row">
        <dt class="col-sm-3">Description lists</dt>
        <dd class="col-sm-9">A description list is perfect for defining terms.</dd>
      
        <dt class="col-sm-3">Euismod</dt>
        <dd class="col-sm-9">
          <p>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</p>
          <p>Donec id elit non mi porta gravida at eget metus.</p>
        </dd>
      
        <dt class="col-sm-3">Malesuada porta</dt>
        <dd class="col-sm-9">Etiam porta sem malesuada magna mollis euismod.</dd>
      
        <dt class="col-sm-3 text-truncate">Truncated term is truncated</dt>
        <dd class="col-sm-9">Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
      
        <dt class="col-sm-3">Nesting</dt>
        <dd class="col-sm-9">
          <dl class="row">
            <dt class="col-sm-4">Nested definition list</dt>
            <dd class="col-sm-8">Aenean posuere, tortor sed cursus feugiat, nunc augue blandit nunc.</dd>
          </dl>
        </dd>
      </dl>

    <div class="row">
        <div class="col-md-6">
            @checkbox([
                'name' => 'pilots_check',
                'wrap_label_tag' => 'h3',
            ])
                Pilotes
            @endcheckbox
        </div>
        <div class="col-md-6">
            @checkbox([
                'name' => 'soapboxes_check',
                'wrap_label_tag' => 'h3',
            ])
                Caisses à savon
            @endcheckbox
        </div>
    </div>

    @checkbox([
        'name' => 'rgpd_check',
        'required' => True,
    ])
        J'autorise a-fond-la-caisse.com à stocker mes données personnelles
        ainsi que celles des pilotes enregistrés,
        à des fins techniques et d'organisation de la course.
    @endcheckbox

    <input type="submit" name="nextStep"
           value="Valider l'inscription" class="btn btn-primary">

    <input type="submit" name="back"
           value="Retour" class="btn btn-secondary btn-sm">
</form>
@endsection
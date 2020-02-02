<div class="card mb-2" data-collectionItem>
    <div class="card-body">
        <button class="btn btn-sm btn-danger float-right" data-action="deleteCollectionItem" type="button"><i class="far fa-trash-alt"></i></button>
        <h5 class="card-title">Pilote #{{ $index }}</h5>

        <div class="row">
            <div class="col-md">
                @select([
                    'name' => 'pilots['. $index .'][honorific_prefix]',
                    'options' => [
                        'm' => 'M.',
                        'mme' => 'Mme.',
                        'autre' => 'Autre',
                    ],
                    'required' => True,
                    'initial' => $pilot['honorific_prefix'] ?? '',
                ])
                Civilité
                @endselect
            </div>
    
            <div class="col-md">
                @input([
                    'name' => 'pilots['. $index .'][first_name]',
                    'required' => True,
                    'initial' => $pilot['first_name'] ?? '',
                ])
                Prénom
                @endinput
            </div>
    
            <div class="col-md">
                @input([
                    'name' => 'pilots['. $index .'][last_name]',
                    'required' => True,
                    'initial' => $pilot['last_name'] ?? '',
                ])
                Nom de famille
                @endinput
            </div>

            <div class="col-md">
                @input([
                    'name' => 'pilots['. $index .'][birthday]',
                    'type' => 'date',
                    'required' => True,
                    'initial' => $pilot['birthday'] ?? '',
                ])
                Date de naissance
                @endinput
            </div>
        </div>
    </div>  
</div>
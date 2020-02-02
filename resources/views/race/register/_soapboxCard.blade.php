<div class="card mb-2" data-collectionItem>
    <div class="card-body">
        <button class="btn btn-sm btn-danger float-right" data-action="deleteCollectionItem" type="button"><i class="far fa-trash-alt"></i></button>
        <h5 class="card-title">Caisse à savon #{{ $index }}</h5>

        <div class="row">    
            <div class="col-md">
                @input([
                    'name' => 'soapboxes['. $index .'][name]',
                    'required' => True,
                    'initial' => $soapbox['name'] ?? '',
                ])
                Nom
                @endinput
            </div>
    
            <div class="col-md">
                @input([
                    'name' => 'soapboxes['. $index .'][desired_number]',
                    'required' => False,
                    'initial' => $soapbox['desired_number'] ?? '',
                ])
                @slot('help_text')
                Le numéro de course comporte trois chiffres. Tu peux changer
                ton souhait à tout moment.<br>
                L'attribution se fait selon l'ordre de validation des inscriptions,
                sauf changement manuel de l'organisateur.
                @endslot
                Numéro de course souhaité
                @endinput
            </div>
        </div>
    </div>  
</div>
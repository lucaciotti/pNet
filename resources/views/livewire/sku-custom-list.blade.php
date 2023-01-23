<div wire:init="readyToLoad">
    <dl class="dl-horizontal">
        <dt>Codice</dt>
        <dd>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <big><strong>{{$id_art}}</strong></big> -
            <small>{{$descr_art}}</small>
        </dd>
    </dl>
    <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modal-sku_cli">
        Inserisci Nuovo Codice Personalizzato
    </button>
    <table class="table table-hover table-condensed dtTbls_light" id="listSkuCodes">
        <thead>
            <th>Cliente</th>
            <th>Codice Personalizzato</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($listSkuCodes as $sku)
            <tr>
                <td>[{{ $sku->id_cli_for }}]
                    @if($sku->client)
                    - {{ $sku->client->rag_soc }}
                    @endif
                </td>
                <td>{{ $sku->sku_code }}</td>
                <td><button class="btn btn-sm btn-default" wire:click="delete('{{ $sku->id_cli_for }}')" wire:loading.attr="disabled"><i class="fa fa-trash fa-lg text-danger"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <span class="text-warning" wire:loading wire:target="delete">
        Cancellazione Valore...
    </span>
</div>

@include('parideViews.prods.modals.skuCliForm')
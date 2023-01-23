
<div class="modal fade show" id="modal-sku_cli" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                @if (!empty($sku_code))
                    <h6 class="modal-title">Modifica Codice Prodotto Personalizzato</h6>
                @else
                    <h6 class="modal-title">Inserisci Codice Prodotto Personalizzato</h6>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('sku-custom-form', ['id_art' => $id_art, 'id_cli_for' => $id_cli_for ?? '', 'sku_code' => $sku_code ?? '' ])
            </div>
        </div>
    </div>
</div>
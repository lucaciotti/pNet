<div class="modal fade show" id="modal-sku_cli_list" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Lista Codici Prodotto Personalizzati</h6>   
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('sku-custom-list', ['id_art' => $id_art])
            </div>
        </div>
    </div>
</div>
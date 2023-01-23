<div class="modal fade show" id="modal-lg" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><strong>{{ $prod->id_art }}</strong> - Specifiche</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $prod->desc_ecom !!}
            </div>
        </div>
    </div>
</div>
{{-- <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modal-docNotes_{{ $idNote }}">
    Inserisci Nuova Regola Prezzo
</button> --}}

<div class="modal fade show" id="modal-priceMngr_{{ $idPrice }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($idPrice!=0)
                <h6 class="modal-title">Modifica Regola di Prezzo</h6>
                @else
                <h6 class="modal-title">Nuova Regola di Prezzo</h6>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- @livewire('note-doc-form', ['idNote' => $idNote]) --}}
                <livewire:pricemanager.form :idPrice="$idPrice" :wire:key="time().$idPrice">
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('closeModalPriceMngrForm_{{ $idPrice }}', event => {
        $("#modal-priceMngr_{{ $idPrice }}").modal('hide');
    })
</script>
@endpush
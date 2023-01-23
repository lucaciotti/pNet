<button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modal-docNotes_{{ $idNote }}">
    Inserisci Nuova Nota su Documento
</button>

<div class="modal fade show" id="modal-docNotes_{{ $idNote }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($idNote!=0)
                <h6 class="modal-title">Nota Personalizzata Documento</h6>
                @else
                <h6 class="modal-title">Nota Personalizzata Documento</h6>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('note-doc-form', ['idNote' => $idNote])
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('closeModalDocNoteForm_{{ $idNote }}', event => {
        $("#modal-docNotes_{{ $idNote }}").modal('hide');
    })
</script>
@endpush
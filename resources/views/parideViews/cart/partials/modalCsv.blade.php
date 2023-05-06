
<button class="btn btn-block btn-warning" data-toggle="modal" data-target="#modal-cartCSV">
    Import CSV
</button>

<div class="modal fade show" id="modal-cartCSV" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Importa Righe da CSV</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <livewire:cart.import-csv>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('closeModalCartCSV', event => {
        $("#modal-cartCSV").modal('hide');
    })
</script>
@endpush
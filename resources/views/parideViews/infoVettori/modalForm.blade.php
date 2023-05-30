<button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modal-infoVettori_{{ $idInfoVet }}">
    Inserisci Url Tracking Vettori
</button>

<div class="modal fade show" id="modal-infoVettori_{{ $idInfoVet }}" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                @if ($idInfoVet!=0)
                <h6 class="modal-title">Url Tracking Vettore</h6>
                @else
                <h6 class="modal-title">Url Tracking Vettore</h6>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                @livewire('info-vettori-form', ['idInfoVet' => $idInfoVet])
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    window.addEventListener('closeModalInfoVettoriForm_{{ $idInfoVet }}', event => {
        $("#modal-infoVettori_{{ $idInfoVet }}").modal('hide');
    })
</script>
@endpush
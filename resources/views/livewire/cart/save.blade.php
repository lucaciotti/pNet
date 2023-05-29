<div>
    <div class="form-group" style="margin-bottom: 10px; text-align: center;">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="agreement" name="agreement">
            <label for="agreement" class="custom-control-label">Ho letto e accetto i <strong><a href="https://www.ferramentaparide.it/schede/PR00024_Condizioni_Vendita.pdf" target="_blank" rel="noopener noreferrer">Termini e Condizioni di Vendita</a></strong></label>
        </div>
    </div>
    <button class="btn btn-block btn-success" wire:click='saveOrder'>Salva Ordine</button>
    @if($errorMessage) <span class="text-danger">{{ $errorMessage }}</span> @endif
</div>

@push('js')
<script>
    $(document).ready(function() {

        $('#agreement').on('change', function (e) {
            var data = $('#agreement').prop("checked");
            @this.set('agreement', data);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2()
    }); });
</script>
@endpush
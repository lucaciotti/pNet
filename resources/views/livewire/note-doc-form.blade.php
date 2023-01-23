<form wire:submit.prevent="submit" wire:init="readyToLoad">

    <div class="form-group" style="margin-bottom:5px;">
        <label for="tipo_doc">Tipologia Documento</label>
        <select class="form-control select2 livewireSelect2" id="tipo_doc" style="width: 100%;" placeholder="Codice Cliente" wire:model.lazy="tipo_doc">
            <option value=""></option>
            <option value="XC">Preventivo / Offerta</option>
            <option value="OC">Ordine</option>
            <option value="BO">DDT</option>
            <option value="FT">Fattura Accompagnatoria</option>
            <option value="FD">Fattura Differita</option>
            <option value="FP">Fattura Proforma </option>
            <option value="NC">Nota di Credito</option>
        </select>
        @error('tipo_doc') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="start_date">Data Inizio Validità</label>
        <div class="input-group date">
            <input type="text" id="start_date" class="form-control form-control-sm" data-target="#start_date">
            <div class="input-group-append" data-target="#start_date">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="end_date">Data Fine Validità</label>
        <div class="input-group date">
            <input type="text" id="end_date" class="form-control form-control-sm" data-target="#end_date">
            <div class="input-group-append" data-target="#end_date">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
        @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="note">Note</label>
        <textarea class="form-control" rows="3" placeholder="Inserisci Note ..." id="note" wire:model.lazy="note"></textarea>
        @error('note') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div>
        <button type="submit" class="btn bg-lightblue btn-sm btn-block" style="margin-top:10px;">Salva</button>
    </div>

</form>

@push('js')
<script>
    $(document).ready(function() {

        $('#tipo_doc').on('change', function (e) {
            var data = $('#tipo_doc').select2("val");
            @this.set('tipo_doc', data);
        });

        $('input[id="start_date"]').daterangepicker({
            lang: 'it-IT',
            singleDatePicker: true,
            showDropdowns: true,
        },
        function(start, end, label) {
            @this.set('start_date', start);
        });

        $('input[id="end_date"]').daterangepicker({
            lang: 'it-IT',
            singleDatePicker: true,
            showDropdowns: true,
        },
        function(start, end, label) {
            @this.set('end_date', start);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2();
        });
    });
</script>
@endpush
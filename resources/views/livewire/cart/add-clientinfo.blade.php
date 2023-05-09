<div>
    <div class="d-md-flex justify-content-between">
        <div class="form-group col-md-6">
            <label>Identifica il tuo Ordine</label>
            <div class="input-group input-group">
                <input type="text" class="form-control form-control-sm" name="idOrd" id="idOrd" placeholder="Identificativo" wire:model.lazy="idOrd">
            </div>
            @error('idOrd') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    
        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="start_date">Richiesta Data Consegna</label>
            <div class="input-group date">
                <input type="text" id="start_date" class="form-control form-control-sm" data-target="#start_date">
                <div class="input-group-append" data-target="#start_date">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    
    @if (RedisUser::get('role') != 'client')
    <hr>
    <div class="form-group" style="margin-bottom:5px;">
        <label for="codCli">Codice Cliente</label>
        <select class="form-control select2 livewireSelect2 text-bold" id="codCli" style="width: 100%;" placeholder="Codice Cliente" @if($importfromDoc) disabled @endif wire:model.lazy="codCli">
            <option value=""> </option>
            @foreach ($listCli as $client)
            <option value="{{ $client['id_cli_for'] }}"> {{ $client['id_cli_for'] }} - {{ $client['rag_soc'] }} </option>
            @endforeach
        </select>
        @error('codCli') <span class="text-danger">{{ $message }}</span> @enderror
        @if (!$listCli)
        {{-- <span class="text-warning"> Caricamento Clienti... Attendere prego </span> --}}
        <div class="d-flex align-items-center text-secondary">
            <strong>Caricamento Clienti...</strong>
            <div class="spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
        </div>
        @endif
    </div>
    @endif
</div>

@push('js')
<script>
    $(document).ready(function() {

        $('#codCli').on('change', function (e) {
            var data = $('#codCli').select2("val");
            @this.set('codCli', data);
        });
        
        $('input[id="start_date"]').daterangepicker({
            lang: 'it-IT',
            singleDatePicker: true,
            showDropdowns: true,
            "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Applica",
            "cancelLabel": "Cancella",
            "fromLabel": "Da",
            "toLabel": "A",
            "customRangeLabel": "Personalizza",
            "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mer",
            "Gio",
            "Ven",
            "Sab"
            ],
            "monthNames": [
            "Gennaio",
            "Febbraio",
            "Marzo",
            "Aprile",
            "Maggio",
            "Giugno",
            "Luglio",
            "Agosto",
            "Settembre",
            "Ottobre",
            "Novembre",
            "Dicembre"
            ],
            "firstDay": 1
            }
        }).on('blur', function (e) {
        var data = $('input[id="start_date"]').data('daterangepicker');
        // console.log(data.startDate);
        @this.set('start_date', data.startDate);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2()
    }); });
</script>
@endpush
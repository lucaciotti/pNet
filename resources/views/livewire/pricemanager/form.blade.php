
<form wire:submit.prevent="submit" {{-- wire:init="readyToLoad" --}}>
    
    <div class="d-md-flex justify-content-between">
        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="id_tipo_cl">Tipo Cliente</label>
            <select class="form-control select2 livewireSelect2" id="id_tipo_cl" style="width: 100%;" placeholder="Codice Cliente" wire:model.lazy="id_tipo_cl">
                <option value="0"> - </option>
                @foreach ($tipoClienti as $tipo)
                <option value="{{ $tipo['id_tipo_cl'] }}"> {{ $tipo['descr'] }} </option>
                @endforeach
            </select>
            @error('id_tipo_cl') <span class="text-danger">{{ $message }}</span> @enderror
            @if (!$tipoClLoaded)
            <div class="d-flex align-items-center text-secondary">
                <strong>Caricamento...</strong>
                <div class="spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
            </div>
            @endif
        </div>

        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="id_cli_for">Codice Cliente</label>
            <select class="form-control select2 livewireSelect2" id="id_cli_for" style="width: 100%;" placeholder="Codice Cliente" wire:model.lazy="id_cli_for">
                <option value=""> - </option>
                @foreach ($clients as $client)
                <option value="{{ $client['id_cli_for'] }}"> {{ $client['rag_soc'] }} </option>
                @endforeach
            </select>
            @error('id_cli_for') <span class="text-danger">{{ $message }}</span> @enderror
            @if (!$clientiLoaded)
            <div class="d-flex align-items-center text-secondary">
                <strong>Caricamento...</strong>
                <div class="spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
            </div>
            @endif
        </div>
    </div>

    <hr>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="id_fam">Famiglia Prodotto</label>
        <select class="form-control select2 livewireSelect2" id="id_fam" style="width: 100%;" placeholder="Famiglia Prodotto" wire:model.lazy="id_fam">
            @foreach ($gruppi as $grp)
            <option value="{{ $grp['id_fam'] }}"> [{{ $grp['id_fam'] }}] {{ $grp['descr'] }}</option>
            @endforeach
        </select>
        @error('id_fam') <span class="text-danger">{{ $message }}</span> @enderror
        @if (!$gruppiLoaded)
        <div class="d-flex align-items-center text-secondary">
            <strong>Caricamento...</strong>
            <div class="spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
        </div>
        @endif
    </div>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="listino">Listino Prezzo</label>
        <select class="form-control select2 livewireSelect2" id="listino" style="width: 100%;"
            placeholder="Listino Prezzo" wire:model.lazy="listino">
            <option value=""></option>
            <option value="1">Listino 1</option>
            <option value="2">Listino 2</option>
            <option value="3">Listino 3</option>
            <option value="4">Listino 4</option>
        </select>
        @error('listino') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="d-md-flex justify-content-between">
        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="start_date">Data Inizio Validità</label>
            <div class="input-group date">
                <input type="text" id="start_date" class="form-control form-control-sm" data-target="#start_date">
                <div class="input-group-append" data-target="#start_date">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="end_date">Data Fine Validità</label>
            <div class="input-group date">
                <input type="text" id="end_date" class="form-control form-control-sm" data-target="#end_date">
                <div class="input-group-append" data-target="#end_date">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
            @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <div>
        <button type="submit" class="btn bg-lightblue btn-sm btn-block" style="margin-top:10px;">Salva</button>
    </div>

</form>

@push('js')
<script>
    $(document).ready(function() {

        $('#id_tipo_cl').on('change', function (e) {
            var data = $('#id_tipo_cl').select2("val");
            @this.set('id_tipo_cl', data);
        });
        $('#id_cli_for').on('change', function (e) {
        var data = $('#id_cli_for').select2("val");
        @this.set('id_cli_for', data);
        });
        $('#id_fam').on('change', function (e) {
        var data = $('#id_fam').select2("val");
        @this.set('id_fam', data);
        });
        $('#listino').on('change', function (e) {
            var data = $('#listino').select2("val");
            @this.set('listino', data);
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

        $('input[id="end_date"]').daterangepicker({
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
        var data = $('input[id="end_date"]').data('daterangepicker');
        // console.log(data.startDate);
        @this.set('end_date', data.startDate);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            if(message.component.fingerprint.name=='pricemanager.form'){
                $('.select2').select2();
                // $('input[id="start_date"]').daterangepicker({
                //     lang: 'it-IT',
                //     singleDatePicker: true,
                //     showDropdowns: true,
                //     "locale": {
                //     "format": "DD/MM/YYYY",
                //     "separator": " - ",
                //     "applyLabel": "Applica",
                //     "cancelLabel": "Cancella",
                //     "fromLabel": "Da",
                //     "toLabel": "A",
                //     "customRangeLabel": "Personalizza",
                //     "daysOfWeek": [
                //     "Dom",
                //     "Lun",
                //     "Mar",
                //     "Mer",
                //     "Gio",
                //     "Ven",
                //     "Sab"
                //     ],
                //     "monthNames": [
                //     "Gennaio",
                //     "Febbraio",
                //     "Marzo",
                //     "Aprile",
                //     "Maggio",
                //     "Giugno",
                //     "Luglio",
                //     "Agosto",
                //     "Settembre",
                //     "Ottobre",
                //     "Novembre",
                //     "Dicembre"
                //     ],
                //     "firstDay": 1
                //     }
                // }).on('blur', function (e) {
                // var data = $('input[id="start_date"]').data('daterangepicker');
                // // console.log(data.startDate);
                // @this.set('start_date', data.startDate);
                // });
                
                // $('input[id="end_date"]').daterangepicker({
                //     lang: 'it-IT',
                //     singleDatePicker: true,
                //     showDropdowns: true,
                //     "locale": {
                //     "format": "DD/MM/YYYY",
                //     "separator": " - ",
                //     "applyLabel": "Applica",
                //     "cancelLabel": "Cancella",
                //     "fromLabel": "Da",
                //     "toLabel": "A",
                //     "customRangeLabel": "Personalizza",
                //     "daysOfWeek": [
                //     "Dom",
                //     "Lun",
                //     "Mar",
                //     "Mer",
                //     "Gio",
                //     "Ven",
                //     "Sab"
                //     ],
                //     "monthNames": [
                //     "Gennaio",
                //     "Febbraio",
                //     "Marzo",
                //     "Aprile",
                //     "Maggio",
                //     "Giugno",
                //     "Luglio",
                //     "Agosto",
                //     "Settembre",
                //     "Ottobre",
                //     "Novembre",
                //     "Dicembre"
                //     ],
                //     "firstDay": 1
                //     }
                // }).on('blur', function (e) {
                // var data = $('input[id="end_date"]').data('daterangepicker');
                // // console.log(data.startDate);
                // @this.set('end_date', data.startDate);
                // });
            }
        });
    });
</script>
@endpush
<div class="row d-flex justify-content-start" wire:init="readyToLoad">
    <div class="col-lg-8">
        <div class="card" wire:ignore>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modal-priceMngr_0" onclick="Livewire.emit('openModalPriceMngrForm', 0)">
                    Inserisci Nuova Regola Prezzo
                </button>
                @include('parideViews.priceManager.modalForm', ['idPrice' => 0])
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista Regole di Prezzo</h3>
        
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
        
                <table class="table table-hover table-condensed" id="listPriceMngr">
                    <thead>
                        <th>Tipo Cliente</th>
                        <th>Cliente</th>
                        <th>Famiglia Prd.</th>
                        <th>Listino Rif.</th>
                        <th>Data Inizio</th>
                        <th>Data Fine</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($price_lists as $price)
                        <tr>
                            <td>{{ $price->typeCli->descr ?? '' }}</td>
                            <td>{{ $price->cliente->rag_soc ?? '' }}</td>
                            <td>{{ $price->grpProd->descr }}</td>
                            <td>L-{{ $price->listino }}</td>
                            <td>{{ $price->start_date->format('d/m/Y') }}</td>
                            <td>{{ $price->end_date->format('d/m/Y') }}</td>
                            {{-- <td>@include('parideViews.docNotes.modalForm', ['idNote' => $note->id])</td> --}}
                            <td><button class="btn btn-sm btn-default" wire:click="delete('{{ $price->id }}')"
                                    wire:loading.attr="disabled"><i class="fa fa-trash fa-lg text-danger"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Extra Filtri</h3>        
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="tipocli_selected">Tipo Cliente</label>
                    <select class="form-control select2 livewireSelect2" id="tipocli_selected" style="width: 100%;" multiple placeholder="Tipo Cliente" wire:model.lazy="tipocli_selected">
                        @foreach ($tipiCli as $cli)
                        <option value="{{ $cli->id_tipo_cl }}">[{{ $cli->id_tipo_cl }}] {{ $cli->descr ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="client_selected">Cliente</label>
                    <select class="form-control select2 livewireSelect2" id="client_selected" style="width: 100%;" multiple placeholder="Cliente" wire:model.lazy="client_selected">
                        @foreach ($clients as $cli)
                        <option value="{{ $cli->id_cli_for }}">[{{ $cli->id_cli_for }}] {{ $cli->rag_soc ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:5px;">
                    <label for="grp_selected">Famiglia Prodotto</label>
                    <select class="form-control select2 livewireSelect2" id="grp_selected" style="width: 100%;" multiple placeholder="Famiglia Prodotto" wire:model.lazy="grp_selected">
                        @foreach ($gruppi as $grp)
                        <option value="{{ $grp->id_fam }}"> [{{ $grp->id_fam }}] {{ $grp->descr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {

        $('#listPriceMngr').DataTable({
            "iDisplayLength": 25,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "aaSorting": [],
            "responsive": true,
            "columnDefs": [
            { "responsivePriority": 1, "targets": 0 },
            { "responsivePriority": 2, "targets": 1 },
            { "responsivePriority": 3, "targets": -1 }
            ],
            "language": {
            "lengthMenu": "Mostra _MENU_ righe per pagina",
            "zeroRecords": "Nessuna corrispondenza trovata",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessuna riga trovata",
            "infoFiltered": "(filtrato da _MAX_ righe totali)",
            "decimal": "",
            "emptyTable": "Nessun dato disponibile nella tabella",
            "infoPostFix": "",
            "thousands": ".",
            "loadingRecords": "Caricamento...",
            "processing": "Processamento...",
            "search": "Ricerca:",
            "paginate": {
            "first": "Primo",
            "last": "Ultimo",
            "next": "Prossima",
            "previous": "Precedente"
            },
            "aria": {
            "sortAscending": ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
            }
            }
        });
    
        $('#tipocli_selected').on('change', function(e) {
            var data = $('#tipocli_selected').select2("val");
            @this.set('tipocli_selected', data);
        });
        $('#client_selected').on('change', function(e) {
            var data = $('#client_selected').select2("val");
            console.log(data);
            @this.set('client_selected', data);
        });
        $('#grp_selected').on('change', function(e) {
            var data = $('#grp_selected').select2("val");
            @this.set('grp_selected', data);
        });
    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            console.log(message.component.fingerprint.name);
            if(message.component.fingerprint.name=='pricemanager.content'){
                if ( $.fn.dataTable.isDataTable( '#listPriceMngr' ) ) {
                    table = $('#listPriceMngr').DataTable();
                    table.clear().destroy();
                }
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            console.log(message.component.fingerprint.name);
            if(message.component.fingerprint.name=='pricemanager.content'){
                $('.select2').select2();
                $('#listPriceMngr').DataTable({
                    "iDisplayLength": 25,
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "aaSorting": [],
                    "responsive": true,
                    "columnDefs": [
                    { "responsivePriority": 1, "targets": 0 },
                    { "responsivePriority": 2, "targets": 1 },
                    { "responsivePriority": 3, "targets": -1 }
                    ],
                    "language": {
                    "lengthMenu": "Mostra _MENU_ righe per pagina",
                    "zeroRecords": "Nessuna corrispondenza trovata",
                    "info": "Pagina _PAGE_ di _PAGES_",
                    "infoEmpty": "Nessuna riga trovata",
                    "infoFiltered": "(filtrato da _MAX_ righe totali)",
                    "decimal": "",
                    "emptyTable": "Nessun dato disponibile nella tabella",
                    "infoPostFix": "",
                    "thousands": ".",
                    "loadingRecords": "Caricamento...",
                    "processing": "Processamento...",
                    "search": "Ricerca:",
                    "paginate": {
                    "first": "Primo",
                    "last": "Ultimo",
                    "next": "Prossima",
                    "previous": "Precedente"
                    },
                    "aria": {
                    "sortAscending": ": attiva per ordinare la colonna in ordine crescente",
                    "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                    }
                    }
                });
            }
        });
    });
</script>
@endpush
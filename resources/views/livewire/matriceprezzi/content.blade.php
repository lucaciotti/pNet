<div class="row d-flex justify-content-start" wire:init="readyToLoad">
    
    <div class="col-lg-8">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Matrice Prezzi</h3>
        
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
                        <th>Marca Prd.</th>
                        <th>Cod.Prd.</th>
                        <th>Listino Rif.</th>
                        <th>Sconto %</th>
                        <th>Data Inizio</th>
                        <th>Data Fine</th>
                    </thead>
                    <tbody>
                        @foreach ($price_lists as $price)
                        <tr>
                            <td>{{ $price->typeCli->descr ?? '' }}</td>
                            <td>{{ $price->id_cli_for ?? '' }} - {{ $price->cliente->rag_soc ?? '' }}</td>
                            <td>@if ($price->id_fam!=""){{ $price->id_fam }} - {{ $price->grpProd->descr ?? 'ATTENZIONE - FAMIGLIA CANCELLATA' }}@endif</td>
                            <td>@if ($price->id_mar>0){{ $price->id_mar }} - {{ $price->marca->descr ?? 'ATTENZIONE - MARCA CANCELLATA' }}@endif</td>
                            <td>@if ($price->id_art>0){{ $price->id_art }}@else - @endif</td>
                            <td>L-{{ $price->id_lis }}</td>
                            <td>{{ $price->sconto }}</td>
                            <td>{{ $price->da_data->format('d/m/Y') }}</td>
                            <td>{{ $price->a_data->format('d/m/Y') }}</td>
                            {{-- <td>@include('parideViews.docNotes.modalForm', ['idNote' => $note->id])</td> --}}
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
                <div class="form-group" style="margin-bottom:5px;">
                    <label for="grp_selected">Famiglia Prodotto</label>
                    <select class="form-control select2 livewireSelect2" id="grp_selected" style="width: 100%;" multiple
                        placeholder="Famiglia Prodotto" wire:model.lazy="grp_selected">
                        @foreach ($gruppi as $grp)
                        <option value="{{ $grp->id_fam }}"> [{{ $grp->id_fam }}] {{ $grp->descr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipocli_selected">Tipo Cliente</label>
                    <select class="form-control select2 livewireSelect2" id="tipocli_selected" style="width: 100%;" multiple placeholder="Tipo Cliente" wire:model.lazy="tipocli_selected">
                        @foreach ($tipiCli as $cli)
                        <option value="{{ $cli->id_tipo_cl }}">[{{ $cli->id_tipo_cl }}] {{ $cli->descr ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="marca_selected">Marca Prodotto</label>
                    <select class="form-control select2 livewireSelect2" id="marca_selected" style="width: 100%;" multiple placeholder="Marca Prodotto" wire:model.lazy="marca_selected">
                        @foreach ($marche as $marca)
                        <option value="{{ $marca->id_mar }}">[{{ $marca->id_mar }}] {{ $marca->descr ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <div class="form-group">
                    <label>Codice Articolo</label>
                    <div class="input-group input-group mb-3">
                        <div class="input-group-prepend">
                            <select type="button" class="btn btn-primary dropdown-toggle" name="codArtOp">
                                {{-- <option value="eql">=</option>
                                <option value="stw">[]...</option> --}}
                                <option value="cnt" selected>...[]...</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" name="codArt" wire:model.lazy="codArt">
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="codeArtSwitch" wire:model="codeArtSwitch" checked>
                        <label class="custom-control-label" for="codeArtSwitch">Solo Codice Articolo</label>
                    </div>
                <div>
                    <hr>
                <div class="form-group">
                    <label>Codice Cliente</label>
                    <div class="input-group input-group mb-3">
                        <div class="input-group-prepend">
                            <select type="button" class="btn btn-primary dropdown-toggle" name="codcliOp">
                                {{-- <option value="eql">=</option> --}}
                                {{-- <option value="stw">[]...</option> --}}
                                <option value="cnt" selected>...[]...</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" name="codcli" wire:model.lazy="codcli">
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ trans('doc.descClient') }}</label>
                    <div class="input-group input-group mb-3">
                        <div class="input-group-prepend">
                            <select type="button" class="btn btn-primary dropdown-toggle" name="ragsocOp">
                                {{-- <option value="eql">=</option>
                                <option value="stw">[]...</option> --}}
                                <option value="cnt" selected>...[]...</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" name="ragsoc" wire:model.lazy="ragsoc">
                    </div>
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
        $('#marca_selected').on('change', function(e) {
            var data = $('#marca_selected').select2("val");
            @this.set('marca_selected', data);
        });
    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            console.log(message.component.fingerprint.name);
            if(message.component.fingerprint.name=='matriceprezzi.content'){
                if ( $.fn.dataTable.isDataTable( '#listPriceMngr' ) ) {
                    table = $('#listPriceMngr').DataTable();
                    table.clear().destroy();
                }
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            console.log(message.component.fingerprint.name);
            if(message.component.fingerprint.name=='matriceprezzi.content'){
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
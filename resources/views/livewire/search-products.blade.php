<div class="row d-flex justify-content-start" wire:init="readyToLoad">
    <div class="col-lg-8">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Ricerca Libera" wire:model.lazy="searchString"
                        wire:keydown.enter="loadProducts">
                    {{-- <div class="input-group-append">
                        <a href="#" class="input-group-text"><i class="fas fa-fw fa-search"></i></a>
                    </div> --}}
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary" type="button"><i class="fas fa-fw fa-search"></i></button>
                    </div>
                </div>
                <hr>
                <div id="myCustomControl" class="form-group d-md-flex justify-content-around">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="codeArtSwitch" wire:model="codeArtSwitch"
                            checked>
                        <label class="custom-control-label" for="codeArtSwitch">Codice Articolo</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="descrSwitch" wire:model="descrSwitch"
                            checked>
                        <label class="custom-control-label" for="descrSwitch">Descrizione</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="barcodeSwitch" wire:model="barcodeSwitch"
                            checked>
                        <label class="custom-control-label" for="barcodeSwitch">Barcode</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customCodeSwitch"
                            wire:model="customCodeSwitch" checked>
                        <label class="custom-control-label" for="customCodeSwitch">Codice Personalizzato</label>
                    </div>
                </div>
                {{-- <div wire:loading> --}}
                    <div class="text-secondary float-right">
                        <strong wire:loading>Caricamento...</strong>
                        <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" wire:loading></div>
                    </div>
                    {{--
                </div> --}}
            </div>
            <!-- /.card-body -->
        </div>
    </div>
{{-- </div>
<div class="row"> --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('prod.contentTitle_idx') }}</h3>
        
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($isEmptyMultiSearch)
                <div wire:model.lazy="isEmptyMultiSearch">                
                    <p>
                        La ricerca non corrisponde ad alcun articolo. <br>
                        Prova a cambiare la parola di ricera: per esempio invece di <strong>"cacciavite"</strong> scrivi
                        <strong>"cacciavi"</strong>. <br>
                        Oppure riduci il numero di parole inserite: per esempio invece di <strong>"trapano a percussione per
                            cemento"</strong> prova <strong>"trapano percussione"</strong>. <br>
                        Se non trovi comunque contattaci per informazioni.
                    </p>
                </div>
                @endif
                <table class="table table-hover table-condensed" id="listProds">
                    <thead>
                        <th>{{ trans('prod.codeArt') }}</th>
                        <th>{{ trans('prod.descArt') }}</th>
                        <th>Famiglia Prodotto</th>
                        <th>Prezzo</th>
                        <th>Disponibilità</th>
                        <th>UM</th>
                        {{-- <th>Barcode</th>
                        <th>Forn.</th> --}}
                    </thead>
                    <tbody wire:loading.remove>
                        @foreach ($products as $prod)
                        <tr>
                            <td>
                                @if (!empty($prod->nome_foto))
                                <a class="thumbnail" href="{{ route('product::detail', $prod->id_art) }}">
                                    {{ $prod->id_art }}
                                    <span>
                                        <img src="{{ Thumbnail::src($prod->nome_foto)->widen(400)->url() }}" />
                                    </span>
                                </a>
                                @else
                                <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a>
                                @endif
                                {{-- <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a> --}}
                                @if ($prod->non_attivo=='1')
                                <span class="right badge badge-danger">NON ATTIVO</span>
                                @endif
                            </td>
                            <td>{{ $prod->descr }}</td>
                            <td>[{{ $prod->id_fam }}]
                                @if($prod->grpProd)
                                - {{ $prod->grpProd->descr }}
                                @endif
                            </td>
                            <td style="text-align: right">{{ number_format((float)round($prod->prezzo_1,3), 2, ',', '') }} €
                            </td>
                            <td style="text-align:right;">
                                @if($prod->magGiac)
                                {{ number_format((float)$prod->magGiac->esistenza, 2, ',', '') }}
                                @else
                                0
                                @endif
                            </td>
                            <td>{{ $prod->um }}</td>
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
                <div class="d-md-flex justify-content-between">
                    <div class="form-group col-md-6" style="margin-bottom:5px;">
                        <label for="grp_selected">Famiglia</label>
                        <select class="form-control select2 livewireSelect2" id="grp_selected" style="width: 100%;" multiple placeholder="Famiglia Prodotto" wire:model.lazy="grpSelected">
                            @foreach ($gruppi as $grp)
                            <option value="{{ $grp['id_fam'] }}"> [{{ $grp->id_fam }}] {{ $grp->descr }}</option>
                            @endforeach
                        </select>
                        @error('grp_selected') <span class="text-danger">{{ $message }}</span> @enderror
                        {{-- @if (!$clientsLoaded)
                        <span class="text-warning"> Caricamento Clienti... Attendere prego </span>
                        @endif --}}
                    </div>
                    <div class="form-group col-md-6">
                        <label for="marche_selected">Marca Prodotto</label>
                        <select class="form-control select2 livewireSelect2" id="marche_selected" style="width: 100%;" multiple placeholder="Marca Prodotto" wire:model.lazy="marcheSelected">
                            @foreach ($marcheList as $marca)
                            <option value="{{ $marca->id_mar }}">[{{ $marca->id_mar }}] {{ $marca->descr ?? '' }}</option>
                            @endforeach
                        </select>
                        @error('marche_selected') <span class="text-danger">{{ $message }}</span> @enderror
                        {{-- @if (!$clientsLoaded)
                        <span class="text-warning"> Caricamento Clienti... Attendere prego </span>
                        @endif --}}
                    </div>
                </div>
                @if (!in_array(RedisUser::get('role'), ['client', 'agent', 'user']))
                <hr>
                <div class="form-group">
                    <label for="supplier_selected">Fornitore</label>
                        <select class="form-control select2 livewireSelect2" id="supplier_selected" style="width: 100%;" multiple placeholder="Fornitore" wire:model.lazy="supplierSelected">
                            @foreach ($suppliersList as $sup)
                            <option value="{{ $sup->id_cli_for }}">[{{ $sup->id_cli_for }}] {{ $sup->rag_soc ?? '' }}</option>
                            @endforeach
                        </select>
                        @error('supplier_selected') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {

        $('#listProds').DataTable({
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
    
        $('#grp_selected').on('change', function(e) {
            var data = $('#grp_selected').select2("val");
            @this.set('grpSelected', data);
        });
        $('#marche_selected').on('change', function(e) {
            var data = $('#marche_selected').select2("val");
            console.log(data);
            @this.set('marcheSelected', data);
        });
        $('#supplier_selected').on('change', function(e) {
            var data = $('#supplier_selected').select2("val");
            @this.set('supplierSelected', data);
        });
    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            if ( $.fn.dataTable.isDataTable( '#listProds' ) ) {
                table = $('#listProds').DataTable();
                table.clear().destroy();
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2();
            $('#listProds').DataTable({
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
        });
    });
</script>
@endpush
<div>
    <table class="table table-hover table-condensed" id="addCart">
        <col width='3%'>
        <col width='15%'>
        <col width='15%'>
        <col width='40%'>
        <col width='10%'>
        <col width='15%'>
        <col width='3%'>
        <thead style="display: none">
            <tr>
                <th>#</th>
                <th>Cod.Art.</th>
                <th>Vs Cod.Art.</th>
                <th>Descrizione</th>
                <th>UM</th>
                <th>Quantità</th>
                <th></th>
            </tr>
        </thead>
        <tbody style="background-color: lightgrey">
            <tr>
                <td>
                    <div class="input-group input-group-sm">
                        @if (!$isArtSelected)
                            <button class="btn btn-sm btn-outline-primary" type="button" wire:click="toogleSearch" data-toggle="tooltip" data-placement="bottom" title="Ricerca Libera">
                                <i class="fas fa-fw fa-search-plus"></i>
                            </button>
                        @else
                            <button class="btn btn-sm btn-outline-warning" type="button" wire:click="resetAll" data-toggle="tooltip" data-placement="bottom" title="Reset Valori">
                                <i class="fas fa-fw fa-undo"></i>
                            </button>
                        @endif
                    </div>
                </td>
                @if ($isToogleSearch)
                <td colspan="3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="text" placeholder="Ricerca Libera" wire:model="searchStr" @if($isArtSelected) readonly @endif>
                        @if (!$isArtSelected)
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-fw fa-search"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                    @if(!empty($listProducts))
                    <div id='dropdownList' class="navbar-search-results myDropdownDiv" style='width: 60%'>
                        <div class="list-group myDropdownList">
                            <a href="#" class="list-group-item list-group-item-action" wire:loading wire:target="searchStr">
                                <div class="d-flex align-items-center text-secondary">
                                    <strong>Caricamento...</strong>
                                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                </div>
                            </a>
                            @if(!empty($listProducts))
                            @foreach($listProducts as $i => $product)
                    
                            <a class="list-group-item list-group-item-action" wire:click="selectedArt({{ $product['id_art'] }})">
                                <div class="d-flex w-100 justify-content-between">
                                    <p class="mb-1">{{ $product['id_art'] }} - {{ $product['descr'] }}</p>
                                </div>
                            </a>
                    
                            @endforeach
                            @else
                            <a class="list-group-item">
                                <div class="search-title">Nessun risultato...
                                </div>
                                <div class="search-path"></div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </td>
                @else
                <td>
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="text" placeholder="Cod.Art." wire:model.debounce.1000ms="idArt" wire:keydown.enter="searchListArt" @if ($isArtSelected) readonly @endif>
                        @if (!$isArtSelected)
                            {{-- <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-fw fa-search"></i>
                                </button>
                            </div> --}}
                        @endif
                    </div>
                    @error('idArt') <span class="text-danger">{{ $message }}</span> @enderror
                    @if(!empty($listArts))
                    <div id='dropdownList' class="navbar-search-results myDropdownDiv">
                        <div class="list-group myDropdownList">
                            <a href="#" class="list-group-item list-group-item-action" wire:loading wire:target="idArt">
                                <div class="d-flex align-items-center text-secondary">
                                    <strong>Caricamento...</strong>
                                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                </div>
                            </a>
                            @if(!empty($listArts))
                            @foreach($listArts as $i => $product)
                    
                            <a class="list-group-item list-group-item-action" wire:click="selectedArt({{ $product['id_art'] }})">
                                <div class="d-flex w-100 justify-content-between">
                                    <p class="mb-1">{{ $product['id_art'] }} - {{ $product['descr'] }}</p>
                                </div>
                            </a>
                    
                            @endforeach
                            @else
                            <a class="list-group-item">
                                <div class="search-title">Nessun risultato...
                                </div>
                                <div class="search-path"></div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="text" placeholder="Vs Cod.Art." wire:model.debounce.1000ms="skuCustom" @if($isArtSelected) readonly @endif>
                        @if (!$isArtSelected)
                        {{-- <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-fw fa-search"></i>
                            </button>
                        </div> --}}
                        @endif
                    </div>
                    @if(!empty($listCustomCodes))
                    <div id='dropdownList' class="navbar-search-results myDropdownDiv">
                        <div class="list-group myDropdownList">
                            <a href="#" class="list-group-item list-group-item-action" wire:loading wire:target="skuCustom">
                                <div class="d-flex align-items-center text-secondary">
                                    <strong>Caricamento...</strong>
                                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                </div>
                            </a>
                            @if(!empty($listCustomCodes))
                            @foreach($listCustomCodes as $i => $product)
                    
                            <a class="list-group-item list-group-item-action" wire:click="selectedArt({{ $product['id_art'] }})">
                                <div class="d-flex w-100 justify-content-between">
                                    <p class="mb-1">{{ $product['id_art'] }} - {{ $product['descr'] }}</p>
                                </div>
                            </a>
                    
                            @endforeach
                            @else
                            <a class="list-group-item">
                                <div class="search-title">Nessun risultato...
                                </div>
                                <div class="search-path"></div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="text" placeholder="Descrizione" wire:model.debounce.1000ms="descrArt" @if($isArtSelected) readonly @endif>
                        @if (!$isArtSelected)
                        {{-- <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-fw fa-search"></i>
                            </button>
                        </div> --}}
                        @endif
                    </div>
                    @if(!empty($listDescrArts))
                    <div id='dropdownList' class="navbar-search-results myDropdownDiv">
                        <div class="list-group myDropdownList">
                            <a href="#" class="list-group-item list-group-item-action" wire:loading wire:target="descrArt">
                                <div class="d-flex align-items-center text-secondary">
                                    <strong>Caricamento...</strong>
                                    <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                                </div>
                            </a>
                            @if(!empty($listDescrArts))
                            @foreach($listDescrArts as $i => $product)
                    
                            <a class="list-group-item list-group-item-action" wire:click="selectedArt({{ $product['id_art'] }})">
                                <div class="d-flex w-100 justify-content-between">
                                    <p class="mb-1">{{ $product['id_art'] }} - {{ $product['descr'] }}</p>
                                </div>
                            </a>
                    
                            @endforeach
                            @else
                            <a class="list-group-item">
                                <div class="search-title">Nessun risultato...
                                </div>
                                <div class="search-path"></div>
                            </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </td>
                @endif
                <td>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" readonly wire:model.lazy="umArt">
                    </div>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <input type="number" class="form-control" style="text-align:right;" wire:model="quantity">
                    </div>
                    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <button class="btn btn-sm btn-success" type="button" wire:click="addToCart">
                            <i class="fas fa-fw fa-cart-plus"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@push('css')
    <style>
        .myDropdownList {
            max-height: 400px;
            margin-bottom: 10px;
            overflow-y: scroll;
            -webkit-overflow-scrolling: touch;
        }
    
        .myDropdownDiv {
            position: absolute;
            width: auto;
            overflow-y: auto;
            padding-top: 5px;
            /* background: white; */
            /* border-bottom-left-radius: 10px; */
            /* border-bottom-right-radius: 10px; */
            /* max-height: 200px; */
            /* border: 1px solid gray; */
            /*This is relative to the navbar now*/
            /* left: 0;
            right: 0;
            top: 40px; */
        }
    
        @media screen and (max-width: 500px) {
            .myDropdownDiv {
                width: auto;
            }
        }
    
        .myDropdownDiv a:link,
        a:visited,
        a:hover,
        a:active {
            color: #000;
        }
    
        .myDropdownDiv a:hover,
        a:active {
            background-color: lightblue;
            cursor: pointer;
        }
    </style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#addCart').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "aaSorting": [],
            "responsive": true,
            "columnDefs": [
            { "responsivePriority": 1, "targets": 1 },
            { "responsivePriority": 2, "targets": -2 },
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
            }
            }
        });    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            if(message.component.fingerprint.name=='add-cart'){
                if ( $.fn.dataTable.isDataTable( '#addCart' ) ) {
                    table = $('#addCart').DataTable();
                    table.clear().destroy();
                }
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            if(message.component.fingerprint.name=='add-cart'){
                $('#addCart').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "aaSorting": [],
                "responsive": true,
                "columnDefs": [
                { "responsivePriority": 1, "targets": 1 },
                { "responsivePriority": 2, "targets": -2 },
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
                }
                }
                });
            }
        });
    });
    document.addEventListener("click", function(evt) {
        var flyoutElement = document.getElementById('dropdownList'),
        targetElement = evt.target; // clicked element
        if(document.getElementById('dropdownList')){
            do {
                if (targetElement == flyoutElement) {
                    // This is a click inside. Do nothing, just return.
                    return;
                }
                // Go up the DOM
                targetElement = targetElement.parentNode;
            } while (targetElement);
            // This is a click outside.
            Livewire.emit('resetLists')
        } else {
        return;
        }
    });
</script>
@endpush
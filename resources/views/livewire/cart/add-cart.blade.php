<div>
    <table class="table table-hover table-condensed" id="addCart">
        <col width='3%'>
        <col width='10%'>
        <col width='10%'>
        <col width='35%'>
        <col width='6%'>
        <col width='10%'>
        <col width='3%'>
        <col width='10%'>
        <col width='10%'>
        <col width='3%'>
        <thead style="display: none">
            <tr>
                <th>#</th>
                <th>Cod.Art.</th>
                <th>Vs Cod.Art.</th>
                <th>Descrizione</th>
                <th>UM</th>
                <th>Quantità</th>
                <th>Stock</th>
                <th>Prezzo</th>
                <th>Totale</th>
                <th></th>
            </tr>
        </thead>
            <tbody style="background-color: lightgrey">
                <tr @if($isToogleSearch) style="display:none;" @endif>
                    <td>
                        <div class="input-group input-group-sm">
                            @if (!$isArtSelected)
                            <button class="btn btn-sm btn-outline-primary" type="button" wire:click="toogleSearch"
                                data-toggle="tooltip" data-placement="bottom" title="Descrizione Libera">
                                <i class="fas fa-fw fa-pen-alt"></i>
                            </button>
                            @else
                            <button class="btn btn-sm btn-outline-warning" type="button" wire:click="resetAll" data-toggle="tooltip"
                                data-placement="bottom" title="Reset Valori">
                                <i class="fas fa-fw fa-undo"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="text" placeholder="Cod.Art."
                                wire:model.debounce.1000ms="idArt" wire:keydown.enter="searchListArt" @if ($isArtSelected) readonly
                                @endif>
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
            
                                <a class="list-group-item list-group-item-action"
                                    wire:click="selectedArt({{ $product['id_art'] }})">
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
                            <input class="form-control form-control-navbar" type="text" placeholder="Vs Cod.Art."
                                wire:model.debounce.1000ms="skuCustom" @if($isArtSelected) readonly @endif>
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
            
                                <a class="list-group-item list-group-item-action"
                                    wire:click="selectedArt({{ $product['id_art'] }})">
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
                            <input class="form-control form-control-navbar" type="text" placeholder="Descrizione"
                                wire:model.debounce.1000ms="descrArt" @if($isArtSelected) readonly @endif>
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
            
                                <a class="list-group-item list-group-item-action"
                                    wire:click="selectedArt({{ $product['id_art'] }})">
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
                            <input type="text" class="form-control" readonly wire:model.lazy="umArt">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control" style="text-align:right;" step='0.5' wire:model="quantity">
                        </div>
                        @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
                    </td>
                    <td>
                        @if ($art)
                        @php
                        $giac = $art->maggiac->esistenza;
                        @endphp
                        @if ($quantity < $giac) <svg height="20" width="20">
                            <circle cx="10" cy="10" r="8" fill="green" style="opacity:0.8" />
                            </svg>
                            @elseif ($quantity > $giac && $giac>0)
                            <svg height="20" width="20">
                                <circle cx="10" cy="10" r="8" fill="orange" style="opacity:0.8" />
                            </svg>
                            @else
                            <svg height="20" width="20">
                                <circle cx="10" cy="10" r="8" fill="red" style="opacity:0.8" />
                            </svg>
                            @endif
                            @endif
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="etx" class="form-control" style="text-align:right;" readonly wire:model.lazy="price">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" style="text-align:right;" readonly wire:model.lazy="total">
                        </div>
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-sm btn-success" type="button" @if($importfromDoc) disabled @endif
                                wire:click="addToCart">
                                <i class="fas fa-fw fa-cart-plus"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            
                <tr @if(!$isToogleSearch) style="display:none;" @endif>
                    <td>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-sm btn-outline-primary" type="button" wire:click="toogleSearch" data-toggle="tooltip"
                                data-placement="bottom" title="Descrizione Libera">
                                <i class="fas fa-fw fa-pen-alt"></i>
                            </button>
                        </div>
                    </td>
                    <td colspan="9">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="text" placeholder="Descrizione Libera"
                                wire:model="freeDescr" @if($isArtSelected) readonly @endif>
                        </div>
                        {{-- <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="text" placeholder="Descrizione Libera">
                        </div> --}}
                    </td>
                    <td>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-sm btn-success" type="button" wire:click="addFreeDescr">
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
            z-index: 10;
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
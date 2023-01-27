<div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cerca Prodotti" wire:model.lazy="searchString" wire:keydown.enter="loadProducts">
                <div class="input-group-append">
                    <a href="#" class="input-group-text"><i class="fas fa-fw fa-search"></i></a>
                </div>
            </div>
            <hr>
            <div id="myCustomControl" class="form-group d-flex justify-content-around">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="codeArtSwitch" wire:model="codeArtSwitch" checked>
                    <label class="custom-control-label" for="codeArtSwitch">Codice Articolo</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="descrSwitch" wire:model="descrSwitch" checked>
                    <label class="custom-control-label" for="descrSwitch" >Descrizione</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="barcodeSwitch" wire:model="barcodeSwitch" checked>
                    <label class="custom-control-label" for="barcodeSwitch" >Barcode</label>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customCodeSwitch" wire:model="customCodeSwitch" checked>
                    <label class="custom-control-label" for="customCodeSwitch">Codice Personalizzato</label>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
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
            
            <table class="table table-hover table-condensed dtTbls_full" id="listDocs">
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
                <tbody>
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
                        <td style="text-align: right">{{ number_format((float)round($prod->prezzo_1,3), 2, ',', '') }} €</td>
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

@push('js')
<script>
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            if ( $.fn.dataTable.isDataTable( '.dtTbls_full' ) ) {
            table = $('.dtTbls_full').DataTable("responsive": true);
            }
    }); });
</script>
@endpush
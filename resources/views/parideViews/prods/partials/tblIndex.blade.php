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
                    @if($prod->skuCustomCode->count()>0 && RedisUser::get('role')=='client')
                    [{{ $prod->skuCustomCode->sku_code }}]
                    @endif
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
            {{-- <td>{{ $prod->id_cod_bar }}</td>
            <td>[{{ $prod->id_cli_for }}]
                @if($prod->supplier)
                - {{ $prod->supplier->rag_soc }}
                @endif
            </td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
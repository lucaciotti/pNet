<table class="table table-hover table-condensed dtTbls_full" id="listDocs">
    <thead>
        <th>{{ trans('prod.codeArt') }}</th>
        <th>{{ trans('prod.descArt') }}</th>
        <th>Famiglia Prodotto</th>
        <th>Prezzo</th>
        <th>UM</th>
        <th>Disponibilità</th>
        {{-- <th>Barcode</th>
                <th>Forn.</th> --}}
    </thead>
    <tbody>
        @foreach ($products as $prod)
        <tr>
            <td>
                <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a>
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
            <td>{{ $prod->prezzo_1 }}</td>
            <td>{{ $prod->um }}</td>
            <td>{{ $prod->magGiac->esistenza }}</td>
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
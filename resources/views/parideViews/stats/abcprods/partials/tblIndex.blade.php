<table class="table table-hover table-condensed dtTbls_full" id="listDocs">
    <thead>
        <th>{{ trans('prod.codeArt') }}</th>
        <th>{{ trans('prod.descArt') }}</th>
        {{-- <th>Famiglia Prodotto</th> --}}
        <th>Lista Docs</th>
        <th>Prezzo Medio</th>
        <th>Qta Tot.</th>
        <th>UM</th>
        {{-- <th>Barcode</th>
                <th>Forn.</th> --}}
    </thead>
    <tbody>
        @foreach ($abcProds as $prod)
        <tr>
            <td>
                <a class="thumbnail" href="{{ route('product::detail', $prod->id_art) }}">
                    {{ $prod->id_art }}
                    <span>
                        @if (!empty($prod->product->nome_foto))
                            <img src="{{ Thumbnail::src($prod->product->nome_foto)->widen(400)->url() }}"/>
                        @endif
                    </span>
                </a>
                {{-- <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a> --}}
                {{-- @if ($prod->product->non_attivo=='1')
                <span class="right badge badge-danger">NON ATTIVO</span>
                @endif --}}
            </td>
            @if ($prod->product)
                <td>{{ $prod->product->descr }}</td>
                {{-- <td>[{{ $prod->product->id_fam }}]
                    @if($prod->product->grpProd)
                    - {{ $prod->product->grpProd->descr }}
                    @endif
                </td> --}}
                <td>
                    <form id="{{ $prod->id_art }}_toDoc" action="{{ route('abcProds::artToDocs') }}" method="post" target="_blank">
                        {!! csrf_field() !!}
                        <input type="hidden" name="startDate" value={{ $startDate }}>
                        <input type="hidden" name="endDate" value="{{ $endDate }}">
                        <input type="hidden" name="idArt" value="{{ $prod->id_art }}">
                        <input type="hidden" name="client" value="{{ base64_encode(serialize($client)) }}">
                        {{-- <a href='javascript(0);' onclick="$('#{{ $prod->id_art }}_toDoc').submit()">Lista Documenti</a> --}}
                        <button type="submit" class="btn btn-sm btn-default">
                            <i class="fa fa-external-link-alt text-primary"></i>
                        </button>
                    </form>
                </td>
                <td style="text-align: right">{{ number_format((float)round($prod->val/$prod->qta,3), 2, ',', '') }} €</td>
                <td style="text-align:right;">{{ number_format((float)$prod->qta, 2, ',', '') }} </td>
                <td>{{ $prod->product->um }}</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
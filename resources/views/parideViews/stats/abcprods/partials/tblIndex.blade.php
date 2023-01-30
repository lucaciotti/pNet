<table class="table table-hover table-condensed dtTbls_statAbc" id="listDocs">
    <thead>
        <th>{{ trans('prod.codeArt') }}</th>
        <th>{{ trans('prod.descArt') }}</th>
        {{-- <th>Famiglia Prodotto</th> --}}
        <th>Lista Docs</th>
        <th>Prezzo Medio</th>
        <th>Qta Tot.</th>
        <th>UM</th>
        @if (!in_array(RedisUser::get('role'), ['client']))
        <th>Valore</th>
        @endif
        {{-- <th>Barcode</th>
                <th>Forn.</th> --}}
    </thead>
    <tbody>
        @foreach ($abcProds as $prod)
        <tr>
            <td>
                @if (!empty($prod->product->nome_foto))
                <a class="thumbnail" href="{{ route('product::detail', $prod->id_art) }}">
                    {{ $prod->id_art }}
                    <span>
                        <img src="{{ Thumbnail::src($prod->product->nome_foto)->widen(400)->url() }}"/>
                    </span>
                </a>
                @else
                    <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a>
                @endif
                {{-- @if ($prod->product->non_attivo=='1')
                <span class="right badge badge-danger">NON ATTIVO</span>
                @endif --}}
            </td>
            <td>@if ($prod->product){{ $prod->product->descr }} @endif</td>
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
            <td>@if ($prod->product){{ $prod->product->um }} @endif</td>
            @if (!in_array(RedisUser::get('role'), ['client']))
            <td>{{ currency($prod->val) }}</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
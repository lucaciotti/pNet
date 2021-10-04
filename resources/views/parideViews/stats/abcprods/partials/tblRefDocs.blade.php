<table class="table table-hover table-condensed dtTbls_full" id="listDocs">
    <thead>
        <th>{{ trans('doc.typeDoc') }}</th>
        <th>{{ trans('doc.#Doc') }}</th>
        <th>{{ trans('doc.dateDoc_condensed') }}</th>
        <th>{{ trans('doc.client') }}</th>
        <th>Qta</th>
        <th>UM</th>
        {{-- <th>Prezzo Un.</th>
        <th>Sconto</th>
        <th>Prezzo Tot.</th> --}}
    </thead>
    <tbody>
        @foreach ($docs as $doc)
            @foreach ($doc->rows as $row)
                <tr>
                    <td>{{ $doc->descr_tipodoc }}</td>
                    <td>
                        <a href="{{ route('doc::detail', [$doc->tipodoc, $doc->id_doc]) }}"> {{ $doc->num }} </a>
                    </td>
                    <td><span class='date'>{{$doc->data->format('Ymd')}}</span>{{ $doc->data->format('d-m-Y') }}</td>
                    <td>
                        {{ $doc->client->rag_soc ?? '' }} [
                        <a href="{{ route('client::detail', [$doc->id_cli_for]) }}" target="_blank">
                            {{ $doc->id_cli_for }}
                        </a>
                        ]
                    </td>
                    <td>{{ $row->qtarow }}</td>
                    <td>{{ $row->um }}</td>
                    {{-- <td>{{ number_format((float)round($row->prezzo,3), 3, ',', '') }} €</td>
                    <td>{{ $row->sc1+$row->sc2 }}</td>
                    <td>{{ currency($row->val_riga) }}</td> --}}
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
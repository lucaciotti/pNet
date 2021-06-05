<table class="table table-hover table-condensed dtTbls_full">
    <thead>
        <th>Tipo Doc.</th>
        <th>Numero Doc.</th>
        <th>Data Doc.</th>
        <th>Cliente</th>
        <th>Inviato</th>
        <th>Data Invio</th>
        <th>    </th>
    </thead>
    <tbody>
        @foreach ($docListed as $doc)
        <tr>
            <td>{{ $doc->tipo_doc }}</td>
            <td>{{ $doc->ddt->num }}</td>
            <td>{{ $doc->ddt->data }}</td>
            <td>
                @if (!empty($doc->client))
                {{ $doc->id_cli }} - {{ $doc->client->rag_soc ?? 'NONE' }}
                @endif
            </td>
            <td>
                @if ($doc->inviato)
                Inviato
                @else
                -
                @endif
            </td>
            <td>
                @if (!empty($doc->inviato))
                {{ $doc->updated_at }}
                @else
                -
                @endif
            </td>
            <td>
                <a href="{{ route('doc::sendDdt', $doc->id ) }}">
                    <button type="submit" id="send-ddt-{{ $doc->id }}" class="btn btn-block btn-outline-warning">
                        <i class="fas fa-at"></i>&nbsp;&nbsp;Invia
                    </button>
                </a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
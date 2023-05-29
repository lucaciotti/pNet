{{-- @if($tipomodulo)
  @else --}}
  {{-- <table class="table table-hover table-condensed dtTbls_light nowrap" id="listDocs"> --}}
    {{-- @endif --}}
<table class="table table-hover table-condensed dtTbls_full_Tot" id="listDocs">
  <thead>
    <th>{{ trans('doc.typeDoc') }}</th>
    <th>{{ trans('doc.#Doc') }}</th>
    <th>{{ trans('doc.dateDoc_condensed') }}</th>
    <th>{{ trans('doc.client') }}</th>
    {{-- <th>{{ trans('doc.referenceDoc_condensed') }}</th> --}}
    <th>CSV</th>
    <th>PDF</th>
  </thead>
    {{-- <tfoot>
      <tr>
        <th colspan="5" style="text-align:right">{{ trans('doc.totDoc_condensed') }}:</th>
        <th colspan="5" style="text-align:right"></th>
        <th></th>
      </tr>
    </tfoot> --}}
  <tbody>
    @foreach ($docs as $doc)
     <tr>
        <td>Ordine Web</td>
        <td>
          <a href="{{ route('cart::docdetail', $doc->id) }}"> {{ $doc->id }} </a>
           {{-- {{ $doc->id }} --}}
        </td>
        <td><span class='date'>{{$doc->created_at->format('Ymd')}}</span>{{ $doc->created_at->format('d-m-Y') }}</td>
        <td>{{ $doc->client->rag_soc ?? '' }} [<a href="{{ route('client::detail', [$doc->id_cli_for]) }}" target="_blank"> {{ $doc->id_cli_for }} </a>]</td>
        {{-- <td>{{ $doc->rif_num or '-' }}</td> --}}
        <td>
          <a class="btn-sm btn-default" href="{{ route('cart::exportCsv', $doc->id ) }}" target="_blank">
            <i class="fa fa-file-text-o fa-lg text-warning"></i>
          </a>
        </td>
        <td>
          <a class="btn-sm btn-default" href="{{ route('cart::downloadPDF', $doc->id ) }}" target="_blank">
            <i class="fa fa-file-pdf-o fa-lg text-danger"></i>
          </a>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
{{--
@push('scripts')
    <script>
    $(document).ready(function() {
      $('#listDocs').DataTable( {
          "order": [[ 3, "desc" ]]
      } );
    } );
    </script>
@endpush --}}

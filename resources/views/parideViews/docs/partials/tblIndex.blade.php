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
    <th>{{ trans('doc.totDoc_condensed') }}</th>
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
        <td>{{ $doc->descr_tipodoc }}</td>
        <td>
          <a href="{{ route('doc::detail', [$doc->tipodoc, $doc->id_doc]) }}"> {{ $doc->num }} </a>
        </td>
        <td><span class='date'>{{$doc->data->format('Ymd')}}</span>{{ $doc->data->format('d-m-Y') }}</td>
        <td>{{ $doc->client->rag_soc }} [{{ $doc->id_cli_for }}]</td>
        {{-- <td>{{ $doc->rif_num or '-' }}</td> --}}
        <td>{{ currency($doc->tot_imp) }}</td>
        <td>
          <a class="btn-sm btn-default" href="{{ route('doc::downloadPDF', [$doc->tipodoc, $doc->id_doc] ) }}" target="_blank">
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


  <table class="table table-hover table-condensed dtTbls_total">
    <thead>
      <th>{{ trans('doc.#Row') }}</th>
      <th>{{ trans('doc.codeArt') }}</th>
      <th>Vs.Cod.Interno</th>
      <th>{{ trans('doc.descArt') }}</th>
      <th>{{ trans('doc.quantity_condensed') }}</th>
      <th>Prezzo Tot.</th>
    </thead>
    <tbody>
      @php
        $num_row = 0;
      @endphp
      @foreach ($head->rows as $row)
        @php
        $num_row += 1;
        @endphp
        <tr>
          <td>{{ $num_row }}</td>
          @if ($row->id_art!=0)
            <td><a href="{{ route('product::detail', $row->id_art) }}"> {{ $row->id_art }} </a></td>
          @else
            <td> - </td>
          @endif
          <td>{{ $row->skuCustomCode->sku_code ?? '' }}</td>
          <td>{{ $row->descr ?? '' }}</td>
          <td style="text-align: center;">
            {{ $row->quantity }} {{ $row->product->um ?? '' }} 
          </td>
          <td style="text-align: center;">
            {{ $row->val_riga }} €
          </td>
        </tr>
      @endforeach
    </tbody>
    
  </table>


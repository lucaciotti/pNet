@if ($stampaPrezzi)
  <table class="table table-hover table-condensed dtTbls_total">
    <thead>
      <th>{{ trans('doc.#Row') }}</th>
      <th>{{ trans('doc.codeArt') }}</th>
      <th>Vs.Cod.Interno</th>
      <th>{{ trans('doc.descArt') }}</th>
      @if($head->tipomodulo!='O')
        <th>{{ trans('doc.quantity_condensed') }}</th>
        <th>{{ trans('doc.unitPrice') }}</th>
        <th>{{ trans('doc.discount') }}</th>
      @elseif($head->tipomodulo=='O')
        <th>{{ trans('doc.quantity_condensed') }}</th>
        <th>{{ trans('doc.quantity_residual') }}</th>
        <th>{{ trans('doc.dateDispach_condensed') }}</th>
      @endif
      <th>{{ trans('doc.totPrice') }}</th>
      <th>Iva</th>
    </thead>
    <tfoot>
      <tr>
        <th colspan="6" style="text-align:right">{{ trans('doc.totMerce') }}:</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </tfoot>
    <tbody>
      @php
        $num_row = 0;
      @endphp
      @foreach ($head->rows as $row)
        @php
        $num_row += 1;
        @endphp
        @if($head->tipomodulo!='O')
          <tr>
            <td>{{ $num_row }}</td>
            @if ($row->id_art!=0)
              <td><a href="{{ route('product::detail', $row->id_art) }}"> {{ $row->id_art }} </a></td>
            @else
              <td> - </td>
            @endif
            <td>{{ $row->skuCustomCode->sku_code ?? '' }}</td>
            <td>{{ $row->descr }}</td>
            <td>@if ($row->prezzo!=0){{ $row->qtarow }} {{ $row->um }}@endif</td>
            <td>@if ($row->prezzo!=0){{ number_format((float)round($row->prezzo,3), 3, ',', '') }} €@endif</td>
            <td>@if ($row->prezzo!=0){{ $row->sc1+$row->sc2 }}@endif</td>
            <td>@if ($row->prezzo!=0){{ currency($row->val_riga) }}@endif</td>
            <td>@if ($row->tva) {{ $row->tva->perc }} % @endif</td>
          </tr>
        @elseif($head->tipomodulo=='O')
          <tr>
            <td>{{ $num_row }}</td>
            @if ($row->id_art!=0)
            <td><a href="{{ route('product::detail', $row->id_art) }}"> {{ $row->id_art }} </a></td>
            @else
            <td> - </td>
            @endif
              {{-- &nbsp
              @if($row->u_dtpronto)
                <a href="#" data-toggle="popover" title="Dispach Date" data-content="{{ $row->u_dtpronto->format('d-m-Y') }}">
                  <i class="fa fa-info-circle"> </i>
                </a>
              @endif --}}
            </td>
            <td>{{ $row->skuCustomCode->sku_code ?? '' }}</td>
            <td>{{ $row->descr }}</td>
            <td>@if ($row->um!=''){{ $row->qtarow }}@endif</td>
            <td>
              @if($row->qtares>0)
                @if ($row->um!='') {{ $row->qtares }} @endif
              @else
                -
              @endif
            </td>
            <td>            
                @if($row->data_eva) {{ $row->data_eva->format('d-m-Y') }} @endif
            </td>
            <td>@if ($row->um!='') {{ currency($row->val_riga) }} @endif</td>
            <td>@if ($row->tva) {{ $row->tva->perc }} % @endif</td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
@else
  <table class="table table-hover table-condensed dtTbls_light">
    <col width="30">
    <col width="100">
    <col width="100">
    <col width="250">
    <col width="80">
    @if($head->tipomodulo=='O')
    <col width="80">
    @endif
    @if($head->tipomodulo=='O')
    <col width="100">
    @endif
    <thead>
      <th>{{ trans('doc.#Row') }}</th>
      <th>{{ trans('doc.codeArt') }}</th>
      <th>Vs.Cod.Interno</th>
      <th>{{ trans('doc.descArt') }}</th>
      <th>{{ trans('doc.quantity_condensed') }}</th>
      @if($head->tipomodulo=='O')
      <th>{{ trans('doc.quantity_residual') }}</th>
      @endif
      @if($head->tipomodulo=='O')
      <th>{{ trans('doc.dateDispach_condensed') }}</th>
      @endif
    </thead>
    <tbody>
      @php
      $totMerce=0;
      $totOmaggio=0;
      // $totIvaOmaggio=0;
      $totProvv=0;
      $provvParziale=0;
      $provv="";

      $num_row = 0;
      @endphp
      @foreach ($head->rows as $row)
      @php
      $num_row += 1;
      @endphp
      <tr>
        <td style="text-align: center;">{{ $num_row }}</td>
        @if ($row->id_art!=0)
        <td><a href="{{ route('product::detail', $row->id_art) }}"> {{ $row->id_art }} </a></td>
        @else
        <td> - </td>
        @endif
        <td>{{ $row->skuCustomCode->sku_code ?? '' }}</td>
        <td>
          {{ $row->descr }}
        </td>
        <td style="text-align: center;">
          @if ($row->um!='') {{ $row->qtarow }} {{ $row->um }} @endif
        </td>
        @if($head->tipomodulo=='O')
        <td style="text-align: center;">@if ($row->um!='') {{ $row->qtares }} @endif</td>
        @endif
        @if($head->tipomodulo=='O')
        <td style="text-align: center;">
          @if($row->data_eva)
          {{ $row->data_eva->format('d-m-Y') }}
          @endif
        </td>
        @endif
        @php
        $totMerce=$totMerce+$row->val_riga;
        $totOmaggio=$totOmaggio+(($row->ommerce) ? $row->val_riga : 0);
        // $totIvaOmaggio=$totIvaOmaggio+(($row->omiva) ? $row->prezzotot : 0);
        // $provvParziale=($row->prezzotot>0) ? floatval(str_replace(",",".",$row->provv))/100*$row->prezzotot : 0;
        // $totProvv=$totProvv+$provvParziale;
        // $provv=($row->prezzotot>0) ? (($row->provv!="") ? $row->provv : "0") : "";
        @endphp
        {{-- @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' || $head->tipodoc == 'PP'))
                      <td style="text-align: center;">
                          @if($row->prezzotot>0) {{ $provv }} % @endif
        </td>
        <td style="text-align: right;">
          @if($row->prezzotot>0) {{ currency($provvParziale) }}@endif
        </td>
        @endif --}}
      </tr>
      @endforeach
    </tbody>
    
  </table>
@endif

<table class="table table-hover table-condensed">
    <col width="30">
    <col width="100">
    <col width="100">
    <col width="250">
    <col width="80">
    @if($head->tipomodulo=='O')
    <col width="80">
    @endif
    @if ($stampaPrezzi)
        <col width="80">
        <col width="80">
    @endif
    @if($head->tipomodulo=='O')
    <col width="100">
    @endif
    @if ($stampaPrezzi)
        <col width="80">
        <col width="50">
    @endif
    {{-- @if (!in_array(RedisUser::get('role'), ['client']))
    <col width="80">
    <col width="80">
    @endif --}}
    <thead>
        <th>{{ trans('doc.#Row') }}</th>
        <th>{{ trans('doc.codeArt') }}</th>
        <th>Vs.Cod.Interno</th>
        <th>{{ trans('doc.descArt') }}</th>
        <th>{{ trans('doc.quantity_condensed') }}</th>
        @if($head->tipomodulo=='O')
        <th>{{ trans('doc.quantity_residual') }}</th>
        @endif
        @if ($stampaPrezzi)
        <th>{{ trans('doc.unitPrice') }}</th>
        <th>{{ trans('doc.discount') }}</th>
        @endif
        @if($head->tipomodulo=='O')
        <th>{{ trans('doc.dateDispach_condensed') }}</th>
        @endif
        @if ($stampaPrezzi)
        <th>{{ trans('doc.totPrice') }}</th>
        <th>Iva</th>
        @endif
        {{-- @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' || $head->tipodoc == 'PP'))
        <th>Provv %</th>
        <th>Provv €</th>
        @endif --}}
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
                    {{ Illuminate\Support\Str::ucfirst(Illuminate\Support\Str::lower($row->descr)) }}
                </td>
                <td style="text-align: center;">
                    @if ($row->um!='') {{ $row->qtarow }} {{ $row->um }} @endif
                </td>
                @if($head->tipomodulo=='O')
                <td style="text-align: center;">@if ($row->um!='') {{ $row->qtares }} @endif</td>
                @endif
                @if ($stampaPrezzi)
                    @if($row->ommerce)
                        <td colspan="2" style="text-align: center;"><strong> FREE OF CHARGE</strong></td>
                    @else
                        <td style="text-align: right;">@if ($row->prezzo!=0){{ number_format((float)round($row->prezzo,3), 3, ',', '') }} €@endif</td>
                        <td style="text-align: center;">@if ($row->prezzo!=0){{ $row->sc1+$row->sc2 }}@endif</td>
                    @endif
                @endif
                @if($head->tipomodulo=='O')
                <td style="text-align: center;">
                    @if($row->data_eva)
                        {{ $row->data_eva->format('d-m-Y') }}
                    @endif                   
                </td>
                @endif
                @if ($stampaPrezzi)
                    <td style="text-align: right;">@if ($row->prezzo!=0){{ currency($row->val_riga) }}@endif</td>
                    <td style="text-align: right;">@if ($row->tva) {{ $row->tva->perc }} % @endif</td>
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
    @if ($stampaPrezzi)
        <tfoot>
            <tr>
                <th @if($head->tipomodulo=='O') colspan="9" @else colspan="7" @endif style="text-align:right">Total:</th>
                <th style="text-align: right;">{{ currency($totMerce) }}</th>
                <th></th>
                {{-- @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' || $head->tipodoc == 'PP'))
                <th></th>
                <th style="text-align: right;">{{ currency($totProvv) }}</th>
                @endif --}}
            </tr>
        </tfoot>
    @endif
</table>

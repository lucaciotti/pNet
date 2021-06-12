<table class="table table-hover table-condensed">
    <col width="30">
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
    @endif
    {{-- @if (!in_array(RedisUser::get('role'), ['client']))
    <col width="80">
    <col width="80">
    @endif --}}
    <thead>
        <th>{{ trans('doc.#Row') }}</th>
        <th>{{ trans('doc.codeArt') }}</th>
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
                <td>
                    {{ Illuminate\Support\Str::ucfirst(Illuminate\Support\Str::lower($row->descr)) }}
                </td>
                <td style="text-align: center;">
                    {{ $row->qtarow }} {{ $row->um }}
                </td>
                @if($head->tipomodulo=='O')
                <td style="text-align: center;">{{ $row->qtares }}</td>
                @endif
                @if ($stampaPrezzi)
                    @if($row->ommerce)
                        <td colspan="2" style="text-align: center;"><strong> FREE OF CHARGE</strong></td>
                    @else
                        <td style="text-align: right;">@if ($row->prezzo!=0){{ $row->prezzo }} €@endif</td>
                        <td style="text-align: center;">@if ($row->prezzo!=0){{ $row->sc1+$row->sc2 }}@endif</td>
                    @endif
                @endif
                @if($head->tipomodulo=='O')
                <td style="text-align: center;">
                    @if (in_array(RedisUser::get('role'), ['client']))
                        @if($row->u_dtpronto)
                            {{ $row->u_dtpronto->format('d-m-Y') }}
                        @else
                            @if($row->dataconseg)
                                {{ $row->dataconseg->format('d-m-Y') }}
                            @endif
                        @endif
                    @else
                        @if($row->dataconseg) {{ $row->dataconseg->format('d-m-Y') }} @endif
                    @endif
                </td>
                @endif
                @if ($stampaPrezzi)
                    <td style="text-align: right;">@if ($row->prezzo!=0){{ currency($row->val_riga) }}@endif</td>
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
                <th @if($head->tipomodulo=='O') colspan="8" @else colspan="6" @endif style="text-align:right">Total:</th>
                <th style="text-align: right;">{{ currency($totMerce) }}</th>
                {{-- @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' || $head->tipodoc == 'PP'))
                <th></th>
                <th style="text-align: right;">{{ currency($totProvv) }}</th>
                @endif --}}
            </tr>
        </tfoot>
        
        @if ($head->sconti)
            <tfoot>
                <tr>
                    <th @if($head->tipomodulo=='O') colspan="9" @else colspan="7" @endif style="text-align:right">{{ trans('doc.scontoMerce') }}: {{$head->sconti}} %</th>
                    <th style="text-align: right;">{{ currency($head->totmerce) }}</th>
                    @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' ||
                    $head->tipodoc == 'PP'))
                    <th></th>
                    <th style="text-align: right;">{{ currency($totProvv-floatval($head->sconti)/100*$totProvv) }}</th>
                    @endif
                </tr>
            </tfoot>
        @endif
    
        @if ($totOmaggio>0)
        <tfoot>
            <tr>
                <th @if($head->tipomodulo=='O') colspan="9" @else colspan="7" @endif style="text-align:right">Total Value of Goods Free of Charge: </th>
                <th style="text-align: right;">{{ currency(-$totOmaggio) }}</th>
                @if (!in_array(RedisUser::get('role'), ['client']) && ($head->tipomodulo == 'F' || $head->tipomodulo == 'N' ||
                $head->tipodoc == 'PP'))
                <th></th>
                <th></th>
                @endif
            </tr>
        </tfoot>
        @endif
    @endif
</table>

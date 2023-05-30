<table class="table table-hover table-condensed">
    <col width="30">
    <col width="100">
    <col width="100">
    <col width="250">
    <col width="80">
    <col width="80">
    <col width="80">
    <col width="50">
    <thead>
        <th>{{ trans('doc.#Row') }}</th>
        <th>{{ trans('doc.codeArt') }}</th>
        <th>Vs.Cod.Interno</th>
        <th>{{ trans('doc.descArt') }}</th>
        <th>{{ trans('doc.quantity_condensed') }}</th>
        <th>{{ trans('doc.unitPrice') }}</th>
        <th>{{ trans('doc.totPrice') }}</th>
        <th>Iva</th>
    </thead>
    <tbody>
        @php
            $totMerce=0;
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
                <td style="text-align: right;">@if ($row->prezzo!=0){{ number_format((float)round($row->prezzo,3), 3, ',', '') }} €@endif</td>
                <td style="text-align: right;">@if ($row->prezzo!=0){{ currency($row->val_riga) }}@endif</td>
                <td style="text-align: right;">@if ($row->iva) {{ $row->iva }} % @endif</td>
                @php
                    $totMerce=$totMerce+$row->val_riga;
                @endphp
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align:right">Total:</th>
            <th style="text-align: right;">{{ currency($totMerce) }}</th>
            <th></th>
        </tr>
    </tfoot>
</table>

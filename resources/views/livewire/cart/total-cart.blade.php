<table border=1 frame=void rules=rows width='100%'>
    <col>
    <col width='30%'>
        <tr>
            <th>
                Totale Merce
            </th>
            <th class='text-right'>
                {{ currency($cart->get('items_subtotal')) }}
            </th>
        </tr>
        @php
        $actions=$cart->get('applied_actions');
        @endphp
        @if ($actions)
        @foreach ($actions as $action)
        <tr>
            <th>
                {{ $action->get('title') }}
            </th>
            <th class='text-right'>
                {{ currency($action->get('amount')) }}
            </th>
        </tr>
        @endforeach
        @endif
        <tr>
            <th>
                Totale Imponibile
            </th>
            <th class='text-right'>
                {{ currency($cart->get('taxable_amount')) }}
            </th>
        </tr>
        <tr>
            <th>
                Totale IVA (22%)
            </th>
            <th class='text-right'>
                + {{ currency($cart->get('tax_amount')) }}
            </th>
        </tr>
        <tfoot style="background-color: lightgrey">
            <tr>
                <th>
                    Importo Totale
                </th>
                <th class='text-right'>
                    {{ currency($cart->get('total')) }}
                </th>
            </tr>
        </tfoot>
</table>
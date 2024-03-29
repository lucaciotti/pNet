<table border=1 frame=void rules=rows width='100%'>
    <col>
    <col width='30%'>
    @if ($cart->get('items_subtotal')<50)
        @php
            $value=50-$cart->get('items_subtotal');
        @endphp
        <tr>
            <th colspan="2" class="text-center bg-primary">
                Manca un valore di {{ currency($value) }} a minimo d'ordine
            </th>
        </tr>
    @endif
    <tr>
        <th>
            Totale Merce
        </th>
        <th class='text-right'>
            {{ currency($cart->get('items_subtotal') ?? 0) }}
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
            {{ currency($action->get('amount') ?? 0) }}
        </th>
    </tr>        
    @endforeach
    @endif
    <tfoot style="background-color: lightgrey">
        <tr>
            <th>
                Importo Totale
            </th>
            <th class='text-right'>
                {{ currency($cart->get('subtotal') ?? 0) }}
            </th>
        </tr>
    </tfoot>
</table>

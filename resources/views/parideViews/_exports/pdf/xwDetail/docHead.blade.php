<span class="floatleft">
    {{-- <img src="{{ asset('/assets/img/logo_esteso.png') }}" alt="" height="130" align="left"> --}}
    <img src="data:image/jpeg;base64, {{ base64_encode(@file_get_contents(url('assets/img/logo_esteso.png'))) }}" alt="" height="130" align="left">
</span>

<span class="floatright">
    <br><br><br>
    {{-- <div class="contentSubTitle">{{ trans('doc.dataDoc') }}</div> --}}
    <dl class="dl-horizontal">
        <dt>{{ trans('doc.document') }}</dt>
        <dd>
            <strong>{{$head->descr_tipodoc}}</strong> n°
            <a href="{{ route('cart::docdetail', [$head->id]) }}">
                <strong>{{$head->id}}</strong>
            </a>
        </dd>

        <dt>{{ trans('doc.client') }}</dt>
        <dd><strong>{{$head->client->rag_soc}} [{{$head->id_cli_for}}]</strong></dd>

        <dt>{{ trans('client.vatCode') }}</dt>
        <dd>{{$head->client->p_i}}</dd>

        <dt>{{ trans('doc.dateDoc') }}</dt>
        <dd>{{$head->data->format('d/m/Y')}}</dd>

        @if ($head->rif_num)
        <dt>{{ trans('doc.referenceDoc') }}</dt>
        <dd>{{$head->rif_num}}</dd>
        @endif

    </dl>
</span>
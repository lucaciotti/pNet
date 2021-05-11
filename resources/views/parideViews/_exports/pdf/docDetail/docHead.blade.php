<span class="floatleft">
    <span class="contentSubTitle">{{ trans('doc.dataDoc') }}</span>
    <dl class="dl-horizontal">
        <dt>{{ trans('doc.document') }}</dt>
        <dd>
            <strong>{{$head->descr_tipodoc}}</strong> n°
            <a href="{{ route('doc::detail', [$tipodoc, $head->id_doc]) }}">
                <strong>{{$head->num}}</strong>
            </a>
        </dd>

        <dt>{{ trans('doc.client') }}</dt>
        <dd><strong>{{$head->nome1}} [{{$head->id_cli_for}}]</strong></dd>

        <dt>{{ trans('doc.dateDoc') }}</dt>
        <dd>{{$head->data->format('d/m/Y')}}</dd>

        {{-- @if($head->tipomodulo == 'O')
        <dt>{{ trans('doc.deliverType') }}</dt>
        <dd>{{$head->u_tipocons}}</dd>

        <dt>Prevista Consegna</dt>
        <dd>{{$head->datacons->format('d/m/Y')}}</dd>
        @endif --}}
        @if ($head->rif_num)
        <dt>{{ trans('doc.referenceDoc') }}</dt>
        <dd>{{$head->rif_num}}</dd>
        @endif

        {{-- <dt>{{ trans('client.agent') }}</dt>
        <dd>{{$head->agente}} - {{$head->agent->descrizion}}</dd> --}}
    </dl>
</span>

<span class="floatright">
    <img src="{{ asset('/assets/img/logo_esteso.png') }}" alt="" {{-- height="120" --}} width="200" align="right">
</span>
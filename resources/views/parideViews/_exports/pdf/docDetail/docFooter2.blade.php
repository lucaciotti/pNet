<span class="floatleft">
    @if($head->colli > 0)
    <span class="contentSubTitle">{{ trans('doc.dataSped') }}</span>
    <dl class="dl-horizontal">
        <dt>{{ trans('doc.nColli') }}</dt>
        <dd>{{$head->colli}}</dd>

        <dt>{{ trans('doc.goodsAspect') }}</dt>
        <dd>{{ $head->descr_aeb }}</dd>

        {{-- <dt>{{ trans('doc.volume') }}</dt>
        <dd>{{$head->volume}} mc</dd>

        <dt>{{ trans('doc.weightNet') }}</dt>
        <dd>{{$head->pesonetto}} Kg</dd> --}}
        @if($head->peso>0)
            <dt>{{ trans('doc.weightGross') }}</dt>
            <dd>{{$head->peso}} Kg</dd>
        @endif

    </dl>
    @endif
</span>



<span class="floatright20">
    <span class="contentSubTitle">{{ trans('doc.totsDoc') }}</span>
    <dl class="dl-horizontal">
        @if($head->sconto>0)
        <dt>{{ trans('doc.scontoMerce') }}</dt>
        <dd>{{$head->sconto}} %</dd>
        
        <hr class="smalldivider">
        @endif
        
        {{-- <dt>{{ trans('doc.totMerce') }}</dt>
        <dd>{{$head->totmerce}} €</dd> --}}

        @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N')
        <dt>Spese Bancarie</dt>
        <dd>{{$head->spese_ban}} €</dd>
        <hr class="smalldivider">
        @endif

        <dt>{{ trans('doc.totImp') }}</dt>
        <dd>{{$head->tot_imp}} €</dd>

        <dt>{{ trans('doc.totVat') }} ({{ $head->id_iva_c }} %)</dt>
        <dd>{{$head->tot_iva}} €</dd>

    </dl>
    @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N')
        <dl class="dl-horizontal">
            <hr class="smalldivider">

            <dt>{{ trans('doc.totDoc_condensed') }}</dt>
            <dd><strong>{{$head->tot_rit}} €</strong></dd>
        </dl>
    @endif
</span>
{{-- 
<span class="floatright20">
    @if($prevDocs->count()>0)
    <span class="contentSubTitle">{{ trans('doc.linkedDocs') }}</span>
        @foreach($prevDocs as $doc)
            <dl>
                <a href="{{ route('doc::detail', $doc->id) }}">
                    {{$doc->tipodoc}} {{$doc->numerodoc}} - {{$doc->datadoc->format('d/m/Y')}}
                </a>
                <a href="{{ route('doc::downloadPDF', $doc->id) }}">
                    [PDF]
                </a>
            </dl>
        @endforeach
    @endif
    
    @if($nextDocs->count()>0)
    <span class="contentSubTitle">{{ trans('doc.nextDocs') }}</span>
        @foreach($nextDocs as $doc)
            <dl>
                <a href="{{ route('doc::detail', $doc->id) }}" title="kNetPage">
                    {{$doc->tipodoc}} {{$doc->numerodoc}}
                </a> - {{$doc->datadoc->format('d/m/Y')}}
                <a href="{{ route('doc::downloadPDF', $doc->id) }}" title="kNetPDF">
                    [PDF]
                </a>
            </dl>
        @endforeach
    @endif

</span> --}}




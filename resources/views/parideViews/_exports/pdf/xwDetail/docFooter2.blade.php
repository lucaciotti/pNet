<span class="floatleft">
    @if($head->destinazioni)
    <span class="contentSubTitle">Destinazione Merce</span>
    <dl class="dl-horizontal">
        <dt>Ragione Sociale</dt>
        <dd>{{$head->destinazioni->rag_soc}}</dd>
        <dt>Indirizzo</dt>
        <dd>
            {{$head->destinazioni->citta}} ({{$head->destinazioni->provincia}}), {{$head->destinazioni->cap}} <br>
            {{$head->destinazioni->indirizzo}}
        </dd>
    </dl>
    @endif
</span>



<span class="floatright20">
        <span class="contentSubTitle">{{ trans('doc.totsDoc') }}</span>
        <dl class="dl-horizontal">
           
        
            <dt>{{ trans('doc.totImp') }}</dt>
            <dd>{{$head->tot_imp}} €</dd>
        
            @if($head->tot_iva > 0)
            <dt>{{ trans('doc.totVat') }}</dt>
            <dd>{{$head->tot_iva}} €</dd>
            @endif
        
        </dl>
        <dl class="dl-horizontal">
            <hr class="smalldivider">
        
            <dt>{{ trans('doc.totDoc_condensed') }}</dt>
            <dd><strong>{{$head->totale}} €</strong></dd>
        </dl>

</span>




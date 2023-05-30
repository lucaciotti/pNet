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
    @if($head->tipo_sped)
    <span class="contentSubTitle">Tipologia Spedizione</span>
    <dl class="dl-horizontal">
        <dd>{{$head->tipo_sped}}</dd>
    </dl>
    @endif
    <span class="contentSubTitle">Data Richiesta Consegna</span>
    <dl class="dl-horizontal">
        <dd>{{$head->data_eva->format('d/m/Y')}}</dd>
    </dl>
    @if($head->payType)
    <span class="contentSubTitle">Metodo Pagamento</span>
    <dl class="dl-horizontal">
        <dd>{{$head->payType->descr}}</dd>
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




<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="customDocTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="DettTab" data-toggle="pill" href="#Dett" role="tab" aria-controls="Dett"
                    aria-selected="true">Dettagli</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="SpedTab" data-toggle="pill" href="#Sped" role="tab" aria-controls="Sped"
                    aria-selected="false">Spedizione</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="TotTab" data-toggle="pill" href="#Tot" role="tab" aria-controls="Tot"
                    aria-selected="false">Totale Doc</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="customDocTabContent">
            <div class="tab-pane fade active show" id="Dett" role="tabpanel" aria-labelledby="Dett-tab">
                <dl class="dl-horizontal">
                    <dt>{{ trans('doc.document') }}</dt>
                    <dd>Ordine Web n°{{$head->id}}</dd>
                
                    <dt>{{ trans('doc.client') }}</dt>
                    <dd><strong>{{$head->client->rag_soc}} [<a href="{{ route('client::detail', [$head->id_cli_for]) }}"
                                target="_blank"> {{ $head->id_cli_for }} </a>]</strong></dd>
                
                    <dt>{{ trans('doc.dateDoc') }}</dt>
                    <dd>{{$head->created_at->format('d/m/Y')}}</dd>
                
                    <dt>{{ trans('doc.referenceDoc') }}</dt>
                    <dd>{{$head->rif_num}}</dd>

                    <hr>
                    <dt>{{ trans('doc.totDoc_condensed') }}</dt>
                    <dd><strong>{{$head->totale}} €</strong></dd>

                    <hr>
                    <dl class="dl-horizontal">
                        <dt>Tipologia Pagamento</dt>
                        <dd>{{$head->payType->descr ?? '-----'}}</dd>
                    </dl>
                </dl>
            </div>

            <div class="tab-pane fade" id="Sped" role="tabpanel" aria-labelledby="Sped-tab">
                <dl class="dl-horizontal">
                    <dt>Tipologia Spedizione</dt>
                    <dd>{{$head->tipo_sped ?? '-----'}}</dd>
                </dl>

                <dl class="dl-horizontal">
                    <dt>Data Richiesta Consegna</dt>
                    <dd>{{$head->data_eva->format('d/m/Y') }}</dd>
                </dl>

                @if($head->destinazioni)
                <hr>
                <dl class="dl-horizontal">
                    <dt>Ragione Sociale - Destinazione Merce</dt>
                    <dd>{{$head->destinazioni->rag_soc}}</dd>
                    <dt>Indirizzo</dt>
                    <dd>
                        {{$head->destinazioni->citta}} ({{$head->destinazioni->provincia}}), {{$head->destinazioni->cap}}<br>
                        {{$head->destinazioni->indirizzo}}
                    </dd>
                </dl>
                @endif
            
            </div>

            <div class="tab-pane fade" id="Tot" role="tabpanel" aria-labelledby="Tot-tab">
                
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

                <hr>
                <dl class="dl-horizontal">
                    <dt class="contentSubTitle">Tipologia Pagamento</dt>
                    <dd>{{$head->payType->descr ?? '-----'}}</dd>
                </dl>
            </div>
            
        </div>
    </div>
    <!-- /.card -->
</div>
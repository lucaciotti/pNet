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
                    <dd>{{$head->descr_tipodoc}} n°{{$head->num}}</dd>
                
                    <dt>{{ trans('doc.client') }}</dt>
                    <dd><strong>{{$head->client->rag_soc}} [<a href="{{ route('client::detail', [$head->id_cli_for]) }}"
                                target="_blank"> {{ $head->id_cli_for }} </a>]</strong></dd>
                
                    <dt>{{ trans('doc.dateDoc') }}</dt>
                    <dd>{{$head->data->format('d/m/Y')}}</dd>
                
                    <dt>{{ trans('doc.referenceDoc') }}</dt>
                    <dd>{{$head->rif_num or ''}}</dd>
                    
                    @if ($stampaPrezzi)
                        <hr>
                        
                        @if(($head->tipomodulo == 'F' && $head->tipodoc != 'FP') || $head->tipomodulo == 'N')
                        
                        <dt>{{ trans('doc.totDoc_condensed') }}</dt>
                        <dd><strong>{{$head->tot_rit}} €</strong></dd>
                        @else
                        @php
                        $totDoc = $head->tot_imp+$head->tot_iva;
                        @endphp
                        <dt>{{ trans('doc.totDoc_condensed') }}</dt>
                        <dd><strong>{{$totDoc}} €</strong></dd>
                        @endif
                    @endif

                    <hr>
                    <dl class="dl-horizontal">
                        <dt>Tipologia Pagamento</dt>
                        <dd>{{$head->payType->descr ?? '-----'}}</dd>
                        @if ($head->pagato)
                        <dd><strong>[PAGATO]</strong></dd>
                        @endif
                    </dl>

                </dl>
            </div>
            <div class="tab-pane fade" id="Sped" role="tabpanel" aria-labelledby="Sped-tab">                
                @if(!$head->destinazioni)
                    @if(!empty($head->des_dive1) || !empty($head->des_dive2))
                        <h6>Destinazione Merce</h6>
                        @if(empty($head->des_dive3) && empty($head->des_dive4))
                        <dl class="dl-horizontal">
                            <dt>Indirizzo</dt>
                            <dd>{{$head->des_dive1}}</dd>
                        </dl>
                        @else
                        <dl class="dl-horizontal">
                            <dt>Ragione Sociale</dt>
                            @if(!empty($head->des_dive1))
                            <dd>{{$head->des_dive1}}</dd>
                            @else
                            <dd>{{$head->des_dive2}}</dd>
                            @endif
                            <dt>Indirizzo</dt>
                            <dd>
                                @if(!empty($head->des_dive4))
                                {{$head->des_dive4}} <br>
                                @endif
                                {{$head->des_dive3}}
                            </dd>
                        </dl>
                        @endif
                    @endif
                @else
                    <h6>Destinazione Merce</h6>
                    <dl class="dl-horizontal">
                        <dt>Ragione Sociale</dt>
                        <dd>{{$head->destinazioni->rag_soc}}</dd>
                        <dt>Indirizzo</dt>
                        <dd>
                            {{$head->destinazioni->citta}} ({{$head->destinazioni->provincia}}), {{$head->destinazioni->cap}}<br>
                            {{$head->destinazioni->indirizzo}}
                        </dd>
                    </dl>
                @endif
                
                @if($head->vettore)
                <dl class="dl-horizontal">
                    <dt>Vettore</dt>
                    <dd>{{$head->vettore->rag_soc1}}</dd>    
                    @if($head->tracking)
                        <dt>Tracking</dt>
                        @php
                            $url = ($head->vettore->info) ? str_replace('<-id_tracking->', $head->tracking, $head->vettore->info->url) : '#';
                        @endphp
                        <dd><a href="{{ $url }}" class="text-bold text-blue" target="_blank"> {{$head->tracking}} </a></dd>
                    @endif            
                </dl>
                @endif

                @if ($head->colliDetailed)
                    @foreach ($head->colliDetailed as $colli)
                        <dl class="dl-horizontal">
                            <dt>Collo n°{{ $colli->num }}</dt>
                            <dd>
                                {{$colli->lung}}x{{$colli->larg}}@if($colli->alte>0)x{{$colli->alte}}@endif cm
                                @if($colli->peso>0)
                                <br>{{ trans('doc.weightGross') }}: {{$colli->peso}} Kg
                                @endif
                            </dd>
                        </dl>
                    @endforeach
                @else
                    @if($head->colli > 0)
                    {{-- <hr> --}}
                    <dl class="dl-horizontal">
                        <dt>{{ trans('doc.nColli') }}</dt>
                        <dd>{{$head->colli}}</dd>
                    
                        <dt>{{ trans('doc.goodsAspect') }}</dt>
                        <dd>{{ $head->descr_aeb }}</dd>
                    
                        @if($head->peso>0)
                        <dt>{{ trans('doc.weightGross') }}</dt>
                        <dd>{{$head->peso}} Kg</dd>
                        @endif
                    
                    </dl>
                    @endif
                @endif
            </div>
            <div class="tab-pane fade" id="Tot" role="tabpanel" aria-labelledby="Tot-tab">
                @if ($stampaPrezzi)
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
                    
                    @if($head->tot_iva > 0)
                        <dt>{{ trans('doc.totVat') }}</dt>
                        <dd>{{$head->tot_iva}} €</dd>
                    @endif
                
                </dl>
                @if(($head->tipomodulo == 'F' && $head->tipodoc != 'FP') || $head->tipomodulo == 'N')
                    <hr class="smalldivider">
                
                    <dt>{{ trans('doc.totDoc_condensed') }}</dt>
                    <dd><strong>{{$head->tot_rit}} €</strong></dd>
                </dl>
                @else
                @php
                $totDoc = $head->tot_imp+$head->tot_iva;
                @endphp
                <dl class="dl-horizontal">
                    <hr class="smalldivider">
                
                    <dt>{{ trans('doc.totDoc_condensed') }}</dt>
                    <dd><strong>{{$totDoc}} €</strong></dd>
                </dl>
                @endif
                @endif
                
                @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N' || $head->tipomodulo == 'B')
                <dl class="dl-horizontal">
                    <dt class="contentSubTitle">Tipologia Pagamento</dt>
                    <dd>{{$head->payType->descr ?? '-----'}}</dd>
                    @if ($head->pagato)
                    <dd><strong>[PAGATO]</strong></dd>
                    @endif
                </dl>
                @endif
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>
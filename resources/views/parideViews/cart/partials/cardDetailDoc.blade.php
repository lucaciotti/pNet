<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="customDocTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="DettTab" data-toggle="pill" href="#Dett" role="tab" aria-controls="Dett"
                    aria-selected="true">Dettagli</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="customDocTabContent">
            <div class="tab-pane fade active show" id="Dett" role="tabpanel" aria-labelledby="Dett-tab">
                <dl class="dl-horizontal">
                    <dt>{{ trans('doc.document') }}</dt>
                    <dd>Ordine Web n°{{$head->num}}</dd>
                
                    <dt>{{ trans('doc.client') }}</dt>
                    <dd><strong>{{$head->client->rag_soc}} [<a href="{{ route('client::detail', [$head->id_cli_for]) }}"
                                target="_blank"> {{ $head->id_cli_for }} </a>]</strong></dd>
                
                    <dt>{{ trans('doc.dateDoc') }}</dt>
                    <dd>{{$head->created_at->format('d/m/Y')}}</dd>

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

                </dl>
            </div>
            
        </div>
    </div>
    <!-- /.card -->
</div>
@extends('adminlte::page')

@section('title_postfix', '- Client Detail')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
      {{$client->rag_soc}}
  </h1>
  <h6>[{{$client->id_cli_for}}]</h6>
  <br>
@stop

@section('content-fluid')
{{-- <div class="container"> --}}
<div class="row">
  <div class="col-lg-4">
    <div class="card card-primary card-outline card-outline-tabs">
      <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="customAnagTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="AnagTab" data-toggle="pill" href="#Anag"
              role="tab" aria-controls="Anag" aria-selected="true">{{ trans('client.dataCli') }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="ContTab" data-toggle="pill" href="#Cont"
              role="tab" aria-controls="Cont" aria-selected="false">{{ trans('client.contactCli') }}</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="customAnagTabContent">
          <div class="tab-pane fade active show" id="Anag" role="tabpanel"
            aria-labelledby="Anag-tab">
            <dl class="dl-horizontal">
              <dt>{{ trans('client.descCli') }}</dt>
              <dd>
                <big><strong>{{$client->rag_soc}}</strong></big>
                <small>{{$client->rag_soc2}}</small>
              </dd>
            
              <dt>{{ trans('client.codeCli') }}</dt>
              <dd>{{$client->id_cli_for}}</dd>

              <dt>Tipo Cliente</dt>
              @if ($client->id_tipo_cli!=0 && $client->typeCli)
              <dd>{{$client->typeCli->descr}}</dd>
              @else
              <dd> - </dd>
              @endif
            
              <dt>{{ trans('client.vatCode') }}</dt>
              <dd>{{$client->p_i}}</dd>
            
              @if($client->c_f != $client->partiva)
              <dt>{{ trans('client.taxCode') }}</dt>
              <dd>{{$client->c_f}}</dd>
              @endif
              
              <dt>Tipologia Pagamento Predefinita</dt>
              <dd>{{$client->payType->descr}}</dd>
              {{-- <dt>{{ trans('client.sector_full') }}</dt>
              <dd>{{$client->settore}} - @if($client->detSect) {{$client->detSect->descrizion}} @endif</dd> --}}
            </dl>
            
            <h4><strong> {{ trans('client.location') }} </strong> </h4>
            <hr style="padding-top: 0; margin-top:0;">
            <dl class="dl-horizontal">
            
              <dt>{{ trans('client.location') }}</dt>
              <dd>{{$client->citta}} ({{$client->provincia}}) - @if (empty($client->paese))
              I
              @else
              {{ $client->paese }}
              @endif</dd>
            
              <dt>{{ trans('client.address') }}</dt>
              <dd>{{$client->indirizzo}}</dd>
            
              <dt>{{ trans('client.posteCode') }}</dt>
              <dd>{{$client->cap}}</dd>
            </dl>
            
            <h4><strong> {{ trans('client.situationCli') }}</strong> </h4>
            <hr style="padding-top: 0; margin-top:0;">
            <dl class="dl-horizontal">            
              <dt>{{ trans('client.relationStart') }}</dt>
              <dd>{{$client->data_m}}</dd>
            
              <dt>{{ trans('client.relationEnd') }}</dt>
              <dd>{{$client->u_datafine}}</dd>
            </dl>
          </div>
          <div class="tab-pane fade" id="Cont" role="tabpanel"
            aria-labelledby="Cont-tab">
            <dl class="dl-horizontal">
            
              <dt>{{ trans('client.referencePerson') }}</dt>
              <dd>@if(!empty($client->pers_rif1)) {{$client->pers_rif1}} @else {{$client->codcliest}} @endif</dd>
             
              {{--<dt>{{ trans('client.referenceAgent') }}</dt>
              <dd>@if($client->agent) {{$client->agent->descrizion}} @endif</dd> --}}
            
              <hr>
            
              <dt>{{ trans('client.phone') }}</dt>
              <dd>{{$client->telefono}}
                @if (!empty($client->telefono))
                &nbsp;<span class="badge bg-green">
                  <a href="tel:{{$client->telefono}}"><i class="fa fa-phone"></i></a>
                </span>
                @endif
              </dd>
              <dt>{{ trans('client.fax') }}</dt>
              <dd>{{$client->fax}}</dd>
            
              <dt>{{ trans('client.phone2') }}</dt>
              <dd>{{$client->telefono1}}
                @if (!empty($client->telefono1))
                &nbsp;<span class="badge bg-green">
                  <a href="tel:{{$client->telefono1}}"><i class="fa fa-phone"></i></a>
                </span>
                @endif
              </dd>
            
              <dt>{{ trans('client.mobilePhone') }}</dt>
              <dd>{{$client->cell}}
                @if (!empty($client->cell))
                &nbsp;<a class="badge bg-green" href="tel:{{$client->cell}}"><i class="fa fa-phone"></i></a>
                @endif
              </dd>
            
              <hr>
            
              <dt>{{ trans('client.email') }}</dt>
              <dd>{{$client->e_mail}}
                @if (!empty($client->e_mail))
                &nbsp;<a class="badge bg-red" href="mailto:{{$client->e_mail}}"><i class="fa fa-envelope-o"></i></a>
                @endif
              </dd>
            
              <hr>
            
              <dt>{{ trans('client.emailAdm') }}</dt>
              <dd>{{$client->e_mail_amministrazione}}
                @if (!empty($client->e_mail_amministrazione))
                &nbsp;<a class="badge bg-red" href="mailto:{{$client->e_mail_amministrazione}}"><i class="fa fa-envelope-o"></i></a>
                @endif
              </dd>
            
              <dt>{{ trans('client.emailOrder') }}</dt>
              <dd>{{$client->e_mail_ordini}}
                @if (!empty($client->e_mail_ordini))
                &nbsp;<a class="badge bg-red" href="mailto:{{$client->e_mail_ordini}}"><i class="fa fa-envelope-o"></i></a>
                @endif
              </dd>
            
              <dt>{{ trans('client.emailDdt') }}</dt>
              <dd>{{$client->e_mail_ddt}}
                @if (!empty($client->e_mail_ddt))
                &nbsp;<a class="badge bg-red" href="mailto:{{$client->e_mail_ddt}}"><i class="fa fa-envelope-o bg-red"></i></a>
                @endif
              </dd>
            
              <dt>{{ trans('client.emailInvoice') }}</dt>
              <dd>{{$client->e_mail_fatture}}
                @if (!empty($client->e_mail_fatture))
                &nbsp;<a class="badge bg-red" href="mailto:{{$client->e_mail_fatture}}"><i class="fa fa-envelope-o bg-red"></i></a>
                @endif
              </dd>
            
            </dl>
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ trans('client.maps') }}</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div style="height: 403px; width: 100%;">
          @if($mapsException=='')
            {!! Mapper::render() !!}
          @else
            {{ $mapsException }}
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">{{ trans('client.docuCli') }}</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, '']) }}">{{ strtoupper(trans('client.allDocs')) }}</a>
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, 'P']) }}">{{ trans('client.quotes') }}</a>
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, 'O']) }}">{{ trans('client.orders') }}</a>
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, 'B']) }}">{{ trans('client.ddt') }}</a>
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, 'F']) }}">{{ trans('client.invoice') }}</a>
        <a type="button" class="btn btn-default btn-block" href="{{ route('doc::clientList', [$client->id_cli_for, 'N']) }}">{{ trans('client.notecredito') }}</a>
      </div>
    </div>
  </div>

</div>
<script type="text/javascript">

    function onMapLoad(map)
    {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    var marker = new google.maps.Marker({
                      position: pos,
                      map: map,
                      label: "#",
                      title: "You Are Here"
                    });

                    // map.setCenter(pos);
                }
            );
        }
    }
</script>

{{-- </div> --}}
@endsection

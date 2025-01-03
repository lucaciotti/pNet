@extends('adminlte::page')
@php
try {
  //code...
  LaravelMatomoTracker::setUserId(RedisUser::get('name'));
  LaravelMatomoTracker::doTrackPageView('Dettagli Prodotto - '.$prod->id_art);
} catch (\Throwable $th) {
  //throw $th;
}
@endphp
@section('title_postfix', '- Product Detail')

{{-- @section('content_header')
  <br>
  <h1 class="m-0 text-dark">
      {{$prod->id_art}}
  </h1>
  <h6>[{{$prod->descr_pos}}]</h6>
  <br>
@stop --}}

@section('content-fluid')
{{-- <div class="container"> --}}
<div class="row">
  
  <div class="col-lg-4">
    <div class="card card-outline">
      <div class="card-header">
        @if ($prod->non_attivo=='1')
            <div class="ribbon-wrapper ribbon-lg">
              <div class="ribbon bg-danger">
                NON Attivo
              </div>
            </div>
        @endif
        <h3 class="card-title">Dettagli</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div {{-- style="height: 270px; width: 100%;" --}}>          
          <dl class="dl-horizontal">
            <dt>Codice</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <big><strong>{{$prod->id_art}}</strong></big> - 
              <small>{{$prod->descr_pos}}</small>
            </dd>
          
            <dt>Descrizione Articolo</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <strong>{{$prod->descr}}</strong>
            </dd>
          
            <dt>Famiglia Prodotto</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;
              [{{$prod->master_grup}}] 
              @if ($prod->masterGrpProd)
                <strong>{{ $prod->masterGrpProd->descr }}</strong>                
              @endif
              @if ($prod->id_fam != $prod->master_grup)
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="fa fa-level-up-alt fa-rotate-90"></i>
                &nbsp;&nbsp;&nbsp;[{{$prod->id_fam}}]
                @if ($prod->grpProd)
                <strong>{{ $prod->grpProd->descr }}</strong>
                @endif
              @endif
            </dd>

              <dt>Marca</dt>
              <dd>
                &nbsp;&nbsp;&nbsp;&nbsp;
                @if ($prod->marche)
                <strong>{{ $prod->marche->descr }}</strong>              
                @endif
              </dd>
            
            @if (!in_array(RedisUser::get('role'), ['client', 'user']))
              <dt>Codice Prodotto Fornitore</dt>
              @if ($prod->supplierCodes)
                <dd>
                @foreach ($prod->supplierCodes as $supCod)
                    &nbsp;&nbsp;&nbsp;&nbsp;{{$supCod->id_cod_for}} <br>
                @endforeach
                </dd>
              @else
                <dd>
                  &nbsp;&nbsp;&nbsp;&nbsp;<big>{{$prod->id_cod_for}}</big>
                </dd>
              @endif
            @endif

            <dt>Barcodes</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;{{$prod->id_cod_bar}}
              @if($prod->barcodes)
                @foreach ($prod->barcodes as $barcode)
                  @if ($barcode->id_cod_bar != $prod->id_cod_bar)
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;{{$barcode->id_cod_bar}}
                  @endif                
                @endforeach
              @endif
            </dd>
          </dl>

          @if (!empty($prod->desc_ecom))
          <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-lg">
            Specifiche Tecniche &nbsp;&nbsp;<i class="fas fa-external-link-alt"></i>
          </button>
          @endif
          @if (!empty($prod->url))
          <a type="button" class="btn btn-primary btn-block" href="{{ $prod->url }}" target="_blank"><strong class="text-white">Link a Paride Srl eShop</strong></a>
          @endif
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Giacenza</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <label>Quantità:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ $prod->um }}</span>
          </div>
          @if ($prod->magGiac)
          <input type="text" class="form-control" readonly name="giacArt" value="{{ $prod->magGiac->esistenza }}" style="text-align:right;">
          @else
          <input type="text" class="form-control" readonly name="giacArt" value="0" style="text-align:right;">
          @endif
          <div class="input-group-append">
            <span class="input-group-text">.00</span>
          </div>
        </div>        
      </div>
    </div>

    @if (!in_array(RedisUser::get('role'), ['client', 'user', 'agent']))
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Vendute</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <label>Quantità:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ $prod->um }}</span>
          </div>
          @if ($prod->magGiac)
          <input type="text" class="form-control" readonly name="giacArt" value="{{ $prod->magGiac->qta_ven }}"
            style="text-align:right;">
          @else
          <input type="text" class="form-control" readonly name="giacArt" value="0" style="text-align:right;">
          @endif
          <div class="input-group-append">
            <span class="input-group-text">.00</span>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>

  @php
      $imageExist = ($prod->nome_foto && @fopen($prod->nome_foto, 'r'));
  @endphp
  <div class="col-lg-4">
    <div class="card @if (!$imageExist) collapsed-card @endif"> 
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Immagine</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            @if (!$imageExist)
              <i class="fas fa-plus"></i>
            @else
              <i class="fas fa-minus"></i>
            @endif
          </button>
        </div>
      </div>
      <div class="card-body">
        {{-- <div style="height: 270px; width: 100%;"> --}}
          @if ($imageExist)
            <a href="{{ $prod->nome_foto }}" data-toggle="lightbox" data-max-width="600">
              <img src="{{ $prod->nome_foto }}" height="270px" class="img-fluid">
            </a>  
          @else     
            <img src="{{ asset('assets/img/noPhoto.jpg') }}" alt="noImage" height="270px" class="img-fluid" style="display: block; margin-left: auto; margin-right: auto;">
          @endif
        {{-- </div> --}}
      </div>
    </div>
  </div>

</div>

<div class="row">

  <div class="col-lg-4">
    @if (!in_array(RedisUser::get('role'), ['client', 'user']))
      <div class="card">
        <div class="card-header">
          <h3 class="card-title" data-card-widget="collapse">Acquisto</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @if (!in_array(RedisUser::get('role'), ['agent', 'superAgent']))
          <label>Prezzo di Acquisto:</label>
          <div class="input-group">
            <input type="text" class="form-control" readonly name="prezzAcq" value="{{ round($prod->prezzo_a,3) }}"
              style="text-align:right;">
            <div class="input-group-append">
              <span class="input-group-text">€</span>
            </div>
          </div>
          @endif
      
          <label>Fornitore:</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fa fa-truck-loading"></i></span>
            </div>
            @if ($prod->supplier)
            <input type="text" class="form-control" readonly name="supplier"
              value="{{ $prod->id_cli_for }} - {{ $prod->supplier->rag_soc }}">
            @else
            <input type="text" class="form-control" readonly name="supplier" value="{{ $prod->id_cli_for }}">
            @endif
          </div>
      
        </div>
      </div>
    @endif

    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Vendita</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
  
        <label>Listino 1 (IVA escl.):</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzVend" value="{{ round($prod->prezzo_1,3) }}"
            style="text-align:right;">
          <div class="input-group-append">
            <span class="input-group-text">€ / {{ $prod->um }}</span>
          </div>
        </div>
        @if (!in_array(RedisUser::get('role'), ['client', 'user']))
          <label>Listino 2 (IVA escl.):</label>
          <div class="input-group">
            <input type="text" class="form-control" readonly name="prezzVend" value="{{ round($prod->prezzo_2,3) }}"
              style="text-align:right;">
            <div class="input-group-append">
              <span class="input-group-text">€ / {{ $prod->um }}</span>
            </div>
          </div>

          <label>Listino 3 (IVA escl.):</label>
          <div class="input-group">
            <input type="text" class="form-control" readonly name="prezzVend" value="{{ round($prod->prezzo_3,3) }}"
              style="text-align:right;">
            <div class="input-group-append">
              <span class="input-group-text">€ / {{ $prod->um }}</span>
            </div>
          </div>     
        @endif
        <hr>
        <label>IVA:</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzVend" value="{{ $prod->id_iva }}"
            style="text-align:right;">
          <div class="input-group-append">
            <span class="input-group-text">%</span>
          </div>
        </div>
  
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    {{-- <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Prodotti Simili</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('parideViews.prods.partials.tblIndex', ['products' => $productsFam])  
      </div>
    </div> --}}

    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Prodotti @if ($prod->marche)
        di <strong>{{ $prod->marche->descr }}</strong>
        @endif</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('parideViews.prods.partials.tblIndex', ['products' => $productsMarca])
      </div>
    </div>
  </div>

</div>

<div class="modal fade show" id="modal-lg" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title"><strong>{{ $prod->id_art }}</strong> - Specifiche</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        {!! $prod->desc_ecom !!}
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

{{-- </div> --}}
@endsection

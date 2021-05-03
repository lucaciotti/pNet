@extends('adminlte::page')

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
        <h3 class="card-title">Dettagli</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div style="height: 270px; width: 100%;">          
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
            </dd>

            <dt>Sotto Famiglia</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;
              [{{$prod->id_fam}}]
              @if ($prod->grpProd)
              <strong>{{ $prod->grpProd->descr }}</strong>              
              @endif
            </dd>

            <dt>Barcode</dt>
            <dd>
              &nbsp;&nbsp;&nbsp;&nbsp;
              <big><strong>{{$prod->id_cod_bar}}</strong></big>
            </dd>
          </dl>
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
  </div>

  <div class="col-lg-4">
    <div class="card collapsed-card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Immagine</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div style="height: 270px; width: 100%;">
          <img src="{{ asset('assets/img/noPhoto.png') }}" alt="noImage" height="270px"
            style="display: block; margin-left: auto; margin-right: auto;">
        </div>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="col-lg-6">
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
        
        <label>Prezzo di Acquisto:</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzAcq" value="{{ round($prod->prezzo_a,3) }}" style="text-align:right;">
          <div class="input-group-append">
            <span class="input-group-text">€</span>
          </div>
        </div>

        <label>Fornitore:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-truck-loading"></i></span>
          </div>
          @if ($prod->supplier)
          <input type="text" class="form-control" readonly name="supplier" value="{{ $prod->id_cli_for }} - {{ $prod->supplier->rag_soc }}">
          @else
          <input type="text" class="form-control" readonly name="supplier" value="{{ $prod->id_cli_for }}" >
          @endif
        </div>

      </div>
    </div>
  </div>

  <div class="col-lg-6">
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
            <span class="input-group-text">€</span>
          </div>
        </div>

        <label>Listino 2 (IVA escl.):</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzVend" value="{{ round($prod->prezzo_2,3) }}"
            style="text-align:right;">
          <div class="input-group-append">
            <span class="input-group-text">€</span>
          </div>
        </div>

        <label>Listino 3 (IVA escl.):</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzVend" value="{{ round($prod->prezzo_3,3) }}"
            style="text-align:right;">
          <div class="input-group-append">
            <span class="input-group-text">€</span>
          </div>
        </div>     
        
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
</div>

{{-- </div> --}}
@endsection

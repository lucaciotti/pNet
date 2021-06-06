@extends('adminlte::page')

@section('title_postfix')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
      {{$head->descr_tipodoc}} n°{{$head->num}}
  </h1>
  <h6>{{ trans('doc.contentDesc_dtl', ['date' => $head->data->format('d/m/Y')]) }}</h6>
  <br>
@stop

@section('content-fluid')
{{-- <div class="container"> --}}
<div class="row">
  
  <div class="col-lg-5">
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
        <div style="">          
          <dl class="dl-horizontal">
            <dt>{{ trans('doc.document') }}</dt>
            <dd>{{$head->descr_tipodoc}} n°{{$head->num}}</dd>
            
            <dt>{{ trans('doc.client') }}</dt>
            <dd><strong>{{$head->client->rag_soc}} [{{$head->id_cli_for}}]</strong></dd>
            
            <dt>{{ trans('doc.dateDoc') }}</dt>
            <dd>{{$head->data->format('d/m/Y')}}</dd>
            
            <dt>{{ trans('doc.referenceDoc') }}</dt>
            <dd>{{$head->rif_num or ''}}</dd>
            
            <hr>
            
            <dt>{{ trans('doc.totImp') }}</dt>
            <dd>{{$head->tot_imp}} €</dd>
            
            <dt>{{ trans('doc.totVat') }} @if($head->id_iva_c!='')({{ $head->id_iva_c ?? '22' }} %)@endif</dt>
            <dd>{{$head->tot_iva}} €</dd>

            <hr>

            @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N')
            
              <dt>{{ trans('doc.totDoc_condensed') }}</dt>
              <dd><strong>{{$head->tot_rit}} €</strong> <br> @if ($head->pagato) [PAGATO]@endif</dd>
            @else
            @php
            $totDoc = $head->tot_imp+$head->tot_iva;
            @endphp
              <dt>{{ trans('doc.totDoc_condensed') }}</dt>
              <dd><strong>{{$totDoc}} €</strong></dd>
            @endif
            
          </dl>
        </div>
      </div>
      <!-- /.card -->
    </div>

    <div class="card card-outline">
      <div class="card-header">
        <h3 class="card-title">Downloads</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        {{-- <a type="button" class="btn btn-default btn-block" target="_blank" href="{{ route('doc::downloadXML', $head->id) }}">
          <strong> XML File</strong>
        </a>
        <hr>
        <a type="button" class="btn btn-default btn-block" target="_blank" href="{{ route('doc::downloadXLS', $head->id) }}">
          <strong> Excel File</strong>
        </a>
        <hr> --}}
        <a type="button" class="btn bg-lightblue btn-block" target="_blank" href="{{ route('doc::downloadPDF', [$head->tipodoc, $head->id_doc]) }}">
          <strong> PDF File</strong>
        </a>
      </div>
      <!-- /.card -->
    </div>

  </div>

  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">{{ trans('doc.listRows') }}</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        @include('parideViews.docs.partials.tblDetail', [$head])   
      </div>
    </div>
  </div>

</div>

{{-- </div> --}}
@endsection

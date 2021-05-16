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
        <div style="height: 270px; width: 100%;">          
          <dl class="dl-horizontal">
            <dt>{{ trans('doc.document') }}</dt>
            <dd>{{$head->descr_tipodoc}} n°{{$head->num}}</dd>
            
            <dt>{{ trans('doc.client') }}</dt>
            <dd><strong>{{$head->nome1}} [{{$head->id_cli_for}}]</strong></dd>
            
            <dt>{{ trans('doc.dateDoc') }}</dt>
            <dd>{{$head->data->format('d/m/Y')}}</dd>
            
            <dt>{{ trans('doc.referenceDoc') }}</dt>
            <dd>{{$head->rif_num or ''}}</dd>
            
            <hr>
            
            <dt>{{ trans('doc.totDoc') }}</dt>
            <dd><strong>{{$head->tot_imp}} €</strong></dd>
            
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
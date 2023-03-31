@extends('adminlte::page')

@section('title_postfix')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
      Ordine Web n°{{$head->id}}
  </h1>
  <br>
@stop

@section('content-fluid')
{{-- <div class="container"> --}}
<div class="row">
  <div class="col-lg-5">
    @include('parideViews.cart.partials.cardDetailDoc')

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
        {{-- <a type="button" class="btn bg-lightblue btn-block" target="_blank" href="{{ route('doc::downloadPDF', [$head->tipodoc, $head->id_doc]) }}">
          <i class="fa fa-download"></i><strong> PDF File</strong>
        </a> --}}
        <a type="button" class="btn btn-default btn-block" target="_blank" href="{{ route('cart::exportCsv', $head->id) }}">
          <strong> CSV File</strong>
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
        @include('parideViews.cart.partials.tblDetail', [$head])   
      </div>
    </div>
  </div>

</div>

{{-- </div> --}}
@endsection

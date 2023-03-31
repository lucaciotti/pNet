@extends('adminlte::page')

@section('title_postfix', '- OrdWeb List')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    Lista Ordini Web Emessi
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Lista Ordini Web Emessi</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @include('parideViews.cart.partials.tblIndex', [$docs])
        </div>
        <!-- /.card-body -->
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ trans('client.filter') }}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @include('parideViews.cart.partials.formIndex')
        </div>
      </div>

    </div>
  </div>
@stop


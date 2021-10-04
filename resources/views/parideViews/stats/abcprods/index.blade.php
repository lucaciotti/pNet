@extends('adminlte::page')

@section('title_postfix', '- AbcProds')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    Abc Prodotti
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Abc Prodotti</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
              @include('parideViews.stats.abcprods.partials.tblIndex')          
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
          @include('parideViews.stats.abcprods.partials.formIndex')
        </div>
      </div>
    </div>
  </div>
@stop

@section('extra_script')
  {{-- @include('layouts.partials.scripts.iCheck')
  @include('layouts.partials.scripts.select2')
  @include('layouts.partials.scripts.datePicker') --}}
@endsection

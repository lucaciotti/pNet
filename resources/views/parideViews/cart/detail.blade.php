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
        <a type="button" class="btn bg-lightblue btn-block" target="_blank" href="{{ route('cart::downloadPDF', [$head->id]) }}">
          <i class="fa fa-download"></i><strong> PDF File</strong>
        </a>
        <a type="button" class="btn btn-default btn-block" target="_blank" href="{{ route('cart::exportCsv', $head->id) }}">
          <strong> CSV File</strong>
        </a>
      </div>
      <!-- /.card -->
    </div>

    @if (!in_array(RedisUser::get('role'), ['client', 'agent']))
    <div class="card card-outline">
      <div class="card-header">
        <h3 class="card-title">Send By Email</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <a type="button" class="btn bg-warning btn-block" target="_blank"
          href="{{ route('cart::sendXW', [$head->id]) }}">
          <i class="fa fa-paper-plane"></i><strong>Invia email con allegati</strong>
        </a>
      </div>
      <!-- /.card -->
    </div>
    @endif

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
    
    @if (!empty($head->note))
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Note</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <p>{!! $head->note !!}</p>
      </div>
    </div>  
    @endif
    
  </div>

</div>

{{-- </div> --}}
@endsection

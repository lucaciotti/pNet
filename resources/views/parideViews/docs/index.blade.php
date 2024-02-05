@extends('adminlte::page')
@php
try {
  //code...
  LaravelMatomoTracker::setUserId(RedisUser::get('name'));
  LaravelMatomoTracker::doTrackPageView('Lista Documenti');
} catch (\Throwable $th) {
  //throw $th;
}
@endphp
@section('title_postfix', '- DocList')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    {{ trans('doc.contentTitle_idx', ['tipoDoc' => $descModulo]) }}
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ trans('doc.contentTitle_idx', ['tipoDoc' => $descModulo]) }}</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @include('parideViews.docs.partials.tblIndex', [$docs])
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
          @include('parideViews.docs.partials.formIndex')
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ trans('doc.changeDoc') }}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          <a type="button" class="btn btn-default btn-block"
            href="{{ route('doc::list', ['']) }}">{{ strtoupper(trans('client.allDocs')) }}</a>
          <a type="button" class="btn btn-default btn-block"
            href="{{ route('doc::list', ['P']) }}">{{ trans('client.quotes') }}</a>
          <a type="button" class="btn btn-default btn-block"
            href="{{ route('doc::list', ['O']) }}">{{ trans('client.orders') }}</a>
          <a type="button" class="btn btn-default btn-block" href="{{ route('doc::list', ['B']) }}">{{ trans('client.ddt') }}</a>
          <a type="button" class="btn btn-default btn-block"
            href="{{ route('doc::list', ['F']) }}">{{ trans('client.invoice') }}</a>
          <a type="button" class="btn btn-default btn-block"
            href="{{ route('doc::list', ['N']) }}">{{ trans('client.notecredito') }}</a>
        </div>
      </div>
    </div>
  </div>
@stop


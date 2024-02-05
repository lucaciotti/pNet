@extends('adminlte::page')
@php
try {
  //code...
  LaravelMatomoTracker::setUserId(RedisUser::get('name'));
  LaravelMatomoTracker::doTrackPageView('Gestione Clienti');
} catch (\Throwable $th) {
  //throw $th;
}
@endphp
@section('title_postfix', '- '.trans('user.headTitle_idx'))

@section('content_header')
<br>
<h1 class="m-0 text-dark">
  AdminUtility - {{ trans('user.contentTitle_idx') }}
</h1>
<br>
@stop


@section('content-fluid')
<div class="row">
  <div class="col-lg-7">

    <div class="card">
      <div class="card-header border-transparent">
        <h3 class="card-title">{{ trans('user.listClients') }}</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        @include('sysViews.user.partial.tblIndex', ['users' => $clients])
        {{-- <livewire:user-table /> --}}
      </div>
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
        @include('sysViews.user.partial.formIndex')
      </div>
    </div>
  </div>
</div>
@endsection

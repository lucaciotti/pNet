@extends('adminlte::page')

@section('title_postfix', '- '.trans('user.headTitle_idx'))

@section('content_header')
<br>
<h1 class="m-0 text-dark">
  AdminUtility - {{ trans('user.contentTitle_idx') }}
</h1>
<br>
@stop


@section('content')
<div class="row">
  <div class="col-lg-12">

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
      </div>
    </div>

  </div>
</div>
@endsection

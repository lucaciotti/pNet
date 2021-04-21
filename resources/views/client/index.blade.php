@extends('adminlte::page')

@section('title_postfix', '- ClientList')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    {{ trans('client.contentTitle_idx') }}
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-7">
      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title">{{ trans('client.listCli') }}</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table m-0">
              <thead>
                <tr>
                  <th>{{ trans('client.code') }}</th>
                  <th>{{ trans('client.descCli') }}</th>
                  <th>{{ trans('client.nat&loc') }}</th>
                  {{-- <th>{{ trans('client.sector') }}</th> --}}
                  {{-- <th>{{ trans('client.agent') }}</th> --}}
                  <th>{{ trans('client.lnkDocuments') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($clients as $client)
                <tr>
                  <td>
                    <a href="{{ route('client::detail', $client->id_cli_for ) }}"> {{ $client->id_cli_for }}</a>
                  </td>
                  <td>{{ $client->rag_soc }}</td>
                  <td>{{ $client->citta }} - {{ $client->provincia }}</td>
                  {{-- <td>{{ $client->settore }}</td> --}}
                  {{-- <td>@if($client->agent) {{ $client->agent->descrizion }} @endif</td> --}}
                  <td><a href="#">{{ trans('client.documents') }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.table-responsive -->
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
          @include('client.partials.formIndex')
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

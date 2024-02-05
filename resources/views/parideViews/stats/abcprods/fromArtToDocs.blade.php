@extends('adminlte::page')
@php
try {
    //code...
    LaravelMatomoTracker::setUserId(RedisUser::get('name'));
    LaravelMatomoTracker::doTrackPageView('Abc Prodotti');
} catch (\Throwable $th) {
    //throw $th;
}
@endphp
@section('title_postfix', '- AbcProds')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Lista Documenti con Prodotto
</h1>
<br>
@stop

@section('content-fluid')
<div class="row">

    <div class="col-lg-3">
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="card-title">{{ trans('client.filter') }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div> --}}
            <div class="card-body">
                <dl class="dl-horizontal">
                    <dt>
                        <strong>
                            <h4>{{$idArt}}</h4>
                        </strong>
                    </dt>
                    <dd>{{$descrArt}}</dd>
                
                    <dt>Periodo di Riferimento:</dt>
                    <dd>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" name="docDataPicker" readonly>
                            <input type="hidden" name="startDate" value="">
                            <input type="hidden" name="endDate" value="">
                        </div>
                    </dd>
                
                    @if ($client)
                    <hr>
                
                    
                    @endif                
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista Documenti</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @include('parideViews.stats.abcprods.partials.tblRefDocs')
            </div>
            <!-- /.card-body -->
        </div>
    </div>

    
</div>
@stop

@section('extra_script')
{{-- @include('layouts.partials.scripts.iCheck')
  @include('layouts.partials.scripts.select2')
  @include('layouts.partials.scripts.datePicker') --}}
@endsection
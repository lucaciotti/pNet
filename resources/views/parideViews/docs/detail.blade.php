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
@php
if($tipodoc=='BO') {
  $stampaPrezzi = ($head->client->nopvddt && !$head->fatturato) ? false : true;
}else {
  $stampaPrezzi = true;
}
@endphp
<div class="row">
  <div class="col-lg-5">
    @include('parideViews.docs.partials.cardDetailDoc')

    @if(!$prevDocs->isEmpty() || !$nextDocs->isEmpty())
      <div class="card card-outline">
        <div class="card-header">
          <h3 class="card-title">Documenti Collegati</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @if(!$prevDocs->isEmpty())
          <h6>{{ trans('doc.prevDocs') }}</h6>
            @foreach ($prevDocs as $doc)
            <a type="button" class="btn btn-default btn-block" target="_blank"
              href="{{ route('doc::detail', [$doc->tipo_doc, $doc->id_doc]) }}">
              <strong> {{ $doc->descr_tipodoc }} n. {{ $doc->num }} del {{ $doc->data->format('d/m/Y') }}</strong>
            </a>
            @endforeach
            <hr>
          @endif
          @if(!$nextDocs->isEmpty())
          <h6>{{ trans('doc.nextDocs') }}</h6>
            @foreach ($nextDocs as $doc)
            <a type="button" class="btn bg-lightblue btn-block" target="_blank"
              href="{{ route('doc::detail', [$doc->tipo_doc, $doc->id_doc]) }}">
              <strong> {{ $doc->descr_tipodoc }} n. {{ $doc->num }} del {{ $doc->data->format('d/m/Y') }}</strong>
            </a>
            @endforeach
          @endif
        </div>
        <!-- /.card -->
      </div>
    @endif

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
          <i class="fa fa-download"></i><strong> PDF File</strong>
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

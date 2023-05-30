@extends('adminlte::page')

@section('title_postfix', '- Gestione Vettori')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Gestione Url Tracking Vettori
</h1>
<br>
@stop

@section('content')
<div class="row">

    <div class="col-lg-12">
        @livewire('info-vettori-list')
    </div>
</div>
@stop

@section('extra_script')
@endsection
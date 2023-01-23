@extends('adminlte::page')

@section('title_postfix', '- Search Products')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Ricerca Prodotti
</h1>
<br>
@stop

@section('content')
<div class="row">

    <div class="col-lg-12">
       @livewire('search-products', ['searchStr' => $searchStr])
    </div>
</div>
@stop

@section('extra_script')
@endsection
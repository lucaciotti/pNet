@extends('adminlte::page')
@php
try {
    //code...
    LaravelMatomoTracker::setUserId(RedisUser::get('name'));
    LaravelMatomoTracker::doTrackPageView('Ricerca Prodotti');
} catch (\Throwable $th) {
    //throw $th;
}
@endphp

@section('title_postfix', '- Search Products')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Ricerca Prodotti
</h1>
<br>
@stop

@section('content-fluid')
{{-- <div class="row"> --}}

    {{-- <div class="col-lg-12"> --}}
       @livewire('search-products', ['searchStr' => $searchStr])
    {{-- </div> --}}
{{-- </div> --}}
@stop

@section('extra_script')
@endsection
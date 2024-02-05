@extends('adminlte::page')
@php
try {
    //code...
    LaravelMatomoTracker::setUserId(RedisUser::get('name'));
    LaravelMatomoTracker::doTrackPageView('Gestione Price Manager');
} catch (\Throwable $th) {
    //throw $th;
}
@endphp
@section('title_postfix', '- Price Manager')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Price Manager
</h1>
<br>
@stop

@section('content-fluid')
{{-- <div class="row"> --}}

    {{-- <div class="col-lg-12"> --}}
        @livewire('pricemanager.content')
    {{-- </div> --}}
{{-- </div> --}}
@stop

@section('extra_script')
@endsection
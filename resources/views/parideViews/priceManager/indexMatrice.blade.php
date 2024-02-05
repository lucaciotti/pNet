@extends('adminlte::page')
@php
try {
    //code...
    LaravelMatomoTracker::setUserId(RedisUser::get('name'));
    LaravelMatomoTracker::doTrackPageView('Gestione Matrice Prezzi');
} catch (\Throwable $th) {
    //throw $th;
}
@endphp
@section('title_postfix', '- Matrice Prezzi')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Matrice Prezzi
</h1>
<br>
@stop

@section('content-fluid')
{{-- <div class="row"> --}}

    {{-- <div class="col-lg-12"> --}}
        @livewire('matriceprezzi.content')
    {{-- </div> --}}
{{-- </div> --}}
@stop

@section('extra_script')
@endsection
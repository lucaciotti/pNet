@extends('adminlte::page')
@php
try {
    //code...
    LaravelMatomoTracker::setUserId(RedisUser::get('name'));
    LaravelMatomoTracker::doTrackPageView('Note Personalizzate Documenti');
} catch (\Throwable $th) {
    //throw $th;
}
@endphp
@section('title_postfix', '- Note Documenti')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Note Personalizzate Documenti
</h1>
<br>
@stop

@section('content')
<div class="row">

    <div class="col-lg-12">
        @livewire('note-doc-list')
    </div>
</div>
@stop

@section('extra_script')
@endsection
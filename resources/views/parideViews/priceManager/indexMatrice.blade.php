@extends('adminlte::page')

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
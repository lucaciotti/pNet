@extends('adminlte::auth.auth-page')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('auth_header', 'Inviato Invito')

@section('auth_body')
    E' stato inviato un invito alla tua email personale.<br>
    Ti preghiamo di controllare.<br>
    Nel caso non ti fosse arrivata nessuna email ti preghiamo di contattare la nostra assistenza: <br>

    <a href="mailto:info@ferramentaparide.it">info@ferramentaparide.it</a>
    
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="/login">
            Accedi
        </a>
    </p>

    <p class="my-0">
        <a href="https://www.youtube.com/playlist?list=PLpD2hglxlx_elO_RsO9Vk2dnzir5dkPss" target="_blank">
            Vedi i tutorial per utilizzare pNet <i class="fa fa-youtube"></i>
        </a>
    </p>
    {{-- Register link --}}
    {{-- @if($register_url)
        <p class="my-0">
            <a href="{{ $register_url }}">
                {{ __('adminlte::adminlte.register_a_new_membership') }}
            </a>
        </p>
    @endif --}}
@stop

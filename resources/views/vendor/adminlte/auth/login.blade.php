@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif

@section('auth_header', __('adminlte::adminlte.login_message'))

@section('auth_body')

    @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif

    <form action="{{ $login_url }}" method="post">
        {{ csrf_field() }}

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="nickname" class="form-control {{ $errors->has('nickname') ? 'is-invalid' : '' }}"
                   value="{{ old('nickname') }}" placeholder="{{ __('adminlte::adminlte.nickname') }}" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('nickname'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('nickname') }}</strong>
                </div>
            @endif
            <label for="nickname"><small>Il nickname è [CODICE_CLIENTE]@pnet.it (es C123456@pnet.it)</small></label>    
        </div>

        {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="{{ __('adminlte::adminlte.password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif
        </div>

        {{-- Login field --}}
        <div class="row">
            <div class="col-7">
                <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                </div>
            </div>
            <div class="col-5">
                <button type=submit class="btn btn-block btn-primary">
                    <span class="fas fa-sign-in-alt"></span>
                    {{ __('adminlte::adminlte.sign_in') }}
                </button>
            </div>
        </div>

    </form>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    @if($password_reset_url)
        <p class="my-0">
            <a href="{{ $password_reset_url }}">
                {{ __('adminlte::adminlte.i_forgot_my_password') }}
            </a>
        </p>
    @endif

    <p class="my-0">
        <a href="mailto:amministrazione@ferramentaparide.it?subject=Richiesta%20credenziali%20accesso%20portale%20pNet&body=Salve%2C%0A%0Avorrei%20ricevere%20i%20dati%20di%20accesso%20al%20piattaforma%20pNet%20per%20la%20seguente%20azienda.%0A%0ARAGIONE%20SOCIALE%3A%0A%0APIVA%2FCF%3A%0A%0AINDIRIZZO%3A%0A%0ATELEFONO%3A%0A%0AMAIL%20PRINCIPALE%3A%0A%0ACODICE%20SDI%3A%0A%0AGi%C3%A0%20cliente%3F%20(S%C3%AC%20%2F%20No)%3A%0A%0AInviando%20la%20presente%20email%20accetto%20la%20Privacy%20Policy%20di%20Ferramenta%20Schiavon%20Paride%20e%20conseguentemente%20di%20essere%20registrato%20nei%20suoi%20sistemi%20informatici%20per%20la%20creazione%20di%20utente%20e%20password%20dedicati%20secondo%20quanto%20riportato%20al%20seguente%20link%3A%0Ahttps%3A%2F%2Fwww.ferramentaparide.it%2Fschede%2FPrivacy_Policy_Schiavon_Paride_Ferramenta_V02.pdf%0A" target="_blank">
            Non ho le credenziali di accesso e desidero registrarmi 
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

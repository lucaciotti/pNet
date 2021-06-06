@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

{{-- @php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@if (config('adminlte.use_route_url', false))
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@else
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@endif --}}

@section('auth_header', 'Scegli la tua password' /* __('adminlte::adminlte.password_reset_message') */)

@section('auth_body')
    <form action="{{ route('password.update') }}" method="post" id="resetPasswordForm">
        {{ csrf_field() }}

        {{-- Token field --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email field --}}
        <label>Username</label>
        <div class="input-group mb-3">
            <input type="email" name="nickname" class="form-control {{ $errors->has('nickname') ? 'is-invalid' : '' }}"
                   value="{{ old('nickname', $request->nickname) }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
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
        </div>

        {{-- Password field --}}
        <label>Password</label>
        <div class="input-group mb-3">
            <input type="password" name="password"
                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
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

        {{-- Password confirmation field --}}
        <label>Conferma Password</label>
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                   placeholder="{{ trans('adminlte::adminlte.retype_password') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                    &nbsp;&nbsp; Accettazione dei <a href="#" data-toggle="modal" data-target="#termsModal">Termini di utilizzo</a>
                </label>
            </div>
        </div>

        {{-- Confirm password reset button --}}
        <button type="button" class="btn btn-block btn-primary" onclick="testForm()">
            <span class="fas fa-sync-alt"></span>
            Aggiorna Password{{-- {{ __('adminlte::adminlte.reset_password') }} --}}
        </button>

    </form>

    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="Terms and conditions"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Termini e Condizioni</h3>
                </div>
    
                <div class="modal-body">
                    <p>
                        Autorizzo il trattamento dei miei dati personali esclusivamente per le finalità di cui al punto a), 
                        con le modalità e nei limiti ai sensi dell'art. 13 del D.lgs. 196/03 del codice civile italiano.
                    </p>
    
                    <p>
                        Autorizzo inoltre il trattamento dei miei dati personali forniti a Ferramenta Paride 
                        esclusivamente per le finalità di cui ai punti b) e c), con le modalità e nei limiti, 
                        ai sensi dell'art. 13 del D.lgs. 196/03 del codice civile italiano.
                    </p>
                    
                    <p>
                        Infine autorizzo Ferramenta Paride, per mezzo del piattaforma pNet, a inviarmi email contenenti informazioni relative ai miei acquisti ed ai miei documenti.<br>
                        [E' importante sottolineare come questa configurazione possa essere disattivata dall'utente in qualsiasi momento.]
                    </p>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function testForm() {
            if(document.getElementById("agreeTerms").checked) {
                document.getElementById("resetPasswordForm").submit();
            } else {
                alert('Attenzione! \nOccorre accettare i Termini e Condizioni di utilizzo!');
                return false;
            }            
        }
    </script>
@stop

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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Termini e Condizioni</h3>
                </div>
    
                <div class="modal-body">                    
                    <p>
                        <strong>1. DATI PERSONALI</strong><br>
                        Il Cliente autorizza il trattamento dei suoi dati personali esclusivamente per le finalità di cui al punto a), con le
                        modalità e nei limiti ai sensi dell'art. 13 del D.lgs. 196/03 del codice civile italiano.
                        Il Cliente autorizza il trattamento dei suoi dati personali forniti a Ferramenta Schiavon Paride esclusivamente per le
                        finalità di cui ai punti b) e c), con le modalità e nei limiti, ai sensi dell'art. 13 del D.lgs. 196/03 del codice
                        civile italiano.
                        Il Cliente autorizza, inoltre, Ferramenta Schiavon Paride, per mezzo del piattaforma pNet, a inviargli email contenenti
                        informazioni relative ai suoi acquisti ed ai suoi documenti.
                        [E' importante sottolineare come questa configurazione possa essere disattivata dall'utente in qualsiasi momento.]
                    </p>
    
                    <p>
                        <strong>2. DIVIETO DI CESSIONE</strong><br>
                        È fatto espresso divieto al Cliente di cedere a terzi le proprie credenziali di accesso al portale pNet ai sensi
                        dell’art. 1.10, salvo il previo consenso scritto di Ferramenta Schiavon Paride.
                        Il Cliente si impegna a conservare la UserID e la password con la massima cura, a non comunicarla a terzi e a notificare
                        immediatamente e per iscritto tramite posta certificata a Schiavon Paride Ferramenta l'eventuale furto, smarrimento o
                        perdita della password.
                    </p>

                    <p>
                        <strong>3. PREZZI ESPOSTI E DIPONIBILITA' DEI PRODOTTI</strong><br>                        
                        Tutti i prezzi dei prodotti esposti ed indicati nel catalogo di pNet sono espressi IVA esclusa.
                        Nonostante ogni sforzo di Ferramenta Schiavon Paride, non è possibile escludere che per una parte degli articoli
                        presenti sul catalogo sia indicato per errore un prezzo diverso da quello effettivo.
                        In tal caso Ferramenta Schiavon Paride si impegna ad informare il Cliente e a comunicare l'informazione corretta, previa
                        verifica.
                        Quanto sopra è valido anche per la disponibilità dei prodotti.
                        Inoltre, il prezzo indicato è un prezzo base e potrebbe variare a seconda delle scontistiche del Cliente e/o famiglia di
                        prodotti.
                    </p>

                    <p>
                        <strong>4. AGGIORNAMENTO DELLE INFORMAZIONI</strong><br>                        
                        L'aggiornamento dei dati presenti sul portale pNet viene effettuato in momenti prestabiliti, pertanto potrebbero non
                        essere presenti alcune informazioni o essere non aggiornate fino al momento del successivo aggiornamento.
                    </p>

                    <p>
                        <strong>5. CANCELLAZIONE DELL'ACCOUNT CLIENTE</strong><br>                       
                        Il Cliente che voglia cancellare il proprio account può farlo inviando la richiesta attraverso posta certificata.
                        Ferramenta Schiavon Paride si riserva 3 giorni lavorativi per il completamento dell'operazione.
                        Ad avvenuta cancellazione, una mail di conferma viene inviata a Cliente.
                    </p>

                    <p>
                        <strong>6. CONDIZIONI GENERALI</strong><br>
                        Le presenti Condizioni possono subire modifiche o aggiornamenti in qualsiasi momento da parte di Ferramenta Schiavon
                        Paride; in tal caso Ferramenta Schiavon Paride provvederà a darne comunicazione al Cliente attraverso gli appositi
                        canali.
                        Il Cliente dichiara di aver letto, compreso e accettato quanto indicato nella presente.
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

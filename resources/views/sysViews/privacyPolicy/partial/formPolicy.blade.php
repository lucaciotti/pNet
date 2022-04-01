<form action="{{ route('privacy::update') }}" id="formPrivacy" method="POST">
    {{ csrf_field() }}

    <p>
        Io sottoscritto/a
        <span class="col-md-2" style="display: inline-block">
            <input type="text" class="form-control form-control-sm form-inline" name="name" id="privacyName" placeholder="Nome">
        </span>
        <span class="col-md-2" style="display: inline-block">
            <input type="text" class="form-control form-control-sm form-inline" name="surname" id="privacySurname" placeholder="Cognome">
        </span>
        (INTERESSATO), in qualità di rappresentante dell'azienda [{{ $user->client ? $user->client->rag_soc : $user->name }}],
        a seguito di consultazione e presa visone dell’informativa sulla privacy ed essendo, quindi, stato informato in
        merito
        all’identità del titolare del
        trattamento, delle modalità con cui i miei dati vengono trattati, delle finalità del trattamento cui sono destinati
        i
        miei dati personali ai sensi
        dell’Art.13 del Regolamento UE 2016/679, con la presente:
    </p>
    <div class="form-group" style="margin-bottom: 10px; text-align: center;">
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" id="privacyCheckDatiPers" name="checkDatiPers">
            <label for="privacyCheckDatiPers" class="custom-control-label"><strong>Acconsento</strong></label>
        </div>
    </div>
    <p>
        al trattamento dei dati personali da parte di Schiavon Paride Ferramenta per le finalità strettamente connesse allo
        svolgimento delle attività amministrative indicate al punto 2.1.
    </p>

    <hr>

    <p>
        Inoltre, date le premesse di cui al punto precedente:
    </p>
    {{-- <div class="form-check" style="margin-bottom: 10px; text-align: center;">
        <input type="checkbox" class="form-check-input" id="checkNewLetterOk">
        <label class="form-check-label" for="checkNewLetterOk"><strong>Acconsento</strong></label>
    </div>
    <div class="form-check" style="margin-bottom: 10px; text-align: center;">
        <input type="checkbox" class="form-check-input" id="checkNewLetterKo">
        <label class="form-check-label" for="checkNewLetterKo"><strong>NON Acconsento</strong></label>
    </div> --}}
    <div class="form-group" style="margin-bottom: 10px; text-align: center;">
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="checkNewLetter" name="checkNewsLetter" value='1'>
            <label for="checkNewLetter" class="custom-control-label"><strong>Acconsento</strong></label>
        </div>
        <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="checkNewLetterNO" name="checkNewsLetter" value='0'>
            <label for="checkNewLetterNO" class="custom-control-label"><strong>Non Acconsento</strong></label>
        </div>
    </div>
    <p>
        al trattamento dei dati personali da parte di Schiavon Paride Ferramenta per le finalità informative di marketing
        indicate al punto 2.2.
    </p>
    <p>
        Sono consapevole e sono stato informato del fatto di potere revocare il consenso in qualunque momento inviando una
        richiesta per posta
        elettronica certificata all’indirizzo amministrazioneparide@pec.it o tramite posta raccomandata all’indirizzo Via
        Lovadina 63/2 - 31050 – Vascon di Carbonera (TV).
    </p>

    <div class="col-md-2 float-right">
        <button type="button" class="btn btn-primary btn-block" onclick="checkPrivacyForm()">{{ trans('_message.submit') }}</button>
    </div>

</form>

@push('js')
<script>
    function checkPrivacyForm(){
        if($('#privacyName').val()==""){
            Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: 'Attenzione!',
            html:
            'E\' richiesta la compiazione del Modulo di consenso in tutte le sue parti: <br> ' +
            '- Nome <br>' +
            '- Cognome <br>' +
            '- Consenso <br>',
            showConfirmButton: true,
            timer: 3500
            });
            $('#privacyName').focus();
            return false;
        }
        if($('#privacySurname').val()==""){
            Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: 'Attenzione!',
            html:
            'E\' richiesta la compiazione del Modulo di consenso in tutte le sue parti: <br> ' +
            '- Nome <br>' +
            '- Cognome <br>' +
            '- Consenso <br>',
            showConfirmButton: true,
            timer: 3500
            });
            $('#privacySurname').focus();
            return false;
        }
        if($('#privacyCheckDatiPers').prop("checked")==false){
            Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: 'Attenzione!',
            html:
            'E\' richiesta la compiazione del Modulo di consenso in tutte le sue parti: <br> ' +
            '- Nome <br>' +
            '- Cognome <br>' +
            '- Consenso <br>',
            showConfirmButton: true,
            timer: 3500
            });
            $('#privacyCheckDatiPers').focus();
            return false;
        }
        if($('#checkNewLetter').prop("checked")==false && $('#checkNewLetterNO').prop("checked")==false){
            Swal.fire({
            position: 'top-end',
            icon: 'warning',
            title: 'Attenzione!',
            html:
            'E\' richiesta una scelta sulle finalità di Marketing: <br> ' +
            '- Acconsento <br>' +
            '- Non Acconsento',
            showConfirmButton: true,
            timer: 3500
            });
            $('#checkNewLetter').focus();
            return false;
        }
        $('#formPrivacy').submit();
    }
</script>
@endpush

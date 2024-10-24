@component('mail::message')
# Buongiorno, {{ $user->name }}

le riepiloghiamo qui di seguito il "Consenso alla Privacy" da lei concesso a [Ferramenta Paride Srl](https://www.ferramentaparide.it/).     
Da questo momento potrà visualizzare lo stato dei sui Preventivi, Ordini, DDT e Fatture, unitamente al catalogo completo
dei nostri prodotti, sui nostri sistemi informativi.

@component('mail::panel')
<div style="text-align: justify">
Io sottoscritto/a <b>{{ $user->privacyAgreement->name }} {{ $user->privacyAgreement->surname }}</b> (INTERESSATO), in
qualità di rappresentante dell'azienda [<b>{{ $user->client ? $user->client->rag_soc : $user->name }}</b>],
a seguito di consultazione e presa visone dell’informativa sulla privacy ed essendo, quindi, stato informato in merito
all’identità del titolare del trattamento, delle modalità con cui i miei dati vengono trattati,
delle finalità del trattamento cui sono destinati i miei dati personali ai sensi
dell’Art.13 del Regolamento UE 2016/679, con la presente:</div>
<br>

@if($user->privacyAgreement->privacy_agreement)
**Acconsento**
@endif

<div style="text-align: justify">
al trattamento dei dati personali da parte di Ferramenta Paride Srl per le finalità strettamente connesse allo
svolgimento delle attività amministrative indicate al punto 2.1</div>
<br>
<div style="text-align: justify">
Inoltre, date le premesse di cui al punto precedente:</div>
<br>

@if($user->privacyAgreement->marketing_agreement)
**Acconsento**
@endif
@if(!$user->privacyAgreement->marketing_agreement)
**Non Acconsento**
@endif

<br>
<div style="text-align: justify">
al trattamento dei dati personali da parte di Ferramenta Paride Srl per le finalità informative di marketing
indicate al punto 2.2.</div>
<br>

<div style="text-align: justify">
Sono consapevole e sono stato informato del fatto di potere revocare il consenso in qualunque momento inviando una
richiesta per posta elettronica
certificata all’indirizzo amministrazioneparide@pec.it o tramite posta raccomandata all’indirizzo Via Lovadina 63/2 -
31050 – Vascon di Carbonera (TV).</div>

<br>
<div style="text-align: justify">
Consenso registrato in data: {{ $user->privacyAgreement->updated_at->format('d-m-Y') }}
</div>
@endcomponent

Cliccando qui avrà accesso alla pagina con le condizioni sulla privacy:
@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Le ricordiamo che il *nickname* a lei associato è:      

**{{ $user->nickname }}**



Come sempre, rimaniamo a sua disposizione.

Ringraziando per l'attenzione, auguriamo un buon lavoro.

Staff pNet Ferramenta Paride Srl

{{-- @slot('subcopy')
<small>
    <br>
    La presente comunicazione viene inviata automaticamente mediante mezzo elettronico.<br>
    AVVERTENZA - TUTELA DELLA PRIVACY<br>
    Il presente messaggio e-mail contiene informazioni confidenziali indirizzate esclusivamente alle persone sopra
    indicate.<br>
    Se il ricevente non è tra dette persone non dovrà intraprendere alcuna azione se non informare il mittente
    dell'errore e cancellare il messaggio.<br>
    Il ricevente dovrà inoltre accertarsi che gli allegati non contengano virus prima di aprirli. Vi informiamo che
    a tutela del destinatario tutti i dati presenti verranno trattati in base alla normativa vigente sulla privacy.
    Rif.D.L.196/2003.<br>
    -------------------------------------------------------------------------------------------------------<br>
    Titolare del trattamento:<br>
    Ferramenta Paride Srl<br>
    Via Lovadina, 63/2 - 31050 Vascon di Carbonera (TV) - Italy<br>
    Tel-1 (0039) 0422-350065 - Tel-2 (0039) 0422-448300<br>
    P.I. 01932040262 Reg. Imprese Treviso n. 177409<br>
    E-mail info@ferramentaparide.it
</small>
@endslot --}}
@endcomponent
@component('mail::message')
# Buongiorno, {{ $user->name }}

con questa email automatica la invitiamo ad accedere a "pNet", il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  
In questo modo potrà visualizzare lo stato dei sui Preventivi, Ordini, DDT e Fatture, unitamente al catalogo completo dei nostri prodotti.  

Il *nickname* a lei associato è:  
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **{{ $user->nickname }}**

Come primo accesso la preghiamo di cliccare sul link qui sotto per impostare la prima password di siurezza e cominciare a navigare da subito nel portale:  
@component('mail::button', ['url' => $url])
Accedi Qui
@endcomponent

Come sempre, rimaniamo a sua disposizione.  

Ringraziando per l'attenzione, auguriamo un buon lavoro.  

Staff pNet Ferramenta Paride  

@slot('subcopy')
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
    Schiavon Paride Ferramenta<br>
    Via Lovadina, 63/2 - 31050 Vascon di Carbonera (TV) - Italy<br>
    Tel-1 (0039) 0422-350065 - Tel-2 (0039) 0422-448300<br>
    P.I. 01932040262 Reg. Imprese Treviso n. 177409<br>
    E-mail info@ferramentaparide.it
</small>
@endslot
@endcomponent

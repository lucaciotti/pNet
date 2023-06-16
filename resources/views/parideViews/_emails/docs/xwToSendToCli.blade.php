@component('mail::message')
# Buongiorno, {{ $client->rag_soc }} [{{ $client->id_cli_for }}@pnet.it] 
con questa email automatica le inviamo in allegato il documento Ordine-Web emesso da pNet, il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  
Il dettagli del presente documento (articoli, prezzi, disponibilità, tempi e modalità di consegna) verranno controllati dai nostri operatori e sono da intendersi non vincolanti.  
Al termine del processo di verifica riceverà conferma d'ordine aggiornata.

Le ricordiamo che tutti i Pre-Ordini della sua azienda sono consultabili attraverso il link qui sotto:

@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Come sempre, rimaniamo a sua disposizione.

Ringraziando per l'attenzione, auguriamo un buon lavoro.

Staff pNet Ferramenta Paride

@endcomponent

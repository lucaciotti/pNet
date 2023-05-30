@component('mail::message')
# Ciao, 
il cliente {{ $client->rag_soc }} [{{ $client->id_cod_cli }]  

ha emesso un nuovo documento {{ $descrTipoDoc }} creato attraverso la piattaforma pNet, il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  
Qui in allegato sono inclusi i file PDF e CSV.

Ricordiamo che tutti i documenti sono consultabili attraverso il link qui sotto:  

@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Staff pNet Ferramenta Paride

@endcomponent

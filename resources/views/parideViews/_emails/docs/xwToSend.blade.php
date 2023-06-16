@component('mail::message')
# Salve, 
il cliente {{ $client->rag_soc }} [{{ $client->id_cli_for }}]({{ $urlClient }}) ha emesso un nuovo Ordine Web [n.{{ $doc->id }}/{{ $doc->data->year }}]({{ $urlXW }}) attraverso la piattaforma pNet, il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  
Il riferimento Ordine Cliente è {{ $doc->rif_num }}.

Qui in allegato sono inclusi i file PDF e CSV.

Ricordiamo che tutti gli ordini sono consultabili attraverso il link qui sotto:

@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Staff pNet Ferramenta Paride

@endcomponent

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
@endcomponent

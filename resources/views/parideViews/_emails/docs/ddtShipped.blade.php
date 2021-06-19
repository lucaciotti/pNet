@component('mail::message')
# Buongiorno, {{ $user->name }}

con questa email automatica le inviamo in allegato il documento DDT emesso da pNet, il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  

Le ricordiamo che tutti i documenti della sua azienda sono consultabili attraverso il link qui sotto:  

@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Come sempre, rimaniamo a sua disposizione.

Ringraziando per l'attenzione, auguriamo un buon lavoro.  

Staff pNet Ferramenta Paride
@endcomponent

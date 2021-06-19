@component('mail::message')
# Buongiorno, {{ $user->name }}

con questa email automatica le inviamo in allegato il documento DDT emesso da pNet, il portale extranet di [Ferramenta Paride](https://www.ferramentaparide.it/).  

Le ricordiamo che tutti i documenti della sua azienda sono consultabili sul notro portale.  
Se ha perso l'invito per registrarsi, può richiederlo qui cliccando qui sotto.  

@component('mail::button', ['url' => $urlInvito])
Ricevi inviot a pNet
@endcomponent

Come sempre, rimaniamo a sua disposizione.

Ringraziando per l'attenzione, auguriamo un buon lavoro.  

Staff pNet Ferramenta Paride
@endcomponent

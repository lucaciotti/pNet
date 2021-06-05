@component('mail::message')
# Ciao, {{ $user->name }}

Con questa email automatica Vi inviamo in allegato il documento DDT emesso da pNet, il portale di [Ferramenta Paride](https://www.ferramentaparide.it/).

Vi ricordiamo che tutti i vostri documenti sono consultabili attraverso il link qui sotto:

@component('mail::button', ['url' => $url])
Clicca Qui
@endcomponent

Rimaniamo a vostra disposizione.  
Vi ringraziamo per l'attenzione,<br>
{{ config('app.name') }} staff
@endcomponent

@component('mail::message')
# Ciao, {{ $user->name }}

Questa è una email automatica di invito al portale "pNet" di Ferramenta Paride.
Sul nostro portale potrà visualizzare lo stato dei suoi Ordini, Bolle e Fatture.
Tutto ciò unitamente al catalogo dei nostri prodotti.

Il 'nickname' a lei associato per l'accesso è:
    {{ $user->nickname }}

Come primo accesso Vi preghiamo di cliccare sul link qui sotto e di impostare la Vostra prima password.

@component('mail::button', ['url' => $url])
Accedi Qui
@endcomponent

Rimaniamo a vostra disposizione.
Vi ringraziamo per l'attenzione,<br>
{{ config('app.name') }} staff
@endcomponent

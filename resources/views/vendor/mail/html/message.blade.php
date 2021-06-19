@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img src="{{ asset(config('adminlte.logo_img')) }}" style="height: 30px;width: 30px;" data-auto-embed="attachment">
    Ferramenta Paride - {{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
<small><small>
    <br>
    -------------------------------------------------------------------------------------------------------<br>
    La presente comunicazione viene inviata automaticamente mediante mezzo elettronico.<br>
    AVVERTENZA - TUTELA DELLA PRIVACY<br>
    Il presente messaggio e-mail contiene informazioni confidenziali indirizzate esclusivamente alle persone sopra indicate.<br>
    Se il ricevente non è tra dette persone non dovrà intraprendere alcuna azione se non informare il mittente dell'errore e cancellare il messaggio.<br>
    Il ricevente dovrà inoltre accertarsi che gli allegati non contengano virus prima di aprirli. Vi informiamo che a tutela del destinatario tutti i dati presenti verranno trattati in base alla normativa vigente sulla privacy. Rif.D.L.196/2003.<br>
    -------------------------------------------------------------------------------------------------------<br>
    Titolare del trattamento:<br>
    Schiavon Paride Ferramenta<br>
    Via Lovadina, 63/2 - 31050 Vascon di Carbonera (TV) - Italy<br>
    Tel-1 (0039) 0422-350065 - Tel-2 (0039) 0422-448300<br>
    P.I. 01932040262 Reg. Imprese Treviso n. 177409<br>
    E-mail info@ferramentaparide.it
</small></small>
@endcomponent
@endslot
@endcomponent

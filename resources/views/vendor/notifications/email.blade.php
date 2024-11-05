@component('mail::message')
{{-- Greeting --}}
{{-- @if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Ciao!')
@endif
@endif --}}

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}

@endforeach --}}

Buongiorno,

ha ricevuto questa mail perchè abbiamo ricevuto la richiesta di un password reset per il suo account.

Il link rimarrà valido per 48 ore.

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}
Se non ha richiesto un password reset, non è richiesta alcuna azione.

Auguriamo un buon lavoro.

Staff pNet Ferramenta Paride

{{-- Salutation --}}
{{-- @if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif --}}

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Se ha problemi nel cliccare il pulsante 'Reset Password' , copi e incolli il seguente link nel suo browser:",
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent

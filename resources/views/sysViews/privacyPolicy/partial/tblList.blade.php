<table class="table table-hover table-condensed dtTbls_full">
    <thead>
        <th>{{ trans('user.name') }}</th>
        <th>{{ trans('user.codCli') }}</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Consenso Privacy</th>
        <th>Consenso Marketing</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </thead>
    <tbody>
        @foreach ($privacyAgree as $userAgree)
        <tr>
            @if($userAgree->user)
            <td>
                <a href="{{ route('user::users.edit', $userAgree->user->id ) }}" target="_blank" title="Modifica Utente">
                    {{ $userAgree->user->name }}
                </a>
            </td>
            <td>
                @if (!empty($userAgree->user->codcli))
                {{ $userAgree->user->codcli }} {{-- - {{ $userAgree->user->client->rag_soc }} --}}
                @endif
            </td>
            @else
                <td></td>
                <td></td>
            @endif
            <td>{{ $userAgree->name }}</td>
            <td>{{ $userAgree->surname }}</td>
            <td style="text-align: center;">@if($userAgree->privacy_agreement) <i class="fa fa-check"></i> @endif</td>
            <td style="text-align: center;">@if($userAgree->marketing_agreement) <i class="fa fa-check"></i> @endif</td>
            <td>
                @if($userAgree->user)
                <a href="{{ url('/privacyPolicy/'.$userAgree->user->id) }}" target="_blank" title="Modifica Privacy Agreement Utente">
                    <button type="submit" id="privacyPolicy-{{ $userAgree->user->id }}" class="btn btn-sm btn-outline-success">
                        <i class="fa fa-handshake"></i>
                    </button>
                </a>
                @endif
            </td>
            <td>
                @if($userAgree->user)
                <a href="{{ route('privacy::sendMailPrivacyAgree', $userAgree->user->id ) }}" title="Invia email Privacy Agreement">
                    <button type="submit" id="mail-privacy-{{ $userAgree->user->id }}" class="btn btn-sm btn-danger">
                        <i class="fa fa-envelope-open-text"></i>
                    </button>
                </a>
                @endif
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
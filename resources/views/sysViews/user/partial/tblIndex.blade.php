<table class="table table-hover table-condensed dtTbls_full">
  <thead>
    <th>&nbsp;</th>
    <th>{{ trans('user.name') }}</th>
    <th>{{ trans('user.eMail') }}</th>
    <th>{{ trans('user.role') }}</th>
    {{-- <th>{{ trans('user.codAg') }}</th>
    <th>{{ trans('user.codCli') }}</th> --}}
    <th>isActive?</th>
    <th>Ordine Web</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </thead>
  <tbody>
      @foreach ($users as $user)
        <tr>
          <td>
            @if ($user->isActive)
            <a href="{{ route('user::actLike', $user->id ) }}">
              <button type="submit" id="act-user-{{ $user->id }}" class="btn btn-xs btn-warning">
                  <i class="fa fa-btn fa-user-secret">
                  </i>
              </button>
            </a>
            @endif
          </td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>@foreach ($user->roles as $role)
            {{ $role->display_name }}
          @endforeach</td>
          {{-- <td>@if (!empty($user->codag))
            {{ $user->codag }} - {{ $user->agent->descrizion or 'NONE' }}
          @endif</td>
          <td>@if (!empty($user->codcli))
            {{ $user->codcli }}
          @endif</td> --}}
          <td>
            @if ($user->isActive)
              Si
            @else
              No
            @endif
          </td>
          <td>
            @if ($user->enable_ordweb)
              Si
            @else
              No
            @endif
          </td>
          <td>
            <a href="{{ route('user::users.edit', $user->id ) }}" target="_blank" title="Modifica Utente">
              <button type="submit" id="edit-user-{{ $user->id }}" class="btn btn-xs btn-secondary">
                  <i class="fa fa-btn fa-pencil">
                  </i>
              </button>
            </a>
          </td>
          <td>
            <a href="{{ url('/privacyPolicy/'.$user->id) }}" target="_blank" title="Modifica Privacy Agreement Utente">
              <button type="submit" id="privacyPolicy-{{ $user->id }}" class="btn btn-xs btn-outline-success">
                <i class="fa fa-btn fa-handshake"></i>
              </button>
            </a>
          </td>
          <td>
            <a href="{{ route('user::resetPassword', $user->id ) }}" title="Reset Password Utente">
              <button type="submit" id="reset-user-{{ $user->id }}" class="btn btn-xs btn-success">
                <i class="fa fa-btn fa-key">
                </i>
              </button>
            </a>
          </td>
          <td>
            <form action="{{ route('user::users.destroy', $user->id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" id="delete-user-{{ $user->id }}" class="btn btn-xs btn-danger" title="Cancella Utente">
                    <i class="fa fa-btn fa-trash"></i>
                </button>
            </form>
          </td>
        </tr>
      @endforeach

  </tbody>
</table>

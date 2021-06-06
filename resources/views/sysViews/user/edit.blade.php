@extends('adminlte::page')
@section('title_postfix', '- '.trans('user.headTitle_edt'))

@section('content')
  <div class="row">
    <div class="col-lg-12 col-lg-offset-1">
      <img src="{{asset('/assets/img/avatar_default.jpg')}}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px;"/>
      <br><br>
      <h2>{{ trans('user.userProfile', ['user' => $user->name]) }}</h2>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-lg-12 col-lg-offset-2">
      <div class="card card-default">
        <div class="card-header with-border">
          <h2 class="card-title" data-widget="collapse">{{ trans('user.modifyUser') }}</h2>
        </div>
        <div class="card-body">

          <form action="{{ route('user::users.update', $user->id) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field('PUT') }}
            <div class="form-group">
              <label>{{ trans('user.name') }}</label>
              <input type="text" class="form-control" name="name" value="{{$user->name}}">
            </div>
            <div class="form-group">
              <label>{{ trans('user.nickname') }}</label>
              <input type="text" class="form-control" name="nickname" value="{{$user->nickname}}" readonly="readonly">
            </div>
            <div class="form-group">
              <label>{{ trans('user.eMail') }}</label>
              <input type="text" class="form-control" name="email" value="{{$user->email}}" required>
            </div>

            <hr>

            <div class="form-group">
              <label>Ricezione Email Automatiche</label>
              <div class="radio">
                <label>
                  <input type="radio" name="auto_email" id="optauto_email1" value="0" @if(!$user->auto_email) checked @endif>&nbsp;&nbsp;No
                </label>
                <label>
                  <input type="radio" name="auto_email" id="optauto_email2" value="1" @if($user->auto_email) checked @endif>&nbsp;&nbsp;Si
                </label>
              </div>
            </div>

            @if (!in_array(RedisUser::get('role'), ['client', 'agent', 'superAgent', 'user']))
            <hr>

            <div class="form-group">
              <label>{{ trans('user.role') }}</label>
              <select name="role" class="form-control select2" style="width: 100%;">
                <option value=""> </option>
                @foreach ($roles as $role)
                  <option value="{{ $role->id }}"
                    @if($user->roles->contains($role->id))
                        selected
                    @endif
                    >{{ $role->display_name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans('user.codAg') }}</label>
              <select name="codag" class="form-control select2" style="width: 100%;">
                <option value=""> </option>
                @foreach ($agents as $agent)
                  <option value="{{ $agent->codice }}"
                    @if($agent->codice===$user->codag)
                        selected
                    @endif
                    >[{{$agent->codice}}] {{ $agent->descrizion }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>{{ trans('user.codCli') }}</label>
              <select name="codcli" class="form-control select2" style="width: 100%;">
                <option value=""> </option>
                @foreach ($clients as $client)
                  <option value="{{ $client->id_cli_for }}"
                    @if($client->id_cli_for==$user->codcli)
                        selected
                    @endif
                    >[{{$client->id_cli_for}}] {{ $client->rag_soc }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>{{ trans('user.refDitta') }}</label>
              @if (RedisUser::get('role')=='admin')
                <select name="ditta" class="form-control" style="width: 100%;">
                  <option value="it" @if ($user->ditta=='it') selected="selected" @endif>pNet DATA</option>
                </select>
              @else
                <input type="text" class="form-control" name="ditta" value="pNet_DATA {{$user->ditta}}" readonly="readonly">
              @endif

            </div>

            <hr>

            <div class="form-group">
              <label>isActive?</label>
              <div class="radio">
                <label>
                  <input type="radio" name="isActive" id="opt1" value="0" @if(!$user->isActive) checked @endif>&nbsp;&nbsp;No
                </label>
                <label>
                  <input type="radio" name="isActive" id="opt2" value="1" @if($user->isActive) checked @endif>&nbsp;&nbsp;Si
                </label>
              </div>
            </div>
            @endif

            <div>
              <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('extra_script')
  {{-- @include('layouts.partials.scripts.iCheck')
  @include('layouts.partials.scripts.select2')
  @include('layouts.partials.scripts.datePicker') --}}
@endsection

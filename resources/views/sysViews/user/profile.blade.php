@extends('adminlte::page')
@section('title_postfix', '- '.trans('user.headTitle_pfl'))

@section('content')
  <div class="row">
    <div class="col-lg-12 col-lg-offset-1">
      <img src="{{asset('/assets/img/avatar_default.jpg')}}" style="width:120px; height:120px; float:left; border-radius:50%; margin-right:25px;"/>
      <br>
      <h2>{{ trans('user.userProfile', ['user' => $user->name]) }}</h2>
      {{-- @if (!in_array(RedisUser::get('role'), ['client', 'agent', 'superAgent', 'user'])) --}}
        <a href="{{ route('user::users.edit', $user->id ) }}">
          <button type="submit" id="edit-user-{{ $user->id }}" class="btn btn-block btn-sm btn-outline-warning" style="width:120px;">
              <i class="fa fa-pencil-alt"></i>&nbsp;&nbsp; {{ trans('user.modify') }}
          </button>
        </a>
      {{-- @endif --}}
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="col-lg-12 col-lg-offset-2">
        <div class="card card-default">
          <div class="card-header">
            <h2 class="card-title" data-widget="collapse">{{ trans('user.userSettings') }}</h2>
            {{-- <div class="card-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div> --}}
          </div>
          <div class="card-body">
            <dl class="dl-horizontal">
              <dt>{{ trans('user.name') }}</dt>
              <dd>{{$user->name}}</dd>

              <dt>{{ trans('user.eMail') }}</dt>
              <dd>{{ $user->email }}</dd>

              <dt>{{ trans('user.role') }}</dt>
              <dd>{{$user->roles()->first()->display_name}}</dd>

              @if (!empty($user->codag))
                <dt>{{ trans('user.codAg') }}</dt>
                <dd>{{$user->codag}} - {{$user->agent->descrizion}}</dd>
              @endif

              @if (!empty($user->codcli))
                <dt>{{ trans('user.codCli') }}</dt>
                <dd>{{$user->codcli}} - {{$user->client->rag_soc ?? 'NONE'}}</dd>
              @endif

              <dt>{{ trans('user.refDitta') }}</dt>
              <dd>pNet-Data</dd>

              <hr>

              <dt>{{ trans('user.changeLang') }}</dt>
              <dd>
                <form action="{{ route('user::changeLang') }}" method="post" class="form" style="max-width:30%;">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="input-group">
                    <select class="form-control" name="lang">
                      <option value="" @if ($user->lang=='') selected="selected" @endif>Auto</option>
                      <option value="it" @if ($user->lang==='it') selected="selected" @endif>{{ trans('user.langIT')}}</option>
                      <option value="es" @if ($user->lang=='es') selected="selected" @endif>{{ trans('user.langES')}}</option>
                      <option value="fr" @if ($user->lang=='fr') selected="selected" @endif>{{ trans('user.langFR')}}</option>
                      <option value="en" @if ($user->lang=='en') selected="selected" @endif>{{ trans('user.langEN')}}</option>
                      <option value="de" @if ($user->lang=='de') selected="selected" @endif>{{ trans('user.langDE') }}</option>
                    </select>
                    <span class="input-group-btn">
                      <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-angle-right"></i></button>
                    </span>
                  </div>
                </form>
              </dd>
              <hr>
            </dl>

            <hr>
            @livewire('paride-lw.btn.reset-user-password', ['idUser' => $user->id])
            <hr>

            <form action="{{ url('/gdpr/download') }}" method="post">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-block btn-sm btn-outline-danger" >
                Scarica i tuoi dati (GDPR)
              </button>
            </form>

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

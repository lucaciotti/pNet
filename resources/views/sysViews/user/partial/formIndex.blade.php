<form action="{{ route('user::usersFilterCli') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
    <div class="form-group">
      <label>Ragione Sociale</label>
      {{-- <select name="ragsoc[]" class="form-control select2" multiple="multiple" style="width: 100%;">
        @foreach ($fltClients as $client)
        <option value="{{ $client->id_cli_for }}" @if (in_array($client->id_cli_for, (old('ragsoc') ? old('ragsoc') : [])))
          selected
          @endif
          >
          {{ $client->name }}
        </option>
        @endforeach
      </select> --}}
      <div class="input-group input-group mb-3">
        <div class="input-group-prepend">
          <select type="button" class="btn btn-primary dropdown-toggle" name="ragsocOp">
            <option value="eql">=</option>
            <option value="stw">[]...</option>
            <option value="cnt" selected>...[]...</option>
          </select>
        </div>
        <input type="text" class="form-control" name="ragsoc" value="{{ $ragsocflt ?? '' }}">
      </div>
    </div>
    
    {{-- Codice CLiente --}}
    <div class="form-group">
      <label>Codice Cliente</label>
      <div class="input-group input-group mb-3">
        <div class="input-group-prepend">
          <select type="button" class="btn btn-primary dropdown-toggle" name="codcliOp">
            <option value="eql">=</option>
            <option value="stw">[]...</option>
            <option value="cnt" selected>...[]...</option>
          </select>
        </div>
        <!-- /btn-group -->@php
        if (old('codcli')!=''){
        $codcliflt = (old('codcli'));
        } else {
        // $codcliflt = '';
        }
        @endphp
        <input type="text" class="form-control" name="codcli" value="{{ $codcliflt ?? '' }}">
      </div>
    </div>

    <div class="form-group">
      <label>Email</label>
      <div class="input-group input-group mb-3">
        <div class="input-group-prepend">
          <select type="button" class="btn btn-primary dropdown-toggle" name="emailOp">
            <option value="eql">=</option>
            <option value="stw">[]...</option>
            <option value="cnt" selected>...[]...</option>
          </select>
        </div>
        <input type="text" class="form-control" name="email" value="{{ $emailflt ?? '' }}">
      </div>
    </div>

  <div class="form-group">
    <label>Stato Cliente</label>
    @php
        if(!empty($fltClients) && !empty($fltClients->first())){
          $active = $fltClients->first()->isActive;
        } else {
          $active = true;
        }
    @endphp
    <div class="radio">      
      <input type="radio" name="optIsActive" id="opt1" value="1" @if($active) checked @endif>
      <label for="opt1"> Utenti Attivi &nbsp;&nbsp; </label>    
      <input type="radio" name="optIsActive" id="opt2" value="0" @if(!$active) checked @endif>
      <label for="opt2"> Utenti Non Attivi &nbsp;&nbsp; </label>
    </div>
  </div>
  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

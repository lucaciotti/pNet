<form action="{{ route('client::fltList') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  {{-- Ragione Sociale --}}
  <div class="form-group">
    <label>Ragione Sociale</label>
    <select name="ragsoc[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($fltClients as $client)
        <option 
          value="{{ $client->id_cli_for }}"
          @if (in_array($client->id_cli_for, (old('ragsoc') ? old('ragsoc') : [])))
          selected
          @endif
        >
          {{ $client->rag_soc }}
        </option>
      @endforeach
    </select>
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
      $codcliflt = '';
      }
      @endphp
      <input type="text" class="form-control" name="codcli" value="{{ $codcliflt }}">
    </div>
  </div>
  {{-- Partita Iva --}}
  <div class="form-group">
    <label>Partita Iva</label>
    <div class="input-group input-group mb-3">
      <span class="input-group-prepend">
            <select type="button" class="btn btn-primary dropdown-toggle" name="partivaOp">
              <option value="eql">=</option>
              <option value="stw">[]...</option>
              <option value="cnt" selected>...[]...</option>
            </select>
          </span>
      <input type="text" class="form-control" name="partiva" value="{{ old('partiva') }}">
    </div>
  </div>  

  <div class="form-group">
    <label>{{ trans('client.zone') }}</label>
    <select name="zona[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($zone as $zona)
      <option value="{{ $zona->provincia }}"
        @if (in_array($zona->provincia, (old('zona') ? old('zona') : [])))
        selected
        @endif
        >
        {{ $zona->provincia }}
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

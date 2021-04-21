<form action="{{ route('client::fltList') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  {{-- Ragione Sociale --}}
  <div class="form-group">
    <label>Ragione Sociale</label>
    <select name="ragsoc" class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1"
      aria-hidden="true">
      <option selected="selected" data-select2-id="0"> </option>
      @foreach ($fltClients as $client)
        <option 
          value="{{ $client->id_cli_for }}"
          data-select2-id="{{ $client->id_cli_for }}"
          @if ($client->id_cli_for==old('ragsoc') || $client->id_cli_for==old('codcli'))
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
    <div class="input-group">
      <span class="input-group-btn">
        <select type="button" class="btn btn-warning dropdown-toggle" name="codcliOp">
          <option value="eql">=</option>
          <option value="stw">[]...</option>
          <option value="cnt" selected>...[]...</option>
        </select>
      </span>
      @php
          if (old('ragsoc')!='' || old('codcli')!=''){
            $codcliflt = (old('ragsoc') ? old('ragsoc') : old('codcli'));
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
    <div class="input-group">
      <span class="input-group-btn">
            <select type="button" class="btn btn-warning dropdown-toggle" name="partivaOp">
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
    <select name="zona[]" class="form-control select2 select2-hidden-accessible" style="width: 100%;"
      tabindex="-1" aria-hidden="true">
      @foreach ($zone as $zona)
      <option value="{{ $zona->provincia }}" data-select2-id="{{ $zona->provincia }}" 
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

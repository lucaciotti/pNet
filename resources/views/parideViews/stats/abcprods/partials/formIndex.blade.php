<form action="{{ route('abcProds::fltList') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  {{-- Periodo --}}
  <div class="form-group">
    <label>Periodo di Riferimento:</label>  
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">
          <i class="far fa-calendar-alt"></i>
        </span>
      </div>
      <input type="text" class="form-control float-right" name="docDataPicker">
      <input type="hidden" name="startDate" value="">
      <input type="hidden" name="endDate" value="">
    </div>
  </div>

  {{-- Ragione Sociale --}}
  <div class="form-group">
    <label>Ragione Sociale Cliente</label>
    <select name="client[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($fltClients as $cli)
      <option value="{{ $cli->id_cli_for }}" 
        @if ($client ? in_array($cli->id_cli_for, $client) : in_array($cli->id_cli_for,old('client')))
        selected
        @endif
        >
        {{ $cli->rag_soc }}
      </option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label>Famiglia</label>
    <select name="grpSelected[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($gruppi as $grp)
      <option value="{{ $grp->id_fam }}" @if (in_array($grp->id_fam, (old('grpSelected') ? old('grpSelected') :
        Arr::wrap($grpSelected))))
        selected
        @endif
        >
        [{{ $grp->id_fam }}] {{ $grp->descr }}
      </option>
      @endforeach
    </select>
  </div>

  <hr>
  
  <div class="form-group">
    <label>Marca Prodotto</label>
    <select name="marcheSelected[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($marcheList as $marca)
      <option value="{{ $marca->id_mar }}" @if (in_array($marca->id_mar, (old('marcheSelected') ?
        old('marcheSelected') :
        Arr::wrap($marcheSelected))))
        selected
        @endif
        >
        [{{ $marca->id_mar }}] {{ $marca->descr ?? '' }}
      </option>
      @endforeach
    </select>
  </div>

  <hr>
  
  @if (!in_array(RedisUser::get('role'), ['client', 'agent', 'user']))
  <div class="form-group">
    <label>Fornitore</label>
    <select name="supplierSelected[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($suppliersList as $sup)
      <option value="{{ $sup->id_cli_for }}" @if (in_array($sup->id_cli_for, (old('supplierSelected') ? old('supplierSelected') :
        Arr::wrap($supplierSelected))))
        selected
        @endif
        >
        [{{ $sup->id_cli_for }}] {{ $sup->supplier->rag_soc ?? '' }}
      </option>
      @endforeach
    </select>
  </div>
  @endif

  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

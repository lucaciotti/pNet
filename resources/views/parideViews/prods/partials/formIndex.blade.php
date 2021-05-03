<form action="{{ route('product::fltList') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  {{-- Codice Art --}}
  <div class="form-group">
    <label>Codice Articolo</label>
    <div class="input-group input-group mb-3">
      <div class="input-group-prepend">
        <select type="button" class="btn btn-primary dropdown-toggle" name="codArtOp">
          <option value="eql">=</option>
          <option value="stw">[]...</option>
          <option value="cnt" selected>...[]...</option>
        </select>
      </div><input type="text" class="form-control" name="descrArt" value="{{ old('codArt') }}">
    </div>
  </div>
  {{-- Partita Iva --}}
  <div class="form-group">
    <label>Descr. Art.</label>
    <div class="input-group input-group mb-3">
      <span class="input-group-prepend">
            <select type="button" class="btn btn-primary dropdown-toggle" name="descrArtOp">
              <option value="eql">=</option>
              <option value="stw">[]...</option>
              <option value="cnt" selected>...[]...</option>
            </select>
          </span>
      <input type="text" class="form-control" name="descrArt" value="{{ old('descrArt') }}">
    </div>
  </div>  
  {{-- Barcode --}}
  <div class="form-group">
    <label>Barcode</label>
    <div class="input-group input-group mb-3">
      <span class="input-group-prepend">
        <select type="button" class="btn btn-primary dropdown-toggle" name="barcodeOp">
          <option value="eql">=</option>
          <option value="stw">[]...</option>
          <option value="cnt" selected>...[]...</option>
        </select>
      </span>
      <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}">
    </div>
  </div>
{{-- 
  <div class="form-group">
    <label>Macro Famiglia</label>
    <select name="masterGrpFilter[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @php
      if (old('masterGrpFilter')!=''){
      $fltr = old('masterGrpFilter');
      } else {
      $fltr = $masterGrpFilter;
      }
      @endphp
      @foreach ($masterGrps as $grp)
      <option value="{{ $grp->id_fam }}"
        @if (in_array($grp->id_fam, $fltr))
        selected
        @endif
        >
        [{{ $grp->id_fam }}] {{ $grp->descr }}
      </option>
      @endforeach
    </select>
  </div> --}}

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
    <label>Fornitore</label>
    <select name="supplierSelected[]" class="form-control select2" multiple="multiple" style="width: 100%;">
      @foreach ($suppliersList as $sup)
      <option value="{{ $sup->id_cli_for }}" @if (in_array($sup->id_cli_for, (old('supplierSelected') ? old('supplierSelected') :
        Arr::wrap($supplierSelected))))
        selected
        @endif
        >
        [{{ $sup->id_cli_for }}] {{ $sup->rag_soc }}
      </option>
      @endforeach
    </select>
  </div>

  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

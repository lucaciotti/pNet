<form action="{{-- {{ route('doc::fltList') }} --}}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <div class="form-group">
    <label>{{ trans('doc.descClient') }}</label>
    <div class="input-group input-group mb-3">
      <div class="input-group-prepend">
        <select type="button" class="btn btn-primary dropdown-toggle" name="codcliOp">
          <option value="eql">=</option>
          <option value="stw">[]...</option>
          <option value="cnt" selected>...[]...</option>
        </select>
      </div>
      <input type="text" class="form-control" name="ragsoc" value="{{-- {{$ragSoc or ''}} --}}">
    </div>
  </div>
  
  <div class="form-group">
    <label>{{ trans('doc.dateDoc') }}:</label>
  
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
  <div class="form-group">
    <label>&nbsp;
      <input type="checkbox" name="noDate" id="noDate" value="C" @if($startDate=="" ) checked @endif>
      {{ trans('doc.anyDate') }}
    </label>  
  </div>

  <div class="form-group">
    <label>{{ trans('doc.typeDoc') }}</label>
    <div class="radio">
      <label>
        <input type="radio" name="optTipoDoc" id="opt1" value="" checked> {{ trans('doc.allDocs') }}
      </label>
      <label>
        <input type="radio" name="optTipoDoc" id="opt2" value="P"> {{ trans('doc.quotes') }}
      </label>
      <label>
        <input type="radio" name="optTipoDoc" id="opt3" value="O"> {{ trans('doc.orders') }}
      </label>
      <label>
        <input type="radio" name="optTipoDoc" id="opt4" value="B"> {{ trans('doc.ddt') }}
      </label>
      <label>
        <input type="radio" name="optTipoDoc" id="opt5" value="F"> {{ trans('doc.invoice') }}
      </label>
    </div>
  </div>
  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

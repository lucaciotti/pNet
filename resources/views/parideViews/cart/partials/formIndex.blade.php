<form action="{{ route('cart::fltList') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  @if (!in_array(RedisUser::get('role'), ['client', 'user']))
      <div class="form-group">
        <label>{{ trans('doc.descClient') }}</label>
        <div class="input-group input-group mb-3">
          <div class="input-group-prepend">
            <select type="button" class="btn btn-primary dropdown-toggle" name="ragsocOp">
              <option value="eql">=</option>
              <option value="stw">[]...</option>
              <option value="cnt" selected>...[]...</option>
            </select>
          </div>
          <input type="text" class="form-control" name="ragsoc" value="{{ $ragSoc ?? '' }}">
        </div>
      </div>
  @endif
  
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
    <input type="checkbox" name="noDate" id="noDate" value="C" @if($noDate) checked @endif>
    <label>&nbsp;&nbsp;
      {{ trans('doc.anyDate') }}
    </label>  
  </div>

  <div>
    <button type="submit" class="btn btn-primary">{{ trans('_message.submit') }}</button>
  </div>
</form>

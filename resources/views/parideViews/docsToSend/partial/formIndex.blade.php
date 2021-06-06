<form action="{{ route('doc::fltDdtToSend') }}" method="post">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  
  <div class="form-group">
    <label>Data di Update:</label>
  
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

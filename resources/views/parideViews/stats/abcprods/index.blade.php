@extends('adminlte::page')

@section('title_postfix', '- AbcProds')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    Abc Prodotti
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-lg-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Abc Prodotti</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
              @include('parideViews.stats.abcprods.partials.tblIndex')          
        </div>
        <!-- /.card-body -->
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ trans('client.filter') }}</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
          @include('parideViews.stats.abcprods.partials.formIndex')
        </div>
      </div>
    </div>

  </div>
@stop

@push('js')
  {{-- <script>
    // if ( (window.location.href).endsWith('filter') && window.history.replaceState ) {
    //       window.history.replaceState( null, null, (window.location.href).replace('filter', '') );
    //   }
    // window.onbeforeunload = function() {
    //   if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    //     console.info( "This page is reloaded" );
    //     if("Your work will be lost."){
    //       return window.location.href = "{{ route('abcProds::list')}}";
    //     };
    //   }
    //   return false; 
    // };
    $(document).ready(function($) {

        if(window.event)
        {
        if(window.event.clientX < 40 && window.event.clientY < 0) { alert("Browser back button is clicked..."); } else {
          alert("Browser refresh button is clicked..."); } } else { if(event.currentTarget.performance.navigation.type==1) {
          alert("Browser refresh button is clicked..."); } if(event.currentTarget.performance.navigation.type==2) {
          alert("Browser back button is clicked..."); } }

      // if (window.history && window.history.pushState) {

      //   $(window).on('popstate', function() {
      //     var hashLocation = location.hash;
      //     var hashSplit = hashLocation.split("#!/");
      //     var hashName = hashSplit[1];

      //     if (hashName !== '') {
      //       var hash = window.location.hash;
      //       if (hash === '') {
      //         alert('Back button was pressed.');
      //       }
      //     }
      //   });
      //   // window.history.pushState('forward', null, './#forward');
      // }

    }); --}}
  </script>
@endpush

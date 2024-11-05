@extends('adminlte::page')

@section('title_postfix', '- '.trans('user.headTitle_idx'))

@section('content_header')
<br>
<h1 class="m-0 text-dark">
  {{-- Privacy Policy - Ferramenta Paride Srl --}}
</h1>
<br>
@stop


@section('content')
  <div class="row">
    <div class="col-lg-12">

      @include('sysViews.privacyPolicy.partial.policy')
      

      <div class="card">
        <div class="card-header border-transparent">
          <h3 class="card-title"><strong>Consenso al trattamento dei dati personali</strong></h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @include('sysViews.privacyPolicy.partial.formPolicy')
        </div>
      </div>

    </div>
  </div>
@endsection


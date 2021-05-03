@extends('adminlte::page')

@section('title_postfix', '- ProdList')

@section('content_header')
  <br>
  <h1 class="m-0 text-dark">
    {{ trans('prod.contentTitle_idx') }}
  </h1>
  <br>
@stop

@section('content-fluid')
  <div class="row">

    <div class="col-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">{{ trans('prod.contentTitle_idx') }}</h3>
      
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-condensed dtTbls_light" id="listDocs">
                  <thead>
                    <th>{{ trans('prod.codeArt') }}</th>
                    <th>{{ trans('prod.descArt') }}</th>
                    <th>Famiglia Prodotto</th>
                    <th>Prezzo</th>
                    <th>UM</th>
                    <th>Disponibilità</th>
                    {{-- <th>Barcode</th>
                    <th>Forn.</th> --}}
                  </thead>
                  <tbody>
                    @foreach ($products as $prod)
                    <tr>
                      <td>
                        <a href="{{ route('product::detail', $prod->id_art) }}"> {{ $prod->id_art }} </a>
                      </td>
                      <td>{{ $prod->descr }}</td>
                      <td>[{{ $prod->id_fam }}]
                        @if($prod->grpProd)
                        - {{ $prod->grpProd->descr }}
                        @endif
                      </td>
                      <td>{{ $prod->prezzo_1 }}</td>
                      <td>{{ $prod->um }}</td>
                      <td>0</td>
                      {{-- <td>{{ $prod->id_cod_bar }}</td>
                      <td>[{{ $prod->id_cli_for }}]
                        @if($prod->supplier)
                        - {{ $prod->supplier->rag_soc }}
                        @endif
                      </td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
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
          @include('parideViews.prods.partials.formIndex')
        </div>
      </div>
    </div>
  </div>
@stop

@section('extra_script')
  {{-- @include('layouts.partials.scripts.iCheck')
  @include('layouts.partials.scripts.select2')
  @include('layouts.partials.scripts.datePicker') --}}
@endsection

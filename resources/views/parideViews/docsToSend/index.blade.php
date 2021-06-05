@extends('adminlte::page')

@section('title_postfix', '- Ddt da Inviare')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Ddt da Inviare
</h1>
<br>
@stop


@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Ddt da Inviare</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @include('parideViews.docsToSend.partial.tblIndex', ['docListed' => $docListed])
            </div>
        </div>

    </div>
</div>
@endsection
@extends('adminlte::page')

@section('title_postfix', '- '.trans('user.headTitle_idx'))

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    AdminUtility - Lista Consensi Privacy 
</h1>
<br>
@stop


@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">{{ trans('user.listClients') }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div>
                    <a href="{{ url('/downloadCSVprivacy') }}" class="btn btn-sm btn-default"> Export CSV</a>

                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import-csv">
                        Import CSV
                    </button>
                </div>
                @if (session('success'))
                @push('js')
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'File Importato!',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    });
                </script>
                @endpush
                @endif
                <br>
                @include('sysViews.privacyPolicy.partial.tblList', ['privacyAgree' => $privacyAgree])
            </div>
        </div>

    </div>
</div>

<div class="modal fade show" id="modal-import-csv" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/importCSVprivacy') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="file" class="form-control">
                        <button class="btn btn-primary" type="submit">Invia</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
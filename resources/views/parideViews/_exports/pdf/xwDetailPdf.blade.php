@extends('parideViews._exports.pdf._masterPage.masterPdf')

@section('pdf-main')
<p class="page">
    <div class="row">
        @include('parideViews._exports.pdf.xwDetail.docHead', [$head, $tipodoc] )        
    </div>

    <div class="row">
        <br><br><br><br><br><br><br><br><br><br><br>
        <hr class="dividerPage">
    </div>
    <div class="row">
        <div class="contentTitle">{{ trans('doc.listRows') }}</div>
        @include('parideViews._exports.pdf.xwDetail.tblRowDetail', [$head] )
    </div>
    <div>
        <hr class="dividerPage">
    </div>


    <div class="row">
        <br>
        {{-- <br> --}}
        @include('parideViews._exports.pdf.xwDetail.docFooter2', [$head] )
    </div>

    
    <div class="row">
        <hr class="dividerPage">
    </div>

    <span>
        <u>
            <h4>Note:</h4>
        </u>
        <h5>
            {!! $head->note !!}
        </h5>
        <hr>
        <h5>
            {!! $noteDoc !!}
        </h5>
    </span>

    
    <div class="row">
        <hr class="dividerPage">
    </div>
    
    <span>
        <h6>
            Il nickname per l'accesso riservato associato alla sua azienda è: <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $head->client->id_cli_for }}@pnet.it
        </h6>
    </span>

</p>
@endsection
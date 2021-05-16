@extends('parideViews._exports.pdf._masterPage.masterPdf')

@section('pdf-main')
<p class="page">
    <div class="row">
        @include('parideViews._exports.pdf.docDetail.docHead', [$head, $tipodoc] )        
    </div>

    <div class="row">
        <br><br><br><br><br><br><br><br><br><br><br>
        <hr class="dividerPage">
    </div>
    <div class="row">
        <div class="contentTitle">{{ trans('doc.listRows') }}</div>
        @include('parideViews._exports.pdf.docDetail.tblRowDetail', [$head] )
    </div>
    <div>
        <hr class="dividerPage">
    </div>


    <div class="row">
        <br>
        {{-- <br> --}}
        @include('parideViews._exports.pdf.docDetail.docFooter2', [$head] )
    </div>





    {{-- @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N')
    <div>
        <hr class="dividerPage">
    </div>
    <div class="row">
        <div class="contentTitle">{{ trans('doc.lnkPayment') }}</div>
        @include('parideViews._exports.pdf.docDetail.tblPayment', ['scads'=> $head->scadenza] )
    </div>
    @endif --}}




</p>
@endsection
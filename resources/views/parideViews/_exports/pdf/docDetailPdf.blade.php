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

    @if($tipodoc=='XC')
    <div class="row">
        <br><br><br><br><br><br><br><br><br><br><br>
        <hr class="dividerPage">
    </div>

    <span>
        <u><h4>Note:</h4></u>
        <h5>
            La disponibilità del materiale indicato si intende salvo venduto dalla data del presente documento. 
            <br>
            I tempi o data di consegna sono puramente indicativi e potrebbero subire variazione.
            <br><br>
            Validità del preventivo: 5gg.
        </h5>
    </span>
    @endif

    @if($tipodoc=='BO'|| $tipodoc=='FT'|| $tipodoc=='FD'|| $tipodoc=='FP')
    <div class="row">
        <br><br><br><br><br><br><br><br><br><br><br>
        <hr class="dividerPage">
    </div>
    
    <span>
        <u>
            <h4>Note:</h4>
        </u>
        <h5>
            Non si accetano resi o sostituzioni di materiale oltre 30gg dalla data della presente.
        </h5>
    </span>
    @endif




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
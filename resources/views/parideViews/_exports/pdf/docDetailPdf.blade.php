@extends('parideViews._exports.pdf._masterPage.masterPdf')

@section('pdf-main')
<p class="page">
    <div class="row">
        @include('parideViews._exports.pdf.docDetail.docHead', [$head, $tipodoc] )        
    </div>

    @php
    if($tipodoc=='BO') {
        $stampaPrezzi = ($head->client->nopvddt && !$head->fatturato) ? false : true;
    }else {
        $stampaPrezzi = true;
    }
    @endphp

    <div class="row">
        <br><br><br><br><br><br><br><br><br><br><br>
        <hr class="dividerPage">
    </div>
    <div class="row">
        <div class="contentTitle">{{ trans('doc.listRows') }}</div>
        @include('parideViews._exports.pdf.docDetail.tblRowDetail', [$head, $stampaPrezzi] )
    </div>
    <div>
        <hr class="dividerPage">
    </div>


    <div class="row">
        <br>
        {{-- <br> --}}
        @include('parideViews._exports.pdf.docDetail.docFooter2', [$head, $stampaPrezzi] )
    </div>

    {{-- @if($head->tipomodulo == 'F' || $head->tipomodulo == 'N') --}}
    @if($tipodoc=='FP')
        <div>
            <hr class="dividerPage">
        </div>
        <div class="row">
            {{-- <div class="contentTitle">{{ trans('doc.lnkPayment') }}</div>
            @include('parideViews._exports.pdf.docDetail.tblPayment', ['$head'=> $head] ) --}}
            @if (!$head->pagato && $head->id_pag!=16)
            <span class="contentSubTitle">Estremi Pagamento</span>
            <dl class="dl-horizontal">
                <dd>INTESA SAN PAOLO AG. MASERADA SUL PIAVE (TV)</dd>
                <dd>IBAN: IT61 R030 6961 7881 0000 0001 249</dd>
                <dd>SWIFT: BCITITMM</dd>
            </dl>
            @endif
        </div>
    @endif

    @if($tipodoc=='XC' || $tipodoc=='OC'|| $tipodoc=='BO'|| $tipodoc=='FT' || $tipodoc=='FD' || $tipodoc=='NC')
        
        <div class="row">
            {{-- <br><br><br><br><br><br><br><br><br><br><br> --}}
            <hr class="dividerPage">
        </div>

        <span>
            <u>
                <h4>Note:</h4>
            </u>
            @if(!empty($noteDoc))
                <h5>
                    {!! $noteDoc !!}
                </h5>
            @else
                @if($tipodoc=='XC')
                <h5>
                    La disponibilità del materiale indicato si intende salvo venduto dalla data del presente documento.
                    <br>
                    I tempi o data di consegna sono puramente indicativi e potrebbero subire variazione.
                    <br><br>
                    Validità del preventivo: 5gg.
                </h5>
                @endif
                @if($tipodoc=='OC')
                <h5>
                    Le date di consegna sono indicative e non vincolanti.
                    <br>
                    Il materiale viene fornito in base alle condizioni generali di vendita così come riportato su:
                    <br>https://www.ferramentaparide.it/treviso-termini-e-condizioni
                </h5>
                @endif
                @if($tipodoc=='BO'|| $tipodoc=='FT')
                <h5>
                    Non si accettano resi o sostituzioni di materiale oltre 14gg dalla data della presente.
                    <br>
                    I resi devono essere approvati.
                </h5>
                @endif
                @if($tipodoc=='FT'|| $tipodoc=='FD' || $tipodoc=='NC')
                <h5>
                    Copia digitale della fattura inviata a SDI.
                </h5>
                @endif
            @endif
            
            {{-- @if($tipodoc=='FP' && $head->id_pag!=16)
            <h5>
                INTESA SAN PAOLO AG. MASERADA SUL PIAVE (TV) <br>
                IBAN: IT61 R030 6961 7881 0000 0001 249 <br>
                SWIFT: BCITITMM
            </h5>
            @endif --}}
        </span>
    @endif

    
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
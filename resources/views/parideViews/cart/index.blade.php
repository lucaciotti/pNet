@extends('adminlte::page')

@section('title_postfix', '- Cart Insert')

@section('content_header')
<br>
<h1 class="m-0 text-dark">
    Nuovo Ordine Web
</h1>
{{-- <h6>[ Inserisci Nuovo ]</h6> --}}
<br>
@stop

@section('content-fluid')
    <div class="row d-flex justify-content-center" >
        <div class="col-lg-10">
            
            <div class="bs-stepper linear">
                <div class="card card-default">
                    <div class="card-body p-50">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step active" data-target="#zero-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="zero-part" id="zero-part-trigger"
                                    aria-selected="true" onclick="stepper.to(1)">
                                    <span class="bs-stepper-circle"><span class="fas fa-info"
                                            aria-hidden="true"></span></span>
                                    <span class="bs-stepper-label">Info generali</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#first-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="first-part" id="first-part-trigger"
                                    aria-selected="false" disabled="disabled" onclick="stepper.to(2)">
                                    <span class="bs-stepper-circle"><span class="fas fa-clipboard-list"
                                            aria-hidden="true"></span></span>
                                    <span class="bs-stepper-label">Lista Prodotti</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#second-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="second-part"
                                    id="second-part-trigger" aria-selected="false" disabled="disabled" onclick="stepper.to(3)">
                                    <span class="bs-stepper-circle"><span class="fas fa-map-marked" aria-hidden="true"></span></span>
                                    <span class="bs-stepper-label">Spedizione</span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#third-part">
                                <button type="button" class="step-trigger" role="tab" aria-controls="third-part" id="third-part-trigger"
                                    aria-selected="false" disabled="disabled" onclick="stepper.to(4)">
                                    <span class="bs-stepper-circle"><span class="fas fa-save" aria-hidden="true"></span></span>
                                    <span class="bs-stepper-label">Riepilogo & Salva</span>
                                </button>
                            </div>
                        </div>
                        
                    </div>

                </div>

                <div class="bs-stepper-content">
                    
                    <div id="zero-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="zero-part-trigger">
                        <div class="card card-default">
                            <div class="card-body ">
                                @livewire('cart.add-clientinfo')
                            </div>
                        </div>

                        <div>
                            @livewire('cart.reset-cart')                            
                            <button class="btn btn-primary float-right" onclick="/* stepper.next(); */ Livewire.emit('checkClient');">
                                {{-- <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style></div> --}}
                                Inizia
                            </button>
                        </div>
                    </div>
                    <div id="first-part" class="content" role="tabpanel" aria-labelledby="first-part-trigger">
                        <div class="card card-default">
                            <div class="card-body ">
                                @livewire('cart.table')
                                <br>
                                @livewire('cart.add-cart')
                            </div>
                        </div>

                        <div class="d-md-flex justify-content-between">
                            <div class="col-md-4">
                                @include('parideViews.cart.partials.modalCsv')
                            </div>
                            <div class="col-md-4">
                                @livewire('cart.clear-items')
                            </div>
                            <div class="card card-default col-md-4">
                                <div class="card-body ">
                                    @livewire('cart.total-items')
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary float-left" onclick="stepper.previous()">Indietro</button>
                            <button class="btn btn-primary float-right" onclick="stepper.next()">Continua</button>
                        </div>
                    </div>
                    <div id="second-part" class="content" role="tabpanel" aria-labelledby="second-part-trigger">
                        
                        <div class="card card-default">
                            <div class="card-body">
                                @livewire('cart.add-extrainfo')
                            </div>
                        </div>
                        
                        <div>
                            <button class="btn btn-primary float-left" onclick="stepper.previous()">Indietro</button>
                            <button class="btn btn-primary float-right" onclick="stepper.next()">Continua</button>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    </div>
                    <div id="third-part" class="content" role="tabpanel" aria-labelledby="third-part-trigger">

                        <div class="card collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title" data-card-widget="collapse">Riepilogo Righe Ordine</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body ">
                                @livewire('cart.table', ['isReadOnly' => true], key('time().third-part-trigger'))
                            </div>
                        </div>
                        <br>
                        <div class="d-md-flex justify-content-between">
                            <div class="card card-default col-md-6">
                                <div class="card-body ">
                                    <p>Il presente documento verrà caricato e seguentemente processato da Ferramenta Paride.
                                        <br>
                                        Riceverà uan email con la conferma d'ordine.
                                    </p>
                                    <div class='text-danger'>
                                        Nel caso di:
                                        <ul>
                                            <li>articoli non disponibili o parzialmente disponibili i prezzi potrebbero variare rispetto a quanto indicato
                                                nel portale;</li>
                                            <li>spedizione con porto franco i costi di spedizione verranno riportati nella successiva conferma d'ordine.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-default col-md-4">
                                <div class="card-body ">
                                    @livewire('cart.total-cart')
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-body">
                                @livewire('cart.save')
                            </div>
                        </div>
        
                        <button class="btn btn-primary float-left" onclick="stepper.previous()">Indietro</button>
                        {{-- <button class="btn btn-primary" onclick="stepper.next()">Next</button> --}}
                        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                    </div>

                </div>
                
            </div>

        </div>
        
        <div>
            <br>
        </div>
    </div>

@endsection

@push('css')
<style>
    @media screen and (max-width: 500px) {
        .bs-stepper-label {
            display: none;
        }
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        window.stepper = new Stepper($('.bs-stepper')[0]);
    });
    window.addEventListener('insertClient', event => {
        Livewire.emit('insertClient');
        stepper.to(1);
    });
    window.addEventListener('stepperGoOn', event => {
    stepper.next();
    });
</script>
@endpush
@extends('adminlte::page')

@section('title_postfix', '- Home')

@section('content_header')
    <br><br>
    <h1 class="m-0 text-dark">
        Ciao, <strong>{{ RedisUser::get('name') }}</strong><br>
    </h1>
    <h6 class="m-0 text-dark">
        Questa è la tua dashbord di <strong>pNet</strong>
    </h6>
@stop

@section('content')
    <br><br><br>
    @if (!in_array(RedisUser::get('role'), ['user']))
        <div class="row">
            <div class="col-lg-6 col-6 ml-auto">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $nQuotes }}</h3>
        
                        <p>Preventivi recenti</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clipboard-list"></i>
                    </div>
                    <a href="{{ route('home::newQuotes') }}" class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6 ml-auto">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $nDDTs }}</h3>
            
                        <p>DDT questo mese</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-truck-loading"></i>
                    </div>
                    <a href="{{ route('home::newDDTs') }}" class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-6 ml-auto">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>&NonBreakingSpace;</h3>
            
                        <p>Nuovo Ordine Web</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cart-plus"></i>
                    </div>
                    <a href="{{ route('cart::index') }}" class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6 ml-auto">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $nFattDir+$nFattDif }}</h3>
        
                        <p>Fatture recenti</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-invoice-dollar"></i>
                    </div>
                    <a href="{{ route('home::lastInvoices') }}" class="small-box-footer">Visualizza <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @else
        <div class="row">
            <div class="col-12 col-lg-offset-1">
                <div class="card">
                    <div class="card-body">
                        <h3>{{ trans('home.newUserMessage') }}</h3>
                        <p>
                            {{ trans('home.pleaseWait') }}<br>
                            {{ trans('home.thanks') }}
                        </p>
                    </div>
            </div>
            </div>
        </div>
    @endif
@stop

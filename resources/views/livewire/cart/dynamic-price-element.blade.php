<div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title" data-card-widget="collapse">Vendita</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">

        <label>Aggiungi al carrello:</label>
        <div class="d-md-flex justify-content-between" wire:ignore>
            <div class="input-group input-group-sm">
                <input type="number" class="form-control" style="text-align:right;" wire:model="quantity" min="0" @if($useDecimal)
                    step='0.01' @else step="1" @endif @if($importfromDoc) disabled @endif wire:keydown.enter="addToCart"
                    wire:keydown.tab="addToCart">
                
                <div class="input-group-append" style="width:80%">
                    <button class="btn" id="btnCartEl" type="button" style="width:100%" @if($importfromDoc) disabled @endif
                        wire:click="addToCart">
                        @if ($iconRefresh)
                        <i class="fas fa-fw fa-sync"></i> Aggiorna Carrello
                        @else
                        <i class="fas fa-fw fa-cart-plus"></i> ACQUISTA
                        @endif
                    </button>
                </div>

            </div>
        </div>
        <hr>
  
        <label>Listino Calcolato (IVA escl.):</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="prezzVend" style="text-align:right;" wire:model="price">
          <div class="input-group-append">
            <span class="input-group-text">€ / {{ $product->um }}</span>
          </div>
        </div>
        <hr>
        @if ($quantity2>0)
            <label>Prezzo per quantità (IVA escl.):</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text text-primary text-bold">{{ $quantity2 }} o più {{ $product->um }}</span>
              </div>
              <input type="text" class="form-control" readonly name="prezzVend2" style="text-align:right;" wire:model="price2">
              <div class="input-group-append">
                <span class="input-group-text">€ / {{ $product->um }}</span>
              </div>
            </div>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text text-primary text-bold">{{ $quantity3 }} o più {{ $product->um }}</span>
              </div>
              <input type="text" class="form-control" readonly name="prezzVend3" style="text-align:right;" wire:model="price3">
              <div class="input-group-append">
                <span class="input-group-text">€ / {{ $product->um }}</span>
              </div>
            </div>
        @endif
        <hr>
        <label>IVA:</label>
        <div class="input-group">
          <input type="text" class="form-control" readonly name="ivaVend" style="text-align:right;" wire:model="iva"> 
          <div class="input-group-append">
            <span class="input-group-text">%</span>
          </div>
        </div>
  
      </div>
    </div>
  </div>


@push('css')
<style>
    #btnCartEl {
        background-color: #0d91d7;
        color: white;
    }

    #btnCartEl:hover {
        background-color: #14628c;
    }
</style>
@endpush

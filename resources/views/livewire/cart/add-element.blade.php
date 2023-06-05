<div class="d-md-flex justify-content-between" wire:ignore>
    <div class="input-group input-group-sm">
        <input type="number" class="form-control" style="text-align:right;" wire:model="quantity" min="0" @if($useDecimal) step='0.01' @else step="1" @endif @if($importfromDoc) disabled @endif wire:keydown.enter="addToCart" wire:keydown.tab="addToCart" >
        {{-- <div class="input-group-append"> 
            <a href="#" class="input-group-text"><i class="fas fa-fw fa-search"></i></a>
        </div> --}}
        @if(!$productPage)
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" @if($importfromDoc) disabled @endif wire:click="addToCart">
                    @if ($iconRefresh)
                    <i class="fas fa-fw fa-sync"></i>
                    @else
                    <i class="fas fa-fw fa-cart-plus"></i>
                    @endif
                </button>
            </div>
        @else
            <div class="input-group-append" style="width:80%">
                <button class="btn" id="btnCartEl" type="button" style="width:100%" @if($importfromDoc) disabled @endif wire:click="addToCart">
                    @if ($iconRefresh)
                    <i class="fas fa-fw fa-sync"></i> Aggiorna Carrello
                    @else
                    <i class="fas fa-fw fa-cart-plus"></i> ACQUISTA
                    @endif
                </button>
            </div>            
        @endif
    </div>
    @error('quantity') <span class="text-danger">{{ $message }}</span> @enderror
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
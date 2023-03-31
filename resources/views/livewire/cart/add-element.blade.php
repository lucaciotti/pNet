<div class="d-md-flex justify-content-between" wire:ignore>
    <div class="input-group input-group-sm">
        <input type="number" class="form-control" style="text-align:right;" wire:model="quantity" wire:keydown.enter="addToCart" wire:keydown.tab="addToCart" >
        {{-- <div class="input-group-append"> 
            <a href="#" class="input-group-text"><i class="fas fa-fw fa-search"></i></a>
        </div> --}}
        <div class="input-group-append">
            <button class="btn btn-outline-primary" type="button" wire:click="addToCart">
                @if ($iconRefresh)
                <i class="fas fa-fw fa-sync"></i>
                @else
                <i class="fas fa-fw fa-cart-plus"></i>
                @endif
            </button>
        </div>
    </div>
</div>


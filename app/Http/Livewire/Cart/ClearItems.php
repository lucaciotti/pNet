<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class ClearItems extends Component
{
    public $importfromDoc;
    
    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        return view('livewire.cart.clear-items');
    }

    public function resetItems(){
        Cart::clearItems();
        $this->emit('cart_updated');
    }
}

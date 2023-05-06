<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class ClearItems extends Component
{
    public function render()
    {
        return view('livewire.cart.clear-items');
    }

    public function resetItems(){
        Cart::clearItems();
        $this->emit('cart_updated');
    }
}

<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class ResetCart extends Component
{
    public function render()
    {
        return view('livewire.cart.reset-cart');
    }

    public function resetCart(){
        Cart::destroy();
        $this->emit('cart_deleted');
        $this->emit('cart_updated');
    }
}

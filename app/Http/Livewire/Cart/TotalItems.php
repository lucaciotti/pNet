<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class TotalItems extends Component
{
    public $cart;

    protected $listeners = ['cart_updated' => 'render'];
    
    public function render()
    {
        $this->cart = Cart::getDetails();
        return view('livewire.cart.total-items');
    }
}

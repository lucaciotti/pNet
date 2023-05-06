<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class TotalCart extends Component
{
    public $cart;

    protected $listeners = ['cart_updated' => 'render'];

    public function render()
    {
        Cart::applyTax([
            'id'         => 22,
            'title'      => 'IVA (22%)',
        ]);
        $this->cart = Cart::getDetails();
        // dd($this->cart);
        return view('livewire.cart.total-cart');
    }
}

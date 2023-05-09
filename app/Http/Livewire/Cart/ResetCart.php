<?php

namespace App\Http\Livewire\Cart;

use Carbon\Carbon;
use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class ResetCart extends Component
{
    public function render()
    {
        return view('livewire.cart.reset-cart');
    }

    public function resetCart(){
        // Cart::destroy();
        Cart::setExtraInfo('order.id', '');
        Cart::setExtraInfo('order.shipdate', Carbon::now());
        Cart::setExtraInfo('customer.code', '');
        Cart::setExtraInfo('price.customer', '');
        Cart::setExtraInfo('customer.destination', '');
        Cart::setExtraInfo('order.idPag', '');
        Cart::setExtraInfo('order.tipoSped', '');
        Cart::setExtraInfo('order.fromDoc', false);
        Cart::clearItems();
        $this->emit('cart_deleted');
        $this->emit('cart_updated');
    }
}

<?php

namespace App\Http\Livewire\Cart;

use Jackiedo\Cart\Facades\Cart;
use LaravelMatomoTracker;
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
        try {
            //code...
            LaravelMatomoTracker::doTrackEcommerceCartUpdate($this->cart->get('total'));
            LaravelMatomoTracker::doTrackEcommerceOrder(Cart::getExtraInfo('order.id'), $this->cart->get('total'), $this->cart->get('items_subtotal'));
        } catch (\Throwable $th) {
            //throw $th;
        }
        // dd($this->cart);
        return view('livewire.cart.total-cart');
    }
}

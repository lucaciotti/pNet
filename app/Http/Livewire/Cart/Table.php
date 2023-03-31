<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;

class Table extends Component
{
    public $cartCount= 0;
    public $cartItems;

    public $products = [];

    public $isReadOnly = false;

    // protected $listeners = ['cart.item.added' => 'render'];
    protected $listeners = ['cart_updated' => 'render'];

    public function mount($isReadOnly=false){
        $this->isReadOnly = $isReadOnly;
    }
    public function render()
    {
        $this->cartItems=Cart::getDetails()->get('items');
        $this->cartCount=$this->cartItems->count();
        return view('livewire.cart.table');
    }

    public function deleteItem($itemHash){
        Cart::removeItem($itemHash);
        $this->emit('cart_updated');
    }
}

<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Support\Arr;

use App\Models\parideModels\Product;

class AddElement extends Component
{
    public $product;
    public $quantity;
    public $iconRefresh=false;
    
    private $viewLoaded = false;

    // protected $listeners = [
    //     'cart_updated' => 'render',
    // ];

    public function mount($product){
        $this->product = Product::find($product->id_art);
        $cartItem = ($this->product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->product->id_art])) : null;
        $this->quantity = $cartItem!=null ? $cartItem->getDetails()->quantity : 0;
        $this->iconRefresh = $cartItem!=null ? true : false;
    }

    public function render()
    {   
        return view('livewire.cart.add-element');
    }

    public function hydrate(){
        return;
    }

    public function addToCart(){
        $cartItem = ($this->product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->product->id_art])) : null;
        if($cartItem==null){
            $this->product->addToCart('default', [
                'quantity' => $this->quantity
            ]);
        } else {
            Cart::updateItem($cartItem->getHash(), [
                'quantity' => $this->quantity
            ]);
        }
        $this->emit('cart_updated');
        // dd($cartItem);
    }
}

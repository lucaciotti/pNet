<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
 
class NavItem extends Component
{
    use LivewireAlert;

    public $cartCount= 0;
    public $cartItems;

    // protected $listeners = ['cart.item.added' => 'render'];
    protected $listeners = [
        'cart_updated' => 'updated',
        'cart_saved' => 'saved'
    ];
    

    public function mount(){
    }

    public function render()
    {
        $this->cartItems=Cart::getDetails()->get('items');
        $this->cartCount=$this->cartItems->count();
        return view('livewire.cart.nav-item');
    }

    public function updated(){
        $this->alert('success', 'Carrello Aggiornato!', [
            'position' =>  'bottom-end',
            // 'padding' => '10px',
            'timer' =>  3000,
            'toast' =>  true,
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  true,
            'showConfirmButton' =>  false,
        ]);
        $this->render();
    }

    public function saved(){
        $this->alert('success', 'Ordine Salvato con Successo!', [
            'position' =>  'bottom-end',
            // 'padding' => '10px',
            'timer' =>  3000,
            'toast' =>  true,
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  true,
            'showConfirmButton' =>  false,
        ]);
        $this->render();
    }

    public function deleteItem($itemHash){
        Cart::removeItem($itemHash);
        $this->emit('cart_updated');
    }

    public function openLink($id_art){
        redirect()->route('product::detail', $id_art);
    }
}

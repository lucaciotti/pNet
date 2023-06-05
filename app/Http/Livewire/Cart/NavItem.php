<?php

namespace App\Http\Livewire\Cart;

use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Jantinnerezo\LivewireAlert\LivewireAlert;
 
class NavItem extends Component
{
    use LivewireAlert;

    public $importfromDoc;
    
    public $cartCount= 0;
    public $cartItems;

    // protected $listeners = ['cart.item.added' => 'render'];
    protected $listeners = [
        'cart_updated' => 'updated',
        'cart_saved' => 'saved',
        'quantityGtThan0' => 'quantityGtThan0'
    ];
    

    public function mount(){
    }

    public function render()
    {
        $this->cartItems=Cart::getDetails()->get('items');
        $this->cartCount=$this->cartItems->count();
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        return view('livewire.cart.nav-item');
    }

    public function updated(){
        $this->alert('info', 'Carrello Aggiornato!', [
            'position' =>  'bottom-end',
            // 'padding' => '10px',
            'timer' =>  3000,
            'toast' =>  true,
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        $this->render();
    }

    public function saved(){
        $this->alert('info', 'Ordine Salvato con Successo!', [
            'position' =>  'bottom-end',
            // 'padding' => '10px',
            'timer' =>  3000,
            'toast' =>  true,
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
            'showConfirmButton' =>  false,
        ]);
        $this->render();
    }

    public function quantityGtThan0()
    {
        $this->alert('error', 'La quantità deve essere maggiore di 0!', [
            'position' =>  'bottom-end',
            // 'padding' => '10px',
            'timer' =>  3000,
            'toast' =>  true,
            'cancelButtonText' =>  'Cancel',
            'showCancelButton' =>  false,
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

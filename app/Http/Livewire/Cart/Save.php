<?php

namespace App\Http\Livewire\Cart;

use DB;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;

use App\Models\parideModels\Docs\wDocHead;
use App\Models\parideModels\Docs\wDocRow;

class Save extends Component
{
    public $cartItems;
    public $cartInfo;
    public $customer;
    public $destination;
    public $sendEmail=false;
    public $email;

    public $errorMessage;

    protected $listeners = [
        'cart_updated' => 'render',
        'cart_info_updated' => 'render',
    ];
    
    public function render()
    {
        return view('livewire.cart.save');
    }

    public function saveOrder(){
        $this->reset('errorMessage');
        $cartItems=Cart::getDetails()->get('items');
        $cartCount=$cartItems->count();
        $codCli = Cart::getExtraInfo('customer.code', '');
        $idDest = Cart::getExtraInfo('customer.destination', 0);

        if($cartCount==0){
            $this->errorMessage = 'Attenzione! Lista Prodotti Vuota...inserire almeno un prodotto!';
            return;
        }
        if(empty($codCli)){
            $this->errorMessage = 'Attenzione! Selezionare il Cliente di riferimento per l\'ordine!';
            return;
        }
        try {
            DB::transaction(function() use ($codCli, $idDest, $cartItems) {
                $head=wDocHead::create([
                    'tipo_doc' => 'XW',
                    'id_cli_for' => $codCli,
                    'id_dest_pro' => $idDest,
                ]);

                if($head){
                    foreach ($cartItems as $item) {
                        wDocRow::create([
                            'doc_head_id' => $head->id,
                            'id_art' => $item->model->id_art,
                            'quantity' => $item->quantity,
                        ]);
                    }
                }
            });
        } catch (\Throwable $th) {
            $this->errorMessage = $th->getMessage();
            return;
        }

        Cart::destroy();      
        $this->emit('cart_saved');  
        
        redirect()->route('cart::list');
        

    }
}

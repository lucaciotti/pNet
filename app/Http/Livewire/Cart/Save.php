<?php

namespace App\Http\Livewire\Cart;

use DB;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;

use App\Models\parideModels\Docs\wDocHead;
use App\Models\parideModels\Docs\wDocRow;
use Carbon\Carbon;

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
        $cartDetails=Cart::getDetails();
        $cartItems=Cart::getDetails()->get('items');
        $cartActions=Cart::getDetails()->get('applied_actions');
        $cartCount=$cartItems->count();
        $codCli = Cart::getExtraInfo('customer.code', '');
        $idDest = Cart::getExtraInfo('customer.destination', 0);
        $rif_ord = Cart::getExtraInfo('order.id', '');
        $shipdate = Cart::getExtraInfo('order.shipdate');
        $tipo_sped = Cart::getExtraInfo('order.tipoSped', '');
        $id_pag = Cart::getExtraInfo('order.idPag', 0);

        if($cartCount==0){
            $this->errorMessage = 'Attenzione! Lista Prodotti Vuota...inserire almeno un prodotto!';
            return;
        }
        if(empty($codCli)){
            $this->errorMessage = 'Attenzione! Selezionare il Cliente di riferimento per l\'ordine!';
            return;
        }
        try {
            DB::transaction(function() use ($codCli, $idDest, $rif_ord, $shipdate, $tipo_sped, $id_pag, $cartDetails, $cartItems, $cartActions) {
                $head=wDocHead::create([
                    'tipo_doc' => 'XW',
                    'id_cli_for' => $codCli,
                    'rif_num' => $rif_ord,
                    'data' => Carbon::now(),
                    'data_eva' => $shipdate,
                    'id_pag' => $id_pag,
                    'tipo_sped' => $tipo_sped,
                    'tot_imp' => $cartDetails->get('taxable_amount'),
                    'tot_iva' => $cartDetails->get('tax_amount'),
                    'totale' =>  $cartDetails->get('total'),
                ]);

                if($head){
                    foreach ($cartItems as $item) {
                        wDocRow::create([
                            'doc_head_id' => $head->id,
                            'id_art' => $item->model->id_art,
                            'descr' => $item->model->descr,
                            'quantity' => $item->quantity,
                            'prezzo' => $item->get('price'),
                            'iva' => 22,
                            'val_riga' => $item->get('total_price'),
                        ]);
                    }
                    if(count($cartActions)>0){
                        wDocRow::create([
                            'doc_head_id' => $head->id,
                            'id_art' => 0,
                            'descr' => '--- Extra ---',
                            'quantity' => 0,
                            'prezzo' => 0,
                            'iva' => 0,
                            'val_riga' => 0,
                        ]);
                        foreach ($cartActions as $action) {
                            wDocRow::create([
                                'doc_head_id' => $head->id,
                                'id_art' => 0,
                                'descr' => $action->get('title'),
                                'quantity' => 1,
                                'prezzo' => $action->get('amount'),
                                'iva' => 22,
                                'val_riga' => $action->get('amount'),
                            ]);
                        }
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

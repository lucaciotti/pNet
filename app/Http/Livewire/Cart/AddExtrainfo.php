<?php

namespace App\Http\Livewire\Cart;

use RedisUser;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Validation\Validator;

use App\Models\parideModels\Client;
use App\Models\parideModels\Destinazioni;
use App\Models\parideModels\PaymentType;

class AddExtrainfo extends Component
{
    public $codCli;
    public $idDest;
    public $tipo_sped;
    public $id_pag;

    public $clientDefault;
    public $listDest = [];
    public $listPag = [];
    
    public $destSelected;
    
    protected $rules = [
        'codCli' => 'required',
    ];

    protected $listeners = [
        'cart_client_updated' => 'loadClient',
    ];

    public function mount(){
        $this->idDest = Cart::getExtraInfo('customer.destination', '');
        $this->loadClient();
    }

    public function loadClient(){
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        if (!empty($this->codCli)) {
            $this->clientDefault = Client::select('id_cli_for', 'rag_soc', 'indirizzo', 'citta', 'cap', 'provincia', 'id_pag')->find($this->codCli);
            $this->listDest = Destinazioni::where('id_cli_for', $this->codCli)->get()->toArray();
            $this->listPag = PaymentType::all()->toArray();
            $this->id_pag = $this->clientDefault->id_pag;
            Cart::setExtraInfo('order.idPag', $this->id_pag);
            $this->reset('idDest', 'listDest');        
            $this->destSelected = $this->clientDefault;
        }
    }

    public function updatedIdDest(){
        Cart::setExtraInfo('customer.destination', $this->idDest);
        if(!empty($this->idDest)) $this->destSelected = Destinazioni::select('rag_soc', 'indirizzo', 'citta', 'cap', 'provincia')->where('id_cli_for', $this->codCli)->where('id_dest_pro', $this->idDest)->first();
        if(empty($this->idDest))  $this->destSelected = $this->clientDefault;
    }

    public function updatedIdPag()
    {
        Cart::setExtraInfo('order.idPag', $this->id_pag);
    }

    public function updatedTipoSped()
    {
        Cart::setExtraInfo('order.tipoSped', $this->tipo_sped);
    }

    public function render()
    {
        return view('livewire.cart.add-extrainfo');
    }
}

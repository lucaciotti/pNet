<?php

namespace App\Http\Livewire\Cart;

use RedisUser;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Validation\Validator;

use App\Models\parideModels\Client;
use App\Models\parideModels\Destinazioni;

class AddExtrainfo extends Component
{
    public $codCli;
    public $idDest;

    public $listCli = [];
    public $destDefault;
    public $listDest = [];
    
    public $destSelected;
    
    protected $rules = [
        'codCli' => 'required',
    ];

    public function mount(){
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $this->idDest = Cart::getExtraInfo('customer.destination', '');
        if(in_array(RedisUser::get('role'), ['client'])){
            if(empty($this->codCli)) $this->codCli = RedisUser::get('codcli');
            // $this->destDefault = = Client::select('id_cli_for', 'rag_soc', 'indirizzo', 'citta', 'cap', 'provincia')->find($this->codCli);
            // $this->listCli = $this->destDefault->toArray();
        } else {
            $this->listCli = Client::select('id_cli_for', 'rag_soc')->get()->toArray();
        }
        if (!empty($this->codCli)){
            $this->updatedCodCli();
        }
    }

    public function updatedCodCli(){
        $this->reset('idDest', 'listDest');
        Cart::setExtraInfo('customer.code', $this->codCli);
        $this->emit('cart_info_updated');
        
        $this->destDefault = Client::select('id_cli_for', 'rag_soc', 'indirizzo', 'citta', 'cap', 'provincia')->find($this->codCli);
        $this->destSelected = $this->destDefault;
        $this->listDest = Destinazioni::where('id_cli_for', $this->codCli)->get()->toArray();
    }

    public function updatedIdDest(){
        Cart::setExtraInfo('customer.destination', $this->idDest);
        $this->emit('cart_info_updated');

        $this->destSelected = Destinazioni::select('rag_soc', 'indirizzo', 'citta', 'cap', 'provincia')->where('id_cli_for', $this->codCli)->where('id_dest_pro', $this->idDest)->first();
    }

    public function render()
    {
        return view('livewire.cart.add-extrainfo');
    }
}

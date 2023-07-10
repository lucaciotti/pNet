<?php

namespace App\Http\Livewire\Cart;

use RedisUser;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Validation\Validator;

use App\Models\parideModels\Client;
use App\Models\parideModels\Destinazioni;
use Carbon\Carbon;
use Session;

class AddClientinfo extends Component
{
    public $importfromDoc;
    public $codCli;
    public $idOrd;
    public $start_date;

    public $listCli = [];
    
    protected $rules = [
        // 'idOrd' => 'max:16',
        'codCli' => 'required',
    ];
    protected $messages = [
        'idOrd.max' => 'Riferimento Ordine deve essere massimo di 16 caratteri!',
        'codCli.required' => 'E\' obbligatorio selezionare il cliente prima di continuare!',
    ];

    protected $listeners = [
        'insertClient' => 'insertClient',
        'cart_updated' => '$refresh',
        'cart_deleted' => 'loadInit',
    ];

    public function mount(){
        $this->loadInit();
    }

    public function loadInit(){
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $this->idOrd = Cart::getExtraInfo('order.id');
        $this->start_date = Cart::getExtraInfo('order.shipdate');
        if (in_array(RedisUser::get('role'), ['client'])) {
            $this->codCli = RedisUser::get('codcli');
        } else {
            $this->listCli = Client::select('id_cli_for', 'rag_soc')->get()->toArray();
        }
        $this->updatedCodCli();
        if (empty($this->start_date)) {
            $this->start_date = Carbon::now();
            $this->updatedStartDate();
        }
        if (empty($this->idOrd)) {
            $this->idOrd = '#' . Carbon::now()->format('d/m/Y');
            $this->updatedIdOrd();
        }
    }

    public function updatedIdOrd()
    {
        $this->validate();
        Cart::setExtraInfo('order.id', $this->idOrd);
    }

    public function updatedStartDate()
    {
        $this->start_date = Carbon::parse($this->start_date)->timezone('Europe/Rome');
        Cart::setExtraInfo('order.shipdate', $this->start_date);
    }

    public function updatedCodCli()
    {
        Cart::setExtraInfo('customer.code', $this->codCli);
        $this->emit('cart_client_updated');
    }

    public function insertClient(){
        $this->codCli = '';
        $this->validate();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        return view('livewire.cart.add-clientinfo');
    }
}

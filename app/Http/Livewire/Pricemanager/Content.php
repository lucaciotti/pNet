<?php

namespace App\Http\Livewire\Pricemanager;

use App\Models\parideModels\Client;
use App\Models\parideModels\ClientType;
use App\Models\parideModels\SubGrpProd;
use App\Models\parideModels\wPriceManager;
use Livewire\Component;

class Content extends Component
{
    public $price_lists = [];

    #Filtri
    public $gruppi;
    public $grp_selected;
    public $clients;
    public $client_selected;
    public $tipiCli;
    public $tipocli_selected;

    public $viewLoaded = false;

    protected $listeners = ['closeModalPriceMngrForm' => '$refresh', 'refreshComponent' => '$refresh'];

    public function mount()
    {
        if (!$this->viewLoaded) {
            $this->gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
            $this->tipiCli = ClientType::all();
            $this->clients = Client::select('id_cli_for', 'rag_soc')->get();
        }
    }

    public function readyToLoad()
    {
        // wire:init
        $this->viewLoaded = true;
    }

    public function render()
    {
        $this->loadPriceManager();
        return view('livewire.pricemanager.content');
    }

    public function loadPriceManager(){
        $price_lists = wPriceManager::with(['cliente', 'typeCli', 'grpProd']);
        if (!empty($this->grp_selected)) {
            $price_lists->whereIn('id_fam', $this->grp_selected);
        }
        if (!empty($this->client_selected)) {
            $price_lists->whereIn('id_cli_for', $this->client_selected);
        }
        if (!empty($this->tipocli_selected)) {
            $price_lists->whereIn('id_tipo_cl', $this->tipocli_selected);
        }
        $this->price_lists = $price_lists->get();
    }

    public function delete($id_price)
    {
        // dd($id_cli_for);
        wPriceManager::where('id', $id_price)->delete();
        $this->emit('refreshComponent');
    }
}

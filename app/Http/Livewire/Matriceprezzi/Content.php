<?php

namespace App\Http\Livewire\Matriceprezzi;

use App\Models\parideModels\Client;
use App\Models\parideModels\ClientType;
use App\Models\parideModels\Marche;
use App\Models\parideModels\MatricePrezzi;
use App\Models\parideModels\SubGrpProd;
use Livewire\Component;

class Content extends Component
{
    public $price_lists = [];

    #Filtri
    public $gruppi = [];
    public $grp_selected;
    public $clients = [];
    public $client_selected;
    // public $products = [];
    // public $product_selected;
    public $marche = [];
    public $marca_selected;

    public $codeArtSwitch = false;
    public $codArt;

    public $codcli;
    public $ragsoc;
    public $tipiCli = [];
    public $tipocli_selected;

    public $viewLoaded = false;

    protected $listeners = [
        'closeModalPriceMngrForm' => '$refresh', 
        'refreshComponent' => '$refresh',
        'loadFilters' => 'loadFilters'
    ];

    public function mount()
    {
        $this->tipocli_selected = [10];
        $this->loadFilters();
    }

    public function readyToLoad()
    {
        // wire:init
        $this->viewLoaded = true;
    }

    public function render()
    {
        $this->loadPriceManager();
        return view('livewire.matriceprezzi.content');
    }

    public function loadPriceManager(){
        $price_lists = MatricePrezzi::with(['cliente', 'typeCli', 'grpProd', 'product']);
        if (!empty($this->grp_selected)) {
            $price_lists->whereIn('id_fam', $this->grp_selected);
        }
        if (!empty($this->client_selected)) {
            $price_lists->whereIn('id_cli_for', $this->client_selected);
        }
        if (!empty($this->codcli)) {
            $price_lists->where('id_cli_for', 'like', '%'.$this->codcli.'%');
        }
        if (!empty($this->codArt)) {
            $price_lists->where('id_art', 'like', '%' . $this->codArt . '%');
        }
        if (!empty($this->codeArtSwitch)) {
            $price_lists->where('id_art', '!=', '');
        }
        if (!empty($this->ragsoc)) {
            $price_lists->whereHas('cliente', function ($query) {
                $query->where('rag_soc', 'like', '%' . $this->ragsoc . '%')
                ->withoutGlobalScope('agent')
                ->withoutGlobalScope('superAgent')
                ->withoutGlobalScope('client');
            });;
        }
        if (!empty($this->tipocli_selected)) {
            $price_lists->whereIn('id_tipo_cl', $this->tipocli_selected);
        }
        if (!empty($this->marca_selected)) {
            $price_lists->whereIn('id_mar', $this->marca_selected);
        }
        $this->price_lists = $price_lists->get();
    }

    public function loadFilters(){
        if (empty($this->gruppi)) $this->gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
        if (empty($this->tipiCli)) $this->tipiCli = ClientType::all();
        if (empty($this->marche)) $this->marche = Marche::all();
        // if (empty($this->clients)) $this->clients = Client::select('id_cli_for', 'rag_soc')->get();
    }

    public function delete($id_price)
    {
        // dd($id_cli_for);
        wPriceManager::where('id', $id_price)->delete();
        $this->emit('refreshComponent');
    }
}

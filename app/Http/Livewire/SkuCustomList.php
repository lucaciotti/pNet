<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\parideModels\wSkuCustom;
use App\Models\parideModels\Client;
use App\Models\parideModels\Product;

class SkuCustomList extends Component
{
    public $id_art;
    public $descr_art;
    // public $listSkuCodes = [];
    public $readyToLoad = false;

    protected $listeners = ['closeModalSkuCli' => '$refresh'];

    public function mount($id_art)
    {
        $this->id_art= $id_art;
        $this->descr_art = Product::select('descr_pos')->find($this->id_art)->descr_pos;
    }

    public function readyToLoad()
    {
        // wire:init
        // $this->listSkuCodes = wSkuCustom::with(['client' => function ($query) { $query->select('id_cli_for', 'rag_soc'); }])->get();
        $this->readyToLoad = true;        
    }

    public function render()
    {
        return view('livewire.sku-custom-list', [
            'listSkuCodes' => $this->readyToLoad
                ? wSkuCustom::with(['client' => function ($query) { $query->select('id_cli_for', 'rag_soc'); }])->get()
                : [],
        ]);
    }

    public function delete($id_cli_for){
        // dd($id_cli_for);
        wSkuCustom::where(['id_art' => $this->id_art, 'id_cli_for' => $id_cli_for])->delete();
        $this->emit('refreshComponent');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\parideModels\wInfoVettori;
use Livewire\Component;


class InfoVettoriList extends Component
{
    public $infoVettori = [];

    protected $listeners = ['closeModalInfoVettoriForm' => '$refresh', 'refreshComponent' => '$refresh'];

    public function mount(){
    }

    public function render()
    {
        $this->infoVettori = wInfoVettori::all();
        return view('livewire.info-vettori-list');
    }

    public function delete($id){
        // dd($id_cli_for);
        wInfoVettori::where('id', $id)->delete();
        $this->emit('refreshComponent');
    }
}

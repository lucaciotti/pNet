<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

use App\Models\parideModels\Vettori;
use App\Models\parideModels\wInfoVettori;

class InfoVettoriForm extends Component
{   
    public $id_info_vettore;
    public $id_vet;
    public $url;

    public $listVettori;
    
    public $readyToLoad = false;

    protected $rules = [
        // 'sku_code' => 'required|unique:pNet_DATA.w_sku_custom',
        'id_vet' => 'required',
        'url' => 'required',
    ];

    protected $messages = [
        'id_vet.required' => 'E\' obbligatorio selezionare un Vettore!',
        'url.required' => 'E\' obbligatorio inserire un URL tracking valido!',
    ];

    public function mount($idInfoVet)
    {
        $this->id_info_vettore == $idInfoVet;
        $this->listVettori = Vettori::all();
    }

    public function render()
    {
        return view('livewire.info-vettori-form');
    }

    public function readyToLoad() {
        $this->readyToLoad=true;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    public function submit()
    {
        $validatedData = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if(!empty($this->id_vet)){
                    if(wInfoVettori::where('id_vet', $this->id_vet)->exists()){
                        $validator->errors()->add('id_vet', 'Il Vettore ha già un URL associato! Cancellare prima il vecchio riferimento in tabella!');
                    }
                }
                if (!empty($this->url)) {
                    if (strpos($this->url, '<-id_tracking->')==0) {
                        $validator->errors()->add('url', 'Ricorda di inserire "<-id_tracking->" all\'interno dell\'url!');
                    }
                }
            });
        })->validate();
        
        // dd($validatedData);
        if($this->id_info_vettore==0){
        $this->dispatchBrowserEvent('closeModalInfoVettoriForm_0');
            $info=wInfoVettori::create($validatedData);
        } else {
        $this->dispatchBrowserEvent('closeModalInfoVettoriForm_'+$this->id_info_vettore);
            $info = wInfoVettori::where('id', $this->id_info_vettore)->update($validatedData);
        }
        $this->emit('closeModalInfoVettoriForm');
    }
}

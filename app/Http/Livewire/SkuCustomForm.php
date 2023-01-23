<?php

namespace App\Http\Livewire;

use RedisUser;
use Livewire\Component;
use Illuminate\Validation\Validator;

use App\Models\parideModels\wSkuCustom;
use App\Models\parideModels\Client;
use App\Models\parideModels\Product;

class SkuCustomForm extends Component
{

    public $sku_code;
    public $id_art;
    public $descr_art;
    public $id_cli_for;
    public $clients = [];

    public $mode = 'insert';
    public $clientsLoaded = false;

    protected $rules = [
        // 'sku_code' => 'required|unique:pNet_DATA.w_sku_custom',
        'sku_code' => 'required',
        'id_art' => 'required',
        'id_cli_for' => 'required',
    ];

    protected $messages = [
        'sku_code.required' => 'E\' obbligatorio inserire un codice prodotto!',
    ];

    protected $validationAttributes = [
        'sku_code' => 'Codice Prodotto Personalizzato'
    ];

    // protected $listeners = ['skuCodeModalShowed' => 'skuCodeModalShowed'];


    public function mount($id_art, $id_cli_for, $sku_code)
    {
        $this->id_art= $id_art;
        $this->descr_art = Product::select('descr_pos')->find($this->id_art)->descr_pos;
        $this->id_cli_for= $id_cli_for;
        if(!empty($id_cli_for)) $this->mode='edit';
        $this->sku_code= $sku_code;
    }

    public function readyToLoad()
    {
        // wire:init
        $this->skuCodeModalShowed();
        $this->clientsLoaded = true;
    }

    public function render()
    {
        return view('livewire.sku-custom-form');
    }

    public function skuCodeModalShowed() {
        if(!empty($this->id_cli_for)){
            $this->clients = Client::select('id_cli_for', 'rag_soc')->where('id_cli_for', $this->id_cli_for)->get()->toArray();
        } else {
            $this->clients = Client::select('id_cli_for', 'rag_soc')->get()->toArray();
        }        
    }

    public function submit()
    {
        $validatedData = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $sku=wSkuCustom::where('sku_code', $this->sku_code)
                                ->where('id_cli_for', $this->id_cli_for)->get();
                if($sku->count()>0){
                     $validator->errors()->add('sku_code', 'Il codice é già utilizzato per il codice: '.$sku->first()->id_art);
                }
                if($this->mode=='insert'){
                    $sku=wSkuCustom::where('id_art', $this->id_art)
                                    ->where('id_cli_for', $this->id_cli_for)->get();
                    if($sku->count()>0){
                        $validator->errors()->add('id_cli_for', 'Il codice cliente selezionato presenta già un codice personalizzato!\n Cancellare prima il vecchio codice!');
                    }
                }   
            });
        })->validate();
        $this->dispatchBrowserEvent('closeModalSkuCli');
        // $validatedData = $this->validate();
        // dd($validatedData);
        $contact=wSkuCustom::updateOrCreate([
            'id_art' => $validatedData['id_art'],
            'id_cli_for' => $validatedData['id_cli_for']
        ],
        [
            'sku_code' => $validatedData['sku_code']
        ]);
        $this->sku_code = '';
        $this->emit('closeModalSkuCli');
        if(in_array(RedisUser::get('role'), ['client'])){
            return redirect()->to('product/'.$this->id_art);
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedSkuCode(){
        $sku=wSkuCustom::where('sku_code', $this->sku_code)
                        ->where('id_cli_for', $this->id_cli_for)->get();
        if($sku->count()>0){
            $this->addError('sku_code', 'Il codice é già utilizzato per il codice: '.$sku->first()->id_art);
        }
    }

    public function updatedIdCliFor(){
        if($this->mode=='insert'){
            $sku=wSkuCustom::where('id_art', $this->id_art)
                            ->where('id_cli_for', $this->id_cli_for)->get();
            if($sku->count()>0){
                $this->addError('id_cli_for', 'Il codice cliente selezionato presenta già un codice personalizzato!\n Cancellare prima il vecchio codice!');
            }
        }

    }

}

<?php

namespace App\Http\Livewire\Pricemanager;

use App\Models\parideModels\Client;
use App\Models\parideModels\ClientType;
use App\Models\parideModels\SubGrpProd;
use App\Models\parideModels\wPriceManager;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Validation\Validator;

class Form extends Component
{
    public $id_price;
    public $priceManage;

    #form fields
    public $id_tipo_cl;
    public $id_cli_for;
    public $id_fam;
    public $listino;
    public $start_date;
    public $end_date;

    public $clients=[];
    public $tipoClienti=[];
    public $gruppi=[];

    public $viewLoaded = false;
    public $gruppiLoaded = false;
    public $tipoClLoaded = false;
    public $clientiLoaded = false;

    protected $rules = [
        // 'sku_code' => 'required|unique:pNet_DATA.w_sku_custom',
        'id_tipo_cl' => '',
        'id_cli_for' => '',
        'id_fam' => 'required',
        'listino' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
    ];

    protected $messages = [
        'start_date.required' => 'E\' obbligatorio inserire una data di inizio validità!',
        'end_date.required' => 'E\' obbligatorio inserire una data di fine validità!',
        'id_fam.required' => 'E\' obbligatorio inserire la Famiglia Prodotto!',
    ];

    protected $validationAttributes = [
        'start_date' => 'Data Inizio Validità',
        'end_date' => 'Data Fine Validità',
        'id_fam' => 'Famiglia Prodotto',
    ];

    protected $listeners = ['openModalPriceMngrForm' => 'readyToLoad'];

    public function mount($idPrice)
    {
        $this->id_price = $idPrice;
    }

    public function updatedStartDate()
    {
        $this->start_date = Carbon::parse($this->start_date)->timezone('Europe/Rome');
        if (!empty($this->end_date)) {
            if ($this->end_date <= $this->start_date) {
                $this->addError('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
            }
        }
    }
    public function updatedEndDate()
    {
        $this->end_date = Carbon::parse($this->end_date)->timezone('Europe/Rome');
        if (!empty($this->start_date)) {
            if ($this->end_date <= $this->start_date) {
                $this->addError('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
            }
        }
    }
    public function updatedIdTipoCl(){
        $this->id_cli_for = '';
    }
    public function updatedIdCliFor(){
        $this->id_tipo_cl = '';
    }
    public function updated(){
        $this->validate();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function submit()
    {
        $validatedData = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if (!empty($this->end_date)) {
                    if ($this->end_date <= $this->start_date) {
                        $validator->errors()->add('end_date', 'La Data di fine validità non può essere antecedente alla Data di Inizio Validità');
                    }
                }
                if (empty($this->id_tipo_cl) && empty($this->id_cli_for)) {
                    $validator->errors()->add('id_tipo_cl', 'Selezionare almeno uno tra Tipo Cliente e Codice Cliente');
                    $validator->errors()->add('id_cli_for', 'Selezionare almeno uno tra Tipo Cliente e Codice Cliente');
                }
            });
        })->validate();

        // dd($validatedData);
        if ($this->id_price == 0) {
            $this->dispatchBrowserEvent('closeModalPriceMngrForm_0');
            $note = wPriceManager::create($validatedData);
        } else {
            $this->dispatchBrowserEvent('closeModalPriceMngrForm_' + $this->id_price);
            $note = wPriceManager::where('id', $this->id_price)->update($validatedData);
        }
        $this->emit('closeModalPriceMngrForm');
    }

    public function readyToLoad($idPrice)
    {
        if($idPrice==$this->id_price){
            $this->viewLoaded = true;
            $this->loadEntity();
            $this->loadGruppi();
            $this->loadTipoCl();
            $this->loadClienti();
        }
    }
    public function loadEntity(){
        if ($this->id_price != 0) {
            $this->priceManage = wPriceManager::findOrFail($this->id_price);
            $this->id_tipo_cl = $this->priceManage->id_tipo_cl;
            $this->id_cli_for = $this->priceManage->id_cli_for;
            $this->id_fam = $this->priceManage->id_fam;
            $this->listino = $this->priceManage->listino;
            $this->start_date = $this->priceManage->start_date;
            $this->end_date = $this->priceManage->end_date;
        }
    }
    public function loadGruppi(){
        $this->gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get()->toArray();
        $this->gruppiLoaded = true;
    }
    public function loadTipoCl(){
        $this->tipoClienti = ClientType::all()->toArray();
        $this->tipoClLoaded = true;
    }
    public function loadClienti(){
        $this->clients = Client::select('id_cli_for', 'rag_soc')->get()->toArray();
        $this->clientiLoaded = true;
    }

    public function render()
    {
        return view('livewire.pricemanager.form');
    }
}

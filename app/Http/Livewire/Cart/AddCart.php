<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use App\Models\parideModels\Client;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

use App\Models\parideModels\Product;
use LaravelMatomoTracker;
use RedisUser;

class AddCart extends Component
{
    public $importfromDoc;
    public $codCli;
    public $shipdate;

    public $art;
    public $idArt;
    public $skuCustom;
    public $descrArt;
    public $umArt;
    public $quantity=0;
    public $price=0.00;
    public $infoPrice;
    public $total=0.00;

    public $freeDescr;

    public $listArts = [];
    public $listCustomCodes = [];
    public $listDescrArts = [];
    public $listProducts = [];

    public $isArtSelected = false;
    
    public $isToogleSearch = false;
    public $isMultiWordsSearch = false;
    public $isEmptyMultiSearch = false;
    public $useDecimal = false;

    protected $rules = [
        'idArt' => 'required',
        'quantity' => 'required',
    ];

    // protected $listeners = ['cart.item.added' => 'render'];
    protected $listeners = [
        'cart_updated' => 'render',
        'resetLists' => 'resetLists',
        'checkClient' => 'checkClient',
    ];

    public function checkClient()
    {
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $this->shipdate = Cart::getExtraInfo('order.shipdate');
        if(empty($this->codCli)){
            $this->dispatchBrowserEvent('insertClient');
        } else {
            #CONTROLLO RIGHE con valore 0
            $cartModified=false;
            foreach (Cart::getItems() as $hash => $item) {
                if($item->getPrice()==0 || Cart::getExtraInfo('price.customer', '')!=$this->codCli) {
                    if(!empty($item->get('associated_class'))){
                        $cartModified = true;
                        $price = PriceManager::getPrice($this->codCli, $item->getId(), $item->getQuantity(), $this->shipdate);
                        Cart::updateItem($hash, [
                            'price' => $price,
                        ]);
                    }
                }
            }
            if($cartModified){
                $this->applyEstraPrices();
                Cart::setExtraInfo('price.customer', $this->codCli);
                $this->emit('cart_updated');
            }
            $this->dispatchBrowserEvent('stepperGoOn');
        }
    }

    // public function updated($prop){
    //     dd($prop);
    // }

    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        return view('livewire.cart.add-cart');
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function updatedIdArt(){
        if(strlen($this->idArt)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $this->searchListArt();
    }
    public function searchListArt()
    {
        $this->listArts = Product::select('id_art', 'descr')
                                ->where('id_art', 'like', $this->idArt . '%')
                                ->where('non_attivo', 0)
                                ->orWhere('id_cod_bar', 'like', $this->idArt . '%')
                                ->orWhere('id_cod_for', 'like', $this->idArt . '%')
                                ->orWhereHas('barcodes', function ($query) {
                                    $query->where('id_cod_bar', 'like', $this->idArt . '%');
                                })
                                ->get()->toArray();
    }

    public function updatedSkuCustom(){
        if(strlen($this->skuCustom)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $searchStr = $this->skuCustom;
        $this->listCustomCodes = Product::select('id_art', 'descr')
                                ->where('non_attivo', 0)
                                ->whereHas('skuCustomCode', function ($query) use ($searchStr) {
                                    $query->where('sku_code', 'like', $searchStr . '%');
                                })->get()->toArray();
    }

    public function updatedDescrArt(){
        if(strlen($this->descrArt)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $this->listDescrArts = Product::select('id_art', 'descr')
                                        ->where('non_attivo', 0)
                                        ->whereRaw('upper(descr) like (?)',["%{$this->descrArt}%"])->get()->toArray();
    }

    public function toogleSearch(){
        // dd();
        $this->isToogleSearch = !$this->isToogleSearch;
    }

    public function selectedArt($id_art){
        $this->reset();
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $this->shipdate = Cart::getExtraInfo('order.shipdate');
        $this->art =  Product::where('id_art', $id_art)->first();
        $this->idArt = $this->art->id_art;
        $this->descrArt = $this->art->descr;
        $this->umArt = $this->art->um;
        $this->isArtSelected = true;
        $dfl_qta = $this->art->pz_x_conf;
        if($this->umArt=='%' || $this->umArt =='KG' || $this->umArt == 'MQ') $this->useDecimal=true;
        $cartItem = ($this->art->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->idArt])) : null;
        $this->quantity = $cartItem!=null ? $cartItem->getDetails()->quantity : $dfl_qta;
        if($this->umArt=='%') $this->quantity= $this->quantity/100;
        if (!empty($this->codCli)) {
            $price = PriceManager::getPrice($this->codCli, $this->idArt, $this->quantity, $this->shipdate);
            $this->infoPrice = PriceManager::getInfo($this->codCli, $this->idArt, $this->quantity, $this->shipdate);
            $this->price = number_format((float)($price), 3, ',', '\'');
            $this->total = number_format((float)($this->quantity * $price), 2, ',', '\'');
        }
    }

    public function updatedQuantity(){
        if ($this->quantity < 0) {
            $this->quantity = 0;
            $this->emit('quantityGtThan0');
            return;
        }
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $this->shipdate = Cart::getExtraInfo('order.shipdate');
        if (!empty($this->codCli)) {
            $price = PriceManager::getPrice($this->codCli, $this->idArt, $this->quantity, $this->shipdate);
            $this->infoPrice = PriceManager::getInfo($this->codCli, $this->idArt, $this->quantity, $this->shipdate);
            $this->price = number_format((float)($price), 3, ',', '\'');
            $this->total = number_format((float)($this->quantity * $price), 2, ',', '\'');
        }
    }

    public function addToCart(){
        if ($this->quantity <= 0) {
            $this->quantity = 0;
            $this->emit('quantityGtThan0');
            return;
        }
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        Cart::setExtraInfo('price.customer', $this->codCli);
        $product = $this->art;
        $this->withValidator(function (Validator $validator) use ($product){
            $validator->after(function ($validator) use ($product) {
                if(empty($product)){
                    $validator->errors()->add('idArt', 'Attenzione! Articolo non valido!');
                }
                if($this->quantity<=0){
                    $validator->errors()->add('quantity', 'Attenzione! La quantità deve essere maggiore di 0!');
                }
            });
        })->validate();

        $cartItem = ($product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $product->id_art])) : null;
        
        if(!empty($this->codCli)){
            $price = PriceManager::getPrice($this->codCli, $this->idArt, $this->quantity, $this->shipdate);
        }

        if($cartItem==null){
            $product->addToCart('default', [
                'quantity' => $this->quantity,
                'price' => $price,
            ]);
        } else {
            Cart::updateItem($cartItem->getHash(), [
                'quantity' => $this->quantity,
                'price' => $price,
            ]);
        }
        $this->applyEstraPrices();
        try {
            //code...
            LaravelMatomoTracker::addEcommerceItem($this->idArt, $this->descrArt, '', $price, $this->quantity);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $this->reset();
        $this->emit('cart_updated');
    }

    public function addFreeDescr(){
        Cart::addItem([
            'id'=> random_int(1, 999999),
            'title' => $this->freeDescr,
            'quantity' => 0,
            'taxable' => false,
            'price' => 0,
        ]);
        $this->reset();
        $this->emit('cart_updated');
    }

    public function applyEstraPrices(){
        # COTROLLO SUBTOTALE CARRELLO E AGGIUNGO ACTION SOVRAPPREZZO ORDINE MINIMO
        $totalCart = Cart::getItemsSubtotal();
        $paymentType = Cart::getExtraInfo('order.idPag', '');
        if ($totalCart < 50 && in_array($paymentType, [2,16,54,62])) {
            $actions = Cart::getActions(['id' => 1]);
            if (count($actions) == 0) {
                Cart::applyAction([
                    'group' => 'Additional costs',
                    'id'    => 1,
                    'title' => 'Spese Gestione Ordine Minimo',
                    'value' => 2.50
                ]);
            }
        } else {
            $actions = Cart::getActions(['id' => 1]);
            // dd(Arr::first($actions));
            if (count($actions) > 0) {
                Cart::removeAction(Arr::first($actions)->getHash());
            }
        }
        # AGGIUNGO SCONTO DI 2% ORDINE WEB
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $isOrdDiscountEnabled = False;
        if(!empty($this->codCli)){
            $isOrdDiscountEnabled = Client::find($this->codCli)->user->enable_ordweb_discount ?? false;
        }
        $actionsDiscount = Cart::getActions(['id' => 101]);
        if (count($actionsDiscount) == 0 && $isOrdDiscountEnabled) {
            Cart::applyAction([
                'group' => 'Discount',
                'id'    => 101,
                'title' => 'Sconto 2% ordine web',
                'value' => '-2%'
            ]);
        }
        if (count($actionsDiscount) > 0 && !$isOrdDiscountEnabled) {
            Cart::removeAction(Arr::first($actionsDiscount)->getHash());
        }
    }

    public function resetLists(){
        $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
        if(!$this->isArtSelected){
            $this->reset();
        }
    }

    public function resetAll(){
        $this->reset();
    }
}

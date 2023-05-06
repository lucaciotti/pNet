<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Validator;

use App\Models\parideModels\Product;
use RedisUser;

class AddCart extends Component
{
    public $codCli;
    public $shipdate;

    public $idArt;
    public $skuCustom;
    public $descrArt;
    public $umArt;
    public $quantity=0;
    public $searchStr;

    public $listArts = [];
    public $listCustomCodes = [];
    public $listDescrArts = [];
    public $listProducts = [];

    public $isArtSelected = false;
    
    public $isToogleSearch = false;
    public $isMultiWordsSearch = false;
    public $isEmptyMultiSearch = false;

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
        if (in_array(RedisUser::get('role'), ['client'])) {
            if (empty($this->codCli)) $this->codCli = RedisUser::get('codcli');
        } else {
            $this->codCli = Cart::getExtraInfo('customer.code', '');
        }
        $this->shipdate = Cart::getExtraInfo('order.dhipdate');
        if(empty($this->codCli)){
            $this->dispatchBrowserEvent('insertClient');
        } else {
            #CONTROLLO RIGHE con valore 0
            $cartModified=false;
            foreach (Cart::getItems() as $hash => $item) {
                if($item->getPrice()==0 || Cart::getExtraInfo('price.customer', '')!=$this->codCli) {
                    $cartModified = true;
                    $price = PriceManager::getPrice($this->codCli, $item->getId(), $item->getQuantity(), $this->shipdate);
                    Cart::updateItem($hash, [
                        'price' => $price,
                    ]);
                }
            }
            if($cartModified){
                $this->applyEstraPrices();
                Cart::setExtraInfo('price.customer', $this->codCli);
                $this->emit('cart_updated');
            }
        }
    }

    public function render()
    {
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
        $this->listArts = Product::select('id_art', 'descr')->where('id_art', 'like', $this->idArt . '%')->get()->toArray();
    }

    public function updatedSkuCustom(){
        if(strlen($this->skuCustom)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $searchStr = $this->skuCustom;
        $this->listCustomCodes = Product::select('id_art', 'descr')->whereHas('skuCustomCode', function ($query) use ($searchStr) {
                                    $query->where('sku_code', 'like', $searchStr . '%');
                                })->get()->toArray();
    }

    public function updatedDescrArt(){
        if(strlen($this->descrArt)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $this->listDescrArts = Product::select('id_art', 'descr')->whereRaw('upper(descr) like (?)',["%{$this->descrArt}%"])->get()->toArray();
    }

    public function updatedSearchStr(){
        if(strlen($this->searchStr)<3) {
            $this->reset(['listArts', 'listCustomCodes', 'listDescrArts', 'listProducts']);
            return;
        }
        $this->loadProducts();
    }

    public function toogleSearch(){
        $this->isToogleSearch = !$this->isToogleSearch;
    }

    public function selectedArt($id_art){
        $art =  Product::where('id_art', $id_art)->first();
        $this->reset();
        $this->idArt = $art->id_art;
        $this->descrArt = $art->descr;
        $this->umArt = $art->um;
        $this->isArtSelected = true;
        $dfl_qta = $art->pz_x_conf;
        $cartItem = ($art->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->idArt])) : null;
        $this->quantity = $cartItem!=null ? $cartItem->getDetails()->quantity : $dfl_qta;
    }

    public function addToCart(){
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $product = Product::find($this->idArt);
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
        $this->reset();
        $this->emit('cart_updated');
    }

    public function applyEstraPrices(){
        # COTROLLO SUBTOTALE CARRELLO E AGGIUNGO ACTION SOVRAPPREZZO ORDINE MINIMO
        $totalCart = Cart::getItemsSubtotal();
        if ($totalCart < 50) {
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
            if (count($actions) > 0) {
                Cart::removeAction($actions[0]);
            }
        }
        # AGGIUNGO SCONTO DI 2% ORDINE WEB
        $actionsDiscount = Cart::getActions(['id' => 101]);
        if (count($actionsDiscount) == 0) {
            Cart::applyAction([
                'group' => 'Discount',
                'id'    => 101,
                'title' => 'Sconto 2% ordine web',
                'value' => '-2%'
            ]);
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

    public function updatedSearchString(){
        $this->loadProducts();
    }

    public function loadProducts() {
        
        $products_code = Product::select('id_art', 'descr');
        
        $this->isMultiWordsSearch = false;
        $this->isEmptyMultiSearch = false;
        if(!empty($this->searchStr)) {
            $this->listProducts = $this->searchStringWhereStatement($products_code);
        }
        
        if(count($this->listProducts)==0 && $this->isMultiWordsSearch){
            $this->isEmptyMultiSearch = true;
        }
    }

    private function searchStringWhereStatement($products_list){
        $searchStr = trim(Str::upper($this->searchStr));

        if(Str::of($searchStr)->explode(' ')->count()==1){
            $products_list->where(function ($query) use ($searchStr) {
                $query->where('id_art', 'like', $searchStr . '%');

                $query->orWhereRaw('upper(desc_ecom) like (?)',["%{$searchStr}%"])
                        ->orWhereRaw('upper(descr) like (?)',["%{$searchStr}%"]);

                $query->orWhere('id_cod_bar', 'like', $searchStr . '%')
                        ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                            $query->where('id_cod_bar', 'like', $searchStr . '%');
                        });

                $query->orWhereHas('skuCustomCode', function ($query) use ($searchStr) {
                    $query->where('sku_code', 'like', $searchStr . '%');
                });

            });
        } else {
            $aSearchStr = Str::of($searchStr)->explode(' ');
            $this->isMultiWordsSearch = true;
            $products_list->where(function ($query) use ($aSearchStr) {
                $query->where(function($query) use($aSearchStr) {
                    foreach ($aSearchStr as $key => $value) {
                        $query->whereRaw('upper(desc_ecom) like (?)',["%{$value}%"]);
                    }
                });
                $query->orWhere(function($query) use($aSearchStr) {
                    foreach ($aSearchStr as $key => $value) {
                        $query->whereRaw('upper(descr) like (?)',["%{$value}%"]);
                    }
                });
            });
        }

        return $products_list->get()->toArray();
    }
}

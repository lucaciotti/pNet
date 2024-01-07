<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use App\Models\parideModels\Client;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Support\Arr;

use App\Models\parideModels\Product;
use Carbon\Carbon;

class AddElement extends Component
{
    public $importfromDoc;
    public $productPage;
    public $codCli;

    public $product;
    public $quantity=0;
    public $iconRefresh=false;
    public $useDecimal=false;
    
    private $viewLoaded = false;

    protected $listeners = [
        'cart_updated' => 'render',
    ];

    public function mount($product, $productPage=false){
        $this->productPage = $productPage;
        $this->product = Product::find($product->id_art);

        if($this->product->um == '%' || $this->product->um == 'KG') $this->useDecimal=true;

        $cartItem = ($this->product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->product->id_art])) : null;
        $this->quantity = $cartItem != null ? $cartItem->getDetails()->quantity : $this->quantity;
        $this->iconRefresh = $cartItem != null ? true : false;
        if ($this->productPage && $this->quantity == 0) {
            $this->quantity = $this->product->pz_x_conf;
        }
    }

    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        if($this->product->non_attivo) $this->importfromDoc = true; 
        return view('livewire.cart.add-element');
    }

    public function updatedQuantity(){
        if ($this->quantity<0){
            $this->quantity = 0;
            $this->emit('quantityGtThan0');
        }
    }

    public function addToCart(){
        if ($this->quantity <= 0) {
            $this->quantity = 0;
            $this->emit('quantityGtThan0');
            return;
        }
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $shipdate = Cart::getExtraInfo('order.shipdate', Carbon::now());
        if (!empty($this->codCli)) {
            $price = PriceManager::getPrice($this->codCli, $this->product->id_art, $this->quantity, $shipdate);
        } else {
            $price = 0;
        }
        $cartItem = ($this->product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->product->id_art])) : null;
        if($cartItem==null){
            $this->product->addToCart('default', [
                'quantity' => $this->quantity,
                'price' => $price
            ]);
        } else {
            Cart::updateItem($cartItem->getHash(), [
                'quantity' => $this->quantity,
                'price' => $price
            ]);
        }
        $this->applyEstraPrices();
        $this->emit('cart_updated');
        // dd($cartItem);
    }

    public function applyEstraPrices()
    {
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
                Cart::removeAction(Arr::first($actions)->getHash());
            }
        }
        # AGGIUNGO SCONTO DI 2% ORDINE WEB
        $this->codCli = Cart::getExtraInfo('customer.code', '');
        $isOrdDiscountEnabled = False;
        if (!empty($this->codCli)) {
            $isOrdDiscountEnabled = Client::find($this->codCli)->user->enable_ordweb_discount;
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
}

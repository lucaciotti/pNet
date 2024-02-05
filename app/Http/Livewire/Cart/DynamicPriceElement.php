<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use App\Models\parideModels\Client;
use Livewire\Component;
use Jackiedo\Cart\Facades\Cart;
use Illuminate\Support\Arr;

use App\Models\parideModels\Product;
use Carbon\Carbon;
use RedisUser;

class DynamicPriceElement extends Component
{
    public $importfromDoc;
    public $productPage;
    public $codCli;

    public $product;
    public $quantity = 0;
    public $price = 0;
    public $quantity2 = 0;
    public $price2 = 0;
    public $quantity3 = 0;
    public $price3 = 0;
    public $iva = 0;
    public $iconRefresh = false;
    public $useDecimal = false;

    private $viewLoaded = false;

    protected $listeners = [
        'cart_updated' => 'render',
    ];

    public function mount($product, $productPage = false)
    {
        $this->productPage = $productPage;
        $this->product = Product::find($product->id_art);

        if (in_array(RedisUser::get('role'), ['client'])) {
            $this->codCli = RedisUser::get('codcli');
        }

        if ($this->product->um == '%' || $this->product->um =='KG' || $this->product->um == 'MQ') $this->useDecimal = true;

        $cartItem = ($this->product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $this->product->id_art])) : null;
        $this->quantity = $cartItem != null ? $cartItem->getDetails()->quantity : $this->quantity;
        $this->iconRefresh = $cartItem != null ? true : false;
        if ($this->productPage && $this->quantity == 0) {
            $this->quantity = 1;
        }
        $this->iva =  ($this->product->tva) ? $this->product->tva->perc : 0;
        if (!empty($this->codCli)) {
            $price = PriceManager::getPrice($this->codCli, $this->product->id_art, $this->quantity);
            $this->price = number_format((float)($price), 3, ',', '\'');
        }
        #Gestione Prezzo per Quantità
        if ($this->productPage && $this->product->pz_x_conf > 1) {
            $this->quantity2 = $this->product->pz_x_conf/2;
            if(!$this->useDecimal && is_float($this->quantity2)) $this->quantity2 = ceil($this->quantity2);
            $this->quantity3 = $this->product->pz_x_conf;
            if (!empty($this->codCli)) {
                $price2 = PriceManager::getPrice($this->codCli, $this->product->id_art, $this->quantity2);
                $this->price2 = number_format((float)($price2), 3, ',', '\'');
                $price3 = PriceManager::getPrice($this->codCli, $this->product->id_art, $this->quantity3);
                $this->price3 = number_format((float)($price3), 3, ',', '\'');
            }
        }
    }

    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        if ($this->product->non_attivo) $this->importfromDoc = true;         
        return view('livewire.cart.dynamic-price-element');
    }

    public function updatedQuantity() {
        if ($this->quantity < 0) {
            $this->quantity = 0;
            $this->emit('quantityGtThan0');
        }
    
        if (!empty($this->codCli)) {
            $price = PriceManager::getPrice($this->codCli, $this->product->id_art, $this->quantity);
            $this->price = number_format((float)($price), 3, ',', '\'');
        }
    }

    public function addToCart()
    {
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
        if ($cartItem == null) {
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
        $paymentType = Cart::getExtraInfo('order.idPag', '');
        if ($totalCart < 50 && in_array($paymentType, [2, 16, 54, 62])) {
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
}

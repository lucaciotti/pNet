<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use App\Models\parideModels\Product;
use Arr;
use Carbon\Carbon;
use Jackiedo\Cart\Facades\Cart;
use Livewire\Component;

class Doc2cart extends Component
{
    public $doc;

    public function mount($doc){
        $this->doc = $doc;
    }

    public function render()
    {
        return view('livewire.cart.doc2cart');
    }

    public function doc2cart(){
        $doc = $this->doc;
        // Cart::destroy();
        Cart::setExtraInfo('order.id', $doc->rif_num);
        Cart::setExtraInfo('order.shipdate', Carbon::now());
        Cart::setExtraInfo('customer.code', $doc->id_cli_for);
        Cart::setExtraInfo('price.customer', $doc->id_cli_for);
        Cart::setExtraInfo('customer.destination', $doc->id_dest);
        Cart::setExtraInfo('order.idPag', $doc->id_pag);
        Cart::setExtraInfo('order.tipoSped', '');
        Cart::clearItems();
        // sleep(1);
        foreach ($doc->rows as $row) {
            $product = Product::find($row->id_art);
            $cartItem = ($product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $product->id_art])) : null;
            $qta = ($cartItem == null) ? $row->qta_ord : $cartItem->getQuantity() + $row->qta_ord;
            $price = PriceManager::getPrice($doc->id_cli_for, $row->id_art, $qta);
            if ($cartItem == null) {
                $product->addToCart('default', [
                    'quantity' => $qta,
                    'price' => $price,
                ]);
            } else {
                Cart::updateItem($cartItem->getHash(), [
                    'quantity' => $qta,
                    'price' => $price,
                ]);
            }
        }
        $this->applyEstraPrices();

        $this->emit('updated');
        redirect()->route('cart::index');
    }

    protected function applyEstraPrices()
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
}

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
        // Cart::destroy(); $doc->descr_tipodoc.' n°'.
        $rif_doc = $doc->num;
        Cart::setExtraInfo('order.id', $rif_doc);
        Cart::setExtraInfo('order.shipdate', Carbon::now());
        Cart::setExtraInfo('customer.code', $doc->id_cli_for);
        Cart::setExtraInfo('price.customer', $doc->id_cli_for);
        Cart::setExtraInfo('customer.destination', $doc->id_dest);
        Cart::setExtraInfo('order.idPag', $doc->id_pag);
        Cart::setExtraInfo('order.tipoSped', '');
        Cart::setExtraInfo('order.fromDoc', true);
        Cart::clearItems();
        // sleep(1);
        foreach ($doc->rows as $row) {
            $product = Product::find($row->id_art);
            $qta = $row->qta_ord;
            // $price = PriceManager::getPrice($doc->id_cli_for, $row->id_art, $qta);
            $price = $row->prezzo;

            $cartItem = $product->addToCart('default', [
                'quantity' => $qta,
                'price' => $price,
            ]);
            Cart::updateItem($cartItem->getHash(), [
                'title' => $row->descr,
            ]);
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
                Cart::removeAction(Arr::first($actions)->getHash());
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
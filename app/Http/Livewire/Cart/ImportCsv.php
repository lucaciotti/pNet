<?php

namespace App\Http\Livewire\Cart;

use App\Helpers\PriceManager;
use App\Models\parideModels\Client;
use App\Models\parideModels\Product;
use Arr;
use Carbon\Carbon;
use Cart;
use Livewire\Component;
use Livewire\WithFileUploads;
use Log;

class ImportCsv extends Component
{
    use WithFileUploads;

    public $file;

    public $file_extension;
    public $path = '';
    public $filename = '';
    public $file_placeolder = 'Carica file csv...';

    public $importfromDoc;

    protected $rules = [
        'file' => 'required|mimes:csv,txt',
        'file_extension' => 'required|in:csv,txt',
        'filename' => 'required',
    ];

    public function render()
    {
        $this->importfromDoc = Cart::getExtraInfo('order.fromDoc', false);
        return view('livewire.cart.import-csv');
    }

    public function updatedFile()
    {
        // dd($this->file->getClientOriginalName());
        $this->file_extension = strtolower($this->file->getClientOriginalExtension());
        $this->filename = $this->file->getClientOriginalName();
        if ($this->file) {
            $this->file_placeolder = $this->file->getClientOriginalName();
        } else {
            $this->file_placeolder = 'Carica file csv...';
        }
        $this->validate();
    }

    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function import(){
        $this->validate();
        $this->path = $this->file->store('csv_import');
        $codCli = Cart::getExtraInfo('customer.code', '');
        $shipdate = Cart::getExtraInfo('order.shipdate', Carbon::now());
        $row = 0;
        if (($handle = fopen(storage_path('app/' . $this->path), "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $row++;
                if($row==1) continue;
                $num = count($data);
                if($num==2){
                    $id_art = $data[0];
                    $quantity = $data[1];
                    $product = Product::find($id_art);
                    if($product){
                        $cartItem = ($product->hasInCart('default')) ? Arr::first(Cart::getItems(['id' => $product->id_art])) : null;
                        $qta = ($cartItem == null) ? $quantity : $cartItem->getQuantity() + $quantity;
                        if (!empty($codCli)) {
                            $price = PriceManager::getPrice($codCli, $id_art, $qta, $shipdate);
                        } else {
                            $price = 0;
                        }
                        if ($cartItem == null) {
                            $product->addToCart('default', [
                                'quantity' => $qta,
                                'price' => $price
                            ]);
                        } else {
                            Cart::updateItem($cartItem->getHash(), [
                                'quantity' => $qta,
                                'price' => $price
                            ]);
                        }
                        Log::info("Import CSV Imported $id_art [file:" . $this->path . " row: " . $row . "]");
                    } else {
                        Log::error("Import CSV product not found [file:". $this->path . " row: ". $row . "]");
                    }
                } else {
                    Log::error("Import CSV too many element [file:" . $this->path . " row: " . $row . "]");
                }
            }
            fclose($handle);
            unlink(storage_path('app/' . $this->path));
        }
        $this->applyEstraPrices();
        $this->emit('cart_updated');
        $this->reset();
        $this->dispatchBrowserEvent('closeModalCartCSV');
        $this->emit('closeModalCartCSV');
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
        $codCli = Cart::getExtraInfo('customer.code', '');
        $isOrdDiscountEnabled = False;
        if (!empty($codCli)) {
            $isOrdDiscountEnabled = Client::find($codCli)->user->enable_ordweb_discount;
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

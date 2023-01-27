<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\parideModels\Product;

class SearchProducts extends Component
{
    public $searchString;
    public $codeArtSwitch = true;
    public $descrSwitch = true;
    public $barcodeSwitch = true;
    public $customCodeSwitch = true;

    public $products = [];

    public function mount($searchStr){
        $this->searchString  = $searchStr;
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.search-products');
    }

    public function loadProducts() {
        $searchStr = trim(Str::upper($this->searchString));
        
        $products_code = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for','prezzo_1', 'non_attivo', 'nome_foto')
                                ->with(['grpProd', 'supplier', 'magGiac', 'marche']);
        if(Str::wordCount($searchStr)==1){
            if($this->codeArtSwitch){
                    $products_code->where('id_art', 'like', $searchStr . '%');
            }

            if($this->descrSwitch){
                    // $products_code->orwhere('desc_ecom', 'like', '%' . $searchStr . '%')->orWhere('descr', 'like', '%' . $searchStr . '%');
                    $products_code->orWhereRaw('upper(desc_ecom) like (?)',["%{$searchStr}%"])
                                ->orWhereRaw('upper(descr) like (?)',["%{$searchStr}%"]);
            }

            if($this->barcodeSwitch){
                    $products_code->orWhere('id_cod_bar', 'like', $searchStr . '%')
                    ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                        $query->where('id_cod_bar', 'like', $searchStr . '%');
                    });
            }

            if($this->customCodeSwitch){
                $products_code->orWhereHas('skuCustomCode', function ($query) use ($searchStr) {
                    $query->where('sku_code', 'like', $searchStr . '%');
                });
            }
        } else {
            $aSearchStr = Str::of($searchStr)->explode(' ');
            $products_code->where(function($query) use($aSearchStr) {
                foreach ($aSearchStr as $key => $value) {
                    $query->whereRaw('upper(desc_ecom) like (?)',["%{$value}%"]);
                }
            });
            $products_code->orWhere(function($query) use($aSearchStr) {
                foreach ($aSearchStr as $key => $value) {
                    $query->whereRaw('upper(descr) like (?)',["%{$value}%"]);
                }
            });
        }
        
        $this->products = $products_code->get();
    }

    public function updatedSearchString(){
        $this->loadProducts();
    }
    public function updatedCodeArtSwitch(){
        $this->loadProducts();
    }
    public function updatedDescrSwitch(){
        $this->loadProducts();
    }
    public function updatedBarcodeSwitch(){
        $this->loadProducts();
    }
    public function updatedCustomCodeSwitch(){
        $this->loadProducts();
    }

    // public function updated(){
    //     $this->loadProducts();
    // }
}

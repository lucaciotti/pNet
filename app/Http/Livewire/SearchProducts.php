<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\parideModels\Product;
use App\Models\parideModels\Supplier;
use App\Models\parideModels\SubGrpProd;
use App\Models\parideModels\Marche;

class SearchProducts extends Component
{
    public $searchString;
    public $gruppi;
    public $grpSelected;
    public $suppliersList;
    public $supplierSelected;
    public $marcheList;
    public $marcheSelected;
    public $codeArtSwitch = true;
    public $descrSwitch = true;
    public $barcodeSwitch = true;
    public $customCodeSwitch = true;

    public $isMultiWordsSearch = false;
    public $isEmptyMultiSearch = false;

    public $products = [];
    public $viewLoaded = false;

    public function mount($searchStr){
        $this->searchString  = $searchStr;
        if(!$this->viewLoaded){
            $this->gruppi = SubGrpProd::where('id_fam', '!=', '')->orderBy('id_fam')->get();
            $this->suppliersList = Supplier::select('id_cli_for', 'rag_soc')->whereHas('products')->orderBy('id_cli_for')->get();
            $this->marcheList = Marche::all();
        }
        $this->loadProducts();
    }

    public function readyToLoad()
    {
        // wire:init
        $this->viewLoaded = true;
    }

    public function render()
    {
        return view('livewire.search-products');
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
    public function updatedGrpSelected(){
        $this->loadProducts();
    }
    public function updatedMarcheSelected(){
        $this->loadProducts();
    }
    public function updatedSupplierSelected(){
        $this->loadProducts();
    }

    // public function updated(){
    //     $this->loadProducts();
    // }

    // MAIN METHOD 
    public function loadProducts() {
        
        $products_code = Product::select('id_art', 'descr', 'um', 'pz_x_conf', 'id_fam', 'id_cod_bar', 'id_cli_for','prezzo_1', 'non_attivo', 'nome_foto')
                                ->with(['grpProd', 'supplier', 'magGiac', 'marche']);
        
        $this->isMultiWordsSearch = false;
        $this->isEmptyMultiSearch = false;
        if(!empty($this->searchString)) {
            $products_code = $this->searchStringWhereStatement($products_code);
        } else {
            if (empty($this->grpSelected) && empty($this->grpSelected) && empty($this->supplierSelected) && empty($this->marcheSelected)) {
                $products_code->orderBy('id_art', 'desc')->take(50);
            }
        }

        if (!empty($this->grpSelected)) {
            $products_code->whereIn('id_fam', $this->grpSelected);
        }

        if (!empty($this->supplierSelected)) {
            $products_code->whereIn('id_cli_for', $this->supplierSelected);
        }

        if (!empty($this->marcheSelected)) {
            $products_code->whereIn('id_mar', $this->marcheSelected);
        }
        if($this->codeArtSwitch || $this->descrSwitch || $this->barcodeSwitch || $this->customCodeSwitch){
            $this->products = $products_code->get();
        } else {
            $this->products = $products_code->where('id_art', '-1')->get();
        }
        if($this->products->count()==0 && $this->isMultiWordsSearch){
            $this->isEmptyMultiSearch = true;
        }
    }

    private function searchStringWhereStatement($products_list){
        $searchStr = trim(Str::upper($this->searchString));

        if(Str::of($searchStr)->explode(' ')->count()==1){
            $products_list->where(function ($query) use ($searchStr) {
                if($this->codeArtSwitch){
                    $query->where('id_art', 'like', $searchStr . '%');
                }

                if($this->descrSwitch){
                        // $products_code->orwhere('desc_ecom', 'like', '%' . $searchStr . '%')->orWhere('descr', 'like', '%' . $searchStr . '%');
                        $query->orWhereRaw('upper(desc_ecom) like (?)',["%{$searchStr}%"])
                                    ->orWhereRaw('upper(descr) like (?)',["%{$searchStr}%"]);
                }

                if($this->barcodeSwitch){
                        $query->orWhere('id_cod_bar', 'like', $searchStr . '%')
                        ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                            $query->where('id_cod_bar', 'like', $searchStr . '%');
                        });
                }

                if($this->customCodeSwitch){
                    $query->orWhereHas('skuCustomCode', function ($query) use ($searchStr) {
                        $query->where('sku_code', 'like', $searchStr . '%');
                    });
                }
            });
        } else {
            $aSearchStr = Str::of($searchStr)->explode(' ');
            $this->isMultiWordsSearch = true;
            if($this->descrSwitch){
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
            } else {
                $products_list->where('id_art', '-1');
            }
        }

        return $products_list;
    }


}

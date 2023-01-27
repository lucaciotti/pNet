<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\RedisUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\parideModels\Product;

class ProductSearchBar extends Component
{
    public string $searchStr = '';
    public Array $products = [];
    public int $highlightIndex = 0;

    protected $listeners = ['resetFilters' => 'resetFilters'];

    public function mount()
    {
        $this->resetFilters();
    }

    public function resetFilters()
    {
        $this->reset(['searchStr', 'products', 'highlightIndex']);
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->products) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->products) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectProduct()
    {
        $product = $this->products[$this->highlightIndex] ?? null;
        if ($product) {
            $this->redirect(route('product::detail', $product['id_art']));
        }
    }

    public function updatedSearchStr()
    {
        $searchStr = trim(Str::upper($this->searchStr));
        if(Str::wordCount($searchStr)==1){
            $products_code = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Codice Prodotto" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
                ->where('id_art', 'like', $searchStr . '%')->take(25)->get();
            $products_desc = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Descrizione" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
                ->whereRaw('upper(desc_ecom) like (?)',["%{$searchStr}%"])
                ->orWhereRaw('upper(descr) like (?)',["%{$searchStr}%"])
                ->take(25)->get();
            $products_barcode = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Barcode" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
                ->where('id_cod_bar', 'like', $this->searchStr . '%')
                ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                    $query->where('id_cod_bar', 'like', $searchStr . '%');
                })->take(25)->get();
            $products_supplierCode = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Cod. Fornitore" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
                ->whereHas('supplierCodes', function ($query) use ($searchStr) {
                    $query->where('id_cod_for', 'like', $searchStr . '%');
                })->take(25)->get();
            $products_customCode = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Cod. Personalizzato" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
                ->orWhereHas('skuCustomCode', function ($query) use ($searchStr) {
                    $query->where('sku_code', 'like', $searchStr . '%');
                })->take(25)->get();

            $this->products = $products_code->merge($products_desc)->merge($products_barcode)->merge($products_supplierCode)->merge($products_customCode)->toArray();
        } else {
                $aSearchStr = Str::of($searchStr)->explode(' ');
                $products_desc = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Descrizione" as type'), DB::raw('"'.$searchStr.'" as searchStr'));
                // foreach ($aSearchStr as $key => $value) {
                //     if($key==0){
                //         $products_desc->whereRaw('upper(desc_ecom) like (?)',["%{$value}%"])
                //                     ->orWhereRaw('upper(descr) like (?)',["%{$value}%"]);
                //     } else {
                //         $products_desc->orWhereRaw('upper(desc_ecom) like (?)',["%{$value}%"])
                //                     ->orWhereRaw('upper(descr) like (?)',["%{$value}%"]);
                //     }
                // }
                $products_desc->where(function($query) use($aSearchStr) {
                    foreach ($aSearchStr as $key => $value) {
                        $query->whereRaw('upper(desc_ecom) like (?)',["%{$value}%"]);
                    }
                });
                $products_desc->orWhere(function($query) use($aSearchStr) {
                    foreach ($aSearchStr as $key => $value) {
                        $query->whereRaw('upper(descr) like (?)',["%{$value}%"]);
                    }
                });
                $products_desc = $products_desc->take(25)->get();
                $this->products = $products_desc->toArray();
        }   
        
        // dd($this->products);
    }

    public function render()
    {
        return view('livewire.product-search-bar');
    }

    public function goToProducts()
    {
        return redirect()->to('search-products/'.$this->searchStr);
    }
}

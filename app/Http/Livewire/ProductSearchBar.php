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
        $searchStr = Str::upper($this->searchStr);
        $products_code = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Codice Prodotto" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
            ->where('id_art', 'like', $searchStr . '%')->take(25)->get();
        $products_desc = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Descrizione" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
            ->where('desc_ecom', 'like', '%' . $searchStr . '%')
            ->orWhere('descr', 'like', '%' . $searchStr . '%')->take(25)->get();
        $products_barcode = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"Barcode" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
            ->where('id_cod_bar', 'like', $this->searchStr . '%')
            ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                $query->where('id_cod_bar', 'like', $searchStr . '%');
            })->take(25)->get();
        $products_customCode = Product::select('id_art', 'descr', 'id_cli_for', DB::raw('"CustomCode" as type'), DB::raw('"'.$searchStr.'" as searchStr'))
            ->whereHas('supplierCodes', function ($query) use ($searchStr) {
                $query->where('id_cod_for', 'like', $searchStr . '%');
            })
            ->orWhereHas('skuCustomCode', function ($query) use ($searchStr) {
                $query->where('sku_code', 'like', $searchStr . '%');
            })->take(25)->get();

        $this->products = $products_code->merge($products_desc)->merge($products_barcode)->merge($products_customCode)->toArray();
        
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

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\RedisUser;
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
        $this->products = Product::select('id_art', 'descr', 'id_cli_for')
            ->where('id_art', 'like', $searchStr . '%')
            ->where('id_art', 'like', $searchStr . '%')
            ->orWhere('descr', 'like', '%' . $searchStr . '%')
            ->orWhere('id_cod_bar', 'like', $this->searchStr . '%')
            ->orWhereHas('barcodes', function ($query) use ($searchStr) {
                $query->where('id_cod_bar', 'like', $searchStr . '%');
            })
            ->orWhereHas('supplierCodes', function ($query) use ($searchStr) {
                $query->where('id_cod_for', 'like', $searchStr . '%');
            })
            ->take(25)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product-search-bar');
    }
}

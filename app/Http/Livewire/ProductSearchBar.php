<?php

namespace App\Http\Livewire;

use App\Models\parideModels\Product;
use Livewire\Component;

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
            $this->redirect(route('show-contact', $product['id_art']));
        }
    }

    public function updatedSearchStr()
    {
        $this->products = Product::where('id_art', 'like', $this->searchStr . '%')
            ->orWhere('descr', 'like', '%' . $this->searchStr . '%')
            ->take(10)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product-search-bar');
    }
}

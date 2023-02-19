<div id='productSearchBar' class="relative">
    <div class="form-outline">
        <div class="input-group">
            <input class="form-control form-control-navbar" type="search" placeholder="Cerca Prodotti" aria-label="Search"
            wire:model="searchStr"
            wire:keydown.escape="resetFilters"
            wire:keydown.tab="resetFilters"
            wire:keydown.enter="goToProducts"
            wire:keydown.ArrowUp="decrementHighlight"
            wire:keydown.ArrowDown="incrementHighlight">
            <div class="input-group-append">
                <button class="btn btn-navbar">
                    <i class="fas fa-fw fa-search"></i>
                </button>
            </div>
        </div>
        @if(!empty($searchStr))
        <div id='productSearchResult' class="navbar-search-results mySearchResults">
            <div class="list-group myListGroup">
                <a href="#" class="list-group-item list-group-item-action" wire:loading wire:target="searchStr">
                  {{-- <p class="mb-1 text-warning">Caricamento ...</p> --}}
                    <div class="d-flex align-items-center text-secondary">
                        <strong>Caricamento...</strong>
                        <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                    </div>
                </a>
                @if(!empty($products))
                    @foreach($products as $i => $product)
                    
                    <a href="{{ route('product::detail', $product['id_art']) }}" class="list-group-item list-group-item-action">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $product['id_art'] }}</h5>
                        <small>{{ $product['type'] }}</small>
                      </div>
                      <p class="mb-1">{{ $product['descr'] }}</p>
                      {{-- <small>{{ $product['searchStr'] }}</small> --}}
                    </a>

                    @endforeach
                @else
                    <a href="#" class="list-group-item">
                        <div class="search-title">No results...
                        </div>
                        <div class="search-path"></div>
                    </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>


<style>

    .myListGroup {
      max-height: 400px;
      margin-bottom: 10px;
      overflow-y:scroll;
      -webkit-overflow-scrolling: touch;
    }
    .mySearchResults {
        position: absolute;
        width: 500px;
        overflow-y: auto;
        /* background: white; */
        /* border-bottom-left-radius: 10px; */
        /* border-bottom-right-radius: 10px; */
        /* max-height: 200px; */
        /* border: 1px solid gray; */
        /*This is relative to the navbar now*/
        /* left: 0;
        right: 0;
        top: 40px; */
    }
    @media screen and (max-width: 500px) {
      .mySearchResults {
      width: auto;
      }
    }
    .mySearchResults a:link,a:visited,a:hover,a:active {
        color:#000;
    }
    .mySearchResults a:hover,a:active {
        background-color: lightblue;
    }
    .mySearchHighlight {
        background-color: lightblue;
    }
</style>

@push('js')
<script>
    document.addEventListener("click", function(evt) {
        var flyoutElement = document.getElementById('productSearchBar'),
        targetElement = evt.target; // clicked element
        if(document.getElementById('productSearchResult')){
            do {
                if (targetElement == flyoutElement) {
                    // This is a click inside. Do nothing, just return.
                    console.log("Clicked inside!");
                    return;
                }
                // Go up the DOM
                targetElement = targetElement.parentNode;
            } while (targetElement);
            // This is a click outside.
            console.log("Reset Product SeachBar!");
            Livewire.emit('resetFilters')
        } else {
        return;
        }
    });
</script>
@endpush
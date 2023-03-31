<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-cart-arrow-down"></i>
        <span class="badge badge-danger navbar-badge">{{ $cartCount }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width: 400px;">
        <span class="dropdown-item dropdown-header">{{ $cartCount }} Prodotti</span>
            <div class="dropdown-divider"></div>
        @foreach ($cartItems as $item)

            {{-- <a href="#" class="dropdown-item">
                <small><strong>{{ $item->model->id_art }}</strong> - {{ $item->model->descr }}</small>&nbsp;&nbsp;&nbsp;
                <span class="float-right text-muted text-sm">{{ $item->quantity }}</span>
            </a> --}}
            <a {{-- href="{{ route('product::detail', $item->model->id_art) }}" --}} class="dropdown-item">
            
                <div class="media">
                    <div class="media-body">
                        <h3 class="dropdown-item-title">
                            {{ $item->model->id_art }}
                            
                            
                            <button class="btn btn-sm btn-outline-danger float-right ml-1" wire:click='deleteItem("{{ $item->hash }}")'><i class="fas fa-trash" aria-hidden="true"></i></button>
                            <button class="btn btn-sm btn-outline-grey float-right ml-1" wire:click='openLink("{{ $item->model->id_art }}")'><i class="fa fa-external-link" aria-hidden="true"></i></button>
                            {{-- <span class="float-right text-sm text-danger">pz {{ $item->quantity }}</span> --}}
                            {{-- <span class="float-right text-sm text-prymary"><i class="fas fa-open"></i></span>
                            <span class="float-right text-sm text-danger"><i class="fas fa-trash"></i></span> --}}
                        </h3>
                        <p class="text-sm"><small>{{ $item->model->descr }}</small></p>
                        <livewire:cart.add-element :product="$item->model" :wire:key="time().$item->id">
                        {{-- <p class="text-sm text-muted float-right">pz {{ $item->quantity }}</p> --}}
                    </div>
                </div>
                
            </a>
            <div class="dropdown-divider"></div>
        @endforeach
        
        <a href="{{ route('cart::index') }}" class="dropdown-item dropdown-footer">Emetti Ordine</a>
    </div>
</li>
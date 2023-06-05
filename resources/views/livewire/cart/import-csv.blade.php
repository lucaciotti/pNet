<form wire:submit.prevent="import" {{-- wire:init="readyToLoad" --}}>

    <div class="form-group">
        <label for="file">Carica CSV</label>
        <input id="file" type="file" class="btn btn-default w-100" wire:model.lazy="file">
        @error('file') <span class="text-danger">{{ $message }}</span> @enderror
        @error('file_extension') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div wire:loading wire:target="file">Caricamento ...</div>
    <div>
        <button type="submit" @if($importfromDoc) disabled @endif class="btn bg-lightblue btn-sm btn-block" style="margin-top:10px;">Importa</button>
    </div>
    <hr>
    <div class="text-sm text-center">
        <h6>Crea un ordine a partire da un file CSV</h6>
        <p>Il file CSV deve contenere una prima colonna con il codice del prodotto di Ferramenta Paride e una seconda colonna
            con la quantità del prodotto.</p>
        <a href="{{ url('/download/cart_example.csv') }}" download class="text-primary"><i
                class="fa fa-download"></i>Scarica file di esempio</a>
    </div>
</form>

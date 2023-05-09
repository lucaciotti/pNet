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

</form>

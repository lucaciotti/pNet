<div>
    <button class="btn btn-block btn-success" wire:click='saveOrder'>Salva Ordine</button>
    @if($errorMessage) <span class="text-danger">{{ $errorMessage }}</span> @endif
</div>

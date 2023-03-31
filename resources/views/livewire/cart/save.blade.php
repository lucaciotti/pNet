<div>
    <p>Il presente documento verrà caricato e seguentemente processato da Ferramenta Paride.</p>
    <p>Riceverà uan email con la conferma d'ordine.</p>
    <button class="btn btn-block btn-success" wire:click='saveOrder'>Salva Ordine</button>
    @if($errorMessage) <span class="text-danger">{{ $errorMessage }}</span> @endif
</div>

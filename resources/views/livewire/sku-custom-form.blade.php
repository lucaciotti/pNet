<form wire:submit.prevent="submit" wire:init="readyToLoad">
    
    <dl class="dl-horizontal">
        <dt>Codice</dt>
        <dd>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <big><strong>{{$id_art}}</strong></big> -
            <small>{{$descr_art}}</small>
        </dd>
    </dl>

    @if (RedisUser::get('role') != 'client')
        <div class="form-group"style="margin-bottom:5px;">
            <label for="id_cli_for">Codice Cliente</label>
            <select class="form-control select2 livewireSelect2" id="id_cli_for" style="width: 100%;" placeholder="Codice Cliente" wire:model.lazy="id_cli_for">
                @foreach ($clients as $client)
                <option value="{{ $client['id_cli_for'] }}"> {{ $client['rag_soc'] }} </option>
                @endforeach
            </select>
            @error('id_cli_for') <span class="text-danger">{{ $message }}</span> @enderror
            @if (!$clientsLoaded)
                <span class="text-warning"> Caricamento Clienti... Attendere prego </span>
            @endif        
        </div>
    @endif
    
    <div class="form-group" style="margin-bottom:5px;">
        <label for="sku_code">Codice Personalizzato</label>
        <input type="text" class="form-control form-control-sm" id="sku_code" placeholder="Codice Personalizzato Prodotto" wire:model.lazy="sku_code" >
        @error('sku_code') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    
    <div>
        <button type="submit" class="btn bg-lightblue btn-sm btn-block" style="margin-top:10px;">Salva</button>
    </div>

</form>

@push('js')
<script>
    $(document).ready(function() {

        $('#id_cli_for').on('change', function (e) {
            var data = $('#id_cli_for').select2("val");
            @this.set('id_cli_for', data);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2()
    }); });

    window.addEventListener('closeModalSkuCli', event => {
        $("#modal-sku_cli").modal('hide');
    })
</script>
@endpush
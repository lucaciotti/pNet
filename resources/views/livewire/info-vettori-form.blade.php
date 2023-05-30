<form wire:submit.prevent="submit" wire:init="readyToLoad">

    <div class="form-group" style="margin-bottom:5px;">
        <label for="id_vet">Vettore</label>
        <select class="form-control select2 livewireSelect2" id="id_vet" style="width: 100%;" placeholder="Vettore" wire:model.lazy="id_vet">
            <option value=""></option>
            @foreach ($listVettori as $vettore)
                
            <option value="{{ $vettore->id_vet }}">{{ $vettore->rag_soc1 }}</option>
            @endforeach
        </select>
        @error('id_vet') <span class="text-danger">{{ $message }}</span> @enderror
    </div>

    <div class="form-group" style="margin-bottom:5px;">
        <label for="url">Url Tracking</label>
        <div class="input-group date">
            <input type="text" id="url" class="form-control form-control-sm" style="width: 100%;" placeholder="Url Tracking" wire:model.lazy="url">
        </div>
        @error('url') <span class="text-danger">{{ $message }}</span><br> @enderror
        <span class="text-bold text-sm">Inserire "<-id_tracking->" nella porzione di Url, dove deve essere inserito l'ID univoco del tracking vettore. <br>(es. "https://www.sda.it/wps/portal/Servizi_online/dettaglio-spedizione?locale=it&tracing.letteraVettura=<-id_tracking->")</span>
    </div>

    <div>
        <button type="submit" class="btn bg-lightblue btn-sm btn-block" style="margin-top:10px;">Salva</button>
    </div>

</form>

@push('js')
<script>
    $(document).ready(function() {

        $('#id_vet').on('change', function (e) {
            var data = $('#id_vet').select2("val");
            @this.set('id_vet', data);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2();
        });
    });
</script>
@endpush
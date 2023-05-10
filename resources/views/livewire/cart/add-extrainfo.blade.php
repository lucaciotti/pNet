<div>
   
    <div class="d-md-flex justify-content-between">
        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="tipo_sped">Opzioni Spedizione</label>
            <select class="form-control select2 livewireSelect2" id="tipo_sped" style="width: 100%;" placeholder="Opzioni Spedizione" wire:model.lazy="tipo_sped">
                <option value=""></option>
                <option value="Ritiro in Sede">Ritiro in Sede</option>
                <option value="Porto Franco">Porto Franco</option>
                <option value="Porto Assegnato">Porto Assegnato</option>
            </select>
            @error('tipo_sped') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group col-md-6" style="margin-bottom:5px;">
            <label for="id_pag">Tipo Pagamento</label>
            <select class="form-control select2 livewireSelect2" id="id_pag" style="width: 100%;" placeholder="Tipo Pagamento" disabled wire:model.lazy="id_pag">
               @foreach ($listPag as $pag)
                <option value="{{ $pag['id_pag'] }}"> 
                    {{ $pag['descr'] }}
                </option>
                @endforeach
            </select>
            @error('id_pag') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>

    <hr>
    <div class="d-md-flex justify-content-between">
        <div class="form-group col-md-6" style="margin-bottom:5px;" @disabled(empty($codCli))>
            <label for="idDest">Destinazione Merce</label>
            <select class="form-control select2 livewireSelect2" id="idDest" style="width: 100%;" placeholder="Destinazione" wire:model.lazy="idDest">
                @if (!empty($clientDefault))
                    <option value=""> {{ $clientDefault->rag_soc }} - {{ $clientDefault->citta }} [{{ $clientDefault->provincia }}]</option>
                @endif
                @foreach ($listDest as $dest)
                    <option value="{{ $dest['id_dest_pro'] }}"> {{ $dest['rag_soc'] }} - {{ $dest['citta'] }} [{{ $dest['provincia'] }}] </option>
                @endforeach
            </select>
            @error('idDest') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        @if (!empty($destSelected))
        <div class="row col-md-6 d-flex justify-content-center pt-10">
            <div class="card col-lg-10" style="background: lightgrey" >
                <div class="card-body">
                    <h5 class="card-title">Destinazione finale</h5>
                    <p class="card-text">
                        <dl class="dl-horizontal">
                            <dt>{{ $destSelected->rag_soc }}</dt>
                            <dd>
                                {{ $destSelected->indirizzo }}
                                <br>
                                {{ $destSelected->cap }}, {{ $destSelected->citta }} [{{ $destSelected->provincia }}]
                            </dd>
                        </dl>
                    </p>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $('#idDest').on('change', function (e) {
            var data = $('#idDest').select2("val");
            @this.set('idDest', data);
        });
        $('#tipo_sped').on('change', function (e) {
            var data = $('#tipo_sped').select2("val");
            @this.set('tipo_sped', data);
        });
        $('#id_pag').on('change', function (e) {
            var data = $('#id_pag').select2("val");
            @this.set('id_pag', data);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2()
    }); });
</script>
@endpush
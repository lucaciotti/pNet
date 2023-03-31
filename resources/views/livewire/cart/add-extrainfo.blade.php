<div>
    @if (RedisUser::get('role') != 'client')
    <div class="form-group" style="margin-bottom:5px;">
        <label for="codCli">Codice Cliente</label>
        <select class="form-control select2 livewireSelect2" id="codCli" style="width: 100%;" placeholder="Codice Cliente" wire:model.lazy="codCli">
            @foreach ($listCli as $client)
            <option value="{{ $client['id_cli_for'] }}"> {{ $client['id_cli_for'] }} - {{ $client['rag_soc'] }} </option>
            @endforeach
        </select>
        @error('codCli') <span class="text-danger">{{ $message }}</span> @enderror
        @if (!$listCli)
        {{-- <span class="text-warning"> Caricamento Clienti... Attendere prego </span> --}}
        <div class="d-flex align-items-center text-secondary">
            <strong>Caricamento Clienti...</strong>
            <div class="spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
        </div>
        @endif
    </div>
    @endif

    <div class="form-group" style="margin-bottom:5px;" @disabled(empty($codCli))>
        <label for="idDest">Destinazione Merce</label>
        <select class="form-control select2 livewireSelect2" id="idDest" style="width: 100%;" placeholder="Destinazione" wire:model.lazy="idDest">
            @if (!empty($destDefault))
                <option value=""> {{ $destDefault->rag_soc }} - {{ $destDefault->citta }} [{{ $destDefault->provincia }}]</option>
            @endif
            @foreach ($listDest as $dest)
                <option value="{{ $dest['id_dest_pro'] }}"> {{ $dest['rag_soc'] }} - {{ $dest['citta'] }} [{{ $dest['provincia'] }}] </option>
            @endforeach
        </select>
        @error('idDest') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <br>
    @if (!empty($destSelected))
    <div class="row d-flex justify-content-center pt-10">
        <div class="card col-lg-6" style="background: lightgrey" >
            <div class="card-body">
                <h5 class="card-title">Destinazione finale</h5>
                <p class="card-text">
                    <dl class="dl-horizontal">
                        {{-- <dt>Ragione Sociale</dt> --}}
                        <dt>{{ $destSelected->rag_soc }}</dt>
                        {{-- <dt>Via</dt> --}}
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

@push('js')
<script>
    $(document).ready(function() {

        $('#codCli').on('change', function (e) {
            var data = $('#codCli').select2("val");
            @this.set('codCli', data);
        });

        $('#idDest').on('change', function (e) {
            var data = $('#idDest').select2("val");
            @this.set('idDest', data);
        });

    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.processed', (message, component) => {
            $('.select2').select2()
    }); });
</script>
@endpush
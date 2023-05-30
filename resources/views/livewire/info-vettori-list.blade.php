<div>
    <div>
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                @include('parideViews.infoVettori.modalForm', ['idInfoVet' => 0])
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista Gestione Vettori</h3>
    
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
    
                <table class="table table-hover table-condensed dtTbls_full" id="listDocs">
                    <thead>
                        <th>Vettore</th>
                        <th>Url</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($infoVettori as $info)
                        <tr>
                            <td>{{ $info->vettore->rag_soc1 }}</td>
                            <td>{{ $info->url}}</td>
                            <td><button class="btn btn-sm btn-default" wire:click="delete('{{ $info->id }}')" wire:loading.attr="disabled"><i class="fa fa-trash fa-lg text-danger"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

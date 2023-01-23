<div>
    <div>
        {{-- <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <div class="form-group">
                    <label>{{ trans('doc.typeDoc') }}</label>
                    <div class="radio">
                        <input type="radio" name="optTipoDoc" id="opt1" value="" checked>
                        <label for="opt1"> {{ trans('doc.allDocs') }} &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt2" value="P">
                        <label for="opt2"> {{ trans('doc.quotes') }} &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt3" value="O">
                        <label for="opt3"> {{ trans('doc.orders') }} &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt4" value="B">
                        <label for="opt4"> {{ trans('doc.ddt') }} &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt5" value="F">
                        <label for="opt5"> {{ trans('doc.invoice') }} &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt6" value="FD">
                        <label for="opt6">Fatture Differite &nbsp;&nbsp; </label>
                        <input type="radio" name="optTipoDoc" id="opt7" value="N">
                        <label for="opt7">Note di Credito &nbsp;&nbsp; </label>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div> --}}

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                @include('parideViews.docNotes.modalForm', ['idNote' => 0])
            </div>
            <!-- /.card-body -->
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista Note Personalizzate Documenti</h3>
    
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
                        <th>Tipo Documento</th>
                        <th>Note</th>
                        <th>Data Inizio</th>
                        <th>Data Fine</th>
                        {{-- <th></th> --}}
                        <th></th>
                        {{-- <th>Barcode</th>
                        <th>Forn.</th> --}}
                    </thead>
                    <tbody>
                        @foreach ($notes as $note)
                        <tr>
                            <td>{{ $note->tipologia }}</td>
                            {{-- <td>{!! Str::words($note->note, 5, ' ...') !!}</td> --}}
                            <td>{{$note->note}}</td>
                            <td>{{ $note->start_date->format('d/m/Y') }}</td>
                            <td>{{ $note->end_date->format('d/m/Y') }}</td>
                            {{-- <td>@include('parideViews.docNotes.modalForm', ['idNote' => $note->id])</td> --}}
                            <td><button class="btn btn-sm btn-default" wire:click="delete('{{ $note->id }}')" wire:loading.attr="disabled"><i class="fa fa-trash fa-lg text-danger"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
    
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

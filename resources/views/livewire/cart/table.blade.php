<div>
    @if (!$isReadOnly)
    <table class="table table-hover table-condensed text-center" id="tableCart">
    @else
    <table class="table table-hover table-condensed text-center" id="riepCart">
    @endif
        <col width='3%'>
        <col width='15%'>
        <col width='15%'>
        <col width='40%'>
        <col width='10%'>
        <col width='15%'>
        <col width='3%'>
        <thead>
            <tr>
                <th>#</th>
                <th>Cod.Art.</th>
                <th>Vs Cod.Art.</th>
                <th>Descrizione</th>
                <th>UM</th>
                <th>Quantità</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cartItems as $item)
                <tr>
                    <td class="align-middle">{{ $loop->index+1 }}</td>
                    <td class="align-middle"><a href="{{ route('product::detail', $item->model->id_art) }}"> {{ $item->model->id_art }} </a></td>
                    <td class="align-middle">{{ '' }}</td>
                    <td class="align-middle">{{ $item->model->descr }}</td>
                    <td class="align-middle">{{ $item->model->um }}</td>
                    <td>
                        @if ($isReadOnly)
                            {{ $item->quantity }}
                        @else
                            <livewire:cart.add-element :product="$item->model" :wire:key="time().$item->hash">
                        @endif
                    </td>
                    {{-- <td>{{ $item->quantity }}</td> --}}
                    <td>
                        @if (!$isReadOnly)
                        <div class="input-group input-group-sm">
                            <button class="btn btn-sm btn-outline-danger" type="button" wire:click='deleteItem("{{ $item->hash }}")'><i
                                    class="fas fa-fw fa-trash"></i></button>
                        </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</div>

@push('js')
@if (!$isReadOnly)
<script>
    $(document).ready(function() {
        $('#tableCart').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "aaSorting": [],
            "responsive": true,
            "columnDefs": [
            { "responsivePriority": 1, "targets": 0 },
            { "responsivePriority": 2, "targets": 1 },
            { "responsivePriority": 3, "targets": -2 }
            ],
            "language": {
            "lengthMenu": "Mostra _MENU_ righe per pagina",
            "zeroRecords": "Nessuna corrispondenza trovata",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessuna riga trovata",
            "infoFiltered": "(filtrato da _MAX_ righe totali)",
            "decimal": "",
            "emptyTable": "Nessun dato disponibile nella tabella",
            "infoPostFix": "",
            "thousands": ".",
            "loadingRecords": "Caricamento...",
            "processing": "Processamento...",
            "search": "Ricerca:",
            "paginate": {
            "first": "Primo",
            "last": "Ultimo",
            "next": "Prossima",
            "previous": "Precedente"
            }
            }
        });    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            if(message.component.fingerprint.name=='table'){
                if ( $.fn.dataTable.isDataTable( '#listProds' ) ) {
                    table = $('#tableCart').DataTable();
                    table.clear().destroy();
                }
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            if(message.component.fingerprint.name=='table'){
                $('#tableCart').DataTable({
                    "iDisplayLength": 25,
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "aaSorting": [],
                    "responsive": true,
                    "columnDefs": [
                    { "responsivePriority": 1, "targets": 0 },
                    { "responsivePriority": 2, "targets": 1 },
                    { "responsivePriority": 3, "targets": -1 }
                    ],
                    "language": {
                    "lengthMenu": "Mostra _MENU_ righe per pagina",
                    "zeroRecords": "Nessuna corrispondenza trovata",
                    "info": "Pagina _PAGE_ di _PAGES_",
                    "infoEmpty": "Nessuna riga trovata",
                    "infoFiltered": "(filtrato da _MAX_ righe totali)",
                    "decimal": "",
                    "emptyTable": "Nessun dato disponibile nella tabella",
                    "infoPostFix": "",
                    "thousands": ".",
                    "loadingRecords": "Caricamento...",
                    "processing": "Processamento...",
                    "search": "Ricerca:",
                    "paginate": {
                    "first": "Primo",
                    "last": "Ultimo",
                    "next": "Prossima",
                    "previous": "Precedente"
                    },
                    "aria": {
                    "sortAscending": ": attiva per ordinare la colonna in ordine crescente",
                    "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                    }
                    }
                });
            }
        });
    });
</script>
@else
<script>
    $(document).ready(function() {
        $('#riepCart').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "aaSorting": [],
            "responsive": true,
            "columnDefs": [
            { "responsivePriority": 1, "targets": 0 },
            { "responsivePriority": 2, "targets": 1 },
            { "responsivePriority": 3, "targets": -2 }
            ],
            "language": {
            "lengthMenu": "Mostra _MENU_ righe per pagina",
            "zeroRecords": "Nessuna corrispondenza trovata",
            "info": "Pagina _PAGE_ di _PAGES_",
            "infoEmpty": "Nessuna riga trovata",
            "infoFiltered": "(filtrato da _MAX_ righe totali)",
            "decimal": "",
            "emptyTable": "Nessun dato disponibile nella tabella",
            "infoPostFix": "",
            "thousands": ".",
            "loadingRecords": "Caricamento...",
            "processing": "Processamento...",
            "search": "Ricerca:",
            "paginate": {
            "first": "Primo",
            "last": "Ultimo",
            "next": "Prossima",
            "previous": "Precedente"
            }
            }
        });    
    });
    document.addEventListener("livewire:load", () => {
        Livewire.hook('message.sent', (message, component) => {
            if(message.component.fingerprint.name=='table'){
                if ( $.fn.dataTable.isDataTable( '#riepCart' ) ) {
                    table = $('#riepCart').DataTable();
                    table.clear().destroy();
                }
            }
        });
        Livewire.hook('message.processed', (message, component) => {
            if(message.component.fingerprint.name=='table'){
                $('#riepCart').DataTable({
                    "iDisplayLength": 25,
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "aaSorting": [],
                    "responsive": true,
                    "columnDefs": [
                    { "responsivePriority": 1, "targets": 0 },
                    { "responsivePriority": 2, "targets": 1 },
                    { "responsivePriority": 3, "targets": -1 }
                    ],
                    "language": {
                    "lengthMenu": "Mostra _MENU_ righe per pagina",
                    "zeroRecords": "Nessuna corrispondenza trovata",
                    "info": "Pagina _PAGE_ di _PAGES_",
                    "infoEmpty": "Nessuna riga trovata",
                    "infoFiltered": "(filtrato da _MAX_ righe totali)",
                    "decimal": "",
                    "emptyTable": "Nessun dato disponibile nella tabella",
                    "infoPostFix": "",
                    "thousands": ".",
                    "loadingRecords": "Caricamento...",
                    "processing": "Processamento...",
                    "search": "Ricerca:",
                    "paginate": {
                    "first": "Primo",
                    "last": "Ultimo",
                    "next": "Prossima",
                    "previous": "Precedente"
                    },
                    "aria": {
                    "sortAscending": ": attiva per ordinare la colonna in ordine crescente",
                    "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
                    }
                    }
                });
            }
        });
    });
</script>
@endif
@endpush
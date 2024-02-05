{{-- myCurrency --}}
<script>
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "my-currency-pre": function(a) {
            // console.log('sort currency:'+ a.replace(/[^\d\-]/g, ''));
            return parseFloat(a.replace(/[^\d\-]/g, ''));
        },
        "my-currency-asc": function(a,b) {
            return ((a < b) ? -1 : ((a> b) ? 1 : 0));
        },
        "my-currency-desc": function(a,b) {
            return ((a < b) ? 1 : ((a> b) ? -1 : 0));
        }
    });
</script>

{{-- myDatePicker --}}
<script>
    moment.locale('it');
    $('#datePicker').daterangepicker({
      "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Applica",
        "cancelLabel": "Cancella",
        "fromLabel": "Da",
        "toLabel": "A",
        "customRangeLabel": "Personalizza",
        "daysOfWeek": [
          "Dom",
          "Lun",
          "Mar",
          "Mer",
          "Gio",
          "Ven",
          "Sab"
        ],
        "monthNames": [
          "Gennaio",
          "Febbraio",
          "Marzo",
          "Aprile",
          "Maggio",
          "Giugno",
          "Luglio",
          "Agosto",
          "Settembre",
          "Ottobre",
          "Novembre",
          "Dicembre"
        ],
        "firstDay": 1
      }
    });
    $('input[name="docDataPicker"]').daterangepicker(
        {
          "locale": {
          "format": "DD/MM/YYYY",
          "separator": " - ",
          "applyLabel": "Applica",
          "cancelLabel": "Cancella",
          "fromLabel": "Da",
          "toLabel": "A",
          "customRangeLabel": "Personalizza",
          "daysOfWeek": [
          "Dom",
          "Lun",
          "Mar",
          "Mer",
          "Gio",
          "Ven",
          "Sab"
          ],
          "monthNames": [
          "Gennaio",
          "Febbraio",
          "Marzo",
          "Aprile",
          "Maggio",
          "Giugno",
          "Luglio",
          "Agosto",
          "Settembre",
          "Ottobre",
          "Novembre",
          "Dicembre"
          ],
          "firstDay": 1
          }
        },
        function (start, end) {
            // $('.daterange-btn span').html(start.format('D/MM/YYYY') + ' - ' + end.format('D/MM/YYYY'));
            $('input[name="startDate"]').val(start.format('D/MM/YYYY'));
            $('input[name="endDate"]').val(end.format('D/MM/YYYY'));
        }
    );
    $('input[name="noDate"]').click(function() {
        $('input[name="docDataPicker"]').toggle(!this.checked);
        if(this.checked){
            $('input[name="startDate"]').val('');
            $('input[name="endDate"]').val('');
        } else {
            setDataRange(start, end);
        }
    });
    
    function setDataRange(start, end) {
        $('input[name="docDataPicker"]').data('daterangepicker').setStartDate(start);
        $('input[name="docDataPicker"]').data('daterangepicker').setEndDate(end);
        $('input[name="startDate"]').val(start.format('D/MM/YYYY'));
        $('input[name="endDate"]').val(end.format('D/MM/YYYY'));
    };
    
    function setVoidRange() {
        $('input[name="noDate"]').click();
        // $('input[name="noDate"]').iCheck('check', function(event){
        //     // alert(event.type + ' callback');
        //     $('input[name="docDataPicker"]').val('');
        //     $('input[name="docDataPicker"]').prop('disabled', true);
        //     $('input[name="startDate"]').val('');
        //     $('input[name="endDate"]').val('');
        // });
    };
    @if(isset($startDate) || isset($endDate))
        var start = moment('{{$startDate}}');
        var end = moment('{{$endDate}}');
        setDataRange(start, end);
    @else
        // $('.daterange-btn span').html('Seleziona Data');
        console.log("empty StartDate");
        setVoidRange();
    @endif
</script>

{{-- myDatatables --}}
<script>
    $(function () {
    $(".dtTbls_full").DataTable({
      "iDisplayLength": 25,
      "aaSorting": [],
      "lengthChange": true,
      "responsive": true,
      "autoWidth": false,
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
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
    $('.dtTbls_light').DataTable({
      "deferRender": true,
      "stateSave": true,
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
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
    $(".dtTbls_full_Tot").DataTable({
      "iDisplayLength": 25,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      'aoColumnDefs': [
        { 'sType': 'currency', 'aTargets': [4] } // In this case 5th column will be sorted on currency basis.
        ],
      "columnDefs": [
        { "responsivePriority": 1, "targets": 0 },
        { "responsivePriority": 2, "targets": 1 },
        { "responsivePriority": 3, "targets": -1 },
        { type: 'my-currency', targets: 4 }
        ],
      "responsive": true,
      "language": {
        "lengthMenu": "Mostra _MENU_ righe per pagina",
        "zeroRecords": "Nessuna corrispondenza trovata",
        "info": "Pagina _PAGE_ di _PAGES_",
        "infoEmpty": "Nessuna riga trovata",
        "infoFiltered": "(filtrato da _MAX_ righe totali)",
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
    $('.dtTbls_total').DataTable({
      "iDisplayLength": 15,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "aaSorting": [],
      "footerCallback": function ( row, data, start, end, display ) {
          var api = this.api(), data;

          // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  (i.includes("€") ? i.replace(",", ".").replace(" €", "").replace(/[\$,]/g, '')*1 : i.replace(/[\$,]/g, '')*1) :
                  typeof i === 'number' ?
                      i : 0;
          };

          // Total over all pages
          total = api
              .column( 7 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Total over this page
          pageTotal = api
              .column( 7, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          console.log(pageTotal);
          if(api.page.info().page == api.page.info().pages-1){
            $( api.column( 7 ).footer() ).html(
                total.toFixed(2) +' €'//+' ['+ total +' € Tot.Doc.]'
            );
          } else {
            $( api.column( 7 ).footer() ).html(
                "<i class='fa fa-arrow-right'> Ultima Pagina</i> "
            );
          }
      },
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
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
    
    $('.dtTbls_ordWeb').DataTable({
      "iDisplayLength": 15,
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "aaSorting": [],
      "footerCallback": function ( row, data, start, end, display ) {
          var api = this.api(), data;

          // Remove the formatting to get integer data for summation
          var intVal = function ( i ) {
              return typeof i === 'string' ?
                  (i.includes("€") ? i.replace(",", ".").replace(" €", "").replace(/[\$,]/g, '')*1 : i.replace(/[\$,]/g, '')*1) :
                  typeof i === 'number' ?
                      i : 0;
          };

          // Total over all pages
          total = api
              .column( 5 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Total over this page
          pageTotal = api
              .column( 5, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          console.log(pageTotal);
          if(api.page.info().page == api.page.info().pages-1){
            $( api.column( 5 ).footer() ).html(
                total.toFixed(2) +' €'//+' ['+ total +' € Tot.Doc.]'
            );
          } else {
            $( api.column( 5 ).footer() ).html(
                "<i class='fa fa-arrow-right'> Ultima Pagina</i> "
            );
          }
      },
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
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
    });
    
    $('.dtTbls_statAbc').DataTable({
        "iDisplayLength": 25,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "columnDefs": [
        { "responsivePriority": 1, "targets": 0 },
        { "responsivePriority": 2, "targets": 1 },
        { "responsivePriority": 3, "targets": -2 },
        { type: 'my-currency', targets: 3 },
        { type: 'my-currency', targets: 6 },
        ],
      "language": {
        "lengthMenu": "Mostra _MENU_ righe per pagina",
        "zeroRecords": "Nessuna corrispondenza trovata",
        "info": "Pagina _PAGE_ di _PAGES_",
        "infoEmpty": "Nessuna riga trovata",
        "infoFiltered": "(filtrato da _MAX_ righe totali)",
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
        // "aaSorting": [[0, "desc"]],
        // "bStateSave": false
    });
    $('.dtTbls_stat4').DataTable({
        "iDisplayLength": 25,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "aoColumnDefs": [
        {"sType": "my-currency", "aTargets": [2]},
        {"sType": "my-currency", "aTargets": [3]},
        {"sType": "my-currency", "aTargets": [4]},
        {"sType": "my-currency", "aTargets": [5]}
        ]
        // "aaSorting": [[0, "desc"]],
        // "bStateSave": false
        });
        $('.dtTbls_stat5').DataTable({
        "iDisplayLength": 25,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "aoColumnDefs": [
        {"sType": "my-currency", "aTargets": [2]},
        {"sType": "my-currency", "aTargets": [3]},
        {"sType": "my-currency", "aTargets": [4]},
        {"sType": "my-currency", "aTargets": [5]},
        {"sType": "my-currency", "aTargets": [6]}
        ],
      "language": {
        "lengthMenu": "Mostra _MENU_ righe per pagina",
        "zeroRecords": "Nessuna corrispondenza trovata",
        "info": "Pagina _PAGE_ di _PAGES_",
        "infoEmpty": "Nessuna riga trovata",
        "infoFiltered": "(filtrato da _MAX_ righe totali)",
        "decimal":        "",
        "emptyTable":     "Nessun dato disponibile nella tabella",
        "infoPostFix":    "",
        "thousands":      ".",
        "loadingRecords": "Caricamento...",
        "processing":     "Processamento...",
        "search":         "Ricerca:",
        "paginate": {
            "first":      "Primo",
            "last":       "Ultimo",
            "next":       "Prossima",
            "previous":   "Precedente"
        },
        "aria": {
            "sortAscending":  ": attiva per ordinare la colonna in ordine crescente",
            "sortDescending": ": attiva per ordinare la colonna in ordine decrescente"
        }
      }
        // "aaSorting": [[0, "desc"]],
        // "bStateSave": false
    });
  });
</script>

{{-- mySelect2 --}}
<script>
    // function selectAll(class){
  // $(class+"> option").prop("selected","selected");
  // $(".select2").trigger("change");
  // };
    $(function () {
        $('.select2').select2();
        // $(".selectAll").parent('[class*="icheckbox"]').hasClass("checked")
        $("#checkbox.selectAll").on('ifChanged', function(event) {
          if(event.target.checked){
            $(".select2.selectAll > option").prop("selected","selected");
            $(".select2.selectAll").trigger("change");
          }else{
            // $(".select2.selectAll > option").removeAttr("selected");
            $(".select2.selectAll > option").prop("selected","");
            $(".select2.selectAll").trigger("change");
          }
          // console.log('checked = ' + event.target.checked);
          // console.log('value = ' + event.target.value);
        });
        // FOR a normal CheckBox
        // $(".selectAll").click(function(){
        //   console.log('clicked');
        //   if($(".selectAll").is(':checked') ){
        //     $(".select2 > option").prop("selected","selected");
        //     $(".select2").trigger("change");
        //   }else{
        //     $(".select2 > option").removeAttr("selected");
        //     $(".select2").trigger("change");
        //   }
        // });
      });
</script>

{{-- Ekko-LightBox --}}
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

{{-- Tooltip --}}
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

{{-- ZenDesk --}}
<!--Start of Zendesk Chat Script-->
@if(App::environment('production'))
    <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){
        z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
        $.src='https://v2.zopim.com/?5kD2eVVklHiJSkiTapXQljZtRRhqT8MG';z.t=+new Date;$.
        type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
    </script>
@endif
<!--End of Zendesk Chat Script-->

<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://pnetlucaciottispace.matomo.cloud/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src='//cdn.matomo.cloud/pnetlucaciottispace.matomo.cloud/matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

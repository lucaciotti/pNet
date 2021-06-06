{{-- myCurrency --}}
<script>
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "my-currency-pre": function(a) {
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
    $('#datePicker').daterangepicker();
    $('input[name="docDataPicker"]').daterangepicker(
        {},
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
      "columnDefs": [
        { "responsivePriority": 1, "targets": 0 },
        { "responsivePriority": 2, "targets": 1 },
        { "responsivePriority": 3, "targets": -1 }
        ]
        });
    $('.dtTbls_light').DataTable({
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
        ]
    });
    $(".dtTbls_full_Tot").DataTable({
      "iDisplayLength": 25,
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
                  i.replace(/[\$,]/g, '')*1 :
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
          $( api.column( 5 ).footer() ).html(
              pageTotal.toFixed(2) +' €'              
          );
      },
      "responsive": true,
        "columnDefs": [
            { "responsivePriority": 1, "targets": 0 },
            { "responsivePriority": 2, "targets": 1 },
            { "responsivePriority": 3, "targets": -1 }
        ]
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
              .column( 6 )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Total over this page
          pageTotal = api
              .column( 6, { page: 'current'} )
              .data()
              .reduce( function (a, b) {
                  return intVal(a) + intVal(b);
              }, 0 );

          // Update footer
          console.log(pageTotal);
          if(api.page.info().page == api.page.info().pages-1){
            $( api.column( 6 ).footer() ).html(
                total.toFixed(2) +' €'//+' ['+ total +' € Tot.Doc.]'
            );
          } else {
            $( api.column( 6 ).footer() ).html(
                "<i class='fa fa-arrow-right'> Last Page</i> "
            );
          }
      },
      "responsive": true,
        "columnDefs": [
        { "responsivePriority": 1, "targets": 0 },
        { "responsivePriority": 2, "targets": 1 },
        { "responsivePriority": 3, "targets": -1 }
        ]
    });
    $('.dtTbls_stat3').DataTable({
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
            {"sType": "my-currency", "aTargets": [4]}
        ]
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
        ]
        // "aaSorting": [[0, "desc"]],
        // "bStateSave": false
    });
  });
</script>
<style>
    .dtTbls_light span.date {
        display: none;
    }

    .dtTbls_full span.date {
        display: none;
    }

    .dtTbls_full_Tot span.date {
        display: none;
    }

    .dtTbls_total span.date {
        display: none;
    }
    
</style>

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
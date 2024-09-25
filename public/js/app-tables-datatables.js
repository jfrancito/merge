var App = (function () {
  'use strict';
        //console.log("entro");
  App.dataTables = function( ){

    //We use this to apply style to certain elements
    $.extend( true, $.fn.dataTable.defaults, {
      dom:
        "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6'f>>" +
        "<'row be-datatable-body'<'col-sm-12'tr>>" +
        "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    } );

    $("#nso").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        columnDefs:[{
            targets: "_all",
            sortable: false
        }]
    });

    $("#nso_check").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[2000, 3000, -1], [2000, 3000, "All"]],
        columnDefs:[{
            targets: "_all",
            sortable: false
        }]
    });



    $("#nso_obs").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        columnDefs:[{
            targets: "_all",
            sortable: false
        }]
    });
    $("#despacholocen").dataTable({
        "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
        order : [[ 5, "desc" ]],
        "bPaginate": false
    });


    $("#table1").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 0, "asc" ]]
    });

    //Remove search & paging dropdown
    $("#table2").dataTable({
      pageLength: 6,
      dom:  "<'row be-datatable-body'<'col-sm-12'tr>>" +
            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });

    //Enable toolbar button functions
    $("#table3").dataTable({
      buttons: [
        'copy', 'excel', 'pdf', 'print'
      ],
      "lengthMenu": [[6, 10, 25, 50, -1], [6, 10, 25, 50, "All"]],
      dom:  "<'row be-datatable-header'<'col-sm-6'l><'col-sm-6 text-right'B>>" +
            "<'row be-datatable-body'<'col-sm-12'tr>>" +
            "<'row be-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>"
    });


  };

  return App;
})(App || {});

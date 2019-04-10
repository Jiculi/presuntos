$(document).ready(function() {
    $('#juicios').DataTable( {


        language: {
            processing:     "Procesando...",
            search:         "Busca&nbsp;:",
            lengthMenu:    "Muestra _MENU_ actores",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ actores",
            infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered:   "(filtrado de un total de _MAX_ registros)",
            infoPostFix:    "",
            loadingRecords: "Cargando información...",
            zeroRecords:    "No se encontraron resultados",
            emptyTable:     "Ningún dato disponible en esta tabla",
            paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
            },
            aria: {
                sortAscending:  ": activar para ordenar en forma ascendente",
                sortDescending: ": activar para ordena en forma descendente"
            }
        },

        ajax: {
             url: "jsonJuicios.php",
             dataSrc: ''
        },
   
        "columns": [
            { "data": "cp" },
            { "data": "procedimiento" },
            { "data": "entidad" },
            { "data": "actor" },
            { "data": "f_resolucion" },
            { "data": "monto" },
            { "data": "resultado" }
        ],

        dom: 'flt<"bottom"ipr><B><"clear">', //<#boton >frtip',  // <"top"B>irt<"bottom"flp><"clear">', //'Bfrtip',
        buttons: [
             'copy', 'excelHtml5', 'pdfHtml5'
        ]
    } );


        // Setup - add a text input to each footer cell
        $('#juicios tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );
     
        // DataTable
        var table = $('#juicios').DataTable();
     
        // Apply the search
        table.columns().every( function () {
            var that = this;
     
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        } );



} );

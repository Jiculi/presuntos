$(document).ready(function() {
    $('#juicios').DataTable( {

        language: {
            processing:     "Procesando...",
            search:         "Busca&nbsp;:",
            lengthMenu:    "Muestra _MENU_ Amparos Indirectos",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ Amparos Indirectos",
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
             url: "e/jsonAmparosIn.php",
             dataSrc: ''
        },
   
        "columns": [
            {
                className:      'Seguimiento',
                orderable:      false,
                data:           null,
                defaultContent: '<a href="" title="Generar Oficio" class="oficio"><i class="material-icons" style="color:#069;">description</i></a>'+ '....'+
                                '<a href="" title="Generar Volante" class="zzz"><i class="material-icons">add_to_home_screen</i></a>'
            },
            { "data": "id" },
            { "data": "procedimiento" },
            { "data": "actor" },
            { "data": "ai" },
            { "data": "sub" },
            { "data": "estado" },
            { "data": "f_interposicion" },
            { "data": "f_resolucion" },
            { "data": "f_notificacion" }
        ],

        "columnDefs": [
                { "searchable": false, "targets": 0 },
                { "orderable": false, "targets": 0 },
                {
                    "targets": [ 1 ],
                    "visible": false,
                    "searchable": false
                },
                {
                "targets": [5,6,7],
                "className": 'dt-body-right'
                }
            ],

            dom: '<"#boton"B><"top"fl>t<ipr><"clear">', //<#boton >frtip',  // <"top"B>irt<"bottom"flp><"clear">', //'Bfrtip',
            buttons: [
                'excelHtml5', 'pdfHtml5',  'copy'
            ]    

    } );

    $('#fondoOscuro3').fadeIn();
    $('#fondoOscuro3').height($(window).height());

    // Setup - add a text input to each footer cell
    $('#juicios tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="F '+title+'" />' );
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


    


function mostrarSeguimiento(pagina) {
    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());
    $("#altaOficio").css("top", "3%");
    $("#altaOficio").css("overflow", "auto");
    $("#altaOficio").height($(window).height());
    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}

function mostrarAltaOficio(pagina) {
    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());
    $("#altaOficio").css("width", "65%");

    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}

function mostrarAltaVolante(pagina) {
    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());
    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}



    
    
    $('#juicios').on('click', 'a.oficio', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);
        var pagina = 'e/amparosInOficio.php?id='+encodeURIComponent(row.data().id)+'&procedimiento='+encodeURIComponent(row.data().procedimiento)+'&ai='+encodeURIComponent(row.data().ai);
        console.log(pagina);
        mostrarAltaOficio(pagina);
    } );
    
    $('#juicios').on('click', 'a.zzz', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);
        var pagina = 'e/amparosInVolante.php?id='+encodeURIComponent(row.data().id)+'&procedimiento='+encodeURIComponent(row.data().procedimiento)+'&ai='+encodeURIComponent(row.data().ai);
        console.log(pagina);
        mostrarAltaVolante(pagina);
	} );

} );
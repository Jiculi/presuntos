$(document).ready(function() {
    $('#juicios').DataTable( {

        language: {
            processing:     "Procesando...",
            search:         "Busca&nbsp;:",
            lengthMenu:    "Muestra _MENU_ volantes",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ volantes",
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
             url: "e/jsonVolantes.php",
             dataSrc: ''
        },
   
        "columns": [
            {
                className:      'Seguimiento',
                orderable:      false,
                data:           null,
                defaultContent: '<a href="" title="Volante de Correpondencia" class="xxx"><i class="material-icons" style="color:rgb(221, 41, 110);">attachment</i></a>'

            },
            { "data": "accion" },
            { "data": "presunto" },
            { "data": "folio" },
            { "data": "fecha_actual" },
            { "data": "remitente" },
            { "data": "entidad_dependencia" },
            { "data": "turnado" },
            { "data": "tipoMovimiento" }

        ],
        "order": [[ 4, "desc" ]]
    } );

    // Setup - add a text input to each footer cell
    $('#juicios tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Filtro '+title+'" />' );
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



function mostrarSeguimiento(pagina)
{
    $("#cuadroOficios").fadeIn();
    $("#cuadroOficios").load(pagina);

}
 

    function handlerName(event) {
        alert(event.data.msg);
    }
    




//    $("#formajuicios").html('<b>Custom tool bar! Text/images etc.</b>');
 //   $("#Fallo").on("click", {msg: "You just clicked me!"}, handlerName);

    $('#juicios').on('click', 'a.xxx', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);
        let pagina = 'e/juiciosVolantePrint.php?folio=' + encodeURIComponent(row.data().folio);
        console.log(pagina);
        mostrarSeguimiento(pagina);
	} );
    
    $('#juicios').on('click', 'a.yyy', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);

        var pagina =  'e/juiciosVolantePrint.php?folio=' + encodeURIComponent(row.data().folio);
        console.log(pagina);
        mostrarSeguimiento(pagina);

	} );

} );
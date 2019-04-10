$(document).ready(function() {
    $('#juicios').DataTable( {
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
        ]
    } );
} );

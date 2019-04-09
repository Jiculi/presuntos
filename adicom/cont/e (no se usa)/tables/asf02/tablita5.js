$(document).ready(function() {
    $('#juicios').DataTable( {
         "ajax": "data.txt",
   
        "columns": [
            { "data": "procedimiento" },
            { "data": "actor" },
            { "data": "f_resolucion" }
        ]
    } );
} );

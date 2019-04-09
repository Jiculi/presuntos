$(document).ready(function() {
    $('#example').DataTable( {
         "ajax": "data.txt",
   
        "columns": [
            { "data": "procedimiento" },
            { "data": "actor" },
            { "data": "f_resolucion" }
        ]
    } );
} );

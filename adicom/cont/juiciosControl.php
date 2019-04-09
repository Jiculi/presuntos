<?php ?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Procedimientos</title>

    <link rel="stylesheet" href="css/juiciosControl.css">
    <link rel="stylesheet" href="js/datatables/dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"/>

    <script type="text/javascript" src="p/juiciosControl.js"></script>


<!--
   <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
   <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 

    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="p/juiciosControl.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>

    <script src='js/pdfmake.min.js'></script>
 	<script src='js/vfs_fonts.js'></script>
-->
    <script>
        function cerrarListaJuicios() {
		    $("#mesa").fadeOut();
		    $('#mantel').fadeOut('slow');
        }
    </script>  
</head>

<body>

    <div id="listajuicios">
        <div class="navbarJuicios">
            <a href="#" class="logo">Control Procedimientos</a>

		    <div class="navbarJuicios-right">
                <a href="javascript:cerrarListaJuicios()">Cerrar</a>
                
		    </div>
	    </div>
        <div id = "contenedor">
          <table id="juicios" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th rowspan="2">Procedimiento</th>
                    <th rowspan="2">Resultado</th>
                    <th colspan="4">Juicios Contenciosos</th>
                    <th colspan="4">Amparos Directos</th>
                    <th colspan="4">Recursos Fiscales</th>
                </tr>
                <tr>
                    <th>Juicios</th>
                    <th>Fav</th>
                    <th>Des</th>
                    <th>Tra</th>
                    <th>Amparos</th>
                    <th>Fav</th>
                    <th>Des</th>
                    <th>Tra</th>
                    <th>Recursos</th>
                    <th>Fav</th>
                    <th>Des</th>
                    <th>Tra</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Procedimiento</th>
                    <th>resultado</th>
                    <th>j</th>
                    <th>jcaF</th>
                    <th>jcaD</th>
                    <th>jcaT</th>
                    <th>a</th>
                    <th>aF</th>
                    <th>aD</th>
                    <th>aT</th>
                    <th>rrf</th>
                    <th>rrfF</th>
                    <th>rrfD</th>
                    <th>rrfT</th>
                </tr>
            </tfoot>
          </table>
        </div>
    </div>    
</body>
</html>

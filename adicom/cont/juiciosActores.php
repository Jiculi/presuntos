<?php ?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Juicios Contenciosos Administrativos</title>

    <link rel="stylesheet" href="css/juiciosLista.css">
    <link rel="stylesheet" href="js/datatables/dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"/>


   <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
   <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 

    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="e/tablita.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>

    <script src='js/pdfmake.min.js'></script>
 	<script src='js/vfs_fonts.js'></script>

    <script>
        function cerrarListaJuicios() {
		    $("#listajuicios").fadeOut();
		    $('#fondoOscuro3').fadeOut('slow');
        }
        function abre() {
            $("#altaOficio").fadeIn();
            $("#altaOficio").load("e/juiciosNuevo.php");
        }
    </script>  
</head>

<body>
    <div id='altaOficio' style="display: none;"></div>
    <div id="popup-overlay"></div>

    <div id="listajuicios">
        <div class="navbarJuicios">
            <a href="#" class="logo">Lista de Juicios</a>
            <a href="javascript:abre()"> <img src="images/registro_nuevo.png" /> Nuevo Juicio </a>
		    <div class="navbarJuicios-right">
                <a href="javascript:cerrarListaJuicios()">Cerrar</a>
		    </div>
        </div>
        
        <div id = "contenedor">
          <table id="juicios" class="display nowrap" style="width:100%">
            <thead>
                <tr>
				    <th></th>
					<th>id</th>
                    <th>Acción</th>
                    <th>Procedimiento</th>
                    <th>Juicio</th>
                    <th>Actor</th>
                    <th>Entidad</th>
                    <th>RRF</th>
                    <th>AD</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
					<th></th>
					<th>id</th>
                    <th>Acción</th>
                    <th>Procedimiento</th>
                    <th>Juicio</th>
                    <th>Actor</th>
                    <th>Entidad</th>
                    <th>RRF</th>
                    <th>AD</th>
                    <th>Sub</th>
                </tr>
            </tfoot>
          </table>
        </div>
    </div>    
</body>
</html>

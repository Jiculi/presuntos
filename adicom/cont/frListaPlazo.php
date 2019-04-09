<?php ?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Juicios Contenciosos Administrativos</title>

    <link rel="stylesheet" href="css/frListaPlazo.css">
    <link rel="stylesheet" href="js/datatables/dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"/>


   <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
   <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 

    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="e/frListaPlazo.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>

    <script src='js/pdfmake.min.js'></script>
 	<script src='js/vfs_fonts.js'></script>

    <script>
        function cerrarListaJuicios() {
		    $("#listajuicios").fadeOut();
		    $('#popup-overlay').fadeOut('slow');
        }
    </script>  
</head>

<body>
    <div id='altaOficio' style="display: none;"></div>
    <div id="popup-overlay"></div>

    <div id="listajuicios">
        <div class="navbarJuicios">
            <a href="#" class="logo">Control de Emisón de Resoluciones</a>
		    <div class="navbarJuicios-right">
                <a href="javascript:cerrarListaJuicios()">Cerrar</a>
		    </div>
        </div>
        
        <div id = "contenedor">
          <table id="juicios" class="display" style="width:100%">
            <thead>
                <tr>
				    <th rowspan="2"></th>
                    <th rowspan="2">Entidad</th>
                    <th rowspan="2">Acción</th>
                    <th rowspan="2">Procedimiento</th>
                    <th rowspan="2">Nivel</th>
                    <th rowspan="2">Cierre Instrucción</th>
                    <th colspan="2">Emisión Resolución</th>
                    <th rowspan="2">Dentro plazo</th>
                    <th colspan="2">Notificación Resolución</th>
                    <th rowspan="2">Dentro plazo</th>
                    <th rowspan="2">e</th>
                </tr>
                <tr>
                    <th>Límite</th>
                    <th>Resolución</th>
                    <th>Límite</th>
                    <th>Notificación</th>


                    <th >Estado</th>
                </tr>

            </thead>
            <tfoot>
                <tr>
				    <th></th>
                    <th>Entidad</th>
                    <th>Acción</th>
                    <th>Procedimiento</th>
                    <th>Nivel</th>
                    <th>Cierre I</th>
                    <th>90 días</th>
                    <th>Resolución</th>
                    <th>s1</th>
                    <th>10 días</th>
                    <th>Notificación</th>
                    <th>s2</th>
                    <th>e</th>
                    <th>Estado</th>
                </tr>
            </tfoot>
          </table>
        </div>
    </div>    
</body>
</html>

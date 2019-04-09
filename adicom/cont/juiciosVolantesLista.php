<?php 
?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/juiciosVolantesLista.css">
    <link rel="stylesheet" href="js/datatables/dataTables.min.css">
    <!--
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   -->

   <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
   <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 

    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="e/juiciosVolantesTabla.js"></script>
    <script>
        function cerrarListaVolantes() {
		    $("#listaVolantes").fadeOut();
		    $('#fondoOscuro3').fadeOut('slow');
        }
    </script>    
</head>

<body>
    <div id="fondoOscuro2"></div>
    <div id='cuadroOficios'style="display: none;"></div>

    <div id="listaVolantes" >

        <div class="navbarJuicios">
            <a href="#" class="logo">Lista de Volantes (Juicios Contenciosos Administrativos)</a>

		    <div class="navbarJuicios-right">
                <a href="javascript:cerrarListaVolantes()">Cerrar</a>
                
		    </div>
	    </div>



        <table id="juicios" class="display nowrap" style="width:100%">
            <thead>
                <tr>
				    <th>Seguimiento</th>
                    <th>Acción</th>
                    <th>Juicio</th>
                    <th>Volante</th>
                    <th>Fecha</th>
                    <th>Remitente</th>
                    <th>Dependencia</th>
                    <th>Turnado</th>
                    <th>Tipo</th>

                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Seguimiento</th>
                    <th>Acción</th>
                    <th>Juicio</th>
                    <th>Volante</th>
                    <th>Fecha</th>
                    <th>Remitente</th>
                    <th>Dependencia</th>
                    <th>Turnado</th>
                    <th>Tipo</th>

                </tr>
            </tfoot>
        </table>
    </div>

</body>
</html>
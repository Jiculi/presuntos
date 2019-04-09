<?php ?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/juiciosOficiosLista.css">
    <link rel="stylesheet" href="js/datatables/dataTables.min.css">

   <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
   <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="e/juiciosOficiosTabla.js"></script> 
    <script>
        function cerrarListaOficios() {
		    $("#listaOficios").fadeOut();
		    $('#fondoOscuro3').fadeOut('slow');
        }
    </script>  
  
</head>

<body>

    <div id="fondoOscuro2"></div>
    <div id='cuadroOficios'style="display: none;"></div>

    <div id="listaOficios" >
        <div class="navbarJuicios">
            <a href="#" class="logo">Lista de Oficios (Juicios Contenciosos Administrativos)</a>

		    <div class="navbarJuicios-right">
                <a href="javascript:cerrarListaOficios()">Cerrar</a>
                
		    </div>
	    </div>


   
        <div><h3>Lista de oficios</h3></div>

        <table id="juicios" class="display nowrap" style="width:100%">
            <thead>
                <tr>
				    <th></th>
					<th>id</th>
					<th>Oficio</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                    <th>Juicio</th>
                    <th>Destinatario</th>
                    <th>Dependencia</th>
                    <th>Tipo</th>
                    <th>Volante</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                <th></th>
                    <th>id</th>
					<th>Oficio</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                    <th>Juicio</th>
                    <th>Destinatario</th>
                    <th>Dependencia</th>
                    <th>Tipo</th>
                    <th>Volante</th>
                </tr>
            </tfoot>
        </table>
  </div> 

</body>
</html>
<?php ?> 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="e/css/style_juicios.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <script type="text/javascript" src="e/js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="e/jquery.dataTables.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <script type="text/javascript" src="e/tablita.js"></script>   

    	

</head>

<body>
    
<div id='formajuicios'>#revisa</div>
        <div id="edita"><h3>Juicios de Nulidad</h3></div>

        <table id="juicios" class="display" style="width:100%">
            <thead>
                <tr>
				    <th> </th>
					<th>id</th>
                    <th>CP</th>
                    <th>Procedimiento</th>
                    <th>Entidad</th>
                    <th>Actor</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Resultado</th>
                    <th>Seguimiento</th>					
                </tr>
            </thead>
            <tfoot>
                <tr>
					<th> </th>
					<th>id</th>
                    <th>CP</th>
                    <th>Procedimiento</th>
                    <th>Entidad</th>
                    <th>Actor</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Resultado</th>
                    <th>Seguimiento</th>						
                </tr>
            </tfoot>
        </table>

</body>
</html>


<?php
   header("Content-Type: text/html;charset=utf-8");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Juicios de nulidad</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"/>
<!--    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css"/>  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>  -->

    
    
    <script type="text/javascript" src="jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>






    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
    <script src='pdfmake.min.js'></script>
 	<script src='vfs_fonts.js'></script>


    <script type="text/javascript" src="tablita.js"></script>   


</head>

<body>
<div class="container">
    <h3>Juicios de Nulidad</h3>
    <table id="juicios" class="display" style="width:100%">
        <thead>
            <tr>
                <th>CP</th>
                <th>Procedimiento</th>
                <th>Entidad</th>
                <th>Actor</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>CP</th>
                <th>Procedimiento</th>
                <th>Entidad</th>
                <th>Actor</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Resultado</th>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
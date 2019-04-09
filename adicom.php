<?php 
    session_start();
?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Juicios Contenciosos Administrativos</title>

    <link rel="stylesheet" href="adicom/css/adicom.css">  -->

    <!--     <link rel="stylesheet" href="adicom/css/estilo.css" type="text/css" media="screen" title="default" />

  <link rel="stylesheet" href="../css/actores.css">  -->
    <link rel="stylesheet" href="../js/datatables/dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 


    <script>
        function informacion() {
            var pagina = 'adicom/cont/pfrr_informacion.php?numAccion=03-00622-2-143-03-005&usuario=fllamas&direccion=DG&nivel=A';
alert("antes");
            $("#cuadroRes").load(pagina);
            alert("despues");

        }
    </script>  
</head>

<body>
    <div id='altaOficio' style="display: none;"></div>
<!--    <div id="popup-overlay"></div>  -->
    <div id="ventana-overlay"></div>

    <div id="listajuicios">
        <div class="navbarJuicios">
            <a href="#" class="logo">Actores</a>
		    <div class="navbarJuicios-right">
                <a href="javascript:informacion()">Info</a>
                 <a href="/recupera/index.php">Cerrar</a> 
            </div>
        </div>
        
    </div>

    <div id="fondoOscuro"></div>
	<div id="cuadroDialogo" > cuadro de dialogo
		<div id="cuadroTitulo"> </div>
		<div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarCuadro()" > <img src="images/cerrar.png" /> </div>
		<div id="cuadroRes">hola</div>
		<div id="cuadroMen">que pasa</div>
	</div>
    
    <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 

    <script type="text/javascript" src="../js/jquery.dataTables.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>

    <script src='../js/pdfmake.min.js'></script>
 	<script src='../js/vfs_fonts.js'></script>

    <script src="src/adicom.js"></script>


</body>
</html>

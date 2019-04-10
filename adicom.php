<?php 
    session_start();
    include("./adicom/includes/funciones.php");
?> 
<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Juicios Contenciosos Administrativos</title>

      <link rel="stylesheet" href="./adicom.css">  
     <!--  <link rel="stylesheet" href="adicom/css/estilo.css" type="text/css" media="screen" title="default" />  -->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">



    <script type="text/javascript" src="adicom/js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="adicom/js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 



    <script>
        function informacion() {
            var pagina = 'adicom/pfrr_informacion.php?numAccion=03-00622-2-143-03-005&usuario=fllamas&direccion=DG&nivel=A';
            jQuery("#cuadroRes").load(pagina);

        }
    </script>  
</head>

<body>
<?php 
//	echo cuadroYfondo(); 
//	echo cuadroYfondo2();
//	echo cuadroYfondo3();
?>


<!-- ----------------------------------------- ----------------------------------------------->
<!-- ---------------------------- IMPORTANTE NO QUITAR --------------------------------------->
<!-- --------------------- VARIABLES QUE PASAN VALORES A JQUERY ------------------------------>
<!-- ----------------------------------------- ----------------------------------------------->
<input name="indexUser" type="hidden" value="<?php echo  $_SESSION['usuario'] ?>" id="indexUser" />
<input name="indexDir" type="hidden" value="<?php echo $_SESSION['direccion'] ?>"  id="indexDir" />
<input name="indexNivel" type="hidden" value="<?php echo $_SESSION['nivel'] ?>"  id="indexNivel" />
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
    <div id='altaOficio' style="display: none;"></div>
<!--    <div id="popup-overlay"></div>  -->
    <div id="ventana-overlay"></div>

    <div id="listajuicios">
        <div class="navbarJuicios">
            <a href="#" class="logo">Actores</a>
		    <div class="navbarJuicios-right">
                <a href="javascript:informacion()">Info</a>
            </div>
        </div>
        
    </div>

    <div id="Titulo">
    </div>
    <div id="pin"></div>
    <p>que pasa</p>
        <button id="juicios">vamos</button>
    </div>


    <script type="text/javascript" src="adicom/js/funciones.js"></script>
    <script type="text/javascript" src="adicom/js/ajax.js"></script>
    <script type="text/javascript" src="adicom/js/ajaxMisa.js"></script>
    <script type="text/javascript" src="adicom/js/menu.js"></script>

    <script type="text/javascript" src="adicom/js/ajaxConfiguracion.js"></script>


    <!--  checkbox styling script -->


    <script src="./adicom.js"></script>



</body>
</html>

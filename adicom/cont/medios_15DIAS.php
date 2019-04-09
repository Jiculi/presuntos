<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

//$nombre_1 = valorSeguro($_REQUEST['persona']);
$prueba2 = valorSeguro($_REQUEST['limite_not']);
$nombre1 = valorSeguro($_REQUEST['nombre1']);
$nombre2 = valorSeguro($_REQUEST['nombre2']);
$nombre3 = valorSeguro($_REQUEST['nombre3']);

$fecha = fechaNormal(valorSeguro($_REQUEST['persona']));

$pronuncie = fechaNormal(valorSeguro($_REQUEST['menos'])); 


?>
<script>
//----------------------------------------
function confirmado() 
{ 
        $$.ajax({ 
                type: "POST", 
                url: "procesosAjax/MEDIOS_pendientesUAA.php", 
                //beforeSend: function(){  }, 
                data: { 
                           rec: <?php echo $pronuncie ?>, 
                        }, 
                success: function(data) 
                        {       
                                compruebaNot(); 
                                cerrarCuadro(); 
                        } 
        }); 
}

</script>
<?php

 $nombres2 = str_replace('_',' ',$prueba2);
if($pronuncie >15)				 
echo "<br><br><center>
	<br><br>El Actor ".$nombres2."<br> le restan ".$pronuncie." Dias
	<br><br>Para interponer un recurso de reconsideración .
	</h2>	
	</center>";
	
else
echo "<br><br>
	<center>
	<h2>La fecha de notificación a este presunto fue el ".$fecha.". 
	<br><br>El limite de los 15 días para interponer un recurso de reconsideración ha concluido.
	<center> <br> <br> <br> <input type= 'button'  value='Enterado' class='submit_line' onclick='confirmado()'  </center>
	</h2>	
	</center>";

?>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$prueba = valorSeguro($_REQUEST['ejemplo']);
$prueba2 = fechaNormal(valorSeguro($_REQUEST['limite']));
$pronuncie = fechaNormal(valorSeguro($_REQUEST['pro'])); 
$restan = fechaNormal(valorSeguro($_REQUEST['restante']));
$recurrente= valorSeguro($_REQUEST['recurrente']);


?>
<script>
//----------------------------------------
function confirmado() 
{ 
        $$.ajax({ 
                type: "POST", 
                url: "procesosAjax/medios_pendiente.php", 
                //beforeSend: function(){  }, 
                data: { 
                           rec: <?php echo $recurrente ?>, 
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

if ($restan >5){
echo "<br><br><center>
	<h2>De acuerdo al oficio de prevencion $prueba <br> Con fecha de Acuse  ".$pronuncie.". 
	<br><br>La fecha limite para que el actor se pronuncie es:<br> ".$prueba2." .
	<br><br>Restan  ".$restan." dias.
	</h2>	
	</center>";
}	
else{
echo "<br><br>
	<center>
	<h2>La fecha de notificación a este presunto fue el ".$pronuncie.". 
	<br><br>El limite de los 5 días para presentar la información ha concluido.
	<center> <br> <br> <br> <input type= 'button'  value='Enterado' class='submit_line' onclick='confirmado()'  </center>
	</h2>	
	</center>";
}	
	?>	
	
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion = valorSeguro($_REQUEST['numAccion']);
$fecha = fechaNormal(valorSeguro($_REQUEST['fecha']));
$fechaUact = fechaNormal(valorSeguro($_REQUEST['fechaUact'])); 
$dias = fechaNormal(valorSeguro($_REQUEST['dias']));

?>
<script>
//----------------------------------------
function pendientesUAA()
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/po_pendientesUAA.php",
		//beforeSend: function(){  },
		data: {
				id:<?php echo $id ?>,
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
echo "<br><br><center>
	<h2>De acuerdo a la Última Actuación de la acción $accion <!-- es ".$fechaUact." --> <br> la fecha límite para emitir tu Resolución es el ".$fecha.". 
	<br><br>Tienes ".$dias." días para Emitir tu Resolución.
	<br><br>¿Cómo vas?
	</h2>
	
	
	</center>";
/*
echo "<center> <br> <input type='button' value='Marcar como atendido' class='submit_line' onclick='pendientesUAA()' />  </center>";
*/
?>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$id = valorSeguro($_REQUEST['id']);
$accion = valorSeguro($_REQUEST['numAccion']);
$asunto = valorSeguro($_REQUEST['asunto']);
$fecha = valorSeguro($_REQUEST['fecha']);
$solicitante=valorSeguro($_REQUEST['solicitante']);


?>
<script>
//----------------------------------------
function ayudaTicket()
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/po_pendiente_ayuda.php",
		//beforeSend: function(){  },
		data: {
				id:<?php echo $id ?>
			},
		success: function(data) 
			{ 	
				compruebaNot();
				cerrarCuadro();
			}
	});
}

</script>
<?php $u=dameUsuario($solicitante);
 $u['nombre'];
echo "<br><center><h3>Solicitud de Ayuda de ".$u['nombre']." <br><br> Asunto. $asunto <br><br>Accion. $accion <br> </h3></center>";
echo "<br><br><center><h3> ¿Se atendio la solicitud? </h3></center>";

echo "<center> <br> <input type='button' value='Marcar como atendido' class='submit_line' onclick='ayudaTicket()' />  </center>";
?>

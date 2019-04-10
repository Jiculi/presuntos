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
$comentarios=valorSeguro($_REQUEST['comentarios']);
$atendidopor=valorSeguro($_REQUEST['atendidoPor']);
$horafecha=valorSeguro ($_REQUEST['atencion']);
$fechaantencion=explode(" ",$horafecha);
$fechapartida=$fechaantencion[0];
$horapartida=$fechaantencion[1];
$fechanormal=fechaNormal($fechapartida);







$usu = dameUsuario($atendidopor);
$atendidopor = $usu['nombre'];

?>
<script>
//----------------------------------------
function Atendido()
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/po_atendido_ayuda.php",
		//beforeSend: function(){  },
		data: {
				id:<?php echo $id ?>
			},
		success: function(data) 
			{ 	compruebaNot();
				cerrarCuadro();
			}
	});
}
</script>
<?php 
$u=dameUsuario($solicitante);
$u['nombre'];

$asunto = str_replace("\\n","<br>",$asunto);
$asunto = str_replace("\\r","<br>",$asunto);
$asunto = html_entity_decode($asunto);

$comentarios = str_replace("\\n","<br>",$comentarios);
$comentarios = str_replace("\\r","<br>",$comentarios);
$comentarios = html_entity_decode($comentarios);

echo "<br><center><h3>Solicitud de Ayuda de ".$u['nombre']." atendida</h3></center>";
echo "<br><br> <b>Asunto.</b> $asunto <br><br><b>Accion.</b> $accion <br>";
echo "<br><br> <b>Comentarios.</b> <h3> $comentarios  ";
echo "<br><br> <b>Atendido por </b> $atendidopor";
echo "<br><br> <b>Fecha</b> $fechanormal";
echo "<br><br> <b>Hora</b> $horapartida";
echo "<center> <br> <input type='button' value='Marcar como Leido' class='submit_line' onclick='Atendido()' />  </center>";
?>

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
$hora = valorSeguro($_REQUEST['hora']);
$solicitante=valorSeguro($_REQUEST['solicitante']);
$usuario=valorSeguro($_REQUEST['usuario']);
$tipo=valorSeguro($_REQUEST['tipo']);

?>
<script>
//----------------------------------------
function ayudaTicket(usuario)
{
	var comentarios=document.getElementById('comentarios').value;
	
	$$.ajax({
		type: "POST",
		url: "procesosAjax/po_pendiente_ayuda.php",

		//beforeSend: function(){  },
		data: {
				comentarios:comentarios,
				id:<?php echo $id ?>,
				usuario:usuario
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
$u=dameUsuario($solicitante);
$u['nombre'];

$asunto = str_replace("\\n","<br>",$asunto);
$asunto = str_replace("\\r","<br>",$asunto);

if($tipo == "SA") echo "<div id='saDiv'>";
else if($tipo == "PO") echo "<div id='poDiv'>";
else echo "<div id='pfrrDiv'>";

echo "<h3><br><center>Solicitud de Ayuda de $tipo </h3></center>";
echo "<h3>Ticket No. $id &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tipo: $tipo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha: ".fechaNormal($fecha)."  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hora: ".$hora." </h3>";
echo "<h3>Usuario: ".$u['nombre']."</h3>";

echo "<b>Accion. $accion </b>";
echo "<br><br><b>Asunto.</b> ".html_entity_decode($asunto)." ";
echo "<br><br><center><h3> ¿Se atendio la solicitud? </h3></center>";
echo "<br><b>Comentarios: </b> <center> <textarea style='width:90%; margin:0 auto; height:50px' id='comentarios' name='comentarios'></textarea> </center>";
echo "<center> <br> <input type='button' value='Marcar como atendido' class='submit_line' onclick=\"ayudaTicket('".$usuario."')\" />  </center>";
?>
</div>
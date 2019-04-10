<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$id = valorSeguro($_REQUEST['id']);
$accion = valorSeguro($_REQUEST['numAccion']);
$oficio = valorSeguro($_REQUEST['oficio']);
$fecha = valorSeguro($_REQUEST['fecha']);

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
echo "<br><br><center><h3>El oficio $oficio de devolución a la UAA de la accion $accion <br> se vencio la fecha ".fechaNormal($fecha).". </h3></center>";
echo "<br><br><center><h3> ¿Se atendio el oficio? </h3></center>";

echo "<center> <br> <input type='button' value='Marcar como atendido' class='submit_line' onclick='pendientesUAA()' />  </center>";
?>

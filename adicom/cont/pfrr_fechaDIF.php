<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

include("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$idAud = valorSeguro( $_REQUEST['idAud'] );
$idPresunto = valorSeguro( $_REQUEST['idPresunto'] );
$presunto = $_REQUEST['presunto'];
$rfc=valorSeguro($_REQUEST['rfc']);
$accion=valorSeguro($_REQUEST['numAccion']);
$oficio=valorSeguro($_REQUEST['oficio']);
$usuario=valorSeguro($_REQUEST['usuario']);
?>
<script>
$$(function() {

	$$( "#fechaDif" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: 0,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
})

function fechaDiferimiento()
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/pfrr_fechaDIF.php",
		//beforeSend: function(){  },
		data: 
		{
			idPresunto:'<?php echo $idPresunto ?>',
			presunto:'<?php echo $presunto ?>',
			rfc:'<?php echo $rfc ?>',
			fecha: $$("#fechaDif").val(),
			accion:'<?php echo $accion ?>',
			oficio: $$("#oficioDif").val(),
			usuario: '<?php echo $usuario ?>'
		},
		success: function(data) 
		{ 	
			compruebaNot();
			cerrarCuadro();
			//new mostrarCuadro(300,600,'Fecha de Direfimiento',100,'cont/pfrr_fechaDIF.php','idPresunto=<?php echo $idPresunto; ?>&presunto=<?php echo urlencode($presunto); ?>&rfc=<?php echo $rfc; ?>&numAccion=<?php echo $accion; ?>&oficio=<?php echo $oficio; ?>&usuario=<?php echo $us; ?>');
			//return
		}
	});
}
</script>
<?php
$table = "<center> <br><br>";
$table .= "<table class='feDif' width='80%' align='center' cellspacing=2 style=''>";
//$table .= "<tr> <td class='etiquetaPo'>ID Presunto:</td><td>".$idPresunto."</td> </tr>";
$table .= "<tr> <td class='etiquetaPo'>Presunto:</td><td>".$presunto."</td> </tr>";
$table .= "<tr> <td class='etiquetaPo'>RFC:</td><td>".$rfc."</td> </tr>";
$table .= "<tr> <td class='etiquetaPo'>Oficio Citatorio:</td><td> <input name='oficioDif'  type='text'  class='redonda5'  id='oficioDif' value=''> </td> </tr>";
$table .= "<tr> <td class='etiquetaPo'>Fecha Direfimiento:</td><td> <input name='fechaDif'  type='text'  class='redonda5'  id='fechaDif' value='' readonly='readonly'> </td> </tr>";
$table .= "<tr> <td colspan='2'> <br><br> <center> <input type='button' value='Crear Fecha Direfimiento' class='submit_line' onclick='fechaDiferimiento()' /> </center> </td> </tr>";
$table .= "</table>";
$table .= "</center>";

echo $table;
?>

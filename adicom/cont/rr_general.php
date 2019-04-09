<?php
date_default_timezone_set("America/Mexico_City");
error_reporting(E_ERROR);

require_once("../includes/iclases.php");
require_once("../includes/funciones.php");
error_reporting(E_ERROR);
$iconexion = new iconexion;
$icon = $iconexion->iconectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$valor = $_POST['valor'];
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];


//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//---------------------------------------------------------------
$tabla = "<table>";
$tabla .= utf8_decode("
	<tr>
		<tr><td class='celTit' colspan='10' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
		<tr><td class='celTit' colspan='10' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
		<tr><td class='celTit' colspan='10' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES A LOS RECURSOS FEDERALES EN ESTADOS Y MUNICIPIOS</b></td></tr>
		<tr><td class='celTit' colspan='10' align='center'><b>REPORTE DE JUICIOS</b></td></tr>
		<tr><td class='celTit' colspan='10' align='center'><b>AL ".date('d')." DE ".strtoupper(dameMes(date("n")))." DE ".date('Y')." - ".date('h:i:s')."</b></td></tr>
		
		<tr><td class='celTit' colspan='10' align='center'> </td></tr>
	</tr>");

$tabla .= "<tr>";
$tabla .=	"<th> </th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Juicio Interno")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("ACCIÓN")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("PROCEDIMIENTO")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("FONDO")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("DA")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("IMPORTE QUE CUBRE EL DAÑO")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("INTERESES")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("MONTO REINTEGRADO")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("FECHA REINTEGRO")."</th>";
$tabla .= "</trs>";
//------------------------------------------------------------------------------
//------------------------------- SACAMOS DATOS DE BD --------------------------
//------------------------------------------------------------------------------
$sql = $iconexion->iselect("select * from juicios where sub= $nivel", false);

$total = mysqli_num_rows($sql);
$i=0;

//------------------------------------------------------------------------------
while($r = mysqli_fetch_array($sql))

{
	$tabla .= "<tr>";
	$tabla .= "<td>".++$i."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".($r['nojuicio'])."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".$r['num_accion']."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".($r['superveniente'])."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".($r['fondo'])."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".$nivSbd."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".number_format($resarcido,2)."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".number_format($intereses,2)."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".number_format($suma,2)."</td>";
	$tabla .= "<td style='background:#FFFF00;'border: 1px dotted silver'>".($fecha_deposito)."</td>";
	$tabla .= "</tr>";

		
	

}




$tabla .= "</table>";


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-------------------------------- TOTALES -------------------------------------
//$iconexion->iresult($sql);
//$iconexion->idesconectar();



header("Content-type: application/vnd.ms-excel;charset=utf-8");
header("Content-disposition: attachment; filename=listado_po.xls");
//$excel=$_REQUEST['export'];
echo ($tabla);
exit;


?>



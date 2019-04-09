<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$folio = valorSeguro(trim($_REQUEST['folio']));
//$id = 4569;
$direccion = valorSeguro(trim($_REQUEST['direccion']));
$filas = "";

$sql = $conexion->select("SELECT
							  v.folio as folioV,
							  v.hora_registro as horaRegV,
							  v.hora_recepcion as horaRecV,
							  v.fecha_oficio as fechaOfiV, 
							  v.fecha_acuse as fechaAcuV,
							  v.fecha_actual as fechaActV,
							  v.cral as cralV,
							  v.fechaCral as fechaCralV,
							  v.acuseCral acuseCralV,
							  v.entidad_dependencia as eDepV,
							  v.remitente as remiV,
							  v.cargo as cargoV,
							  v.oficio as oficioV,
							  v.destinatario as destinatarioV,
							  v.asunto as asuntoV,
							  v.turnado as turnadoV,
							  v.status as statusV,
							  v.semaforo as semaforoV,
							  v.generado_por as generadoV,
							  v.tipoMovimiento as movV,
							  v.direccion as direccionV,
							  v.accion as accionV,
							  vc.folio as folioVC,
							  vc.fecha_oficio as fechaOfiVC, 
							  vc.fecha_acuse as fechaAcuVC,
							  vc.fecha_actual as fechaActVC,
							  vc.cral as cralVC,
							  vc.fechaCral as fechaCralVC,
							  vc.acuseCral acuseCralVC,
							  vc.entidad_dependencia as eDepVC,
							  vc.remitente as remiVC,
							  vc.cargo as cargoVC,
							  vc.oficio as oficioVC,
							  vc.asunto as asuntoVC,
							  vc.turnado as turnadoVC,
							  vc.tipoMovimiento as movVC,
							  vc.direccion as direccionVC,
							  vc.accion as accionVC
						 FROM volantes v 
						 LEFT JOIN volantes_contenido vc ON v.folio = vc.folio
						 WHERE v.folio = '$folio' ",false);
while($r = mysql_fetch_array($sql))
{

	$horaReg = $r["horaRegV"];
	$horaRec = $r["horaRecV"];
	
	$fechaOf 		= ($r["fechaOfiV"] != "") ? $r["fechaOfiV"] : $r["fechaOfiVC"] ;
	$fechaAc 		= ($r["fechaAcuV"] != "") ? $r["fechaAcuV"] : $r["fechaAcuVC"] ;
	$fechaAct 		= ($r["fechaActV"] != "") ? $r["fechaActV"] : $r["fechaActVC"] ;
	$cral 			= ($r["cralV"] != "") ? $r["cralV"] : $r["cralVC"] ;
	$fechaCral 		= ($r["fechaCralV"] != "") ? $r["fechaCralV"] : $r["fechaCralVC"] ;
	$acuseCral 		= ($r["acuseCralV"] != "") ? $r["acuseCralV"] : $r["acuseCralVC"] ;
	$eDep 			= ($r["eDepV"] != "") ? $r["eDepV"] : $r["eDepVC"] ;
	$remi 			= ($r["remiV"] != "") ? $r["remiV"] : $r["remiVC"] ;
	$cargo 			= ($r["cargoV"] != "") ? $r["cargoV"] : $r["cargoVC"] ;
	$eDep 			= ($r["eDepV"] != "") ? $r["eDepV"] : $r["eDepVC"] ;
	$oficio 		= ($r["oficioV"] != "") ? $r["oficioV"] : $r["oficioVC"] ;
	$asunto 		= ($r["asuntoV"] != "") ? $r["asuntoV"] : $r["asuntoVC"] ;
	$turnado 		= ($r["turnadoV"] != "") ? $r["turnadoV"] : $r["turnadoVC"] ;
	$asunto 		= ($r["asuntoV"] != "") ? $r["asuntoV"] : $r["asuntoVC"] ;
	$status 		= $r["statusV"];
	$semaforo 		= $r["semaforoV"];
	$mov 			= ($r["movV"] != "") ? $r["movV"] : $r["movVC"] ;
	$direccion 		= ($r["direccionV"] != "") ? $r["direccionV"] : $r["direccionVC"] ;
	$accion 		= ($r["accionVC"] != "") ? $r["accionVC"] : $r["accionV"] ;
	
	if($status == 0)
	{
		$status = "<div style='position:absolute; top:130px; left:130px; font-weight:bold; font-size:80px; color:silver '> CANCELADO </div>";	
	}
	if($mov == 2) $$mov = "Recepción";
	elseif($mov == 'otro') $mov = "Otro";
	else 
	{
		if(is_numeric($mov)) $mov = dameEstado($mov);
		else $mov = $r['tipoMovimiento'];
	}
	#C0C0C0
	$filas .= '
			<TR> 
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" width="">'.$remi.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$cargo.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$eDep.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$oficio.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.fechaNormal($fechaOf).'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$accion.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$mov.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: justify; padding:3px; margin:3px;" class="celdaTD2" width="">'.$asunto.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD2" width=""> <a href="#" onclick="new mostrarCuadro2(500,450,\'Responder Oficio\',50,\'cont/po_otros_oficios_responder.php\',\'accion='.$accion.'&oficio='.$oficio.'&destinatario='.urlencode($remi).'&cargo='.urlencode($cargo).'&dependencia='.urlencode($eDep).'&direccion='.$_REQUEST['direccion'].'&usuario='.$_REQUEST['usuario'].'&nivel='.$_REQUEST['nivel'].'\')"> Responder </a> </td>
			</TR> 	';
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script type="text/javascript">

</script>
<style>
#contenidoImprimir{ position:relative; padding:10px;}
.tablaVol{ }
.celdaTD{ font-size:11px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px; }
.celdaTD2{ font-size:11px; border:1px solid #CCC; text-align: justify; padding:3px; margin:3px; }
</style>
</head>

<body>
<div id="contenidoImprimir">
<?php 

$tablaVol = '
    
    <TABLE  width="100%" style="font-size:12px; border:1px solid #333;font-family:Arial, Helvetica, sans-serif;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;" cellpadding="2" cellspacing="2"> 
        <TR> 
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="15%">Remitente</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="15%">Cargo</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="10%">Dependencia</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="5%">Oficio</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="5%">Fecha</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="10%">Accion</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="10%">Referencia</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="20%">Asunto</td>
           <td style="font-weight:bold;border:1px solid #999; text-align: center; padding:3px; margin:3px; " width="20%"></td>
        </TR> 
		'.$filas.'
    </TABLE>'; 

//if($_REQUEST['muestra'] == 1) echo $tablaVol;
//else 
echo $tablaVol ;

?>

</div>
</body>
</html>

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
							  vc.accion as accionVC,
							  vc.presunto as presuntoVC
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
	$presunto 		= $r["presuntoVC"];
	
	if($status == 0)
	{
		$status = "<div style='position:absolute; top:130px; left:130px; font-weight:bold; font-size:80px; color:silver '> CANCELADO </div>";	
	}
	if($mov == 2) $$mov = "Recepción";
	elseif($mov == 'otro') $mov = "Otro";
	else 
	{
		if(is_numeric($mov)) $mov = dameEstado($mov);
		else $mov = $mov;
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
			</TR> 	';
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<script type="text/javascript">
	var ok = "";
/*
$$( document ).ready(function() {
	if( $$("#indexDir").val() == "DG" )   ok = "ok";
	if( $$("#indexUser").val() == "esolares" )   ok = "ok";
	
	if(ok != "ok") $$("#impresion").html("");
	
});
*/
function imprSelec(muestra)
{
		var ficha=document.getElementById(muestra);
		var ventimp=window.open('Impresion de Volantes','popimpr');
			
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
}
</script>
<style>
#contenidoImprimir{ position:relative; padding:10px;}
.tablaVol{ }
.celdaTD{ font-size:11px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px; }
.celdaTD2{ font-size:11px; border:1px solid #CCC; text-align: justify; padding:3px; margin:3px; }
</style>
</head>

<body>

<div id="impresion" style="position:fixed; right:270px; z-index:1000">
	<a href="javascript:imprSelec('contenidoImprimir')" class="submit-login" style="-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
    <img src="images/printer.png" style="float:left; "/> 
    <div style="float:left; line-height:15px"> &nbsp;&nbsp;&nbsp; Imprimir</div> <div style="clear:both"></div> </a>
</div>

<div id="contenidoImprimir">
<?php 

$tablaVol = '
    <table width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;border:1px solid #333;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
        <tr>
          <td align="center" style="padding:3px"><img src="../../../Sitio sin nombre 2/legal3.png" width="53" height="49" /></td>
          <td style="">
		  	<div align="center"><strong>VOLANTE DE CONTROL DE CORRESPONDENCIA</strong></div>
			<div align="center">DIRECCION GENERAL DE RESPONSABILIDADES A LOS RECURSOS FEDERALES EN ESTADOS Y MUNICIPIOS</div>
		  </td>
          <td align="center"> 
		  	<div style="font-size:15px; border:1px solid #999; padding:3px; margin:5px; width:70px;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;"><strong>'.$folio.'</strong></div> 
		    <div style="font-size:10px; border:1px solid #999; padding:3px; margin:5px; width:70px;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;"><strong>'.fechaNormal($fechaAct).'<br>'.fechaNormal($horaReg).'</strong></div>
		  </td>
        </tr>
    </table>
    
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
        </TR> 
		'.$filas.'
		<TR>
			<td colspan="10" style="font-size:12px; border:1px solid #999; text-align: left; padding:3px; margin:3px; "> 
				<b>Turnado a: '.$turnado.' </b> 
			<td>
		</TR>
		<TR>
          <TD colspan="10" style="font-size:12px; border:1px solid #999; text-align: left; padding:3px; margin:3px; "> 
                <table width="100%" style="font-size:12px; ">
                    <tr>
                        <td style=" padding:1px">[&nbsp;&nbsp;] Para conocimiento</td><td style=" padding:1px"> [&nbsp;&nbsp;] Dar tramite</td> 
						<td rowspan="3" width="50%" style="border-left:1px solid #999; padding:3px"> 
							Observaciones:<br><br><br>
							Lic. Oscar René Martínez Hernández<br>
							DGR
							
						</td>
					</tr>
                    <tr>
                        <td style=" padding:1px">[&nbsp;&nbsp;] Emitir Opinion</td><td style=" padding:1px">[&nbsp;&nbsp;] Atender Solicitud</td>
                    </tr>
					<tr>
                        <td style=" padding:1px">[&nbsp;&nbsp;] Tratar Acuerdo</td><td style=" padding:1px">[&nbsp;&nbsp;] Asistir</td>
                    </tr>
                </table>
			</TD>
        </TR> 
    </TABLE>'; 

//if($_REQUEST['muestra'] == 1) echo $tablaVol;
//else 
echo $tablaVol."<br><br><br>".$tablaVol;

?>

</div>
</body>
</html>

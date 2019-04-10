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
						 WHERE v.folio = '$folio' limit 1 ",false);
						 
						 
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
	/*if($mov == 2) $$movi = "Opinión del PPO";
	elseif($mov == 'otro') $mov = "Otro";
	else 
	{*/
	
	
	$sqlO= $conexion->SELECT("SELECT * FROM fondos INNER JOIN opiniones on fondos.num_accion=opiniones.num_accion where opiniones.num_accion='$accion' or opiniones.num_accion_po='$accion'" , false);
	
	while($rO = mysql_fetch_array($sqlO))
{
	$fondo = $rO["fondo"];
	$entidad = $rO["entidad_fiscalizada"];
}
	
	$sql2= $conexion->SELECT("SELECT * FROM fondos INNER JOIN po on fondos.num_accion=po.num_accion where po.num_accion='$accion'", false);
	
	while($r2 = mysql_fetch_array($sql2))
{
	$fondo = $r2["fondo"];
	$entidad = $r2["entidad_fiscalizada"];
}
	
	
		if(is_numeric($mov)) $mov = dameEstado($mov);
		
		else $mov = $mov;
	
	#C0C0C0
	$filas .= '
			<TR> 
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" width="">'.$remi.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$cargo.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$eDep.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$oficio.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.fechaNormal($fechaOf).'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$accion.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$accion.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$accion.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: center; padding:3px; margin:3px;" class="celdaTD" width="">'.$movi.'</td>
			   <td style="font-size:10px; border:1px solid #CCC; text-align: justify; padding:3px; margin:3px;" class="celdaTD2" width="">'.$asunto.'</td>
			</TR> 	';
	
}
?>

<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/juiciosVolantePrint.css">



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

function cerrarCuadrito() {
	$("#formajuicios").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}
</script>


</head>



<body>

<div class="navbar">
	<a href="#" class="logo">Volante de Correspondencia</a>
	<div class="navbar-right">
		  <a class="active" href="javascript:imprSelec('contenidoImprimir')">Imprimir</a>
		  <a href="javascript:cerrarCuadrito()">Cerrar</a>
	</div>
</div>

<!--
<div id="impresion" >
	<a href="javascript:imprSelec('contenidoImprimir')" class="submit-login" style="-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
    <img src="images/printer.png" style="float:left; "/> 
    <div style="float:left; line-height:15px"> &nbsp;&nbsp;&nbsp; Imprimir</div> <div style="clear:both"></div> </a>
    <div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarCuadrito()" > <img src="images/cerrar.png" /> </div>  

</div>
-->

<div id="contenidoImprimir">

<?php 
$tablaVol = '
    <table width="100%" style="font-size:12px; font-family:Arial, Helvetica, sans-serif;border:1px solid #333;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
        <tr>
          <td align="center" style="padding:3px"><img src="images/logoasfok.jpg" width="100" /></td>
          <td style="">
          <br>
		  	<div align="center"><strong>VOLANTE DE CONTROL INTERNO DE CORRESPONDENCIA</strong></div>
			<div align="center">DIRECCION GENERAL DE RESPONSABILIDADES</div><br>
		  </td>
          <td align="center"> <div style="border:1px solid #999; padding:3px; margin:5px; width:70px;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;"><strong>'.$folio.'</strong></div> </td>
        </tr>
    </table>
    
    <table  width="100%" style="font-size:12px; border:1px solid #333;font-family:Arial, Helvetica, sans-serif;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;" cellpadding="2" cellspacing="2"> 
        <TR> 
           <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; " width="18%">Remitente</td>
           <td style="padding:3px">
		   		'.ucwords($remi).' &nbsp; 
		   		<div style="float:right; margin:0 0 0 0">
					<div style="float:left;padding: 3px">
					<strong>Fecha Volante</strong>
					</div>
					<div style="float:left;width:70px; padding: 3px 10px; border:1px solid #999;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
					<strong>'.fechaNormal($fechaAct).'</strong>
					</div>
				</div> 
			</td> 
        </TR> 
        <TR> 
           <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Oficio</TD> 
           <td style="padding:3px">'.stripslashes($oficio).'
             <div style="float:right; margin:0 0 0 0">
						<div style="float:left;padding: 3px">
						<strong>Hora Volante</strong>
			   </div>
						<div style="float:left;width:70px; padding: 3px 10px; border:1px solid #999;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
						<strong>'.$horaReg.'</strong>
					</div>
			 </div> 		   
	      </td> 
      </TR> 
        <TR> 
           <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Turnado</TD> 
           <td style="padding:3px">'.$turnado.' &nbsp;</td> 
      </TR>
        <TR>
          <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Acción</TD>
          <td> 
			<table style="font-size:12px;" >
				<TR>
				  <td style="padding:1px">'.$accion.' &nbsp;</td>
				  		   		<div style="float:right; margin:0 0 0 0">
					<div style="float:left;padding: 3px">
					<strong>Fecha</strong>
					</div>
					<div style="float:left;width:70px; padding: 3px 10px; border:1px solid #999;-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
					<strong>'.fechaNormal($fechaOf).'</strong>
					</div>
			  </TR>
				<TR>
			</table>
		  
		  </td> 
      </TR>
        <TR>
          <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Entidad Fiscalizada</TD>
          <td style="padding:3px">'.$entidad.' &nbsp;</td> 
      </TR>
      <TR>
          <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Fondo</TD>
        <td style="padding:3px">'.$fondo.' &nbsp;</td> 
          </TR>
        <TR>
          <td style="font-weight:bold;border:1px solid #999; text-align: right; padding:3px; margin:3px; ">Tipo de Recepción</TD>
          <td style="padding:3px"> '.$mov.' &nbsp;</td> 
          </TR>
       
        <TR>
      

          <TD  style="font-weight:bold;border:1px solid #999;   text-align: right;  padding:3px; margin:3px; "><p><br>
          </p>
            <p>Asunto<br>
              <br>
            </p>
            <p><br>
              <br>
          </p></TD>
          <td style="padding:3px; border:1px solid #999;  ">'.$asunto.'&nbsp;<p><br></p></td> 
      </TR>
        <TR>
          <TD colspan="2" style="font-size:12px; border:1px solid #999; text-align: left; padding:3px; margin:3px; "> 
                <table width="100%" style="font-size:12px; ">
                    <tr>
                        <td style=" padding:1px">[&nbsp;&nbsp;] Para conocimiento</td><td style=" padding:1px"> [&nbsp;&nbsp;] Dar tramite</td> 
						<td rowspan="3" width="50%" style="border-left:1px solid #999; padding:3px"> 
							Observaciones:<br><br><br>
							Lic. Rosa María Gutiérrez Rodríguez<br>
							
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
echo $tablaVol."<br><br><br>"/*.$tablaVol*/;

?>

</div>
</body>
</html>

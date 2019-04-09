<?php 
//header('Content-Type: text/html; charset=UTF-8'); 
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();


$ef = valorSeguro($_REQUEST['ef']);
$tipo = valorSeguro($_REQUEST['tipo']);

//-----------------------------------------------------------------------------------------------------------------------------------
$thEstilo = "bgcolor = '#58ACFA' ";
$encabezados = "
	<table width='100%' style='' class='tabla'>
			<tr><td class='celTit' colspan='11' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES </b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'><b>RESUMEN DE</b></td></tr>
			<!-----tr><td class='celTit' colspan='11' align='center'><b>AL ".date('d')." DE ".date('m')." DE ".date('Y')."</b></td></tr----->
			<tr><td class='celTit' colspan='11' align='center'> </td></tr>
	</table>
	<table width='100%' class='tabla' border='1' bordercolor='#999999'>
			<tr>
				<th $thEstilo> N	</th>
				<th $thEstilo> <font color='white'> Acción </font>	</th>
				<th $thEstilo> <font color='white'> Entidad Fiscalizada	 </font>	</th>
				<th $thEstilo> <font color='white'> CP </font>	</th>
				<th $thEstilo> <font color='white'> Presunto Responsable  </font>	</th>		
				<th $thEstilo> <font color='white'> Cargo </font>		</th>
				<th $thEstilo> <font color='white'> Fondo </font>		</th>
				<th $thEstilo> <font color='white'> UAA </font>		</th>
				<th $thEstilo> <font color='white'> PO </font>		</th>
				<th $thEstilo> <font color='white'> Irregularidad </font>		</th>
				<th $thEstilo> <font color='white'> Control Interno </font>		</th>
				<th $thEstilo> <font color='white'> Monto </font>	</th>	
				<th $thEstilo> <font color='white'> DIR. </font>	</th>
			</tr>";



//------------ contamos cantidad que se repite una accion ---------------
if($tipo==1){
$cont = "SELECT pfrr.num_accion, count( pfrr.num_accion ) AS veces FROM pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
fondos on fondos.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where tipo <>'titularICC' and tipo <> 'titularTESOFE' and tipo <> 'responsableInforme'
and pfrr_presuntos_audiencias.status=1
and detalle_edo_tramite <> 14
and entidad like '%Gobierno del Estado de $ef%' GROUP BY pfrr.num_accion";
}

if($tipo==3){
$cont = "SELECT pfrr.num_accion, count( pfrr.num_accion ) AS veces FROM pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
fondos fondos po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where tipo <>'titularICC' and tipo <> 'titularTESOFE' and tipo <> 'responsableInforme'
and pfrr_presuntos_audiencias.status=1
and detalle_edo_tramite <> 14
and (entidad like '%$ef%' or pdrcs like '%$ef%') GROUP BY pfrr.num_accion";
}
$contx = $conexion->select($cont);
while($na = mysql_fetch_assoc($contx)) {
	$cadAcciones[$na['num_accion']] = $na['veces'];
}
//print_r($cadAcciones);

//---------------------------------------- TABLA TEMPORAL ---------------------------------------------------
//-----------------------------------------------------------------------------------------------------------

if($tipo==1){
	$sqlt= "select pfrr.num_accion, entidad, pfrr.cp, pfrr.pdrcs, pfrr.po, pfrr.direccion, nombre, detalle_edo_tramite, cargo, fondos.fondo, fondos.uaa, detalle_estado, id_sicsa, inicio_frr, monto_no_solventado
from pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
fondos on fondos.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where tipo <>'titularICC' and tipo <> 'titularTESOFE' and tipo <> 'responsableInforme'
and pfrr_presuntos_audiencias.status=1
and detalle_edo_tramite <> 14
and entidad like '%Gobierno del Estado de $ef%' order by pfrr.num_accion";
	}
	
		if($tipo==3){
	$sqlt= "select pfrr.num_accion, entidad, pfrr.cp, pfrr.pdrcs, pfrr.po, pfrr.direccion, nombre, detalle_edo_tramite, cargo, fondos.fondo, fondos.uaa, detalle_estado, id_sicsa, inicio_frr, monto_no_solventado
from pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
fondos on fondos.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where tipo <>'titularICC' and tipo <> 'titularTESOFE' and tipo <> 'responsableInforme'
and pfrr_presuntos_audiencias.status=1
and detalle_edo_tramite <> 14
and (entidad like '%$ef%' or pdrcs like '%$ef%') order by pfrr.num_accion";
	}

$exet = mysql_query($sqlt) or die(mysql_error()."<br><br>".nl2br($sqlt));
$rr = 0;
while($rt = mysql_fetch_array($exet))
{
	
	$rr = 0;
	$numAcc = $cadAcciones[$rt['num_accion']];
	//-----------------------------------------------------------------------
	
	
	//-----------------------------------------------------------------------
	//---------------------------------------------------------------------
	
	$tablat .= "<TR>";
	//************************************
	//**************************************************************		
	if($NA != $rt['num_accion'] ) $cuenta++;
	//**************************************
	if( $NA != $rt['num_accion'] && $numAcc >= 1 ) 
	{
	$ff++;
	$tablat .= "
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$cuenta."</td>
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['num_accion']."</td>
		<td  $estilo rowspan = '$numAcc' align='left' valign='middle' >".$rt['entidad']."</td>
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['cp']."</td>
 		
		";
		
		
	}
	
	$tablat .= "	
			<td $estilo align='right' valign='middle'>".$rt['nombre']." $edo</td>	
			<td $estilo align='left' valign='middle'>".$rt['cargo']."</td>
			";
	
	
		if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		$tablat .= "	
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['fondo']."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['uaa']."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['po']."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['pdrcs']."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['detalle_estado']."</td>";
	
	if ($rt['inicio_frr'] == "" or $rt['inicio_frr'] == 0)
		{
			$montopfr = $rt['monto_no_solventado'];
		} else {
			$montopfr = $rt['inicio_frr'];
		}
	
		$tablat .= "	
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$montopfr."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['direccion']."</td>";

			
	}

		
			
	
	
		
	
	$NA = $rt['num_accion'];
	//$conexion->update("UPDATE pfrr SET fecha_notificacion_resolucion = '".$fechaNot."' WHERE num_accion = '".$rt['num_accion']."' ",false);

}
//*********************************************************************************************

header("Content-type: application/pdf");
header("Content-disposition: attachment; filename=listado_po.xls");
//$excel=$_REQUEST['export'];
print utf8_decode($tablat);
exit;



//print_r($_REQUEST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
//mysql_free_result($sqlT);
//$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

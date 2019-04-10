<?php 
//header('Content-Type: text/html; charset=UTF-8'); 
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();

?>


<style>
body{ font-family:Arial, Helvetica, sans-serif; font-size:10px}

.tabla{border:1px dotted silver}
.tabla th{border:1px dotted silver;}
.tabla td{border:1px dotted silver}

.celTit{ border:1 !important}

</style>
<?php

$ef = valorSeguro($_REQUEST['ef']);
$tipo = valorSeguro($_REQUEST['tipo']);

//-----------------------------------------------------------------------------------------------------------------------------------
$thEstilo = "bgcolor = '#54963b' ";
$encabezados = "
	<table width='100%' style='' class='tabla'>
			<tr><td class='celTit' colspan='11' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'><b>PROCEDIMIENTOS POR INICIAR</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'><b>".date('d')." DE ".date('m')." DE ".date('Y')."</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'> </td></tr>
	</table>
	<table width='100%' class='tabla' border='1' bordercolor='#999999'>
			<tr>
				<th $thEstilo> No°	</th>
				<th $thEstilo> <font color='white'> CP </font>	</th>
				<th $thEstilo> <font color='white'> Entidad Fiscalizada	 </font>	</th>
				<th $thEstilo> <font color='white'> UAA </font>	</th>
				<th $thEstilo> <font color='white'> Acción  </font>	</th>
				<th $thEstilo> <font color='white'> Fondo  </font>	</th>				
				<th $thEstilo> <font color='white'> Irregularidad General </font>		</th>
				<th $thEstilo> <font color='white'> Presunto Responsable</font>		</th>
				<th $thEstilo> <font color='white'> Monto </font>	</th>
				<th $thEstilo> <font color='white'> Control Interno </font>		</th>
				<th $thEstilo> <font color='white'> DIRECCIÓN </font>		</th>
				<th $thEstilo> <font color='white'> SUBDIRECTOR </font>		</th>
					
			</tr>";
$encabezados = "
	<table width='100%' style='' class='tabla'>
			<tr><td class='celTit' colspan='11' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
			<tr><td class='celTit' colspan='11' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'><b>PROCEDIMIENTOS POR INICIAR</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'><b>AL ".date('d')." DE ".date('m')." DE ".date('Y')."</b></td></tr>
			<tr><td class='celTit' colspan='11' align='center'> </td></tr>
	</table>
	<table width='100%' class='tabla' border='1' bordercolor='#999999'>
			<tr>
				<th $thEstilo> No°	</th>
				<th $thEstilo> <font color='white'> CP </font>	</th>
				<th $thEstilo> <font color='white'> Entidad Fiscalizada	 </font>	</th>
				<th $thEstilo> <font color='white'> UAA </font>	</th>
				<th $thEstilo> <font color='white'> Acción  </font>	</th>
				<th $thEstilo> <font color='white'> Fondo  </font>	</th>				
				<th $thEstilo> <font color='white'> Irregularidad General </font>		</th>
				<th $thEstilo> <font color='white'> Presunto Responsable</font>		</th>
				<th $thEstilo> <font color='white'> Monto </font>	</th>
				<th $thEstilo> <font color='white'> Control Interno </font>		</th>
				<th $thEstilo> <font color='white'> DIRECCIÓN </font>		</th>
				<th $thEstilo> <font color='white'> SUBDIRECTOR </font>		</th>
			</tr>";



//------------ contamos cantidad que se repite una accion ---------------
if($tipo==1){
$cont = "SELECT pfrr.num_accion, count( pfrr.num_accion ) AS veces FROM pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
po on po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where (pfrr.`entidad` LIKE 'SEDESOL' or pfrr.`entidad` LIKE 'u%')
and (pfrr.`cp` BETWEEN 2013 AND 2015)
GROUP BY pfrr.num_accion";
}

if($tipo==3){
$cont = "SELECT pfrr.num_accion, count( pfrr.num_accion ) AS veces FROM pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
po on po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where (pfrr.`entidad` LIKE 'SEDESOL' or pfrr.`entidad` LIKE 'u%')
and (pfrr.`cp` BETWEEN 2013 AND 2015)
GROUP BY pfrr.num_accion";
}
$contx = $conexion->select($cont);
while($na = mysql_fetch_assoc($contx)) {
	$cadAcciones[$na['num_accion']] = $na['veces'];
}
//print_r($cadAcciones);

//---------------------------------------- TABLA TEMPORAL ---------------------------------------------------
//-----------------------------------------------------------------------------------------------------------

if($tipo==1){
	$sqlt= "select pfrr.num_accion, po.UAA, entidad, pfrr.cp, nombre, detalle_edo_tramite, cargo, po.fondo, irregularidad_general, detalle_estado, id_sicsa, inicio_frr, monto_de_po_en_pesos, pfrr.direccion, pfrr.subdirector
from pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
po on po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where (pfrr.`entidad` LIKE 'SEDESOL' or pfrr.`entidad` LIKE 'u%')
and (pfrr.`cp` BETWEEN 2013 AND 2015)
order by pfrr.num_accion";
	}
	
		if($tipo==3){
	$sqlt= "select pfrr.num_accion, po.UAA, entidad, pfrr.cp, nombre, detalle_edo_tramite, cargo, po.fondo, irregularidad_general, detalle_estado, id_sicsa, inicio_frr, monto_de_po_en_pesos, pfrr.direccion, pfrr.subdirector
from pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
po on po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where (pfrr.`entidad` LIKE 'SEDESOL' or pfrr.`entidad` LIKE 'u%')
and (pfrr.`cp` BETWEEN 2013 AND 2015)
order by pfrr.num_accion";
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
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['cp']."</td>
		<td  $estilo rowspan = '$numAcc' align='left' valign='middle' >".$rt['entidad']."</td>
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['UAA']."</td>
		<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['num_accion']."</td>
		<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['fondo']."</td>
 		<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['irregularidad_general']."</td>
		
		";
		
	}
	
	$tablat .= "	
			<td $estilo align='right' valign='middle'>".$rt['nombre']." $edo</td>	
			
			";



			
		if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		
		
		
			
						$tablat .= "	
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>$".$rt['monto_de_po_en_pesos']."</td>";
			
			
	}
		
	
		if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		$tablat .= "	
			
			
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['detalle_estado']."</td>";
			
	}

		
		if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		$tablat .= "	
			
			
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['direccion']."</td>";
			
	}			
	
			if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		$tablat .= "	
			
			
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['subdirector']."</td>";
			
	}
		
	
	$NA = $rt['num_accion'];
	//$conexion->update("UPDATE pfrr SET fecha_notificacion_resolucion = '".$fechaNot."' WHERE num_accion = '".$rt['num_accion']."' ",false);

}
$tablat .= "</table>";
//*********************************************************************************************
buscaOficioMedios();
//*********************************************************************************************
echo "<div>"; 
	echo $tabla = utf8_decode(utf8_encode($encabezados.$tablat));
echo "</div>";
//*********************************************************************************************
//echo "<div id='' class='tabla'>";
	//echo "<br><table width='100%'>";
	/*
	echo "<tr>
			<th>fecha_acuerdo_inicio en 0 -> ".$fai."</th>
			<th>cierre_instruccion en 0 -> ".$fci."</th>
			<th>resolucion en 0 -> ".$fr."</th>
			<th>fecha_notificacion_resolucion en 0 -> ".$fnr."</th>
		  </tr>
	";
	echo "<tr>";
		echo "<td valign='top'>".$msgfai."</td>";
		echo "<td valign='top'>".$msgfci."</td>";
		echo "<td valign='top'>".$msgfr."</td>";
		echo "<td valign='top'>".$msgfnr."</td>";
	echo "</tr></table>";
	*/
//echo "</div>";
//*********************************************************************************************
//*********************************************************************************************
?>

<div class="nav">
<div class="table menuSup">

	<li> <img src="images/excel.png"/> <form action="excel.php" method = "POST" >
				<input type="hidden" name="export" value= <?php echo urlencode($encabezados.$tablat) ?> />
				<input type="hidden" name="nombre_archivo" value="entidad"/>
				<input type = "submit" value = "Descargar en Excel" class="links">
				</form>
			</li>
		</ul>
        
        

	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
	</li>
	</ul>
</div>
</div>







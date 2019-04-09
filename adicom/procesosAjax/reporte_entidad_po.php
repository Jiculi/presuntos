<?php 
//header('Content-Type: text/html; charset=UTF-8'); 
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();
error_reporting(E_ERROR);

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
$thEstilo = "bgcolor = '#58ACFA' ";
$encabezados = "
	<table width='100%' style='' class='tabla'>
			<tr><td class='celTit' colspan='9' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
			<tr><td class='celTit' colspan='9' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
			<tr><td class='celTit' colspan='9' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES</b></td></tr>
			<tr><td class='celTit' colspan='9' align='center'><b>RESUMEN DE</b></td></tr>
			<tr><td class='celTit' colspan='9' align='center'><b>$ef</b></td></tr>
			<!--- tr><td class='celTit' colspan='9' align='center'><b>AL ".date('d')." DE ".date('m')." DE ".date('Y')."</b></td></tr --->
			<tr><td class='celTit' colspan='9' align='center'> </td></tr>
	</table>
	<table width='100%' class='tabla' border='1' bordercolor='#999999'>
			<tr>
				<th $thEstilo> N	</th>
				<th $thEstilo >   <font color='white'> Entidad Fiscalizada </font>	</th>
				<th $thEstilo> <font color='white'> Acción	 </font>	</th>
				<th $thEstilo> <font color='white'> UAA	 </font>	</th>
				<th $thEstilo> <font color='white'> Irregularidad </font>	</th>
				<th $thEstilo> <font color='white'> CP  </font>	</th>		
				<th $thEstilo> <font color='white'> Estatus </font>		</th>
				<th $thEstilo> <font color='white'> Presuntos Responsables </font>		</th>
				<th $thEstilo> <font color='white'> Cargo </font>		</th>
				<th $thEstilo> <font color='white'> Monto </font>	</th>	
			</tr>";



//------------ contamos cantidad que se repite una accion ---------------
if($tipo==1){
$cont = "
SELECT po.num_accion, count( po.num_accion ) AS veces FROM po
inner join
po_presuntos
on po_presuntos.num_accion=po.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=po.detalle_de_estado_de_tramite
where 
(detalle_de_estado_de_tramite = 6 or detalle_de_estado_de_tramite= 7)
and entidad_accion like '%Gobierno del Estado de $ef%' GROUP BY po.num_accion";
}





if($tipo==3){
$cont = "SELECT po.num_accion, count( po.num_accion ) AS veces FROM po
inner join
po_presuntos
on po_presuntos.num_accion=po.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=po.detalle_de_estado_de_tramite
where 
(detalle_de_estado_de_tramite = 6 or detalle_de_estado_de_tramite= 7)
and (entidad_accion like '%$ef%' OR entidad_fiscalizada like '%$ef%') GROUP BY po.num_accion";
}
$contx = $conexion->select($cont);
while($na = mysql_fetch_assoc($contx)) {
	$cadAcciones[$na['num_accion']] = $na['veces'];
}
//print_r($cadAcciones);

//---------------------------------------- TABLA TEMPORAL ---------------------------------------------------
//-----------------------------------------------------------------------------------------------------------

if($tipo==1){
	$sqlt= "SELECT po.num_accion, numero_de_pliego, entidad_fiscalizada, uaa, irregularidad_general, cp,detalle_estado, servidor_contratista, cargo_servidor, monto_de_po_en_pesos FROM po inner join po_presuntos on po_presuntos.num_accion=po.num_accion inner join estados_tramite on estados_tramite.id_estado=po.detalle_de_estado_de_tramite where (detalle_de_estado_de_tramite = 6 or detalle_de_estado_de_tramite= 7) and entidad_accion like '%Gobierno del Estado de $ef%' order by num_accion";






	}
	
		if($tipo==3){
	$sqlt= "SELECT po.num_accion, numero_de_pliego, entidad_fiscalizada, uaa, irregularidad_general, cp,detalle_estado, servidor_contratista, cargo_servidor, monto_de_po_en_pesos FROM po inner join po_presuntos on po_presuntos.num_accion=po.num_accion inner join estados_tramite on estados_tramite.id_estado=po.detalle_de_estado_de_tramite where (detalle_de_estado_de_tramite = 6 or detalle_de_estado_de_tramite= 7) and entidad_accion like '%$ef%' order by num_accion";
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
		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['entidad_fiscalizada']."</td>
		<td  $estilo rowspan = '$numAcc' align='left' valign='middle' >".$rt['num_accion']."</td>
		<td  $estilo rowspan = '$numAcc' align='left' valign='middle' >".$rt['uaa']."</td>
					<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['irregularidad_general']."</td>

		<td  $estilo rowspan = '$numAcc' align='center' valign='middle' >".$rt['cp']."</td>
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".$rt['detalle_estado']."</td>
 		
		";
		
		
	}
	
	$tablat .= "	
			<td $estilo align='right' valign='middle'>".$rt['servidor_contratista']." $edo</td>	
			<td $estilo align='left' valign='middle'>".$rt['cargo_servidor']."</td>
			";
	
	

			
		if( $NA != $rt['num_accion'] && $numAcc >= 1) 
	{
		
		
		if($rt['id_sicsa']>6){
		$tablat .= "	
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".'$'.number_format($rt['inicio_frr'],2)."</td>";
		}
		
		
		else{
			
						$tablat .= "	
			<td  $estilo  rowspan = '$numAcc' align='center' valign='middle'>".'$'.number_format($rt['monto_de_po_en_pesos'],2)."</td>";
			
			}
			
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







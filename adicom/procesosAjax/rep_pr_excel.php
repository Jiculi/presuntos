<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

error_reporting(E_ERROR);

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$limit = valorSeguro($_POST['limit']);
$envio = valorSeguro($_POST['envio']);
//------------------------------------------------------------------------------
$ef = valorSeguro($_REQUEST['ef']);

/* ------------------- CHECKBOX ------------------------*/
//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
//---------- DG vemos todo -----------------------------------------
	$txtsql= "select pfrr.num_accion, entidad, pfrr.cp, nombre, cargo, po.fondo, irregularidad_general, detalle_estado, id_sicsa, inicio_frr, monto_de_po_en_pesos
from pfrr
inner join
pfrr_presuntos_audiencias
on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join
po on po.num_accion=pfrr.num_accion
inner join 
estados_tramite on estados_tramite.id_estado=pfrr.detalle_edo_tramite
where tipo <>'titularICC' and tipo <> 'titularTESOFE' and tipo <> 'responsableInforme'
and pfrr_presuntos_audiencias.status=1
and detalle_edo_tramite <> 14
and nombre like '%$ef%'";
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);


$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------


$tabla = "<table>";
$tabla .="
	<tr>
		<tr><td class='celTit' colspan='10' align='center'><b>AUDITORÍA SUPERIOR DE LA FEDERACIÓN</b></td>	</tr>
		<tr><td class='celTit' colspan='10' align='center'><b>UNIDAD DE ASUNTOS JURÍDICOS</b></td>	</tr>
		<tr><td class='celTit' colspan='10' align='center'><b>DIRECCIÓN GENERAL DE RESPONSABILIDADES A LOS RECURSOS FEDERALES EN ESTADOS Y MUNICIPIOS</b></td></tr>
		<tr><td class='celTit' colspan='10' align='center'><b>ASUNTOS DE</b></td></tr>
		<tr><td class='celTit' colspan='10' align='center'><b>$ef</b></td></tr>
		<tr><td class='celTit' colspan='10' align='center'><b>AL ".date('d')." DE ".strtoupper(dameMes(date("n")))." DE ".date('Y')." - ".date('h:i:s')."</b></td></tr>
		
		<tr><td class='celTit' colspan='10' align='center'> </td></tr>
	</tr>";

$tabla .= "<tr>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("N")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>Acción</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Entidad Fiscalizada")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("CP")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Presunto Responsable")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Cargo")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Fondo")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Irregularidad")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Control Interno")."</th>";
$tabla .=	"<th style='background:#339933; border: 1px dotted silver'>".utf8_decode("Monto")."</th>";

$tabla .= "</trs>";




while($r = mysql_fetch_array($sqlT))
{

	$totalM[]= $r['inicio_frr'];
$totalMonto=array_sum($totalM); 
if($r['id_sicsa']==6){
$tdns[] = $r['monto_de_po_en_pesos'];
$totaldtns= array_sum($tdns);
}
$total=$totalMonto+$totaldtns;
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//------SQL de Volantes//
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '				
						<div style="overflow:auto;  width:100%; height:400px">
		<table border="1" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >

            <tr bordercolor="#666666"  '.$estilo.' >';

				
				$tabla .= '<td class="">'.$i.'</td>';
				$tabla .= '<td class="" align="center"> '.$r['num_accion'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['entidad'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				$tabla .= '<td class="">'.$r['nombre'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['cargo'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['fondo'].'</td>';
				if ($r['irregularidad_general']=="")
				$tabla .= '<td class="" align="center">Ampliado</td>';
				else 
				$tabla .= '<td class="" align="center">'.$r['irregularidad_general'].'</td>';
				if($r['id_sicsa']==7)
				$tabla .= '<td class="" align="center">Desahogo del PFRR</td>';
				else
				$tabla .= '<td class="" align="center">'.$r['detalle_estado'].'</td>';
				if($r['id_sicsa']>6)
				$tabla .= '<td class="">' ."$".number_format($r['inicio_frr'],2).'</td>';
				else
				$tabla .= '<td class="">' ."$".number_format($r['monto_de_po_en_pesos'],2).'</td>';

				
			$tabla .= '</td> </tr>';

}


$tabla .= '<table border="0">';
	$tabla .= "<tr>";
	$tabla .= "<tr>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td>";
	$tabla .= "<td> TOTAL";
	$tabla .= "<td>".number_format($total,2)."</td>";
	$tabla .= "</tr>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</td>";
	$tabla .= "</tr>";





$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

//if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
//------------------------------------------------------------------------------------------------------------------
//$paginas = ceil($total/1000);
//echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=listado_po.xls");
//$excel=$_REQUEST['export'];
print utf8_decode($tabla);
exit;



//print_r($_REQUEST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
//mysql_free_result($sqlT);
//$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

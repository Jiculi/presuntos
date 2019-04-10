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
$ef = valorSeguro($_POST['ef']);

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
and nombre like '%$ef%'";
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);


$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				$tabla .= '<th class="ancho50 blanco"> N </th>';
				$tabla .= '<th class="ancho200 blanco">Acción</th>';
				$tabla .= '<th class="ancho100 blanco">Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho50 blanco">CP</th>';
				$tabla .= '<th class="ancho150 blanco">Presunto Responsable</th>';
				$tabla .= '<th class="ancho150 blanco">Cargo </th>';
				$tabla .= '<th class="ancho100 blanco">Fondo</th>';
				$tabla .= '<th class="ancho250 blanco">Irregularidad</th>';				
				$tabla .= '<th class="ancho10 blanco">Control Interno</th>';
			$tabla .= '<th class="ancho100 blanco">Monto</th> 
					</tr>
				</thead>

';

while($r = mysql_fetch_array($sqlT))
{

	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//------SQL de Volantes//
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
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
				$tabla .= '<td class="">Desahogo del PFRR</td>';
				else
				$tabla .= '<td class="" align="center">'.$r['detalle_estado'].'</td>';
				if($r['id_sicsa']>6)
				$tabla .= '<td class="">' ."$".number_format($r['inicio_frr'],2).'</td>';
				else
				$tabla .= '<td class="">' ."$".number_format($r['monto_de_po_en_pesos'],2).'</td>';

				
			$tabla .= '</td> </tr>';

}
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

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
	$txtsql= "select pfrr.entidad, pfrr.num_accion, uaa, fondo, estado_sicsa, inicio_frr from pfrr inner join po on po.num_accion=pfrr.num_accion inner join estados_tramite on pfrr.detalle_edo_tramite=estados_tramite.id_estado inner join estados_sicsa on estados_sicsa.id_sicsa=estados_tramite.id_sicsa where entidad like '%$ef%' and estados_sicsa.id_sicsa=7" ;
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
				$tabla .= '<th class="ancho200 blanco">Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho100 blanco">Acción</th>';
				$tabla .= '<th class="ancho50 blanco">UAA</th>';
				$tabla .= '<th class="ancho150 blanco">Fondo</th>';
				$tabla .= '<th class="ancho150 blanco">Control Interno </th>';
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
				$tabla .= '<td class="" align="center"> '.$r['entidad'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['num_accion'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['uaa'].'</td>';
				$tabla .= '<td class="">'.$r['fondo'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['estado_sicsa'].'</td>';
				$tabla .= '<td class="" align="center">'."$ ".number_format($r['inicio_frr'],2).'</td>';

				
			$tabla .= '</td> </tr>';
}
$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados $ef $totalP</h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
//------------------------------------------------------------------------------------------------------------------
$paginas = ceil($total/1000);
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;


//print_r($_POST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
mysql_free_result($sqlT);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

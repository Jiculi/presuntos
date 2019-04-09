<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
//----------------------------------------- DGRRFEM ------------------------------------------------
$conexion = new conexion;
$conexion->conectar();
//------------------------- RECIBIMOS VARIABLES ----------------------------------------------------
$nombre = $_REQUEST["term"];
//$estado = $_REQUEST["estado"];
//$movimiento = $_REQUEST["movimiento"];
//--------------------------------------------------------------------------------------------------
//if($estado == 33.1)
//	$sql=$conexion->select("SELECT * FROM medios WHERE nombre LIKE '%".$nombre."%' order by nombre asc ");
//if($estado == 33.2)
$sql=$conexion->select("SELECT * FROM medios WHERE nombre LIKE '%".$nombre."%' order by nombre asc ");
//--------------------------------------------------------------------------------------------------
while($r = mysql_fetch_array($sql))
{
	$edoTxt = dameEstado($r["estado"]);
	$pfrr = dameDatosPFRR($r["num_accion"]);
	$pdr = $pfrr["pdr"];
	$procedimiento = $pfrr["procedimiento"];
	//---------- sacamos los oficios -------------------------------

	
	$results[] = array(
						"value"=>$r["nombre"]." - ".$r["num_accion"], 
						"idPresunto" => $r["id"], 
						"nombre" => $r["nombre"], 
						"cargo" => $r["cargo"], 
						"dependencia" => $r["dependencia"], 
						"accion" => $r["num_accion"], 
						"estadoTxt"=>$edoTxt,  
						"estado"=>$r["estado"], 
						"pdr"=>$pdr, 
						"procedimiento" => $procedimiento, 
						"referencia" => $oficio,
						"refDestinatario" => $ofiDestinatario,
						"refCargo" => $ofiCargo,						
						"fechaReferencia" => $fechaOficio,
						"sql" => $query
						);
}
echo json_encode($results);
//echo print_r($results)

?>





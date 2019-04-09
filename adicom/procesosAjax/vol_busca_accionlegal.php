<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
//----------------------------------------- DGRRFEM ------------------------------------------------
$conexion = new conexion;
$conexion->conectar();
//------------------------- RECIBIMOS VARIABLES ----------------------------------------------------
$accion = $_REQUEST["term"];
//--------------------------------------------------------------------------------------------------
$sql=$conexion->select("SELECT num_accion,num_accion_po,direccion,abogado,detalle_de_estado_de_tramite AS ET,numero_de_pliego,prescripcion FROM opiniones WHERE num_accion LIKE '%".$accion."%' or num_accion_po LIKE '%".$accion."%' order by num_accion asc ");
//--------------------------------------------------------------------------------------------------
while($r = mysql_fetch_array($sql))
{
	//---------------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------------
	$sql1=$conexion->select("SELECT nombre,direccion FROM usuarios WHERE nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	//----------------------------------------------------------------------------------------------------
	$estado = dameEdoTramite($r["num_accion"]);
	if($estado)	$edoTxt = dameEstado($estado);
	else $edoTxt = "Sin Estado";
//--------------------------
 
	$edoModulo = dameModuloAccion($r["num_accion"]);
	
	if($estado<>99){
	$results[] = array("value"=>$r["num_accion_po"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$estado,"edoTxt"=>$edoTxt, "prescripcion"=>$r["prescripcion"], "presuntos"=>$totalPresuntos, "montototal"=>$totalMontoPO, "po"=>$r["numero_de_pliego"], "referencia"=>$referencia, "referenciaAcuse"=>$referenciaAcuse, "edoModulo"=>$edoModulo);
	}
	
	else{
	
		$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$estado,"edoTxt"=>$edoTxt, "prescripcion"=>$r["prescripcion"], "presuntos"=>$totalPresuntos, "montototal"=>$totalMontoPO, "po"=>$r["numero_de_pliego"], "referencia"=>$referencia, "referenciaAcuse"=>$referenciaAcuse, "edoModulo"=>$edoModulo);
	}
}
echo json_encode($results);
//echo print_r($results)

?>





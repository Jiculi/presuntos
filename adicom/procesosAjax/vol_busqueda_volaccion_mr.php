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
$sql=$conexion->select("SELECT num_accion,direccion,abogado,detalle_edo_tramite AS ET,po,prescripcion FROM pfrr WHERE num_accion LIKE '%".$accion."%' order by num_accion asc ");
//--------------------------------------------------------------------------------------------------
while($r = mysql_fetch_array($sql))
{
	//---------------------------------------------------------------------------------------------------
	// --- vemos si hay presuntos -----------------------------------------------------------------------
	$sqlPresuntos = $conexion->select("select num_accion FROM po_presuntos where num_accion = '".$r["num_accion"]."'");
	$totalPresuntos = mysql_num_rows($sqlPresuntos);
	// --- vemos si hay montos ---------------------------------------------------------------------------
	$totalMontoPO = dameTotalPO($r["num_accion"]);
	//----------------------------------------------------------------------------------------------------
	$sql1=$conexion->select("SELECT nombre,direccion FROM usuarios WHERE nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	//----------------------------------------------------------------------------------------------------
	$estado = dameEdoTramite($r["num_accion"]);
	if($estado)	$edoTxt = dameEstado($estado);
	else $edoTxt = "Sin Estado";
	//---------- FECHA DEL FOLIO DE ACUSE EDO 3 O 4----------------------------------------------------------------
	if($estado == 3 || $estado == 4)
	{
		$query = "SELECT tipo,oficio,oficioRecepcion,oficioAcuse 
					FROM po_historial
					WHERE 
						estadoTramite = 3 AND 
						num_accion = '".$r["num_accion"]."' AND 
						status <> 0 
					ORDER BY oficioRecepcion DESC
					limit 1";
		$sql2=$conexion->select($query); 
		$nOfJur = mysql_num_rows($sql2);
		$ofi = mysql_fetch_array($sql2);
		
		if($nOfJur) 
		{
			$referencia = $ofi["oficio"];
			//$referenciaFecha = fechaNormal($ofi["oficioRecepcion"]);
			$referenciaAcuse = fechaNormal($ofi["oficioAcuse"]);
		}
	}
	//---------- FECHA DEL FOLIO DE ACUSE EDO 7 ----------------------------------------------------------------
	if($estado == 7)
	{
		$query = "SELECT tipo,oficio,oficioRecepcion,oficioAcuse 
					FROM po_historial
					WHERE 
						estadoTramite = 7 AND 
						num_accion = '".$r["num_accion"]."' AND 
						status <> 0 
					ORDER BY oficioRecepcion DESC
					limit 1";
		$sql3=$conexion->select($query); 
		$nOfJur = mysql_num_rows($sql3);
		$ofi = mysql_fetch_array($sql3);
		
		if($nOfJur) 
		{
			$referencia = $ofi["oficio"];
			//$referenciaFecha = fechaNormal($ofi["oficioRecepcion"]);
			$referenciaAcuse = fechaNormal($ofi["oficioAcuse"]);
		}
	}

	$edoModulo = dameModuloAccion($r["num_accion"]);
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$estado,"edoTxt"=>$edoTxt, "prescripcion"=>$r["prescripcion"], "presuntos"=>$totalPresuntos, "montototal"=>$totalMontoPO, "po"=>$r["numero_de_pliego"], "referencia"=>$referencia, "referenciaAcuse"=>$referenciaAcuse, "edoModulo"=>$edoModulo);
}
echo json_encode($results);
//echo print_r($results)

?>





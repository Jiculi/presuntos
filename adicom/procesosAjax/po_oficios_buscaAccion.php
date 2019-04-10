<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/funciones.php");
// ----------------------- cvariables ---------------------------------------------------------------
$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
$nivel = $_REQUEST["nivel"];
if ( $nivel == "S" ) { $nivel = $_REQUEST["direccion"];}

// ----------------------- conexion principal ---------------------------------------------------------------
require_once("../includes/clases.php");
$conexion = new conexion;
$conexion->conectar();

if($direccion == "DG") $sql=$conexion->select("select num_accion,direccion,abogado,detalle_de_estado_de_tramite,monto_de_po_en_pesos,monto_modificado FROM po where num_accion like '%$accion%'");
else $sql=$conexion->select("SELECT num_accion,direccion,abogado,detalle_de_estado_de_tramite,monto_de_po_en_pesos,monto_modificado FROM po WHERE num_accion LIKE '%$accion%' AND  subnivel LIKE '".$nivel."%'  ");

while ($r=mysql_fetch_array ($sql))
{
	if($r['monto_modificado'] == '') $monto = $r['monto_de_po_en_pesos'];
	else $monto = $r['monto_modificado'];
	
	$sql1=$conexion->select("select nombre,direccion from usuarios where nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	$edoGral = (dameEstado($r["detalle_de_estado_de_tramite"]));
	//vemos si tiene oficios sin utilizar pendientes
	$sqlxx=$conexion->select("SELECT O.folio, O.fecha_oficio FROM oficios O
							INNER JOIN oficios_contenido OC
							ON O.folio = OC.folio 
							WHERE 
								O.tipo='notificacionICC' AND 
								OC.num_accion = '".$r["num_accion"]."'  AND 
								OC.juridico = 1 AND 
								O.status <> 0 "); 
	$ofiICC = mysql_num_rows($sqlxx);
	
	$sqlxx=$conexion->select("SELECT O.folio, O.fecha_oficio 
							FROM oficios O 
							INNER JOIN oficios_contenido OC
							ON O.folio = OC.folio 
							WHERE 
								O.tipo='notificacionEF' AND 
								OC.num_accion = '".$r["num_accion"]."' AND 
								OC.juridico = 1 AND 
								O.status <> 0 "); 
	$ofiEF = mysql_num_rows($sqlxx);
	
	$sqlxx=$conexion->select("SELECT O.folio, O.fecha_oficio 
							FROM oficios O 
							INNER JOIN oficios_contenido OC 
								ON O.folio = OC.folio 
							WHERE 
								O.tipo='asistencia' AND 
								OC.num_accion = '".$r["num_accion"]."' AND 
								OC.atendido = 0 AND 
								O.status <> 0 "); 
	$ofiAS = mysql_num_rows($sqlxx);
	
	$sqlxx=$conexion->select("SELECT O.folio, O.fecha_oficio 
							FROM oficios O 
							INNER JOIN oficios_contenido OC 
								ON O.folio = OC.folio 
							WHERE 
								O.tipo='remisionUAA' AND 
								OC.num_accion = '".$r["num_accion"]."' AND 
								OC.atendido = 0 AND 
								O.status <> 0 "); 
	$remuaa = mysql_num_rows($sqlxx);
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estadoTxt"=>$edoGral, "estado"=>$r["detalle_de_estado_de_tramite"], "ofiICC"=>$ofiICC, "ofiEF"=>$ofiEF, "ofiAS"=>$ofiAS, "remuaa"=>$remuaa, "monto"=>$monto);
}
echo json_encode($results);

?>
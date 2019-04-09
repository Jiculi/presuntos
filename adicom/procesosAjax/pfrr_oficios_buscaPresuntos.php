<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["accion"];
//----------------------- SACAMOS TODOS LOS CITATORIOS --------------------------------------------------------------------------------
$sql2=$conexion->select("SELECT destinatario FROM oficios WHERE tipo = 'citatorio_PFRR' AND status <> 0");
while ($r2=mysql_fetch_array ($sql2)) $arrayDestinatarios[] = $r2['destinatario'];
//-------------------------------------------------------------------------------------------------------------------------------------
$sql=$conexion->select("SELECT cont,num_accion,nombre,cargo,dependencia FROM pfrr_presuntos_audiencias WHERE num_accion LIKE '".$accion."'  AND status <> 0 AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme') ");
while ($r=mysql_fetch_array ($sql))
{
	if(!in_array($r['cont'],$arrayDestinatarios))
		// if(!in_array($r['cont'],$arrayDestinatarios)) (No tiene oficcios citatorios los presuntos por eso solo llama a los que
	{
		$presuntos .= $r['nombre']."-";
		$idPresuntos .= $r['cont']."-";
		$cargos .= $r['cargo']."-";
		$dependencias .= $r['dependencia']."-";
	}
} 
$todo = $presuntos."|".$idPresuntos."|".$cargos."|".$dependencias;
echo $todo;
?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

/*
idVol:$$('#idVolE').val(),
folio:$$('#folioE').val(),
accion:$$('#accionvolanteE').val(),
direccion:<?php echo $r['direccion'] ?>,
//---- se elige el user del index -------------
usuario:$$('#indexUser').val()
*/

$nombre= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];

$cont = 0;

$sql=$conexion->select("select id,nombre,direccion from usuarios WHERE nombre LIKE '%$nombre%' AND direccion = '$direccion'");

while ($r=mysql_fetch_array ($sql))
{
	$results[] = array("id"=>$r["id"],"value"=>$r["nombre"], "direccion"=>$r["direccion"]);
}

echo json_encode($results);

?>





<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");

require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$cral = $_REQUEST["cral"];
$cral2 = str_replace("/","!",$_REQUEST["cral"]);

$sql=$conexion->select("select oficioDoc from archivos where oficioDoc like '".$cral2."'");
$nr = mysql_num_rows($sql);

if($nr == 0) echo "0";
else echo "1";


?>





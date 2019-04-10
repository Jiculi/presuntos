<?php
//header('Content-Type: text/html; charset=UTF-8');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once("../../includes/clases.php");
require_once("../../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();

$accion = valorSeguro($_REQUEST['accion']); //variable

$query = $conexion->select("SELECT `num_accion`, `superveniente`, `num_procedimiento`, `entidad`, `cp`, `resolucion` 
						FROM `pfrr` 
						WHERE `num_accion` ='$accion' 
						limit 1 ");

$row = mysql_fetch_array($query);

$cambia = $row['num_procedimiento'];

$cambia = str_replace("/", "-", "$cambia");

echo "<table border=1>\n";
echo "<tr>\n";
echo "<th>Clave</th>\n";
echo "<th>Superveniente</th>\n";
echo "<th>Procedimiento</th>\n";
echo "<th>Entidad</th>\n";
echo "<th>CP</th>\n";
echo "<th>Fecha Resoluci&oacute;n</th>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td><div>".$row['num_accion']."</div></td>\n";
echo "<td><div>".$row['superveniente']."</div></td>\n";
echo "<td><div>
	<a
	href='file://SIAC/ASF/UAJ/DGR/Archivo_Compartido_de_Resoluciones_Emitidas/A/".$cambia.".pdf'
	target='_parent'>".$row['num_procedimiento']."</a></td>
</div></td>\n";
echo "<td><div>".$row['entidad']."</div></td>\n";
echo "<td><div>".$row['cp']."</div></td>\n";
echo "<td><div>".$row['resolucion']."</div></td>\n";
echo "</tr>\n";

echo "</table>\n";

?>
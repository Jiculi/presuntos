<?php
require_once("includes/clases.php");
require_once("includes/configuracion.php");
require_once("includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
if($_SESSION['direccion'] != "DG")
	$sql = $conexion->insert("INSERT INTO rep_visitas SET user = '".$_SESSION['usuario']."', fechaHora = '".date("Y-m-d")." ".date("h:i:s")."', hora='".date("h:i:s")."' ",false);
//echo $sql;
//$r = mysql_fetch_array($sql);
//-------------------------------------------------------------------------------
?>
<div style="padding:10px">
<table width="100%">
    <tr>
        <td <?php if($_SESSION['direccion'] == "DG") echo 'width="60%"'; 
		else  echo 'width="100%"';  ?> >
        <iframe width="100%" height="400" frameborder="0" src="reportes/comportamientoSA2012.pdf.php"></iframe>
        </td>
        
        <?php if($_SESSION['direccion'] == "DG") { ?>
        <td valign="top" style="padding:10px">
        	<div style="height:400px;overflow:auto;">
        	<table width="100%">
                <tr> <th>Nombre</th> <th>Direccion</th> <th> Fecha Hora </th> </tr>
                <center><b>Ultimos Visitantes</b></center>
                <?php 
                $sql = $conexion->select("SELECT * FROM rep_visitas order by fechaHora desc");
                while($r = mysql_fetch_array($sql))
				{
					$u = dameUsuario($r['user']);
					$FH = explode(" ",$r['fechaHora']);
                   echo "<tr> <td>".$u['nombre']."</td> <td>".$u['direccion']."</td> <td>".fechaNormal($FH[0])." ".$FH[1]."</td> </tr>"; 
				}
                ?>
                </table>
                </div>
        </td>
         <?php } ?>
    </tr>
</table>
</div>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
$soloLectura="readonly";
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE cont = ".$_REQUEST['idPresuntop']." ",true);
$r = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
$sqlPo = $conexion->select("SELECT detalle_edo_tramite FROM pfrr WHERE num_accion = '".$_REQUEST['numAccion']."' ",false);
$rPo = mysql_fetch_array($sqlPo);

if($rPo['detalle_edo_tramite'] >= 10 ) $soloLectura = "readonly";
else $soloLectura = "";
//-------------------------------------------------------------------------------

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<center>
<div id='actualizaP2' style="line-height:normal"></div>
<?php 
//echo $_REQUEST['numAccion']." edo tra ".$rPo['detalle_de_estado_de_tramite'] 

if($r['status'] == "1") $checkPR = "selected";

?>


  <table width="20%" align="center" class="tablaPasos ">
                 <tr valign="baseline">
                 	<td ><h1><center>Al presionar el botón se borrará al presunto:</center></h3></td>
                 </tr>
                 <tr>                 	
      				<td ><input  type="text" disabled="disabled" class="submit-login" id="nombre"  name="nombre" value="<?php echo $r['nombre']; ?>" size="20" ></td>
                 </tr>
                  <tr >
      <td class="center" colspan="3">
      <center><br /><br />
      <?php if($rPo['detalle_edo_tramite'] <= 18 || $_REQUEST['direccion'] == "DG") {?>
      	<input type="button"  class="submit-login"  value="Borrar presunto" onclick="borraPresuntopfrr('<?php echo $r['cont'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">
      <?php } ?>
      </table>
</center>
</body>
</html>
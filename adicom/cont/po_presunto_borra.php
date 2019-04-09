<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
$soloLectura="readonly";
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM po_presuntos WHERE creacion = ".$_REQUEST['idPresunto']." ",true);
$r = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
$sqlPo = $conexion->select("SELECT detalle_de_estado_de_tramite FROM po WHERE num_accion = '".$_REQUEST['numAccion']."' ",false);
$rPo = mysql_fetch_array($sqlPo);

if($rPo['detalle_de_estado_de_tramite'] >= 6 ) $soloLectura = "readonly";
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
if($r['tipo_presunto'] == "responsableInforme") $checkRI = "selected";
if($r['tipo_presunto'] == "titularICC") $checkICC = "selected";
if($r['tipo_presunto'] == "presuntoResponsable") $checkPR = "selected";
if($r['tipo_presunto'] == "proveedor") $checkP = "selected";
if($r['tipo_presunto'] == "contratista") $checkC = "selected";
?>


  <table width="90%" align="center" class="tablaPasos ">
                 <tr valign="baseline">
                 	<td ><h3><center>Al presionar el botón se borrará al presunto:</center></h3></td>
                 </tr>
                 <tr>                 	
      				<td ><input  type="text" disabled="disabled" class="redonda5" id="servidor_contratista"  name="servidor_contratista" value="<?php echo $r['servidor_contratista']; ?>" size="70" ></td>
                 </tr>
                  <tr >
      <td class="center" colspan="3">
      <center><br /><br />
      <?php if($rPo['detalle_de_estado_de_tramite'] < 6 ) {?>
      	<input type="button"  class="submit-login"  value="Borrar presunto" onclick="borraPresunto('<?php echo $r['creacion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">
      <?php } ?>
      </table>
</center>
</body>
</html>
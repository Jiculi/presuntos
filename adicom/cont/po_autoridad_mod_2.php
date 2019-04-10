<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="autoridad_MOD" id="form1">
  <table width="90%" align="center" class="tablaPasos ">
                 <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td >
                  <select class="redonda5" id="tipoAutoridad" name="tipoAutoridad" >
                  	<option value="">Seleccione tipo de Autoridad...</option>
                    <option value="responsableInforme">Titular de la Entidad Fiscalizada</option>
                    <option value="titularICC">Titular Instancia de Control Competente</option>
                  </select>
                  
                  </td>
                </tr>

    <tr valign="baseline">
      <td class="etiquetaPo">Nombre: </td>
      <td ><input  type="text"  class="redonda5" id="servidor_contratista"  name="servidor_contratista" value="<?php echo $r['servidor_contratista']; ?>" size="70" <?php echo  $soloLectura ?>></td>
    </tr>
    <tr>
      <td class="etiquetaPo">Cargo:</td>
      <td><input  type="text"  class="redonda5" id="cargo_servidor" name="cargo_servidor" value="<?php echo $r['cargo_servidor']; ?>" size="70" <?php echo  $soloLectura ?>></td>
    </tr>
    <tr >
      <td class="etiquetaPo">Dependencia:</td>
      <td><input  type="text"  class="redonda5" id="dependencia" name="dependencia" value="<?php echo $r['dependencia']; ?>" size="70" <?php echo  $soloLectura ?>></td>
    </tr>
    <tr >
      <td class="center" colspan="3">
      <center><br /><br />
      <?php if($rPo['detalle_de_estado_de_tramite'] < 6 ) {?>
      	<input type="button"  class="submit-login"  value="Actualizar Autoridad" onclick="actualizaAutoridad_2('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">
      <?php } ?>
      </center>
      </td>
      
    </tr>
  </table>
  <input name="creacion" type="hidden" id="creacion" value="<?php echo $r['creacion']; ?>">
</form>
</center>
</body>
</html>
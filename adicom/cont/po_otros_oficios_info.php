<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$id = valorSeguro($_REQUEST['id']);
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM otros_oficios WHERE id = '".$id."' ",false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
?>
<!-- ----------------------------- DIV RECEPCION --------------------------------- -->
<!-- ----------------------------- DIV RECEPCION --------------------------------- -->
<div style="float:right"><img src="images/help.png" /></div>
<h3 class="poTitulosPasos">Información del Oficio  </h3>

  <table width="90%" align="center" class="tablaPasos">
  <tr valign="baseline">
        <td width="12%" align="right" class="etiquetaPo">Tipo:
        <td colspan="5"><?php echo $r['tipo'] ?></td>
    </tr>
      <tr valign="baseline">
        <td align="right" nowrap class="etiquetaPo">Folio de Oficio:</td>
        <td width="19%"><?php echo $r['folio_volante'] ?></td>
      <tr>
        <td width="11%" class="etiquetaPo">Fecha del Oficio:</td>
        <td width="7%"><?php echo $r['fecha'] ?></td>
      </tr>
      <tr>
        <td width="4%" class="etiquetaPo">Acuse</td>
        <td width="46%"><?php echo $r['acuse'] ?></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap class="etiquetaPo">Asunto:</td>
        <td colspan="5"><?php echo $r['leyenda'] ?></td>
      </tr>
      <tr valign="baseline">
        <td align="right" nowrap class="etiquetaPo">Atiende oficio:</td>
        <td colspan="5"><?php echo $r['atiende'] ?>
      </tr>
      <tr valign="baseline">
        <td nowrap align="right">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">
      </tr>
    </table>
<!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
<!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
//echo "ACCION ".$NA = valorSeguro($r['num_accion']);
//echo "accion ".
if($_REQUEST['numAccion'] != "")$accion = valorSeguro($_REQUEST['numAccion']);
else $accion=valorSeguro($_REQUEST['RS_accion']);

//echo "<h4> Num. accion: ".$accion."</h4><br><br>";
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$sql2 = $conexion->select("SELECT * FROM pfrr WHERE num_accion = '".$accion."' ");
$ra = mysql_fetch_array($sql2);
$tra = mysql_num_rows($sql2);
//--------------------------------------------------------------------------------------------------------------
//mysql_select_db($database_SAGAP, $SAGAP);
/*$sql3 = $conexion->select("SELECT * FROM po_montos WHERE num_accion = '".$accion."' ");
$rm = mysql_fetch_array($sql3);
$trm = mysql_num_rows($sql3);*/
//--------------------------------------------------------------------------------------------------------------
$monto_PO = floatval(str_replace(",","",$ra['monto_no_solventado']));
/*$monto_resarcido = floatval($rm['monto_resarcido']);
$monto_justificado = floatval($rm['monto_justificado']);
$monto_aclarado = floatval($rm['monto_aclarado']);
$monto_comprobado = floatval($rm['monto_comprobado']); 
$suma = $monto_resarcido +$monto_aclarado +$monto_comprobado + $monto_justificado;*/
$TotPO = floatval($monto_PO) - floatval($suma);
	
//echo "<br> $monto_PO - $suma = $TotPO";
//--------------------------------------------------------------------------------------------------------------
echo number_format($TotPO,2);
?>  
   


   
  
  




</body>
</html>
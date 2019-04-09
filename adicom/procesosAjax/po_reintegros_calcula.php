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
$sql2 = $conexion->select("SELECT * FROM po WHERE num_accion = '".$accion."' ");
$ra = mysql_fetch_array($sql2);
$tra = mysql_num_rows($sql2);
//--------------------------------------------------------------------------------------------------------------
//mysql_select_db($database_SAGAP, $SAGAP);
$sql3 = $conexion->select("SELECT * FROM po_montos WHERE num_accion = '".$accion."' ");
$rm = mysql_fetch_array($sql3);
$trm = mysql_num_rows($sql3);
//--------------------------------------------------------------------------------------------------------------
$monto_PO = floatval($ra['monto_de_po_en_pesos']);
$intereses = floatval($rm['intereses']);
$monto_PO_modificado = floatval($ra['monto_modificado']);
$monto_resarcido = floatval($rm['monto_resarcido']);
$monto_justificado = floatval($rm['monto_justificado']);
$monto_aclarado = floatval($rm['monto_aclarado']);
$monto_comprobado = floatval($rm['monto_comprobado']); 
$monto_modificado = floatval($rm['monto_modificado']); 
$suma = $monto_resarcido +$monto_aclarado +$monto_comprobado + $monto_justificado;
$TotPO = floatval($monto_PO) - floatval($suma);
$TotPO_modificado=floatval($monto_PO_modificado) - floatval($suma);
$cant_reintegrada=floatval($monto_PO) + floatval($intereses);
$cant_reintegrada_mod=floatval($monto_PO_modificado) + floatval($intereses);
//echo "<br> $monto_PO - $suma = $TotPO";
//--------------------------------------------------------------------------------------------------------------
?>
<style>
.montosInfo td{ font-weight:bold}
</style>
<table width="95%" border="0" cellspacing="0" cellpadding="0" class="montosInfo" align="center">
  <tr>
    <th scope="col" align="center"><p>Monto IR Original</p></th>
    <th scope="col" align="center"><p>Monto Modificado por la UAA</p></th>
    <th scope="col" align="center"><p>Resarcido</p></th>
    <th scope="col" align="center"><p>Justificado</p></th>
    <th scope="col" align="center"><p>Comprobado</p></th>
    <th scope="col" align="center"><p>Aclarado</p></th>
    <th scope="col" align="center"><p >Monto PO</p></th>
  </tr>
  <tr>
  	<td class="RS_cantidad" rowspan="2" width="200" align="center" style="text-align:center"> 
   	<span style="font-weght:bold; font-size:16px;" > <?php echo number_format($monto_PO,2)  ?> </span></td>
    <td width="200" align="center"><p><center><br /><?php echo number_format($monto_PO_modificado,2) ?></p></td>
    <td width="200" align="center"><p><center><?php echo number_format($monto_resarcido,2) ?></p></td>
    <td width="200" align="center"><p><center><?php echo number_format($monto_justificado,2) ?></p></td>
    <td width="200" align="center"><p><center><?php echo number_format($monto_comprobado,2) ?></p></td>
    <td width="200" align="center"><p><center><?php echo number_format($monto_aclarado,2) ?></p></td>
    
    <?php if($monto_PO_modificado !=0){ ?>
    <td width="200" align="center" rowspan="2" width="200" align="center" style="text-align:center"> 
    	<span style="font-weght:bold; font-size:16px;" > <?php echo number_format($TotPO_modificado,2) ?> </span>  
        
    </td> <?php }else {?>
        <td width="200" align="center" rowspan="2" width="200" align="center" style="text-align:center"> 
    	<span style="font-weght:bold; font-size:16px;" > <?php echo number_format($TotPO,2) ?> </span>  
    </td><?php }?>

  </tr>


   <tr>
    <td ><?php if($monto_PO_modificado == 0) {?><div style="margin:0 30px" class="submit_line redonda3" id='RS_montoModificado' onclick="muestraNvoMonto('modificado')">Modificar</div> <?php } ?></td>
    <td ><?php if($monto_resarcido == 0) {?><div style="margin:0 30px" class="submit_line redonda3" id='RS_montoResarcido' onclick="muestraNvoMonto('resarcido')">Modificar</div> <?php } ?></td>
    <td ><?php if($monto_justificado == 0){ ?><div style="margin:0 30px" class="submit_line redonda3" id='RS_montoResarcido' onclick="muestraNvoMonto('justificado')">Modificar</div> <?php } ?></td>
    <td ><?php if($monto_comprobado == 0) {?><div style="margin:0 30px" class="submit_line redonda3" id='RS_montoResarcido' onclick="muestraNvoMonto('comprobado')">Modificar</div> <?php } ?></td>
    <td ><?php if($monto_aclarado == 0) {?><div style="margin:0 30px" class="submit_line redonda3" id='RS_montoResarcido' onclick="muestraNvoMonto('aclarado')">Modificar</div> <?php } ?></td>
  </tr>

  <tr>

  <td> <br />  </td>
  <td> <br />  </td>
            <tr>
            <br />

  </tr>
</table>
<input type="hidden" name="RS_num_accion" id="RS_num_accion" value="<?php echo $accion ?>" /> 
<input type="hidden" name="RS_direccion" id="RS_direccion" value="<?php echo $dir ?>" /> 
<!-- cambia montos -->


</body>
</html>
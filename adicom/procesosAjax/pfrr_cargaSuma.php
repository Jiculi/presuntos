<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE cont = ".$_REQUEST['idPresuntop']." ",true);
$r = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
$sqlPo = $conexion->select("SELECT detalle_edo_tramite FROM pfrr WHERE num_accion = '".$_REQUEST['numAccion']."' ",false);
$rPo = mysql_fetch_array($sqlPo);
/*
if($rPo['detalle_de_estado_de_tramite'] >= 6 ) $soloLectura = "readonly";
else $soloLectura = "";
*/
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
/*
if(cambioEstado($_REQUEST['numAccion'],15)) 
{
	//echo "editable";	
}
else 
{
	echo "<script> $$('#presunto_MOD_pfrr input').attr('disabled', true) </script>";
	echo "<script> $$('#presunto_MOD_pfrr textarea').attr('disabled', true) </script>";
	echo "<script> $$('#presunto_MOD_pfrr button').attr('disabled', true) </script>";
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script type="text/javascript" src="js/funciones.js"></script>
<style>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

</head>

<body>

<?php 
$montoI = str_replace(",","",dameMontoInicialPFRR($_REQUEST['numAccion']));
$montoI = str_replace("$","",$montoI);

$montoPR = str_replace(",","",$r['monto']);
$montoPR = str_replace("$","",$montoPR);

$montoA = str_replace(",","",$r['monto_aclarado']);
$montoA = str_replace("$","",$montoA);

$montoR = str_replace(",","",$r['resarcido']);
$montoR = str_replace("$","",$montoR);
$sread = ($montoR != "" || $montoR != 0) ? "disabled" : "";

$interesesD = str_replace(",","",$r['interesesDano']);
$interesesD = str_replace("$","",$interesesD);

$intereses = str_replace(",","",$r['intereses_resarcidos']);
$intereses = str_replace("$","",$intereses);
$iread = ($montoR != "" || $montoR != 0) ? "disabled" : "";


$suma = $montoPR - $montoA - $montoR;
$sumai = $interesesD - $intereses;

$total = $suma + $sumai;
$depos = $montoR + $intereses;

$idPresuntop = $_REQUEST['idPresuntop'];

$sqlx = $conexion->update("UPDATE pfrr_presuntos_audiencias
						  SET 
							  importe_frr = '".$total."'
						  WHERE cont= ".$idPresuntop." ",false);
?>

          <table width="100%" align="right">
              <tr>
              	<td><h3>Daño / Perjuicio</h3></td>
              </tr>
              
              
              <tr>
              	<td>Importe Daño PR:  </td> <td align="right"> + <?php echo @number_format($montoPR,2) ?> </td>
              </tr>
              <tr>
              	<td>Importe Aclarado:</td> <td align="right"> - <?php echo @number_format($montoA,2); ?> </td>
              </tr>
              <tr>
              	<td>Importe Reintegrado: </td> <td align="right"> - <?php echo @number_format($montoR,2); ?> </td>
              </tr>

              <tr>
              	<td colspan="2" align="right"> <hr /> </td>
              </tr>
              <tr>
              	<td>SUBTOTAL:  </td> <td align="right"> <?php echo @number_format($suma,2); ?> </td>
              </tr>
          </table>

          <table width="100%" align="right">
              <tr>
              	<td><br /><br /> <h3>Intereses</h3></td>
              </tr>
              <tr>
              	<td>Intereses del Daño:  </td> <td align="right"> + <?php echo @number_format($interesesD,2); ?> </td>
              </tr>
              <tr>
              	<td>Intereses Cubiertos:  </td> <td align="right"> - <?php echo @number_format($intereses,2); ?> </td>
              </tr>
              <tr>
              	<td colspan="2" align="right"> <hr /> </td>
              </tr>
              <tr>
              	<td>SUBTOTAL:  </td> <td align="right"> <?php echo @number_format($sumai,2); ?> </td>
              </tr>
          </table>

          <table width="100%" align="right">
              <tr>
              	<td><br /><br /> <h3> </h3></td>
              </tr>
              <tr>
              	<td colspan="2" align="right"> <hr /> </td>
              </tr>
              <tr>
              	<td><h3> Importe<br /> Reintegrado: </h3> </td> <td align="right" valign="middle"> $ <?php echo @number_format($depos,2) ?> </td>
              </tr>
              <tr>
              	<?php 
					if($total < 0) $txtTotal = "<span style='color:red'> ".@number_format($total,2)." </span>";
					else $txtTotal = "<span style='color:black'> ".@number_format($total,2)." </span>";
				?>
              	<td><h3> TOTAL FRR: </h3> </td> <td align="right" valign="middle"><b>$<?php echo $txtTotal  ?></b> </td>
              </tr>
          </table>
          <?php //print_r($_REQUEST) ?>

</body>
</html>
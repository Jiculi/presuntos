<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//--------------------------------------------------------------------------------------------------------------
if(isset($_SESSION['userDireccion'])) $dir = $_SESSION['userDireccion'];
else  $dir = $_REQUEST['RS_direccion'];

$accion=valorSeguro($_REQUEST['RS_accion']);

if($_REQUEST['RS_formulario'] == 'formNvoMonto')
{
	$sql1 = $conexion->select("SELECT * FROM po_montos WHERE num_accion = '".$accion."' ");
	echo "\n - Numero de rows: ".
	$tMon = mysql_num_rows($sql1);
	echo " \n ";
	
	if($tMon == 0) $sql1 = $conexion->insert("INSERT INTO po_montos SET num_accion = '".$accion."' ");

	if($_REQUEST['RS_tipo'] == 'modificado') $sql = "UPDATE po SET monto_modificado = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	if($_REQUEST['RS_tipo'] == 'resarcido') $sql = "UPDATE po_montos SET monto_resarcido = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	if($_REQUEST['RS_tipo'] == 'justificado') $sql = "UPDATE po_montos SET monto_justificado = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	if($_REQUEST['RS_tipo'] == 'comprobado') $sql = "UPDATE po_montos SET monto_comprobado = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	if($_REQUEST['RS_tipo'] == 'aclarado') $sql = "UPDATE po_montos SET monto_aclarado = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	if($_REQUEST['RS_tipo'] == 'intereses') $sql = "UPDATE po_montos SET intereses = '".str_replace(",","",$_REQUEST['RS_cantidad'])."'  WHERE num_accion = '".$accion."' ";
	$exe = mysql_query($sql) or die(mysql_error()."<br>".$sql);	
	unset($_REQUEST['RS_formulario']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

</script>
</head>

<body>
<div id='RS_cambiaMontos'>
	<center>
    <form method="post" name="form_nuevo_monto" id="form_nuevo_monto" action='#' onSubmit="return false">
    <table width="40%" border="0" cellspacing="0" cellpadding="0" class="RS_tabla_ajax" align="center">
      <tr>
        <th colspan="8" scope="col"><h4 class="RS_tit"> <br /><br /></h4></th>
      </tr>
    
      <tr>
        <td scope="col" colspan="2"><b>Cantidad: </b></td>
        <td><input type="text" class="redonda3" name="RS_cantidad" id="RS_cantidad" onChange="cambiaNum('RS_cantidad')" /></td>
      </tr>
      <tr>
        <td colspan="5">
        	<center>
                <input type="hidden" name="RS_accion" id="RS_accion" value="<?php echo $accion ?>" /> 
                <input type="hidden" name="RS_tipo" id="RS_tipo" value="<?php echo $_REQUEST['tipo'] ?>" /> 
                <input type="hidden" name="RS_formulario" id="formNvoMonto" value="formNvoMonto" /> 
                <br />
                <input type="button"  class="submit_line redonda3" alt="Ver Oficios" value="Actualizar Cantidad" onclick="actualizaMonto('<?php echo $_REQUEST['tipo'] ?>')" name="Actualizar registro" id="RS_nvoMonto" class='RS_form_boton'>
            </center>
        </td> 
      </tr>
    </table>
    </form>
    </center>
</div>

</body>
</html>

<script>
$$( "#fecha_de_cargo_inicio_n" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });


$$( "#fecha_de_cargo_final_n" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });

</script>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
error_reporting(E_ERROR);
$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM po_presuntos WHERE creacion = ".$_REQUEST['idPresunto']." ",true);
$r = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
$sqlPo = $conexion->select("SELECT detalle_de_estado_de_tramite FROM po WHERE num_accion = '".$_REQUEST['numAccion']."' ",false);
$rPo = mysql_fetch_array($sqlPo);

//if($rPo['detalle_de_estado_de_tramite'] >= 6 ) $soloLectura = "readonly";
//else $soloLectura = "";
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
<form action="<?php echo $editFormAction; ?>" method="POST" name="presunto_MOD" id="form1">
  <table width="107%" weight="100%" align="center" class="tablaPasos ">
                 <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td width="600" >
                  <select  class="redonda5" id="tipoPresunto"  name="tipoPresunto" >
                  	<option value="">Seleccione tipo de Presunto...</option>
                    <option value="presuntoResponsable" <?php echo $checkPR; ?>>Servidor Público</option>
                    <option value="proveedor" <?php echo $checkP; ?>>Proveedor</option>
                    <option value="contratista" <?php echo $checkC; ?>>Contratista</option>
                  </select>
                  
                  </td>
                  
                </tr>

    <tr valign="baseline">
      <td class="etiquetaPo">Nombre: </td>
      <td ><input  type="text"  class="redonda5" id="servidor_contratista"  name="servidor_contratista" value="<?php echo $r['servidor_contratista']; ?>" size="100" <?php echo  $soloLectura ?>></td>
     
    </tr>
    <tr>
      <td width="155" class="etiquetaPo">Cargo durante el periodo de la irregularidad:</td>
      <td><input  type="text"  class="redonda5" id="cargo_servidor" name="cargo_servidor" value="<?php echo $r['cargo_servidor']; ?>" size="100" <?php echo  $soloLectura ?>></td>
      
    </tr>
                    <tr>
                  <td class="etiquetaPo">Fecha del Cargo:</td>
                  <td> Del <input class="redonda5" id="fecha_de_cargo_inicio_n" name="fecha_de_cargo_inicio_n" type="text" value='<?php echo fechaNormal($r['fecha_de_cargo_inicio']) ?>' readonly> Al <input class="redonda5" id="fecha_de_cargo_final_n" name="fecha_de_cargo_final_n" type="text" value='<?php echo fechaNormal($r['fecha_de_cargo_final']) ?>' readonly></td>
                </tr>


<tr >
      <td class="etiquetaPo">Acción/Omisión:</td>
      <td>
      <textarea class="redonda5" id="irregularidad" name="irregularidad" cols="97" rows="4" onKeyDown="contador(this.form.irregularidad, 'cuenta', 450)" onKeyUp="contador(this.form.irregularidad, 'cuenta', 1000)"  <?php echo  $soloLectura ?>><?php echo $r['irregularidad'] ?></textarea> 
    </tr>

        <tr>
      <td class="etiquetaPo">Normatividad Infringida:</td>
      <td><textarea  class="redonda5" id="norma" name="norma" cols="97" rows="4" >  <?php echo $r['normatividad_infringida']; ?></textarea></td>
      
      </tr>
      
      <tr>
        <td class="etiquetaPo">Fecha de Irregularidad:</td>
      <td><textarea   class="redonda5" id="fechairre" name="fechairre" cols="97"  rows="4" ><?php echo $r['fecha_de_irregularidad']; ?> </textarea> </td>
      
      </tr>
  
    
    <tr >
      <td class="etiquetaPo">Monto:</td>
      <td><label for="monto"></label> 
      <input name="nuevo_monto"  type="text"  class="redonda5"  id="nuevo_monto" value="<?php echo number_format($r['monto'],2);  ?>" <?php echo  $soloLectura ?>></td>
     
   
        
    </tr>
    <tr >
      <td class="center" colspan="3">
      <center><br /><br />
      <?php if($rPo['detalle_de_estado_de_tramite'] < 300 ) {?>
      	<input type="button"  class="submit-login"  value="Actualizar Presunto" onClick="actualizaPresunto('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">
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
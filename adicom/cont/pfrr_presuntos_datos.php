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
$sqlPo = $conexion->select("SELECT entidad,	detalle_edo_tramite FROM pfrr WHERE num_accion = '".$_REQUEST['numAccion']."' ",false);
$rPo = mysql_fetch_array($sqlPo);
//-------------------------------------------------------------------------------
if(cambioEstado($_REQUEST['numAccion'],500)) 
{
	//echo "editable";	
}
else 
{
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
$$(function() {

	$$( "#fecha_accion_omision1" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	
	
		$$( "#fecha_accion_omision2" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
       // $$( "#fecha_accion_omision1" ).datepicker( "option", "minDate", selectedDate );
      }
    });


		$$( "#pres_accion_omision" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision2" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

		$$( "#fecha_dep_monto" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision2" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

		$$( "#fecha_dep_int" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
      //  $$( "#fecha_accion_omision2" ).datepicker( "option", "maxDate", selectedDate );
      }
    });


});
</script>
<script type="text/javascript" src="js/funciones.js"></script>
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

<div class=" ">
    <div class="left divPresuntos redonda5">
        <form enctype="multipart/form-data" action="#" method="POST" name="presunto_MOD_pfrr" id="presunto_MOD_pfrr">
          <table width="100%" align="center" class="tablaPasos " >
        
            <tr valign="baseline">
              <td class="etiquetaPo" width="250">Nombre: </td>
              <td class="etiquetaPO" > <?php echo $r['nombre']; ?></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="etiquetaPo">Cargo:</td>
              <td> <?php echo $r['cargo']; ?> <br/>
			  <input class="redonda5" name="cargo"  type="text"  class="cargo"  id="cargo" value="<?php echo $r['cargo']; ?>" />
			  </td>
        <td></td>
              <td></td>    </tr>
            <tr >
            
                <tr >
              <td class="etiquetaPo">RFC:</td>
              <td><label for="rfc"></label>
              <input class="redonda5"name="rfc"  type="text"  class="rfc"  id="rfc" value="<?php echo $r['rfc']; ?>" /></td>
        <td></td>
              <td></td>    </tr>
              
                      <tr >
              <td class="etiquetaPo">Dependencia:</td>
              <td><label for="rfc"></label>
              <input class="redonda5"name="dependencia"  type="text"  class="dependencia"  id="dependencia" value="<?php echo $r['dependencia']; ?>" size="40" /></td>
        <td></td>
              <td></td>    </tr>
        
            
            
                    <tr >
                    
              <td class="etiquetaPo">Domicilio:</td>
              <td colspan="3">
              <textarea class="redonda5" id="domicilio" name="domicilio" cols="60" rows="4" onKeyDown="contador(this.form.domicilio, 'cuenta', 100)" onKeyUp="contador(this.form.domicilio, 'cuenta', 100)"   ><?php echo $r['domicilio']; ?></textarea>
               <br />Le restan <span style="font-weight:bold" id='cuenta'>100</span> caracteres.</td>
           <td></td>
              <td></td>
            </tr>
        
        
              <td class="etiquetaPo">Acción/ Omisión:</td>
              
              <td colspan="3">
              <textarea class="redonda5" id="accion_omision" name="accion_omision" cols="60" rows="4" onKeyDown="contador(this.form.irregularidad, 'cuenta', 450)" onKeyUp="contador(this.form.irregularidad, 'cuenta', 450)"  ><?php echo $r['accion_omision']; ?></textarea>
               <br />Le restan <span style="font-weight:bold" id='cuenta'>450</span> caracteres.</td>
            </tr>
            <tr >
              <td class="etiquetaPo">Fecha Acción/Omisión:</td>
              <td colspan="3"><label for="fecha_accion_omision"></label>
              <input  id="fecha_accion_omision1" name="fecha_accion_omision1" type="text"  class="redonda5" value='<?php echo fechaNormal($r['fecha_accion_omision_1']); ?>' size = "12" readonly/><a href="#" onClick="getElementById('fecha_accion_omision1').value=''"> </a>       
               al 
              <input  id="fecha_accion_omision2" name="fecha_accion_omision2" type="text"  class="redonda5" value='<?php echo fechaNormal($r['fecha_accion_omision_2']); ?>' size = "12" readonly/><a href="#" onClick="getElementById('fecha_accion_omision2').value=''"> </a></td>
			 </tr>
             <tr>
              <td class="etiquetaPo">Prescripción de la Acción/Omisión:</td>
              <td><label for="fecha_accion_omision"></label>
              <input  id="pres_accion_omision" name="pres_accion_omision" type="text"  class="redonda5" value='<?php echo fechaNormal($r['prescripcion_accion_omision']); ?>' size = "12" readonly/><a href="#" onClick="getElementById('pres_accion_omision').value=''"> </a> </td> 
        <td></td>
              <td></td>
            </tr>
			<tr>
              <td class="etiquetaPo">Monto: </td>
              <td><label for="monto"></label>
              <input  id="monto_pres" name="monto_pres" type="text"  class="redonda5" value='<?php echo $r['monto']; ?>' size = "12" /><a href="#" onClick="getElementById('resarcido').value=''"> </a> </td> 

            </tr>
        </table>
        	<input type="hidden" name="idPresunto" id="idPresunto" value="<?php echo $_REQUEST['idPresuntop'] ?>"  />
        	<input type="hidden" name="entidadAcc" id="entidadAcc" value="<?php echo  $rPo['entidad'] ?>"  />
        	<input type="hidden" name="estadoAcc" id="estadoAcc" value="<?php echo  dameEstado($rPo['detalle_edo_tramite']) ?>"  />
            
           
            <input type="button"  class="submit-login"  value="Actualizar Presunto" onclick="actualizaPresuntoPFRR('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>','<?php echo $r['nombre']; ?>')">
</form>
    </div>    

    <div style="clear:both">&nbsp;</div>    
</div>
    <center>
	</center>
</body>
</html>
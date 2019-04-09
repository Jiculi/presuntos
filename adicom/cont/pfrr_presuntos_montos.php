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
if(cambioEstado($_REQUEST['numAccion'],22)) 
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
	  //beforeShowDay: noLaborales,
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
	 // beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
      //  $$( "#fecha_accion_omision2" ).datepicker( "option", "maxDate", selectedDate );
      }
    });


});
</script>
<script type="text/javascript" src="js/funciones.js"></script>
<style>
	#cuadroRes2 { background:#FFF !important}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

</head>

<body>
<div  style="background:#FFF !important">
<center>

<div id='actualizaP2' style="line-height:normal"></div>
<?php 
//echo $_REQUEST['numAccion']." edo tra ".$rPo['detalle_de_estado_de_tramite'] 
if($r['tipo_presunto'] == "responsableInforme") $checkRI = "selected";
if($r['tipo_presunto'] == "titularICC") $checkICC = "selected";
if($r['tipo_presunto'] == "presuntoResponsable") $checkPR = "selected";
if($r['tipo_presunto'] == "proveedor") $checkP = "selected";
if($r['tipo_presunto'] == "contratista") $checkC = "selected";

$montoI = str_replace(",","",dameMontoInicialPFRR($_REQUEST['numAccion']));
$montoI = str_replace("$","",$montoI);

$montoPR = str_replace(",","",$r['monto']);
$montoPR = str_replace("$","",$montoPR);

$montoUAA = str_replace(",","",$r['monto_aclarado_uaa']);
$montoUAA = str_replace("$","",$montoUAA);

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

$montoPR = $montoI - $montoUAA;
?>
<script>
function inicioPFRR()
{
	var suma = parseFloat(document.getElementById('monto_po').value) - parseFloat(document.getElementById('monto_aclaradoUAA').value);
	document.getElementById('monto_dano').value = suma.toFixed(2);
}
</script>
  
<div id="presunto_MOD_pfrr" style="position:relative">
<table width="60%" align="left" class="tablaPasos " >
         <tr>
              <td width="200" class="etiquetaPo">Monto PO:</td>
              <td><label for="monto"></label>
              <input name="monto_po"  type="text"  class="redonda5"   id="monto_po" value="<?php echo $montoI ?>"  onchange="inicioPFRR()" readonly="readonly"></td>
			  <!--input name="monto_po"  type="text"  class="redonda5"   id="monto_po" value="<?php echo $montoI ?>"  onchange="inicioPFRR()" readonly="readonly"></td--->
                </td>
              
     
          </tr>

            <tr>
                  <td class="etiquetaPo">Importe Aclarado UAA:</td>
              <td><label for="monto"></label>
              <input name="monto_aclaradoUAA"  type="text"  class="redonda5"  id="monto_aclaradoUAA" value="<?php echo $montoUAA ?>"  onchange="inicioPFRR()">
             
              </tr>

         <tr>
              <td width="200" class="etiquetaPo"> Inicio PFRR: </td>
              <td><label for="monto"></label>
              <input name="monto_dano"  type="text"  class="redonda5" id="monto_dano" value="<?php echo $montoPR ?>"  onchange="formatoMoneda(this)"><!---readonly="readonly"---> </td>
     
          </tr>
            
            <tr >
            <tr>
                  <td class="etiquetaPo">Importe Aclarado DGR:</td>
              <td><label for="monto"></label>
              <input name="monto_aclarado"  type="text"  class="redonda5"  id="monto_aclarado" value="<?php echo $montoA ?>" onchange="formatoMoneda(this)">
             
              </tr>
            <tr >
        
              <td class="etiquetaPo">Importe Reintegrado:</td>
              <td><label for="monto"></label>
              <input name="monto_reintegrado"  type="text"  class="redonda5"  id="monto_reintegrado" value="<?php echo $montoR ?>"  onchange="formatoMoneda(this)"></td>
              <tr>
                <td class="etiquetaPo">Fecha de Depósito:</td>
              <td> <label for="monto"></label>
              <input name="fecha_dep_monto"  type="text"  class="redonda5"  id="fecha_dep_monto" value="<?php echo fechaNormal($r['fecha_deposito']); ?>" /></td>
              </tr>
              
             
           <tr>
               <td colspan="5" align="left">
                 <form style="margin:0; padding:0"  enctype="multipart/form-data" method="post" target="frame_subir2" name="subir_2" id="subir_2" action="procesosAjax/pfrr_subeFicha.php">
                 <span class="etiquetaP" style="width:200px">Ficha de Depósito <br />por el Importe Reintegrado: </span>
                 <input name="ficha" id="ficha2"  type="file" class="redonda5">
                 <input name="idPresuntoFicha"  type="hidden" value="<?php echo $r['cont']; ?>" class="redonda5">
                 <input name="numAcccionFicha"  type="hidden" value="<?php echo $_REQUEST['numAccion']; ?>"  class="redonda5">
                 <input name="tipoFicha"  type="hidden" value="Reintegrado"  class="redonda5">
              </form>
              <iframe name="frame_subir2" id="frame_subir2" width="100%" height="30" frameborder="0"> </iframe>
              <br /> 

    	      	<input type="button"  style="position:relative; top:-20px; left:153px"  class="submit-login"  value="Actualizar Importes" onclick="agregaDatosDano('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">

              <br />
              </td>
              </tr>        
            <td></tr>
            <tr>
        
              <td class="etiquetaPo">Intereses de Daño:</td>
              <td><label for="monto"></label>
              <input name="interesesDano"  type="text"  class="redonda5"  id="interesesDano" value="<?php echo @number_format($interesesD,2) ?>"  onchange="formatoMoneda(this)"  ></td>
              <td>
            </tr>
            <tr >
        
              <td class="etiquetaPo">Intereses Cubiertos:</td>
              <td><label for="monto"></label>
              <input name="intereses"  type="text"  class="redonda5"  id="intereses" value="<?php echo @number_format($intereses,2) ?>"  onchange="formatoMoneda(this)"></td>
              <td>
            </tr>  
                  <tr>
                  <td class="etiquetaPo">Fecha de Depósito:</span></td>
           <td><label for="monto"></label>
           <input name="fecha_dep_int"  type="text"  class="redonda5"   id="fecha_dep_int" value="<?php echo fechaNormal($r['fecha_deposito_intereses_resarcidos']); ?>" />
              </tr>  
              </td>
           
           <tr>
               <td colspan="5" align="left"><left>
                 <form style="margin:0; padding:0" enctype="multipart/form-data" method="post" target="frame_subir1" name="subir_1" id="subir_1" action="procesosAjax/pfrr_subeFicha.php">
                 <span class="etiquetaP">Ficha de Depósito <br />por los Intereses Cubiertos: </span>
                 <input name="ficha" id="ficha1"  type="file"  class="redonda5">
                 <input name="idPresuntoFicha"  type="hidden" value="<?php echo $r['cont']; ?>" class="redonda5">
                 <input name="numAcccionFicha"  type="hidden" value="<?php echo $_REQUEST['numAccion']; ?>"  class="redonda5">
                 <input name="tipoFicha"  type="hidden" value="Aclarado"  class="redonda5">
                 
                 </form>
   				 <iframe name="frame_subir1" id="frame_subir1" width="100%" height="30" frameborder="0"> </iframe>

                 <input type="button" style="position:relative; top:-20px; left:156px"  class="submit-login"  value="Actualizar Intereses" onclick="agregaDatosIntereses('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')">

                 </td>
            </tr>

              </td>
            </tr>
        
            </tr>
          </table>
             <input name="importe_frr"  type="hidden"  class="redonda5"  id="importe_frr" value="<?php echo $total ?>">
             <input name="fecha_registro" type="hidden" id="fecha_registro" value="<?php echo date ("Y-m-d");?>" />


          <!-- ---------------------------------------------------------->
          <div id='tablaSuma' style="float:right;width:250px; padding:10px 20px 0 0; font-size:14px;">
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
		 <br />
          <table width="100%" align="right">
              <tr>
              	<td><br /><br /> <h3>Intereses</h3></td>
              </tr>
              <tr>
              	<td>Intereses del Daño:  </td> <td align="right"> + <?php echo @number_format($interesesD,2); ?> </td>
              </tr>
              <tr>
              	<td>Intereses Cubiertos: </td> 
              	<td align="right"> - <?php echo @number_format($intereses,2); ?> </td>
              </tr>
              <tr>
              	<td colspan="2" align="right"> <hr /> </td>
              </tr>
              <tr>
              	<td>SUBTOTAL:  </td> <td align="right"> <?php echo @number_format($sumai,2); ?> </td>
              </tr>
          </table>
		<br />
          <table width="100%" align="right">
              <tr>
              	<td><br /><br /> <h3> </h3></td>
              </tr>
              <tr>
              	<td colspan="2" align="right"> <hr /> </td>
              </tr>
              <tr>
              	<td><h3>Importe<br /> Reintegrado: </h3> </td> <td align="right" valign="middle"> $ <?php echo @number_format($depos,2) ?> </td>
              </tr>
              <tr>
              	<?php 
					if($total < 0) $txtTotal = "<span style='color:red'> ".@number_format($total,2)." </span>";
					else $txtTotal = "<span style='color:black'> ".@number_format($total,2)." </span>";
				?>
              	<td><h3> TOTAL FRR: </h3> </td> <td align="right" valign="middle"><b>$<?php echo $txtTotal  ?></b> </td>
              </tr>
          </table>
          </div>
          <input name="cont" type="hidden" id="cont" value="<?php echo $r['cont']; ?>">
        <!-- </form> -->
   		<div style="clear:both"></div>
   </div>    

   <div style="width:500px"> 
    <center>
	</center>
   </div>
   
 </div>
</body>
</html>
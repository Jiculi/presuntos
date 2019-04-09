<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------
$idAud = 			valorSeguro($_REQUEST['idAud']);
$accion = 			valorSeguro($_REQUEST['accion']);
$idPresunto = 		valorSeguro($_REQUEST['idPresunto']);
$usuario = 			valorSeguro($_REQUEST['usuario']);
$oficio = 			valorSeguro($_REQUEST['oficio']);
$tipoDeFecha = 		valorSeguro($_REQUEST['tipoDeFecha']);
$ultimaFecha = 		valorSeguro($_REQUEST['ultimaFecha']);
$tipoAudiencia =	valorSeguro($_REQUEST['tipoAudiencia']);
//------------------------------------------------------------------------------
// datos del presunto
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias  WHERE cont = ".$idPresunto." ",true);
$pre = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
if($idAud != "")
{
	// datos dela audiencia
	$sql = $conexion->select("SELECT * FROM pfrr_audiencias  WHERE id = ".$idAud." ",true);
	$aud = mysql_fetch_array($sql);
}
//------------------------------------------------------------------------------
// fecha de oficio citatorio en OFICIOS
$sql=$conexion->select("SELECT folio, fecha_oficio FROM oficios WHERE tipo='citatorio_PFRR' AND num_accion LIKE  '%".$accion."%' AND destinatario = ".$idPresunto." AND juridico='1' AND status <> 0 ORDER BY fecha_oficio desc limit 1"); 
$ofi = mysql_fetch_array($sql);
$nOf = mysql_num_rows($sql);
$ofiCitatorio = $ofi['folio'];
$ofiFecha = fechaNormal($ofi['fecha_oficio']);
//------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
/*------------------------------- pagina volantes --------------------------------*/
#pfrrDiv .nomSis{ color:#390 !important}
#pfrrDiv h3{color:#390 !important}
#pfrrDiv .pasosActivo{ 
	display:inline-block; 
	padding:5px 12px;
	height:25px;  
	cursor:pointer;
	line-height:25px; 
	background:#390 !important;
	font-weight:bold;  
	color:#EEE;}
#pfrrDiv textarea:focus,textarea:hover,input[type="text"]:hover, input[type="text"]:focus,select:hover,select:focus 
{border: 1px solid #390 !important;}
/*#pagVolantes .submit-login{ background:#F0F !important}*/
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:10px 0;
	}
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:10px 0;
	}
	
#pfrrDiv #product-table tr:hover { background:#CBFF97 !important; }
.tablaInfo .etiquetaInfo {border: 1px solid #390 !important; color:#390}
/* .contVolantes{border: 2px solid #F0F !important;} */
/* .pasos{ background:#F39 !important} */

#pfrrDiv #related-act-top	{
	/*background:url(../images/forms/header_related_act.gif);*/
	background:#390 !important;
	width:260px;
	height:43px;
	margin:10px auto 0 auto;
	-moz-border-radius: 8px 8px 0px 0px ;
    -webkit-border-radius: 8px 8px 0px 0px ;
    border-radius: 8px 8px 0px 0px ;
	
	}
#pfrrDiv .pfAccesible{background:#390 !important;}
/*------------------------------- pagina oficios --------------------------------*/
#pfrrDiv .camposAcciones{border:1px dotted #666666; padding:20px 50px; margin:10px; height:300px; overflow:auto}
#pfrrDiv .camposLi{list-style:url(../images/OK20.png); margin:5px; position:relative }
#pfrrDiv .camposInputAcciones{}
#pfrrDiv .eliminarInput{ display:inline-block; cursor:pointer; position:relative; background:url(../images/cross.png); height:16px; width:16px; left:-25px; z-index:100}
</style>
<script>
// fechas -----------------------------------------
$$( document ).ready(function(){
	
	
	$$( "#fecha_oficio_cit" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  /*<?php if($nOf == 0 ) { ?>
	 	 minDate: 0,
	  <?php } else { ?>	
	  	//minDate: "01/06/2018",
	  //beforeShowDay: noLaborales,
	  <?php } ?>	*/
      onClose: function( selectedDate ) {
        $$( "#fecha_citacion" ).datepicker( "option", "minDate", selectedDate );
      }
    });

	$$( "#fecha_noti_cit" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  /*<?php if($nOf == 0 ) { ?>
	 	 minDate: 0,
	  <?php } else { ?>	
	  	//minDate: "01/06/2018",
	  //beforeShowDay: noLaborales,
	  <?php } ?>	*/
      onClose: function( selectedDate ) {
        $$( "#fecha_citacion" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	
	$$( "#fecha_citacion" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fechaContinuacion" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: restaNolaborables('<?php echo $ultimaFecha ?>',0),	
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
	  
    });
	
	$$( "#oficioDif" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: '<?php echo $ultimaFecha ?>',
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fechaDif" ).datepicker( "option", "minDate", selectedDate );
      //}
    });
	
	$$( "#oficioAcuseDif" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: restaNolaborables('<?php echo $ultimaFecha ?>',1),
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	$$( "#fechaDif" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: restaNolaborables('<?php echo $ultimaFecha ?>',1),
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
//
});
//
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div id='pfrrDiv'>
<!--------------------------  VARIABLES GENERALES ---------------------------->
<!---------------------------------------------------------------------------->
 <input name='idAudiencia'  type='hidden'  class='redonda5'  id='idAudiencia' value='<?php echo $idAud; ?>' />
 <input name='idFpresunto'  type='hidden'  class='redonda5'  id='idFpresunto' value='<?php echo $idPresunto; ?>' />
 <input name='nomPresunto'  type='hidden'  class='redonda5'  id='nomPresunto' value='<?php echo $pre['nombre']; ?>' />
 <input name='carPresunto'  type='hidden'  class='redonda5'  id='carPresunto' value='<?php echo $pre['cargo']; ?>' />
 <input name='depPresunto'  type='hidden'  class='redonda5'  id='depPresunto' value='<?php echo $pre['dependencia']; ?>' />
 <input name='rfcPresunto'  type='hidden'  class='redonda5'  id='rfcPresunto' value='<?php echo $pre['rfc']; ?>' />
 <input name='accPresunto'  type='hidden'  class='redonda5'  id='accPresunto' value='<?php echo $accion ?>' />
 <input name='audOficio'  type='hidden'  class='redonda5'  id='audOficio' value='<?php echo $oficio ?>' />
 <input name='fecOficio'  type='hidden'  class='redonda5'  id='fecOficio' value='<?php echo $aud['fecha_oficio_citatorio'] ?>' />
 <input name='usuarioAud'  type='hidden'  class='redonda5'  id='usuarioAud' value='<?php echo $usuario ?>' />
<!---------------------------------------------------------------------------->
<!---------------------------------------------------------------------------->

<?php if ($tipoDeFecha == "fechaCitatorio") {
			//funcion q evalua el estado actual de la accion y el estado ultimo que se encontro del presunto
			//if(cambioEstado($accion,16)) $cambiaEdo = 1; 
			//else $cambiaEdo = 0;
			 $cambiaEdo = 1; 
?>
    <div id="pes2">

		<?php if($nOf == 0 ) { ?>
        <div id="message-red">
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="red-left">
                       Este presunto no cuenta con oficio citatorio... <a href="?cont=pfrr_oficios">Si no lo ha creado haga click aqui para crearlo</a>
                    </td>
                    <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=" $$('#message-red').slideUp() "  alt="" /></a></td>
                </tr>
            </table>
        </div>
        <?php } // fin nOf ?>

        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Fecha de Citación  </h3>
        
        <center> 

	<!--  FECHA DE AUDIENCIA ------------------------------------------------------------------- -->
        <form method="POST" name="presunto_guarda_pfrr" id="presunto_guarda_pfrr">
          <table width="100%" align="center" class="tablaPasos " >
       	 <input type="hidden" name="num_accion" value="<?php echo $accion ?>" id="num_accion" />
             <tr><td class="etiquetaPo">Nombre: </td><td class="etiquetaPO" > <?php echo $pre['nombre']; ?></td> </tr>
             <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $pre['cargo']; ?></td></tr>
             <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $pre['rfc']; ?></td> </tr>
            <tr > <td class="etiquetaPo">Dependencia:</td> <td class "etiquetaPo"><?php echo $r['dependencia']; ?></td> </tr>
            <tr >
        
              <td class="etiquetaPo">Oficio Citatorio:</td>
              <td><label for="oficio_citatorio"></label>
              <input name="oficio_citatorio"  type="text" size="30" class="redonda5"  id="oficio_citatorio" value="<?php echo $ofiCitatorio  ?>"  <?php echo $disabled  ?>></td>
            </tr>
            <tr >
              <td class="etiquetaPo">Fecha del Oficio:</td>
              <td><label for="monto"></label>
              <input name="fecha_oficio_cit"  type="text"  class="redonda5"  id="fecha_oficio_cit" value="<?php echo $ofiFecha  ?>" <?php echo $disabled  ?>></td>
            </tr>
            <tr >
              <td class="etiquetaPo">Fecha de Notificación:</td>
              <td><label for="monto"></label>
              <input name="fecha_noti_cit"  type="text"  class="redonda5"  id="fecha_noti_cit" value="<?php echo $ofiNotificacion ?>"  <?php echo $disabled  ?>></td>
            </tr>
            <tr >
              <td class="etiquetaPo">Tipo de Notificación:</td>
              <td>          <select name='tipo_noti' id='tipo_noti' class="redonda5 inFec" <?php echo $disabled  ?>>
                    <option value="" selected="selected">Elegir</option>
                    <option value="Personal" <?php echo $per  ?>>Personal</option>
                    <option value="Instructivo" <?php echo $ins  ?>>Instructivo</option>
                    <option value="Edicto" <?php echo $edi  ?>>Edicto</option>
                  </select>
            </td>
            </tr>
            <tr >
              <td class="etiquetaPo">Fecha de Citación:</td>
              <td><label for="fecha_citacion"></label>
              <input name="fecha_citacion"  type="text"  class="redonda5"  id="fecha_citacion" value="<?php echo $fechaAudiencia ?>"  <?php echo $disabled  ?>></td>
            </tr>
            <tR>
              <td class="center" colspan="3">
              <center><br /><br />
                <input type="button"  class="submit-login"  value="Guardar Citatorio" onclick="fechadeCitatorio('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>','<?php echo $cambiaEdo ?>')">
              </center>
              </td>
            </tr>
          </table>
        </form>
        </center>
        </div>
<?php } ?>


<?php
if ($tipoDeFecha == "confirmacion") 
{
	//if(cambioEstado($accion,17)) $cambiaEdo = 1; 
	//else $cambiaEdo = 0;
	$cambiaEdo = 1; // cambia estado siempre
	
	echo "<br><center><h3>La audiencia del dia ".$ultimaFecha." con oficio ".$oficio." <br> de la accion ".$accion." esta pendiente. </h3></center>";
	echo "<br><center><h3>El presunto ".$pre['nombre']." </h3></center>";
	echo "<br><center><h3> ¿Compareció a la audiencia? </h3></center>";
	
	echo "
		<center> <br> 
		<input type='button' value='Sí Compareció' class='submit_line' onclick=\"pendientesAUD(1,'".$accion."','".$cambiaEdo."','".$ultimaRonda."','".$ultimaFecha."','".$_REQUEST['usuario']."','".$_REQUEST['idPresunto']."','".$tipoAudiencia."',$idAud)\" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='button' value='No Compareció' class='submit_line' onclick=\"pendientesAUD(0,'".$accion."','".$cambiaEdo."','".$ultimaRonda."','".$ultimaFecha."','".$_REQUEST['usuario']."','".$_REQUEST['idPresunto']."','".$tipoAudiencia."',$idAud)\" />  </center>
		";
}
?>

<?php if ($tipoDeFecha == "fechaDiferimiento") {?>
	<!--  DIFERIMIETO ------------------------------------------------------------------- -->
    <div id="pes2">

        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Oficio y fecha de diferimiento   </h3>
        
        <center> 
        <form name="formDiferimiento">
        <table class='feDif' width='100%' align='center'>
         <tr><td class="etiquetaPo" width="200">Nombre: </td><td class="etiquetaPO" > <?php echo $pre['nombre']; ?></td> </tr>
         <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $pre['cargo']; ?></td></tr>
         <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $pre['rfc']; ?></td> </tr>
         <tr><td class='etiquetaPo'>Fecha de Acuse de Solicitud de Diferimiento:</td><td> <input name='oficioAcuseDif'  type='text'  class='redonda5'  id='oficioAcuseDif' value=''> </td> </tr>
         <!--
         <tr><td class='etiquetaPo'>Fecha Solicitud de Diferimiento:</td><td> <input name='oficioDif'  type='text'  class='redonda5'  id='oficioDif' value=''> </td> </tr>
         -->
         <tr><td class='etiquetaPo'>Fecha Direfimiento:</td><td> <input name='fechaDif'  type='text'  class='redonda5'  id='fechaDif' value='' readonly='readonly'> </td> </tr>
         <tr><td colspan='2'> <br><br> <center> 
         <input type='button' value='Guardar Fecha Diferimiento' class='submit_line' onclick="fechaDiferimiento('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>',1,<?php echo $_REQUEST['idAud'] ?>)" /> 
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <input type='button' value='No Comparecio' class='submit_line' onclick="fechaDiferimiento('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>',0,<?php echo $_REQUEST['idAud'] ?>)" /> </center> </td> </tr>
         </center> 
         </td> </tr>
        </table>
        </form>
        </center>
        <br /><br />

     </div>
<?php } ?>
<?php if ($tipoDeFecha == "fechaContinuacion") {?>
	<!--  CONTINUACION ------------------------------------------------------------------- -->
    <div id="pes3">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Fecha de Continuación   </h3>
        
        <center>
        <form name="formContinuacionX">
        <table class='feDif' width='80%' align='center'>
         <tr><td class="etiquetaPo">Oficio Citacion Anterior: </td><td class="etiquetaPO" ><?php echo $oficio; ?></td> </tr>
         <tr><td class="etiquetaPo">Fecha Citacion Anterior:</td><td class "etiquetaPo"> <?php echo fechaNormal( $aud['fecha_audiencia']) ?></td></tr>
         <tr><td class="etiquetaPo">Nombre: </td><td class="etiquetaPO" > <?php echo $pre['nombre']; ?></td> </tr>
         <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $pre['cargo']; ?></td></tr>
         <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $pre['rfc']; ?></td> </tr>
         <!-- <tr><td class='etiquetaPo'>Oficio Citatorio:</td><td> <input name='oficioContinuacion'  type='text'  class='redonda5'  id='oficioContinuacion' value=''> </td> </tr> -->
         <tr><td class='etiquetaPo'>Fecha Continuacion:</td><td> <input name='fechaContinuacion'  type='text'  class='redonda5'  id='fechaContinuacion' value='' readonly='readonly'> </td> </tr>
         <input name='oficioAnterior'  type='hidden'  class='redonda5'  id='oficioAnterior' value='<?php echo $oficio; ?>' readonly='readonly'>
         <input name='fechaAnterior'  type='hidden'  class='redonda5'  id='fechaAnterior' value='<?php echo $aud['fecha_audiencia'] ?>' readonly='readonly'>
         <tr><td colspan='2'> <br><br> <center> 

         <input type='button' value='Guardar Fecha de Continuación' class='submit_line' onclick="fechaDeContinuacion('<?php echo $_REQUEST['numAccion'] ?>','<?php echo $_REQUEST['usuario'] ?>','<?php echo $_REQUEST['direccion'] ?>')" /> </center> </td> </tr>
        </table>
        </form>
        </center>
        <br /><br />
     </div>
<?php } ?>
	
</div> <!-- #pfrrDiv  -->
</body>
</html>
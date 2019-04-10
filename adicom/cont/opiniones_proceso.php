<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
//------------------------------------------------------------------------------

//-------------------------- BUSCAMOS DATOS DE LA ACCION -----------------------
$sql1 = $conexion->select("SELECT * FROM opiniones WHERE num_accion='".$accion."' ",false);
$a = mysql_fetch_array($sql1);

//------------------------------------------------------------------------------?>

<html>
<head>
<script>
//--------------- MENU CONF ----------------------------
r(function(){
	r('#mMedios>li').hover(
		function(){
		r('.menu_Medios',this).stop(true,true).slideDown();
		},
		function(){
		r('.menu_Medios',this).slideUp();
		}
	);
 
});
$$(function() {

	$$( "#fecha_rec_act" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	//-----	FECHA DE OFICIOS DE REQUISICION DE INFO
	/*
	$$( "#fecha_oficio_req" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 //minDate: fechaMinimaRec,
	 beforeShowDay: noLaborales,
     onClose: function( selectedDate ) {
        $$( "#fecha_acuse_oficio_req" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	*/
	
	$$( "#fecha_acuse_oficio_req" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: "01/08/2018",
	  //maxDate: "31/08/2018",
	 beforeShowDay: noLaborales,
     /*
	  onClose: function( selectedDate ) {
        $$( "#fecha_oficio_req" ).datepicker( "option", "maxDate", selectedDate );
      }
	  */
    });
});
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
$$(document).ready(function(){
  //---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
  $$("#btnEdo33").click(function(){

	  	var datosUrl = "&accion="+$$("#accion").val()+"&oficio_req="+$$("#oficio_req").val()+"&fecha_oficio_req="+$$("#fecha_oficio_req").val()+"&fecha_acuse_oficio_req="+$$("#fecha_acuse_oficio_req").val()+"&tipo= 102";
		
		if(comprobarForm("formOpiAsis"))
		{
			var confirma = confirm("Cambiara el estado a: \n\n - <?php echo dameEstado(102); ?> \n\n ¿Desea continuar?");
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
						//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/opiniones.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
}); 	
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
function ocultaAll() 
{
	$$('.divsEdos').hide();
	$$('.todosPasos').removeClass("pasosActivo");
} 

function muestraPestana(divId)
{
	//todos los demas
	ocultaAll();
	//nuevo link
	$$('#paso'+divId).removeClass('pInactivo');
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#paso'+divId).addClass('pfAccesible '); 
	
	$$('#paso_'+divId).fadeIn();
}

</script>
<script>
//-------- actualiza la hora del txtbox hora para saber la hora del movimiento ---------------------
actualizaReloj('hora_cambio1','hora_cambio2');
//--------------------------------------------------------------------------------------------------
</script>
</head>
<body onLoad="" >
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<?php //-------------- En esta parte cuando el estado de la opinion está en 100 aparece la ventana para capturar oficio ------------

if($a['detalle_de_estado_de_tramite']==100){
?>

<div id='resPasos' class='resPasos redonda10'>
    
<?php
//-------------------------- BUSCAMOS DATOS DEL OFICIO DE LA ACCION -----------------------

$sql = $conexion->select("SELECT * FROM oficios WHERE num_accion LIKE '%".$accion."%' AND status <> '0'",false);
$fo= mysql_fetch_array($sql);
$folioOficio=$fo['folio'];
$fechaOficio=$fo['fecha_oficio'];
$status=$fo['status']; ?>    

<!-- -------------------------------------------------------------------------------------- -->

    
<?php    
    //-- Esta parte de código sirve para víncular el anuncio para crear un oficio en caso de no haberse creado -->
if( !(isset($fo['folio']) and $fo['fecha_oficio']) !=""){
	echo "<div id=\"message-red\">
                <table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                        <td class=\"red-left\">
                           Esta acción no cuenta con Oficio de Asistencia Jurídica... <a href=\"?cont=opiniones_oficios\">Si no lo ha creado haga click aquí para crearlo</a>
                        </td>
                        <td class=\"red-right\"><a class=\"close-red\"><img src=\"images/table/icon_close_red.gif\" onClick=\"$$('#message-red').slideUp()\"  alt=\"\" /></a></td>
                    </tr>
                </table>
            </div>";}
else{
	echo "";
	}
     //--Aquí termina  el código para víncular el anuncio para crear un oficio en cado de no haberse creado-->
     
  ?>   
    <div class="resPasosMedios redonda10">
        
        <!-- -------------- EDO TRAMITE 33 INFO AL RECURRENTE -------------------- -->
        <div align="center" >
            <br /> <br/>
            <h3>Asistencia Jurídica/Devolución de la SA.</h3>
            <div align="center">
            	 <br /> 
                <form name="formOpiAsis" id="formOpiAsis">
                <table width="70%" class="feDif">
                    <tr>
                    <!-- MENSAJE DE FALTA DE OFICIO 
                        <td colspan="2">
                         <?php if($totOfirec == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="?cont=medios_rr_oficios&nombre=<?php echo trim($r['nombre']) ?>">Click aqui para crearlo</a></div>
                         <?php } ?>
                        </td>
                        <td rowspan="4" style="padding:0 0 0 50px"> <input type="button" name="Guardar" value="Ya se tiene información del Recurrente" class="submit_line" id="btnInfoOK" onclick="muestraPestana(3)"/> </td>
                   -->
                   </tr>
                   <tr>
                        <td><input type="hidden" size="30" name="accion" id="accion" class="redonda5" value="<?php echo $accion ?>" readonly /></td>
                    </tr>
                   
                    <tr>
                        <td class="etiquetaPo">Oficio de asistencia:</td>
                        <td><input type="text" size="30" name="oficio_req" id="oficio_req" class="redonda5" value="<?php echo $fo['folio'];?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" size="30" name="fecha_oficio_req" id="fecha_oficio_req" class="redonda5" value="<?php echo fechaNormal($fo['fecha_oficio']); ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Acuse del Oficio:</td>
                        <td><input type="text" size="30" name="fecha_acuse_oficio_req" id="fecha_acuse_oficio_req" class="redonda5" /></td>
                    </tr>
					<tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_reqRecRec" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEdo33" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
            <br /> <br /> <br />
        </div>

    <!-- ------------------------------------------------------------------- -->    
    </div></div>
    
<?php 

} //------ Esta llave cierra el if de evaluación del estado de tramite 100 ------
  
  //-------------------------------- Aquí termina el proceso del estado de trámite 100 ----------------------------------------
  
    
  //-------------------------------- SALTO A VENTANA DE ESTADO DE TRAMITE 102 ------------- -->
  //-------------------------------- Esta parte de código se activa cuando el estado de trámite de la acción en opinion está en 102 ------
    
if($a['detalle_de_estado_de_tramite']==102){
?>
    
    <div id='resPasos' class='resPasos redonda10'>
    
        <div id="mensaje">
        
        <?php 
echo "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>Atención</h3><img src='images/warning_red.png' /><h3>Esta acción esta en la UAA.</h3><br /><br /><h3>No se pueden hacer cambios</h3></center></p>";
?>
        </div></div>

<?php } ?>

<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
error_reporting(0);
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$id = valorSeguro($_REQUEST['juicio']);
$juicio=valorSeguro($_REQUEST['juinu']);

//------------------------------------------------------------------------------
?>
<html>
<head>
<script type="text/javascript" src="js/funciones.js"></script>
<script>


function MuestraOtros()
{
	var otros = document.getElementById('otros');
    if (otros.checked)
	{
		$$("#otrost").attr("type","text");
	} else {  
		$$("#otrost").attr("type","hidden");
	} 
}


function dameFechaOfi()
{
	var ofi_jur= $$("#oficio_de_devolucionJ").val();
	
	$$.ajax
	({
		/*
		beforeSend: function(objeto)
		{
			//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito"); }
		},
		*/
		type: "POST",
		url: "procesosAjax/po_oficio_juridico.php",
		data:{
				oficio:ofi_jur
		},
		error: function(objeto, quepaso, otroobj)
		{

		},
		success: function(resultadoPHP)
		{ 
			$$("#fechadev").val(resultadoPHP);
			//alert(resultadoPHP);
		}
	});
	
	
	
	}



function muestraError(paso,texto)
{
	ocultaAll();
	document.getElementById(paso).innerHTML = "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>Atención</h3><img src='images/warning_red.png' /><h3 class='poTitulosPasos'>"+texto+"</h3>    </center></p>";
	$$('#'+paso).fadeIn();
}
function ocultaAll() 
{
	$$('.todosContPasos').removeClass("pActivo");
	$$('.todosContPasos').hide();
	$$('.todosPasos').removeClass("pasosActivo");
	//$$('.todosNP').removeClass('noPasoActivo');
	$$('.todosNP').addClass('noPaso'); 
} 
function muestraPestana(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	$$('#p'+divId).fadeIn();
}

 function Habilitar()
{
	var asofis = document.getElementById('asofis');
    if (asofis.checked)
	{
		$$("#oficio_notificacion_asofis").removeAttr('hidden');
		$$("#fecha_asofis").removeAttr('hidden');
		$$("#fecha_acuse_asofis").removeAttr('hidden');
		$$("#fecha_oficio_asofis").removeAttr('hidden');
		$$("#fecha_oficio_asofis_acuse").removeAttr('hidden');
		$$("#asofis").attr('hidden');
	}}
	

function Habilitar_icc()
{
	var segundo_icc = document.getElementById('segundo_icc');
    if (segundo_icc.checked)
	{
		$$("#oficio_notificacion_2do_icc").removeAttr('hidden');
		$$("#fecha_2do_icc").removeAttr('hidden');
		$$("#fecha_acuse_2do_icc").removeAttr('hidden');
		$$("#fecha_oficio_2do_icc").removeAttr('hidden');
		$$("#fecha_oficio_2do_icc_acuse").removeAttr('hidden');
		$$("#segundo_icc").attr('hidden');
	}}

//<!-----------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
$$(function() {
	//------------------------ VARIABLES GLOBALES ----------------------------------
	<?php 	
	
	//--------------------- SACAR FECHAS DEL SISTEMA -------------------
	$exeufr = $conexion->select("select oficioRecepcion from po_historial where num_accion = '".$accion."' order by oficioRecepcion desc limit 1 ",false);
	$ultimaFrecepcion = mysql_fetch_array($exeufr);
	echo "var ultimaFrecepcion = '".fechaNormal($ultimaFrecepcion['oficioRecepcion'])."'; ";
	//------------------------------------------------------------------
	echo "var ultimaFsolventacion = '".fechaNormal($ultimaFrecepcion['oficioRecepcion'])."'; ";
	//------------------------------------------------------------------
	echo "var ultimaFbaja = '".fechaNormal($ultimaFrecepcion['oficioRecepcion'])."'; ";
	//------------------------------------------------------------------	
	$exeufa = $conexion->select("select oficioAcuse from po_historial where num_accion = '".$accion."' order by oficioAcuse desc limit 1 ",false);
	$ultimaFasistencia = mysql_fetch_array($exeufa);
	echo "var ultimaFasistencia = '".fechaNormal($ultimaFasistencia['oficioAcuse'])."'; ";
	//------------------------------------------------------------------
	echo "var ultimaFproceso = '".fechaNormal($ultimaFasistencia['oficioAcuse'])."'; ";
	//------------------------------------------------------------------
	echo "var ultimaFremitiruaa = '".fechaNormal($ultimaFasistencia['oficioAcuse'])."'; ";
	//------------------------------------------------------------------
	$exeufn = $conexion->select("select acuseNotEntidad from po_historial where num_accion = '".$accion."' order by acuseNotEntidad desc limit 1 ",false);
	$ultimaFnotificado = mysql_fetch_array($exeufn);
	echo "var ultimaFnotificado = '".fechaNormal($ultimaFnotificado['acuseNotEntidad'])."'; ";
	
	//------------------------------------------------------------------
	?>
	//------------------------ VARIABLES GLOBALES ------------------------------------------------
	var formatoFecha = 'dd/mm/yy';
	var fechaInicio = "01/05/2014"; //var fechaInicio = "01/03/2014";
	var fechaMinima = "";
	//---- si la fecha de inicio es mas actual a la de recepcion se queda la de INICIO -----------
	if((fechaJS(fechaInicio) >= fechaJS(ultimaFrecepcion)) || (ultimaFrecepcion == "")) var fechaMinimaRec = fechaInicio;
	else  var fechaMinimaRec = ultimaFrecepcion;
	//$$( "#f1po_fecha_oficio" ).val(fechaMinimaRec);
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) >= fechaJS(ultimaFasistencia) || (ultimaFasistencia == "")) var fechaMinimaAsi = fechaInicio;
	else  var fechaMinimaAsi = ultimaFasistencia;
	//$$( "#fechadev" ).val(fechaMinimaAsi);
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) >= fechaJS(ultimaFproceso) || (ultimaFproceso == "")) var fechaMinimaPro = fechaInicio;
	else  var fechaMinimaPro = ultimaFproceso;
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) >= fechaJS(ultimaFnotificado) || (ultimaFnotificado == "")) var fechaMinimaNot = fechaInicio;
	else  var fechaMinimaNot = ultimaFnotificado;
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) >= fechaJS(ultimaFremitiruaa) || (ultimaFremitiruaa == "")) var fechaMinimaUaa = fechaInicio;
	else  var fechaMinimaUaa = ultimaFremitiruaa;
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) >= fechaJS(ultimaFsolventacion) || (ultimaFsolventacion == "")) var fechaMinimaSol = fechaInicio;
	else  var fechaMinimaSol = ultimaFsolventacion;
	//--------------------------------------------------------------------------------------------
	//if(fechaJS(fechaInicio) > fechaJS(ultimaFdtns)) var fechaMinimaDtns = fechaInicio;
	//else  var fechaMinimaDtns = ultimaFdtns;
	//--------------------------------------------------------------------------------------------
	if(fechaJS(fechaInicio) > fechaJS(ultimaFbaja)) var fechaMinimaBaja = fechaInicio;
	else  var fechaMinimaBaja = ultimaFbaja;
	//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- REGISTRAR RECEPCION ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f1po_fecha_oficio" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate:fechaMinimaAsi,
	  //maxDate: "+1m",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//$$("#f2po_acuse_oficio").focus();
	  	$$( "#f2po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
		//$$( "#f2po_acuse_oficio" ).datepicker( "option", "maxDate", restaNolaborables(selectedDate,5)  ); 
		//--- fechas cral ---
		//$$( "#cralRec" ).datepicker( "option", "minDate", selectedDate );
		//$$( "#f4po_acuse_cral" ).datepicker( "option", "minDate", selectedDate );
		//--- fechas volante
		//$$( "#f5po_fecha_volante" ).datepicker( "option", "minDate", selectedDate );
		//$$( "#f6po_acuse_volante" ).datepicker( "option", "minDate", selectedDate );
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f2po_acuse_oficio" ).datepicker({
      //defaultDate: "+1w",
	  dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:fechaMinimaAsi,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#f1po_fecha_oficio" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
	//---------------------------------------------------------------------------------------------
	  $$( "#cralRec" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "0",
      numberOfMonths:1,	  
	  showAnim:'slideDown',
	  minDate: fechaMinimaAsi,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {  $$( "#f4po_acuse_cral" ).datepicker( "option", "minDate", selectedDate );  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f4po_acuse_cral" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "0",
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: fechaMinimaAsi,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {  $$( "#f3po_fecha_cral" ).datepicker( "option", "maxDate", selectedDate );    }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f5po_fecha_volante" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "0",
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: fechaMinimaAsi,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) { $$( "#f6po_acuse_volante" ).datepicker( "option", "minDate", selectedDate );  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f6po_acuse_volante" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "0",
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:fechaMinimaAsi,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) { $$( "#f3po_fecha_cral" ).datepicker( "option", "maxDate", selectedDate ); }
    });
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- ASISTENCIA JURIDICA ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
/*	$$( "#fechadev" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: fechaMinimaRec,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	 	$$( "#acusedev" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });*/
	//---------------------------------------------------------------------------------------------
		$$( "#acusedev" ).datepicker({
	  dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "01/10/2018",
	  maxDate: "31/10/2018",
	  	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fechadev" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- EN PROCESO  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#fechap" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "", //mas una semana
      numberOfMonths:2,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acusep" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#acusep" ).datepicker({
	  dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fechap" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- NOTIFICACION  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	/*$$( "#fecha_oficio_notificacion_entidad" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: fechaMinimaPro,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_oficio_notificacion_entidad" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });*/
	//---------------------------------------------------------------------------------------------
	/*$$( "#fecha_oficio_notificacion_oic" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: fechaMinimaPro,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_oficio_notificacion_oic" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });*/
	//---------------------------------------------------------------------------------------------
	
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- REMISION UAA  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	/*$$( "#f11po_fecha_oficio" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: fechaMinimaNot,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#f12po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });*/
	//---------------------------------------------------------------------------------------------
	
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- SOLVENTACION  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f17fecha_recepcion" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate:"14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#f18acuse_recepcion" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f18acuse_recepcion" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w",
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:"14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#f17fecha_recepcion" ).datepicker( "option", "maxDate", selectedDate );
		$$("#f19fecha_volante_recepcion").val(selectedDate);
		$$("#f20acuse_volante_recepcion").val(selectedDate);
      }
    });
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- DTNS  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#fecha_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:2,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_recepcionDTNS" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#acuse_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w",
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:"14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fecha_recepcionDTNS" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
//--------------------------------------------------------------------------------------------------------------
	$$( "#fecha_SICSA_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate:fechaMinimaUaa,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_SICSA_recepcionDTNS" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#acuse_SICSA_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w",
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fecha_SICSA_recepcionDTNS" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
//--------------------------------------------------------------------------------------------------------------
	$$( "#fecha_volante_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate:"14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_volante_recepcionDTNS" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#acuse_volante_recepcionDTNS" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w",
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  //minDate: fechaMinimaUaa,
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fecha_volante_recepcionDTNS" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- BAJA  ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f13fecha_recepcion" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#f14acuse_recepcion" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#f14acuse_recepcion" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "+1w",
      //changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "14/02/2018",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#f13fecha_recepcion" ).datepicker( "option", "maxDate", selectedDate );
		$$( "#f15fecha_volante_recepcion" ).val(selectedDate);
		$$( "#f16fecha_volante_recepcion" ).val(selectedDate);
      }
    });
//--------------------------------------------------------------------------------------------------------------

});
</script>
<script>
//-------- actualiza la hora del txtbox hora para saber la hora del movimiento ---------------------
actualizaReloj('hora_cambio1','hora_cambio2');
//--------------------------------------------------------------------------------------------------
</script>

</head>
<body onLoad="" >
<?php
//-------------------------- BUSCAMOS DATOS DE LA ACCION -----------------------
$sql = $conexion->select("SELECT * FROM juicios WHERE id = '".$id."' ",false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);

//------------------------------------------------------------------------------
/*
	1. Pendiente  UAA envíe a DGRRFEM PPO y ET 	
	2. Opinión para Emisión/Corrección del Pliego 	
	3. Devolución del PPO 	
	4. Aprobación del PPO. En Firma del AEGF 	
	5. En proceso de Notificación 	
	6. Notificado 	
	7. ET, PO y oficios notificados remitidos a la UAA 	
	8. Baja por Conclusión Previa a su Emisión 	
	9. Solventada 	
	10. Dictamen Técnico por no Solventación del PO
*/
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------

	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	if($r['estado'] == "En contestación de Demanda" )
{

	$onclickP1 = "";
	$onclickP2 = "onclick='muestraPestana(2)'";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "";	
	$onclickP6 = "";	
	$onclickP7 = "";	
	$onclickP8 = "";	
	
	$txtPaso2 = "pasosActivo";
		
	$acceso2 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p2').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 3 -----------------------------------
//---------------------------------------------------------------------------
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 4 y 5 -----------------------------------
//---------------------------------------------------------------------------
if($r['estado'] == "En espera de Sentencia" )
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP1 = "";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "onclick='muestraPestana(4)'";	
	$onclickP5 = "onclick='muestraPestana(5)'";	
	$onclickP6 = "";	
	$onclickP7 = "";	
	$onclickP8 = "onclick='muestraPestana(8)'";	
	
	$txtPaso4 = "pasosActivo";
	
	$acceso4 = "pfAccesible";
	$acceso5 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p4').fadeIn();	});	</script>";
}
if($r['estado'] == "En espera de Sentencia con Alegatos" )
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP1 = "";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "onclick='muestraPestana(4)'";	
	$onclickP5 = "'";	
	$onclickP6 = "";	
	$onclickP7 = "";	
	$onclickP8 = "";	
	
	$txtPaso4 = "pasosActivo";
	
	$acceso4 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p4').fadeIn();	});	</script>";
}


if($r['estado'] == "En espera de Sentencia con Ampliacion" )
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP1 = "";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "'";	
	$onclickP5 = "onclick='muestraPestana(5)'";	
	$onclickP6 = "";	
	$onclickP7 = "";	
	$onclickP8 = "";	
	
	$txtPaso5 = "pasosActivo";
	
	$acceso5 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p5').fadeIn();	});	</script>";
}

//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 6 -----------------------------------
//---------------------------------------------------------------------------

//---------------------------------------------------------------------------
//------------------------ ACTIVAR PESTAÑAS ---------------------------------
//---------------------------------------------------------------------------
if(ACTIVAPESTANAS == true)
{
	$onclickP1 = " onclick='muestraPestana(1)' ";
	$onclickP2 = " onclick='muestraPestana(2)' ";	
	$onclickP3 = " onclick='muestraPestana(3)' ";	
	$onclickP4 = " onclick='muestraPestana(4)' ";	
	$onclickP5 = " onclick='muestraPestana(5)' ";	
	$onclickP6 = " onclick='muestraPestana(6)' ";	
	$onclickP7 = " onclick='muestraPestana(7)' ";	
	$onclickP8 = " onclick='muestraPestana(8)' ";	
	
	$txtPaso1 = " pasosActivo ";
	$txtPaso2 = " pasosActivo ";
	$txtPaso3 = " pasosActivo ";
	$txtPaso4 = " pasosActivo ";
	$txtPaso5 = " pasosActivo ";
	$txtPaso6 = " pasosActivo ";
	$txtPaso7 = " pasosActivo ";
	$txtPaso8 = " pasosActivo ";
	
	$numPaso1 = " noPasoActivo ";
	$numPaso2 = " noPasoActivo ";
	$numPaso3 = " noPasoActivo ";
	$numPaso4 = " noPasoActivo ";
	$numPaso5 = " noPasoActivo ";
	$numPaso6 = " noPasoActivo ";
	$numPaso7 = " noPasoActivo ";
	$numPaso8 = " noPasoActivo ";
	
	$acceso1 = " pfAccesible ";
	$acceso2 = " pfAccesible ";
	$acceso3 = " pfAccesible ";
	$acceso4 = " pfAccesible ";
	$acceso5 = " pfAccesible ";
	$acceso6 = " pfAccesible ";
	$acceso7 = " pfAccesible ";
	$acceso8 = " pfAccesible ";
}
?>

<!--  start content-table-inner -->
<style>
.ui-datepicker-calendar td a,.ui-state-default{ display:block; padding:1px 0 !important}
	body{
		/*font: 62.5% "Trebuchet MS", sans-serif;*/
		font-size:62.5%;
	}
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
</style>
<div id='resGuardar' style="line-height:normal"></div>
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ---------------------------- IMPORTANTE NO QUITAR --------------------------------------->
<!-- --------------------- VARIABLES QUE PASAN VALORES A JQUERY ------------------------------>
<!-- ----------------------------------------- ----------------------------------------------->
<input name="juicio" type="hidden" value="<?php echo $id ?>" id="juicio" />
<input name="fecha_cambio" type="hidden" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input name="hora_cambio1" type="hidden" id="hora_cambio1" value="" />
<input name="hora_cambio2" type="hidden" id="hora_cambio2" value="" />
<input name="txtUser" type="hidden" value="<?php echo $_REQUEST['usuario'] ?>" id="txtUser" />
<input name="userDir" type="hidden" value="<?php echo $_REQUEST['direccion'] ?>" id="userDir" />
<input name="entidad_fiscalizada" type="hidden" value="<?php echo $r['entidad_fiscalizada'] ?>" id="entidad_fiscalizada" />
<input name="edoTraPro" type="hidden" value="<?php echo dameEstado($r['detalle_de_estado_de_tramite']) ?>" id="edoTraPro" />
<input name="dirAccion" type="hidden" value="<?php echo $r['direccion'] ?>" id="dirAccion" />
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<style>
	
	#paso1,#paso3,#paso6,#paso7,#paso8,
	#p1,#p3,#p6,#p7,#p8{ display:none !important}
	
</style>
<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> RECEPCIÓN PPO  </div>
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> CONTESTACIÓN DE LA DEMANDA</div>
       <div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso3 ?>">3</div>--> EN PROCESO </div>
       <div id='paso4' <?php echo $onclickP4 ?> class="todosPasos <?php echo $txtPaso4 ?> <?php echo $acceso4 ?> pasos"><!--<div id='np4' class="todosNP noPaso redonda10 <?php echo $numPaso4 ?>">4</div>--> AMPLIACION </div>
       <div id='paso5' <?php echo $onclickP5 ?> class="todosPasos <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"><!--<div id='np5' class="todosNP noPaso redonda10 <?php echo $numPaso5 ?>">5</div>--> ALEGATOS</div>
       <div id='paso6' <?php echo $onclickP6 ?> class="todosPasos <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"><!--<div id='np6' class="todosNP noPaso redonda10 <?php echo $numPaso6 ?>">6</div>--> SOLVENTACIÓN</div>
       <div id='paso7' <?php echo $onclickP7 ?> class="todosPasos <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"><!--<div id='np7' class="todosNP noPaso redonda10 <?php echo $numPaso7 ?>">7</div>--> DTNS</div>
       <div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"><!--<div id='np8' class="todosNP noPaso redonda10 <?php echo $numPaso8 ?>">8</div>--> BAJA</div>
    </div>
    
    <div id='resPasos' class='resPasos redonda10'>
    
        <div id="p0" class="todosContPasos pInactivo">
        </div>
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
			<?php //---------------------------MANDA A TRAER EL OFICIO EN CADA JUICIO-------------

//-------------------------- SENTENCIAS DE SQL ---------------------------------
//---------------------------MANDA A TRAER EL OFICIO EN CADA JUICIO-------------

$txtsql="SELECT * FROM juicios where id = '$jn'";
$r2= $conexion->	select($txtsql);
$r = mysql_fetch_array($r2);	


$txtsql1="SELECT * FROM oficios WHERE num_accion LIKE '%$juicio%' AND tipo ='contestacion_jn'";
$oficon= $conexion-> select($txtsql1);
$r1 = mysql_fetch_array($oficon);	


$txtsql2="SELECT * FROM oficios WHERE num_accion LIKE '%$juicio%' AND tipo ='ampliacion_jn'";
$ofiamp= $conexion-> select($txtsql2);
$r4 = mysql_fetch_array($ofiamp);	


$txtsql3="SELECT * FROM oficios WHERE num_accion LIKE '%$juicio%' AND tipo ='alegatos_jn'";
$ofiale= $conexion-> select($txtsql3);
$r7 = mysql_fetch_array($ofiale);	

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE CONTESTACIÓN ANTIGUOS---------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant= explode("/",$juicio);
$ofi1 = $ofiant[0];
$ofi2 = $ofiant[1];

if 
($ofi2 == '2012' || $ofi2 == '2013'|| $ofi2 == '2014'|| $ofi2 == '2015' ||$ofi2 == '2016'|| $ofi2 == '2017')
$antiguoCO = $r['oficio_contestacion']; 
else 
$antiguoCO = $r1 ['folio'];

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE AMPLIACIÓN ANTIGUOS-----------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant1= explode("/",$juicio);
$ofi2 = $ofiant1[0];
$ofi3 = $ofiant1[1];

if 
($ofi3 == '2012' || $ofi3 == '2013'|| $ofi3 == '2014'|| $ofi3 == '2015' ||$ofi3 == '2016'|| $ofi3 == '2017')
$antiguoAM = $r['oficio_ampliacion']; 
else 
$antiguoAM = $r4 ['folio'];

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE ALEGATOS ANTIGUOS-----------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant2= explode("/",$juicio);
$ofi4 = $ofiant2[0];
$ofi5 = $ofiant2[1];

if 
($ofi5 == '2012' || $ofi5 == '2013'|| $ofi5 == '2014'|| $ofi5 == '2015' ||$ofi5 == '2016'|| $ofi5 == '2017')
$antiguoAL = $r['oficio_alegatos']; 
else 
$antiguoAL = $r7 ['folio'];


?><?php if($nOfJur == 0) { ?>
            <!-- mensaje advertencia -->
            <?php } // fin nOf ?>

            <div style="float:right"><img src="images/help.png" /></div>
            <h3 align="center" class="poTitulosPasos">Contestación de la Demanda</h3>
            
          	<form action="#" method="POST" name="guardaJU" id="guardaJU">
            <input name="juridico" type="hidden" id="juridico" value="0" /></td>
	          
              <center>
              <table width="" align="left" class="tablaPasos ">
                <tr valign="baseline">
                  <td height="50"  align="left" nowrap class="etiquetaPo">Oficio de Contestación:</td>
                  
                  <td >
                  <!--
                  <select name="oficio_de_devolucionJ" id="oficio_de_devolucionJ" class="redonda5" onChange="dameFechaOfi()"  >
                  <option value="0"> Elegir </option> 
                 
                  </select>
                  -->
                  
                  <?php
				    echo "<input name='oficio_contestacion' readonly id='oficio_contestacion' class='redonda5' type='text' value='".$antiguoCO."' > " ?>
                  
                  
                  
                  
                  <!--
                  <input name="oficio_de_devolucionJ" type="text" value="DGRRFEM" class="redonda5" id="oficio_de_devolucionJ" size="5">
                  -
                  <input name="oficio_de_devolucionJ" type="text" value="A" class="redonda5" id="oficio_de_devolucionJ" size="5">
                  -
                  <input name="oficio_de_devolucionJ" type="text" value="" class="redonda5" id="oficio_de_devolucionJ" size="5">
					/
                  <input name="oficio_de_devolucionJ" type="text" value="<?PHP echo date("y") ?>" class="redonda5" id="oficio_de_devolucionJ" size="5">
                  -->
                  </td>
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                  </td>
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                <tr valign="baseline">
                  <td valign="top" height="43" align="right"  class="etiquetaPo">Acuse:</td>
                  <td><input  tabindex="3" id="acusedev" name="acusedev" type="text"  class="redonda5" value='' size = "12" readonly/><a href="#" onClick="getElementById('acusedev').value=''" style="float:right; margin:0 0 0 0" title="Borrar fecha" class="icon-2 info-tooltip"></a></td>
                  
                  
                </tr>
                <tr valign="baseline">
                  <td height="27" align="right" valign="top"  class="etiquetaPo">&nbsp;</td>
                  <td><input type="button" class="submit-login" alt="Guardar" value="Guardar" name="botGuardarCon" id="botGuardarCon"  
                                         
                                          onClick="guardaCon()" /></td>
                </tr>
                <tr>

                    </td>
                </tr>
              </table>
              </center>
	        </form>
        
        </div>
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        
        <!-- ----------------------------- DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        
        <!-- ----------------------------- DIV NOTIFICAR --------------------------------- -->
        <!-- ----------------------------- DIV NOTIFICAR --------------------------------- -->
        <div id="p4" class="todosContPasos pInactivo">

            
            
         <!-- -------------------------------------------------------- -->
            
            
           
        	<!-- -------------------------------------------------------- -->
            
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Ampliación de Demanda</h3>
            
            <form action="<?php echo $editFormAction; ?>" method="POST" name="formam" id="formam" onSubmit="return false">
             <input id="acusep" name="acuse" type="hidden"  class="redonda5" value='<?php $fecha_prescripcion =$_REQUEST['f1_fecha_presc']; 
			echo $fecha_prescripcion;?>'<?php echo $row_DetailRS1['prescripcion']; ?> />
              <table width="90%" align="center" class="tablaPasos ">
                
               <!-------- EVALUACION PARA PROCESO DE LAS ASOFIS ------------>
                                   
                   <script>
				  	//---------------------------------------------------------------------------------------------
					$$( "#fecha_oficio_asofis_acuse" ).datepicker({
					  //dateFormat: formatoFecha,
					  //defaultDate: "+1w",
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: "01/01/2018",
					  maxDate: "31/12/2018",
					  beforeShowDay: noLaborales,
					  onClose: function( selectedDate ) {
						$$( "#fecha_oficio_asofis" ).datepicker( "option", "maxDate", selectedDate );
					  }
					});
				  </script>		
                  
                  
                  
                  
                  <!-------- EVALUACION PARA PROCESO DE DOBLE OFICIO AL ICC ------------>
                                   
                  <tr valign="baseline">
                 
                   <script>
				  	//---------------------------------------------------------------------------------------------
					$$( "#fecha_oficio_2do_icc_acuse" ).datepicker({
					  //dateFormat: formatoFecha,
					  //defaultDate: "+1w",
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: "14/02/2018",
	 			      maxDate: "28/02/2018",
					  beforeShowDay: noLaborales,
					  onClose: function( selectedDate ) {
						$$( "#fecha_oficio_2do_icc" ).datepicker( "option", "maxDate", selectedDate );
					  }
					});
				  </script>		
                  
                  
                  
                  
                  

                  <tR></tR> 
                  <tR></tR>
                  <td></td>
                  <td align="right" nowrap class="etiquetaPo">Oficio de Ampliacion:</td>
                            
                                    <script>
				  	//---------------------------------------------------------------------------------------------
					$$( "#acuse_oficio_notificacion_entidad" ).datepicker({
					  //dateFormat: formatoFecha,
					  //defaultDate: "+1w",
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate:'<?php echo fechaNormal($ofi["fecha_oficio"]) ?>',
					  beforeShowDay: noLaborales,
					  onClose: function( selectedDate ) {
						$$( "#fecha_oficio_notificacion_entidad" ).datepicker( "option", "maxDate", selectedDate );
					  }
					});
				  </script>				 
                                   				 
                                              
                   <?php $sql=$conexion->select("SELECT O.folio, O.fecha_oficio
				   									FROM oficios O
													INNER JOIN oficios_contenido OC
													ON O.folio = OC.folio 
													WHERE 
														O.tipo='notificacionICC' AND 
														OC.num_accion = '".$accion."'  AND 
														OC.juridico = 1 AND 
														O.status <> 0 "); 
				  		$ofi2 = mysql_fetch_array($sql);
				  ?>
                  
                  
                   <script>
                                              $$( "#acuseam" ).datepicker({
                                  //dateFormat: formatoFecha,
                                  //defaultDate: "+1w",
                                  changeMonth: false,
                                  numberOfMonths: 1,
                                  showAnim:'slideDown',
                                  minDate: '<?php echo fechaNormal($ofi2["fecha_oficio"]) ?>',
                                  beforeShowDay: noLaborales,
                                  onClose: function( selectedDate ) {
                                    $$( "#fecha_oficio_notificacion_oic" ).datepicker( "option", "maxDate", selectedDate );
                                  }
                                });
					
</script>
                  
                  
                  
                  <td ><input  tabindex="1" type="text"  class="redonda5"  name="oficio_am" id="oficio_am"  value="<?php echo stripslashes($antiguoAM);	?>"  size="25" readonly ></td>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td align="right" nowrap class="etiquetaPo">Acuse:</td>
                    <td><input  tabindex="3" style="float:left" id="acuseam"name="acuseam"  type="text"  class="redonda5"  value=''  size="12" readonly/>
                <tr valign="baseline">
                  <td  colspan="7" align="center">
                  <br><br>
                  <input type="button" class="submit-login" alt="Guardar" value="Guardar" name="Guardar" id="Guardar" onClick="guardaam()" <?php echo $disabledICC ?> <?php echo $disabledEF ?> ></td>
                </tr>
              </table>
              
            </form>
            
            
        </div>
        <!-- ----------------------------- FIN NOTIFICAR --------------------------------- -->
        <!-- ----------------------------- FIN NOTIFICAR --------------------------------- -->
        
		<!-- ----------------------------- DIV NOTIFICAR UAA --------------------------------- -->
        <!-- ----------------------------- DIV NOTIFICAR UAA --------------------------------- -->        
        <div id="p5" class="todosContPasos pInactivo">
        	<?php $sql=$conexion->select("SELECT O.folio, O.fecha_oficio 
					   								FROM oficios O
													INNER JOIN oficios_contenido OC
													ON O.folio = OC.folio
													WHERE 
														O.tipo='remisionUAA' AND 
														OC.num_accion = '".$accion."' AND 
														O.status <> 0 "); 
				  $ofi2 = mysql_fetch_array($sql);
				  $nofUaa = mysql_num_rows($sql);
			?>
        	<!-- -------------------------------------------------------- -->
        	<!-- -------------------------------------------------------- -->
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Alegatos</h3>
            
             <form action="<?php echo $editFormAction; ?>" method="POST" name="formale" id="formale">
                <table width="90%" align="center" class="tablaPasos ">
                  <tr valign="baseline">
                    <td width="12%" height="23" align="right" nowrap class="etiquetaPo">Oficio de Alegatos:
                                      
                          <script>
                          $$( "#acuseal" ).datepicker({
                         // dateFormat: formatoFecha,
                          //defaultDate: "+1w",
                          changeMonth: false,
                          numberOfMonths: 1,
                          showAnim:'slideDown',
                          minDate: "01/10/2018",
	 						 maxDate: "15/10/2018",
                          beforeShowDay: noLaborales,  
                          onClose: function( selectedDate ) {
                            $$( "#f11po_fecha_oficio" ).datepicker( "option", "maxDate", selectedDate );
                          }
                        });
                        
                        </script>
                    <td width="27%"><input  tabindex="1" type="text" id="oficio_ale" class="redonda5"  name="oficio_ale"  value="<?php echo $antiguoAL	?>" size="25"  readonly></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap class="etiquetaPo">Acuse :</td>
                    <td><input  tabindex="3" style="float:left" id="acuseal"name="acuseal"  type="text"  class="redonda5"  value=''  size="12" readonly/>
                    </td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="4" align="center">
                    <br><br>
                    <input  type="button" class="submit-login" value="Guardar" name="Guardar3" id="Guardar3" onClick="GuardaAl()"></td>
                  </tr>
                </table>
          </form>
            
        </div>
        <!-- ----------------------------- FIN DIV NOTIFICAR UAA --------------------------------- -->
        <!-- ----------------------------- FIN DIV NOTIFICAR UAA --------------------------------- -->
        
        <!-- ----------------------------- DIV SOLVENTAR --------------------------------- -->
        <!-- ----------------------------- DIV SOLVENTAR --------------------------------- -->
        <div id="p6" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Solventación</h3>
            
             <form action="<?php echo $editFormAction; ?>" method="POST" name="formSol" id="formSol">
            <table width="90%" align="center" class="tablaPasos ">
              <tr valign="baseline">
                <td width="106" rowspan="4" align="right" nowrap="nowrap"></td>
                <td width="141" align="right" nowrap="nowrap" class="etiquetaPo">Oficio de Solventación:
                  <input name="registro_recepcion" type="hidden" id="registro_recepcion" value="<?php echo date ("d/m/Y");?>" /></td>
                <td width="200"><input  tabindex="1" name="oficio_recepcionS"  type="text"  class="redonda5"  id="oficio_recepcionS" value="AEGF-" size="25"  /></td>
                <td width="19" rowspan="4">&nbsp;</td>
                <td width="69" class="etiquetaPo">Volante:</td>
                <td width="190"><input  tabindex="4" name="volante_recepcionS"  type="text"  class="redonda5"  id="volante_recepcionS" value="" size="12" maxlength="7"></td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" class="etiquetaPo">Fecha del Oficio de Solventación:</td>
                <td>
                	<input  tabindex="2" style="float:left" id="f17fecha_recepcion"name="f17fecha_recepcion"  type="text"  class="redonda5"  value=''  size="12" readonly/>
                    <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('f17fecha_recepcion').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                </td>
                <td class="etiquetaPo">Fecha de Volante:</td>
                <td>
                <input  tabindex="5" style="float:left" id="f19fecha_volante_recepcion"name="f19fecha_volante_recepcion"  type="text"  class="redonda5"  value=''  size="12" readonly>
                <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('f19fecha_volante_recepcion').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                </td>
              </tr>
              <tr valign="baseline">
                <td align="right" nowrap="nowrap" class="etiquetaPo">Acuse de Oficio de Solventación:</td>
                <td>
                <input  tabindex="3" style="float:left" id="f18acuse_recepcion" name="f18acuse_recepcion"  type="text"  class="redonda5"  value=''  size="12" readonly>
                <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('f18acuse_recepcion').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                </td>
                <td class="etiquetaPo"><!-- Acuse de Volante: --></td>
                <td>
                <input  tabindex="6" style="float:left" id="f20acuse_volante_recepcion"name="f20acuse_volante_recepcion"  type="hidden"  class="redonda5"  value=''  size="12" readonly>
                <!-- <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('f20acuse_volante_recepcion').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a> -->
                </td>
              </tr>
              <tr valign="baseline">
                <td colspan="5" align="center">
                <br><br>
                <input type="button" class="submit-login"  alt="Registrar Oficio" onClick="Solventar()" value="Solventar" name="button2" id="button2">
                </td>

              </tr>
            </table>
          </form>
            
        </div>
        <!-- ----------------------------- FIN DIV SOLVENTAR --------------------------------- -->
        <!-- ----------------------------- FIN DIV SOLVENTAR --------------------------------- -->
        
        <!-- ----------------------------- DIV DTNS --------------------------------- -->
        <!-- ----------------------------- DIV DTNS --------------------------------- -->
    	<div id="p7" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Registro del Dictamen Técnico por No Solventacion del PO</h3>
            
            <form action="<?php echo $editFormAction; ?>" method="POST" name="formdtns" id="form1" onSubmit="return false">
              <table width="95%" align="center" class="tablaPasos ">
                <tr valign="baseline">
                  <td align="right" nowrap class="etiquetaPo">Oficio DTNS:</td>
                  <td ><input  tabindex="1" name="oficio_recepcionDTNS"  type="text"  class="redonda5"  id="oficio_recepcionDTNS" value="" size="25"></td>
                  <td  class="etiquetaPo">CRAL:</td>
                  <td ><input  tabindex="5" name="SICSA_recepcionDTNS"  type="text"  class="redonda5"  id="SICSA_recepcionDTNS" value="" size="25"></td>
                  <td class="etiquetaPo">Volante:</td>
                  <td ><label for="volante_recepcion"></label>
                    <input  tabindex="8" name="volante_recepcionDTNS"  type="text"  class="redonda5"  id="volante_recepcionDTNS" value=""></td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap class="etiquetaPo">DT:</td>
                  <td>
                  <input  tabindex="2" name="num_DT"  type="text"  class="redonda5"  id="num_DT" value="" size="25"></td>
                  <td class="etiquetaPo">Fecha de CRAL:</td>
                  <td>
                  	<input  tabindex="6" style="float:left" name="fecha_SICSA_recepcionDTNS"  type="text"  class="redonda5"  id="fecha_SICSA_recepcionDTNS" value="" size="12" readonly>
                    <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('fecha_SICSA_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                  </td>
                  <td class="etiquetaPo">Fecha de Volante:</td>
                  <td>
                  <input  tabindex="9" style="float:left" name="fecha_volante_recepcionDTNS"  type="text"  class="redonda5"  id="fecha_volante_recepcionDTNS" value="" size="12" readonly>
                  <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('fecha_volante_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                  </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap class="etiquetaPo">Fecha de Oficio DTNS:</td>
        <td>
        	<input  tabindex="3" style="float:left" name="fecha_recepcionDTNS" type="text" class="redonda5" id="fecha_recepcionDTNS" value="" size="12" readonly>
            <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('fecha_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
            </td>
                  <td class="etiquetaPo">Acuse de CRAL:</td>
                  <td>
                    <input   tabindex="7" style="float:left" name="acuse_SICSA_recepcionDTNS"  type="text"  class="redonda5"  id="acuse_SICSA_recepcionDTNS" value="" size="12" readonly>
                    <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('acuse_SICSA_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                  </td>
                  <td class="etiquetaPo">Acuse de Volante:</td>
                  <td>
                    <input  tabindex="10" style="float:left" name="acuse_volante_recepcionDTNS"  type="text"  class="redonda5"  id="acuse_volante_recepcionDTNS" value="" size="12" readonly>
                    <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('acuse_volante_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                 </td>
                </tr>
                <tr valign="baseline">
                  <td align="right" nowrap class="etiquetaPo">Acuse de Oficio DTNS:</td>
                  <td>
                  	<input  tabindex="4" style="float:left" name="acuse_recepcionDTNS"  type="text"  class="redonda5"  id="acuse_recepcionDTNS" value="" size="12" readonly>
                    <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('acuse_recepcionDTNS').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                  </td>
                  <td>&nbsp;</td>
                  <td><label for="acuse_SICSA_recepcion"></label></td>
                  <td>&nbsp;</td>
                  <td><label for="acuse_volante_recepcion"></label></td>
                </tr>
                <tr valign="baseline">
                  <td colspan="7" align="center">
                  <input name="entidad" type="hidden" id="entidad" value="<?php echo $r['entidad_accion']; ?>">
                  <input name="cp" type="hidden" id="cp" value="<?php echo $r['cp']; ?>">
                  <input name="auditoria" type="hidden" id="auditoria" value="<?php echo $r['num_auditoria']; ?>">
                  <input name="direccion" type="hidden" id="direccion" value="<?php echo $r['direccion']; ?>">
                  <input name="subdirector" type="hidden" id="subdirector" value="<?php echo $r['subdirector']; ?>">
                  <input name="abogado" type="hidden" id="abogado" value="<?php echo $r['abogado']; ?>">
                  <input name="po" type="hidden" id="po" value="<?php echo $r['numero_de_pliego']; ?>">
                  <input name="monto_no_solventado" type="hidden" id="monto_no_solventado" value="<?php echo $r['monto_de_po_en_pesos']; ?>">
                  <input name="subnivel" type="hidden" id="subnivel" value="<?php echo $r['subnivel']; ?>">
                  <input name="DG" type="hidden" id="DG" value="DG">
                  <input name="prescripcion" type="hidden" id="prescripcion" value="<?php echo $r['prescripcion']; ?>">
                  <input alt="Guardar" value=" Guardar" name="botonir" id="Guardar" type="button" class="submit-login"  onClick="DTNS()" >
                  
                  </td>
                </tr>
              </table>
			</form>
        </div>
        <!-- ----------------------------- FIN DIV DTNS --------------------------------- -->
        <!-- ----------------------------- FIN DIV DTNS --------------------------------- -->
        
        <!-- ----------------------------- DIV BAJA --------------------------------- -->
        <!-- ----------------------------- DIV BAJA --------------------------------- -->
    	<div id="p8" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Registro de Baja por Conclusión Previa a su Emisión</h3>
            
            <form action="<?php echo $editFormAction; ?>" method="POST" name="formbaja" id="form4">
                <p>&nbsp;</p>
                <table width="90%" align="center" class="tablaPasos ">
                  <tr valign="baseline">
                    <td width="178" align="right" nowrap="nowrap">&nbsp;</td>
                    <td width="178" height="23" align="right" nowrap="nowrap" class="etiquetaPo">Oficio de Baja:
                      <input name="registro_recepcion3" type="hidden" id="registro_recepcion3" value="<?php echo date ("d/m/Y");?>" /></td>
                    <td width="249"><input  tabindex="1" name="oficio_recepcion3"  type="text"  class="redonda5"  id="oficio_recepcion3"  value="AEGF-"  size="25" /></td>
                    <td width="24" rowspan="4">&nbsp;</td>
                    <td width="137" class="etiquetaPo">Volante:</td>
                    <td width="459"><input  tabindex="4" name="volante_recepcion2"  type="text"  class="redonda5"  id="volante_recepcion2" value="" size="12"maxlength="7" ></td>
                  </tr>
                  <tr valign="baseline">
                    <td height="25" align="right" nowrap="nowrap">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="etiquetaPo">Fecha del Oficio de Baja:</td>
                    <td>
                    	<input  tabindex="2" style="float:left" id="f13fecha_recepcion"name="f13fecha_recepcion"  type="text"  class="redonda5"  value=''  size="12" readonly/>
                        <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('f13fecha_recepcion').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a>
                    </td>
                    <td class="etiquetaPo">Fecha de Volante:</td>
                    <td>
                    	<input  tabindex="5" id="f15fecha_volante_recepcion"name="f15fecha_volante_recepcion"  type="text"  class="redonda5"  value='' size="12" readonly />
                        
                   </td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap="nowrap">&nbsp;</td>
                    <td align="right" nowrap="nowrap" class="etiquetaPo">Acuse del Oficio de Baja:</td>
                    <td><input  tabindex="3" id="f14acuse_recepcion"name="f14acuse_recepcion"  type="text"  class="redonda5"  value=''  size="12" readonly/></td>
                    <td class="etiquetaPo"></td>
                    <td><input id="f16fecha_volante_recepcion"name="f16fecha_volante_recepcion"  type="hidden"  class="redonda5"  value='' size="12" readonly/></td>
                  </tr>
                  <tr valign="baseline">
                    <td colspan="7" align="center">
                    <br>
                    <input type="button" class="submit-login" alt="Registrar Oficio" value="Dar de Baja" name="Enviar" id="Enviar" onClick="Baja()">
                    </td>
                  </tr>
                </table>
          </form>
        </div>
        <!-- ----------------------------- FIN DIV BAJA --------------------------------- -->
        <!-- ----------------------------- FIN DIV BAJA --------------------------------- -->

		

    </div>
</div>
<!--  end content-table  -->
</body>
</html>

<?php
	mysql_free_result($sql);
	mysql_free_result($sql2);
	mysql_free_result($sql3);
	mysql_free_result($sql4);
?>
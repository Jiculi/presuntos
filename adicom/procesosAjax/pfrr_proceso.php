<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");

$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
// CONSULTAMOS EL HISTORIAL PARA SABER SI YA PASO POR LA UAA
$sqlUAA = $conexion->select("SELECT * FROM pfrr_historial  WHERE num_accion = '".$accion."' AND estadoTramite = 19 limit 1",true);
$pasoUAA = mysql_num_rows($sqlUAA);
$rUAA = mysql_fetch_array($sqlUAA);
if($pasoUAA && ($rUAA['oficioAcuse'] == "" || $rUAA['oficioAcuse'] == "0000-00-00") ) $abreUAA = true;
if(!$pasoUAA) $abreUAA = true;
?>
<html>
<head>
<script type="text/javascript" src="js/funciones.js"></script>
<script>



function dameFechaOfix()
{
	var ofi_dtns= $$("#oficio_de_devoluciondtns").val();
	
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
		url: "procesosAjax/pfrr_oficio_dtns.php",
		data:{
				oficio:ofi_dtns
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
	document.getElementById(paso).innerHTML = "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>Atención</h3><img src='images/warning_yellow.png' /><h3 class='poTitulosPasos'>"+texto+"</h3>    </center></p>";
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
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
$$(function() {
	//------------------------ VARIABLES GLOBALES ----------------------------------
	//------------------------ VARIABLES GLOBALES ------------------------------------------------
	var formatoFecha = 'dd/mm/yy';
	//------------------- ESTADO DE TRAMITE 1 -----------------------------------
	//---------------------------------------------------------------------------
//----------------------------
$$( "#fechaResolucion" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "01/12/2015",
	  maxDate: "30/12/2015",
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
//----------------------------------------- ASISTENCIA JURIDICA ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#fechaCierreInstruccion" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate:"01/12/2015",
	  maxDate:"30/12/2015",
	 /*
	  minDate: "01/"+(myMes-3)+"/"+myAno,
	  maxDate: MyDias+"/"+myMes+"/"+myAno,
	  */
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	//alert("MIn "+"01/"+myMes+"/"+myAno+"\n Max "+diasDeMes+"/"+myMes+"/"+myAno)
//--------------------------------------------------------------------------------------------------------------
//---------------------------------------------- EN PROCESO  ---------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#fechap" ).datepicker({
	  dateFormat: formatoFecha,
      //defaultDate: "", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "-0D",
		maxDate: "-0D",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acusep" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });

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
$sql = $conexion->select("SELECT * FROM pfrr WHERE num_accion = '".$accion."' ",false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//------------------------------------------------------------------------------
//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
if($pasoUAA)
{
	$fechaUAA = fechaNormal($r['fecha_analisis_documentacion']);
	$fecha90 = strtotime ( '+90 day' , strtotime ( $r['fecha_analisis_documentacion'] ) ) ;
	$fecha90 = fechaNormal(date ( 'Y-m-d' , $fecha90 ));
}
else
{
	$fechaUAA = "";
	$fecha90 = "";
}


/*
if($r['monto_de_po_en_pesos'] == '') $montoIR = "0.00";
else $montoIR = number_format($r['monto_de_po_en_pesos'],2);
*/
//-------------------------- BUSCAMOS MONTOS DE LA ACCION ----------------------
/*
$sql2 = $conexion->select("SELECT * FROM po_montos WHERE num_accion = '".$accion."' ",false);
$m = mysql_fetch_array($sql2);

$monto_PO = floatval($r['monto_de_po_en_pesos']);
$monto_resarcido = floatval($m['monto_resarcido']);
$monto_justificado = floatval($m['monto_justificado']);
$monto_aclarado = floatval($m['monto_aclarado']);
$monto_comprobado = floatval($m['monto_comprobado']); 
$suma = $monto_resarcido +$monto_aclarado +$monto_comprobado + $monto_justificado;
$TotPO = floatval($monto_PO) - floatval($suma);
*/
//----------------------- BUSCAMOS PRESUNTOS DE LA ACCION ----------------------
$sql3 = $conexion->select("SELECT * FROM po_presuntos WHERE num_accion = '".$accion."' ",false);
$p = mysql_fetch_array($sql3);
$tP = $total = mysql_num_rows($sql3);
//---------------------------------------------------------------------------
//------------------- MENSAJE DE ESPERA ACCION ------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 13 || $r['detalle_edo_tramite'] == 16 || $r['detalle_edo_tramite'] == 19)
{
	if(ACTIVAPESTANAS == false)
	echo "<script>	
			muestraError('p0','Esta acción esta en la UAA.<br><br>No se pueden hacer cambios.')
			$$(function() {	$$('#p0').fadeIn();	});	
		</script>";
}
//---------------------------------------------------------------------------
//------------------- MENSAJE DE ESPERA ACCION ------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 14)
{
	if(ACTIVAPESTANAS == false)
	echo "<script>	
			muestraError('p0','Esta acción se Solventó previo al inicio de PFRR.<br><br>No se pueden hacer cambios.')
			$$(function() {	$$('#p0').fadeIn();	});	
		</script>";
}
//---------------------------------------------------------------------------
//------------------- MENSAJE DE ACCION INICIADA ----------------------------
//---------------------------------------------------------------------------
if( dameEdoNumOrden(dameEdoTramite($accion)) > dameEdoNumOrden(15) && $r['detalle_edo_tramite'] != 18 && $r['detalle_edo_tramite'] != 31 && $r['detalle_edo_tramite'] != 19 && $r['detalle_edo_tramite'] != 28 && $r['detalle_edo_tramite'] != 22 && $r['detalle_edo_tramite'] != 29 && $r['detalle_edo_tramite'] != 23 && $r['detalle_edo_tramite'] != 24 && $r['detalle_edo_tramite'] != 25  && $r['detalle_edo_tramite'] != 26)
{
	if(ACTIVAPESTANAS == false)
	echo "<script>
			var link = \"<a href='#' title='Presuntos Responsables' class='icon-6 info-tooltip' onclick=\\\"new mostrarCuadro(580,1000,'".$r['num_accion']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r['entidad']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".dameEstado($r['detalle_edo_tramite'])."',20,'cont/pfrr_presuntos.php','numAccion=".$r['num_accion']."&usuario=".$_SESSION['usuario']."&direccion=".$_SESSION['direccion']."') \\\" ></a>\";
			muestraError('p0','Accion Iniciada y hecho de conocimiento al ICC.<br><br> <div style=\"margin:0 auto; width:600px\"> <span style=\"float:left\">Dirijase al siguiente icono para administrar los presuntos -> &nbsp;&nbsp; </span> <span style=\"clear:both\"> '+link+'</span> </div>')
			$$(function() {	$$('#p0').fadeIn();	});	
		</script>";
}
///---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 11 -----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 11 )
{
	$onclickP2 = "onclick='muestraPestana(2)'";	
	$onclickP3 = "onclick='muestraPestana(3)'";	
	
	$txtPaso2 = "pasosActivo";
	$acceso2 = "pfAccesible";
	$acceso3 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p2').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 15 -----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 15)
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "onclick='muestraPestana(4)'";	
	
	$txtPaso4 = "pasosActivo";
	$acceso4 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p4').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 22 ----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 22)
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "onclick='muestraPestana(5)'";
	
	$txtPaso5 = "pasosActivo";
	$acceso5 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p5').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 28 ----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 28)
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "";
	$onclickP6 = "onclick='muestraPestana(6)'";
	
	$txtPaso6 = "pasosActivo";
	$acceso6 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p6').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 29 ----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 29 || $r['detalle_edo_tramite'] == 23 || $r['detalle_edo_tramite'] == 24 || $r['detalle_edo_tramite'] == 25 || $r['detalle_edo_tramite'] == 26)
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "";
	$onclickP6 = "";
	$onclickP7 = "onclick='muestraPestana(7)'";

	$txtPaso7 = "pasosActivo";
	$acceso7 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p7').fadeIn();	});	</script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 18 ----------------------------------
//---------------------------------------------------------------------------
//se abre solo sino paso por la UAA
if( $abreUAA && ($r['detalle_edo_tramite'] == 18 || $r['detalle_edo_tramite'] == 31) )
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "";
	$onclickP6 = "";
	$onclickP8 = "onclick='muestraPestana(8)'";
	$onclickP9 = "onclick='muestraPestana(9)'";

	$txtPaso9 = "pasosActivo";
	$acceso9 = "pfAccesible";
	$acceso9 = "pfAccesible";
	
	echo "<script>	$$(function() {	$$('#p9').fadeIn();	});	</script>";
	echo "<script> 	$$('#p9').removeClass('pInactivo'); </script>";
}
//---------------------------------------------------------------------------
//------------------- ESTADO DE TRAMITE 29 ----------------------------------
//---------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 31)
{
	//$onclickP1 = "onclick = \" muestraError('p1','No puede realizar una recepcion si no ha devuelto (Asistido Jurídicamente) esta accion') \" ";
	$onclickP2 = "";	
	$onclickP3 = "";	
	$onclickP4 = "";	
	$onclickP5 = "";
	$onclickP6 = "";
	$onclickP8 = "onclick='muestraPestana(8)'";
	if($abreUAA) $onclickP9 = "onclick='muestraPestana(9)'";

	$txtPaso8 = "pasosActivo";
	$acceso8 = "pfAccesible";

	if($abreUAA) $acceso9 = "pfAccesible";
	if($pasoUAA) echo "<script>	$$(function() {	$$('#p8').fadeIn();	});	</script>";
}
//-------------------------------------------------------------------------------------
//------------------- MENSAJE NINGUN PRESUNTO COMPARECIO ------------------------------
//-------------------------------------------------------------------------------------
if($r['detalle_edo_tramite'] == 16)
{
	$sqlPresunto = "
					SELECT ppa.num_accion, ppa.nombre, ppa.responsabilidad, pa.tipo, pa.comparece as comparecio
					FROM pfrr_presuntos_audiencias ppa
					INNER JOIN pfrr_audiencias pa ON pa.idPresunto = ppa.cont
					WHERE ppa.num_accion LIKE '".$accion."'
					AND ppa.tipo != 'responsableInforme' 
					AND ppa.tipo != 'titularICC'
					AND pa.tipo =1;	";
						
	$sqlP = $conexion->select($sqlPresunto,false);
	
	while($rp = mysql_fetch_array($sqlP)) {
		if($rp['comparecio'] == 'ncn') $ncn++;	
	}
	$tp = mysql_num_rows($sqlP);
	
	if($tp == $ncn) {
		$onclickP8 = "onclick='muestraPestana(8)'";	

		$txtPaso8 = "pasosActivo";
		$acceso8 = "pfAccesible";
		
		echo "<script>
					$$(function() {	$$('#p0').fadeOut(); });	
					$$(function() {	$$('#p8').fadeIn(); });	
			 </script>";
		
	}

}

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
	$onclickP9 = " onclick='muestraPestana(9)' ";	
	
	$txtPaso1 = " pasosActivo ";
	$txtPaso2 = " pasosActivo ";
	$txtPaso3 = " pasosActivo ";
	$txtPaso4 = " pasosActivo ";
	$txtPaso5 = " pasosActivo ";
	$txtPaso6 = " pasosActivo ";
	$txtPaso7 = " pasosActivo ";
	$txtPaso8 = " pasosActivo ";
	$txtPaso9 = " pasosActivo ";
	
	$numPaso1 = " noPasoActivo ";
	$numPaso2 = " noPasoActivo ";
	$numPaso3 = " noPasoActivo ";
	$numPaso4 = " noPasoActivo ";
	$numPaso5 = " noPasoActivo ";
	$numPaso6 = " noPasoActivo ";
	$numPaso7 = " noPasoActivo ";
	$numPaso8 = " noPasoActivo ";
	$numPaso9 = " noPasoActivo ";
	
	$acceso1 = " pfAccesible ";
	$acceso2 = " pfAccesible ";
	$acceso3 = " pfAccesible ";
	$acceso4 = " pfAccesible ";
	$acceso5 = " pfAccesible ";
	$acceso6 = " pfAccesible ";
	$acceso7 = " pfAccesible ";
	$acceso8 = " pfAccesible ";
	$acceso9 = " pfAccesible ";
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
	}*/
</style>
<div id='resGuardar' style="line-height:normal"></div>
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ---------------------------- IMPORTANTE NO QUITAR --------------------------------------->
<!-- --------------------- VARIABLES QUE PASAN VALORES A JQUERY ------------------------------>
<!-- ----------------------------------------- ----------------------------------------------->
<input name="num_accion" type="hidden" value="<?php echo $accion ?>" id="num_accion" />
<input name="fecha_cambio" type="hidden" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input name="hora_cambio1" type="hidden" id="hora_cambio1" value="" />
<input name="hora_cambio2" type="hidden" id="hora_cambio2" value="" />
<input name="userDir" type="hidden" value="<?php echo $_REQUEST['direccion'] ?>" id="userDir" />
<input name="entidad_fiscalizada" type="hidden" value="<?php echo $r['entidad'] ?>" id="entidad_fiscalizada" />
<input name="edoTraPro" type="hidden" value="<?php echo dameEstado($r['detalle_edo_tramite']) ?>" id="edoTraPro" />
<input name="dirAccion" type="hidden" value="<?php echo $r['direccion'] ?>" id="dirAccion" />
<input name ="cp" type="hidden" value="<?php echo $r['cp'] ?>" id="cp" /> 
<input name="txtUser" type="hidden" value="<?php echo $_REQUEST['usuario'] ?>" id="txtUser" />
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> DTNS</div>
       <div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso3 ?>">3</div>--> ACUERDO DE INICIO </div>
       <div id='paso4' <?php echo $onclickP4 ?> class="todosPasos <?php echo $txtPaso4 ?> <?php echo $acceso4 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso4 ?>">3</div>--> NOTIFICACIÓN AL ICC </div>
       <div id='paso9' <?php echo $onclickP9 ?> class="todosPasos <?php echo $txtPaso9 ?> <?php echo $acceso9 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso9 ?>">3</div>--> OPINIÓN UAA </div>
       <div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso8 ?>">3</div>--> ULTIMA ACTUACIÓN </div>
       <div id='paso6' <?php echo $onclickP6 ?> class="todosPasos <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso6 ?>">3</div>--> CIERRE INSTRUCCIÓN </div>
       <div id='paso5' <?php echo $onclickP5 ?> class="todosPasos <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso5 ?>">3</div>--> EMISIÓN DE LA RESOLUCIÓN </div>
       <div id='paso7' <?php echo $onclickP7 ?> class="todosPasos <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso7 ?>">3</div>-->NOTIFICACIÓN DE LA RESOLUCIÓN </div>

</div>
    
    <div id='resPasos' class='resPasos redonda10'>
        <!-- ----------------------------- DIV MSG --------------------------------- -->
        <div id="p0" class="todosContPasos pInactivo">
        </div>
         <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 align="center" class="poTitulosPasos">Devolución del Expediente Técnico</h3>
            
          	<form action="#" method="POST" name="devdtns" id="devdtns">
	         <input name="juridico" type="hidden" id="juridico" value="0" /></td>
              <center>
			  <?php 
			  $query = "SELECT O.folio as Folio, fecha_oficio from oficios O
						INNER JOIN oficios_contenido OC
							ON O.folio = OC.folio
						WHERE 
							O.tipo = 'dtns_PFRR' and 
							OC.num_accion like '%".$accion."%'  and 
							O.status <> 0 and 
							OC.juridico= 1";
							
              $sql=$conexion->select($query); 
              $ofdtns = mysql_num_rows($sql);
			  $ofi = mysql_fetch_array($sql);
              ?>                                   
			<script>
			$$(function() {
				$$("#acusedev").datepicker({
				  changeMonth: false,
				  numberOfMonths: 1,
				  showAnim:'slideDown',
				  minDate: "01/10/2015",
				  maxDate: '<?php echo date("d/m/Y") ?>',
				  beforeShowDay: noLaborales
				  });
			});
			</script>

                <?php if($ofdtns == 0) { ?>
                <!-- mensaje advertencia -->
                <div id="message-red">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="red-left">
                               Esta acción no cuenta con Oficio de Devolución del DTNS... <a href="?cont=pfrr_oficios">Si no lo ha creado haga click aqui para crearlo</a>
                            </td>
                            <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=" $$('#message-red').slideUp() "  alt="" /></a></td>
                        </tr>
                    </table>
                </div>
                <?php } // fin nOf ?>
              
              <table width="100%" align="left" class="tablaPasos ">
                <tr valign="baseline">
                  <td height="50"  align="left" nowrap class="etiquetaPo">Oficio de Devoluci&oacute;n:</td>
                  <td >
                 <?php
				    echo "<input name='oficio_de_devoluciondtns' readonly id='oficio_de_devoluciondtns' class='redonda5' type='text' value='".stripslashes($ofi['Folio'])."'  size = '30'  > " ?>
                  </td>
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                  <td  rowspan="50" >
                     <center>
                         <table class="tabladtns" width="90%" align="center">
                         	<tr>
                                <td valign="top" width="25%" class=""><input type="checkbox" name="inexistencia" id="inexistencia">
                              
                                <label for="inexistencia">
                                  Inexistencia de daño/perjuicio
                              </label></td>
                             
                              <td valign="top"  width="25%"   class="">
                              <input type="checkbox" name="irregularidad" id="irregularidad">
                              <label for="irregularidad">Fecha de irregularidad incorrecta</label></td>
                              
                              <td valign="top"  width="25%"  class="">
                              <input type="checkbox" name="docu_soporte" id="docu_soporte">
                                <label for="docu_soporte">Falta de documentación soporte del  recurso erogado</label></td>
                        	</tr>
                            <tr>
                                <td valign="top"  width="25%"  class=""><input type="checkbox" name="inadecuada" id="inadecuada">
                                <label for="inadecuada">Acción u omisión  inadecuada              (incorrecta)</label></td>
                                  
                                <td valign="top"  width="25%"  class=""><input type="checkbox" name="papeles" id="papeles">
                                <label for="papeles">Papeles de  
                                  trabajo no 
                                  cuadran
                                </label></td>
                                
                                  <td valign="top"  width="25%"   class=""><input type="checkbox" name="docu_irre" id="docu_irre">
                                    <label for="docu_irre">Falta de 
                                      documentación 
                                      que acredite la  
                                      irregularidad
                                    </label></td>
                        	</tr>
                           <tr>
                              <td valign="top" width="25%"  class=""><p>
                                
                                <input type="checkbox" name="monto_no_preciso" id="monto_no_preciso">
                                <label for="monto_no_preciso">Monto no preciso 
                                /exacto 
                              con el soporte<br> documental </label>
                               </td>
                              <td valign="top" width="25%"   class=""><input type="checkbox" name="mezcla" id="mezcla">
                                <label for="mezcla">Mezcla de  
                                  recursos
                              </label></td>
                              <td valign="top" width="25%" class=""> 
                                <input type="checkbox" name="presun_resp" id="presun_resp">
                                <label for="presun_resp">
                                Falta de  documentación 
                                que acredite la 
                                presunta  responsabilidad
                                </td>
                          </tr>
                          <tr valign="baseline">
                              <td valign="top" width="25%" class=""><input type="checkbox" name="datos" id="datos">
                                <label for="datos">Falta de datos 
                                  personales (PR)
                              </label></td> 
                              <td valign="top"  width="25%"  class=""><input type="checkbox" name="ilegible" id="ilegible">
                                <label for="ilegible">Documentación 
                                  ilegible
                              </label></td>
                              
                              <td valign="top" width="25%"  class="">
                                <input type="checkbox" name="indebida_fun" id="indebida_fun">
                                <label for="indebida_fun">Indebida 
                                fundamentación
                             </td>
                          </tr>
                                   
                           <tr valign="baseline">
                              <td valign="top" width="25%"  class=""><input type="checkbox" name="solUAAsolventacion" id="solUAAsolventacion">
                                <label for="solUAAsolventacion"> A solicitud de la UAA, Por posible solventación</label> </td>
                          
                               <tr valign="top">
                              <td valign="top" width="25%"  class=""><input type="checkbox" name="validacionUAA" id="validacionUAA">
                                <label for="validacionUAA"> Validación de reintegro por la UAA</label>
                              
               
                           </tr> 
                         </table>
                     
                  
                     
                     
                    </center>
                  </td>
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                </tr>
                <tr valign="baseline">
                  <td valign="top" height="43" align="right"  class="etiquetaPo">Fecha de Oficio de Devolución:</td>

                  <td><input  tabindex="2" id="fechadev" name="fechadev" type="text"  class="redonda5" value="<?php echo stripslashes(fechaNormal($ofi["fecha_oficio"]));	?>" size = "15" readonly  /> </td>
                </tr>
                <tr valign="baseline">
                  <td valign="top" height="43" align="right"  class="etiquetaPo">Acuse de Oficio de Devolución:</td>
                  <td><input  tabindex="3" id="acusedev" name="acusedev" type="text"  class="redonda5" value='' size = "15" readonly/><a href="#" onClick="getElementById('acusedev').value=''" style="float:right; margin:0 40px 0 0" title="Borrar fecha" class="icon-2 info-tooltip"></a></td>
                  
                  
                </tr>
                <tr valign="baseline">
                  <td valign="top" align="right"  class="etiquetaPo">&nbsp;</td>
                  <td><input type="button" class="submit-login" alt="Guardar" value="Guardar" name="devdtns" id="devdtns"  onClick="devdtnsx() " /></td>
                </tr>
                <tr>

                    </td>
                </tr>
              </table>
              </center>
	        </form>
        
        </div>
        <!-- ----------------------------- FIN DIV DEVOLUCIÓN DEL EXPEDIENTE TECNICO --------------------------------- -->      
        
        <!-- ----------------------------- DIV NOTIFICACION ICC --------------------------------- -->
                <div id="p4" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Notificación del acuerdo de inicio al ICC</h3>
            
            <?php 
				  $sql=$conexion->select("SELECT folio, fecha_oficio from oficios where tipo = 'Not_icc_PFRR' and num_accion like '%".$accion."%'  and juridico='1'"); 
				  $ofi = mysql_fetch_array($sql);
				  $numOfi = mysql_num_rows($sql);
			?>                                   
            <script>
			$$(function() {
				$$("#fecha_acu_icc_pfrr").datepicker({
				  changeMonth: false,
				  numberOfMonths: 1,
				  showAnim:'slideDown',
				  minDate: '<?php echo stripslashes(fechaNormal($ofi["fecha_oficio"]));	?>',
				  maxDate: '<?php echo date("d/m/Y") ?>',
				  beforeShowDay: noLaborales
				  });
			});
			</script>
                <?php if($numOfi == 0) { ?>
                <!-- mensaje advertencia -->
                <div id="message-red">
                    <table border="0" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="red-left">
                               Esta acción no cuenta con Notificación del acuerdo de inicio al ICC... <a href="?cont=pfrr_oficios">Si no lo ha creado haga click aqui para crearlo</a>
                            </td>
                            <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=" $$('#message-red').slideUp() "  alt="" /></a></td>
                        </tr>
                    </table>
                </div>
                <?php } // fin nOf ?>
            
            <form action="#" method="POST" name="formpro" id="notiiccpfrr" onSubmit="return false">
			  <table width="100%" border="0" align="center" class="tablaPasos ">
				<tr valign="baseline">
                
				<tr>
				  <td width="40%" align="right"  class="etiquetaPo">Oficio de Notificación al ICC:</td>
				  <td><input  tabindex="2" style="float:left;" id="oficio_not_icc_pfrr" name="oficio_not_icc_pfrr" type="text"  class="redonda5" value='<?php echo stripslashes($ofi['folio']) ?>' size="20" readonly/> <a href="#" style=" " ></a></td>
			    </tr>
                <tr valign="baseline">
                                  <td width="40%" align="right"  class="etiquetaPo">Fecha de Oficio de Notificación al ICC:</td>
                                  
                  <?php $sql=$conexion->select("SELECT folio, fecha_oficio from oficios where tipo = 'Not_icc_PFRR' and num_accion like '%".$accion."%' "); 
				  		$ofi = mysql_fetch_array($sql);

				  ?>                                   
               
				  <td><input  tabindex="2" style="float:left;" id="fecha_not_icc_pfrr" name="fecha_not_icc_pfrr" type="text"  class="redonda5" value='<?php echo stripslashes(fechaNormal($ofi['fecha_oficio'])) ?>' size="12" readonly/> <a href="#" style=" margin:0 0 0 5px" ></a></td>
</tr>


                <tr valign="baseline">
                                  <td width="40%" align="right"  class="etiquetaPo">Acuse de Oficio de Notificación al ICC:</td>
				  <td><input  tabindex="2" style="float:left;" id="fecha_acu_icc_pfrr" name="fecha_acu_icc_pfrr" type="text"  class="redonda5" value='' size="12" readonly/> <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('fecha_acu_icc_pfrr').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a></td>
</tr>

				<tr valign="baseline">
				  <td  colspan="2">
                  <center>
                <br><br>
                <input type="button" class="submit-login" alt="Guardar" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" name="Registrar" id="RegistrarProce"  onclick="NotificaICCx()" /> 
                    </center>       
        		</td>
			    </tr>
			  </table>
		  </form>

        </div>
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        

 <!-- ----------------------------- DIV ACUERDO DE INICIO --------------------------------- -->
          <div id="p3" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Acuerdo de Inicio</h3>
            
            <form action="#" method="POST" name="formpro" id="acuerdoinicio" onSubmit="return false">
			  <table width="100%" border="0" align="center" class="tablaPasos ">
				<tr valign="baseline">
				  <td width="40%" align="right"  class="etiquetaPo">Fecha de Acuerdo de Inicio:</td>
				  <td><input  tabindex="2" style="float:left;" id="fechap" name="fechap" type="text"  class="redonda5" value='' size="12" readonly/> <a href="#" style=" margin:0 0 0 5px" onClick="getElementById('fechap').value=''" title="Borrar fecha" class="icon-2 info-tooltip"></a></td>
			    </tr>
				<tr valign="baseline">
				  <td  colspan="2">
                  <center>
                <br><br>
                <input type="button" class="submit-login" alt="Guardar" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" name="Registrar" id="RegistrarProce"   onclick="generapfrr()" /> 
                    </center>       
        		</td>
			    </tr>
			  </table>
		  </form>

        </div>
	<!--  OPINION UAA ------------------------------------------------------------------- -->
	<!--  OPINION UAA ------------------------------------------------------------------- -->
	<!--  OPINION UAA ------------------------------------------------------------------- -->
    <div id="p9" class="todosContPasos pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Opinión Técnica de la UAA   </h3>
        <?php
		  //buscamos oficios de la opinion a la UAA
		  $ofSQL = "SELECT *,oficios.folio as OficioFolio FROM oficios_contenido INNER JOIN oficios ON oficios_contenido.folio = oficios.folio WHERE oficios.tipo = 'opinion_UAA_PFRR' AND oficios_contenido.num_accion  = '".$accion."' AND status <> 0 order by oficios.fecha_oficio desc LIMIT 1 ";
		  $ofSQL = $conexion->select($ofSQL,false);
		  $tUA = mysql_num_rows($ofSQL);
		  $rUA = mysql_fetch_array($ofSQL);
		  //-------------------------------------------------------------------------------------------
		  if(cambioEstado($accion,19)) $cambiaEdo19 = 1; 
		  else $cambiaEdo19 = 0;
		  //-------------------------------------------------------------------------------------------
		
		if($tUA == 0) { $disabledUA = "disabled"; ?>
            <div id="message-redXX">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="red-left">
                           No hay oficio de Opinión Técnica de la UAA... <a href="?cont=pfrr_oficios">Si no lo ha creado haga click aqui para crearlo</a>
                        </td>
                        <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=' $$("#message-redXX").slideUp()'  alt="" /></a></td>
                    </tr>
                </table>
            </div>
         <?php } else {
			 $disabledUA = ""; 
		 }
		 ?>
		<script>
        $$( "#fechaAcuseUAA" ).datepicker({
         // dateFormat: formatoFecha,
              changeMonth: false,
              numberOfMonths: 1,
              showAnim:'slideDown',
              minDate: '01/10/2015',
			  maxDate: '30/10/2015',
              beforeShowDay: noLaborales
			  /*
              onClose: function( selectedDate ) 
              {
                var fechaMas90 = sumaNaturales(selectedDate,90); 
                $$("#fechaUltimaActuacionMas90").val(fechaMas90);  
              }*/
          });//	//
		  </script>
        

        <center>
        <form name="formOpinionUAA">
        <table class='feDif' width='80%' align='center'>
        	<tr >
              <td width="50%" class="etiquetaPo">Oficio de la Opinión Técnica UAA:</td>
              <td><label for="monto"></label>
              <input name="folioUAA"  type="text"  class="redonda5"  id="folioUAA" value="<?php echo $rUA['OficioFolio'] ?>" readonly <?php echo $disabledUA ?> ></td>
            </tr>
            
        	<tr >
              <td class="etiquetaPo">Fecha del Oficio:</td>
              <td><label for="monto"></label>
              <input name="fechaUAA"  type="text"  class="redonda5"  id="fechaUAA" value="<?php echo fechaNormal($rUA['fecha_oficio']) ?>" readonly <?php echo $disabledUA ?> ></td>
            </tr>
            
        	<tr >
              <td class="etiquetaPo">Acuse del Oficio:</td>
              <td><label for="monto"></label>
              <input name="fechaAcuseUAA"  type="text"  class="redonda5"  id="fechaAcuseUAA" value="" readonly <?php echo $disabledUA ?> ></td>
            </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='acuseOpinionUAA("<?php echo $cambiaEdo19 ?>")' <?php //echo $disabledUA ?> /> </center> </td> </tr>
        </form>

     </div>
	<!--  ULTIMA ACTUACION ------------------------------------------------------------------- -->
	<!--  ULTIMA ACTUACION ------------------------------------------------------------------- -->
	<!--  ULTIMA ACTUACION ------------------------------------------------------------------- -->
    <div id="p8" class="todosContPasos pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Última Actuación   </h3>
        <?php 
		  	$menFinal = "";
			// buscamos si falta algun presunto por terminar 
			$sql2=$conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$r["num_accion"]."' AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND tipo <> 'titularTESOFE') and status <> '0' ORDER BY cont ");
			while($r2 = mysql_fetch_array ($sql2))
			{
				$presuntoNoValido = false;
				// ver X presuntos
				$sql3=$conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$r2["num_accion"]."' AND idPresunto = ".$r2['cont']." ");
				$numAud = mysql_num_rows($sql3);
				
				if($numAud != 0 )
				{
					$tipo1 = false;
					$tipo4 = false;
					//$tipo5 = false;
					$msj = "";
					$mensaje = "";
					$error = 0;
					$presunto = "";
		
					while($r3 = mysql_fetch_array ($sql3))
					{
						if($r3['comparece'] == "ncn") $presuntoNoValido = true;

						$presunto = $r3['presunto'];
						if($r3['tipo'] == 1) $tipo1 = true;
						if($r3['tipo'] == 4) $tipo4 = true;
						if($r3['tipo'] == 5) $tipo5 = true;
						if($r3['tipo'] == 6) $tipo6 = true;
						if($r3['tipo'] == 7) $tipo7 = true;
						//----------------------------------------
					}
					//vemos si esta en el arrary el proceso
					if($tipo1 == false) {$error = 1; $msj .= "Citatorio, "; }
					if($tipo4 == false) {$error = 1; $msj .= "fecha de Pruebas. "; }
					//if($tipo5 == false) {$error = 1; $msj .= "fecha de Admisión, "; }
					//if($tipo6 == false) {$error = 1; $msj .= "fecha de Desahogo, "; }
					//if($tipo7 == false) {$error = 1; $msj .= "fecha de Alegatos"; }
					
					if($error == 1 && !$presuntoNoValido) 
					{
						$mensaje .= "- El presunto  ".$presunto." no tiene ".$msj;
						$menFinal .= $mensaje."<br>";
						$msj = "";
					}
				}else{
					$menFinal .= "- El presunto ".$r2['nombre']." no tiene Citatorio, fecha de Pruebas, fecha de Admisión, fecha de Desahogo, fecha de Alegatos<br>";
				}
			} // fin while y vuelve a evaluar al siguiente presunto
		//-----------------------------------------------------------------------------------------------------
		//-----------------------------------------------------------------------------------------------------
		if($menFinal != "") { $disabledUltimaActuacion = "disabled";?>
            <div id="message-redXX">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="red-left">
                           <?php echo $menFinal ?>
                        </td>
                        <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=' $$("#message-redXX").slideUp()'  alt="" /></a></td>
                    </tr>
                </table>
            </div>
         <?php } 
		 /*
		if($pasoUAA) { $disabledUltimaActuacion = "disabled";?>
            <div id="message-redXX">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="red-left">
                           Esta acción ya paso a Opinión Técnica de la UAA. 
                        </td>
                        <td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=' $$("#message-redXX").slideUp()'  alt="" /></a></td>
                    </tr>
                </table>
            </div>
         <?php } else { 
		 */?>
            <div id="message-yellowXX">
                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="yellow-left">
                           Llene este formulario solo si no se enviará a Opinión Técnica de la UAA. 
                        </td>
                        <td class="yellow-right"><a class="close-yellow"><img src="images/table/icon_close_yellow.gif" onClick=' $$("#message-yellowXX").slideUp()'  alt="" /></a></td>
                    </tr>
                </table>
            </div>
         <?php //} 
		//-------------------------------------------------------------------------------------------
		if(cambioEstado($accion,28)) $cambiaEdo = 1; 
		else $cambiaEdo = 0;
		//-------------------------------------------------------------------------------------------
		  $sql=$conexion->select("SELECT fecha_pruebas FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND tipo = 5 ORDER BY fecha_pruebas DESC LIMIT 1 "); 
		  $noAle = mysql_num_rows($sql);
		  $res = mysql_fetch_array($sql);
		  //echo fechaNormal($res['fecha_pruebas']);
		?>
         <?php $Factual = date("d/m/Y",strtotime ( '-3 month' , strtotime(date("Y-m-d")) ))?>
		<script>
        $$( "#fechaUltimaActuacion" ).datepicker({
         // dateFormat: formatoFecha,
              changeMonth: false,
              numberOfMonths: 1,
              showAnim:'slideDown',
              //minDate: '<?php echo fechaNormal($res['fecha_pruebas']) ?>',
			  minDate: '01/10/2015' ,
              beforeShowDay: noLaborales,
              onClose: function( selectedDate ) 
              {
                var fechaMas90 = sumaNaturales(selectedDate,90); 
                $$("#fechaUltimaActuacionMas90").val(fechaMas90);  
              }
          });//	//
		  </script>
        

        <center>
        <form name="formUltimaActuacion">
        <table class='feDif' width='80%' align='center'>
        	<tr >
              <td class="etiquetaPo">Fecha Última Actuación:</td>
              <td><label for="monto"></label>
              <input name="fechaUltimaActuacion"  type="text"  class="redonda5"  id="fechaUltimaActuacion" value="<?php echo $fechaUAA ?>" readonly <?php echo $disabledUltimaActuacion ?> ></td>
            </tr>
            
        	<tr >
              <td class="etiquetaPo">Límite de 90 días:</td>
              <td><label for="monto"></label>
              <input name="fechaUltimaActuacionMas90"  type="text"  class="redonda5"  id="fechaUltimaActuacionMas90" value="<?php echo $fecha90 ?>" readonly <?php echo $disabledUltimaActuacion ?> ></td>
            </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='FeultimaActuacion("<?php echo $cambiaEdo ?>")' <?php echo $disabledUltimaActuacion ?> /> </center> </td> </tr>
        </form>

     </div>
     
	<!--  CIERRE DE INSTRUCCION ------------------------------------------------------------------- -->
	<!--  CIERRE DE INSTRUCCION ------------------------------------------------------------------- -->
	<!--  CIERRE DE INSTRUCCION ------------------------------------------------------------------- -->

    <div id="p6" class="todosContPasos pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Cierre de Instrucción   </h3>
		<?php
		//-------------------------------------------------------------------------------------------
		if(cambioEstado($accion,22)) $cambiaEdo = 1; 
		else $cambiaEdo = 0;
		//-------------------------------------------------------------------------------------------
		?>
        <center>
        <form name="formCierreInstruccion">
        <table class='feDif' width='80%' align='center'>
        	<tr >
              <td class="etiquetaPo">Fecha de Cierre de Instrucción:</td>
              <td><label for="monto"></label>
              <input name="fechaCierreInstruccion"  type="text"  class="redonda5"  id="fechaCierreInstruccion" value="" readonly <?php echo $disabledfechaCierreInstruccion ?> ></td>
            </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='FecierreInstruccionx("<?php echo $cambiaEdo ?>")' <?php echo $disabledfechaCierreInstruccion ?> /> </center> </td> </tr>
          <tr><td colspan='2'> <br><br> <center> <input type='button' value='Sobreseimiento' class='submit_line' onclick='Sobreseer("<?php echo $cambiaEdo ?>")' <?php echo $disabledfechaCierreInstruccion ?> /> </center> </td> </tr>

        </form>

     </div>
 <!-- ----------------------------- DIV EMISION DE LA RESOLUCION --------------------------------- -->

	<div id="p5" class="todosContPasos pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Emisión de la Resolución  </h3>
		<?php
		//-------------------------------------------------------------------------------------------
		if(cambioEstado($accion,29)) $cambiaEdo = 1; 
		else $cambiaEdo = 0;
		//-------------------------------------------------------------------------------------------
		?>
        <center>
        <form name="resolucionx">
        <table class='feDif' width='80%' align='center'>
        	<tr >
              <td class="etiquetaPo">Fecha de Resolución:</td>
              <td><label for="monto"></label>
              <input name="fechaResolucion"  type="text"  class="redonda5"  id="fechaResolucion" value="" readonly <?php echo $disabledResolucion ?> ></td>
            </tr>
        	<tr >
        	  <td class="etiquetaPo">Tipo de Resolución</td>
        	  <td><label for="tiporesolucion"></label>
        	    <select name="tiporesolucion" id="tiporesolucion" class="redonda5">
                <option value="0">Elegir</option>
                <option value="abstencion">Abstención de Sanción</option>
                <option value="responsabilidad">Con Existencia de Responsabilidad</option>
                <option value="inexistencia">Resolución de Inexistencia</option>
                <option value="sobreseimiento">Sobreseimiento</option>
                
      	      </select></td>
      	  </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Emisionresolucionx("<?php echo $cambiaEdo ?>","<?php echo $accion ?>","<?php echo $_REQUEST['usuario']  ?>")'  /> </center> </td> </tr>
        </form>

     </div>
<!--------------------------------------------------- DIV NOTIFICAR RESOLUCION ----------------------------------------------------------------->
    <div id="p7" class="todosContPasos pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        
             <?php 
			  //buscamos oficios de la presunto responsable notificarRes_PFRR
			  //$ofSQL = "SELECT * FROM oficios_contenido INNER JOIN oficios ON oficios_contenido.folio = oficios.folio WHERE oficios.tipo = 'notificarRes_PFRR' AND oficios_contenido.num_accion  = '".$accion."' AND status <> 0 LIMIT 1";
			  //$ofSQL = $conexion->select($ofSQL,false);
			  //$tPR = mysql_num_rows($ofSQL);
			  //$PR = mysql_fetch_array($ofSQL);
			  //buscamos oficios de la presunto responsable notificarRes_PFRR
			  $ofSQL = "SELECT * FROM pfrr_historial  WHERE num_accion  = '".$accion."' AND (estadoTramite = 23 OR estadoTramite = 24 OR estadoTramite = 25 OR estadoTramite = 26) AND status <> 0 LIMIT 1";
			  $ofSQL = $conexion->select($ofSQL,false);
			  $tPR = mysql_num_rows($ofSQL);
			  $PR = mysql_fetch_array($ofSQL);
			  //buscamos oficios de la tesofe notificarRes_PFRR
			  $ofSQL = "SELECT * FROM oficios_contenido INNER JOIN oficios ON oficios_contenido.folio = oficios.folio WHERE oficios.tipo = 'tesofe_PFRR' AND oficios_contenido.num_accion  = '".$accion."' AND status <> 0 LIMIT 1";
			  $ofSQL = $conexion->select($ofSQL,false);
			  $tTE = mysql_num_rows($ofSQL);
			  $TE = mysql_fetch_array($ofSQL);
			  //buscamos oficios de la ef
			  $ofSQL = "SELECT * FROM oficios_contenido INNER JOIN oficios ON oficios_contenido.folio = oficios.folio WHERE oficios.tipo = 'notificarResEF_PFRR' AND oficios_contenido.num_accion  = '".$accion."' AND status <> 0 LIMIT 1";
			  $ofSQL = $conexion->select($ofSQL,false);
			  $tEF = mysql_num_rows($ofSQL);
			  $EF = mysql_fetch_array($ofSQL);
			  //buscamos oficios de la icc
			  $ofSQL = "SELECT * FROM oficios_contenido INNER JOIN oficios ON oficios_contenido.folio = oficios.folio WHERE oficios.tipo = 'notificarResICC_PFRR' AND oficios_contenido.num_accion  = '".$accion."' AND status <> 0 LIMIT 1";
			  $ofSQL = $conexion->select($ofSQL,false);
			  $tIC = mysql_num_rows($ofSQL);
			  $IC = mysql_fetch_array($ofSQL);
			  
			  
			  $sql=$conexion->select("SELECT estadoTramite,oficioRecepcion from pfrr_historial WHERE num_accion='".$accion."' and estadoTramite LIKE '%24%' ");
			  $tr = mysql_num_rows($sql);
			  
			  while($tf = mysql_fetch_array($sql)){
			  	if($tf['estadoTramite'] == 24) { $disableP = "disabled"; $fechaAcuseP = fechaNormal($tf['oficioRecepcion']); }
			  	if($tf['estadoTramite'] == 24.1) { $disableT = "disabled"; $fechaAcuseT = fechaNormal($tf['oficioRecepcion']); }
			  	if($tf['estadoTramite'] == 24.2) { $disableE = "disabled"; $fechaAcuseE = fechaNormal($tf['oficioRecepcion']); }
			  	if($tf['estadoTramite'] == 24.3) { $disableI = "disabled"; $fechaAcuseI = fechaNormal($tf['oficioRecepcion']); }
			  }
			  
			  
			  $sql=$conexion->select("SELECT tipo from pfrr_historial WHERE num_accion='".$accion."' and estadoTramite=29 limit 1");
			  $tipo = mysql_fetch_array($sql);
				//-------------------------------------------------------------------------------------------
				if($tipo["tipo"] == "abstencion" || stripos($tipo["tipo"],"abstencion") !== false)
				{
					$tipoRes = "abstencion";
					$edoT = 23;
					if(cambioEstado($accion,23)) $cambiaEdo = 1; 
					else $cambiaEdo = 0;
				}
				
				if($tipo["tipo"] == "responsabilidad" || stripos($tipo["tipo"],"Existencia de Responsabilidad") !== false)
				{
					$tipoRes = "responsabilidad";
					$edoT = 24;
					if(cambioEstado($accion,24)) $cambiaEdo = 1; 
					else $cambiaEdo = 0;
				}
				
				if($tipo["tipo"] == "inexistencia" || stripos($tipo["tipo"],"inexistencia") !== false)
				{
					$tipoRes = "inexistencia";
					$edoT = 25;
					if(cambioEstado($accion,25)) $cambiaEdo = 1; 
					else $cambiaEdo = 0;
				}
			
				if($tipo["tipo"] == "sobreseimiento" || stripos($tipo["tipo"],"sobreseimiento") !== false)
				{
					$tipoRes = "sobreseimiento";
					$edoT = 26;
					if(cambioEstado($accion,26)) $cambiaEdo = 1; 
					else $cambiaEdo = 0;
				}
				//-------------------------------------------------------------------------------------------
				//-------------------------------------------------------------------------------------------
				  $sqlres=$conexion->select("SELECT detalle_edo_tramite,resolucion,tipo_resolucion FROM pfrr WHERE num_accion = '".$accion."' "); 
				  $noRes = mysql_num_rows($sqlres);
				  $res = mysql_fetch_array($sqlres);
				  
				  if($tipoRes == "") {
					  
					  if($res['tipo_resolucion'] != "" ){
							  if(stripos($res['tipo_resolucion'],"Existencia de Responsabilidad") !== false) {
								$tipoRes = "responsabilidad";
								$edoT = 24;
							  }
								
							  if(stripos($res['tipo_resolucion'],"responsabilidad") !== false) {
								$tipoRes = "responsabilidad";
								$edoT = 24;
							  }
							  
							  if(stripos($res['tipo_resolucion'],"Inexistencia") !== false) {
								$tipoRes = "inexistencia";
								$edoT = 25;
							  }
							  
							  if(stripos($res['tipo_resolucion'],"Abstencion") !== false) {
								$tipoRes = "abstencion";
								$edoT = 23;
							  }
							  
							  if(stripos($res['tipo_resolucion'],"Sobreseimiento") !== false) {
								$tipoRes = "sobreseimiento";
								$edoT = 26;
							  }
					  }
					  else
					  {
						  if($res['detalle_edo_tramite'] == 24) {
							  $tipoRes = "responsabilidad";
								$edoT = 24;
						  }
						  if($res['detalle_edo_tramite'] == 25) {
							  $tipoRes = "inexistencia";
								$edoT = 25;
						  }
						  if($res['detalle_edo_tramite'] == 23) {
							  $tipoRes = "abstencion";
								$edoT = 23;
						  }
						  if($res['detalle_edo_tramite'] == 26) {
							  $tipoRes = "sobreseimiento";
								$edoT = 26;
						  }
					  }
					  
					  
				  }
				?>
                <style>
				 .notiVarias{ float:left; width:290px;}
				</style>
				<script>
				$$( "#notificacionresoP" ).datepicker({
				 // dateFormat: formatoFecha,
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: '<?php echo fechaNormal($res['resolucion']) ?>',
					  beforeShowDay: noLaborales
				  });//	//
				$$( "#notificacionresoT" ).datepicker({
				 // dateFormat: formatoFecha,
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: '<?php echo fechaNormal($res['resolucion']) ?>',
					  beforeShowDay: noLaborales
				  });//	//
				$$( "#notificacionresoE" ).datepicker({
				 // dateFormat: formatoFecha,
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: '<?php echo fechaNormal($res['resolucion']) ?>',
					  beforeShowDay: noLaborales
				  });//	//
				$$( "#notificacionresoI" ).datepicker({
				 // dateFormat: formatoFecha,
					  changeMonth: false,
					  numberOfMonths: 1,
					  showAnim:'slideDown',
					  minDate: '<?php echo fechaNormal($res['resolucion']) ?>',
					  beforeShowDay: noLaborales
				  });//	//
				  </script>
                  
        			<h3 class="poTitulosPasos">Notificación de la Resolución con <?php echo ucfirst($tipoRes) ?> </h3>

                    <div id="notificacionPresunto" class="notiVarias">
                        <form name="NotiresoP">
                        <table class='feDif' width='80%' align='center'>
                            <!--
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
                              <td><label for="monto"></label>
                              <input name="oficioT"  type="text"  class="redonda5"  id="oficioT" value="<?php echo $PR['folio'] ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                             </td>	 
                            </tr>
                            -->
                           <!--
                            <tr >
                              <td class="etiquetaPo">Fecha de Notificación:</td>
                              <td><label for="monto"></label>
                              <input name="notificacionresoP"  type="text"  class="redonda5"  id="notificacionresoP" value="<?php echo fechaNormal($PR['oficioRecepcion']); ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                             </td>	 
                            </tr>
                            -->
                            <tr>
                                <th colspan="2">
                                <?php 
									if($tPR) { $disableP = "disabled"; } 
									$queryP = "SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' AND (fecha_notificacion_resolucion <> '' AND fecha_notificacion_resolucion <> '0000-00-00') AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND tipo <> 'titularTESOFE') ORDER BY fecha_notificacion_resolucion ASC LIMIT 1";
									$sqlPre = $conexion->select($queryP,false);
									$rdPre = mysql_fetch_array($sqlPre);
								?>
                                
                                    <br><br> Notificacion a Presunto <?php echo fechaNormal($rdPre['fecha_notificacion_resolucion']) ?> <br><br>
                                </th>
                            </tr>
                            <tr>
                            	<td colspan="2">
                                <div class="redonda5" style="height:150px; overflow:auto; border:1px solid #666; padding:5PX;">
                                <?php
								$sqlPre = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."'  AND status = '1' AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND tipo <> 'titularTESOFE') ",false);
								$tablaPre = '<table width="100%">';
								while($rPre = mysql_fetch_array($sqlPre))
								{									
									$i++;
									$res = $i%2;
									if($res == 0) $estilo = "class='non'";
									else $estilo = "class='par'";
									//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
									$tablaPre .= '<tr '.$estilo.'><td class="ancho200">'.$rPre['nombre'].'</td>';
									
									if($rPre['fecha_notificacion_resolucion'] == '0000-00-00' || $rPre['fecha_notificacion_resolucion'] == '' )
										$tablaPre .= '<td class="ancho100" align="center"><a href="#" title="Proceso de Presuntos" class="icon-10 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(300,500,"Fecha Notificación &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$rPre['nombre'].'",100,"cont/pfrr_presuntos_notificacion.php","idPresuntop='.$rPre['cont'].'&numAccion='.$rPre['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'&fecha='.$res['resolucion'].'&tipoRes='.$tipoRes.'&entidad='.urlencode($r['entidad']).'")\'></a>';
									else 
										$tablaPre .= '<td class="ancho100" align="center">'.fechaNormal($rPre['fecha_notificacion_resolucion']);
										
									$tablaPre .= '</td></tr>';
								}
								$tablaPre .= '</table>';
								echo $tablaPre;
								?>
                                </div>
                                </td>
                            <tr>
                        </table>
                        <!--
                          <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores("<?php echo $cambiaEdo ?>","<?php echo $tipoRes ?>","presunto")' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> /> </center> </td> </tr>
                        -->
                        </form>
                    </div>
        <?php if($tipoRes == "responsabilidad") { ?>
                    <div id="notificacionTESOFE" class="notiVarias">
                        <form name="NotiresoT">
                        <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2">
									<?php if(!$TE) { $disableT = "disabled"; ?>
                                        <div class="mensajeRojo">No existe Oficio<br> <a href="?cont=pfrr_oficios">Click aqui para crearlo</a></div>
                                     <?php } ?>
                                    <br><br> Notificacion a TESOFE<br>
                                </th>
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
                              <td><label for="monto"></label>
                              <input name="oficioT"  type="text"  class="redonda5"  id="oficioT" value="<?php echo $TE['folio'] ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                             </td>	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Notificación:</td>
                              <td><label for="monto"></label>
                              <input name="notificacionresoT"  type="text"  class="redonda5"  id="notificacionresoT" value="<?php echo $fechaAcuseT ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?>></td>
                             </td>	 
                            </tr>
                        </table>
                          <input name="tipoResolucionTESOFE"    id="tipoResolucionTESOFE" type="hidden" value="<?php echo $tipoRes ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>></td>
                          <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores("<?php echo $cambiaEdo ?>","<?php echo $tipoRes ?>","tesofe")' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableT ?>/> </center> </td> </tr>
                        </form>
                    </div>
                   
                   <?php } // end responsabilidad ?> 
                    
                    <div id="notificacionEF" class="notiVarias">
                        <form name="NotiresoE">
                        <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2"> 
									<?php if(!$tEF) { $disableE = "disabled"; ?>
                                        <div class="mensajeRojo">No existe Oficio<br> <a href="?cont=pfrr_oficios">Click aqui para crearlo</a></div>
                                     <?php } ?>
                                	<br><br>Notificacion a EF<br>
                                    </th>
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
                              <td width="150">
                              <?php echo $EF['folio'] ?>
                              <!--
                              <label for="monto"></label>
                              <input name="oficioE"  type="text"  class="redonda5"  id="oficioE" value="<?php echo $EF['folio'] ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                              -->
                             </td>	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Emision:</td>
                              <td width="150">
                              <?php echo fechaNormal($EF['fecha_oficio']) ?>
                              <!--
                              <label for="monto"></label>
                              <input name="notificacionresoE"  type="text"  class="redonda5"  id="notificacionresoE" value="<?php echo $fechaAcuseE  ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>></td>
                              -->
                             </td>	 
                            </tr>
                        </table>
                        <!--
                          <input name="tipoResolucionEF"    id="tipoResolucionEF" type="hidden" value="<?php echo $tipoRes ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>></td>
                          <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores("<?php echo $cambiaEdo ?>","<?php echo $tipoRes ?>","ef")' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>/> </center> </td> </tr>
                       -->
                        </form>
                    </div>
                    
                    
                    <div id="notificacionICC" class="notiVarias">
                        <form name="NotiresoI">
                        <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2"> 
                                <?php if(!$tIC) { $disableI = "disabled"; ?>
                                        <div class="mensajeRojo">No existe Oficio<br> <a href="?cont=pfrr_oficios">Click aqui para crearlo</a></div>
                                     <?php } ?>
                                <br><br>Notificacion a ICC <br></th>
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
                              <td width="150">
                              <?php echo $IC['folio'] ?>
                              <!--
                              <label for="monto"></label>
                              <input name="oficioI"  type="text"  class="redonda5"  id="oficioI" value="<?php echo $IC['folio'] ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableP ?> ></td>
                              -->
                             </td>	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Emision:</td>
                              <td width="150">
                              <?php echo fechaNormal($IC['fecha_oficio']) ?>
                              <!--
                              <label for="monto"></label>
                              <input name="notificacionresoI"  type="text"  class="redonda5"  id="notificacionresoI" value="<?php echo $fechaAcuseI ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableI ?>></td>
                              -->
                             </td>	 
                            </tr>
                        </table>
                          <!--
                          <input name="tipoResolucionICC"    id="tipoResolucionICC" type="hidden" value="<?php echo $tipoRes ?>" readonly <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableE ?>></td>
                          <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='Fechatipores("<?php echo $cambiaEdo ?>","<?php echo $tipoRes ?>","icc")' <?php echo $disabledfechaCierreInstruccion ?> <?php echo $disableI ?>/> </center> </td> </tr>
                          -->
                        </form>
                    </div>
                    
        
     </div>





      
    </div>
</div>
<!--  end content-table  -->
</body>
</html>

<?php
	mysql_free_result($sql);
	mysql_free_result($sql2);
	mysql_free_result($sql3);
?>
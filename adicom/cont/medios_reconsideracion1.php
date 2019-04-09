<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- BUSCAMOS DATOS DE LA ACCION -------------------------------------
$query = "SELECT * FROM actores_recurso WHERE recurso_reconsideracion = '".$_REQUEST['recurso_reconsideracion']."' ";
$sql = $conexion->select($query,false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//---------------------------------Muestra oficios y fechas según el estado de trámite
if($_REQUEST['edotram'] == 35)
{
	$query5= "SELECT * FROM oficios WHERE oficio_referencia LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND tipo = 'ofic_SAT' LIMIT 1";
	$sq5 = $conexion->select($query5,false);
	$prev5 = mysql_fetch_array($sq5);
	$totofs = mysql_num_rows($sq5);
		if($totofs == 0){$ofs = 0; $des="disabled"; }else{$ofs = 1; $des="enable";}
		
	$query6= "SELECT * FROM `medio_historial` WHERE `Tipo` LIKE 'ofic_SAT' AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND `Actor` LIKE '%".$_REQUEST['presunto']."%' LIMIT 1";
	$sq6 = $conexion->select($query6,false);
	$prev6= mysql_fetch_array($sq6);
	$totofsn = mysql_num_rows($sq6);
		if($totofsn == 0){ $desn="enable"; $oc="button"; }else{ $desn="disabled"; $oc="hidden"; }
	
	$query1= "SELECT * FROM oficios WHERE oficio_referencia LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND tipo = 'rr_prevencion' LIMIT 1";
	$sq = $conexion->select($query1,false);
	$prev = mysql_fetch_array($sq);
	$totofprev = mysql_num_rows($sq);
		if($totofprev == 0){$ofprev = 0;}else{$ofprev = 1;}
} 

if($_REQUEST['edotram'] == 36)
{
	$query9= "SELECT * FROM oficios WHERE oficio_referencia LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND tipo = 'diligencias_UAA' AND `status`!='0' LIMIT 1";
	$sq9 = $conexion->select($query9,false);
	$prev9 = mysql_fetch_array($sq9);
	$todili = mysql_num_rows($sq9);
		if($todili == 0){$ofdi = 0; $desdi="disabled"; }else{$ofdi = 1; $desdi="enable";}
		
	$query10= "SELECT * FROM `medio_historial` WHERE `Tipo` = 'diligencias_UAA' AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' ORDER BY `id` DESC LIMIT 1";
	$sq10 = $conexion->select($query10,false);
	$prev10= mysql_fetch_array($sq10);
	$todil1 = mysql_num_rows($sq10);
		if($todil1 == 0 && $todili != 0 ){ $desdi1="enable"; $ocdil="button"; }else{ $desdi1="disabled"; $ocdil="hidden"; }
		
}

if($_REQUEST['edotram'] == 39 or $_REQUEST['edotram'] == 391)
{
		$query7= "SELECT * FROM oficios WHERE oficio_referencia LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND (tipo = 'rr_not_acuerdo_s' OR tipo = 'rr_not_des_s') LIMIT 1";
	$sq7 = $conexion->select($query7,false);
	$prev7 = mysql_fetch_array($sq7);
	$tosat = mysql_num_rows($sq7);
		if($tosat == 0){$ofs1 = 0; $des1="disabled"; }else{$ofs1 = 1; $des1="enable";}
		
	$query8= "SELECT * FROM `medio_historial` WHERE `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND (`Tipo` = 'rr_not_acuerdo_s' OR `Tipo` = 'rr_not_des_s') LIMIT 1";
	$sq8 = $conexion->select($query8,false);
	$prev8= mysql_fetch_array($sq8);
	$tosa = mysql_num_rows($sq8);
		if($tosa == 0){ $desn1="enable"; $oc1="button"; }else{ $desn1="disabled"; $oc1="hidden"; }
	
	$query2= "SELECT * FROM oficios WHERE oficio_referencia LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND (tipo = 'rr_not_acuerdo' OR tipo = 'rr_not_des_r') LIMIT 1";
	$sq2 = $conexion->select($query2,false);
	$not = mysql_fetch_array($sq2);
	$totofnot = mysql_num_rows($sq2);
		if($totofnot == 0){$ofnoti = 0;}else{$ofnoti = 1;}
} 

if($_REQUEST['edotram'] == 41 or $_REQUEST['edotram'] == 42 or $_REQUEST['edotram'] == 43)
{
	/*$query3= "SELECT * FROM oficios WHERE tipo = 'rr_not_resol_act' AND oficio_referencia ='".$r['recurso_reconsideracion']."' ";
	$sq3 = $conexion->select($query3,false);
	$resact = mysql_fetch_array($sq3);
	$totofact = mysql_num_rows($sq3);
		if($totofact == 0){$ofresolac = 0;}else{$ofresolac = 1;}*/
		
		$query11= "SELECT * FROM `medio_historial` WHERE (`Tipo` LIKE 'rr_notpre' OR `Tipo` LIKE 'rr_not_resol_act') AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' LIMIT 1";
		$sq11 = $conexion->select($query11,false);
		$prev11= mysql_fetch_array($sq11);
		$tonot0 = mysql_num_rows($sq11);
			if($tonot0 == 0){ $desnot0="enable"; $ocnot0="button"; }else{ $desnot0="disabled"; $ocnot0="hidden"; }

	$query4= "SELECT * FROM oficios WHERE tipo = 'rr_not_resol_sat' AND oficio_referencia ='".$r['recurso_reconsideracion']."' ";
	$sq4 = $conexion->select($query4,false);
	$ressat = mysql_fetch_array($sq4);	
	$totofsat = mysql_num_rows($sq4);
		if($totofsat == 0){$ofresolsat = 0;}else{$ofresolsat = 1;}


		$query12= "SELECT * FROM `medio_historial` WHERE (`Tipo` LIKE 'rr_notsat' OR `Tipo` LIKE 'rr_not_resol_sat') AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' LIMIT 1";
		$sq1a1 = $conexion->select($query12,false);
		$prev12= mysql_fetch_array($sq1a1);
		$tonota0 = mysql_num_rows($sq1a1);
			if($tonota0 == 0){ $desnota0="enable"; $ocnota0="button"; }else{ $desnota0="disabled"; $ocnota0="hidden"; }
/////////// muestra oficios para la EF y el ICC ##falta cambiar variables y parametros##
	$queryef= "SELECT * FROM oficios WHERE tipo = 'rr_not_ef' AND oficio_referencia ='".$r['recurso_reconsideracion']."' ";
	$sqlef = $conexion->select($queryef,false);
	$resef = mysql_fetch_array($sqlef);
	$totef = mysql_num_rows($sqlef);
		if($totef == 0){$ofresef = 0;}else{$ofresef = 1;}
		
		$querye= "SELECT * FROM `medio_historial` WHERE `Tipo` LIKE 'rr_not_ef' AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' LIMIT 1";
		$sqle = $conexion->select($querye,false);
		$prevef= mysql_fetch_array($sqle);
		$tonoef = mysql_num_rows($sqle);
			if($tonoef == 0){ $desnotef="enable"; $ocnotef="button"; }else{ $desnotef="disabled"; $ocnotef="hidden"; }

	$queryicc= "SELECT * FROM oficios WHERE tipo = 'rr_not_icc' AND oficio_referencia ='".$r['recurso_reconsideracion']."' ";
	$sqlicc = $conexion->select($queryicc,false);
	$resicc = mysql_fetch_array($sqlicc);	
	$totoficc = mysql_num_rows($sqlicc);
		if($totoficc == 0){$ofresolicc = 0;}else{$ofresolicc = 1;}


		$queryic= "SELECT * FROM `medio_historial` WHERE `Tipo` LIKE 'rr_not_icc' AND `Procedimiento` LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND `Accion` LIKE '%".$_REQUEST['num_accion']."%' LIMIT 1";
		$sqlic = $conexion->select($queryic,false);
		$previc= mysql_fetch_array($sqlic);
		$tonotic = mysql_num_rows($sqlic);
			if($tonotic == 0){ $desnotic="enable"; $ocnotic="button"; }else{ $desnotic="disabled"; $ocnotic="hidden"; }
}
?>

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

//------Se despliega calendario para acusar la fecha del OFICIO DE PREVISION AL ACTOR  	
	$$( "#fecha_acuse_oficio_req" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
    });

//------Se despliega calendario para acusar la fecha de NOTIFICACIÓN DEL ACUERDO AL ACTOR  
	$$( "#fecha_acuse_oficio_noti_actor" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	
//------Se despliega calendario para acusar la fecha de CIERRRE DE INSTRUCCIÖN
	$$( "#fecha_cierre_ins" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
    });
	
//------Se despliega calendario para acusar la fecha deL TIPO DE EMISION (CONFIRMA,REVOCA,MODIFICA)
	$$( "#fecha_emi_res" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
    });
	  
//------Se despliega calendario para acusar la fecha de notificación al SAT	
	$$( "#satff" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	  
//------Se despliega calendario para acusar la fecha de notificación al SAT en Acuerdo de Admisión/Desechamiento
	$$( "#satff1" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	  
//------Se despliega calendario para acusar la fecha de notificación de diligencias
	$$( "#fecha_acuse_oficio_dil" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
});

//------Se despliega calendario para acusar la fecha de notificación al actor	
	$$( "#notofact" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	 
//------Se despliega calendario para acusar la fecha de notificación al SAT	
	$$( "#notofsat" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	  
	  //------Se despliega calendario para acusar la fecha de notificación al actor	
	$$( "#notof_ef" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });
	 
//------Se despliega calendario para acusar la fecha de notificación al SAT	
	$$( "#notof_ic" ).datepicker({
	  changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "17/10/2016",
	  maxDate: "31/10/2016",
	  beforeShowDay: noLaborales
      });

//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
$$(document).ready(function(){

//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
//---- EDO 33 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------

 $$("#guardacheck").click(function()
 {
		if ($$('#auto:checked').val() && $$('#nomrec:checked').val() && $$('#dom:checked').val() && $$('#acto:checked').val()  && $$('#fecha:checked').val() && $$('#agrav:checked').val() && $$('#resol:checked').val() && $$('#cons:checked').val())
	
			{

			var activos=1;
						var datosUrl = "&recurso="+$$("#recurso").val()+"&ActivoSi="+$$("#ActivoSi").val();	
		
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(34); ?> \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadro();
					}
				
				});
			} //Fin de if confirma
			}
		else
			{
			
			var activos=0;
	var datosUrl = "&auto="+$$("#auto:checked").val()+"&nomrec="+$$("#nomrec:checked").val()+"&dom="+$$("#dom:checked").val()+"&acto="+$$("#acto:checked").val()+"&fecha="+$$("#fecha:checked").val()+"&agrav="+$$("#agrav:checked").val()+"&resol="+$$("#resol:checked").val()+"&cons="+$$("#cons:checked").val()+"&recurso="+$$("#recurso").val()+"&ActivoNo="+$$("#ActivoNo").val();	

			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(35); ?> \n\n Esto le ayudará a generar el oficio de prevensión por la falta de informamción, recordando que solo se puede crear una vez. \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadro();
					}
				
				});
			} //Fin de if confirma
			
			}//Fin de if activos = 0
 });
//---- EDO 34 Acuse fecha de Admisión / DESECHAMIENTO --------------------------

  $$("#extemporaneo").click(function(){
		
		var datosUrl = $$("#formCheckList").serialize();
			
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(34); ?> \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		
  });

 //---- EDO 34 REQUERIMIENTO DE INFORMACION AL RECURRENTE DEL RECURSO DE RECONSIDERACION--------------------------
 //---- Esta parte del código envía al archivo medios_reconsideracion de procesosAjax lo que contiene el formulario formRecursoRec por medio de la variable datosUrl

  $$("#guardaSol").click(function(){
		
		var datosUrl = $$("#formRecursoRec").serialize()+"&numAccion="+$$("#accion_req").val()+"&procedimiento="+$$("#procedimiento_req").val()+"&nombre_actor="+$$("#actor_req").val()+"&actor="+$$("#id_actor_req").val()+"&id_rec_req="+$$("#id_rec_req").val()+"&ofiFolio="+$$("#oficio_req").val()+
		
		 
		"&ofiActor="+$$("#oficio_actor").val()+
		
		"&ofiFecha="+$$("#fecha_oficio_req").val()+"&fecha_acuseo="+$$("#fecha_acuse_oficio_req").val()+"&rr_reqRecRec="+$$("#tipoForm").val()+"&usuario="+$$("#us_req").val();
				
	  	if(comprobarForm("formRecursoRec"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(107); ?> \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
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
  //--------- Acuse fecha de Admisión / DESECHAMIENTO -------------------------------------------------
  
    $$("#guardaNot").click(function(){
		
		var datosUrl = $$("#formNotifica").serialize();
				
	  	if(comprobarForm("formNotifica"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(104); ?> \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
  //---- EDO 34 o 36 ACUERDO DE ADMISION --------------------------
  $$("#btnAdmDes").click(function(){

	  	var datosUrl = $$("#formAdmDes").serialize();
		
		if(comprobarForm("formAdmDes"))
		{
		if($$("#tipoAdm").val() == "admision") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(39); ?> \n\n ¿Desea continuar?");
		else var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(39); ?> \n\n ¿Desea continuar?");
			
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); 
						//alert("Pasó lo siguiente: "+quepaso);
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
 
 //---- EDO 36 CIERRE DE INSTRUCCIÓN --------------------------
 
  $$("#btnCierreIns").click(function(){
	  
		var datosUrl = $$("#formCierreIns").serialize();
		
		if(comprobarForm("formCierreIns"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(40); ?>  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  $$("#btnEmiRes").click(function(){

	  	var datosUrl = $$("#formEmiRes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formEmiRes"))
		{

			if($$("#tipo_emi_res").val() == "confirmarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(41); ?> \n\n ¿Desea continuar?");
			if($$("#tipo_emi_res").val() == "modificarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(42); ?> \n\n ¿Desea continuar?");
			if($$("#tipo_emi_res").val() == "revocarResolucion") var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(47); ?> \n\n ¿Desea continuar?");

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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
    $$("#btnNotRes").click(function(){

	  	var datosUrl = $$("#formNotRes").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
		
		if(comprobarForm("formNotRes"))
		{
			var confirma = confirm("Cambiará el estado a: \n\n - <?php echo dameEstado(43); ?>  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  ///////Notificación presunto / sat
  
      $$("#fechanotpresat").click(function(){

	  	var datosUrl = $$("#NotiresoT").serialize();
		
		if(comprobarForm("NotiresoT"))
		{
			var confirma = confirm("Notificación al Actor / SAT.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
       $$("#fechanotpresat1").click(function(){

	  	var datosUrl = $$("#NotiresoT1").serialize();
		
		if(comprobarForm("NotiresoT1"))
		{
			var confirma = confirm("Notificación al Actor / SAT.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
         $$("#nssat").click(function(){
	  	var datosUrl = $$("#nsat").serialize();
		if(comprobarForm("nsat"))
		{
			var confirma = confirm("Notificación al Actor / SAT.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
  $$("#nssat1").click(function(){
	  	var datosUrl = $$("#nsat1").serialize();
		if(comprobarForm("nsat1"))
		{
			var confirma = confirm("Notificación al Actor / SAT.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
    $$("#guardaDil").click(function(){
	  	var datosUrl = $$("#formDili").serialize();
		if(comprobarForm("formDili"))
		{
			var confirma = confirm("Envío de información a la UAA \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
         $$("#fechanoteficc").click(function(){

	  	var datosUrl = $$("#Notieficc").serialize();
		
		if(comprobarForm("Notieficc"))
		{
			var confirma = confirm("Notificación a EF / ICC.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
  
           $$("#fechanoteficc1").click(function(){

	  	var datosUrl = $$("#Notieficc1").serialize();
		
		if(comprobarForm("Notieficc1"))
		{
			var confirma = confirm("Notificación a EF / ICC.  \n\n ¿Desea continuar?");
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
					url: "procesosAjax/medios_reconcideracion.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						cerrarCuadro();
					}
				});
			}
		}
  });
}); 	
//----------------------------- FUNCIONES PARA FORMULARIOS -----------------------------------------------------------
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

function validaAcuerdo(valor){
	if(valor == "admision"){
		$$("#labelAdmDes").html("Fecha de Acuerdo de Admisión del<br> RR");	
		$$("#contAdmDes").html("<input type='text' name='fechaAdmDes' id='fechaAdmDes'  class='redonda5' /> ");	
		$$("#labelAdmDes2").html("");
		$$("#contAdmDes2").html("");
					
		
		$$( "#fechaAdmDes" ).datepicker({
		 // dateFormat: formatoFecha,
		  changeMonth: false,
		  numberOfMonths: 1,
		  showAnim:'slideDown',
		  minDate: "17/10/2016",
		  maxDate: "31/10/2016",
		  beforeShowDay: noLaborales
		 //minDate: fechaMinimaRec,
		 //beforeShowDay: noLaborales
		  //onClose: function( selectedDate ) {
			//$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
		  //}
		});
	}else{
		
		$$("#labelAdmDes").html("Motivo");	
		$$("#contAdmDes").html("<textarea cols='50' rows='2' name='motivoAdmDes' id='motivoAdmDes' class='redonda5'> </textarea>");	
		$$("#labelAdmDes2").html("Fecha de Acuerdo de Desechamiento del<br> RR");
		$$("#contAdmDes2").html("<input type='text' name='fechaAdmDes2' id='fechaAdmDes2' class='redonda5' /> ");	
			
		
		$$( "#fechaAdmDes2" ).datepicker({
		 // dateFormat: formatoFecha,
		  changeMonth: false,
		  numberOfMonths: 1,
		  showAnim:'slideDown',
		  minDate: "17/10/2016",
		  maxDate: "31/10/2016",
		  beforeShowDay: noLaborales
		 //minDate: fechaMinimaRec,
		 //beforeShowDay: noLaborales
		  //onClose: function( selectedDate ) {
			//$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
		  //}<strong></strong>
		
		});
		
	}
}
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<input type="hidden" name="medios_numAccion" id="medios_numAccion" value="<?php echo $_REQUEST['numAccion'] ?>"/>
<input type="hidden" name="medios_usuario" id="medios_usuario" value="<?php echo $_REQUEST['usuario'] ?>"/>
<input type="hidden" name="medios_direccion" id="medios_direccion" value="<?php echo $_REQUEST['direccion'] ?>"/>
<input type="hidden" name="medios_idPresunto" id="medios_idPresunto" value="<?php echo $_REQUEST['idPresuntop'] ?>"/>
<input type="hidden" name="medios_presunto" id="medios_presunto" value="<?php echo $_REQUEST['presunto'] ?>"/>
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<!-- onclick='muestraDivEdo(".$r['id_estado'].")'>".$r['detalle_estado']." -->
<?php
$pa = "||";
$inter = $pa; $preve = $pa; $admde = $pa; $notac = $pa; $dilig = $pa; $cidin = $pa; $emres = $pa; $notif = $pa;
//------------------- MENSAJE DE ESPERA ACCION ------------------------------
//--En esta parte del código, se habilita la ventana para selecionar los checkbox para la interposición del recurso
if($r['detalle_edo_tramite'] == 33 )
{
	$inter = "INTERPOSICIÓN";
	$onclickP0 = "onclick=\"muestraPestana(0)\"";
	$txtPaso0 = "pasosActivo";
	echo "<script>	$$(function() {	$$('#paso_0').fadeIn();	});	</script>";
}
//--- Se crea el oficio de prevension al actor 
if($r['detalle_edo_tramite'] == 35)
{
	$preve = "PREVENCIÓN";
	$onclickP2 = "onclick=\"muestraPestana(2)\"";
	$txtPaso2 = "pasosActivo";
	$acceso2 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_2').fadeIn();	});	</script>";
}
//--- En esta parte del código, se evalúa que si la acción esta en estado 107, se muestre el mensaje que se encuentra en proceso de prevención
/*if($r['detalle_edo_tramite'] == 107)
{
	$txtPaso9 = "pasosActivo";
	echo "<script>	$$(function() {	$$('#paso_9').fadeIn();	});	</script>";
	
	
}*/
//--- En esta parte del código, se habilita la ventana para admitir o desechar el recurso
if($r['detalle_edo_tramite'] == 34 )
{
	$admde = "ADMISIÓN/DESECHAMIENTO";
	$onclickP8 = "onclick=\"muestraPestana(8)\"";	
	$txtPaso8 = "pasosActivo";
	$acceso8 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_8').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para notificar el acuerdo 
if ($r['detalle_edo_tramite'] == 39 or $r['detalle_edo_tramite'] == 391 )
{
	$notac = "NOTIFICACIÓN ACUERDO";
    $onclickP3 = "onclick=\"muestraPestana(3)\"";	
	$txtPaso3 = "pasosActivo";
	$acceso3 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_3').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para el cierre de instrucción
if ($r['detalle_edo_tramite'] == 36)
{
	$cidin = "CIERRE DE INSTRUCCIÓN";
	$dilig = "DILIGENCIAS";
    $onclickP5 = "onclick=\"muestraPestana(5)\"";	
	$txtPaso5 = "pasosActivo";
	$acceso5 = "pfAccesible";
	$onclickP9 = "onclick=\"muestraPestana(9)\"";
	//$txtPaso9 = "pasosActivo";
	$acceso9 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_5').fadeIn();	});	</script>";
}
/*//--- En esta parte del código, se habilita la ventana para desahogo de diligencias
if ($r['detalle_edo_tramite'] == 38)
{
    $onclickP5 = "onclick=\"muestraPestana(9)\"";	
	$txtPaso5 = "pasosActivo";
	$acceso5 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_9').fadeIn();	});	</script>";
	
	
}*/
//--- En esta parte del código, se habilita la ventana para selecionar cualquier opcion confirmar, modificar o revocar
if($r['detalle_edo_tramite'] == 40)
{
	$emres = "EMITIR RESOLUCIÓN";
	$onclickP6 = "onclick=\"muestraPestana(6)\"";	
	$txtPaso6 = "pasosActivo";
	$acceso6 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_6').fadeIn();	});	</script>";
}
//--- En esta parte del código, se habilita la ventana para notificar la resolución
if($r['detalle_edo_tramite'] == 41 or $r['detalle_edo_tramite'] == 42 or $r['detalle_edo_tramite'] == 43)
{
	$notif = "NOTIFICAR";
	$onclickP7 = "onclick=\"muestraPestana(7)\"";	
	$txtPaso7 = "pasosActivo";
	$acceso7 = "pfAccesible";
	echo "<script>	$$(function() {	$$('#paso_7').fadeIn();	});	</script>";
}
//------------En proceso de envio de información para interposición------------------
if($r['detalle_edo_tramite'] == 35.1 or $r['detalle_edo_tramite'] == 351)
{
	$txtPaso10 = "pasosActivo";
	$acceso10 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_10').fadeIn();	});	</script>";
	}
//------------El recurso de reconsideración fue desechado------------------
if($r['detalle_edo_tramite'] == 37 )
{
	$txtPaso11 = "pasosActivo";
	$acceso11 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_11').fadeIn();	});	</script>";
	}
	//------------El recurso de reconsideración fue desechado------------------
if($r['detalle_edo_tramite'] == 44 )
{
	$txtPaso12 = "pasosActivo";
	$acceso12 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_12').fadeIn();	});	</script>";
	}
	
		//------------El recurso de reconsideración esta en opinión técnica------------------
if($r['detalle_edo_tramite'] == 361 )
{
	$txtPaso13 = "pasosActivo";
	$acceso13 = "pfAccesible";	
	echo "<script>	$$(function() {	$$('#paso_13').fadeIn();	});	</script>";
	}
//---------------------------------------------------------------------------
//------------------------ ACTIVAR PESTAÑAS ---------------------------------
//---------------------------------------------------------------------------
if(ACTIVAPESTANAS == true)
{
	$onclickP0 = " onclick=\"muestraDivEdo('paso_0')\" ";
	$onclickP1 = " onclick=\"muestraDivEdo('paso_1')\" ";
	$onclickP2 = " onclick=\"muestraDivEdo('paso_2')\" ";
	$onclickP3 = " onclick=\"muestraDivEdo('paso_3')\" ";
	$onclickP4 = " onclick=\"muestraDivEdo('paso_4')\" ";
	$onclickP5 = " onclick=\"muestraDivEdo('paso_5')\" ";
	$onclickP6 = " onclick=\"muestraDivEdo('paso_6')\" ";
	$onclickP7 = " onclick=\"muestraDivEdo('paso_7')\" ";
	$onclickP8 = " onclick=\"muestraDivEdo('paso_8')\" ";
	$onclickP9 = " onclick=\"muestraDivEdo('paso_9')\" ";
	$onclickP10 = " onclick=\"muestraDivEdo('paso_10')\" ";
	$onclickP11 = " onclick=\"muestraDivEdo('paso_11')\" ";
	$onclickP11 = " onclick=\"muestraDivEdo('paso_12')\" ";
	$onclickP12 = " onclick=\"muestraDivEdo('paso_13')\" ";
	
	$txtPaso1 = " pasosActivo ";
	$txtPaso2 = " pasosActivo ";
	$txtPaso3 = " pasosActivo ";
	$txtPaso4 = " pasosActivo ";
	$txtPaso5 = " pasosActivo ";
	$txtPaso6 = " pasosActivo ";
	$txtPaso7 = " pasosActivo ";
	$txtPaso8 = " pasosActivo ";
	$txtPaso9 = " pasosActivo ";
	$txtPaso10 = " pasosActivo ";
	$txtPaso11 = " pasosActivo ";
	$txtPaso12 = " pasosActivo ";
	$txtPaso13 = " pasosActivo ";
	
	$acceso1 = " pfAccesible ";
	$acceso2 = " pfAccesible ";
	$acceso3 = " pfAccesible ";
	$acceso4 = " pfAccesible ";
	$acceso5 = " pfAccesible ";
	$acceso6 = " pfAccesible ";
	$acceso7 = " pfAccesible ";
	$acceso8 = " pfAccesible ";
	$acceso9 = " pfAccesible ";
	$acceso10 = " pfAccesible ";
	$acceso11 = " pfAccesible ";
	$acceso12 = " pfAccesible ";
	$acceso13 = " pfAccesible ";
}
?>
<style>

#flotante
{
	position: absolute;
	display:none;
	font-family:Arial;
	font-size:0.8em;
	border:1px solid #808080;
	background-color:#f1f1f1;
}
</style>

<script type="text/javascript">
<!--
//Funcion que muestra el div en la posicion del mouse
function showdiv(event)
{
	//determina un margen de pixels del div al raton
	margin=5;

	//La variable IE determina si estamos utilizando IE
	var IE = document.all?true:false;
	//Si no utilizamos IE capturamos el evento del mouse
	if (!IE) document.captureEvents(Event.MOUSEMOVE)

	var tempX = 0;
	var tempY = 0;

	if(IE)
	{ //para IE
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	}else{ //para netscape
		tempX = event.pageX;
		tempY = event.pageY;
	}
	if (tempX < 0){tempX = 0;}
	if (tempY < 0){tempY = 0;}

	//modificamos el valor del id "posicion" para indicar la posicion del mouse
	document.getElementById('posicion').innerHTML/*="PosX = "+tempX+" | PosY = "+tempY*/;

	document.getElementById('flotante').style.top = (tempY+margin);
	document.getElementById('flotante').style.left = (tempX+margin);
	document.getElementById('flotante').style.display='block';
	return;
}
-->
</script>
<div class="contPasos">
    <div class="encPasos">
	
       <a title="INTERPOSICIÓN"><div id='paso0' onmouseover="showdiv(event);" onmousemove="showdiv(event);" onmouseout="javascript:document.getElementById('flotante').style.display='none';"<?php echo $onclickP0 ?> class="todosPasos <?php echo $txtPaso0 ?> <?php echo $acceso0 ?> pasos"><?php echo $inter ?></div></a>
       <a title="PREVENCIÓN"><div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><?php echo $preve ?></div></a>
       <a title="ADMISIÓN/DESECHAMIENTO"><div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"><?php echo $admde ?></div></a>
       <a title="NOTIFICACIÓN ACUERDO"><div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"><?php echo $notac ?></div></a>
       <a title="DILIGENCIAS"><div id='paso9' <?php echo $onclickP9 ?> class="todosPasos <?php echo $txtPaso9 ?> <?php echo $acceso9 ?> pasos"><?php echo $dilig ?></div></a>
       <a title="CIERRE DE INSTRUCCIÓN"><div id='paso5' <?php echo $onclickP5 ?> class="todosPasos <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"><?php echo $cidin ?></div></a>
       <a title="EMITIR RESOLUCIÓN"><div id='paso6' <?php echo $onclickP6 ?> class="todosPasos <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"><?php echo $emres ?></div></a>
       <a title="NOTIFICAR"><div id='paso7' <?php echo $onclickP7 ?> class="todosPasos <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"><?php echo $notif ?></div></a>
      
	</div>
	<div id="flotante">
	Código
	<br /><span id="posicion"></span>
</div>
    
    <div class="resPasosMedios redonda10">
    
    	
        <!-- -------------- EDO TRAMITE 33-------------------- -->
        <!-- -------------- EDO TRAMITE 33-------------------- -->
        <div id='paso_1' class="divsEdos">
        	
        </div>
        <!-- -------------- EDO TRAMITE 33 INFO AL RECURRENTE -------------------- -->
        <!-- -------------- EDO TRAMITE 33 INFO AL RECURRENTE -------------------- -->
        
        <div id='paso_0' class="divsEdos"> <br>
         <h3>Selecciona las opciones con las que cuenta el Oficio de Reconsideración</h3> <br> <br> <br>
          <center>
                   
                   <form name="formCheckList" id="formCheckList">

                   <table class="tablaRecurso" width="90%" align="center">
                   
    <tr>
    
    <table class="tablaRecurso" width="90%" align="center">
    <input type="hidden" name="recurso" id="recurso" value="<?php echo $r['recurso_reconsideracion']; ?>" />
	<input type="hidden" name="chec_acc" id="chec_acc" value="<?php echo $r['num_accion'];?>"/>
	<input type="hidden" name="chec_actor" id="chec_actor" value="<?php echo $r ['actor']; ?>"/>
    <input type="hidden" name="ActivoSi" id="ActivoSi" value="1"/>
    <input type="hidden" name="ActivoNo" id="ActivoNo" value="0"/>
   <td valign="top" width="30%" class=""><input type="checkbox" name="auto" id="auto" value="on">
    <label for="auto"> Autoridad Adminsitrativa que emitió acto impugnado </label> <br> <br></td>
    
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="nomrec" id="nomrec" value="on">
      <label for="nomrec">Nombre del Recurrente</label> <br> <br></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="dom" id="dom" value="on">
      <label for="dom">Domicilio</label> <br> <br></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="acto" id="acto" value="on">
      <label for="acto">Acto que recurre</label> <br> <br></td>
      
  <tr>
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="fecha" id="fecha" value="on">
      <label for="fecha">Fecha de Notificación</label></td>
      
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="agrav" id="agrav" value="on">
      <label for="agrav">Agravios</label></td>
      
    <td valign="top"  width="30%"  class=""><input type="checkbox" name="resol" id="resol" value="on">
      <label for="resol">Copia de Resolución </label></td>
      
    <td valign="top"  width="30%"   class=""><input type="checkbox" name="cons" id="cons" value="on">
      <label for="cons">Copia de constancia de notificación </label><br></td>
	  

   
                  <!-- ---------------------------- ----------------------------->
                  <!-- ---------------------------- ----------------------------->
                </tr>
				</table> 
				</tr>
                <tr>

                  
                </tr>
              </table>
                      <center> <br>
<br />	

<input type='button' name='guardacheck' id='guardacheck' value='Guardar'  class='submit_line'  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='button' name='extemporaneo' id='extemporaneo' value='Extemporáneo'  class='submit_line'  />
<input type='hidden' name='extemp' id='extemp' value='extemporaneo'/>
</center>

            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </form> 
		</center>
          </div>
        

           
        <!-- -------------- EDO TRAMITE 34 INFO AL RECURRENTE -------------------- -->
        <!-- -------------- EDO TRAMITE 34 INFO AL RECURRENTE -------------------- -->

<div id='paso_2' class="divsEdos"><br />
        <h3>Solicitar Información al Recurrente		</h3>
        <center>
        <table border="0" align="center">
		<tr>
		<td>
		
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
				         
		<div id="notificacionSAT" class="notiVarias">
                <form name="nsat" id="nsat">
					<input type="hidden" name="accion_reqns" id="accion_reqns" value="<?php echo $r['num_accion'];?>"/>
					<input type="hidden" name="procedimiento_reqns" id="procedimiento_reqns" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                    <input type="hidden" name="id_actor_reqns" id="id_actor_reqns" value="<?php echo $r ['actor']; ?>"/>
					
						<table class='feDif' width='90%' align='center'>
                         <tr>
                            <th colspan="2"> <?php if($ofs == 0) { ?>
                              <div class="mensajeRojo">No existe Oficio<br />
                                <a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
                              <p>
                              <?php } ?>
                              <br />
                              Notificacion al SAT</p>
                              <p><br />
                                <br />
                              </p>
                            </th>
                         </tr>
                          <tr >
                            <td class="etiquetaPo">Oficio:</td>
                            <td><input name="satn" id="satn" type="text"  class="redonda5" value = "<?php echo $prev5['folio']?>" <?php echo $desn ?> readonly /></td>
                          </tr>
                            <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="satnf" id="satnf" class="redonda5" value = "<?php echo fechaNormal($prev5['fecha_oficio'])?>" <?php echo $desn ?> readonly /></td>
                    </tr><tr >
                            <td class="etiquetaPo">Notificación del Oficio:</td>
                            <td>
                              <input type="text" readonly="readonly" name="satff" id="satff" class="redonda5" value = "<?php echo fechaNormal($prev6['Fecha_Acuse'])?>" <?php echo $desn ?> /></td>
                          </tr>
						<tr>
                        <td height="54" colspan="2" align="center">
						<br />
                       <center>
					   <input type="hidden" name="tipoForm" id="tipoForm" value="ofic_SAT" />
                          <input type='<?php echo $oc ?>' value='Guardar Fecha' class='submit_line' id="nssat" name="nssat" <?php echo $desn ?>/>
                       </center>
                       </td>
                       </tr>
                       </table>
				</form>
        </div>
        </td>        
        <td>
		   <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <div id="notificacionTESOFE" class="notiVarias">
         <form name="formRecursoRec" id="formRecursoRec">
                <table width="90%" class="feDif">
                    <tr>
                      <th colspan="2" align="center">
                         <?php if($ofprev == 0) {  ?>
                            <div class="mensajeRojo">
                              <p>No existe Oficio... <br /> 
                              <a href="?cont=medios_rr_oficios&nombre=<?php echo trim($r['actor']) ?>">Click aqui para crearlo</a></p></div>
                              <p>
                              <?php } ?>
                              <br> 
                      Notificacion al Presunto</p>
                              <p>&nbsp;</p>
                              <p>&nbsp;</p>
                      </th>

                    </tr>
                    <tr>
                    	
                        <input type="hidden" name="accion_req" id="accion_req" value="<?php echo $r['num_accion'] ?>"/>
						<input type="hidden" name="procedimiento_req" id="procedimiento_req" value="<?php echo $r ['recurso_reconsideracion']; ?>"/>
                        <input type="hidden" name="id_actor_req" id="id_actor_req" value="<?php echo $r ['actor']; ?>"/>
                        <input type="hidden" name="id_rec_req" id="id_rec_req" value="<?php echo $r ['entidad']; ?>"/>
                        <input type="hidden" name="us_req" id="us_req" value="<?php echo $_REQUEST['usuario'] ?>"/>
						                        
                        <td class="etiquetaPo">Oficio:</td>
                        <td><input type="text" name="oficio_req" id="oficio_req" class="redonda5" value="<?php echo $prev['folio'] ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_oficio_req" id="fecha_oficio_req" class="redonda5" value="<?php echo fechaNormal($prev['fecha_oficio']) ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" readonly="readonly" name="fecha_acuse_oficio_req" id="fecha_acuse_oficio_req" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td height="54" colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_reqRecRec" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="guardaSol" <?php echo $des ?> />
                        </td>
                    </tr>
                </table>
                </form>
         </div>
		</td>
		</tr>
		</table>
		<br />
		<br /><br />
        </center>
		</div>
            
        
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO -------------------- -->
        <!-- -------------- EDO TRAMITE 34 o 36 ADMISIÓN / DESECHAMIENTO-------------------- -->
    
       
        <div id='paso_8' class="divsEdos"><br />
            <h3>Admisión o Desechamiento del Recurso de Reconsideración</h3>
            <br> 
            <br> <br> 
            <center>
            <table  border="0"  align="center">
              <tr>
                <td>
                <center>
            <br />
                <form name="formAdmDes" id="formAdmDes">
                <table width="95%" class="feDif">
                    <tr>
                        <td class="etiquetaPo">Tipo de Acuerdo: </td>
                        <td>
                        
                   <input type="hidden" name="accion_reqns1" id="accion_reqns1" value="<?php echo $r['num_accion'];?>"/>
				   <input type="hidden" name="id_actor_reqns1" id="id_actor_reqns1" value="<?php echo $r ['actor']; ?>"/>
                    <input type="hidden"  name ="numeroderecurso" id="numeroderecurso" value="<?php echo $r ['recurso_reconsideracion']; ?>" />
                        	<select name="tipoAdm" id="tipoAdm" class="redonda5" onchange="validaAcuerdo(this.value)">
                                <option value="">Seleccione acuerdo...</option>
								<?php
									$queryex= "SELECT * FROM `medio_historial` WHERE Procedimiento LIKE '%".$_REQUEST['recurso_reconsideracion']."%' AND Tipo = 'extemporaneo' AND id_estado_tramite = 34 LIMIT 1";
									$sqlex = $conexion->select($queryex,false);
									$prev_ext = mysql_fetch_array($sqlex);
									if($prev_ext['Tipo'] != "extemporaneo") {
								?>
                            	<option value="admision">Admisión del Recurso de Reconsideración</option>
								<?php } ?>
                            	<option value="desechamiento">Desechamiento del Recurso de Reconsideración</option>
                          </select>                                               
                        </td>
                    </tr>
                      <tr>
                    	<td id="labelAdmDes" class="etiquetaPo"> </td>
                    	<td id="contAdmDes"> </td>
                      </tr>
                      <tr>
                        <td id="labelAdmDes2" class="etiquetaPo"> </td>                        
                        <td id="contAdmDes2"> </td>
                      </tr>  
                      <tr>
                        <td colspan="2" align="center"><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_AdmDes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnAdmDes" <?php echo $des1 ?> />
                        </td>
                      </tr>                    
                </table>
                </form>
  </center>
                </td>
              </tr>
            </table>
        
            </center>
            <br /><br />
        </div>
        
        
        
         <!-- -------------- EDO TRAMITE NOTIFICA AL SAT / ACTOR -------------------- -->
         <!-- -------------- EDO TRAMITE NOTIFICA AL SAT / ACTOR -------------------- -->

        <div id='paso_3' class="divsEdos"><br />
        
     <h3>Notificación del Acuerdo </h3>
		 <br> 
            <center>
            <table  border="0"  align="center">
              <tr>	 
                <td>
                <div id="notificacionSAT" class="notiVarias">
                <form name="nsat1" id="nsat1">
					<input type="hidden" name="accion_reqns" id="accion_reqns" value="<?php echo $r['num_accion'];?>"/>
					<input type="hidden" name="procedimiento_reqns" id="procedimiento_reqns" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                    <input type="hidden" name="id_actor_reqns" id="id_actor_reqns" value="<?php echo $r ['actor']; ?>"/>
					<input type="hidden" name="ntr" id="ntr" value="<?php echo $r ['detalle_edo_tramite']; ?>"/>
						<table class='feDif' width='90%' align='center'>
                         <tr>
                            <th colspan="2"> <?php if($ofs1 == 0) { ?>
                              <div class="mensajeRojo">No existe Oficio...<br />
                                <a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
                              <p>
                              <?php } ?>
                              <br />
                              Notificacion al SAT</p>
                              <p><br />
                                <br />
                              </p>
                            </th>
                         </tr>
                          <tr >
                            <td class="etiquetaPo">Oficio  de notificación al SAT:</td>
                            <td><input name="satn" id="satn" type="text"  class="redonda5" value = "<?php echo $prev7['folio']?>" <?php echo $desn1 ?> readonly /></td>
                          </tr>
                            <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="satnf" id="satnf" class="redonda5" value = "<?php echo fechaNormal($prev7['fecha_oficio'])?>" <?php echo $desn1 ?> readonly /></td>
                    </tr><tr >
                            <td class="etiquetaPo">Notificación del Oficio:</td>
                            <td>
                              <input type="text" readonly="readonly" name="satff1" id="satff1" class="redonda5" value = "<?php echo fechaNormal($prev8['Fecha_Acuse'])?>" <?php echo $desn1 ?> /></td>
                          </tr>
						<tr>
                        <td  colspan="2" align="center">
						<br />
                       <center> 
					   <input type="hidden" name="tipoForm" id="tipoForm" value="ofic_SAT1" /> 
                          <input type='<?php echo $oc1 ?>' value='Guardar Fecha' class='submit_line' id="nssat1" name="nssat1" <?php echo $desn1 ?>/></center></td>
                       </tr>
                       </table>
				</form>
        </div>
                </td>

				<td>
				<center>
		<div id="notificacionSAT" class="notiVarias">
        <form name="formNotifica" id="formNotifica">
                <table width="90%" class="feDif">
                    <tr>
                        <th colspan="2"> <?php if($ofnoti == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio...<br />
                                <a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
						<p>
                         <?php } ?>
						 </br>
						 Notificacion al Recurrente</p>
							<p><br />
                            <br />
                            </p>
						</th>

                    </tr>
                    <tr>
                    	
                        <input type="hidden" name="accion_not" id="accion_not" value="<?php echo $r['num_accion'];?>"/>
						<input type="hidden" name="procedimiento_not" id="procedimiento_not" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                        <input type="hidden" name="id_actor_not" id="id_actor_not" value="<?php echo $r ['actor']; ?>"/>         
                        <input type="hidden" name="edtram" id="edtram" value="<?php echo $_REQUEST['edotram']; ?>"/>
						<input type="hidden" name="us_not" id="us_not" value="<?php echo $_REQUEST['usuario'] ?>"/>
						
                        <td class="etiquetaPo">Oficio de notificación al actor:</td>
                        <td><input type="text" name="ofi_not" id="ofi_not" class="redonda5" value="<?php echo $not['folio'] ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_ofi_not" id="fecha_ofi_not" class="redonda5" value="<?php echo fechaNormal($not['fecha_oficio']) ?>" readonly /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" readonly="readonly" name="fecha_acuse_oficio_noti_actor" id="fecha_acuse_oficio_noti_actor" class="redonda5" /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
						</br>
						<center>
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_notifica" />
                            <input type="button" name="Guardar" value="Guardar" class="submit_line" id="guardaNot"/>
                        </center>
						</td>
                    </tr>
                </table>
                </form>
				</div>
				</center>
				</td>
			
			</tr>
            </table>
            </center>
            <br>
      
            </div>
        
        <!-- -------------- EDO TRAMITE DESAHOGO DE DILIGENCIAS -------------------- -->
        <!-- -------------- EDO TRAMITE DESAHOGO DE DILIGENCIAS -------------------- -->

        <div id='paso_9' class="divsEdos"><br />
        
     <h3>Resolución del Recurso de Reconsideración </h3><br> 
      
        <form name="formDili" id="formDili">
                <table width="90%" class="feDif">
                    <tr>
                        <td colspan="2">
						
                         <?php if($ofdi == 0) {  ?>
                            <div class="mensajeRojo">No existe Oficio... <a href="?cont=medios_rr_oficios&nombre=<?php echo trim($r['actor']) ?>">Click aqui para crearlo</a></div><br> <br>
                         <?php } ?>
                        </td>

                    </tr>
                    <tr>
                    	
                        <input type="hidden" name="accion_dil" id="accion_dil" value="<?php echo $r['num_accion'];?>"/>
						<input type="hidden" name="procedimiento_dil" id="procedimiento_dil" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                       
                        <input type="hidden" name="id_actor_dil" id="id_actor_dil" value="<?php echo $r ['actor']; ?>"/>         
                        <input type="hidden" name="edtramdil" id="edtramdil" value="<?php echo $_REQUEST['edotram']; ?>"/>
						<input type="hidden" name="us_dil" id="us_dil" value="<?php echo $_REQUEST['usuario'] ?>"/>
						
                        <td class="etiquetaPo">Oficio: <br /> </td>
                        <td><input type="text" name="ofi_dil" id="ofi_dil" class="redonda5" value="<?php echo $prev9['folio'] ?>" readonly <?php echo $desdi1 ?> /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha del Oficio:</td>
                        <td><input type="text" name="fecha_ofi_dil" id="fecha_ofi_dil" class="redonda5" value="<?php echo fechaNormal($prev9['fecha_oficio']) ?>" readonly <?php echo $desdi1 ?> /></td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Notificación del Oficio:</td>
                        <td><input type="text" readonly="readonly" name="fecha_acuse_oficio_dil" id="fecha_acuse_oficio_dil" class="redonda5" value="<?php echo fechaNormal($prev10['Fecha_Acuse']) ?>" <?php echo $desdi1 ?> /></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br />
                            <input type="hidden" name="tipoForm" id="tipoForm" value="rr_not_diligencia" />
                            <input type="<?php echo $ocdil ?>" name="Guardar" value="Guardar" class="submit_line" id="guardaDil"/>
                        </td>
                    </tr>
                </table>
                </form>
            </div>
        
        <!-- -------------- EDO TRAMITE 40 CIERRE INSTRUCCION -------------------- -->
        <!-- -------------- EDO TRAMITE 40 CIERRE INSTRUCCION -------------------- -->
        <div id='paso_5' class="divsEdos">
            <h3>
                    <br />Resolución del Recurso de Reconsideración </h3>
            <center>
            <br />
                <form name="formCierreIns" id="formCierreIns">
                <table width="60%" class="feDif">
                    <tr>
                    <br />
                    <br />
                    <br />
                  
                        <td class="etiquetaPo">Fecha del <br />cierre de instrucción:</td>
                        <td><input type="text" readonly="readonly" name="fecha_cierre_ins" id="fecha_cierre_ins" class="redonda5" /></td>
                    </tr>
                    <tr>
							<input type="hidden" name="accion_ci" id="accion_ci" value="<?php echo $r['num_accion'];?>"/>
							<input type="hidden" name="procedimiento_ci" id="procedimiento_ci" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                       		<input type="hidden" name="id_actor_ci" id="id_actor_ci" value="<?php echo $r ['actor']; ?>"/>         
							<input type="hidden" name="us_ci" id="us_ci" value="<?php echo $_REQUEST['usuario'] ?>"/>
                        <td colspan="2" align="center"><br />
                        <br />                                          
                        <br />
                        <br />
						<input type="hidden" name="tipoForm" id="tipoForm" value="rr_cierreins" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnCierreIns"/>
                        <br />
                        <br />
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
        <!-- -------------- EDO TRAMITE 41 EMISION DE LA RESOLUCIÓN -------------------- -->
        <!-- -------------- EDO TRAMITE 42 EMISION DE LA RESOLUCIÓN -------------------- -->
        <div id='paso_6' class="divsEdos">
            <h3><br />Resolución del Recurso de Reconsideración</h3>
            <center>
            <br />
                <form name="formEmiRes" id="formEmiRes">
                <table width="60%" class="feDif">
                    <tr>
						<input type="hidden" name="accion_emr" id="accion_emr" value="<?php echo $r['num_accion'];?>"/>
						<input type="hidden" name="procedimiento_emr" id="procedimiento_emr" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                        <input type="hidden" name="id_actor_emr" id="id_actor_emr" value="<?php echo $r ['actor']; ?>"/>
						<input type="hidden" name="us_emr" id="us_emr" value="<?php echo $_REQUEST['usuario'] ?>"/>
                    <br /><br /><br />
                        <td class="etiquetaPo">Tipo de Resolución:</td>
                        <td>
                        	<select name="tipo_emi_res" id="tipo_emi_res" class="redonda5">
                            	<option value="">Seleccione una opcion... </option>
                            	<option value="confirmarResolucion"> Confirmar Resolución Definitiva </option>
                            	<option value="modificarResolucion"> Modificar Resolución Definitiva</option>
                            	<option value="revocarResolucion"> Revocar Resolución Definitiva</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="etiquetaPo">Fecha de la emisión <br />de la Resolución:</td>
                        <td><input type="text" readonly="readonly" name="fecha_emi_res" id="fecha_emi_res" class="redonda5" /></td> 
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><br /><br /><br />
                        <input type="hidden" name="tipoForm" id="tipoForm" value="rr_EmiRes" />
                        <input type="button" name="Guardar" value="Guardar" class="submit_line" id="btnEmiRes"/>
                        </td>
                    </tr>
                </table>
                </form>
            </center>
            <br /><br />
        </div>
		
        <!-- -------------- EDO NOTIFICA RESOLUCION-------------------- -->
        <!-- -------------- EDO NOTIFICA RESOLUCION-------------------- -->
		
        <div id='paso_7' class="divsEdos" align="center"><br />
            <h3 align="left">Notificación de la Resolución </h3>

		 <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
         <!-- -------------- OFICIO PRESUNTO-------------------- -->
		<table border="0">
		<tr>
		<td>
		    <div id="notificacionTESOFE" class="notiVarias">
			
                <form name="NotiresoT" id="NotiresoT">
						<input type="hidden" name="accion_notac" id="accion_notac" value="<?php echo $r['num_accion'];?>"/>
						<input type="hidden" name="procedimiento_notac" id="procedimiento_notac" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                        <input type="hidden" name="id_actor_notac" id="id_actor_notac" value="<?php echo $r ['actor']; ?>"/>         
                        <input type="hidden" name="ed_notacs" id="ed_notacs" value="<?php echo $r ['detalle_edo_tramite']; ?>"/>
						<input type="hidden" name="edtramas" id="edtramas" value="<?php echo $_REQUEST['edotram']; ?>"/>
						<input type="hidden" name="us_notas" id="us_notas" value="<?php echo $_REQUEST['usuario'] ?>"/>
                       
					   <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2">
									<!---?php// if($ofresolac == 0) {?>
                                        <div class="mensajeRojo">No existe Oficio<br> 
										<a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
									<//?php //} ?--->
                                    <br><br> 
                                    Notificacion al Recurrente<br><br>
                                </th>
                            </tr>
                            <tr >
                              <!--- td class="etiquetaPo">Oficio:</td>
                              <td><label for="monto"></label>
                              <input name="oficioT"  type="text"  class="redonda5"  id="oficioT" value="<?php echo $resact['folio'] ?>" disabled /></td--->
                             	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Notificación:</td>
                              <td><label for="monto"></label>
                              <input type="text" readonly="readonly" name="notofact" id="notofact" class="redonda5" value="<?php if($tonot0 == 1) echo fechaNormal($prev11['Fecha_Acuse'])  ?>" <?php echo $desnot0 ?> /></td>
                             	 
                            </tr>
                        </table>
                          <br><br> 
						  <center>
						  <input type="hidden" name="tipoForm" id="tipoForm" value="rr_not_resol_act" />
						  <input type="<?php echo $ocnot0 ?>" name="Guardar" value='Guardar Fecha' class='submit_line' id="fechanotpresat"/>
						  </center>  
				</form>
      </div>
        </td>        
        <td>
		
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
           <!-- -------------- OFICIO SAT-------------------- -->
				         
		<div id="notificacionTESOFE" class="notiVarias">
                <form name="NotiresoT1" id="NotiresoT1">
					<input type="hidden" name="accion_notac" id="accion_notac" value="<?php echo $r['num_accion'];?>"/>
					<input type="hidden" name="procedimiento_notac" id="procedimiento_notac" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                    <input type="hidden" name="id_actor_notac" id="id_actor_notac" value="<?php echo $r ['actor']; ?>"/>         
                    <input type="hidden" name="ed_notacs" id="ed_notacs" value="<?php echo $r ['detalle_edo_tramite']; ?>"/>
					<input type="hidden" name="edtramas" id="edtramas" value="<?php echo $_REQUEST['edotram']; ?>"/>
					<input type="hidden" name="us_notas" id="us_notas" value="<?php echo $_REQUEST['usuario'] ?>"/>
						<table class='feDif' width='80%' align='center'>
                         <tr>
                            <th colspan="2"> <?php if($ofresolsat == 0) { ?>
                              <div class="mensajeRojo">No existe Oficio<br />
                                <a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
                              <?php } ?>
                              <br /><br />
                              Notificacion al SAT<br /><br />
                            </th>
                         </tr>
                          <tr >
                            <td class="etiquetaPo">Oficio:</td>
                            <td><input name="oficioT2"  type="text"  class="redonda5"  id="oficioT2" value="<?php echo $ressat['folio'] ?>" disabled /></td>
                            <td><label for="monto5"></label></td>
                            <td></td>
                          </tr>
                          <tr >
                            <td class="etiquetaPo">Fecha de Notificación:</td>
                            <td><label for="monto5"></label>
                              <input type="text" readonly="readonly" name="notofsat" id="notofsat" class="redonda5" value="<?php if($tonota0 == 1) echo fechaNormal($prev12['Fecha_Acuse'])  ?>" <?php echo $desnota0 ?>/></td>
                          </tr>
						</table>                        
                        <br />
                        <br />
                       <center>
					   <input type="hidden" name="tipoForm" id="tipoForm" value="rr_not_resol_sat" />
                          <input type="<?php echo $ocnota0 ?>" value='Guardar Fecha' class='submit_line' id="fechanotpresat1"/>
                       </center>
				</form>
        </div>
		</td>
		<!-- -------------- OFICIO EF-------------------- -->
        <!-- -------------- OFICIO EF-------------------- -->
        <!-- -------------- OFICIO EF-------------------- -->
		<td>
		    <div id="notificacion" class="notiVarias">
			
                <form name="Notieficc" id="Notieficc">
						<input type="hidden" name="accion_notac" id="accion_notac" value="<?php echo $r['num_accion'];?>"/>
						<input type="hidden" name="procedimiento_notac" id="procedimiento_notac" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                        <input type="hidden" name="id_actor_notac" id="id_actor_notac" value="<?php echo $r ['actor']; ?>"/>         
                        <input type="hidden" name="ed_notacs" id="ed_notacs" value="<?php echo $r ['detalle_edo_tramite']; ?>"/>
						<input type="hidden" name="edtramas" id="edtramas" value="<?php echo $_REQUEST['edotram']; ?>"/>
						<input type="hidden" name="us_notas" id="us_notas" value="<?php echo $_REQUEST['usuario'] ?>"/>
                       
					   <table class='feDif' width='80%' align='center'>
                            <tr>
                                <th colspan="2">
									<?php if($ofresef == 0) {?>
                                        <div class="mensajeRojo">No existe Oficio<br> 
										<a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
									<?php } ?>
                                    <br><br> 
                                    Notificacion a la EF<br><br>
                                </th>
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Oficio:</td>
                              <td><label for="monto"></label>
                              <input name="oficioT"  type="text"  class="redonda5"  id="oficioT" value="<?php echo $resef['folio'] ?>" disabled /></td>
                             	 
                            </tr>
                            <tr >
                              <td class="etiquetaPo">Fecha de Notificación:</td>
                              <td><label for="monto"></label>
                              <input type="text" readonly="readonly" name="notof_ef" id="notof_ef" class="redonda5" value="<?php if($tonoef == 1) echo fechaNormal($prevef['Fecha_Acuse'])  ?>" <?php echo $desnotef ?> /></td>
                             	 
                            </tr>
                        </table>
                          <br><br> 
						  <center>
						  <input type="hidden" name="tipoForm" id="tipoForm" value="rr_not_ef" />
						  <input type="<?php echo $ocnotef ?>" name="Guardar" value='Guardar Fecha' class='submit_line' id="fechanoteficc"/>
						  </center>  
				</form>
      </div>
        </td>        
        <td>
		
           <!-- -------------- OFICIO ICC-------------------- -->
           <!-- -------------- OFICIO ICC-------------------- -->
           <!-- -------------- OFICIO ICC-------------------- -->
				         
		<div id="notificacion" class="notiVarias">
                <form name="Notieficc1" id="Notieficc1">
					<input type="hidden" name="accion_notac" id="accion_notac" value="<?php echo $r['num_accion'];?>"/>
					<input type="hidden" name="procedimiento_notac" id="procedimiento_notac" value="<?php echo $r ['recurso_reconsideracion'];?>"/>
                    <input type="hidden" name="id_actor_notac" id="id_actor_notac" value="<?php echo $r ['actor']; ?>"/>         
                    <input type="hidden" name="ed_notacs" id="ed_notacs" value="<?php echo $r ['detalle_edo_tramite']; ?>"/>
					<input type="hidden" name="edtramas" id="edtramas" value="<?php echo $_REQUEST['edotram']; ?>"/>
					<input type="hidden" name="us_notas" id="us_notas" value="<?php echo $_REQUEST['usuario'] ?>"/>
						<table class='feDif' width='80%' align='center'>
                         <tr>
                            <th colspan="2"> <?php if($ofresolicc == 0) { ?>
                              <div class="mensajeRojo">No existe Oficio<br />
                                <a href="?cont=medios_rr_oficios&nombre=">Click aqui para crearlo</a></div>
                              <?php } ?>
                              <br /><br />
                              Notificacion al ICC<br /><br />
                            </th>
                         </tr>
                          <tr >
                            <td class="etiquetaPo">Oficio:</td>
                            <td><input name="oficioT2"  type="text"  class="redonda5"  id="oficioT2" value="<?php echo $resicc['folio'] ?>" disabled /></td>
                            <td><label for="monto5"></label></td>
                            <td></td>
                          </tr>
                          <tr >
                            <td class="etiquetaPo">Fecha de Notificación:</td>
                            <td><label for="monto5"></label>
                              <input type="text" readonly="readonly" name="notof_ic" id="notof_ic" class="redonda5" value="<?php if($tonotic == 1) echo fechaNormal($previc['Fecha_Acuse'])  ?>" <?php echo $desnotic ?>/></td>
                          </tr>
						</table>                        
                        <br />
                        <br />
                       <center>
					   <input type="hidden" name="tipoForm" id="tipoForm" value="rr_not_icc" />
                          <input type="<?php echo $ocnotic ?>" value='Guardar Fecha' class='submit_line' id="fechanoteficc1"/>
                       </center>
				</form>
        </div>
		</td>
		</tr>
		</table>
		<br /><br /><br /><br />
		</div>
				
	<!-- ---En Opinión Ténica de la UAA, mensaje de bloqueo--- -->
	<!-- ---En Opinión Ténica de la UAA, mensaje de bloqueo--- -->
 
		<div id='paso_13' class="divsEdos"><br/>
	            <h3 align="center"><font size=5>En Opinión Ténica de la UAA</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br/><br/>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br/><br/><br/>
            <br /><br />
  </div>
		
        
        
        <!-- -------------- OPINIÓN TÉCNICA (DILIGENCIAS PANTALLA BLOQUEO)--------------------------------------------- -->
 
		<div id='paso_10' class="divsEdos"><br/>
	            <h3 align="center"><font size=5>En espera de requerimientos.</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br/><br/>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br/><br/><br/>
            <br /><br />
  </div>
		
    <!-- -------------- --------------------------------------------- -->  
		
        <div id='paso_11' class="divsEdos">
		    <br><br><br><br><br>
	            <h3 align="center"><font size=5>Recurso Desechado</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br><br>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br><br><br>
            <br /><br />
        </div>
    <!-- ------------------------------------------------------------------- -->
    <!-- -------------- --------------------------------------------- -->  
		
        <div id='paso_12' class="divsEdos">
		    <br><br><br><br><br>
	            <h3 align="center"><font size=5>Revocación de Resolución</font></h3> 
            <center>
            <br />
                <form name="info_req" id="info_req">
                <table width="60%" class="feDif">
				
					<center>
					<img src="images/warning_red.png" />
					</center> <br><br>
				<h3 align="center"><font size=5>No se pueden realizar cambios</font></h3>
				</table>
                </form>
            </center>
			<br><br><br>
            <br /><br />
        </div>
    <!-- ------------------------------------------------------------------- -->	
    </div>

</div>
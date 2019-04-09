<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//print_r($_REQUEST);

//--------------- formulario estado 33  
//--------------- formulario estado 33 

if($_REQUEST['tipoForm'] == "formCheckList")

    //$num_accion=valorSeguro($_POST['num_accion']);
	//$actor = valorSeguro($_POST['actor']);
	$auto = valorSeguro($_POST['auto']);
	$nomrec = valorSeguro($_POST['nomrec']);
	$dom = valorSeguro($_POST['dom']);
	$acto = valorSeguro($_POST['acto']);
	$fecha = valorSeguro($_POST['fecha']);
    $agrav = valorSeguro($_POST['agrav']);
	$resol = valorSeguro($_POST['resol']);
	$cons = valorSeguro($_POST['cons']);
	$recurso = valorSeguro($_POST['recurso']);
	$ActivoSi= valorSeguro ($_POST['ActivoSi']);
	$ActivoNo= valorSeguro ($_POST['ActivoNo']);
	
	
	
	if($ActivoSi=="1"){
		$query = "UPDATE actores_recurso SET
					detalle_edo_tramite = 34,
					faltantes_check_list=0,
					check_list = 1
				WHERE recurso_reconsideracion = '".$recurso."' ";
		$sql = $conexion->update($query);
	}
	
	if($ActivoNo=="0"){
		
		if($auto!="on") $on.="|auto| ";
		if($nomrec!="on") $on.="|nomrec| ";
		if($dom!="on") $on.="|dom| ";
		if($acto!="on") $on.="|acto| ";
		if($fecha!="on") $on.="|fecha| ";
		if($agrav!="on") $on.="|agrav| ";
		if($resol!="on") $on.="|resol| ";
		if($cons!="on") $on.="|cons|";

		
		$query = "UPDATE actores_recurso SET
					detalle_edo_tramite = 35,
					faltantes_check_list = '".$on."',
					check_list = 0
				WHERE recurso_reconsideracion = '".$recurso."' ";
		$sql = $conexion->update($query);
	}
//--------------- Formulario para Admisión / DESECHAMIENTO
			
if($_REQUEST['extemp'] == "extemporaneo"){
	
	$recurso = valorSeguro($_POST['recurso']);
	$extemporaneo = valorSeguro ($_POST['extemp']);
	$numAccion = valorSeguro($_POST['chec_acc']);
	$actor = valorSeguro($_POST['chec_actor']);
	$hoy=date("Y-m-d");
	
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= '34'
			  WHERE recurso_reconsideracion='".$recurso."' ";
		$sql = $conexion->update($query);
	
	$queryh = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'extemporaneo',
				Oficio = '0',
				Procedimiento = '".$recurso."',
				Fecha = '".$hoy."',
				Fecha_Acuse = '0',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = 34";
	$sqlh = $conexion->insert($queryh);	
}

//--------------- Formulario para requerimiento de información paso 107 Recursos de Reconsideracion

			
if($_REQUEST['tipoForm'] == "rr_reqRecRec"){
	
    $numAccion = valorSeguro($_POST['accion_req']);
	$procedimiento = valorSeguro($_POST['procedimiento_req']);
	$nombre_actor = valorSeguro($_POST['id_actor_req']);
	//$actor = valorSeguro($_POST['id_actor_req']);
	$ofiFolio = valorSeguro($_POST['oficio_req']);
	$ofiFecha = valorSeguro($_POST['fecha_oficio_req']);
	$fecha_acuseo = valorSeguro($_POST['fecha_acuse_oficio_req']);
	$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
	$usuario = valorSeguro ($_POST['us_req']);
	//$id_rec_req = valorSeguro($_POST['entidad']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'rr_prevencion',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 351";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= '351',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}
}	

//--------------- Formulario para 1ra notificacion SAT

			
if($_REQUEST['tipoForm'] == "ofic_SAT"){
	
    $numAccion = valorSeguro($_POST['accion_reqns']);
	$procedimiento = valorSeguro($_POST['procedimiento_reqns']);
	$nombre_actor = valorSeguro($_POST['id_actor_reqns']);
	//$actor = valorSeguro($_POST['id_actor_req']);
	$ofiFolio = valorSeguro($_POST['satn']);
	$ofiFecha = valorSeguro($_POST['satnf']);
	$fecha_acuseo = valorSeguro($_POST['satff']);
	$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
	//$usuario = valorSeguro ($_POST['us_req']);
	//$id_rec_req = valorSeguro($_POST['entidad']);
	
		$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'ofic_SAT',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 34";
	$sql = $conexion->insert($query);

	
}
//--------------- Formulario para 1ra notificacion SAT

			
if($_REQUEST['tipoForm'] == "ofic_SAT1"){
	
    $numAccion = valorSeguro($_POST['accion_reqns']);
	$procedimiento = valorSeguro($_POST['procedimiento_reqns']);
	$nombre_actor = valorSeguro($_POST['id_actor_reqns']);
	//$actor = valorSeguro($_POST['id_actor_req']);
	$ofiFolio = valorSeguro($_POST['satn']);
	$ofiFecha = valorSeguro($_POST['satnf']);
	$fecha_acuseo1 = valorSeguro($_POST['satff1']);
	$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
	$ntr = valorSeguro($_POST['ntr']);
	//$usuario = valorSeguro ($_POST['us_req']);
	//$id_rec_req = valorSeguro($_POST['entidad']);
	
	if($ntr == 39)
	{
		$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'rr_not_acuerdo_s',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo1)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 39";
	$sql = $conexion->insert($query);
	} 
else
	{	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'rr_not_des_s',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo1)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 391";
	$sql = $conexion->insert($query);
	}
	
}

//--------------- formulario estado 34 o 36 ADMISION 
//--------------- formulario estado 34 o 36 ADMISION 
if($_REQUEST['tipoForm'] == "rr_AdmDes")
{
	$numAccion = valorSeguro($_POST['accion_reqns1']);
	$nombre_actor = valorSeguro($_POST['id_actor_reqns1']);
    $recurso_adm = valorSeguro ($_POST['numeroderecurso']);
	$fecha_admision =  valorSeguro($_POST['fechaAdmDes']);
	$admin= fechaMysql($fecha_admision);
	$motivo = valorSeguro ($_POST['motivoAdmDes']);
	$fecha_admision2 = valorSeguro ($_POST['fechaAdmDes2']);
	$dese = fechaMysql($fecha_admision2);
	$adm = $_REQUEST['tipoAdm'];
		
//dependiendo la accion si es admision o desachamiento ambos llegan al detalle_edo_tramite para poder notificar

if($adm == "admision")
{
$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'Admision',
				Oficio = 'Admision del Recurso de Reconsideración',
				Procedimiento = '".$recurso_adm."',
				Fecha_Acuse = '".fechaMysql($fecha_admision)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 39";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso set 		
								tipo_acuerdo = 'admision', 	
								fecha_de_acuerdo = '".$admin."',
								detalle_edo_tramite= 39	
          where recurso_reconsideracion ='".$recurso_adm."'";
$sql = $conexion->update($query);
			}

}
else
{
	
$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'Desechamiento',
				Oficio = 'Desechamiento del Recurso de Reconsideración',
				Procedimiento = '".$recurso_adm."',
				Fecha_Acuse = '".fechaMysql($fecha_admision)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 391";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso SET 
		detalle_edo_tramite = 391, 
		tipo_acuerdo= 'desechamiento', 
		fecha_de_acuerdo = '".$dese."', 
		motivo = '".$motivo."'
		WHERE 
		recurso_reconsideracion='".$recurso_adm."' ";

$sql = $conexion->update($query);
			}

}

}
	
//--------------- Formulario para requerimiento de información paso 107 Recursos de Reconsideracion

			
if($_REQUEST['tipoForm'] == "rr_notifica")
{
	
    $numAccion = valorSeguro($_POST['accion_not']);
	$procedimiento = valorSeguro($_POST['procedimiento_not']);
	$actor = valorSeguro($_POST['id_actor_not']);
	$usuario = valorSeguro ($_POST['us_not']);
	$ofiFolio = valorSeguro($_POST['ofi_not']);
	$ofiFecha = valorSeguro($_POST['fecha_ofi_not']);
	$fecha_acuseo = valorSeguro($_POST['fecha_acuse_oficio_noti_actor']);
	$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
	$edotram = valorSeguro($_REQUEST['edtram']);
	
	
if($edotram == 39)
{
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				1111 = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = 39";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= 36,
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}
}
else if($edotram == 391)
{
		$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = 391";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= 37,
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}
}
}	
//--------------- Formulario para 1ra notificacion SAT

			
if($_REQUEST['tipoForm'] == "rr_not_diligencia"){
	
    $numAccion = valorSeguro($_POST['accion_dil']);
	$procedimiento = valorSeguro($_POST['procedimiento_dil']);
	$nombre_actor = valorSeguro($_POST['id_actor_dil']);
	//$actor = valorSeguro($_POST['id_actor_req']);
	$ofiFolio = valorSeguro($_POST['ofi_dil']);
	$ofiFecha = valorSeguro($_POST['fecha_ofi_dil']);
	$fecha_acuseo = valorSeguro($_POST['fecha_acuse_oficio_dil']);
	//$usuario = valorSeguro ($_POST['us_req']);
	//$id_rec_req = valorSeguro($_POST['entidad']);
	
		$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = 'diligencias_UAA',
				Oficio = '".$ofiFolio."',
				Procedimiento = '".$procedimiento."',
				Fecha = '".fechaMysql($ofiFecha)."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$nombre_actor."',
				Volante = 0,
				id_estado_tramite = 36";
	$sql = $conexion->insert($query);
	
		if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= 361,
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}

//--------------- formulario estado 40 CIERRE DE INSTRUCCION
//--------------- formulario estado 40 CIERRE DE INSTRUCCION
if($_REQUEST['tipoForm'] == "rr_cierreins")
{
	
$numAccion = valorSeguro($_POST['accion_ci']);
$procedimiento = valorSeguro($_POST['procedimiento_ci']);
$actor = valorSeguro($_POST['id_actor_ci']);
$usuario = valorSeguro ($_POST['us_ci']);
$fecha_acuseo = valorSeguro($_POST['fecha_cierre_ins']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = 40";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= 40,
				  cierre_instruccion = '".fechaMysql($fecha_acuseo)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}
//--------------- formulario estado 41 EMISION DE LA RESOLUCION
//--------------- formulario estado 42 EMISION DE LA RESOLUCION
if($_REQUEST['tipoForm'] == "rr_EmiRes")
{
$numAccion = valorSeguro($_POST['accion_emr']);
$procedimiento = valorSeguro($_POST['procedimiento_emr']);
$actor = valorSeguro($_POST['id_actor_emr']);
$usuario = valorSeguro ($_POST['us_emr']);
$fecha_acuseo = valorSeguro($_POST['fecha_emi_res']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
$valtipo = valorSeguro($_POST['tipo_emi_res']);

	if($_REQUEST['tipo_emi_res'] == "confirmarResolucion") $estado = 41; 
	if($_REQUEST['tipo_emi_res'] == "modificarResolucion") $estado = 42; 
	if($_REQUEST['tipo_emi_res'] == "revocarResolucion") $estado = 43; 
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = '".$estado."'";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET detalle_edo_tramite= '".$estado."',
			      tipo_resolucion = '".$valtipo."',
				  fecha_resolucion = '".fechaMysql($fecha_acuseo)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			} else { echo "error"; }	
}

//------------------------------------------------- Notificación al presunto

if($_REQUEST['tipoForm'] == "rr_notpre" OR $_REQUEST['tipoForm'] == "rr_not_resol_act")
{
$numAccion = valorSeguro($_POST['accion_notac']);
$procedimiento = valorSeguro($_POST['procedimiento_notac']);
$actor = valorSeguro($_POST['id_actor_notac']);
$usuario = valorSeguro ($_POST['us_notas']);
$fecha_acuseo = valorSeguro($_POST['notofact']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
$detedotram = valorSeguro($_REQUEST['ed_notacs']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = '".$detedotram."' ";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET fecha_notificacion_resolucion_rr = '".fechaMysql($fecha_acuseo)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}
//--------------------------------------------------- Notificación al sat
if($_REQUEST['tipoForm'] == "rr_notsat" OR $_REQUEST['tipoForm'] == "rr_not_resol_sat")
{

$numAccion = valorSeguro($_POST['accion_notac']);
$procedimiento = valorSeguro($_POST['procedimiento_notac']);
$actor = valorSeguro($_POST['id_actor_notac']);
$usuario = valorSeguro ($_POST['us_notas']);
$fecha_acuseo2 = valorSeguro($_POST['notofsat']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
$detedotram = valorSeguro($_REQUEST['ed_notacs']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuseo2)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = '".$detedotram."' ";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET fecha_notificacion_resolucion_rr = '".fechaMysql($fecha_acuseo2)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}

if($_REQUEST['tipoForm'] == "rr_not_ef")
{

$numAccion = valorSeguro($_POST['accion_notac']);
$procedimiento = valorSeguro($_POST['procedimiento_notac']);
$actor = valorSeguro($_POST['id_actor_notac']);
$usuario = valorSeguro ($_POST['us_notas']);
$fecha_acuse4 = valorSeguro($_POST['notof_ef']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
$detedotram = valorSeguro($_REQUEST['ed_notacs']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuse4)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = '".$detedotram."' ";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET fecha_notificacion_resolucion_rr = '".fechaMysql($fecha_acuse4)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}

if($_REQUEST['tipoForm'] == "rr_not_icc")
{

$numAccion = valorSeguro($_POST['accion_notac']);
$procedimiento = valorSeguro($_POST['procedimiento_notac']);
$actor = valorSeguro($_POST['id_actor_notac']);
$usuario = valorSeguro ($_POST['us_notas']);
$fecha_acuse3 = valorSeguro($_POST['notof_ic']);
$rr_reqRecRec = valorSeguro($_POST['tipoForm']);
$detedotram = valorSeguro($_REQUEST['ed_notacs']);
	
	$query = "INSERT INTO medio_historial 
			  SET accion = '".$numAccion."',
				Tipo = '".$rr_reqRecRec."',
				Procedimiento = '".$procedimiento."',
				Fecha_Acuse = '".fechaMysql($fecha_acuse3)."',
				Actor = '".$actor."',
				Volante = 0,
				id_estado_tramite = '".$detedotram."' ";
	$sql = $conexion->insert($query);
	
	if($sql){
	$query = "UPDATE actores_recurso 
			  SET fecha_notificacion_resolucion_rr = '".fechaMysql($fecha_acuse3)."',
				  usuario='".$usuario."'
			  WHERE recurso_reconsideracion='".$procedimiento."' ";
		$sql = $conexion->update($query);
			}	else { echo "error"; }
}
?>
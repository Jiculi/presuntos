<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$vUsuario = valorSeguro($_REQUEST['user']);
$vFecha = valorSeguro($_REQUEST['fecha']);
$vHora = valorSeguro($_REQUEST['hora']);
//------------------------------------ Recepcion------------------------------------------
//------------------------------------ Recepcion------------------------------------------
if($_POST['proceso'] == "recepcion")
{
	$oficioRec = valorSeguro($_POST['oficioRec']);
	$oficioRecF1 = valorSeguro($_POST['oficioRecF1']);
	$f2po_acuse_oficio=valorSeguro($_POST['f2po_acuse_oficio']);
	$SICSA_recepcion_1= valorSeguro($_POST['SICSA_recepcion_1']);
	$cralRec= valorSeguro($_POST['cralRec']);
	$f4po_acuse_cral= valorSeguro($_POST['f4po_acuse_cral']);
	$volante_recepcion3= valorSeguro($_POST['volante_recepcion3']);
	$f5po_fecha_volante=valorSeguro($_POST['f5po_fecha_volante']);
	$f6po_acuse_volante=valorSeguro($_POST['f6po_acuse_volante']);
	$num_accion=valorSeguro($_POST['num_accion']);

	$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,sicsa,sicsaRecepcion,sicsaAcuse,volante,volanteRecepcion,volanteAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,status) VALUES ('".$num_accion."','recepcion','".$oficioRec."','".fechaMysql($oficioRecF1)."','" . fechaMysql($f2po_acuse_oficio)."','".$SICSA_recepcion_1."','".fechaMysql($cralRec)."','".fechaMysql($f4po_acuse_cral)."','".$volante_recepcion3."','".fechaMysql($f5po_fecha_volante)."','".fechaMysql($f6po_acuse_volante)."','2','".$vFecha."','".$vHora."','".$vUsuario."','Opinión para Emisión/Corrección del Pliego',1)",false);
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion,oficio_recepcion, fecha_recepcion, acuse_recepcion, SICSA_recepcion, fecha_SICSA_recepcion, acuse_SICSA_recepcion, volante_recepcion, fecha_volante_recepcion, acuse_volante_recepcion,registro_recepcion,fecha_sistema,hora_sistema,usuario) VALUES ('".$num_accion."','".$oficioRec."','".fechaMysql($oficioRecF1)."','" . fechaMysql($f2po_acuse_oficio)."','".$SICSA_recepcion_1."','".fechaMysql($cralRec)."','".fechaMysql($f4po_acuse_cral)."','".$volante_recepcion3."','".fechaMysql($f5po_fecha_volante)."','".fechaMysql($f6po_acuse_volante)."','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."' WHERE num_accion = '".$num_accion."'" ,false);
	echo "recepcion  -> ".print_r($_POST);
}
//----------------------------------------Asistencia-----------------------
//----------------------------------------Asistencia-----------------------
if ($_POST["proceso"]=="asistencia")
{
	$oficio_de_devolucionJ=valorSeguro($_POST['oficio_de_devolucionJ']);
	$fechadev=fechaMysql(valorSeguro($_POST['fechadev']));
	$acusedev=fechaMysql(valorSeguro($_POST['acusedev']));
	$num_accion=valorSeguro($_POST['num_accion']);
	
	$inexistencia=valorSeguro($_POST['inexistencia']);
	$docu_soporte=valorSeguro($_POST['docu_soporte']);
	$irregularidad=valorSeguro($_POST['irregularidad']);
	$monto_no_preciso=valorSeguro($_POST['monto_no_preciso']);
	$mezcla=valorSeguro($_POST['mezcla']);
	$papeles=valorSeguro($_POST['papeles']);
	$docu_irre=valorSeguro($_POST['docu_irre']);
	$datos=valorSeguro($_POST['datos']);
	$ilegible=valorSeguro($_POST['ilegible']);
	$indebida_fun=valorSeguro($_POST['indebida_fun']);
	$presun_resp=valorSeguro($_POST['presun_resp']);
	$inadecuada=valorSeguro($_POST['inadecuada']);
	$sin_obser=valorSeguro($_POST['sin_obser']);
	$otros=valorSeguro($_POST['otros']);
	$nosonPR=valorSeguro($_POST['nosonPR']);
	$otrostxt=valorSeguro($_POST['otrostxt']);
	$juridico=valorSeguro($_POST['juridico']);
	
	if($inexistencia=="on") $tipo_devolucion.="inexistencia|";
	if($docu_soporte=="on") $tipo_devolucion.="docu_soporte|";
	if($irregularidad=="on") $tipo_devolucion.="irregularidad|";
	if($monto_no_preciso=="on") $tipo_devolucion.="monto_no_preciso|";
	if($mezcla=="on") $tipo_devolucion.="mezcla|";
	if($papeles=="on") $tipo_devolucion.="papeles|";
	if($docu_irre=="on") $tipo_devolucion.="docu_irre|";
	if($datos=="on") $tipo_devolucion.="datos|";
	if($ilegible=="on") $tipo_devolucion.="ilegible|";
	if($indebida_fun=="on") $tipo_devolucion.="indebida_fun|";
	if($presun_resp=="on") $tipo_devolucion.="presun_resp|";
	if($sin_obser=="on") $tipo_devolucion.="sin_obser|";
	if($nosonPR=="on") $tipo_devolucion.="nosonPR|";
	if($otros=="on") $tipo_devolucion.="otros¬¬.$otrostxt|";
	
	$sql=$conexion->update("UPDATE oficios_contenido SET juridico='0' WHERE folio = '".$oficio_de_devolucionJ."' AND num_accion = '".$num_accion."' " ,false);
	$sql=$conexion->update("UPDATE po_historial SET oficioAcuse = '".fechaMysql($acusedev)."', usuario = '".$vUsuario."', status = 1,tipo_devolucion = '".$tipo_devolucion."' WHERE oficio = '".$oficio_de_devolucionJ."' " ,false);
	//$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status,tipo_devolucion) VALUES ('".$num_accion."','asistencia/devolucion','".$oficio_de_devolucionJ."','".fechaMysql($fechadev)."','" . fechaMysql($acusedev)."','3','".$vFecha."','".$vHora."','".$vUsuario."','Asistencia Jurídica/Devolución','$cadMontos',1,'".$tipo_devolucion."')",false);
	
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_de_devolucion, fecha, acuse,registro_recepcion,fecha_sistema,hora_sistema,usuario) VALUES ('$num_accion','$oficio_de_devolucionJ','$fechadev',' $acusedev','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= 3,ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".$vFecha."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);	
	echo "asistencia  -> ".print_r($_POST);
}
//----------------------------------------Proceso-----------------------------
//----------------------------------------Proceso-----------------------------
if($_POST["proceso"]=="procesoPro")
{
	$oficio_de_devolucionP=valorSeguro($_POST['oficio_de_devolucionP']);
	$fechap=fechaMysql(valorSeguro($_POST['fechap']));
	$acusep=fechaMysql(valorSeguro($_POST['acusep']));
	$num_accion=valorSeguro($_POST['num_accion']);

	$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','recepcion','".$oficio_de_devolucionP."','".fechaMysql($fechap)."','" . fechaMysql($acusep)."','5','".$vFecha."','".$vHora."','".$vUsuario."','PO en Proceso de Notificación','$cadMontos',1)",false);
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_recepcion, fecha_recepcion, acuse_recepcion,registro_recepcion,fecha_sistema,hora_sistema,usuario) VALUES ('$num_accion','$oficio_de_devolucionP','$fechap',' $acusep','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '5',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	echo "en proceso  -> ".print_r($_POST);	
}
//-----------------------------------------Notificado--------------------------
//-----------------------------------------Notificado--------------------------
if($_POST["proceso"]=="guardaNoti")
{
	$oficio_notificacion_asofis=valorSeguro($_POST['oficio_notificacion_asofis']);
	$fecha_oficio_asofis=fechaMysql(valorSeguro($_POST['fecha_oficio_asofis']));
	$fecha_oficio_asofis_acuse=fechaMysql(valorSeguro($_POST['fecha_oficio_asofis_acuse']));
	$oficio_notificacion_2do_icc=valorSeguro($_POST['oficio_notificacion_2do_icc']);
	$fecha_oficio_2do_icc=fechaMysql(valorSeguro($_POST['fecha_oficio_2do_icc']));
	$fecha_oficio_2do_icc_acuse=fechaMysql(valorSeguro($_POST['fecha_oficio_2do_icc_acuse']));
	$oficio_notificacion_entidad=valorSeguro($_POST['oficio_notificacion_entidad']);
	$fecha_oficio_notificacion_entidad=fechaMysql(valorSeguro($_POST['fecha_oficio_notificacion_entidad']));
	$acuse_oficio_notificacion_entidad=fechaMysql(valorSeguro($_POST['acuse_oficio_notificacion_entidad']));
	$oficio_notificacion_oic=valorSeguro($_POST['oficio_notificacion_oic']);
	$fecha_oficio_notificacion_oic=fechaMysql(valorSeguro($_POST['fecha_oficio_notificacion_oic']));
	$acuse_oficio_notificacion_oic=fechaMysql(valorSeguro($_POST['acuse_oficio_notificacion_oic']));	
	$num_accion=valorSeguro($_POST['num_accion']);
	$totalPresuntos = valorSeguro($_POST['totalPresuntos']);

	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '6',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	
	if($fecha_oficio_asofis != "NA" && $fecha_oficio_asofis != null){
			$sql = $conexion->update("UPDATE po SET asofis = '1' WHERE num_accion = '".$num_accion."'" ,false);
		}
	
	if($sql)
	{
		$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficioNotEntidad,fechaNotEntidad,acuseNotEntidad,oficioNotOIC,fechaNotOIC,acuseNotOIC,oficioNotAsofis,fechaNotAsofis,acuseNotAsofis,oficioNot2doICC,fechaNot2doICC,acuseNot2doICC,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','notificación','".$oficio_notificacion_entidad."','".$fecha_oficio_notificacion_entidad."','".$acuse_oficio_notificacion_entidad."','".$oficio_notificacion_oic."','".$fecha_oficio_notificacion_oic."','".$acuse_oficio_notificacion_oic."', '".$oficio_notificacion_asofis."', '".$fecha_oficio_asofis."','".$fecha_oficio_asofis_acuse."','".$oficio_notificacion_2do_icc."','".$fecha_oficio_2do_icc."','".$fecha_oficio_2do_icc_acuse."', '6','".$vFecha."','".$vHora."','".$vUsuario."','Notificación del PO','$cadMontos',1)",false);
		//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_notificacion_entidad, fecha_oficio_notificacion_entidad, acuse_oficio_notificacion_entidad, oficio_notificacion_oic, fecha_oficio_notificacion_oic, acuse_oficio_notificacion_oic,registro_recepcion,fecha_sistema,hora_sistema,usuario ) VALUES ('$num_accion','$oficio_notificacion_entidad','$fecha_oficio_notificacion_entidad',' $acuse_oficio_notificacion_entidad','$oficio_notificacion_oic','$fecha_oficio_notificacion_oic','$acuse_oficio_notificacion_oic','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
		$sql = $conexion->update("UPDATE oficios_contenido SET juridico = 0 WHERE folio = '".$oficio_notificacion_entidad."'" ,false);
		$sql = $conexion->update("UPDATE oficios_contenido SET juridico = 0 WHERE folio = '".$oficio_notificacion_oic."'" ,false);
	}
	echo "Notificacion  -> ".print_r($_POST);
}
//---------------------------------------Notificado UAA--------------------------------
//---------------------------------------Notificado UAA--------------------------------
if($_POST["proceso"]=="guardaUAA")
{
	$oficiouaa=valorSeguro($_POST['oficiouaa']);
	$f11po_fecha_oficio=fechaMysql(valorSeguro($_POST['f11po_fecha_oficio']));
	$f12po_acuse_oficio=fechaMysql(valorSeguro($_POST['f12po_acuse_oficio']));
	$num_accion=valorSeguro($_POST['num_accion']);

	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '7',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','asistencia/devolucion','".$oficiouaa."','".fechaMysql($f11po_fecha_oficio)."','" . fechaMysql($f12po_acuse_oficio)."','7','".$vFecha."','".$vHora."','".$vUsuario."','Remitir ET a la UAA','$cadMontos',1)",false);
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_de_devolucion, fecha, acuse,registro_recepcion,fecha_sistema,hora_sistema,usuario) VALUES ('$num_accion','$oficiouaa','$f11po_fecha_oficio',' $f12po_acuse_oficio','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	echo "UAA  -> ".print_r($_POST);
}
//-------------------------------------Solventado-------------------------
//-------------------------------------Solventado-------------------------
if($_POST["proceso"]=="solventado")
{
	$oficio_recepcionS=valorSeguro($_POST['oficio_recepcionS']);
	$f17fecha_recepcion=fechaMysql(valorSeguro($_POST['f17fecha_recepcion']));
	$f18acuse_recepcion=fechaMysql(valorSeguro($_POST['f18acuse_recepcion']));
	$volante_recepcion=valorSeguro($_POST['volante_recepcion']);
	$f19fecha_volante_recepcion=fechaMysql(valorSeguro($_POST['f19fecha_volante_recepcion']));
	$f20acuse_volante_recepcion=fechaMysql(valorSeguro($_POST['f20acuse_volante_recepcion']));	
	$num_accion=valorSeguro($_POST['num_accion']);

	$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,volante,volanteRecepcion,volanteAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','recepcion','".$oficio_recepcionS."','".fechaMysql($f17fecha_recepcion)."','" . fechaMysql($f18acuse_recepcion)."','".$volante_recepcion."','".$f19fecha_volante_recepcion."','".$f20acuse_volante_recepcion."','9','".$vFecha."','".$vHora."','".$vUsuario."','Solventación','$cadMontos',1)",false);
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_recepcion, fecha_recepcion, acuse_recepcion, volante_recepcion, 	fecha_volante_recepcion, acuse_volante_recepcion,registro_recepcion,fecha_sistema,hora_sistema,usuario ) VALUES ('$num_accion','$oficio_recepcionS','$f17fecha_recepcion',' $f18acuse_recepcion','$volante_recepcion','$f19fecha_volante_recepcion','$f20acuse_volante_recepcion','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '9',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	echo "solventacio  -> ".print_r($_POST);
}
//---------------------------------DTNS----------------------
//---------------------------------DTNS----------------------
if($_POST["proceso"]=="DTNS")
{
	$oficio_recepcionDTNS=valorSeguro($_POST['oficio_recepcionDTNS']);
	$num_DT=valorSeguro($_POST['num_DT']);
	$fecha_recepcionDTNS=fechaMysql(valorSeguro($_POST['fecha_recepcionDTNS']));
	$acuse_recepcionDTNS=fechaMysql(valorSeguro($_POST['acuse_recepcionDTNS']));
	$SICSA_recepcionDTNS=valorSeguro($_POST['SICSA_recepcionDTNS']);
	$fecha_SICSA_recepcionDTNS=fechaMysql(valorSeguro($_POST['fecha_SICSA_recepcionDTNS']));	
	$acuse_SICSA_recepcionDTNS=fechaMysql(valorSeguro($_POST['acuse_SICSA_recepcionDTNS']));	
	$volante_recepcionDTNS=valorSeguro($_POST['volante_recepcionDTNS']);
	$fecha_volante_recepcionDTNS=fechaMysql(valorSeguro($_POST['fecha_volante_recepcionDTNS']));
	$acuse_volante_recepcionDTNS=fechaMysql(valorSeguro($_POST['acuse_volante_recepcionDTNS']));
	$num_accion=valorSeguro($_POST['num_accion']);
	//----------------- valores pasan a pfrr --------------------------------------
	$entidad=valorSeguro($_POST['entidad']);
	$cp=valorSeguro($_POST['cp']);
	$auditoria=valorSeguro($_POST['auditoria']);
	$direccion=valorSeguro($_POST['direccion']);
	$subdirector=valorSeguro($_POST['subdirector']);
	$abogado=valorSeguro($_POST['abogado']);
	$po=valorSeguro($_POST['po']);
	$monto_no_solventado=valorSeguro($_POST['monto_no_solventado']);
	$subnivel=valorSeguro($_POST['subnivel']);
	$DG=valorSeguro($_POST['DG']);
	$prescripcion=fechaMysql(valorSeguro($_POST['prescripcion']));
	
	//actualiza tabla PO
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '10',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	if($sql)
	{
		//actualizamos historial PO
		$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,sicsa,sicsaRecepcion,sicsaAcuse,volante,volanteRecepcion,volanteAcuse,dt,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','DTNS','".$oficio_recepcionDTNS."','".fechaMysql($fecha_recepcionDTNS)."','".fechaMysql($acuse_recepcionDTNS)."','".$SICSA_recepcionDTNS."','".$fecha_SICSA_recepcionDTNS."','".$acuse_SICSA_recepcionDTNS."','".$volante_recepcionDTNS."','".$fecha_volante_recepcionDTNS."','".$acuse_volante_recepcionDTNS."','".$num_DT."','10','".$vFecha."','".$vHora."','".$vUsuario."','Registro del Dictamen Técnico por No Solventacion del PO','DT: ".$num_DT."',1) ",false);
		//inserta datos a la bitacora
	}
	//inserta datos a PFRR
	$insertPFRR = sprintf("INSERT INTO pfrr (num_accion, entidad, cp, auditoria, direccion, subdirector, abogado, po, num_DT, prescripcion, detalle_edo_tramite, fecha_edo_tramite, usuario, hora, subnivel, DG) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
	$num_accion,$entidad,$cp,$auditoria,$direccion,$subdirector,$abogado,$po,$num_DT, fechaMysql($prescripcion),11,fechaMysql($vFecha),$vUsuario,$vHora,$subnivel,$DG);
	$sqlPFRR = $conexion->insert($insertPFRR,false);
	if($sqlPFRR)
	{		
		//$sql = $conexion->insert("INSERT INTO pfrr_envio_recepcion (num_accion, oficio_recepcion, dt, fecha_recepcion, acuse_recepcion, SICSA_recepcion, 	fecha_SICSA_recepcion, acuse_SICSA_recepcion,volante_recepcion, fecha_volante_recepcion, acuse_volante_recepcion ) VALUES ('$num_accion','$oficio_recepcionDTNS','$num_DT',' $fecha_recepcionDTNS','$acuse_recepcionDTNS','$SICSA_recepcionDTNS','$fecha_SICSA_recepcionDTNS','$acuse_SICSA_recepcionDTNS','$volante_recepcionDTNS','$fecha_volante_recepcionDTNS','$acuse_volante_recepcionDTNS')  ",false);
		//actualizamos historial PFRR
		$sql = $conexion->insert("INSERT INTO pfrr_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,sicsa,sicsaRecepcion,sicsaAcuse,volante,volanteRecepcion,volanteAcuse,dt,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','DTNS','".$oficio_recepcionDTNS."','".fechaMysql($fecha_recepcionDTNS)."','".fechaMysql($acuse_recepcionDTNS)."','".$SICSA_recepcionDTNS."','".$fecha_SICSA_recepcionDTNS."','".$acuse_SICSA_recepcionDTNS."','".$volante_recepcionDTNS."','".$fecha_volante_recepcionDTNS."','".$acuse_volante_recepcionDTNS."','".$num_DT."','11','".$vFecha."','".$vHora."','".$vUsuario."','Registro del Dictamen Técnico por No Solventacion del PO','DT: ".$num_DT."',1) ",false);
		//inserta datos a pfrr_presuntos_audiencias
		$insertPresuntos = "
			INSERT INTO pfrr_presuntos_audiencias (num_accion,nombre,cargo,dependencia,accion_omision,tipo) 
				SELECT num_accion,servidor_contratista,cargo_servidor,dependencia,irregularidad,tipo_presunto
				FROM  po_presuntos 
				WHERE num_accion = '".$num_accion."' 
					AND tipo_presunto <> 'titularICC' 
					AND tipo_presunto <> 'responsableInforme' ";
		$sqlPresuntos = $conexion->insert($insertPresuntos,false);
		
		if($sqlPFRR && $sqlPresuntos) echo "Todo bien <br><br> - $sqlPFRR <br><br> - $sqlPresuntos";
		else echo "<div style='line-height:normal'>No se gardo <br><br> - $sqlPFRR <br><br> - $sqlPresuntos</div>";
	}
	print_r($_POST);
}
//-----------------------------Baja-------------------------------------
//-----------------------------Baja-------------------------------------
if($_POST["proceso"]=="baja")
{
	$oficio_recepcion3=valorSeguro($_POST['oficio_recepcion3']);
	$f13fecha_recepcion=fechaMysql(valorSeguro($_POST['f13fecha_recepcion']));
	$f14acuse_recepcion=fechaMysql(valorSeguro($_POST['f14acuse_recepcion']));
	$volante_recepcion2=valorSeguro($_POST['volante_recepcion2']);
	$f15fecha_volante_recepcion=fechaMysql(valorSeguro($_POST['f15fecha_volante_recepcion']));
	$f16fecha_volante_recepcion=fechaMysql(valorSeguro($_POST['f16fecha_volante_recepcion']));	
	$num_accion=valorSeguro($_POST['num_accion']);

	$sql = $conexion->insert("INSERT INTO po_historial (num_accion,tipo,oficio,oficioRecepcion,oficioAcuse,volante,volanteRecepcion,volanteAcuse,estadoTramite,fechaSistema,horaSistema,usuario,nombreProceso,montos,status) VALUES ('".$num_accion."','recepcion','".$oficio_recepcion3."','".fechaMysql($f13fecha_recepcion)."','" . fechaMysql($f14acuse_recepcion)."','".$volante_recepcion2."','".$f15fecha_volante_recepcion."','".$f16fecha_volante_recepcion."','8','".$vFecha."','".$vHora."','".$vUsuario."','Registro de Baja por Conclusión Previa a su Emisión','$cadMontos',1)",false);
	//$sql = $conexion->insert("INSERT INTO po_envio_recepcion (num_accion, oficio_recepcion, fecha_recepcion, acuse_recepcion, volante_recepcion, 	fecha_volante_recepcion, acuse_volante_recepcion,registro_recepcion,fecha_sistema,hora_sistema,usuario ) VALUES ('$num_accion','$oficio_recepcion3','$f13fecha_recepcion',' $f14acuse_recepcion','$volante_recepcion2','$f15fecha_volante_recepcion','$f16fecha_volante_recepcion','".$vFecha."','".$vFecha."','".$vHora."','".$vUsuario."')  ",false);
	$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '8',ip_edo_tram='".$vUsuario."',fecha_estado_tramite='".fechaMysql($vFecha)."',hora_act_edo_tram='".$vHora."'  WHERE num_accion = '".$num_accion."'" ,false);
	echo "baja  -> ".print_r($_POST);
}
?>
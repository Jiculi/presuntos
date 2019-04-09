<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$remitente= valorSeguro(trim($_POST['remitente']));
$cargo= valorSeguro(trim($_POST['cargo']));
$oficio= valorSeguro($_POST['oficio']);
$fechaOficio= valorSeguro(fechaMysql($_POST['fechaOficio']));
$fechaAcuse= valorSeguro(fechaMysql($_POST['fechaAcuse']));
$movimiento= valorSeguro($_POST['movimiento']);
$dt= valorSeguro($_POST['dt']);
$accion= valorSeguro($_POST['accion']);
$asunto= valorSeguro($_POST['asunto']);
$dependencia= valorSeguro(trim($_POST['dependencia']));
$turnado= valorSeguro($_POST['turnado']);
$direccion= valorSeguro($_POST['direccion']);
$cral= valorSeguro($_POST['cral']);
$fechaCral= valorSeguro(fechaMysql($_POST['fechaCral']));
$acuseCral= valorSeguro(fechaMysql($_POST['acuseCral']));
$usuario =valorSeguro($_POST['usuario']); 

$cedula= valorSeguro($_POST['ofConcluida']);
$fechaCedula= valorSeguro(fechaMysql($_POST['feConcluida']));
//--------------- asigna variables -----------------------
if(is_numeric($movimiento))
{
	$proceso = $movimiento;
	$edoTramite = $movimiento;
	$tipo = "recepcion";
}
else
{
	$proceso = "";
	$edoTramite = "";
	$tipo = "recepcion";
}


if($movimiento == 'administracion' || $movimiento == 'otro' || $movimiento == 'pfrr_otros' || $movimiento == 'medios_otros' || $movimiento == 'x_otros')
{
	$proceso = "";	
	$edoTramite = 0;
	$tipoMov = $movimiento;
}
//------------------- GENERACION DEL VOLANTE -------------------------------------------------
//--------------------------------------------------------------------------------------------
$fechasVolantes = date('Y-m-d');
$horasVolantes = date("H:i:s");

$sql = $conexion->insert("INSERT INTO volantes 
						  SET 
							hora_registro = '$horasVolantes',
							fecha_oficio = '$fechaOficio',
							fecha_acuse = '$fechaAcuse',
							fecha_actual = '$fechasVolantes',
							cral = '$cral',
							fechaCral = '$fechaCral',
							acuseCral = '$acuseCral',
							entidad_dependencia = '$dependencia',
							remitente = '$remitente',
							cargo = '$cargo',
							referencia = '$oficio',
							destinatario = '',
							asunto = '$asunto',
							turnado = '$turnado',
							asunto_oficio = '',
							status = 1,
							semaforo = 0,
							generado_por = '$usuario',
							VP = '',
							tipoMovimiento = '$movimiento',
							direccion = '$direccion',
							accion = '$accion'
							"
						,false);
//generamos ultimo ID
$ultimo_id = mysql_insert_id(); 

if($ultimo_id <= 9) $uid = "000".$ultimo_id;
if($ultimo_id <= 99 && $ultimo_id >= 10) $uid = "00".$ultimo_id;
if($ultimo_id >= 100 && $ultimo_id < 1000) $uid = "0".$ultimo_id;
if($ultimo_id >= 1000) $uid = $ultimo_id;

$anio = substr(date('Y'),-2);
$folio = $uid."/".$anio;

$sql = $conexion->update("UPDATE volantes SET folio = '$folio' WHERE id = $ultimo_id ", false);
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
if($movimiento != 'otro' && $movimiento != 'pfrr_otros' && $movimiento != 'medios_otros' && $movimiento != 'x_otros' && $movimiento != 'administracion') 
{						
	//------------------------------ RESPALDO DE ACCIONES -------------------------------------------------						
	$sql = $conexion->select("SELECT * FROM po WHERE num_accion = '".$accion."' ",false);
	$rpo = mysql_fetch_array($sql);	
	$total = mysql_num_rows($sql);
							
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = '$accion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
	//------------------------------- ACTUALIZACION DE ACCIONES PO ------------------------------------------------
	//actualizamos solo los edos de PO 
	if(is_numeric($edoTramite) && ($edoTramite <= 10 || $edoTramite == 27))
	{
		$sql = $conexion->update("UPDATE po 
							SET 
								detalle_de_estado_de_tramite= ".$edoTramite.",
								ip_edo_tram='".$usuario."',
								fecha_estado_tramite='$fechasVolantes',
								hora_act_edo_tram='$horasVolantes',
								bajaAnunciada = 0  
							WHERE num_accion = '".$accion."'" 
								,false);
		//------------------------------ INSERTA HISTORIAL PO -------------------------------------------------						
		$sql = $conexion->insert("INSERT INTO po_historial 
						  SET
							num_accion = '$accion',
							tipo = '$tipo',
							oficio = '$oficio',
							oficioRecepcion = '$fechaOficio',
							oficioAcuse = '$fechaAcuse',
							sicsa = '$cral',
							sicsaRecepcion = '$fechaCral',
							sicsaAcuse = '$acuseCral',
							volante = '$folio',
							volanteRecepcion = '$fechasVolantes',
							volanteAcuse = '$fechasVolantes',
							cedula = '$cedula',
							fechaCedula = '$fechaCedula',
							estadoTramite = ".$edoTramite.",
							fechaSistema = '".date('Y-m-d')."',
							horaSistema = '".date('H:i:s')."',
							usuario = '$usuario',
							nombreProceso = '$proceso',
							status = 1"
						,false);
		//------------------------------ INSERTA RECEPCOIN  -------------------------------------------------	
		/*					
		$sql = $conexion->insert("INSERT INTO po_envio_recepcion 
							SET
								num_accion = '$accion',
								oficio_recepcion = '$oficio', 
								fecha_recepcion = '$fechaOficio', 
								acuse_recepcion = '', 
								SICSA_recepcion = '$cral', 
								fecha_SICSA_recepcion = '$fechaCral', 
								acuse_SICSA_recepcion = '$acuseCral', 
								volante_recepcion = '$folio', 
								fecha_volante_recepcion = '$fechasVolantes', 
								acuse_volante_recepcion = '$fechasVolantes',
								registro_recepcion = '".date('Y-m-d')."',
								fecha_sistema = '".date('Y-m-d')."',
								hora_sistema = '".date('H:i:s')."',
								usuario = '$usuario',
								status = 1"
							,false);
		*/
	}
	//------------------------------- ACTUALIZACION DE ACCIONES PFRR ------------------------------------------------
	//actualizamos solo estados PFRR
	if(is_numeric($edoTramite) && ($edoTramite == 11 || $edoTramite == 14 || $edoTramite == 21 || $edoTramite == 28))
	{
		$sql = $conexion->update("UPDATE pfrr
							SET 
								detalle_edo_tramite= $edoTramite,
								usuario='".$usuario."',
								fecha_edo_tramite='$fechasVolantes',
								hora='$horasVolantes'  
							WHERE num_accion = '".$accion."'" 
								,false);
		//----------------------- actualiza PO si es solventacion previa al inicio del PFRR
		if($edoTramite == 14){				
			$sql = $conexion->update("UPDATE po
						SET 
							detalle_de_estado_de_tramite = 9,
							ip_edo_tram = '".$usuario."',
							fecha_estado_tramite = '$fechasVolantes',
							hora_act_edo_tram = '$horasVolantes'  
						WHERE num_accion = '".$accion."'" 
							,false);
		}
		//----------------------- respuesta técnica de la UAA suma 90 días
		if($edoTramite == 28){	
		//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
			$fecha90 = strtotime ( '+90 day' , strtotime ( $fechasVolantes ) ) ;
			$fecha90 = date ( 'Y-m-d' , $fecha90 );
			//----------------------------------------------------------------------------------------------
			//$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 28,  limite_cierre_instruccion = '".$fecha90."', fecha_analisis_documentacion = '".$fecha."',usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
			$sqlpfrr = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = 28, limite_cierre_instruccion = '".$fecha90."', fecha_analisis_documentacion = '".$fechasVolantes."' WHERE num_accion='".$accion."' ",false);
		}
		//------------------------------ INSERTA HISTORIAL PFRR -------------------------------------------------						
		$sql = $conexion->insert("INSERT INTO pfrr_historial 
						  SET
							num_accion = '$accion',
							tipo = '$tipo',
							oficio = '$oficio',
							oficioRecepcion = '$fechaOficio',
							oficioAcuse = '$fechaAcuse',
							sicsa = '$cral',
							sicsaRecepcion = '$fechaCral',
							sicsaAcuse = '$acuseCral',
							volante = '$folio',
							volanteRecepcion = '$fechasVolantes',
							volanteAcuse = '$fechasVolantes',
							estadoTramite = '$edoTramite',
							fechaSistema = '".date('Y-m-d')."',
							horaSistema = '".date('H:i:s')."',
							usuario = '$usuario',
							nombreProceso = '$proceso',
							status = 1"
						,false);
	}

}
//administracion
if($movimiento == 'administracion')
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	 
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO otros_oficios 
								SET
									num_accion = 'administracion',
									folio_volante = '$folio',
									documentoExtra = '$oficio',
									fecha = '$fechaOficio',
									acuse = '$fechaAcuse',
									leyenda = '$asunto',
									atiende = '$remitente',
									referencia = '$remitente',
									tipo = '$tipo',
									status = 1",false);
					
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = 'administracion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
}
//------------------------- OTROS PO ----------------------------------
if($movimiento == 'otro' )
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	 
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO otros_oficios 
								SET
									num_accion = '$accion',
									folio_volante = '$folio',
									documentoExtra = '$oficio',
									fecha = '$fechaOficio',
									acuse = '$fechaAcuse',
									leyenda = '$asunto',
									atiende = '$remitente',
									referencia = '$remitente',
									tipo = '$tipo',
									status = 1",false);
					
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = '$accion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
}
//------------------------ OTROS PFRR -----------------------------------
if($movimiento == 'pfrr_otros' )
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	 
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO pfrr_bitacora_adicional
								SET
									folio = '$oficio',
									num_accion = '$accion',
									tipo_oficio_adicional = '$tipo',
									oficio_tipo_oficio_adicional = '$folio',
									fecha_tipo_oficio_adicional = '$fechaOficio',
									acuse_tipo_oficio_adicional = '$fechaAcuse',
									leyenda_tipo_oficio_adicional = '$asunto',
									atiende_tipo_oficio_adicional = '$remitente',
									referencia_tipo_oficio_adicional = '$remitente',
									status = 1",false);
																		
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = '$accion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
}
//------------------------- OTROS MEDIOS ----------------------------------
if($movimiento == 'medios_otros' )
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	 
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO medios_otros_oficios 
								SET
									num_accion = '$accion',
									folio_volante = '$folio',
									documentoExtra = '$oficio',
									fecha = '$fechaOficio',
									acuse = '$fechaAcuse',
									leyenda = '$asunto',
									atiende = '$remitente',
									referencia = '$remitente',
									tipo = '$tipo',
									status = 1",false);
					
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = '$accion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
}
//------------------------- OTROS MEDIOS ----------------------------------
if($movimiento == 'x_otros' )
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	 
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO x_otros_oficios 
								SET
									num_accion = '$accion',
									folio_volante = '$folio',
									documentoExtra = '$oficio',
									fecha = '$fechaOficio',
									acuse = '$fechaAcuse',
									leyenda = '$asunto',
									atiende = '$remitente',
									referencia = '$remitente',
									tipo = '$tipo',
									status = 1",false);
					
	$sql = $conexion->insert("INSERT INTO volantes_respaldo 
								SET
									volante = '$folio',
									accion = '$accion', 
									ant_edo_tram = '".$rpo['detalle_de_estado_de_tramite']."', 
									ant_fecha_edo_tram = '".$rpo['fecha_estado_tramite']."', 
									ant_hora_edo_tram = '".$rpo['hora_act_edo_tram']."', 
									ant_usuario = '".$rpo['ip_edo_tram']."', 
									act_edo_tram = '$edoTramite', 
									act_fecha_edo_tram = '$fechasVolantes', 
									act_hora_edo_tram = '$horasVolantes', 
									act_usuario = '".$usuario."'
									"
								,false);
}
//---------------------------------------- DTNS ----------------------------------------------------
//---------------------------------------- DTNS ----------------------------------------------------
if($movimiento == 10)
{
	$oficio_recepcionDTNS		=		$oficio;
	//$num_DT						=		valorSeguro($_POST['num_DT']);
	$fecha_recepcionDTNS		=		$fechaOficio;
	$acuse_recepcionDTNS		=		$fechaAcuse;
	$SICSA_recepcionDTNS		= 		$cral;
	$fecha_SICSA_recepcionDTNS	=		$fechaCral;	
	$acuse_SICSA_recepcionDTNS	=		$acuseCral;
	$volante_recepcionDTNS		=		$folio;
	$fecha_volante_recepcionDTNS=		$fechasVolantes;
	$acuse_volante_recepcionDTNS=		$fechasVolantes;
	$num_accion					=		$accion;	
	
	//actualiza tabla PO
		$sqlPO = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '10',ip_edo_tram='".$usuario."',fecha_estado_tramite='".$fechasVolantes."',hora_act_edo_tram='".$horasVolantes."'  WHERE num_accion = '".$num_accion."'" ,false);
	//inserta datos a PFRR
		$insertPFRR = sprintf("
			INSERT INTO pfrr 
				( num_accion,entidad,cp,auditoria,direccion,subdirector,abogado,po,prescripcion,detalle_edo_tramite,fecha_edo_tramite,usuario,hora,subnivel) 
			SELECT 
					num_accion,entidad_fiscalizada,	cp,num_auditoria,direccion,subdirector,abogado,numero_de_pliego,prescripcion,detalle_de_estado_de_tramite,fecha_estado_tramite,ip_edo_tram,hora_act_edo_tram,subnivel
				FROM po
				WHERE po.num_accion = '".$num_accion."' ");	
		$sqlPFRR = $conexion->insert($insertPFRR,false);
		
	//inserta datos a pfrr_presuntos_audiencias
		$insertPresuntos = "
			INSERT INTO pfrr_presuntos_audiencias (num_accion,nombre,cargo,dependencia,accion_omision) 
				SELECT num_accion,servidor_contratista,cargo_servidor,dependencia,irregularidad 
				FROM  po_presuntos 
				WHERE num_accion = '".$num_accion."' 
					AND tipo_presunto <> 'titularICC' 
					AND tipo_presunto <> 'responsableInforme' ";		$sqlPresuntos = $conexion->insert($insertPresuntos,false);
	//actualiza tabla PFRR	
	$sqlPFRR2 = $conexion->update("UPDATE pfrr SET num_DT='".$dt."',detalle_edo_tramite= '11',usuario='".$usuario."',fecha_edo_tramite='".$fechasVolantes."',hora='".$horasVolantes."'  WHERE num_accion = '".$num_accion."'" ,false);
	$sql = $conexion->insert("INSERT INTO pfrr_historial 
							  SET
								num_accion = '$accion',
								tipo = '$tipo',
								oficio = '$oficio',
								oficioRecepcion = '$fechaOficio',
								oficioAcuse = '$fechaAcuse',
								sicsa = '$cral',
								sicsaRecepcion = '$fechaCral',
								sicsaAcuse = '$acuseCral',
								volante = '$folio',
								volanteRecepcion = '$fechasVolantes',
								volanteAcuse = '$fechasVolantes',
								dt = '$dt',
								estadoTramite = '$edoTramite',
								fechaSistema = '".date('Y-m-d')."',
								horaSistema = '".date('H:i:s')."',
								usuario = '$usuario',
								nombreProceso = '$proceso',
								status = 1"
							,false);
	
	if($sqlPO && $insertPFRR && $sqlPFRR && $sqlPFRR2 && $sqlPresuntos) $error = "";
	else
	{
		$error = "error";
		$txtEror = "<div style='line-height:normal'>No se gardo <br><br> - $sqlPO <br><br> $insertPFRR <br><br> $sqlPFRR <br><br> $sqlPFRR2 <br><br> $sqlPresuntos </div>"; 
	}
}
//------------------------------------- FIN DTNS ----------------------------------------------------

//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
	$sql = $conexion->select("SELECT * FROM volantes_remitentes WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
	$total = mysql_num_rows($sql);
	
	if($total == 0)
		$sql = $conexion->insert("INSERT INTO volantes_remitentes SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	
		
		
//------------------------------------------------------
// validamos que no haya fallo----
if($error == "")
	echo $ultimo_id;
else echo $txtEror;

/*
*/
?>

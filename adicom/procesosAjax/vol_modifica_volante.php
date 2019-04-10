<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$tipoAccion= valorSeguro(trim($_POST['tipoAccion']));
$idVol= valorSeguro(trim($_POST['idVol']));
$folio= valorSeguro(trim($_POST['folio']));
$remitente= valorSeguro(trim($_POST['remitente']));
$cargo= valorSeguro(trim($_POST['cargo']));
$oficio= valorSeguro($_POST['oficio']);
$fechaOficio= valorSeguro(fechaMysql($_POST['fechaOficio']));
$fechaAcuse= valorSeguro(fechaMysql($_POST['fechaAcuse']));
$movimiento= valorSeguro($_POST['movimiento']);
$accion= valorSeguro($_POST['accion']);
$asunto= valorSeguro($_POST['asunto']);
$dependencia= valorSeguro(trim($_POST['dependencia']));
$turnado= valorSeguro($_POST['turnado']);
$direccion= valorSeguro($_POST['direccion']);
$cral= valorSeguro($_POST['cral']);
$fechaCral= valorSeguro(fechaMysql($_POST['fechaCral']));
$acuseCral= valorSeguro(fechaMysql($_POST['acuseCral']));
$usuario =valorSeguro($_POST['usuario']); 

//-------------------------- estados de tramite 
//Registro de Recepción del PPO
if($movimiento == 2)
{
	$proceso = "Opinión para Emisión/Corrección del Pliego";
	$edoTramite = 2;
	$tipo = "recepcion";
}

if($movimiento == 10)
{
	$proceso = "Registro del Dictamen Técnico por No Solventacion del PO";	
	$edoTramite = 10;
	$tipo = "dtns";
}
if($movimiento == 9)
{
	$proceso = "Solventación";	
	$edoTramite = 9;
	$tipo = "recepcion";
}

if($movimiento == 8)
{
	$proceso = "Registro de Baja por Conclusión Previa a su Emisión";
	$edoTramite = 8;	
	$tipo = "recepcion";
}

if($movimiento == 'otro')
{
	//$proceso = "";	
	//$edoTramite = 0;
}
//-------------------------- fecha y hora de volante --------------------------
$fechasVolantes = date('Y-m-d');
$horasVolantes = date("H:i:s");
//-------------------------- recupera info de respaldo ------------------------
$sql = $conexion->select("SELECT * FROM volantes_respaldo WHERE volante = '".$folio."' ",false);
$rr = mysql_fetch_array($sql);	
$total = mysql_num_rows($sql);
$antAccion = $rr['accion'];
$antEdo = $rr['ant_edo_tram'];
$antFecEdo = $rr['ant_fecha_edo_tram'];
$antHorEdo = $rr['ant_hora_edo_tram'];
$antUser = $rr['ant_usuario'];
/*
echo "-------------------------------------------------------";
echo "\n Id volante  ";
echo $idVol;
echo "\n total rows ";
echo $total;
echo "\n anterior edo";
echo $antEdo;
echo "\n edo tramite";
echo $edoTramite;
echo "\n \n";
print_r($_POST);
echo "\n \n";
*/
//id	volante	accion	ant_edo_tram	ant_fecha_edo_tram	ant_hora_edo_tram	ant_usuario	act_edo_tram	act_fecha_edo_tram	act_hora_edo_tram	act_usuario	tipo

//-------------------------- cancela movimiento -------------------------------
if($tipoAccion == "cancela" && $movimiento != 'otro')
{
	$sql = $conexion->update("UPDATE volantes SET status = 0 WHERE id = ".$idVol." ",false); 
	$sql = $conexion->update("UPDATE po_historial SET status = 0 WHERE volante = ".$folio." ",false); 	
	$sql = $conexion->update("UPDATE po_envio_recepcion SET status = 0 WHERE volante_recepcion = ".$idVol." ",false); 
	if($antEdo != 0 || $antEdo != "")
		$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= ".$antEdo.",ip_edo_tram='".$antUser."',fecha_estado_tramite='".$antFecEdo."',hora_act_edo_tram='".$antHorEdo."' WHERE num_accion = '".$antAccion."' " ,false);									
}
//-------------------------- modifica movimiento ------------------------------
if($tipoAccion == "modifica" && $movimiento != 'otro')
{
	if($accion == $antAccion)
	{
		$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= ".$edoTramite.",ip_edo_tram='".$usuario."',fecha_estado_tramite='".$fechasVolantes."',hora_act_edo_tram='".$horasVolantes."' WHERE num_accion = '".$accion."' " ,false);									
		$sql = $conexion->update("UPDATE volantes 
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
									status = 1,
									turnado = '$turnado',
									asunto_oficio = '',
									status = 1,
									semaforo = 0,
									generado_por = '$usuario',
									VP = '',
									tipoMovimiento = '$movimiento',
									direccion = '$direccion',
									accion = '$accion'
								WHERE
									id = '$idVol'"
								,false);
		
		//$sql = $conexion->update("UPDATE po_historial SET status = 0 WHERE volante = ".$folio." ",false); 	
		$sql = $conexion->update("UPDATE po_envio_recepcion SET status = 0 WHERE volante_recepcion = ".$idVol." ",false); 
		$sql = $conexion->update("UPDATE po_historial 
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
									nombreProceso = '$proceso'
								WHERE
									volante = '$folio'"	,false);
									
		$sql = $conexion->update("UPDATE po_envio_recepcion 
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
								WHERE
										volante_recepcion = '$folio'"	,false);
	}
	else // si no son iguales las acciones
	{
		//------- solo se le cambia al movimiento el num_accion y asignarle la otra -------------------------------
		//$sql = $conexion->update("UPDATE po_envio_recepcion SET num_accion = '$accion' WHERE volante_recepcion = ".$idVol." ",false);
		//$sql = $conexion->update("UPDATE po_historial SET num_accion = '$accion' WHERE volante = ".$folio." ",false);
		//------- se cancelan los movimiento de la anterior accion ------------
		$sql = $conexion->update("UPDATE volantes SET status = 0 WHERE id = ".$idVol." ",false); 
		$sql = $conexion->update("UPDATE po_historial SET status = 0 WHERE volante = ".$folio." ",false); 	
 		//------- se restaura la anterior accion ---------------------
		if($antEdo != 0 || $antEdo != "")
			$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= ".$antEdo.",ip_edo_tram='".$antUser."',fecha_estado_tramite='".$antFecEdo."',hora_act_edo_tram='".$antHorEdo."' WHERE num_accion = '".$antAccion."' " ,false);									
		//------- se actualiza la nueva accion -----------------------
		if($antEdo != 0 || $antEdo != "")
			$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= ".$edoTramite.",ip_edo_tram='".$usuario."',fecha_estado_tramite='".$fechasVolantes."',hora_act_edo_tram='".$horasVolantes."' WHERE num_accion = '".$accion."' " ,false);									
		//------- se actualiza el volante con los datos de la nueva accion -----------
		$sql = $conexion->update("UPDATE volantes 
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
									status = 1,
									semaforo = 0,
									turnado = '$turnado',
									asunto_oficio = '',
									status = 1,
									generado_por = '$usuario',
									VP = '',
									tipoMovimiento = '$movimiento',
									direccion = '$direccion',
									accion = '$accion'
								WHERE
									id = '$idVol'"
								,false);
		//------- se inserta en el historial el nuevo movimiento  -----------
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
							estadoTramite = '$edoTramite',
							fechaSistema = '".date('Y-m-d')."',
							horaSistema = '".date('H:i:s')."',
							usuario = '$usuario',
							nombreProceso = '$proceso',
							status = 1"
						,false);
		//------- se actualiza el po_envio_recepcion con los datos de la nueva accion -----------
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
	}
}// end modifica != otro 
//----------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------
if($tipoAccion == "cancela" && $movimiento == 'otro')
{
	$sql = $conexion->update("UPDATE volantes SET status = 0 WHERE id = ".$idVol." ",false); 
	$sql = $conexion->update("UPDATE po_bitacora_adicional SET status = 0 WHERE folio = '".$folio."' ",false);

	//------------------------------------------------------------------------------
}
if($tipoAccion == "modifica" && $movimiento == 'otro')
{
	if($accion == $antAccion)
	{
		$txtSql = "UPDATE po_bitacora_adicional
					SET
						num_accion = '$accion', 
						folio = '$folio',
						tipo_oficio_adicional = '$movimiento', 
						oficio_tipo_oficio_adicional = '$oficio', 
						fecha_tipo_oficio_adicional = '$fechaOficio', 
						acuse_tipo_oficio_adicional = '$fechaAcuse', 
						leyenda_tipo_oficio_adicional = '$asunto', 
						referencia_tipo_oficio_adicional = '$remitente',
						status = 1						
					WHERE folio = '$folio' ";
		$sql = $conexion->update($txtSql,false);
		
		//------- se actualiza el volante con los datos de la nueva accion -----------
		$sql = $conexion->update("UPDATE volantes 
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
									status = 1,
									turnado = '$turnado',
									asunto_oficio = '',
									status = 1,
									semaforo = 0,
									generado_por = '$usuario',
									VP = '',
									tipoMovimiento = '$movimiento',
									direccion = '$direccion',
									accion = '$accion'
								WHERE
									id = '$idVol'"
								,false);
	}
	//------------------------------------------------------------------------------
	else 
	{
		$txtSql = "UPDATE po_bitacora_adicional 
					SET
						num_accion = '$accion', 
						folio = '$folio',
						tipo_oficio_adicional = '$movimiento', 
						oficio_tipo_oficio_adicional = '$oficio', 
						fecha_tipo_oficio_adicional = '$fechaOficio', 
						acuse_tipo_oficio_adicional = '$fechaAcuse', 
						leyenda_tipo_oficio_adicional = '$asunto', 
						referencia_tipo_oficio_adicional = '$remitente',
						status = 1						
					 WHERE folio = '$folio' ";
		$sql = $conexion->update($txtSql,false);
		
		//------- se actualiza el volante con los datos de la nueva accion -----------
		$sql = $conexion->update("UPDATE volantes 
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
									status = 1,
									turnado = '$turnado',
									asunto_oficio = '',
									status = 1,
									semaforo = 0,
									generado_por = '$usuario',
									VP = '',
									tipoMovimiento = '$movimiento',
									direccion = '$direccion',
									accion = '$accion'
								WHERE
									id = '$idVol'"
								,false);
	}
}


	//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
	$sql = $conexion->select("SELECT * FROM volantes_remitentes WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
	$total = mysql_num_rows($sql);
	
	if($total == 0)
		$sql = $conexion->insert("INSERT INTO volantes_remitentes SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	

//print_r($_POST);
//echo $tipoAccion ." -> ".$accion ." == ". $antAccion ." --- \n";
echo $idVol;

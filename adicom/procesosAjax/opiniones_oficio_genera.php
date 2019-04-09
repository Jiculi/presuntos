<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$con=0;
foreach($_POST as $nombre_campo => $valor)
{
   $resultado = strpos($nombre_campo, "accionVinculada_"); 
   if($resultado  !== FALSE)
   {
	   if($con == 0) $accion = valorSeguro($valor);
	   $acciones .= valorSeguro($valor)."|";
	   $con++;
   }
   else
   {
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
   }
}

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
//-------------------------------------------------------------------------------
//--------------- COMPROBACION DE QUE NO SE REPITA OFICIO -----------------------

$sql = $conexion->select("SELECT num_accion,hora_oficio,abogado_solicitante,tipo FROM oficios WHERE num_accion LIKE '$acciones' AND hora_oficio = '$horaOficio' AND abogado_solicitante = '$userForm'   ", false);
$TO = mysql_num_rows($sql);

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//------------------- IMPORTANTE NO MOVER EL ORDEN DE LOS PROCESOS --------------
//------------------- buscamos año del ultimo oficio  ---------------------------
//-- de la tabla de folios buscamos por id y de mas a menos y tenemos el ultimo.-
//-------------------------------------------------------------------------------
if($TO == 0){
	$sql = $conexion->select("SELECT * FROM oficios ORDER BY id DESC LIMIT 1", false);
	$totalOf = mysql_num_rows($sql);
	$r = mysql_fetch_array($sql);
	$fechaPartes = explode("-",$r['fecha_oficio']);
	$consecutivo = $r['consecutivo']; 
	$anioAnt = $fechaPartes[0];
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;
	//-------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO oficios 
							  SET 
								consecutivo = '',
								folio = '',
								fecha_oficio = '$fechaOficio',
								hora_oficio = '$horaOficio',
								num_accion = '$acciones',
								oficio_referencia = '$oficioRef',
								destinatario = '$remitente',
								cargo_destinatario = '$cargo',
								dependencia = '$dependencia',
								asunto = '$asunto',
								abogado_solicitante = '$userForm',
								tipo = 'opi_legal',
								status = 2,
								juridico = 1,
								tipoOficio='Opinion Legal'
								"
							,false);
	
	$ultimo_id = mysql_insert_id(); 
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $uid = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $uid = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $uid = "0".$consecutivo;
	if($consecutivo >= 1000) $uid = $consecutivo;
	
	$folio = "DGR-".$dirForm."-";
	$anio = substr(date('Y'),-2);
	$folio .= $uid."/".$anio;
	
	$sql = $conexion->update("UPDATE oficios SET consecutivo = $consecutivo,folio = '$folio'  WHERE id = $ultimo_id ", false);

	//-------------------------------------------------------------------------------
	// lo creamos con estatus 0
	
	if($tipoOficio == "opi_legal")	
	{
		$partesAcciones = explode("|",$acciones);
		
		foreach($partesAcciones as $k => $v)
		{
			if($v != "")
			{
				$sqltxtX = "INSERT INTO opiniones_historial 
				(
					num_accion,
					tipo,
					oficio,
					oficioRecepcion,
					estadoTramite,
					fechaSistema,
					horaSistema,
					usuario,
					nombreProceso,
					status,
					tipo_devolucion
				) 
				VALUES 
				(
					'".$v."',
					'asistencia/devolucion',
					'".$folio."',
					'".$fechaOficio."',
					'opiniones_enviadoAUU',
					'".$fechaOficio."',
					'".$horaOficio."',
					'".$userForm."',
					'opiniones_enviadoAUU',
					0,
					'".$tipoOficio."'
				)";
				$sqlAs = $conexion->insert($sqltxtX,false);
			}
		}
		//echo $sqltxtX;
	}
	//--------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------
	$partesAcciones = explode("|",$acciones);

	//-------------- INSERTAMOS EN LA TABLA FOLIOS CONTENIDO CADA ACCION -------------------------------
	foreach($partesAcciones as $k => $v)
	{
		if($v != "")
		{
			$sqlX = $conexion->insert("INSERT INTO oficios_contenido 
										SET 
											 folio = '".$folio."',
											 num_accion = '".$v."',
											 oficio_referencia = '".$oficioRef."',
											 juridico = 1 ",false);
		}
	}
		//insertamos datops a las tabla del oficios PDF
	if($tipoOficio == 'opi_legal')
	{		
		$remNom = $remitente;
		$remCar = $cargo;
		$remDep = $dependencia;
		$fechaPO = $fechaPO;
		$acciones=$accionvolante;
		
		//iniciales
		$user = dameUsuario($userForm);
		$usNombre = iniciales($user['nombre']);
		$usJefe = iniciales($user['jefe']);
		$usSubd = iniciales($user['subdirector']);
		$usDir = iniciales($user['director']);
	
		$iniciales = $usDir."/".$usSubd."/".$usJefe."/".$usNombre;
		
	
		$sql = $conexion->select("SELECT * from opiniones where num_accion = '".$accion."'", false);

		$datos = mysql_fetch_array($sql);
	
		$po = $datos['numero_de_pliego'];
		



		
		//insertamos datops a las tabla del oficios PDF
		$query1 = "
				INSERT INTO oficios_pdf SET
					oficio = '".$folio."',
					po = '".$po."',
					fecha_oficio = '".$fechaOficio."',
					destinatario = '".$remNom."',
					cargo_destinatario = '".$remCar."',
					dependencia_destinatario = '".$remDep."',
					cp = '".$cp."',
					ef = '".$ef."',
					num_accion = '".$accion."',
					monto = '".$mm."',
					UAA = '".$ua."',
					director_UAA = '".$di."',
					iniciales = '".$iniciales."',
					hora_sistema  = '".$horaOficio."' ";
		$sql = $conexion->insert($query1,false);
		


		
	}
	
	echo $folio."|".$po."|".$remNom."|".$remCar."|".$remDep."|".$fechaPO."|".$fechaOficio."|".$horaOficio."|".$iniciales."|".$accion;
}// end TO
	
else
{ echo "<br><br><center><h2>Ya existe un oficio idéntico... <br> Notifíquelo a la Administración </center></h2>"; }


@mysql_free_result($sql);

?>

<?php

//error_reporting(E_ALL);
require_once("../includes/funciones.php");
require_once('../e/database.php');
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
$numJuicio = $_POST['numJuicio'];
$num_accion = $_POST['accionvolante'];  
$idJuicio = $_POST['idJuicio'];
$remitente = $_POST['remitente'];
$cargo  = $_POST['cargo'];
$dependencia = $_POST['dependencia'];
$asunto = $_POST['asunto'];
$userForm = $_POST['userForm'];
$dirForm = $_POST['dirForm'];
$tipoOficio = "juicios";
$tipo = $_POST['tipo'];
$correoOficio = $_POST['correoOficio'];
$correoFecha = fechaMysql($_POST['correoFecha']);
$correoAcuse = fechaMysql($_POST['correoAcuse']);


function generaNumVolante($tipo = "", $fechasVolantes, $horasVolantes, $turnado, $usuario, $direccion, $Accion, $id)
{
	$pdo = Database::connect();
 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "SELECT * FROM volantes WHERE tipoVolante != 'medios_rr' ORDER BY id DESC LIMIT 1";
	$sqlv = $pdo->prepare($sql);
	$sqlv->execute();
	$totalOf = $sqlv->rowCount();

	$v = $sqlv->fetch(PDO::FETCH_ASSOC);
	$fechaPartes = explode("-",$v['fecha_actual']);
	$folioPartes = explode("/",$v['folio']);
	$consecutivo = $folioPartes[0];
	$anioAnt = $fechaPartes[0];
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $consecutivo = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $consecutivo = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $consecutivo = "0".$consecutivo;
	if($consecutivo >= 1000) $consecutivo = $consecutivo;
	$anio = substr(date('Y'),-2);
	
	if($tipo != "medios_rr")
		$folio = $consecutivo."/".$anio;
	else
		$folio = "CAMBIAR-".$consecutivo."/".$anio;
	
	try {
		$sql = "INSERT INTO volantes (hora_registro, fecha_actual, turnado, semaforo, generado_por, direccion, accion, VP, tipoVolante)
								VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($horasVolantes, $fechasVolantes, $turnado, 0, $usuario, $direccion, $Accion, $id, $tipo));
		$ultimo_id = $pdo->lastInsertId();
		$sql = "UPDATE volantes SET folio = '$folio' WHERE id = $ultimo_id";
		$sqlv = $pdo->prepare($sql);
		$sqlv->execute();
		return $folio;
	} catch( PDOExecption $e ) { 
    	return "Error!: " . $e->getMessage() . "</br>"; 
	}
}

//-------------------------------------------------------------------------------


$numVolante = generaNumVolante($tipo, $fechaOficio, $horaOficio, $userForm, $userForm, $dirForm, $num_accion, $idJuicio);


$sql = "INSERT INTO volantes_contenido (folio, accion, presunto, idPresunto, oficio, fecha_oficio, fecha_acuse, entidad_dependencia, 
                                             remitente, cargo,  asunto, turnado, tipoMovimiento, direccion )
							VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$q = $pdo->prepare($sql);
$q->execute(array( $numVolante, $num_accion, $numJuicio, $idJuicio, $correoOficio, $correoFecha, $correoAcuse, $dependencia, 
                    $remitente, $cargo,  $asunto, $userForm, $tipo, $dirForm));


		// actualizamos juicio nulidad  ----------------

		// Notificación de la Sentencia
		if($tipo == "sentencia")
		{							 
			$sql = "UPDATE juiciosnew SET
						fecha_not_sentencia = '$fechaOficio'
					WHERE id = '$idJuicio'";
			$q = $pdo->prepare($sql);
			$q->execute();
		}
		
		// amparoDirecto
		if($tipo == "amparoDirecto")
		{							 
			$sql = "UPDATE juiciosnew SET
						fecha_not_ejec_amp = '$fechaOficio'
					WHERE id = '$idJuicio'";
			$q = $pdo->prepare($sql);
			$q->execute();
		}

		// amparoRevisión
		if($tipo == "amparoRevisión")
		{							 
			$sql = "UPDATE juiciosnew SET
							fecha_not_ejec_rev = '$fechaOficio'
					WHERE id = '$idJuicio'";
			$q = $pdo->prepare($sql);
			$q->execute();
		}


    

	echo $numVolante . "|" . $fechaOficio . "|" . $horaOficio;

	Database::disconnect();

?>
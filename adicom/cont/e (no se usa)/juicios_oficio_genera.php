<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

// error_reporting(E_ALL);

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");

$num_accion = $_POST['accionvolante'];  // FLL $_POST['totalAcciones'];
$presunto = $_POST['volante']; // FLL $_POST['totalPresuntos'];
$idPresunto ="xxx";

$idJuicio = $_POST['idJuicio'];
$oficioRef = $_POST['oficioRef'];
$remitente = $_POST['remitente'];
$cargo  = $_POST['cargo'];
$dependencia = $_POST['dependencia'];
$asunto = $_POST['asunto'];
$userForm = $_POST['userForm'];
$dirForm = $_POST['dirForm'];
$tipoOficio = "medios";
$tipo = $_POST['tipo'];


//-------------------------------------------------------------------------------
function generaOficioJuicioNulidad($tipo, $fechaOficio, $horaOficio, $num_accion, $presunto, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio, $idJuicio)
{
	$sql = mysql_query("SELECT * FROM oficios ORDER BY id DESC LIMIT 1");
	
	
	$totalOf = mysql_num_rows($sql);
    $r = mysql_fetch_array($sql);
    
	$fechaPartes = explode("-",$r['fecha_oficio']);
	$consecutivo = $r['consecutivo']; 
	$anioAnt = $fechaPartes[0];
	$aniocompuesto = date('Y');
	if($anioAnt='0000' ) $anioAnt = $aniocompuesto ; //--------------------MODIFICAR AÑO A PRINCIPIOS DEL 2018 "MUUUY IMPORTANTE"
	
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;

    //-------------------------------------------------------------------------------


	$resultado = mysql_query("INSERT INTO oficios 
							  SET 
								consecutivo = '$consecutivo',
								folio = '',
								fecha_oficio = '$fechaOficio',
								hora_oficio = '$horaOficio',
								num_accion = '$num_accion',
								oficio_referencia = '$oficioRef',
								destinatario = '$remitente',
                                presunto = '$presunto',
								cargo_destinatario = '$cargo',
								dependencia = '$dependencia',
								asunto = '$asunto',
								abogado_solicitante = '$userForm',
								tipo = '$tipo',
								visto = '$idJuicio',
								tipoOficio = '$tipoOficio',
								status = 2,
                                porPresunto =0,
                                atendido = 0,
								juridico = 1
                                ");
    if (!$resultado) {
        die('Consulta no válida: ' . mysql_error());
    }

    // printf("El último registro insertado tiene el id %d\n", mysql_insert_id());
	
	$ultimo_id = mysql_insert_id(); 
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $uid = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $uid = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $uid = "0".$consecutivo;
	if($consecutivo >= 1000) $uid = $consecutivo;
	
	$folio = "DGR-".$dirForm."-";
	
	$anio = substr(date('Y'),-2);
	$folio .= $uid."/".$anio;
	
	$sql = mysql_query("UPDATE oficios SET consecutivo = $consecutivo,folio = '$folio'  WHERE id = $ultimo_id ");
	
	return $folio;
}
//-------------------------------------------------------------------------------




	$folio = generaOficioJuicioNulidad($tipo, $fechaOficio, $horaOficio, $num_accion, $presunto, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio, $idJuicio);
	//-------------------------------------------------------------------------------

		// actualizamos juicio nulidad  ----------------

		// Contestación de Demanda en el Juicio Contencioso
		if($tipo == "contestacion_jn")
		{							 
			$query = "UPDATE juiciosnew SET
						oficio_contestacion = '$folio',
						fecha_pre_tribunal = '$fechaOficio'
					WHERE accion = '$num_accion'";
			$sql = $conexion->update($query);
		}

	    // Contestación a la Ampliación de Demanda en el Juicio Contencioso
		if($tipo == "contest_amp_jn")
		{							 
			$query = "UPDATE juiciosnew SET
						oficio_ampliacion = '$folio',
						fecha_pre_ampliacion = '$fechaOficio'
					WHERE accion = '$num_accion'";
			$sql = $conexion->update($query);
		}

		// Alegatos en el Juicio Contencioso
		if($tipo == "alegatos_jn")
		{							 
			$query = "UPDATE juiciosnew SET
						oficio_alegatos = '$folio',
						fecha_pre_alegatos = '$fechaOficio'
					WHERE accion = '$num_accion'";
			$sql = $conexion->update($query);
		}
		
    

	echo $folio . "|" . $fechaOficio . "|" . $horaOficio;


    @mysql_free_result($sql);

?>
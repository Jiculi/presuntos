<?php
//header("Cache-Control: no-store, no-cache, must-revalidate");
//header("Content-Type: text/html;charset=utf-8");

// error_reporting(E_ALL);

//require_once("../includes/clases.php");
require_once("../includes/funciones.php");
//$conexion = new conexion;
//$conexion->conectar();

require_once('database.php');

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");

$num_accion = $_POST['accionvolante'];  
$volante = $_POST['volante']; 
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
function generaOficioJuicioNulidad($tipo, $fechaOficio, $horaOficio, $num_accion, $volante, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio, $idJuicio)
{
    $pdo = Database::connect();

    
    $sql = 'SELECT * FROM oficios ORDER BY id DESC LIMIT 1';
    $q = $pdo->prepare($sql);
    $q->execute();
    $totalOf = $q->rowCount();

    //$r->fetchAll();
    $r = $q->fetch(PDO::FETCH_OBJ);

	$fechaPartes = explode("-",$r->fecha_oficio);
	$consecutivo = $r->consecutivo; 
	$anioAnt = $fechaPartes[0];
	$aniocompuesto = date('Y');
	if($anioAnt='0000' ) $anioAnt = $aniocompuesto ; //--------------------MODIFICAR AÑO A PRINCIPIOS DEL 2018 "MUUUY IMPORTANTE"
	
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;

    //-------------------------------------------------------------------------------



    try { 
        $sql = "INSERT INTO oficios (consecutivo, folio, fecha_oficio, hora_oficio, num_accion, oficio_referencia, destinatario, presunto, 
                                cargo_destinatario, dependencia, asunto, abogado_solicitante, tipo, visto, tipoOficio, status, porPresunto, atendido, juridico )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($consecutivo, '', $fechaOficio, $horaOficio, $num_accion, $oficioRef, $remitente, $volante, $cargo, $dependencia, 
                $asunto, $userForm, $tipo, $idJuicio, $tipoOficio, 2, 0, 0, 1 ));
    } catch( PDOExecption $e ) { 
                return "Error!: " . $e->getMessage() . "</br>"; 
    }
        

    // printf("El último registro insertado tiene el id %d\n", mysql_insert_id());
	
	$ultimo_id = $pdo->lastInsertId();
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $uid = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $uid = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $uid = "0".$consecutivo;
	if($consecutivo >= 1000) $uid = $consecutivo;
	
	$folio = "DGR-".$dirForm."-";
	
	$anio = substr(date('Y'),-2);
    $folio .= $uid."/".$anio;
    

    $sql = "UPDATE oficios SET  consecutivo = :consecutivo, folio = :folio WHERE id = :id";
    $q = $pdo->prepare($sql);
    $q->bindParam(":consecutivo",$consecutivo);
    $q->bindParam(":folio", $folio);
    $q->bindParam(":id", $ultimo_id);
    $q->execute();  

	return $folio;
}
//-------------------------------------------------------------------------------

$sql = 'SELECT folio FROM volantes WHERE folio = :folio';
$q = $pdo->prepare($sql);
$q->bindParam(":folio", $volante);
$q->execute();
$totalOf = $q->rowCount();
if ($totalOf == 0) {
    echo  "error" . "|" .  "error" . "|" .  "error";
} else {



	    $folio = generaOficioJuicioNulidad($tipo, $fechaOficio, $horaOficio, $num_accion, $volante, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio, $idJuicio);

		// actualizamos juicio nulidad  ----------------

		// Contestación de Demanda en el Juicio Contencioso
		if($tipo == "contestacion_jn") {							 
			$sql = "UPDATE juiciosnew SET
						oficio_contestacion = :oficio_contestacion,
						fecha_pre_tribunal = :fecha_pre_tribunal
                    WHERE accion = :accion";
            $q = $pdo->prepare($sql);
            $q->bindParam(":oficio_contestacion", $folio);
            $q->bindParam(":fecha_pre_tribunal", $fechaOficio);
            $q->bindParam(":accion", $num_accion);
            $q->execute();  
		}

	    // Contestación a la Ampliación de Demanda en el Juicio Contencioso
		if($tipo == "contest_amp_jn") {							 
			$query = "UPDATE juiciosnew SET
						oficio_ampliacion = :oficio_ampliacion,
						fecha_pre_ampliacion = :fecha_pre_ampliacion
                    WHERE accion = :accion";
          
            $q = $pdo->prepare($query);
            $q->bindParam(":oficio_ampliacion", $folio);
            $q->bindParam(":fecha_pre_ampliacion", $fechaOficio);
            $q->bindParam(":accion", $num_accion);
            $q->execute();
		}


       
		if($tipo == "alegatos_jn") {							 
			$query = "UPDATE juiciosnew SET
						oficio_alegatos = :oficio_alegatos,
						fecha_pre_alegatos = :fecha_pre_alegatos
                    WHERE accion = :accion";
            $q = $pdo->prepare($query);
            $q->bindParam(":oficio_alegatos", $folio);
            $q->bindParam(":fecha_pre_alegatos", $fechaOficio);
            $q->bindParam(":accion", $num_accion);
            $q->execute();
		}

	    echo $folio . "|" . $fechaOficio . "|" . $horaOficio;
}

Database::disconnect();

?>
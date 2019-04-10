<?php
	require_once("../includes/funciones.php");
	require_once('database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$id = $_POST['id'];
$fechanot = (empty($_POST['fechanot'])? null : $_POST['fechanot']);
$f_resolucion = (empty($_POST['f_resolucion'])? null : $_POST['f_resolucion']);
$fecha_sentencia = (empty($_POST['fecha_sentencia'])? null : $_POST['fecha_sentencia']);
$fecha_not_sentencia = (empty($_POST['fecha_not_sentencia'])? null : $_POST['fecha_not_sentencia']);
$resultado = $_POST['resultado'];
$observaciones = $_POST['observaciones'];
$ejecutoria_revision = $_POST['ejecutoria_revision'];
$fecha_pre_rf = (empty($_POST['fecha_pre_rf'])? null : $_POST['fecha_pre_rf']);
$fecha_ejec_rev = (empty($_POST['fecha_ejec_rev'])? null : $_POST['fecha_ejec_rev']);
$fecha_not_ejec_rev = (empty($_POST['fecha_not_ejec_rev'])? null : $_POST['fecha_not_ejec_rev']);
$rf_observaciones = $_POST['rf_observaciones'];
$ejecutoria_amparo = $_POST['ejecutoria_amparo'];
$rf_status = $_POST['rf_status'];
$ad_f_interposicion = (empty($_POST['ad_f_interposicion'])? null : $_POST['ad_f_interposicion']);
$fecha_ejec_amp = (empty($_POST['fecha_ejec_amp'])? null : $_POST['fecha_ejec_amp']);
$fecha_not_ejec_amp = (empty($_POST['fecha_not_ejec_amp'])? null : $_POST['fecha_not_ejec_amp']);
$fecha_ejec_amp = (empty($_POST['fecha_ejec_amp'])? null : $_POST['fecha_ejec_amp']);
$ad_observaciones = $_POST['ad_observaciones'];
$ad_status = $_POST['ad_status'];
$oficio_contestacion = $_POST['oficio_contestacion'];
$fecha_pre_tribunal = (empty($_POST['fecha_pre_tribunal'])? null : $_POST['fecha_pre_tribunal']);
$oficio_ampliacion = $_POST['oficio_ampliacion'];
$fecha_pre_ampliacion = (empty($_POST['fecha_pre_ampliacion'])? null : $_POST['fecha_pre_ampliacion']);
$oficio_alegatos = $_POST['oficio_alegatos'];
$fecha_pre_alegatos = (empty($_POST['fecha_pre_alegatos'])? null : $_POST['fecha_pre_alegatos']);
$sentencia_primera = $_POST['sentencia_primera'];



//&=&comparecencia=&fecha_not_cumplimiento=&fecha_sent_cumplimiento=&sentencia_cumplimiento=&fecha_conclusion=&estado=


$data = [
    'fechanot' => $fechanot,
    'f_resolucion' => $f_resolucion,
    'fecha_sentencia' => $fecha_sentencia, 
    'fecha_not_sentencia' => $fecha_not_sentencia,
    'resultado' => $resultado,
    'observaciones' => $observaciones,
    'ejecutoria_revision' => $ejecutoria_revision,
    'fecha_pre_rf' => $fecha_pre_rf,
    'fecha_ejec_rev' => $fecha_ejec_rev,
    'fecha_not_ejec_rev' => $fecha_not_ejec_rev,
    'rf_observaciones' => $rf_observaciones,
    'ejecutoria_amparo' => $ejecutoria_amparo,
    'rf_status' => $rf_status,
    'ad_f_interposicion' => $ad_f_interposicion,
    'fecha_ejec_amp' => $fecha_ejec_amp,
    'fecha_not_ejec_amp' => $fecha_not_ejec_amp,
    'fecha_ejec_amp' => $fecha_ejec_amp,
    'ad_observaciones' => $ad_observaciones,
    'ad_status' => $ad_status,
    'oficio_contestacion' => $oficio_contestacion,
    'fecha_pre_tribunal' => $fecha_pre_tribunal,
    'oficio_ampliacion' => $oficio_ampliacion,
    'fecha_pre_ampliacion' => $fecha_pre_ampliacion,
    'oficio_alegatos' => $oficio_alegatos,
    'fecha_pre_alegatos' => $fecha_pre_alegatos,
    'sentencia_primera' => $sentencia_primera,

    
    'id' => $id
];

//  

try { 
	$sql = "UPDATE juiciosNew SET fechanot = :fechanot,  
                                    f_resolucion = :f_resolucion, 
                                    fecha_sentencia = :fecha_sentencia, 
                                    fecha_not_sentencia = :fecha_not_sentencia,  
                                    resultado = :resultado,  
                                    observaciones = :observaciones,  
                                    ejecutoria_revision = :ejecutoria_revision,  
                                    fecha_pre_rf = :fecha_pre_rf,  
                                    fecha_ejec_rev = :fecha_ejec_rev,  
                                    fecha_not_ejec_rev = :fecha_not_ejec_rev, 
                                    rf_observaciones = :rf_observaciones,  
                                    ejecutoria_amparo = :ejecutoria_amparo,  
                                    rf_status = :rf_status,  
                                    ad_f_interposicion = :ad_f_interposicion,  
                                    fecha_ejec_amp = :fecha_ejec_amp,  
                                    fecha_not_ejec_amp = :fecha_not_ejec_amp,  
                                    fecha_ejec_amp = :fecha_ejec_amp,  
                                    ad_observaciones = :ad_observaciones,  
                                    ad_status = :ad_status,  
                                    oficio_contestacion = :oficio_contestacion,
                                    fecha_pre_tribunal = :fecha_pre_tribunal,  
                                    oficio_ampliacion = :oficio_ampliacion,  
                                    fecha_pre_ampliacion = :fecha_pre_ampliacion,  
                                    oficio_alegatos = :oficio_alegatos,
                                    sentencia_primera = :sentencia_primera,




                                    fecha_pre_alegatos = :fecha_pre_alegatos

    WHERE id = :id";

	$q = $pdo->prepare($sql);
	$q->execute($data);

	$mensaje = "Juicio actalizado";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
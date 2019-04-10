<?php
	require_once("../includes/funciones.php");
	require_once('database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$id = $_POST['idJuicio'];
$recurso = $_POST['recurso'];
$oficoRF = $_POST['oficioRF'];
$fInterposicion = fechaMysql($_POST['fInterposicion']);
$instancia = $_POST['instancia'];
$observaciones = $_POST['observaciones'];

$data = [
    'ejecutoria_revision' => $recurso,
    'rf_oficio' => $oficoRF,
    'fecha_pre_rf' => $fInterposicion,
    'tribunal' => $instancia,
    'rf_observaciones' => $observaciones, 
    'rf_status' => "en espera",
    'toca_en_revision' => "si",
    
    'id' => $id
];

try { 
	$sql = "UPDATE juiciosNew SET ejecutoria_revision = :ejecutoria_revision,  
                                    rf_oficio = :rf_oficio, 
                                    fecha_pre_rf = :fecha_pre_rf, 
                                    tribunal = :tribunal, 
                                    rf_observaciones = :rf_observaciones, 
                                    toca_en_revision = :toca_en_revision,   
                                    rf_status = :rf_status   
    WHERE id = :id";

	$q = $pdo->prepare($sql);
	$q->execute($data);

	$mensaje = "Recurso de revisión fiscal dado de alta";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
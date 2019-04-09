<?php
	require_once("../includes/funciones.php");
	require_once('database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$id = $_POST['idJuicio'];
$recurso = $_POST['recurso'];
$fInterposicion = fechaMysql($_POST['fInterposicion']);
$instancia = $_POST['instancia'];
$observaciones = $_POST['observaciones'];

$data = [
    'ejecutoria_amparo' => $recurso,
    'ad_f_interposicion' => $fInterposicion,
    'tribunal' => $instancia,
    'ad_observaciones' => $observaciones, 
    'ad_status' => "trámite",
    'toca_amparo' => "si",
    
    'id' => $id
];

try { 
	$sql = "UPDATE juiciosNew SET ejecutoria_amparo = :ejecutoria_amparo,  
                                    ad_f_interposicion = :ad_f_interposicion, 
                                    tribunal = :tribunal, 
                                    ad_observaciones = :ad_observaciones, 
                                    toca_amparo = :toca_amparo,   
                                    ad_status = :ad_status   
    WHERE id = :id";

	$q = $pdo->prepare($sql);
	$q->execute($data);

	$mensaje = "Amparo Directo dado de alta";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
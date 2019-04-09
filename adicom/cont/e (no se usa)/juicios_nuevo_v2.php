<?php
	require_once("../includes/funciones.php");
	require_once('database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$resultado = "trámite";
$nojuicio = "2019"; // valorSeguro($_POST['nojuicio']);

$accion = $_POST['accion'];
$procedimiento = $_POST['procedimiento'];
$salaconocimiento = $_POST['salaconocimiento'];
$actor = $_POST['actor'];
$juicionulidad = $_POST['juicionulidad'];
$dir = $_POST['dir'];
$fechanot = fechaMysql($_POST['fechanot']);
$sub = $_POST['sub'];
$vencimiento = fechaMysql($_POST['vencimiento']);
$monto = $_POST['monto'];

try { 
	$sql = "INSERT INTO juiciosNew (nojuicio, fechanot,  dir, accion, procedimiento, resultado, sub, salaconocimiento, juicionulidad, actor, vencimiento, monto)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($nojuicio, $fechanot, $dir, $accion, $procedimiento, $resultado, $sub, $salaconocimiento, $juicionulidad, $actor, $vencimiento, $monto));

	$mensaje = "Juicio Contencioso Administrativo dado de alta en la base de datos";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
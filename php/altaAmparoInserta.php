<?php
	require_once("./funciones.php");  // fechamysql x datepicker
	require_once('./database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$estado = "trámite";

$accion = $_POST['accion'];
$procedimiento = $_POST['procedimiento'];
$salaconocimiento = $_POST['salaconocimiento'];
$actor = $_POST['actor'];
$amparoIndirecto = $_POST['amparoIndirecto'];
$dir = $_POST['dir'];
$fechanot = fechaMysql($_POST['fechanot']);
$sub = $_POST['sub'];
$vencimiento = fechaMysql($_POST['vencimiento']);
$cont = $_POST['cont'];


try { 
	$sql = "INSERT INTO ai (f_interposicion,  dir, accion, procedimiento, estado, sub, instancia, ai, actor, vencimiento, cont)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($fechanot, $dir, $accion, $procedimiento, $estado, $sub, $salaconocimiento, $amparoIndirecto, $actor, $vencimiento, $cont));

	$mensaje = $fechanot . "Amparo Indirecto dado de alta";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
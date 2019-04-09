<?php
	session_start();
	require_once("./funciones.php");  // fechamysql x datepicker
	require_once('./database.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $usuario = $_SESSION['usuario'];

$estado = "trámite";

$accion = $_POST['accion'];
$procedimiento = $_POST['procedimiento'];

$actor = $_POST['actor'];
$recurso = $_POST['recurso'];
$dir = $_POST['dir'];
$fechanot = fechaMysql($_POST['fechanot']);
$sub = $_POST['sub'];

$cont = $_POST['cont'];


try { 
	$sql = "INSERT INTO actores_recurso (fecha_recurso,  direccion, num_accion, num_procedimiento, subnivel,  recurso_reconsideracion, actor,  cont, usuario)
				VALUES (?, ?, ?,  ?, ?, ?, ?, ?, ?)";
	$q = $pdo->prepare($sql);
	$q->execute(array($fechanot, $dir, $accion, $procedimiento,  $sub, $recurso, $actor,  $cont, $usuario));

	$mensaje = $fechanot . "Amparo Indirecto dado de alta";
	echo($mensaje);
	return;
} catch( PDOExecption $e ) { 
	return "Error!: " . $e->getMessage() . "</br>"; 
}
	echo "hola"
?>
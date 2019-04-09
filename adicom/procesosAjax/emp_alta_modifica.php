<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//print_r($_REQUEST);

//--------------- Alta usuario
//--------------- Alta usuario
$hoy=date("Y-m-d H:i:s");
//---------------- Inicio de Alta
if($_REQUEST['tipoForm'] == "alta")
{
	//---------- Asignación de datos del formulario a variables nuevas ----------------
$nombre = valorSeguro($_POST['empnom']);
$curp = valorSeguro($_POST['empcurp']);
$usuario = valorSeguro($_POST['empusu']);
$password = valorSeguro($_POST['emppas']);
$nivel = valorSeguro ($_POST['empniv']);
$direccion = valorSeguro($_POST['empdir']);
//$tipo = valorSeguro($_POST['emptip']);
$perfil = valorSeguro($_POST['empper']);
$status = valorSeguro($_POST['empsta']);
//$otros_po = valorSeguro($_POST['empopo']);
//$otros_pfrr = valorSeguro($_POST['empopf']);
$genero = valorSeguro($_POST['empgen']);
$fecha_ingreso = valorSeguro($_POST['empfin']);
$sustituye = valorSeguro($_POST['empsus']);
$noempleado = valorSeguro($_POST['empnoe']);
$tipo_emp = valorSeguro($_POST['emptem']);
$puesto = valorSeguro($_POST['emppue']);
$ascenso = valorSeguro($_POST['empasc']);
//$ascenso2 = valorSeguro($_POST['empas2']);
//$fecha_baja = valorSeguro($_POST['empfba']);
$puesto_ant = valorSeguro($_POST['emppan']);
$opciones = valorSeguro($_POST['empopc']);
$nom = valorSeguro($_POST['nom']);

if($status == "" OR $status == "0" ){$status = "0.5";}
if($usuario == ""){$usuario = "usersn"; $password = "passwordn"; }

	$query = "INSERT INTO usuarios 
			  SET `nombre` = '".$nombre."',
			    `curp` = '".$curp."',
				`usuario`='".$usuario."',
				`password`='".$password."',
				`nivel`='".$nivel."',				
				`direccion`='".$direccion."',
				`perfil`='".$perfil."',
				`opciones`='".$opciones."',
				`status`='".$status."',
				`genero`='".$genero."',
				`fecha_ingreso`='".fechaMysql($fecha_ingreso)."',
				`sustituye`='".$sustituye."',
				`noempleado`='".$noempleado."',
				`tipo_emp`='".$tipo_emp."',
				`puesto`='".$puesto."',
				`ascenso`='".fechaMysql($ascenso)."',
				`puesto_ant`='".$puesto_ant."'   ";
		$sql = $conexion->insert($query);
		
	$queryh = "INSERT INTO usuario_historial
			  SET 
				`movimiento` = 'Alta',
				`empleado`='".$nombre."',
				`datos`='".$curp.", ".$usuario.", ".$password.", ".$nivel.", ".$direccion.", ".$perfil.", ".$opciones.", ".$status.", ".$genero.", ".fechaMysql($fecha_ingreso).", ".$sustituye.", ".$noempleado.", ".$tipo_emp.", ".$puesto.", ".fechaMysql($ascenso).", ".$puesto_ant.".',
				`fecha`='".$hoy."',
				`nombre`='".$nom."'		  ";
		$sqlh = $conexion->insert($queryh);
} //---------------- Fin de Alta

//--------------- Modifica usuario---------------------
//--------------- Modifica usuario---------------------



//---------------------------- Inicio de Actualización
if($_REQUEST['tipoForm'] == "actreg")
{
//--------------- Cambios en genero y estatus 
$genero = valorSeguro($_POST['empgen']);
$status = valorSeguro($_POST['empsta']);
	
if ($status == "Activo con acceso al Sistema ADICOM") $status = 1; 
		else if ($status == "Activo sin acceso al Sistema ADICOM") $status = 0.5;
		else $status = valorSeguro($_POST['empsta']);
		
if ($genero == "Femenino") $genero = "F"; 
		else if ($genero == "Masculino") $genero = "M";	
		else $genero = valorSeguro($_POST['empgen']);
		
//---------- Asignación de datos del formulario a variables nuevas ----------------
$nombre = valorSeguro($_POST['empnom']);
$curp = valorSeguro($_POST['empcurp']);

$usuario = valorSeguro($_POST['empusu']);
$password = valorSeguro($_POST['emppas']);

$nivel = valorSeguro ($_POST['empniv']);

$direccion = valorSeguro($_POST['empdir']);
//$tipo = valorSeguro($_POST['emptip']);
$perfil = valorSeguro($_POST['empper']);
$opciones = valorSeguro($_POST['empopc']);
$fecha_ingreso = valorSeguro($_POST['empfin']);
$sustituye = valorSeguro($_POST['empsus']);
$noempleado = valorSeguro($_POST['empnoe']);
$tipo_emp = valorSeguro($_POST['emptem']);
$puesto = valorSeguro($_POST['emppue']);
$ascenso = valorSeguro($_POST['empasc']);
$ascenso2 = valorSeguro($_POST['empas2']);
$puesto_ant = valorSeguro($_POST['emppan']);
$fecha_baja = valorSeguro($_POST['empfba']);
$id = valorSeguro($_POST['emp_id']);
$nom = valorSeguro($_POST['nom']);

//------------------ Abogado a actual -------------------
$sqla = $conexion->select("SELECT * FROM usuarios WHERE id='".$id."' ",false);
$rre = mysql_fetch_array($sqla);

//------------------ Abogado a anterior -----------------
$sqlo = $conexion->select("SELECT * FROM usuarios WHERE nivel = '".$nivel."' and nombre != '".$nombre."' and status=1 ",false);
$res = mysql_fetch_array($sqlo);
$nomant = $res['nombre'];
$userant = $res['nivel'];
$nivPartant = explode(".",$userant);
$nivDirant = $nivPartant[0];

//----------------- Se coloca la dirección correspondiente segun su nivel ---------
$nivPart = explode(".",$nivel);
$nivDir = $nivPart[0];
	//------------------- Actualiza datos en la base

	$query = "UPDATE usuarios 
			  SET `nombre` = '".$nombre."',
				`curp` = '".$curp."',
				`usuario`='".$usuario."',
				`password`='".$password."',
				`nivel`='".$nivel."',				
				`direccion`='".$nivDir."',
				`perfil`='".$perfil."',
				`opciones`='".$opciones."',
				`status`='".$status."',
				`genero`='".$genero."',
				`fecha_ingreso`='".fechaMysql($fecha_ingreso)."',
				`sustituye`='".$sustituye."',
				`noempleado`='".$noempleado."',
				`tipo_emp`='".$tipo_emp."',
				`puesto`='".$puesto."',
				`ascenso`='".fechaMysql($ascenso)."',
				`ascenso2`='".fechaMysql($ascenso2)."',
				`puesto_ant`='".$puesto_ant."',
				`fecha_baja`='".fechaMysql($fecha_baja)."'
			  WHERE `id`='".$id."' ";
		$sql = $conexion->update($query);
		
if( $nivel != "DG")
{
	if( $nivel == $userant and $nombre != $nomant and $rre['status'] != "0" and $rre['status'] != "0.5")
	{

		$querypo = "UPDATE po 
			  SET
				`abogado`='".$nombre."'
			  WHERE `direccion`='".$nivDir."' and `subnivel`='".$nivel."' ";
		$sqlpo = $conexion->update($querypo);
		
		$querypfrr = "UPDATE pfrr 
			  SET
				`abogado`='".$nombre."',
				`usuario`='".$usuario."'
			  WHERE `direccion`='".$nivDir."' and `subnivel`='".$nivel."' ";
		$sqlpfrr = $conexion->update($querypfrr);
		
				$queryop = "UPDATE opiniones 
			  SET
				`abogado`='".$nombre."'
			  WHERE `direccion`='".$nivDir."' and `subnivel`='".$nivel."' ";
		$sqlpfrr = $conexion->update($queryop);
		
		$querym = "UPDATE actores_recurso 
			  SET
				`usuario`='".$usuario."'
			  WHERE `direccion`='".$nivDir."' and `subnivel`='".$nivel."' ";
		$sqlm = $conexion->update($querym);
		
		$queryu = "UPDATE usuarios 
			  SET
				`nivel`='0',
				`direccion`='0'
			  WHERE `direccion`='".$nivDir."' and `nivel`='".$nivel."' and `nombre` LIKE '%".$nomant."%' ";
		$sqlpu = $conexion->update($queryu);
		
		$queryh1 = "INSERT INTO usuario_historial
			  SET 
				`movimiento` = 'Actualizar anterior',
				`empleado`='".$nomant."',
				`datos`='nivel=".$userant.", direccion=".$nivDirant.".',
				`fecha`='".$hoy."',
				`nombre`='".$nom."'		  ";
		$sqlh1 = $conexion->insert($queryh1);
		
	}
}

if($nombre != $rre['nombre'])		{$datos.= $nombre.", ";}
if($curp != $rre['curp'])			{$datos.= $curp.", ";}
if($usuario != $rre['usuario'])		{$datos.= $usuario.", ";}
if($password != $rre['password'])	{$datos.= $password.", ";}
if($nivel != $rre['nivel'])			{$datos.= $nivel.", ";}
if($nivDir != $rre['direccion'])	{$datos.= $nivDir.", ";}
if($perfil != $rre['perfil'])		{$datos.= $perfil.", ";}
if($opciones != $rre['opciones'])	{$datos.= $opciones.", ";}
if($status != $rre['status'])		{$datos.= $status.", ";}
if($genero != $rre['genero'])		{$datos.= $genero.", ";}
if(fechaMysql($fecha_ingreso) != $rre['fecha_ingreso'])	{$datos.= $fecha_ingreso.", ";}
if($sustituye != $rre['sustituye'])	{$datos.= $sustituye.", ";}
if($noempleado != $rre['noempleado'])	{$datos.= $noempleado.", ";}
if($tipo_emp != $rre['tipo_emp'])	{$datos.= $noempleado.", ";}
if($puesto != $rre['puesto'])		{$datos.= $puesto.", ";}
if(fechaMysql($ascenso) != $rre['ascenso'])	{$datos.= $ascenso.", ";}
if(fechaMysql($ascenso2) != $rre['ascenso2'])	{$datos.= $ascenso2.", ";}
if($puesto_ant != $rre['puesto_ant'])		{$datos.= $puesto_ant.", ";}
if(fechaMysql($fecha_baja) != $rre['fecha_baja'])	{$datos.= $fecha_baja.", ";}

$cadena = substr($datos,0,-2);

	$queryh = "INSERT INTO usuario_historial
			  SET 
				`movimiento` = 'Actualizar nuevo',
				`empleado`='".$nombre."',
				`datos`='".$cadena.".',
				`fecha`='".$hoy."',
				`nombre`='".$nom."'		  ";
		$sqlh = $conexion->insert($queryh);
	
}  //---------------------------- Fin de Actualización
?>
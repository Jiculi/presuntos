<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$funcion = valorSeguro($_REQUEST['funcion']);
$idPresunto = valorSeguro($_REQUEST['idPresunto']);
$servidor = valorSeguro($_REQUEST['servidor']);
$cargo = valorSeguro($_REQUEST['cargo']);
$tipoPresunto = valorSeguro($_REQUEST['tipoPresunto']);
$irregularidad = valorSeguro($_REQUEST['irregularidad']);
$monto = valorSeguro($_REQUEST['monton']);
$fecha = valorSeguro($_REQUEST['fecha']);
$hora = valorSeguro($_REQUEST['hora']);
$usuario = valorSeguro($_REQUEST['usuario']);
$accion =  valorSeguro($_REQUEST['num_accion']);
$normatividad_infringida = valorSeguro ($_REQUEST['normatividad']);
$fecha_irre = valorSeguro ($_REQUEST['fecha_irre']);
$fecha_de_cargo_inicio = valorSeguro ($_REQUEST['fecha_de_cargo_inicio']);
$fecha_de_cargo_final = valorSeguro ($_REQUEST['fecha_de_cargo_final']);
$nueva_norma=valorSeguro ($_REQUEST['norma']);
$nueva_fecha_irre=valorSeguro ($_REQUEST['fechairre']);
$nuevo_monto=valorSeguro ($_REQUEST['nuevo_monto']);
$sqld=$conexion->select("Select * from po where num_accion= '$accion'", false);
$rd=mysql_fetch_array($sqld); 
$dependencia=$rd['entidad_fiscalizada'];

$fecha_de_cargo_inicio_n = valorSeguro ($_REQUEST['fecha_de_cargo_inicio_n']);
$fecha_de_cargo_final_n = valorSeguro ($_REQUEST['fecha_de_cargo_final_n']);


$monto_sin_coma =$monto;
$rmsc = str_replace(",","",$monto_sin_coma);

$monto_sin_coma_nuevo =$nuevo_monto;
$rmscn = str_replace(",","",$monto_sin_coma_nuevo);



//------------------------------------------------------------------------------
print_r($_REQUEST);
echo "<br><br>";

if($funcion == "nuevo")
{
	$sql = $conexion->insert("INSERT INTO po_presuntos 
							  SET 
								  servidor_contratista='$servidor', 
								  cargo_servidor='$cargo', 
								  tipo_presunto='$tipoPresunto', 
								  irregularidad='$irregularidad', 
								  dependencia='$dependencia',
								  monto='$rmsc',
								  normatividad_infringida='$normatividad_infringida',
								  fecha_de_irregularidad='$fecha_irre',
								  fecha_de_cargo_inicio='$fecha_de_cargo_inicio',
								  fecha_de_cargo_final='$fecha_de_cargo_final',
								  num_accion='$accion' ",false);
								  
								  
								  
								  
								  
	
	if($sql) echo "---------- OK --------------";
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
if($funcion == "actualiza")
{
	$sql = $conexion->update("UPDATE po_presuntos 
							  SET 
								  servidor_contratista='$servidor', 
								  cargo_servidor='$cargo',
								  dependencia='$dependencia', 
								  tipo_presunto='$tipoPresunto',  
								  irregularidad='$irregularidad', 
								  monto='$rmscn',
								  normatividad_infringida='$nueva_norma',
								  fecha_de_irregularidad='$nueva_fecha_irre',
								  fecha_de_cargo_inicio='$fecha_de_cargo_inicio_n',
								  fecha_de_cargo_final='$fecha_de_cargo_final_n'



							  WHERE creacion= '$idPresunto' ",false);
	
	if($sql) echo "---------- OK --------------";
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
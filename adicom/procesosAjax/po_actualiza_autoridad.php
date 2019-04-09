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
$tipoPresunto = valorSeguro($_REQUEST['tipoAutoridad']);
$dependencia = valorSeguro($_REQUEST['dependencia']);
$fecha = valorSeguro($_REQUEST['fecha']);
$hora = valorSeguro($_REQUEST['hora']);
$usuario = valorSeguro($_REQUEST['usuario']);
$accion =  valorSeguro($_REQUEST['num_accion']);
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
								  dependencia='$dependencia', 
								  num_accion='$accion' ",false);
	
	if($sql) echo "---------- OK NUEVO --------------";
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
if($funcion == "actualiza")
{
	echo $query = "SELECT * FROM po_presuntos WHERE num_accion='$accion' AND (tipo_presunto = 'responsableInforme' OR tipo_presunto = 'titularICC') ";
	$sql = $conexion->update($query,false);
	echo "Num Aut ".$numAut = mysql_num_rows($sql);
	
	if($numAut == 1)
	{
		$sql = $conexion->update("UPDATE po_presuntos 
								  SET 
									  servidor_contratista='$servidor', 
									  cargo_servidor='$cargo',
									  tipo_presunto='$tipoPresunto',  
									  dependencia='$dependencia' 
								  WHERE creacion = '$idPresunto' ",false);
	}
	if($numAut == 2)
	{
		while($rowAut = mysql_fetch_array($sql))
		{
			if($rowAut['creacion'] == $idPresunto) 
				$seleccionado = $rowAut['creacion'];
			else 
				$elOtro = $rowAut['creacion'];
		}
		
		echo "<br> Elegido ".$seleccionado;
		echo "<br> Otro ".$elOtro;
		echo "<br>  Tipo presunto ".$tipoPresunto;
		
		if($tipoPresunto == 'responsableInforme')
		{
			echo $query = "UPDATE po_presuntos 
									  SET 
										  servidor_contratista='$servidor', 
										  cargo_servidor='$cargo',
										  tipo_presunto='responsableInforme',  
										  dependencia='$dependencia' 
									  WHERE creacion = $seleccionado ";
			$sql = $conexion->update($query,false);
			
			$sql = $conexion->update("UPDATE po_presuntos 
									  SET 
										  tipo_presunto='titularICC'  
									  WHERE creacion = '$elOtro' ",false);
		}
		
		if($tipoPresunto == 'titularICC')
		{
			echo $query = "UPDATE po_presuntos 
									  SET 
										  servidor_contratista='$servidor', 
										  cargo_servidor='$cargo',
										  tipo_presunto='titularICC',  
										  dependencia='$dependencia' 
									  WHERE creacion = $seleccionado ";
			$sql = $conexion->update($query,false);
			
			$sql = $conexion->update("UPDATE po_presuntos 
									  SET 
										  tipo_presunto='responsableInforme'
									  WHERE creacion = '$elOtro' ",false);
		}
	}
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//servidor_contratista	cargo_servidor	irregularidad	num_accion	vencimiento_plazo	monto
}
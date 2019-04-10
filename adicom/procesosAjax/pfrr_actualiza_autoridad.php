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
	$sql = $conexion->insert("INSERT INTO pfrr_presuntos_audiencias
							  SET 
								  nombre='$servidor', 
								  cargo='$cargo', 
								  tipo='$tipoPresunto', 
								  dependencia='$dependencia', 
								  num_accion='$accion' ",false);
	
	if($sql) echo "---------- OK NUEVO --------------";
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//nombre	cargo	irregularidad	num_accion	vencimiento_plazo	monto
}
if($funcion == "actualiza")
{
	echo $query = "SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion='$accion' AND (tipo = 'responsableInforme' OR tipo = 'titularICC') ";
	$sql = $conexion->update($query,false);
	echo "Num Aut ".$numAut = mysql_num_rows($sql);
	
	if($numAut == 1)
	{
		$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias 
								  SET 
									  nombre='$servidor', 
									  cargo='$cargo',
									  tipo='$tipoPresunto',  
									  dependencia='$dependencia' 
								  WHERE cont = '$idPresunto' ",false);
	}
	if($numAut == 2)
	{
		while($rowAut = mysql_fetch_array($sql))
		{
			if($rowAut['cont'] == $idPresunto) 
				$seleccionado = $rowAut['cont'];
			else 
				$elOtro = $rowAut['cont'];
		}
		
		echo "<br> Elegido ".$seleccionado;
		echo "<br> Otro ".$elOtro;
		echo "<br>  Tipo presunto ".$tipoPresunto;
		
		if($tipoPresunto == 'responsableInforme')
		{
			echo $query = "UPDATE pfrr_presuntos_audiencias 
									  SET 
										  nombre='$servidor', 
										  cargo='$cargo',
										  tipo='responsableInforme',  
										  dependencia='$dependencia' 
									  WHERE cont = $seleccionado ";
			$sql = $conexion->update($query,false);
			
			$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias 
									  SET 
										  tipo='titularICC'  
									  WHERE cont = '$elOtro' ",false);
		}
		
		if($tipoPresunto == 'titularICC')
		{
			echo $query = "UPDATE pfrr_presuntos_audiencias 
									  SET 
										  nombre='$servidor', 
										  cargo='$cargo',
										  tipo='titularICC',  
										  dependencia='$dependencia' 
									  WHERE cont = $seleccionado ";
			$sql = $conexion->update($query,false);
			
			$sql = $conexion->update("UPDATE pfrr_presuntos_audiencias 
									  SET 
										  tipo='responsableInforme'
									  WHERE cont = '$elOtro' ",false);
		}
	}
							  
	//$sql = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '2' WHERE num_accion = '".$num_accion."'" ,false);
	//nombre	cargo	irregularidad	num_accion	vencimiento_plazo	monto
}
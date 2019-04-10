<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion = $_REQUEST["accion"];
$acciones = $_REQUEST["acciones"];
$tipo = $_REQUEST["opcion"];

$acciones=str_replace("|","','",$acciones);
$acciones = substr($acciones,0,strlen($acciones)-3);//substr quita ultimo ,' (-2) de la cadena y strlen es el tamaño de letras
$error = 0;
$j = 0;

if($tipo == "dtns_PFRR" ) 
{
	// vemos si todas las UAA's son iguales ------------------------------------------------
	$sqlUAA=$conexion->select("SELECT * FROM fondos WHERE num_accion IN ('".$acciones."') ");
	while($row = mysql_fetch_array ($sqlUAA))
	{
		$ACT = $row['UAA'];
		$j++;
		if($j >= 2)
		{
			if($ACT != $ANT) $error++;
		}
		$ANT = $row['UAA'];
	}
	
	
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];
	
	$asunto="Se devuelve DTNS a la $uaa.";

	$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and (tipoMovimiento = '10' || tipoMovimiento = '11') order by fecha_oficio desc limit 1");
	
	while($r2=mysql_fetch_array ($sql2))
		$ref .= stripslashes(html_entity_decode($r2["referencia"])).",";
	
	$ref = substr($ref,0,strlen($ref)-1);//uiqtamos ultimo caracter a ref
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}


//----------------------------Documetnacion UAA--------


if($tipo =="docu_uaa") 
{
	// vemos si todas las UAA's son iguales ------------------------------------------------
	$sqlUAA=$conexion->select("SELECT * FROM fondos WHERE num_accion IN ('".$acciones."') ");
	while($row = mysql_fetch_array ($sqlUAA))
	{
		$ACT = $row['UAA'];
		$j++;
		if($j >= 2)
		{
			if($ACT != $ANT) $error++;
		}
		$ANT = $row['UAA'];
	}
	
	
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];
	
	$asunto="Se remite información a la $uaa.";

	$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and tipoMovimiento = '10' order by fecha_oficio desc");
	
	while($r2=mysql_fetch_array ($sql2))
		$ref .= stripslashes(html_entity_decode($r2["referencia"])).",";
	
	$ref = substr($ref,0,strlen($ref)-1);//uiqtamos ultimo caracter a ref
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}

//---------------------------------------------------------------------------------------------------------------------------------------
if($tipo == "Not_icc_PFRR")
{ 
	$asunto="Se notifica PFRR a ICC";

	$sql=$conexion->select("SELECT * from pfrr_presuntos_audiencias where tipo = 'titularICC' and num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$sql2=$conexion->select("SELECT num_procedimiento,PDR from pfrr where num_accion = '$accion' ");
	$r2=mysql_fetch_array($sql2);
	
	$ref = $r2['num_procedimiento'];//uiqtamos ultimo caracter a ref

echo $r["nombre"]."|".$r["cargo"]."|".$r["dependencia"]."|".$ref."|".$asunto;
}
//---------------------------------------------------------------------------------------------------------------------------------------
if($tipo == "opinion_UAA_PFRR")
{ 
	// vemos si todas las UAA's son iguales ------------------------------------------------
	$sqlUAA=$conexion->select("SELECT * FROM fondos WHERE num_accion IN ('".$acciones."') ");
	while($row = mysql_fetch_array ($sqlUAA))
	{
		$ACT = $row['UAA'];
		$j++;
		if($j >= 2)
		{
			if($ACT != $ANT) $error++;
		}
		$ANT = $row['UAA'];
	}
	
	$asunto="Esta DGR devuelve a la UAA este DTNS para su opinión técnica.";
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];

	$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and tipoMovimiento = '10' order by fecha_oficio desc");
	
	while($r2=mysql_fetch_array ($sql2))
		$ref .= stripslashes(html_entity_decode($r2["referencia"])).",";
	
	$ref = substr($ref,0,strlen($ref)-1);//uiqtamos ultimo caracter a ref
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}

//-----------------------------REsponsabilidad UAA--

if($tipo == 'resp_uaa')
{ 
	// vemos si todas las UAA's son iguales ------------------------------------------------
	$sqlUAA=$conexion->select("SELECT * FROM fondos WHERE num_accion IN ('".$acciones."') ");
	while($row = mysql_fetch_array ($sqlUAA))
	{
		$ACT = $row['UAA'];
		$j++;
		if($j >= 2)
		{
			if($ACT != $ANT) $error++;
		}
		$ANT = $row['UAA'];
	}
	
	$asunto="Esta DGR inicia el procedimiento bajo esctricta responsabilidad de la UAA.";
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];

	$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and tipoMovimiento = '10' order by fecha_oficio desc");
	
	while($r2=mysql_fetch_array ($sql2))
		$ref .= stripslashes(html_entity_decode($r2["referencia"])).",";
	
	$ref = substr($ref,0,strlen($ref)-1);//uiqtamos ultimo caracter a ref
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}

//---------------------------------------------------------------------------------------------------------------------------------------
if($tipo == "notificarRes_PFRR")
{ 
	// vemos si todas las UAA's son iguales ------------------------------------------------
	$sqlUAA=$conexion->select("SELECT * FROM fondos WHERE num_accion IN ('".$acciones."') ");
	while($row = mysql_fetch_array ($sqlUAA))
	{
		$ACT = $row['UAA'];
		$j++;
		if($j >= 2)
		{
			if($ACT != $ANT) $error++;
		}
		$ANT = $row['UAA'];
	}
	
	$asunto=" No se q poner notificarRes_PFRR.";
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];

	$sql2=$conexion->select("SELECT num_procedimiento,PDR from pfrr where num_accion = '$accion' ");
	$r2=mysql_fetch_array($sql2);
	
	$ref = $r2['num_procedimiento'];//uiqtamos ultimo caracter a ref
	
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
if($tipo == "tesofe_PFRR" || $tipo == "notificarResEF_PFRR" || $tipo == "notificarResICC_PFRR")
{ 
	if($tipo == "tesofe_PFRR") {$tipoP = "titularTESOFE"; $ente = "TESOFE"; }
	if($tipo == "notificarResEF_PFRR") {$tipoP = "responsableInforme"; $ente = "Entidad Fiscalizada"; }
	if($tipo == "notificarResICC_PFRR") {$tipoP = "titularICC"; $ente = "ICC"; }
	
	$sql=$conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' AND tipo = '".$tipoP."' ");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["nombre"];
	$cargo=$r["cargo"];
	$uaa=$r["dependencia"];
	$asunto="Se notifica la Reolución a ".$ente.".";

	$sql2=$conexion->select("SELECT num_procedimiento,PDR from pfrr where num_accion = '$accion' ");
	$r2=mysql_fetch_array($sql2);
	
	$ref = $r2['num_procedimiento'];//uiqtamos ultimo caracter a ref
	
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}


if($tipo == "docu_dir_pfrr") 
{
	$asunto="Se remite ET y documentación a la Dirección C";

				$director="Miguel Ángel Santos Ramírez";
				$cargo="Director de Área 'C'";
				$uaa="ASF";
                $error = 0;
				
		
	
	echo $director."|".$cargo."|".$uaa."|".""."|".$asunto."|".$error;
}



if($tipo == "reiteracion") 
{
	$asunto="Se solicita reiteración de inicio de procedimiento";
	$sql=$conexion->select("SELECT * FROM directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	WHERE fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];
	$error= 0;
	
		$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and (tipoMovimiento = '10' || tipoMovimiento = '11') order by fecha_oficio desc limit 1");
	
	while($r2=mysql_fetch_array ($sql2))
		$ref .= stripslashes(html_entity_decode($r2["oficio"])).",";
	
	$ref = substr($ref,0,strlen($ref)-1);//uiqtamos ultimo caracter a ref
	
		
	
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}


?>





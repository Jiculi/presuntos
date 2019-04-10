<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$nombre= $_REQUEST["term"];
$acciones = $_REQUEST["acciones"];
$accion = str_replace("|","",$acciones);
$accion1 = $_REQUEST["accion1"];
$tipo = $_REQUEST["tipo"];
$seleccion = $_REQUEST["seleccion"];

$cont = 0;

if($tipo == "notificacionEF") 
{
	$asunto="Se notifica el PO.";
	$sql=$conexion->select("SELECT * from po_presuntos where tipo_presunto = 'responsableInforme' and num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
		
	$sql2=$conexion->select("SELECT * from volantes 
	where  tipoMovimiento = '5' and accion='".$accion."'  order by fecha_oficio desc limit 1");
	$r2=mysql_fetch_array ($sql2);

	
echo $r["servidor_contratista"]."|".$r["cargo_servidor"]."|".$r["dependencia"]."|".stripslashes(html_entity_decode($r2["referencia"]))."|".$asunto;



}
if($tipo == "notificacionICC")
{ 
	$asunto="Se notifica el PO.";

	$sql=$conexion->select("SELECT * from po_presuntos where tipo_presunto = 'titularICC' and num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	$sql2=$conexion->select("SELECT * from volantes 
	where  tipoMovimiento = '5' and accion='".$accion."'  order by fecha_oficio desc limit 1");
	$r2=mysql_fetch_array ($sql2);

echo $r["servidor_contratista"]."|".$r["cargo_servidor"]."|".$r["dependencia"]."|".stripslashes(html_entity_decode($r2["referencia"]))."|".$asunto;


}

if($tipo == "asistencia") 
{
	$acciones=str_replace("|","','",$acciones);
	$acciones = substr($acciones,0,strlen($acciones)-3);

	$asunto="Se brinda asistencia juridica, remitiendose PPO y ET.";
	$sql=$conexion->select("SELECT * from directores_uaa 
							INNER JOIN po on po.uaa = directores_uaa.uaa
							where  po.num_accion = '".$accion1."'");
	$r=mysql_fetch_array ($sql);

	$sql2=$conexion->select("SELECT * from volantes_contenido where accion LIKE '".$accion1."' and   tipoMovimiento = '2' order by fecha_oficio desc ");
	
	$error = 0;
	$ref = "";
	
	while($r2=mysql_fetch_array ($sql2))
	{
		$i++;
		$uaACT = $r["uaa"];
		if($i >= 2)
		{
			if( $uaANT == $uaACT)
			{
				$ref .= stripslashes(html_entity_decode($r2["oficio"]))." -- ";
			}
			else $error++;
		}else{				
				$ref .= stripslashes(html_entity_decode($r2["oficio"]))." -- ";
		}
	 $uaANT = $uaACT;
	}
	
	$director=$r["director"];
	$cargo=$r["cargo"];
	$uaa=$r["uaa"];

	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}


if($tipo == "remisionUAA" ) 
{
		$sqlpo=$conexion->select("SELECT numero_de_pliego from po
	where num_accion='".$accion."'");
	$po=mysql_fetch_array ($sqlpo);

	$asunto="Se comunica la notificación a la EF y al ICC del ".$po["numero_de_pliego"]." , fecha de vencimiento del plazo y se devuelve ET.";
	$sql=$conexion->select("SELECT * from directores_uaa 
	INNER JOIN fondos on fondos.UAA=directores_uaa.uaa
	where  fondos.num_accion = '".$accion."'");
	

	$r=mysql_fetch_array ($sql);
	
	$sql2=$conexion->select("SELECT * from oficios 
	
	where  tipo = 'notificacionEF' and num_accion like '%".$accion."%' order by fecha_oficio desc limit 1 ");
	$r2=mysql_fetch_array ($sql2);

	
	

echo $r["director"]."|".$r["cargo"]."|".$r["uaa"]."|".stripslashes(html_entity_decode($r2["folio"]))."|".$asunto;


}

if($tipo == "remitentesUAA") 
{
	$sql=$conexion->select("SELECT * from directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	where  fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	echo $r["director"]."|".$r["cargo"]."|".$r["uaa"];
}


//------------Solicitar UAA

if($tipo == "docu_uaa") 
{
	$acciones=str_replace("|","','",$acciones);
	$acciones = substr($acciones,0,strlen($acciones)-3);

	$asunto="Se remite información a la ".$r['uaa']."";
	$sql=$conexion->select("SELECT * from directores_uaa 
							INNER JOIN fondos on fondos.UAA=directores_uaa.uaa
							where  fondos.num_accion = '".$accion1."'");
	$r=mysql_fetch_array ($sql);

	$sql2=$conexion->select("SELECT * from volantes where accion IN ('$acciones') and   tipoMovimiento = '2' order by fecha_oficio desc");
	
	$error = 0;
	while($r2=mysql_fetch_array ($sql2))
	{
		$i++;
		$uaACT = $r["uaa"];
		if($i >= 2)
		{
			if( $uaANT == $uaACT)
			{
				$director=$r["director"];
				$cargo=$r["cargo"];
				$uaa=$r["uaa"];
				
				$ref .= stripslashes(html_entity_decode($r2["referencia"]))." -- ";
			}
			else $error++;
		}else{
				$director=$r["director"];
				$cargo=$r["cargo"];
				$uaa=$r["uaa"];
                $error = 0;
				
				$ref .= stripslashes(html_entity_decode($r2["referencia"]))." -- ";
		}
	 $uaANT = $uaACT;
	}
	echo $director."|".$cargo."|".$uaa."|".$ref."|".$asunto."|".$error;
}

if($tipo == "remitentesUAA") 
{
	$sql=$conexion->select("SELECT * from directores_uaa INNER JOIN fondos on fondos.UAA=directores_uaa.uaa	where  fondos.num_accion = '".$accion."'");
	$r=mysql_fetch_array ($sql);
	
	echo $r["director"]."|".$r["cargo"]."|".$r["uaa"];
}


if($tipo == "archivo") 
{
	$asunto="Se envian acciones al archivo de concentración";
	$sql2=$conexion->select("SELECT * from directores_uaa 
							where  uaa = 'ASF'");
	$r2=mysql_fetch_array ($sql2);

	
	$r2=mysql_fetch_array ($sql2);

				$director="Paola Angelina Soto Montero";
				$cargo="Subdirectora de Área de la Dir. Gral. De Recursos Materiales y Servicios";
				$uaa="ASF";
                $error = 0;
				
		
	
	echo $director."|".$cargo."|".$uaa."|".""."|".$asunto."|".$error;
}



?>





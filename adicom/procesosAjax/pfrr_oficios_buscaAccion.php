<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$accion= $_REQUEST["term"];
$direccion = $_REQUEST["direccion"];
$nivel = $_REQUEST["nivel"];
if ( $nivel == "S" ) { $nivel = $_REQUEST["direccion"];}

if($direccion == "DG" || $direccion == "A") $sql=$conexion->select("select num_accion,direccion,abogado,num_procedimiento,detalle_edo_tramite,PDR FROM pfrr where num_accion like '%$accion%'");
//else $sql=$conexion->select("select num_accion,direccion,abogado,num_procedimiento,detalle_edo_tramite,PDR,subnivel FROM pfrr where num_accion like '%$accion%'  AND subnivel like '%$nivel%' ");
else $sql=$conexion->select("select num_accion,direccion,abogado,num_procedimiento,detalle_edo_tramite,PDR FROM pfrr where num_accion like '%$accion%'  AND  subnivel LIKE '".$nivel."%'  ");

while ($r=mysql_fetch_array ($sql))
{
	$sql1=$conexion->select("select nombre,direccion from usuarios where nivel = '".$r["direccion"]."' ");
	$dir = mysql_fetch_array ($sql1);
	$director = $dir['nombre'];
	$edoGral = (dameEstado($r["detalle_edo_tramite"]));
	$menFinal = "";

	// buscamos si falta algun presunto por terminar 
	$sql2=$conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$r["num_accion"]."' ORDER BY cont ");
	while($r2 = mysql_fetch_array ($sql2))
	{
		// ver X presuntos
		$sql3=$conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$r2["num_accion"]."' AND idPresunto = ".$r2['cont']." ");
		$numAud = mysql_num_rows($sql3);
		
		if($numAud != 0)
		{
			$tipo1 = false;
			$tipo4 = false;
			$tipo5 = false;
			$msj = "";
			$mensaje = "";
			$error = 0;
			$presunto = "";

			while($r3 = mysql_fetch_array ($sql3))
			{
				$presunto = $r3['presunto'];
				if($r3['tipo'] == 1) $tipo1 = true;
				if($r3['tipo'] == 4) $tipo4 = true;
				if($r3['tipo'] == 5) $tipo5 = true;
				//----------------------------------------
			}
			//vemos si esta en el arrary el proceso
			if($tipo1 == false) {$error = 1; $msj .= "Citatorio, "; }
			if($tipo4 == false) {$error = 1; $msj .= "fecha de Pruebas, "; }
			if($tipo5 == false) {$error = 1; $msj .= "fecha de Alegatos"; }
			
			if($error == 1) 
			{
				$mensaje .= "\n - El presunto  ".$presunto." no tiene ".$msj;
				$menFinal .= $mensaje;
				$msj = "";
			}
		}else{
			$menFinal .= "\n - El presunto ".$r2['nombre']." no tiene Citatorio, fecha de Pruebas, fecha de Alegatos";
		}
	} // fin while y vuelve a evaluar al siguiente presunto
	//------- vemos si hay oficio de asistencia pendiente
	$sqlxx=$conexion->select("SELECT O.folio, O.fecha_oficio 
						FROM oficios O 
						INNER JOIN oficios_contenido OC 
							ON O.folio = OC.folio 
						WHERE 
							O.tipo='dtns_PFRR' AND 
							OC.num_accion = '".$r["num_accion"]."' AND 
							OC.atendido = 0 AND 
							O.status <> 0 "); 
	$ofiAS = mysql_num_rows($sqlxx);

	
	

	//sacamos estado de tramiteen texto --------------
	$edoGral = (dameEstado($r["detalle_edo_tramite"]));
	
	$results[] = array("value"=>$r["num_accion"], "direccion"=>$r["direccion"], "turnado"=>$director, "direccion"=>$r["direccion"], "estado"=>$r["detalle_edo_tramite"], "estadoTxt"=>$edoGral, "procedimiento"=>$r["num_procedimiento"],"pdr"=>$r["PDR"],"mensaje"=>"","ofiAS"=>$ofiAS);
}
echo json_encode($results);
?>





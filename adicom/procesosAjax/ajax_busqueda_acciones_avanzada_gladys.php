<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$limit = valorSeguro($_POST['limit']);
$envio = valorSeguro($_POST['envio']);
//------------------------------------------------------------------------------

$oficio = valorSeguro($$_POST['oficio']);
$volante = valorSeguro($$_POST['volante']);
$dirigido = valorSeguro($$_POST['dirigido']);
$uaa=valorSeguro($$_POST['uaa']);
$asunto=valorSeguro($$_POST['asunto']);

/* ------------------- CHECKBOX ------------------------*/

$oficioCh =  valorSeguro($_POST['oficioCh']);
$volanteCh =  valorSeguro($_POST['volanteCh']);
$DirigidoCh =  valorSeguro($_POST['DirigidoCh']);
$AsuntoCh =  valorSeguro($_POST['AsuntoCh']);
$uaaCh =  valorSeguro($_POST['uaaCh']);

/* ------------------- CHECKBOX ------------------------*/
if($oficio !=""){ $sqloficio="and oficio LIKE '%".$oficio."%' "; }
else{$sqloficio="";}

if($Volante != "") $sqlvolante="and folio LIKE '%".$Volante."%' ";
else $sqlvolante="";


if($dirigido != "") $sqlDirigido="and remitente LIKE '".$dirigido."%' ";
else $sqlDirigido="";

if  ($asunto != "" ) $sqlasunto= " and  asunto  LIKE '%".$asunto."%' ";
else $sqlasunto= "";

if($uaa !="") $sqluaa="and entidad_dependencia LIKE '%".$uaa."%' ";
else $sqluaa="";

//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
if($volante !="") {
	$txtsql="select volantes_contenido.oficio, folio, remitente, asunto, entidad_dependencia from volantes_contenido

inner join po on volantes_contenido.accion = po.num_accion

inner join pfrr_historial on volantes_contenido.accion =
pfrr_historial.num_accion";
}


//---------- DG vemos todo -----------------------------------------

//---------- SECRES ven direccion ----------------------------------

//---------- ABOGADOS segun nivel ----------------------------------

//--------------------------------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,1000 ";
else $limit = $limit;
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);
$sql = $conexion->select($txtsql." ORDER BY num_accion ".$limit ,false);
$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				$tabla .= '<th class="ancho300 blanco">  </th>';
				
				if($oficioCh == "true") $tabla .= '<th class="ancho100 blanco">oficio</th>';
				if($volanteCh == "true") $tabla .= '<th class="ancho50 blanco">folio</th>';
				if($DirigidoCh == "true") $tabla .= '<th class="ancho50 blanco">turnado </th>';
				if($uaaCh == "true") $tabla .= '<th class="ancho100 blanco">UAA</th>';
				if($AsuntoCh == "true") $tabla .= '<th class="ancho100 blanco">Asunto</th>';				
				
							
	
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//------SQL de Volantes//
	
	$query1="select volantes_contenido.oficio, folio, remitente, asunto, entidad_dependencia from volantes_contenido

inner join po on volantes_contenido.accion = po.num_accion

inner join pfrr_historial on volantes_contenido.accion =
pfrr_historial.num_accion ";
	
	$sql3=$conexion->select($query1);
	$f=mysql_fetch_array($sql3);
	
	
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				//$tabla .= '<td class="">'.$limit.'</td>';
				if($efCh == "true") 
				$tabla .= '
				<td class="" align="center"><span title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['oficio'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['volante'].
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['uaa'].
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['turnado'].
'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['asunto'];

				
				if($oficioCh == "true") $tabla .= '<td class="" align="center">'.$r['oficio'].'</td>';
				if($volanteCh == "true") $tabla .= '<td class="">'.$r['volante'].'</td>';
				if($uaaCh == "true") $tabla .= '<td class="" align="center">'.$r['uaa'].'</td>';
				if($DirigidoCh == "true") $tabla .= '<td class="" align="center">'.$r['turnado'].'</td>';
				if($AsuntoCh == "true") $tabla .= '<td class="" align="center">'.$r['asunto'].'</td>';			
				

			

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
//------------------------------------------------------------------------------------------------------------------
$paginas = ceil($total/1000);
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;


//print_r($_POST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
mysql_free_result($sqlT);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

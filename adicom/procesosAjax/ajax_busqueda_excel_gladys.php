<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$limit = valorSeguro($_REQUEST['limit']);
$envio = valorSeguro($_REQUEST['envio']);
//------------------------------------------------------------------------------
$reports = valorSeguro($_REQUEST['reports']);

$oficio = valorSeguro($_REQUEST['oficio']);
$volante = valorSeguro($_REQUEST['volante']);
$dirigido = valorSeguro($_REQUEST['dirigido']);
$uaa=valorSeguro($_REQUEST['uaa']);
$asunto=valorSeguro($_REQUEST['asunto']);

/* ------------------- CHECKBOX ------------------------*/
$oficioCh =  valorSeguro($_REQUEST['oficioCh']);
$volanteCh =  valorSeguro($_REQUEST['volanteCh']);
$DirigidoCh =  valorSeguro($_REQUEST['DirigidoCh']);
$AsuntoCh =  valorSeguro($_REQUEST['AsuntoCh']);
$uaaCh =  valorSeguro($_REQUEST['uaaCh']);

/* ------------------- CHECKBOX ------------------------*/
if($oficio !=""){ $sqloficio="and oficio LIKE '%".$oficio."%' "; }
else{$sqloficio="";}

if($volante != "") $sqlvolante="and volante LIKE '%".$volante."%' ";
else $sqlvolante="";

if ($Dirigido !="") $sqlDirigido="and dirigido LIKE '".$Dirigido."%' ";
else $sqlDirigido="";

if($asunto != "") $sqlasunto="and asunto LIKE '".$asunto."%' ";
else $sqlasunto="";

if($uaa !="") $sqluaa="and uaa LIKE '%".$uaa."%' ";
else $sqluaa="";


//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
if($oficio !="") {
	$txtsql="SELECT * FROM volantes";
	$sqloficio="and oficio like '%".$oficio."%'";
}
else $sqloficio="";

if($volante !="") {
	$txtsql="SELECT * FROM volantes";
	$sqlvolante="and volante like '%".$volante."%'";
}
else $sqlvolante="";

if($Dirigido !="") {
	$txtsql="SELECT * FROM volantes";
	$sqlDirigido="and Dirigido like '%".$Dirigido."%'";
}
else $sqlDirigido="";

if($asunto !="") {
	$txtsql="SELECT * FROM volantes";
	$sqlasunto="and asunto like '%".$asunto."%'";
}
else $sqlasunto="";

if($uaa !="") {
	$txtsql="SELECT * FROM volantes";
	$sqluaa="and asunto like '%".$uaa."%'";
}
else $sqluaa="";


//---------- DG vemos todo -----------------------------------------

//---------- SECRES ven direccion ----------------------------------

//---------- ABOGADOS segun nivel ----------------------------------

//--------------------------------------------------------------------------------------------
/*
if($limit == "") $limit = " LIMIT 0,1000 ";
else $limit = $limit;
*/
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);
$sql = $conexion->select($txtsql." ORDER BY num_accion ",false);
$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				//$tabla .= '<th class="ancho300 blanco">  </th>';
				
				if($oficioCh == "true") $tabla .= '<th class="ancho100 blanco">oficio</th>';
				if($volanteCh == "true") $tabla .= '<th class="ancho50 blanco">folio</th>';
				if($DirigidoCh == "true") $tabla .= '<th class="ancho50 blanco">turnado </th>';
				if($uaaCh == "true") $tabla .= '<th class="ancho100 blanco">UAA</th>';
				if($AsuntoCh == "true") $tabla .= '<th class="ancho100 blanco">asunto</th>';				
				
							
			$tabla .= '<th class="acciones blanco">Seguimiento</th> 
					</tr>
				</thead>';
				
				
				
				
				

/*while($r = mysql_fetch_array($sql))
{
	

	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
	$d = mysql_fetch_array($sql1);
	$director = $d['nombre'];

	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
	$d = mysql_fetch_array($sql1);
	$subdirector = $d['nombre'];
	
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
	$d = mysql_fetch_array($sql1);
	$jefe = $d['nombre'];
	
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' ",false);
	$d = mysql_fetch_array($sql1);
	$coordinador = $d['nombre'];
	
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//------SQL de Volantes//
	
	$query1="SELECT folio, po.num_accion from  volantes_contenido vc
		INNER JOIN po on po.num_accion=vc.accion
		WHERE po.num_accion= '".$r['num_accion']."'
		ORDER BY fecha_actual desc 
		LIMIT 1";
	
	$sql3=$conexion->select($query1);
	$f=mysql_fetch_array($sql3);
	$volante=$f['folio'];*/
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
      
	  
	  while($r = mysql_fetch_array($sql))
	  {  
	        $sql1 = $conexion->select("select volantes_contenido.oficio, folio, remitente, asunto, entidad_dependencia from volantes_contenido

inner join po on volantes_contenido.accion = po.num_accion

inner join pfrr_historial on volantes_contenido.accion =
pfrr_historial.num_accion");

	$d = mysql_fetch_array($sql1);
	$oficioCh = $d['oficio'];
	$volanteCh = $d['folio'];	
	$DirigidoCh = $d['turnado'];
	$uaaCh = $d['uaa'];
	$AsuntoCh = $d['asunto'];
		  
	$tabla .= '
            <tr '.$estilo.' >';
				
				//$tabla .= '<td class="">'.$limit.'</td>';
				
				$tabla .= '
				<td </td>';
				
				if($oficioCh == "true") $tabla .= '<td class="" align="center">'.$r['oficio'].'</td>';
				if($volanteCh == "true") $tabla .= '<td class="" align="center">'.$r['folio'].'</td>';
				if($DirigidoCh == "true") $tabla .= '<td class="">'.$r['turnado'].'</td>';
				if($uaaCh == "true") $tabla .= '<td class="" align="center">'.$r['uaa'].'</td>';
				if($AsuntoCh == "true") $tabla .= '<td class="" align="center">'.$r['asunto'].'</td>';							
		
			$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';
	  }
//if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
//------------------------------------------------------------------------------------------------------------------
//$paginas = ceil($total/1000);
//echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Busqueda Volantes.xls");
//$excel=$_REQUEST['export'];
print utf8_decode($tabla);
exit;



//print_r($_REQUEST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
//mysql_free_result($sqlT);
//$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$texto = valorSeguro(trim($_REQUEST['texto']));
$usuario = valorSeguro(trim($_REQUEST['usuario']));
$direccion = valorSeguro(trim($_REQUEST['direccion']));
$nivel = valorSeguro(trim($_REQUEST['nivel']));

if($direccion == "DG" || $nivel == "S")
{
	$sql = $conexion->select("SELECT *,oficios.folio Folio,oficios.id idFol,oficios.tipo as tOficio, status as state FROM oficios 
								WHERE
								(
									num_accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									consecutivo LIKE '%".$texto."%' OR
									destinatario LIKE '%".$texto."%' OR 
									oficio_referencia LIKE '%".$texto."%' OR 
									Folio LIKE '%".$texto."%' OR
									id LIKE '%".$texto."%' 
								)AND oficios.tipo IN (33,34,35,36,37,38,39,40,41,42,43) 
									ORDER BY id desc limit 200
							",false);
}
else
{
	$sql = $conexion->select("SELECT *,oficios.folio Folio,oficios.id idFol,oficios.tipo as tOficio,oficios.status as state FROM oficios 
							  INNER JOIN usuarios 
							  ON oficios.abogado_solicitante = usuarios.usuario
							  WHERE
							  	nivel LIKE '".$nivel."%' AND
								(
									num_accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									consecutivo LIKE '%".$texto."%' OR
									destinatario LIKE '%".$texto."%' OR 
									dependencia LIKE '%".$texto."%' OR 
									oficio_referencia LIKE '%".$texto."%'
								) AND oficios.tipo IN (33,34,35,36,37,38,39,40,41,42,43)
								
								ORDER BY oficios.id desc  limit 200
							",false);
}
						
$total = mysql_num_rows($sql);

$tabla = '

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
		<tr>
			<th class="ancho150"><a href="#">Folio</a>	</th>
			<th class="ancho100"><a href="#">Fecha</a>	</th>
			<th class="ancho200"><a href="#">Acciones</a>	</th>
			<th class="ancho200"><a href="#">Destinatario</a></th>
			<th class="ancho200"><a href="#">Dependencia</a></th>
			<th class="ancho150"><a href="#"> Referencia </a></th>
			<th class="ancho100"><a href="#"> Tipo </a></th>
			<th class="ancho50"><a href="#"> Status </a></th>
			<!--
			<th class="ofiOfi"><a href="#"> Modificar </a></th>
			-->
		</tr>
	</table>
	<div style="height:250px;width:100%;overflow:auto">
	<table border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
	<tbody>
	';

	while($r = mysql_fetch_array($sql))
	{
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		if($r['state'] == 0) $txtStatus = "<img src='images/pendientes.png'>";
		if($r['state'] == 1) $txtStatus = "";
		if($r['state'] == 2) $txtStatus = "";
		
		if($r['Folio'] == "") $folio = $r['idFol'];
		else $folio = $r['Folio'];
		
		$acciones = str_ireplace("|","<br>",$r['num_accion']);
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho150">'.$txtStatus.' '.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$folio).' </td>
					<td class="ancho100">'.fechaNormal($r['fecha_oficio']).'</td>
					<td class="ancho200">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$acciones).'</td>
					<td class="ancho200">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['destinatario']).'</td>
					<td class="ancho200">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['dependencia']).'</td>
					<td class="ancho150">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['oficio_referencia']).'  </td>
					<td class="ancho100">'. dameEstado($r['tOficio']).'  </td>
					<td class="ancho50">';
					
		$tabla .= '	<a href="#" title="Ver Informacion" onclick=\'new mostrarCuadro(500,700,"Información del Oficio",70,"cont/po_oficio_notifica.php","id='.$r['id'].'&abogado='.$r['abogado_solicitante'].'&folio='.$folio.'")\' >  <img src="images/Document-icon.png"> </a>';
		
			
		if($r['tOficio'] == "notificacionEF" || $r['tOficio'] == "notificacionICC" || $r['tOficio'] == "remisionUAA")
			$tabla .= '	<a href="#" title="Ver Oficio" onclick=\' verOficio("'.$folio.'","'.$r['tOficio'].'") \'> <img src="images/pdf.png"> </a> <!-- '.$txtStatus.' --> </td>';
		$tabla .= '	<!--
					<td class="ofiAccion">
					
						<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\' new mostrarCuadro(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id='.$r['id'].'&muestra=1") \'></a>
						<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\' new mostrarCuadro(550,800,"Modificar Volante '.$r['folio'].'",60,"cont/vol_edita_volantes.php","id='.$r['id'].'&muestra=1") \'></a> 
					</td>
					-->						
				</tr>';
	}
		$tabla .= '
				</tbody>
				</table>
				</div>
				';
	
	if($total == 0) $tabla = "<center><br><br><br><br><h3> No se encontraron oficios </h3><br><br><br></center>
	";
	
	echo $tabla;
	/*
	echo nl2br("SELECT *,oficios.folio Folio,oficios.id idFol FROM oficios 
							  INNER JOIN usuarios 
							  ON oficios.abogado_solicitante = usuarios.usuario
							  WHERE
							  	nivel LIKE '".$nivel."%' AND
								(
									num_accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									consecutivo LIKE '%".$texto."%' OR
									destinatario LIKE '%".$texto."%' OR 
									dependencia LIKE '%".$texto."%' OR 
									oficio_referencia LIKE '%".$texto."%'
								)
								ORDER BY oficios.id desc
							");
*/
mysql_free_result($sql);
?>


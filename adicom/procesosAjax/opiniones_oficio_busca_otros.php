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
	$sql = $conexion->select("SELECT * FROM oficios 
								WHERE
								
										tipo = 'opi_legal',
									
									ORDER BY id desc
							",false);
}
else
{
	$sql = $conexion->select("SELECT *,oficios.folio Folio,oficios.id idFol,oficios.tipo as tOficio FROM oficios 
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
								) AND (
									oficios.tipo = 'asistencia' OR
									oficios.tipo = 'notificacionEF' OR
									oficios.tipo = 'notificacionICC' OR
									oficios.tipo = 'remisionUAA' OR
									oficios.tipo = 'otros' OR
									oficios.tipo = 'opi_legal'
								)
								ORDER BY oficios.id desc
							",false);
}
						
$total = mysql_num_rows($sql);

$tabla = '

	<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
		<tr>
			<th class="ancho200"><a href="#">Folio</a>	</th>
			<th class="ofiFecha"><a href="#">Fecha</a>	</th>
			<th class="ofiLeyenda"><a href="#">Acciones</a>	</th>
			<th class="ofiLeyenda"><a href="#">Destinatario</a></th>
			<th class="ofiLeyenda"><a href="#">Dependencia</a></th>
			<th class="ofiLeyenda"><a href="#"> Referencia </a></th>
			<th class="ofiOfi"><a href="#"> Status </a></th>
			<!--
			<th class="ofiOfi"><a href="#"> Modificar </a></th>
			-->
		</tr>
	</table>
	<div style="height:250px;width:100%;overflow:auto">
	<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
	<tbody>
	';

	while($r = mysql_fetch_array($sql))
	{
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		if($r['status'] == 0) $txtStatus = "<b style='color:red'>CANCELADO</b>";
		if($r['status'] == 1) $txtStatus = "<b style='color:#C4C400'>PENDIENTE</b>";
		if($r['status'] == 2) $txtStatus = "<b style='color:GREEN'>NOTIFICADO</b>";
		
		if($r['Folio'] == "") $folio = $r['idFol'];
		else $folio = $r['Folio'];
		
		$acciones = str_ireplace("|","<br>",$r['num_accion']);
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho200">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$folio).'</td>
					<td class="ofiFecha">'.fechaNormal($r['fecha_oficio']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$acciones).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['destinatario']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['dependencia']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['oficio_referencia']).'  </td>
					<td class="ofiOfi">';
		$tabla .= '	<a href="#" title="Ver Informacion" onclick=\'new mostrarCuadro(500,700,"Información del Oficio",70,"cont/po_oficio_notifica.php","id='.$r['id'].'&abogado='.$r['abogado_solicitante'].'&folio='.$folio.'")\' >  <img src="images/Document-icon.png"> </a>';
		
			
		if($r['tOficio'] == "notificacionEF" || $r['tOficio'] == "notificacionICC" || $r['tOficio']== "opi_legal")
			$tabla .= '	<a href="#" title="Modificar" onclick=\' verOficio("'.$folio.'") \'> <img src="images/pdf.png"> </a> <!-- '.$txtStatus.' --> </td>';
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
	
	if($total == 0) $tabla = "<center><br><br><br><br><h3> No se encontraron erere </h3><br><br><br></center>
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


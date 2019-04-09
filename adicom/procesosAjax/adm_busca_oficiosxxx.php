<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$texto = valorSeguro(trim($_POST['texto']));
//$cargo= valorSeguro(trim($_POST['cargo']));

$sql = $conexion->select("SELECT * FROM volantes 
							WHERE 
								accion LIKE '%".$texto."%' OR 
								folio LIKE '%".$texto."%' OR 
								remitente LIKE '%".$texto."%' OR 
								entidad_dependencia LIKE '%".$texto."%' OR 
								referencia LIKE '%".$texto."%'
						",false);
						
$total = mysql_num_rows($sql);

$tabla = '
	<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
		<tr>
			<th class="ofiTipo"><a href="#">Folio</a>	</th>
			<th class="ofiLeyenda"><a href="#">Accion</a>	</th>
			<th class="ofiLeyenda"><a href="#">Remitente</a></th>
			<th class="ofiLeyenda"><a href="#">Entidad</a></th>
			<th class="ofiFecha"><a href="#"> oficio </a></th>
			<th class="ofiAccion"><a href="#"> Status </a></th>
			<th class="ofiAccion"><a href="#"> Modificar </a></th>
		</tr>
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
		else $txtStatus = "<b style='color:blue'>ACTIVO</b>";
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ofiTipo">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['folio']).'</td>
					<td class="ofiTipo">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['accion']).'</td>
					<td class="ofiOfi">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['remitente']).'</td>
					<td class="ofiFecha">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['entidad_dependencia']).'</td>
					<td class="ofiFecha">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['referencia']).'</td>
					<td class="ofiFecha">'.$txtStatus.'</td>
					<td class="ofiAccion">
						<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\' new mostrarCuadro(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id='.$r['id'].'&muestra=1") \'></a>
						<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\' new mostrarCuadro(470,800,"Modificar Volante '.$r['folio'].'",60,"cont/vol_edita_volantes.php","id='.$r['id'].'&muestra=1") \'></a> 
					</td>
				</tr>';
	}
		$tabla .= '
				</tbody>
				</table>
				';
	
	if($total == 0) $tabla = "<center><br><br><br><br><h3> No se encontraron volantes </h3><br><br><br></center>";
	
	echo $tabla;
?>


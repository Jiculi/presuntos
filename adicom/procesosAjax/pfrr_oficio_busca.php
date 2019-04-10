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
if ( $nivel == "S" ) { $nivel = $direccion; }

if($direccion == "DG" || $nivel == "S")
{
	$sql = $conexion->select("SELECT *,o.folio Folio,o.id,o.tipo idFol,o.status as state  FROM oficios o
								WHERE 
								(
									num_accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									consecutivo LIKE '%".$texto."%' OR
									destinatario LIKE '%".$texto."%' OR 
									oficio_referencia LIKE '%".$texto."%' OR 
									Folio LIKE '%".$texto."%' OR
									id LIKE '%".$texto."%'
								) 
								AND tipo IN (SELECT value FROM oficios_options WHERE estado = 'pfrr') 
								ORDER BY id desc limit 200
							",false);
}
else
{
	$sql = $conexion->select("SELECT *,o.folio Folio,o.id idFol,o.status as state  FROM oficios o
							  INNER JOIN usuarios u
							  ON o.abogado_solicitante = u.usuario
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
								AND o.tipo IN (SELECT value FROM oficios_options WHERE estado = 'pfrr') 
								ORDER BY o.id desc limit 200
							",false);
}
						//
$total = mysql_num_rows($sql);

$tabla = '
	<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
		<tr>
			<th class="ancho200"><a href="#">Folio</a>	</th>
			<th class="ofiFecha"><a href="#">Fecha</a>	</th>
			<th class="ofiLeyenda"><a href="#">Acciones</a>	</th>
			<th class="ofiLeyenda"><a href="#">Destinatario</a></th>
			<th class="ofiLeyenda"><a href="#">Dependencia</a></th>
			<th class="ofiLeyenda"><a href="#"> Oficio referencia </a></th>
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
		if($r['state'] == 0) $txtStatus = "<img src='images/pendientes.png'>";
		if($r['state'] == 1) $txtStatus = " ";
		if($r['state'] == 2) $txtStatus = " ";
		//---------- vemos si esta en archivos ---------------------//
		//---------- vemos si esta en archivos ---------------------//
		if($r['Folio'] == "") $folio = $r['idFol'];
		else $folio = $r['Folio'];

		$folioOK = $folio;
		
		$folio = cadenaNormalOficio($folioOK);
		$folio = str_replace("\"","",$folio);
		$folio = str_replace("\'","",$folio);
		$folio = str_replace(" ","",$folio);
		$folio = str_replace("/","!",$folio);
		
		$sqlO = $conexion->select("SELECT * FROM archivos WHERE oficioDoc = '".$folio."' ",false);
		$ofi = mysql_fetch_array($sqlO);
		
		if($ofi != 0) $linkSubirArchivo = "";
		else $linkSubirArchivo = '<a href="#" title="Subir Archivo" onclick=\'new mostrarCuadro(300,400,"Subir archivo",70,"cont/pfrr_oficio_subir.php","accion='.$r['num_accion'].'&folio='.$folio.'")\' >  <img src="images/Upload.png" /> </a>';

		/*
		while($o = mysql_fetch_array($sqlO))
		{
			$docsSubidos[] = $oficioDoc; 
		}
		*/
		//---------- vemos si esta en archivos ---------------------//
		//---------- vemos si esta en archivos ---------------------//
		
		
		$acciones = str_ireplace("|","<br>",$r['num_accion']);
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho200">'.$txtStatus.' '.verificaOficioLink($folioOK).'</td> 
					<td class="ofiFecha">'.fechaNormal($r['fecha_oficio']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$acciones).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['destinatario']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['dependencia']).'</td>
					<td class="ofiLeyenda">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['oficio_referencia']).'  </td>
					<td class="ofiOfi">
						'.$linkSubirArchivo.'
						<a href="#" title="Ver Informacion" onclick=\'new mostrarCuadro(500,700,"Información del Oficio",70,"cont/pfrr_oficio_notifica.php","id='.$r['id'].'&abogado='.$r['abogado_solicitante'].'&folio='.$folioOK.'")\' >  <img src="images/Document-icon.png"> </a>
					</td>
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


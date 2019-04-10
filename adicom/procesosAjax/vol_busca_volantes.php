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
$direccion= valorSeguro(trim($_REQUEST['direccion']));
$usuario = valorSeguro(trim($_REQUEST['usuario']));
$excel = valorSeguro(trim($_REQUEST['excel']));

if($direccion == "DG" || $usuario == "esolares" )
{
	$sql = $conexion->select("SELECT * FROM volantes 
								WHERE 
									accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									remitente LIKE '%".$texto."%' OR 
									entidad_dependencia LIKE '%".$texto."%' OR 
									oficio LIKE '%".$texto."%'
									ORDER BY id desc
									limit 500
							",false);
}
else
{
	$sql = $conexion->select("SELECT * FROM volantes 
								WHERE 
									direccion = '".$direccion."' AND
									(
									accion LIKE '%".$texto."%' OR 
									folio LIKE '%".$texto."%' OR 
									remitente LIKE '%".$texto."%' OR 
									entidad_dependencia LIKE '%".$texto."%' OR 
									oficio LIKE '%".$texto."%'
									)
									ORDER BY id desc
									limit 500
									
							",false);
}
						
$total = mysql_num_rows($sql);

$tabla = '
	<div width="">
		<div>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
				<tr>
					<th class="trbusca ancho100">'.$direccon.'Folio	</th>
					<th class="trbusca ofiLeyenda">Fecha	</th>
					<th class="trbusca ofiLeyenda">Acciones	</th>
					<th class="trbusca ofiLeyenda">Turnado</th>
					';
					
					if($excel=="ok")
					{ 
						$tabla .= '<th class="trbusca ofiAccion"> Asunto</th>';
						$tabla .= '<th class="trbusca ofiAccion"> Fecha de Recepcion del volante</th>';
					}
					
					$tabla .= '<th class="trbusca ofiAccion"> Status</th>
					<!-- <th class="ofiAccion"> Estado </th> -->
					<th class="trbusca ofiAccion"> Seguimiento </th>
				</tr>
			</table>
		</div>
		
		<div style="height:250px; overflow-y:auto;">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
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
					
					if($r['semaforo'] == 0) $txtSem = "<b style='color:red'>PENDIENTE</b>";
					if($r['semaforo'] == 1) $txtSem = "<b style='color:#DFE616'>TURNADO</b>";
					if($r['semaforo'] == 2) $txtSem = "<b style='color:green'>ATENDIDO</b>";
					//-------  SIE ESTA CANCELADO ----------------
					if($r['status'] == 0) $txtSem = "<b style='color:red'>CANCELADO</b>";
					
					if($r['accion'] == "") $accion = "00-0-00000-00-0000-00-000";
					else $accion = $r['accion'];
					
					$accion = str_replace("|","<br>",$accion);
					
					if($r['folio'] == "") $folio = $r['id'];
					else $folio = $r['folio'];
					
					$ofiRef = stripslashes($r['referencia']);
					
					//stripslashes()
					
					$tabla .= '
							<tr '.$estilo.' >
								<td class="ancho100" align="center">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$folio).'&nbsp;</td>
								<td class="ancho100" align="center">'.fechaNormal($r['fecha_actual']).'&nbsp;</td>
								<td class="ancho200" align="center">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$accion).'&nbsp;</td>
								
								<td class="ancho200" style="width:100px">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['turnado']).'&nbsp;</td>';
					if($excel=="ok"){ $tabla .= '<td class="ofiLeyenda">'.$r['asunto'].'&nbsp;</td>';
					$tabla .= '<td class="ancho100">'.fechaNormal($r['fecha_actual']).'&nbsp;</td>';			}
					$tabla .= '	<!-- <td class="ancho100">'.$txtStatus.'</td> -->
								<td class="ancho100" align="center">'.$txtSem.'</td>
								<td class="ancho100">
									<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\' new mostrarCuadro(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","folio='.$r['folio'].'&direccion='.$_SESSION['direccion'].'") \'></a>';
									
					if($r['semaforo'] == 0)
						$tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\' new mostrarCuadro(470,800,"Modificar Volante '.$r['folio'].'",60,"cont/vol_edita_volantes.php","id='.$r['id'].'&direccion='.$_SESSION['direccion'].'") \'></a>';
					
					if($r['semaforo'] != 0)
							$tabla .= '<a href="#" title="Asignar Acción" class="icon-6 info-tooltip" onclick=\' new mostrarCuadro(200,730,"Asignar Acción '.$r['accion'].'",100,"cont/vol_asigna_volantes.php","id='.$r['id'].'&direccion='.$_SESSION['direccion'].'") \'></a> ';
							$tabla .= '</td>
							</tr>';
				}
				//<a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,800,"Presuntos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].' ",50,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>
			$tabla .= '
			</table>
		</div>
	</div>';
	
	if($total == 0) $tabla = "<center><br><br><br><br><h3> No se encontraron volantes </h3><br><br><br></center>";
	
	echo $tabla;
	
 mysql_close();
?>


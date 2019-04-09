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
$ef = valorSeguro($_POST['ef']);

//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= ' select entidad, pfrr.num_accion, po.irregularidad_general, pfrr.cp, estado_sicsa, detalle_estado, nombre, cargo, inicio_frr, monto_de_po_en_pesos 

from pfrr left join po on po.num_accion=pfrr.num_accion
inner join estados_tramite on estados_tramite.id_estado= pfrr.detalle_edo_tramite
inner join pfrr_presuntos_audiencias on pfrr_presuntos_audiencias.num_accion=pfrr.num_accion
inner join estados_sicsa on estados_sicsa.id_sicsa=estados_tramite.id_sicsa
or detalle_de_estado_de_tramite=7
where detalle_edo_tramite <> 14 
and pfrr.entidad like "%Guerrero%"
and (pfrr_presuntos_audiencias.status =1
and pfrr_presuntos_audiencias.tipo="presuntoResponable"
or  pfrr_presuntos_audiencias.tipo="")';
//---------- SECRES ven direccion ----------------------------------
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
				//$tabla .= '<th class="ancho300 blanco">  </th>';
				if($efCh == "true") $tabla .= '<th class="ancho300 blanco"> '.$direccion.' Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho200 blanco">Accion	</th>';
				if($noPliegoCh == "true") $tabla .= '<th class="ancho100 blanco">No. Pliego</th>';
				if($cpCh == "true") $tabla .= '<th class="ancho50 blanco">Cuenta Pública</th>';
				if($audch == "true") $tabla .= '<th class="ancho50 blanco">Auditoria </th>';
				if($uaaCh == "true") $tabla .= '<th class="ancho100 blanco">UAA</th>';
				if($fondoCh == "true") $tabla .= '<th class="ancho100 blanco">Fondo</th>';				
				if($direccionCh == "true") $tabla .= '<th class="ancho50 blanco">Direccion</th>';
				if($subdirectorCh == "true") $tabla .= '<th class="ancho200 blanco">Subdirector</th>';
				if($jefe_deptoch == "true") $tabla .= '<th class="ancho200 blanco">Jefe de Departamento</th>';
				if($abogadoCh == "true") $tabla .= '<th class="ancho200 blanco">Abogado</th>';
				if($esCh == "true") $tabla .= '<th class="ancho200 blanco">Estado SICSA</th>';
				if($etCh == "true") $tabla .= '<th class="ancho300 blanco">Control Interno</th>';
				$tabla .= '<th class="ancho100 blanco">Fecha de Ultimo Movimiento	</th>';			
				if($prescripcionCh == "true") $tabla .= '<th class="ancho100 blanco">Prescripción</th>';
				if($montoCh == "true") $tabla .= '<th class="ancho100 blanco">Monto</th>';
				$tabla .= '<th class="ancho100 blanco">Volante</th>';
							
			$tabla .= '<th class="acciones blanco">Seguimiento</th> 
					</tr>
				</thead>

';

while($r = mysql_fetch_array($sql))
{
	$nivPart = explode(".",$r['subnivel']);
	 $nivDir = $nivPart[0];
	 $nivSbd = $nivPart[0].".".$nivPart[1];
	 $nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
	 $nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];

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
	$volante=$f['folio'];
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				//$tabla .= '<td class="">'.$limit.'</td>';
				if($efCh == "true") $tabla .= '<td class="">'.$r['entidad_fiscalizada'].'</td>';
				$tabla .= '
				<td class="" align="center"><span title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >'.trim(str_replace($accion,"<span class='b'>".$accion."</span>",$r['num_accion'])).'</span></td>';
				if($noPliegoCh == "true") $tabla .= '<td class="" align="center">'.$r['numero_de_pliego'].'</td>';
				if($cpCh == "true") $tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				if($audch == "true") $tabla .= '<td class="">'.$r['num_auditoria'].'</td>';
				if($uaaCh == "true") $tabla .= '<td class="" align="center">'.$r['uaa'].'</td>';
				if($fondoCh == "true") $tabla .= '<td class="" align="center">'.$r['fondo'].'</td>';
				if($direccionCh == "true") $tabla .= '<td class="" align="center">'.$nivPart[0].'</td>';
				if($subdirectorCh == "true") $tabla .= '<td class="">'.$subdirector.'</td>';
				if($jefe_deptoch == "true") $tabla .= '<td class="">'.$jefe.'</td>';
				if($abogadoCh == "true") $tabla .= '<td class="">'.$r['abogado'].'</td>';
				if($esCh == "true") $tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_de_estado_de_tramite']).'</td>';
				if($etCh == "true") $tabla .= '<td class="">'.dameEstado($r['detalle_de_estado_de_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_estado_tramite']).'</td>';
				if($fechaIrrCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				
				if($prescripcionCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				
				
				if($montoCh == "true") $tabla .= '<td class="" align="right">'.@number_format($r['monto_de_po_en_pesos'],2).'</td>';
				$tabla .= '<td class="" align="center">'.$volante.'</td>';

				if($fechaci=="true") $tabla .='<th class="align="right">>'.$r['fecha_estado_tramite'].'</td>';


			$tabla .= '	<td class="acciones">';
			
			if($reports != 1)
			{
				$tabla .= '<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",20,"cont/po_informacion.php","numAccion='.$r['num_accion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadrox1 = new mostrarCuadro(500,1100,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos" class="icon-6 info-tooltip" onclick=\'var cuadrox2 = new mostrarCuadro(550,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",30,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadrox3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).' ",50,"cont/po_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
			}
			$tabla .= '</td> </tr>';
}
$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

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

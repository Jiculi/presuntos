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
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
foreach($_POST as $nombre_campo => $valor)
{
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
}
//echo "\n\n Acciones: ".$acciones."\n\n ";

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------





/* ------------------- CHECKBOX ------------------------*/


if($limit == "") $limit = " limit 0,50 ";
else $limit = valorSeguro($_POST['limit']);
$limit = "";


if  ($ef != "" ) $sqlef= " AND  entidad  LIKE '%".$ef."%' ";
else $sqlef= "";

if  ($cp != 0 ) $sqlcp= " AND cp = ".$cp." ";
else $sqlcp= "";




//--------------------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
$txtsql="SELECT `entidad_fiscalizada`,po.num_accion,`irregularidad_general`,`cp`, detalle_estado, servidor_contratista, cargo_servidor, `monto_de_po_en_pesos` from po inner join estados_tramite on po.detalle_de_estado_de_tramite=estados_tramite.id_estado inner join po_presuntos on po.num_accion=po_presuntos.num_accion where id_sicsa=3 and entidad_fiscalizada= $sqlef and cp <> 2013";
			


//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
//---------- DG vemos todo -----------------------------------------
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql." ORDER BY pfrr.num_accion ",false);
//$sql = $conexion->select($txtsql." ".$limit ,false);
$total = mysql_num_rows($sqlT);
//--------------------------------------------------------------------------------------------
while($r = mysql_fetch_array($sqlT))
{

	
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO pfrr SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				if($efCh == "on") $tabla .= '<td class="">'.$r['entidad'].'</td>';
				$tabla .= '
				<td class="" align="center">
				<span" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,"cont/pfrr_bitacora.php","numAccion='.trim($r['num_accion']).'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($accion,"<span class='b'>".$accion."</span>",$r['pona']).'
				</span>
				</td>';
				$tabla .= '<td class="align="right">'.$r['superveniente'].'</td>';
				$tabla .= '<td class="" align="right">'.$r['num_procedimiento'].'</td>';
				$tabla .= '<td class="" align="right">'.$r['PDR'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['po'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				$tabla .= '<td class="">'.$r['auditoria'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['UAA'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['Fondo'].'</td>';
				$tabla .= '<td class="" align="center">'.$nivPart[0].'</td>';
				$tabla .= '<td class="">'.$subdirector.'</td>';
				$tabla .= '<td class="" align="center">'.$jefe.'</td>';
				$tabla .= '<td class="">'.$r['abogado'].'</td>';
				$tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_edo_tramite']).'</td>';
				$tabla .= '<td class="">'.dameEstado($r['detalle_edo_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_edo_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['fecha_acuerdo_inicio']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['fecha_analisis_documentacion']).'
</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['cierre_instruccion']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['limite_emision_resolucion']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['resolucion']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['limite_notificacion_resolucion']).'</td>';
				$tabla .= '<td class="align="right">'.fechaNormal($r['fecha_notificacion_resolucion']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado_UAA'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($montos['montoPre'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($montos['aclarado'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($montos['reintegrado'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($montos['intereses'],2).'</td>';
				$tabla .= '<td class="" align="right">'.@number_format($c=$montos['reintegrado']+$montos['intereses']).'</td>';
				$tabla .='<td class="align="right">'.$r['fecha_estado_tramite'].'</td>';
				$tabla .='<td class="align="right">'.$r['inicio_frr'].'</td>';
				$tabla .='<td class="align="right">'.$r['monto_pdr'].'</td>';
				$tabla .= '<td class="" align="right">'.$r['ampliados'].'</td>';


			$tabla .= '	<td class="acciones">';
			
			if($reports != 1)
			{
				$tabla .= '<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",20,"cont/pfrr_informacion.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadrox1 = new mostrarCuadro(500,1200,"'.$r['pona'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,"cont/pfrr_proceso.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos" class="icon-6 info-tooltip" onclick=\'var cuadrox2 = new mostrarCuadro(550,1200,"'.$r['pona'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",30,"cont/pfrr_presuntos.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadrox3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",50,"cont/pfrr_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
			}
			$tabla .= '</td> </tr>';
}
	$tabla .= '
			</tbody>
            </table>
			</div>
            <!--  end product-table................................... --> 
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados  </h3></center>";

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
$paginas = ceil($total/1000);
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||".$paginas;


print_r($_POST);
echo nl2br($txtsql);
//echo "<br><br>".$sql;
mysql_free_result($sql);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

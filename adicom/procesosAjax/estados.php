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
//echo "\n\n Acciones: ".$acciones."\n\n ";

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------




$ef = valorSeguro($_POST['ef']);




//--------------------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
$txtsql="select entidad, pfrr.num_accion, uaa, fondo, detalle_estado, inicio_frr
from pfrr inner join po on po.num_accion=pfrr.num_accion
inner join estados_tramite on pfrr.detalle_edo_tramite=estados_tramite.id_estado
where id_sicsa = 7 and entidad like '%ef%'";
			


//--------------------------------------------------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				 $tabla .= '<th class="ancho300 blanco">Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho200 blanco">Accion	</th>';
				 $tabla .= '<th class="ancho200 blanco">Superveniente</th>';
				 $tabla .= '<th class="ancho200 blanco">Número de procedimiento</th>';
				 $tabla .= '<th class="ancho100 blanco">PDR</th>';
				 $tabla .= '<th class="ancho100 blanco">No. Pliego</th>';
				 $tabla .= '<th class="ancho50 blanco">Cuenta Pública</th>';
	
			$tabla .= '<th class="acciones blanco">Seguimiento</th> 
					</tr>
				</thead>

';

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
				if($superCh == "on") $tabla .= '<td class="align="right">'.$r['superveniente'].'</td>';
				if($pfrrch == "on") $tabla .= '<td class="" align="right">'.$r['num_procedimiento'].'</td>';
				if($pdrch == "on") $tabla .= '<td class="" align="right">'.$r['PDR'].'</td>';
				if($noPliegoCh == "on") $tabla .= '<td class="" align="center">'.$r['po'].'</td>';
				if($cpCh == "on") $tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				if($audch == "on") $tabla .= '<td class="">'.$r['auditoria'].'</td>';
				if($uaaCh == "on") $tabla .= '<td class="" align="center">'.$r['UAA'].'</td>';
				if($fondoCh == "on") $tabla .= '<td class="" align="center">'.$r['Fondo'].'</td>';
				if($direccionCh == "on") $tabla .= '<td class="" align="center">'.$nivPart[0].'</td>';
				if($subdirectorCh == "on") $tabla .= '<td class="">'.$subdirector.'</td>';
				if($jefe_deptoch == "on") $tabla .= '<td class="" align="center">'.$jefe.'</td>';
				if($abogadoCh == "on") $tabla .= '<td class="">'.$r['abogado'].'</td>';
				if($esCh == "on") $tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_edo_tramite']).'</td>';
				if($etCh == "on") $tabla .= '<td class="">'.dameEstado($r['detalle_edo_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_edo_tramite']).'</td>';
				if($prescripcionCh == "on") $tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				if($acu_iniCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_acuerdo_inicio']).'</td>';
				if($ul_actCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_analisis_documentacion']).'
</td>';
				if($cie_insCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['cierre_instruccion']).'</td>';
				if($lim_emi_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['limite_emision_resolucion']).'</td>';
				if($emi_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['resolucion']).'</td>';
				if($lim_not_resCh== "on") $tabla .= '<td class="align="right">'.fechaNormal($r['limite_notificacion_resolucion']).'</td>';
				if($not_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_notificacion_resolucion']).'</td>';
				if($fechaIrrCh == "on") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado_UAA'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['montoPre'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['aclarado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['reintegrado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['intereses'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($c=$montos['reintegrado']+$montos['intereses']).'</td>';
				if($fechaci=="on") $tabla .='<td class="align="right">'.$r['fecha_estado_tramite'].'</td>';
				if($inicioCh=="on") $tabla .='<td class="align="right">'.$r['inicio_frr'].'</td>';
				if($ampCh == "on") $tabla .= '<td class="" align="right">'.$r['ampliados'].'</td>';


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

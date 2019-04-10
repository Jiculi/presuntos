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
$valor = valorSeguro($_POST['valor']);
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$limit = valorSeguro($_POST['limit']);
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
//--------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,500 ";
else $limit = $limit;
//--------------------------------------------------------------------

$sqltxt = "SELECT pfrr.num_procedimiento, pfrr.num_accion, pfrr.entidad, pfrr.cp, pfrr.subdirector, pfrr.abogado, pfrr.direccion,
                      pfrr.detalle_edo_tramite,pfrr.subnivel, Count(j_autores.Actor) AS actores, Sum(j_autores.monto) AS monto 
                      FROM pfrr INNER JOIN j_procedimiento ON pfrr.num_procedimiento = j_procedimiento.num_procedimiento 
                      LEFT JOIN j_autores ON j_procedimiento.num_procedimiento = j_autores.num_procedimiento GROUP BY j_procedimiento.num_procedimiento";
	
	/*if($direccion == 'DG' || $direccion == 'A') 	$sqltxt .= " WHERE num_accion LIKE '%".$valor."%' ";
	elseif($nivel == 'S') 	$sqltxt .= " WHERE subnivel LIKE '".$direccion."%' AND num_accion LIKE '%".$valor."%'  "; 
	else 					$sqltxt .= " WHERE subnivel LIKE '".$nivel."%' AND num_accion LIKE '%".$valor."%'  "; */
	
	$sqlSinLim = $conexion->select($sqltxt." ORDER BY num_accion",false);
	$sql = $conexion->select($sqltxt." ORDER BY num_accion ".$limit,false);
	
	$total = mysql_num_rows($sqlSinLim);
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$tabla = '
<form id="mainform" action="" class="formTabla">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
';

while($r = mysql_fetch_array($sql))
{
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
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
	
	if ($subdirector != "")  $responsable = $subdirector;  else $responsable = $director;
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td style="width:100px" >
						<center>
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",50,"cont/pfrr_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>", $r['num_procedimiento']).'
						</a>
						</center>
					</td>
					<td style="width:100px">'.$r['num_accion'].'</td>
					<td style="width:100px">'.$r['entidad'].'</td>
					<td style="width:50px"><center>'.$nivPart[0].'</center></td>
					<td style="width:50px">'.$r['actores'].'</td>
					<td class="ancho200">'.dameEstado($r['detalle_edo_tramite']).'</td>
					<td class="ancho100">
						<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,900," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,
						   "cont/pfrr_informacion.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'&nivel='.$_SESSION['nivel'].'")\'></a>';
						
						if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9" ) 
						    $tabla .= ' <a href="#" title="Actualizar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1200," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,
						   "cont/pfrr_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
						
						if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9" ) 
						    $tabla .= ' <a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(580,1200,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",20,
						  "cont/pfrr_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
						
						if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9" )
							$tabla .= ' <a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" 
							            onclick=\'var cuadro3 = new mostrarCuadro(580,1200,"' . $r['num_accion'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']) . ' ", 20,
						               "cont/i_presuntos.php", "procedimiento='.$r['num_procedimiento'].'&numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';

						if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9" ) 
						    $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(580,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",20,
						  "cont/pfrr_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>
						
						
						
						</td>
				</tr>';
}
	$tabla .= '
			</tbody>
            </table>
            <!--  end product-table................................... --> 
            </form>
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
$paginas = ceil($total/500);
echo $tabla."-|-".$total."-|-".$sqltxt."-|-".$paginas;

mysql_free_result($sql);
 mysql_close();
 ?>

<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$valor = valorSeguro($_POST['valor']);
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
$sqltxt = "SELECT num_accion,entidad,cp,subdirector,abogado,direccion,abogado,detalle_edo_tramite, prescripcion FROM pfrr";

if($direccion == 'DG') 	$sqltxt .= " WHERE num_accion LIKE '%".$valor."%' ";
elseif($nivel == "S") 	$sqltxt .= " WHERE direccion = '".$direccion."' AND num_accion LIKE '%".$valor."%'  "; 
else 					$sqltxt .= " WHERE subnivel LIKE '".$nivel."%' AND num_accion LIKE '%".$valor."%'  ";

$sql = $conexion->select($sqltxt." ORDER BY num_accion",false);
$total = mysql_num_rows($sql);
//---------------------------------------------------------------
$tabla = '
<form id="mainform" action="" class="formTabla">
            <table border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
';

while($r = mysql_fetch_array($sql))
{
	$sql1 = $conexion->select("SELECT nombre,nivel FROM usuarios WHERE nombre  LIKE '%".$r['abogado']."%' ",false);
	$u = mysql_fetch_array($sql1);
	//------------------------------------------------------------------------------
	//------------------------------------------------------------------------------
	$nivPart = explode(".",$u['nivel']);
	$nivDir = $r['direccion'];
	$nivSbd = $r['direccion'].".".$nivPart[1];
	$nivJdd = $r['direccion'].".".$nivPart[1].".".$nivPart[2];
	$nivCor = $r['direccion'].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];
	/*
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
	$d = mysql_fetch_array($sql1);
	$director = $d['nombre'];
	*/
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
	$s = mysql_fetch_array($sql1);
	$subdirector = $s['nombre'];
	/*
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
	$d = mysql_fetch_array($sql1);
	$jefe = $d['nombre'];
	
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' ",false);
	$d = mysql_fetch_array($sql1);
	$coordinador = $d['nombre'];
	*/
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

	//-------- sacamos permisos sobre acciones ----------------
	//$permiso = strpos($nivel,$r['subnivel']);
	//if($permiso !== false || $direccion == 'DG')
	//{
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PFRR SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="accion" >
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000,"Bitacora&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",50,"cont/po_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['num_accion']).'
						</a>
					</td>
					<td class="entidad">'.$r['entidad_fiscalizada'].'</td>
					<td class="direccion">'.$r['direccion'].'</td>
					<td class="subdirector">'.$subdirector.'</td>
					<!-- <td class="abogado">'.$r['abogado'].'</td> -->
					<td class="estado">'.dameEstado($r['detalle_edo_tramite']).'</td>
						<td class="acciones">
						<a href="#" title="Control Interno" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",20,"cont/pfrr_informacion.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>
						';
		if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Actualizar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(510,1100,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,"cont/pfrr_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,800," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",50,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		
		$tabla .= '</td>
				</tr>';
	//}//end if permiso
}
	$tabla .= '
			</tbody>
            </table>
            <!--  end product-table................................... --> 
            </form>
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
echo $tabla."-|-".$total;

mysql_free_result($sql);
?>
<?php 	    mysql_close();
?>

 <?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting (2); 
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
$limit = valorSeguro($_POST['limit']);
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
$sqltxt = "SELECT * FROM usuarios";

if($direccion == 'DG') 	$sqltxt .= " WHERE nombre LIKE '%".$valor."%' ";
elseif($nivel == "S") 	$sqltxt .= " WHERE direccion LIKE '".$direccion."%'"; 

$sql = $conexion->select($sqltxt." ORDER BY nombre",false); //cuenta total registros
$total = mysql_num_rows($sql);
//--------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,500 ";
else $limit = $limit;
//--------------------------------------------------------------------
$sql = $conexion->select($sqltxt." ORDER BY nombre ".$limit,false);// muestra todos los registros
$totalBus = mysql_num_rows($sql);

//$sql = $conexion->select($sqltxt." ORDER BY num_accion ",false);// muestra todos los registros
//---------------------------------------------------------------
$tabla = '
<form id="mainform" action="" class="formTabla">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
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
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="ancho100" align="left" >
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['nombre']).'
						</a>
					</td>
					<td class="ancho50" align="center">'.$r['noempleado'].'</td>
					<td class="ancho50" align="center">'.$r['direccion'].'</td>
					<td class="ancho50" align="center">'.$r['nivel'].'</td> 
					<td class="ancho50" align="right">
						';
		if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Actualizar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(510,1100,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		
		if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).' ",50,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).' ",50,"cont/po_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		
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
$paginas = ceil($total/500);
echo $tabla."||".$total."||".$paginas."||".$totalBus;

mysql_free_result($sql);
mysql_close();
?>

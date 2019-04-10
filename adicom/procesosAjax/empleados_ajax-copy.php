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
//------------------ Buscamos al usuario
$sql1 = $conexion->select("SELECT * FROM usuarios WHERE usuario LIKE '%".$usuario."%' AND nivel = '".$nivel."' AND direccion = '".$direccion."' ",false);
$d = mysql_fetch_array($sql1);
$mostrar = $d['direccion'];
$mostrar1 = $d['nivel'];
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
$sqltxt = "SELECT * FROM usuarios";

if($direccion == 'DG') 	$sqltxt .= " WHERE (nombre LIKE '%".$valor."%' OR noempleado LIKE '%".$valor."%') and `status` != '0' ";
elseif($nivel == "S") 	$sqltxt .= " WHERE (nombre LIKE '%".$valor."%' OR noempleado LIKE '%".$valor."%') AND (direccion LIKE '%".$direccion."%' OR direccion='0') and `status` != '0' ";

$sql = $conexion->select($sqltxt." ORDER BY `direccion` asc, `status` desc, `nivel` asc",false); //cuenta total registros

$total = mysql_num_rows($sql);
//--------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,500 ";
else $limit = $limit;
//--------------------------------------------------------------------
$sql = $conexion->select($sqltxt." ORDER BY `direccion` asc, `status` desc, `nivel` asc".$limit,false);// muestra todos los registros
$totalBus = mysql_num_rows($sql);

//---------------------------------------------------------------
$tabla = '
<form id="mainform" class="formTabla">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
';

while($r = mysql_fetch_array($sql))
{
	
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		if ($r['status'] == 1) $tipostatus = "Activo"; 
		else if ($r['status'] == 0.5) $tipostatus = "Sin acceso";
		else $tipostatus = "Inactivo";
		
		//------------ MUESTRA FILAS LA FUNCION SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
				<td width="85" align="center">
						<a href="#" title="Ver Contrato" onclick=\'var cuadro4 = new mostrarCuadro(610,810,"Nombre: '.$r['contrato'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/emp_contrato.php","emp='.$r['usuario'].'&co='.$r['contrato'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['noempleado']).'
						</a>
				</td>
				
					<td width="215" align="left" >
						<a href="#" title="Ver Información del Empleado" onclick=\'var cuadro1 = new mostrarCuadro(310,410,"Nombre: '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/emp_historial.php","emp='.$r['usuario'].'&id='.$r['id'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['nombre']).'
						</a>
					</td>
					<td width="130" align="center">'.$r['curp'].'</td>
					<td width="40" align="center">'.$r['direccion'].'</td>
					<td width="60" align="center">'.$r['nivel'].'</td>
					<td width="190" align="center">'.$r['puesto'].'</td>
					<td width="150" align="center">'.$r['tipo_emp'].'</td>
					<td width="60" align="center">'.$tipostatus.'</td> 
					<td width="70" align="center">
						';
		if($mostrar1 == "S" or $mostrar == "DG") $tabla .= '<a href="#" title="Ver Información del Empleado" class="icon-5 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(300,800,"Nombre: '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/empleados_info.php","emp='.$r['usuario'].'&id='.$r['id'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
						
		if($mostrar == "DG" or $mostrar1 == "S") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(450,850,"Nombre: '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel: '.$r['nivel'].'",50,"cont/empleados_mod.php","emp='.$r['usuario'].'&id='.$r['id'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
		
		$tabla .= '</td>
				</tr>';
				
}
	$tabla .= '
			</tbody>
            </table>
            <!--  end product-table................................... --> 
            </form>
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";

$paginas = ceil($total/500);
echo $tabla."||".$total."||".$paginas."||".$totalBus;

mysql_free_result($sql);
mysql_close();
?>

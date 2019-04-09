<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ERROR);

require_once("../includes/clasesMysqli.php");

require_once("../includes/funciones.php");
$conexion = new conexion;
$conecta = $conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$valor = $_POST['valor'];
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
$sqltxt = "SELECT * FROM actores_recurso";

if($nivel == 'S')
	{ 	$sqltxt .= " WHERE (actor LIKE '%".$valor."%' OR recurso_reconsideracion LIKE '%".$valor."%') AND direccion LIKE '%".$direccion."%' ";	}
else if($nivel != "DG")
	{ 	$sqltxt .= " WHERE (actor LIKE '%".$valor."%' OR recurso_reconsideracion LIKE '%".$valor."%') AND subnivel LIKE '%".$nivel."%' ";	}
else 
	{	$sqltxt .= " WHERE actor LIKE '%".$valor."%' OR num_accion LIKE '%".$valor."%' OR recurso_reconsideracion LIKE '%".$valor."%' ";	}

	//elseif($nivel == 'S') 	$sqltxt .= " WHERE direccion = '".$direccion."' AND actor LIKE '%".$valor."%' ";
	 			//	elseif($subnivel <> 'B.1.2.2')	$sqltxt .= " WHERE subnivel =$nivel";



	//$sqltxt .= " AND detalle_edo_tramite = 24";
	
	$sql = $conexion->select($sqltxt,false);
	$r = mysql_fetch_array($sql);
	$total = mysqli_num_rows($sql);
	$sql = $conexion->select($sqltxt." ORDER BY SUBSTRING(`recurso_reconsideracion`, 29) limit 500",false);
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
?>
<script>
function muestraSubMedios(id)
{
	//$$('#menuMedios_'+id).slideDown();
	//alert('hola')
}
</script>
<?php
$tabla = '
<form id="mainform" action="" class="formTabla">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
';
	
while($r = mysqli_fetch_array($sql))
{
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
	$sql1 = $conexion->select("SELECT nombre,nivel FROM usuarios WHERE nombre  LIKE '%".$r['abogado']."%' ",false);
	$u = mysqli_fetch_array($sql1);
	//------------------------------------------------------------------------------
	$nivPart = explode(".",$u['nivel']);
	$nivDir = $r['direccion'];
	$nivSbd = $r['direccion'].".".$nivPart[1];
	$nivJdd = $r['direccion'].".".$nivPart[1].".".$nivPart[2];
	$nivCor = $r['direccion'].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];
	/*
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
	$d = mysqli_fetch_array($sql1);
	$director = $d['nombre'];
	*/
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
	$s = mysqli_fetch_array($sql1);
	$subdirector = $s['nombre'];
	/*
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
	$d = mysqli_fetch_array($sql1);
	$jefe = $d['nombre'];
	
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' ",false);
	$d = mysqli_fetch_array($sql1);
	$coordinador = $d['nombre'];
	*/
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		$PFRR = idameDatosPFRR($r['num_accion'],$conecta);
		$dir = $PFRR['direccion'];
		$ctrlInt = dameEstadoi($conecta,$r['detalle_edo_tramite']);
		
		$monto = ($r['monto'] != '') ? "$".@number_format(trim($r['monto']),2) : $r['monto'];
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="ancho150">
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000," '.$r['actor'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).' ",50,"cont/medios_rr_bitacora.php","numAccion='.$r['num_accion'].'&idactor='.urlencode($r['actor']).'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'&nivel='.$_SESSION['nivel'].'")\' >
							'.str_ireplace($valor,"<span class='b'>".$valor."</span>",$r['actor']).'
						</a>								
						
					</td>
					<td class="ancho150" >
					
						<center>
						'.$r['num_accion'].'
						</center>
					</td>
					<td class="ancho150">'.$r['recurso_reconsideracion'].'</td>
					<td class="ancho50" align="center"><center>'.$r['direccion'].'</center></td>
					<td class="ancho150">'.$ctrlInt.'</td>
					<td class="ancho100">';
					
					
					
					
						$tabla .= '<a href="#" title="Ver Información"  class="icon-5 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,900," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).'",50,"cont/mediosrr_informacion.php","num_recurso='.$r['recurso_reconsideracion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'> </a>';
						
						
						$tabla .= "<a href=\"#\" title='Recurso de Reconsideración'  class='icon-1 info-tooltip' onclick=\"var cuadro5 = new mostrarCuadro(450,1100,'".$r['actor']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r['num_accion']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ctrlInt."',50,'cont/medios_reconsideracion.php','recurso_reconsideracion=".$r['recurso_reconsideracion']."&numAccion=".$r['accion']."&edotram=".$r['detalle_edo_tramite']."&usuario=".$_SESSION['usuario']."&direccion=".$_SESSION['direccion']."&presunto=".urlencode($r['actor'])."')\">  </a>";						

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

mysqli_free_result($sql); 
//mysqli_close($conexion);
 ?>

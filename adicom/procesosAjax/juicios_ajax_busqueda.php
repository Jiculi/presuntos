<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(0);

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
	$sqltxt = "SELECT * FROM juicios ";
	
	if($direccion == 'DG') 	$sqltxt .= " WHERE nojuicio LIKE '%".$valor."%' ";
	//elseif($nivel == 'S') 	$sqltxt .= " WHERE subnivel LIKE '".$direccion."%' AND num_accion LIKE '%".$valor."%'  "; 
	else 					$sqltxt .= " WHERE subnivel LIKE '".$nivel."%' AND nojuicio LIKE '%".$valor."%'  ";
	
	$sqlSinLim = $conexion->select($sqltxt." ORDER BY id",false);
	$sql = $conexion->select($sqltxt." ORDER BY id ".$limit,false);
	
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
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
		$i++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA -------
		//----------------------------------------- SI TRAE $nivel-------------------------------------------------
		//----------------------------------------- REVISAR "numAccion='.$r['nojuicio']. --------------------------
				
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="ancho50" align="center" >
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000,"'.$r['nojuicio'].'",50,"cont/juicio_bitacora.php","juicio='.$r['id'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['nojuicio']).'
						</a>








					<td class="ancho150">'.$r['entidad'].'</td>
					<td class="ancho100">'.$r['actor'].'</td>
					<td class="ancho100">'.$r['salaconocimiento'].'</td>
					<td class="ancho100">'.$r['juicionulidad'].'</td>
					<td class="ancho100">'.'$ '. number_format($r['monto'],2).'</td>  
						<td class="ancho100">
						<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,900," '.$r['nojuicio'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['estado'].'",50,"cont/juicio_caratula.php","juicio='.$r['nojuicio'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'&nivel='.$_SESSION['nivel'].'")\'></a>';
						
						if($nivel != "S") $tabla .= ' 	<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(520,900,"Juicio: '.$r['nojuicio'].'",50,"cont/juicio_proceso.php","juicio='.$r['id'].'&juinu='.$r['nojuicio'].'")\'></a>';
						
						if($nivel != "S") $tabla .= ' 	<a href="#" title="Antiguo" class="icon-3 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(520,900,"Juicio: '.$r['nojuicio'].'",50,"cont/juicios_mod.php","juicio='.$r['id'].'&juinu='.$r['nojuicio'].'")\'></a>';
						
					

				
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

<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

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
	$sqltxt = "SELECT * FROM medios ";
//cont	num_accion	nombre	cargo	rfc	domicilio	accion_omision	fecha_accion_omision_1	fecha_accion_omision_2	prescripcion_accion_omision	monto	resarcido	intereses_resarcidos	fecha_deposito_intereses_resarcidos	monto_aclarado	fecha_deposito	oficio_citatorio	fecha_oficio_citatorio	fecha_notificacion_oficio_citatorio	tipo_notificacion	fecha_audiencia	comparece	fecha_diferimiento_audiencia	comparece_diferimiento	fecha_continuacion_audiencia	comparece_continuacion	fecha_ofrecimiento_pruebas	responsabilidad	tipo
//id	num_accion	superveniente	entidad	cp	auditoria	direccion	subdirector	abogado	po	fecha__po	num_DT	monto_no_solventado	prescripcion	estado	fecha_edo_tramite	num_procedimiento	fecha_num_procedimiento	cierre_instruccion	resolucion	fecha_notificacion_resolucion	limite_notificacion_resolucion	limite_emision_resolucion	limite_cierre_instruccion	fecha_IR	fin_IR	usuario	hora	PDR	fecha_acuerdo_inicio	fecha_analisis_documentacion	tipo_resolucion	subnivel	DG	validacion	f1_fecha_presc	
	if($direccion == 'DG') 	$sqltxt .= " WHERE nombre LIKE '%".$valor."%' ";
	elseif($nivel == 'S') 	$sqltxt .= " WHERE direccion = '".$direccion."' AND nombre LIKE '%".$valor."%' ";
	else 					$sqltxt .= " WHERE subnivel LIKE '".$nivel."%' AND nombre LIKE '%".$valor."%'  ";
	
	$sql = $conexion->select($sqltxt,false);
	$total = mysqli_num_rows($sql);
	$sql = $conexion->select($sqltxt." ORDER BY num_accion limit 500",false);
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
		$ctrlInt = dameEstadoi($conecta,$r['estado']);
		// Estados Sicsa 
		// Recurso de Reconcideracion	= 10
		// Juicio de Nulidad			= 11
		$Sicsa = dameNumSicsai($conecta,$r['estado']);
		
		//$monto = ($r['monto'] != '') ? "$".@number_format(trim($r['monto']),2) : $r['monto'];
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="ancho150">'.str_ireplace($valor,"<span class='b'>".$valor."</span>",$r['nombre']).'</td>
					<td class="ancho150" >
					<!--
						<center>
						<a href="#" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['estado']).' ",50,"cont/pfrr_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_ireplace($valor,"<span class='b'>".$valor."</span>",$r['num_accion']).'
						</a>
						</center>
					-->
						<center>
						'.$r['num_accion'].'
						</center>
					</td>
					<td class="ancho150">'.$r['entidad'].'</td>
					<td class="ancho50" align="center">'.$dir.'</td>
					<td class="ancho150">'.$ctrlInt.'</td>
					<td class="ancho100">';
						$tabla .= '<a href="#" title="Control Interno" onclick=\'var cuadro2 = new mostrarCuadro(500,900," '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['estado']).'",50,"cont/medios_informacion.php","id='.$r['id'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'&nivel='.$nivel.'")\'> <img src="images/medios_info.png" /> </a>';
						if($Sicsa == 10) $tabla .= "<a href=\"#\" title='Recurso de Reconcideración' onclick=\"var cuadro5 = new mostrarCuadro(450,1200,'".$r['nombre']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$r['num_accion']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".dameEstadoi($conecta,$r['estado'])."',50,'cont=medios_rr_actores','idPresuntop=".$r['id']."&numAccion=".$r['num_accion']."&usuario=".$_SESSION['usuario']."&direccion=".$_SESSION['direccion']."')\"> <img src='images/medio_actores_24.png'  /> </a>";
						else $tabla .= "<a href=\"#\" title='Recurso de Reconcideración'> <img class='imgInactiva' src='images/medio_actores_24_gris.png'  /> </a> ";
						if($Sicsa == 11) $tabla .= '<a href="#" title="Juicio de Nulidad" onclick=\'var cuadro5 = new mostrarCuadro(400,1200,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['estado']).'",50,"cont/pfrr_presuntos_datos.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'&presunto='.$r['nombre'].')\'> <img src="images/medio_nulidad_24.png" /> </a>';
						else $tabla .= '<a href="#" title="Juicio de Nulidad"> <img src="images/medio_nulidad_24_gris.png" /> </a>';
						if($Sicsa == 12) $tabla .= '<a href="#" title="Juicio de Amparo" onclick=\'var cuadro5 = new mostrarCuadro(400,1200,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['estado']).'",50,"cont/pfrr_presuntos_montos.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'> <img src="images/medio_amparo_24.png" /> </a>';
						else $tabla .= '<a href="#" title="Juicio de Amparo"> <img src="images/medio_amparo_24_gris.png" /> </a>';
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

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
echo $tabla."-|-".$total;

mysqli_free_result($sql); 
//mysqli_close($conexion);
 ?>

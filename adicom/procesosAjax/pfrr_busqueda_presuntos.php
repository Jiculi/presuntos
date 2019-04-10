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
	$sqltxt = "SELECT PA.cont,PA.nombre,pfrr.num_accion as numAc,PA.num_accion,PA.cargo,PA.dependencia,PA.monto,PA.responsabilidad,detalle_edo_tramite,direccion,entidad,subnivel FROM pfrr_presuntos_audiencias PA INNER JOIN pfrr ON PA.num_accion = pfrr.num_accion ";
//cont	num_accion	nombre	cargo	rfc	domicilio	accion_omision	fecha_accion_omision_1	fecha_accion_omision_2	prescripcion_accion_omision	monto	resarcido	intereses_resarcidos	fecha_deposito_intereses_resarcidos	monto_aclarado	fecha_deposito	oficio_citatorio	fecha_oficio_citatorio	fecha_notificacion_oficio_citatorio	tipo_notificacion	fecha_audiencia	comparece	fecha_diferimiento_audiencia	comparece_diferimiento	fecha_continuacion_audiencia	comparece_continuacion	fecha_ofrecimiento_pruebas	responsabilidad	tipo
//id	num_accion	superveniente	entidad	cp	auditoria	direccion	subdirector	abogado	po	fecha__po	num_DT	monto_no_solventado	prescripcion	detalle_edo_tramite	fecha_edo_tramite	num_procedimiento	fecha_num_procedimiento	cierre_instruccion	resolucion	fecha_notificacion_resolucion	limite_notificacion_resolucion	limite_emision_resolucion	limite_cierre_instruccion	fecha_IR	fin_IR	usuario	hora	PDR	fecha_acuerdo_inicio	fecha_analisis_documentacion	tipo_resolucion	subnivel	DG	validacion	f1_fecha_presc	
	if($direccion == 'DG' || $direccion == 'A' || $direccion == 'B' || $direccion == 'C' || $direccion == 'D') 	$sqltxt .= " WHERE PA.nombre LIKE '%".$valor."%' ";
	elseif($nivel == 'S') 	$sqltxt .= " WHERE pfrr.direccion = '".$direccion."' AND PA.nombre LIKE '%".$valor."%' ";
	else 					$sqltxt .= " WHERE pfrr.subnivel LIKE '".$nivel."%' AND PA.nombre LIKE '%".$valor."%'  ";
	
	$sql = $conexion->select($sqltxt,false);
	$total = mysqli_num_rows($sql);
	$sql = $conexion->select($sqltxt." ORDER BY num_accion limit 500",false);
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
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
		
		//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
		$tabla .= '
				<tr '.$estilo.'  >
					<td class="ancho150">'.str_ireplace($valor,"<span class='b'>".$valor."</span>",$r['nombre']).'</td>
					<td class="ancho150" >
						<center>
						<a href="#" title="Ver Información" onclick=\'var cuadro1 = new mostrarCuadro(500,1000," '. 
						$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].
						'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).
						' ",50, "cont/pfrr_informacion.php", "numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].
						'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_ireplace($valor,"<span class='b'>".$valor."</span>",$r['numAc']).'
						</a>
						</center>
					</td>
					<td class="ancho150"> '.$r['cargo'].' </td>
					<td class="ancho150">'.$r['dependencia'].'</td>
					<td class="ancho100" align="right">$'.@number_format(trim($r['monto']),2).'</td>
					<td class="ancho50" align="center">'.$r['responsabilidad'].'</td> 
					<td class="ancho100">';
					
						//$tabla .= '<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,900," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).'",50,"cont/pfrr_informacion.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
						$tabla .= '<a href="#" title="Proceso de Presuntos" class="icon-8 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(530,1100,"' . 
						$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].
						'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).
						'",50,"cont/pfrr_presuntos_proceso.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].
						'&direccion='.$_REQUEST['direccion'].'")\'></a>';

						$tabla .= '<a href="#" title="Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(520,800,"'.
						$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
						dameEstadoi($conecta,$r['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_datos.php","idPresuntop='.$r['cont'].'&numAccion='.
						$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
						// $tabla .= '<a href="#" title="Montos" class="icon-11 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(540,800,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstadoi($conecta,$r['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_montos.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '</td>
				</tr>';
}

				//$tabla .= '<a href="#" title="Proceso de Presuntos" class="icon-8 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(530,1100,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_proceso.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				//$tabla .= '<a href="#" title="Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(520,800,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_datos.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				//$tabla .= '<a href="#" title="Montos" class="icon-11 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(540,800,"'.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_montos.php","idPresuntop='.$r['cont'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';


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

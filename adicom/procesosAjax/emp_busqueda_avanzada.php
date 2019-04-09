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
$limit = valorSeguro($_POST['limit']);
$envio = valorSeguro($_POST['envio']);
//------------------------------------------------------------------------------
$reports = valorSeguro($_POST['reports']);

$nombre = valorSeguro($_POST['Nombre']);
$Nivl = valorSeguro($_REQUEST['Nivl']);
$genero = valorSeguro($_POST['Genero']);
$Direccion = valorSeguro($_POST['Direccion']);
$curp = valorSeguro($_POST['Curp']);
$status = valorSeguro($_POST['Estatus']);
$puesto=valorSeguro($_POST['Puesto']);
$tipo_emp=valorSeguro($_POST['Tipo_emp']);
$noempleado=valorSeguro($_POST['Noempleado']);
$fecha_ingreso=valorSeguro($_POST['Fecha_ingreso']);

$direccion =  valorSeguro($_POST['direccion']);
$nivel=  valorSeguro($_POST['nivel']);


/* ------------------- CHECKBOX ------------------------*/
$noCh =  valorSeguro($_POST['noCh']);
$curpCh =  valorSeguro($_POST['curpCh']);
$usuarioCh =  valorSeguro($_POST['usuarioCh']);
$passwordCh =  valorSeguro($_POST['passwordCh']);
$nivelCh =  valorSeguro($_POST['nivelCh']);

$direccionCh =  valorSeguro($_POST['direccionCh']);
$perfilCh =  valorSeguro($_POST['perfilCh']);
$opcionesCh =  valorSeguro($_POST['opcionesCh']);
$statusCh =  valorSeguro($_POST['statusCh']);
$generoCh =  valorSeguro($_POST['generoCh']);

$fecha_ingresoCh =  valorSeguro($_POST['fecha_ingresoCh']);
$sustituyeCh =  valorSeguro($_POST['sustituyeCh']);
$tipo_empCh =  valorSeguro($_POST['tipo_empCh']);
$puestoCh =  valorSeguro($_POST['puestoCh']);
$fecha_bajaCh =  valorSeguro($_POST['fecha_bajaCh']);

$puesto_antCh =  valorSeguro($_POST['puesto_antCh']);


/* ------------------- CHECKBOX ------------------------*/
if($nombre !=""){ $sqlnombre="and nombre LIKE '%".$nombre."%' "; }
else{$sqlnombre="";}

if($Nivl != "") $sqlNivl="and nivel LIKE '%".$Nivl."%' ";
else $sqlNivl="";

if ($genero !="") $sqlgenero="and genero LIKE '".$genero."%' ";
else $sqlgenero="";

if($Direccion != "") $sqlDireccion="and direccion LIKE '".$Direccion."%' ";
else $sqlDireccion="";

if  ($curp != "" ) $sqlcurp= " AND curp LIKE '".$curp."%' ";
else $sqlcurp= "";

if  ($status != "" ) $sqlstatus= "and  status LIKE '%".$status."%' ";
else $sqlstatus= "";

if  ($puesto != "" ) $sqlpuesto= " AND  puesto  LIKE '%".$puesto."%' ";
else $sqlpuesto= "";

if  ($tipo_emp != "" ) $sqltipo_emp= " AND tipo_emp LIKE '%".$tipo_emp."%' ";
else  $sqltipo_emp= "";

if  ($noempleado != "" ) $sqlnoempleado= " AND noempleado LIKE '% ".$noempleado." ";
else $sqlnoempleado= "";
//--super
if  ($fecha_ingreso !="") $sqlfecha_ingreso= " AND fecha_ingreso LIKE '%".$fecha_ingreso."%' ";
else $sqlfecha_ingreso="";
//super
/* LUNES if($fecha !=0 and $anio!=0) $sqlfecha="and prescripcion between '".$anio."-".$fecha."-01' and '".$anio."-".$fecha."-31'";
else $sqlfecha="";
*/
if($direccion !="") $sqldireccion="and direccion LIKE '%".$direccion."%' ";
else $sqldireccion="";

if($nivel !="") $sqlnivel="and nivel LIKE '%".$nivel."%' ";
else $sqlnivel="";

/*Lunes.if($tipoPO == "ampliado") 
	$sqlAmp="and irregularidad LIKE  '%ampliado%' ";
else $sqlAmp=""; */
//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
//if($tipo_devolucion !="") {
	$txtsql="SELECT * FROM usuarios ";
	//$sqltipo_devolucion="and tipo_devolucion like '%".$tipo_devolucion."%'";
/*}
else $sqltipo_devolucion="";

if($presunto !="") {
	$txtsql="SELECT * FROM usuarios ";
	$sqlpresunto="and servidor_contratista  LIKE '%".$presunto."%' ";
}
else $sqlpresunto="";

if($presunto == "" && $tipo_devolucion == ""){
	$txtsql="SELECT * FROM usuarios ";
}
else {
	$txtsql="SELECT * FROM usuarios ";
	$sqltipo_devolucion="and tipo_devolucion like '%".$tipo_devolucion."%'";
	$sqlpresunto="and servidor_contratista  LIKE '%".$presunto."%' ";
} */


//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= ' WHERE 1=1 '.$sqlnombre.' '.$sqlNivl.' '.$sqlgenero.' '.$sqlDireccion.' '.$sqlcurp.' '.$sqlstatus.' '.$sqlpuesto.' '.$sqltipo_emp.' '.$sqlnoempleado.' '.$sqlfecha_ingreso.' '.$sqldireccion ;
//---------- SECRES ven direccion ----------------------------------
elseif($nivel == 'S')
	$txtsql .= 'WHERE subnivel LIKE "'.$sqlnombre.' '.$sqlNivl.' '.$sqlgenero.' '.$sqlDireccion.' '.$sqlcurp.' '.$sqlstatus.' '.$sqlpuesto.' '.$sqltipo_emp.' '.$sqlnoempleado.' '.$sqlfecha_ingreso.' '.$sqldireccion.' '.$sqlnivel;
//--------------------------------------------------------------------------------------------
//---------- ABOGADOS segun nivel ----------------------------------
else 
	$txtsql .= 'WHERE subnivel LIKE "'.$sqlnombre.' '.$sqlNivl.' '.$sqlgenero.' '.$sqlDireccion.' '.$sqlcurp.' '.$sqlstatus.' '.$sqlpuesto.' '.$sqltipo_emp.' '.$sqlnoempleado.' '.$sqlfecha_ingreso.' '.$sqldireccion.' '.$sqlnivel;
//--------------------------------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,1000 ";
else $limit = $limit;
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);
$sql = $conexion->select($txtsql." ORDER BY noempleado ".$limit ,false);
$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				if($noCh == "true") $tabla .= '<th class="ancho100 blanco">No. Empleado	</th>';
				$tabla .= '<th class="ancho200 blanco">Nombre	</th>'; 
				if($curpCh == "true") $tabla .= '<th class="ancho200 blanco">Curp	</th>';
				if($usuarioCh == "true") $tabla .= '<th class="ancho100 blanco">Usuario</th>';
				if($passwordCh == "true") $tabla .= '<th class="ancho100 blanco"> Password</th>';
				if($nivelCh == "true") $tabla .= '<th class="ancho50 blanco">Nivel </th>';
				
				if($direccionCh == "true") $tabla .= '<th class="ancho100 blanco">Dirección</th>';
				if($perfilCh == "true") $tabla .= '<th class="ancho100 blanco">Perfil</th>';				
				if($opcionesCh == "true") $tabla .= '<th class="ancho50 blanco">Opciones</th>';
				if($statusCh == "true") $tabla .= '<th class="ancho200 blanco">Estatus</th>';
				if($generoCh == "true") $tabla .= '<th class="ancho200 blanco">Genero</th>';
				
				if($fecha_ingresoCh == "true") $tabla .= '<th class="ancho200 blanco">Fecha Ingreso</th>';
				if($sustituyeCh == "true") $tabla .= '<th class="ancho200 blanco">Sustituyó</th>';
				if($tipo_empCh == "true") $tabla .= '<th class="ancho300 blanco">Tipo Empleado</th>';
				if($puestoCh == "true") $tabla .= '<th class="ancho200 blanco">Puesto</th>';
				if($fecha_bajaCh == "true") $tabla .= '<th class="ancho200 blanco">Fecha Baja</th>';
				
				if($puesto_antCh == "true") $tabla .= '<th class="ancho300 blanco">Puesto Anterior</th>';
							
			$tabla .= '<th class="acciones blanco">Seguimiento</th> 
					</tr>
				</thead>

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
	
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//------SQL de Volantes//
	
	$query1="SELECT folio, po.num_accion from  volantes_contenido vc
		INNER JOIN po on po.num_accion=vc.accion
		WHERE po.num_accion= '".$r['num_accion']."'
		ORDER BY fecha_actual desc 
		LIMIT 1";
	
	$sql3=$conexion->select($query1);
	$f=mysql_fetch_array($sql3);
	$volante=$f['folio'];
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				if($noCh == "true") $tabla .= '<td class="" align="center">'.$r['noempleado'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['nombre'].'</td>';
				if($curpCh == "true") $tabla .= '<td class="" align="center">'.$r['curp'].'</td>';
				if($usuarioCh == "true") $tabla .= '<td class="" align="center">'.$r['usuario'].'</td>';
				if($passwordCh == "true") $tabla .= '<td class="" align="center">'.$r['password'].'</td>';
				if($nivelCh == "true") $tabla .= '<td class="" align="center">'.$r['nivel'].'</td>';
				
				
				if($direccionCh == "true") $tabla .= '<td class="" align="center">'.$r['direccion'].'</td>';
				if($perfilCh == "true") $tabla .= '<td class="" align="center">'.$r['perfil'].'</td>';
				if($opcionesCh == "true") $tabla .= '<td class="" align="center">'.$r['opciones'].'</td>';
				if($statusCh == "true") $tabla .= '<td class="" align="center">'.$r['status'].'</td>';
				if($generoCh == "true") $tabla .= '<td class="" align="center">'.$r['genero'].'</td>';
							
				if($fecha_ingresoCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_ingreso']).'</td>';
				if($sustituyeCh == "true") $tabla .= '<td class="" align="center">'.$r['sustituye'].'</td>';
				if($tipo_empCh == "true") $tabla .= '<td class="" align="center">'.$r['tipo_emp'].'</td>';
				if($puestoCh == "true") $tabla .= '<td class="" align="center">'.$r['puesto'].'</td>';				
				if($fecha_bajaCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_baja']).'</td>';
				
				if($puesto_antCh == "true") $tabla .= '<td class="" align="center">'.$r['puesto_ant'].'</td>';
				
				
			$tabla .= '	<td class="acciones">';
			
			if($reports != 1)
			{
				if($nivel == "S" OR $nivel == "DG") $tabla .= '<a href="#" title="Ver Información del Empleado" class="icon-5 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(300,800,"Nombre: '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/empleados_info.php","emp='.$r['usuario'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
						
				if($nivel == "S" OR $nivel == "DG") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(450,770,"Nombre: '.$r['nombre'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dirección: '.$r['direccion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nivel: '.$r['nivel'].'",50,"cont/empleados_mod.php","emp='.$r['usuario'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				
			}
			$tabla .= '</td> </tr>';
}
$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=listado_sa.xls");
//$excel=$_REQUEST['export'];
print utf8_decode($tabla);
exit;

//------------------------------------------------------------------------------------------------------------------
$paginas = ceil($total/1000);
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;


//print_r($_POST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
mysql_free_result($sqlT);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

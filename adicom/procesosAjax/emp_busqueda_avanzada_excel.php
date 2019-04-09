<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$limit = valorSeguro($_REQUEST['limit']);
$envio = valorSeguro($_REQUEST['envio']);
//------------------------------------------------------------------------------
$reports = valorSeguro($_REQUEST['reports']);
$accion = valorSeguro($_REQUEST['accion']);



$ef = valorSeguro($_REQUEST['ef']);
$cp = valorSeguro($_REQUEST['cp']);
$aud = valorSeguro($_REQUEST['aud']);
$edoTram = valorSeguro($_REQUEST['edoTram']);
$po=valorSeguro($_REQUEST['pobus']);
$uaa=valorSeguro($_REQUEST['uaa']);
$fondo=valorSeguro($_REQUEST['fondo']);
$director=valorSeguro($_REQUEST['director']);
$subdirector=valorSeguro($_REQUEST['subdirector']);
// lUNES $presunto=valorSeguro($_REQUEST['presunto']);
$edoSicsa=valorSeguro($_REQUEST['edoSicsa']);
// LUNES $fecha=valorSeguro($_REQUEST['fecha']);
// lUNES $anio=valorSeguro($_REQUEST['anio']);
// lUNES $tipo_devolucion=valorSeguro($_REQUEST['tipo_devolucion']);
$direccion =  valorSeguro($_REQUEST['direccion']);
$nivel=  valorSeguro($_REQUEST['nivel']);
$usu =  valorSeguro($_REQUEST['usuario']);
$jefe_depto =  valorSeguro($_REQUEST['jefe_depto']);
/* ------------------- CHECKBOX ------------------------*/
/* ------------------- CHECKBOX ------------------------*/
$noCh =  valorSeguro($_REQUEST['noCh']);
$curpCh =  valorSeguro($_REQUEST['curpCh']);
$usuarioCh =  valorSeguro($_REQUEST['usuarioCh']);
$direccionCh =  valorSeguro($_REQUEST['direccionCh']);
$passwordCh =  valorSeguro($_REQUEST['passwordCh']);
$nivelCh =  valorSeguro($_REQUEST['nivelCh']);

$perfilCh =  valorSeguro($_REQUEST['perfilCh']);
$opcionesCh =  valorSeguro($_REQUEST['opcionesCh']);
$statusCh =  valorSeguro($_REQUEST['statusCh']);
$generoCh =  valorSeguro($_REQUEST['generoCh']);

$fecha_ingresoCh =  valorSeguro($_REQUEST['fecha_ingresoCh']);
$sustituyeCh =  valorSeguro($_REQUEST['sustituyeCh']);
$tipo_empCh =  valorSeguro($_REQUEST['tipo_empCh']);
$puestoCh =  valorSeguro($_REQUEST['puestoCh']);
$fecha_bajaCh = valorSeguro($_REQUEST['fecha_bajaCh']);
//lunes  $tipoPO = valorSeguro($_POST['tipoPO']);

//------------------ Buscamos al usuario Solicitante
$sqlEMP = $conexion->select("SELECT * FROM usuarios WHERE usuario LIKE '%".$usu."%' AND nivel = '".$nivel."' AND direccion = '".$direccion."' ",false);
$d = mysql_fetch_array($sqlEMP);
$empbusca =$d['usuario'];
$mostrar = $d['direccion'];
$mostrar1 = $d['nivel'];
$opcion = $d['opciones'];

/* ------------------- CHECKBOX ------------------------*/
/* ------------------- CHECKBOX ------------------------*/
if($po !=""){ $sqlpo="and noempleado LIKE '%".$po."%' "; }
else{$sqlpo="";}

if ($director !="") $sqldirector="and direccion LIKE '".$director."' ";
else $sqldirector="";

if($subdirector != "") $sqlsub="and nivel LIKE '".$subdirector."%' ";
else $sqlsub="";


if  ($edoTram != "" ) $sqledoT= " AND tipo_emp LIKE '%".$edoTram."%' ";
else $sqledoT= "";

if  ($accion != "" ) $sqlvalor= "and  nombre LIKE '%".$accion."%' ";
else $sqlvalor= "";

if  ($ef != "" ) $sqlef= " AND  curp  LIKE '%".$ef."%' ";
else $sqlef= "";

if  ($aud != "" ) $sqlaud= " AND nivel LIKE '%".$aud."%' ";
else  $sqlaud= "";

if  ($cp != "" ) $sqlcp= " AND status  = ".$cp." ";
else $sqlcp= "";

if($fondo !="") $sqlfondo="and genero LIKE '%".$fondo."%' ";
else $sqlfondo="";

if($uaa !="") $sqluaa="and puesto LIKE '%".$uaa."%' ";
else $sqluaa="";

if($jefe_depto !="") $sqljefe="and nivel LIKE  '$jefe_depto%' ";
else $sqljefe="";


//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
	$txtsql="SELECT * FROM usuarios ";
	


//---------- DG vemos todo -----------------------------------------
//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= ' WHERE 1=1 '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqlef.' '.$sqlaud.' '.$sqlcp.' '.$sqljefe.' '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;
//---------- SECRES ven direccion ----------------------------------
elseif($nivel == 'S')
	$txtsql .= 'WHERE direccion LIKE "'.$direccion.'" '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqljefe.' '.$sqlef.' '.$sqlaud.' '.$sqlcp.' AND status != 0 '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;
//---------- ABOGADOS segun nivel ----------------------------------
/*else 
	$txtsql .= ' WHERE nivel LIKE "'.$nivel.'%"  '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqlef.' '.$sqljefe.' '.$sqlaud.' '.$sqlcp.' '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;*/
//--------------------------------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,500 ";
else $limit = $limit;

//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);
$sql = $conexion->select($txtsql." ORDER BY nombre ".$limit ,false);
$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				if($noCh == "true") $tabla .= '<th class="ancho100 blanco">No. Empleado '.$opcion.','.$mostrar1.','.$mostrar.'	</th>';
				$tabla .= '<th class="ancho200 blanco">Nombre	</th>'; 
				if($curpCh == "true") $tabla .= '<th class="ancho150 blanco">Curp </th>';
				if($opcion == "1") {
				if($opcionesCh == "true") $tabla .= '<th class="ancho100 blanco">Usuario</th>';
				if($opcionesCh == "true") $tabla .= '<th class="ancho100 blanco"> Password</th>';
				}
				if($opcion == "1" or $mostrar1 == "S"){
				if($nivelCh == "true") $tabla .= '<th class="ancho50 blanco">Nivel </th>';
				}
				
				if($direccionCh == "true") $tabla .= '<th class="ancho50 blanco">Dirección</th>';
				//if($perfilCh == "true") $tabla .= '<th class="ancho100 blanco">Perfil</th>';				
				//if($opcionesCh == "true") $tabla .= '<th class="ancho50 blanco">Opciones</th>';
				if($statusCh == "true") $tabla .= '<th class="ancho100 blanco">Estatus</th>';
				if($generoCh == "true") $tabla .= '<th class="ancho100 blanco">Género</th>';
				
				if($fecha_ingresoCh == "true") $tabla .= '<th class="ancho100 blanco">Fecha Ingreso</th>';
				if($sustituyeCh == "true") $tabla .= '<th class="ancho200 blanco">Sustituyó</th>';
				if($tipo_empCh == "true") $tabla .= '<th class="ancho200 blanco">Tipo Empleado</th>';
				if($puestoCh == "true") $tabla .= '<th class="ancho200 blanco">Puesto</th>';
				if($fecha_bajaCh == "true") $tabla .= '<th class="ancho100 blanco">Fecha Baja</th>';
				
				if($puesto_antCh == "true") $tabla .= '<th class="ancho300 blanco">Puesto Anterior</th>';
				
							
			$tabla .= '<th class="acciones blanco"></th> 
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
/*	
	$query1="SELECT folio, po.num_accion from  volantes_contenido vc
		INNER JOIN po on po.num_accion=vc.accion
		WHERE po.num_accion= '".$r['num_accion']."'
		ORDER BY fecha_actual desc 
		LIMIT 1";
	
	$sql3=$conexion->select($query1);
	$f=mysql_fetch_array($sql3);
	$volante=$f['folio'];
	*/
//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				if($noCh == "true") $tabla .= '<td class="" align="center">'.$r['noempleado'].'</td>';
				$tabla .= '<td class="" > <strong>'.$r['nombre'].'</strong></td>';
				if($curpCh == "true") $tabla .= '<td class="" align="center">'.$r['curp'].'</td>';
				if($opcion == 1) {
				if($opcionesCh == "true") $tabla .= '<td class="" align="center">'.$r['usuario'].'</td>';
				if($opcionesCh == "true")  $tabla .= '<td class="" align="center">'.$r['password'].'</td>';
				}
				if($opcion == 1 or $mostrar1 == "S"){
				if($nivelCh == "true") $tabla .= '<td class="" align="center">'.$r['nivel'].'</td>';
				}
				
				if($direccionCh == "true") $tabla .= '<td class="" align="center">'.$r['direccion'].'</td>';
				//if($perfilCh == "true") $tabla .= '<td class="" align="center">'.$r['perfil'].'</td>';
				//if($opcionesCh == "true") $tabla .= '<td class="" align="center">'.$r['opciones'].'</td>';
				if($r['status'] == 1) $estat="Activo"; else if ($r['status'] == 0.5) $estat="Activo/Sin Acceso"; else $estat="Inactivo";
				if($statusCh == "true") $tabla .= '<td class="" align="center">'.$estat.'</td>';
				if($r['genero'] == "F" or $r['genero'] == "f") $gen="Femenino"; 
				else if ($r['genero'] == "M" or $r['genero'] == "m") $gen="Masculino"; 
				else $gen="Sin Asignar";
				if($generoCh == "true") $tabla .= '<td class="" align="center">'.$gen.'</td>';
							
				if($fecha_ingresoCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_ingreso']).'</td>';
				if($sustituyeCh == "true") $tabla .= '<td class="" align="center">'.$r['sustituye'].'</td>';
				if($tipo_empCh == "true") $tabla .= '<td class="" align="center">'.$r['tipo_emp'].'</td>';
				if($puestoCh == "true") $tabla .= '<td class="" align="center">'.$r['puesto'].'</td>';				
				if($fecha_bajaCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_baja']).'</td>';
				
				if($puesto_antCh == "true") $tabla .= '<td class="" align="center">'.$r['puesto_ant'].'</td>';
				
			$tabla .= '	<td class="acciones">';

            $tabla .= '</td> </tr>';

}
$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

//if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";
//-------------------------------------------- FIN DE LA CREACIÓN DE TABLA -----------------------------------------
//------------------------------------------------------------------------------------------------------------------
$paginas = ceil($total/1000);
//echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql."|||".$paginas;
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=usuarios_emp.xls");
//$excel=$_REQUEST['export'];
print utf8_decode($tabla);
exit;



//print_r($_REQUEST);
//echo nl2br($txtsql);
//echo "<br><br>".$sql;
//mysql_free_result($sqlT);
//$conexion->desconnectar()
/*mysqli_close($conexion);*/

?>
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
$accion = valorSeguro($_POST['accion']);
//-- superveniente
$superveniente = valorSeguro($_REQUEST['superb']);
//--superveniente
$ef = valorSeguro($_POST['ef']);
$cp = valorSeguro($_POST['cp']);
$aud = valorSeguro($_POST['aud']);
$edoTram = valorSeguro($_POST['edoTram']);
$po=valorSeguro($_POST['pobus']);
$uaa=valorSeguro($_POST['uaa']);
$fondo=valorSeguro($_POST['fondo']);
$director=valorSeguro($_POST['director']);
$subdirector=valorSeguro($_POST['subdirector']);
// lUNES $presunto=valorSeguro($_POST['presunto']);
$edoSicsa=valorSeguro($_POST['edoSicsa']);
// lUNES $fecha=valorSeguro($_POST['fecha']);
// lUNES $anio=valorSeguro($_POST['anio']);
// lUNES $tipo_devolucion=valorSeguro($_POST['tipo_devolucion']);
$direccion =  valorSeguro($_POST['direccion']);
$nivel=  valorSeguro($_POST['nivel']);
$jefe_depto=  valorSeguro($_POST['jefe_depto']);
/* ------------------- CHECKBOX ------------------------*/
$supervenientech =  valorSeguro($_POST['supervenientech']);
//--superveneinte
$cpCh =  valorSeguro($_POST['cpCh']);
$efCh =  valorSeguro($_POST['efCh']);
$direccionCh =  valorSeguro($_POST['direccionCh']);
$subdirectorCh =  valorSeguro($_POST['subdirectorCh']);
$abogadoCh =  valorSeguro($_POST['abogadoCh']);
$fechaIrrCh =  valorSeguro($_POST['fechaIrrCh']);
$termiIrrCh =  valorSeguro($_POST['termiIrrCh']);
$noPliegoCh =  valorSeguro($_POST['noPliegoCh']);
$fechaPiegoCh =  valorSeguro($_POST['fechaPiegoCh']);
$prescripcionCh =  valorSeguro($_POST['prescripcionCh']);
$fondoCh =  valorSeguro($_POST['fondoCh']);
$uaaCh =  valorSeguro($_POST['uaaCh']);
$montoCh =  valorSeguro($_POST['montoCh']);
$etCh =  valorSeguro($_POST['etCh']);
$esCh =  valorSeguro($_POST['esCh']);
$audch =  valorSeguro($_POST['audch']);
$fechaci = valorSeguro($_POST['fechaci']);
$jefe_deptoch = valorSeguro($_POST['jefe_deptoch']);
//lunes  $tipoPO = valorSeguro($_POST['tipoPO']);

/* ------------------- CHECKBOX ------------------------*/
if($po !=""){ $sqlpo="and numero_de_pliego LIKE '%".$po."%' "; }
else{$sqlpo="";}

if($fondo != "") $sqlfondo="and fondo LIKE '%".$fondo."%' ";
else $sqlfondo="";

if ($director !="") $sqldirector="and direccion LIKE '".$director."%' ";
else $sqldirector="";

if($subdirector != "") $sqlsub="and subnivel LIKE '".$subdirector."%' ";
else $sqlsub="";


if  ($edoTram != 0 ) $sqledoT= " AND detalle_de_estado_de_tramite = ".$edoTram." ";
else $sqledoT= "";

if  ($accion != "" ) $sqlvalor= "and  num_accion LIKE '%".$accion."%' ";
else $sqlvalor= "";

if  ($ef != "" ) $sqlef= " AND  entidad_fiscalizada  LIKE '%".$ef."%' ";
else $sqlef= "";

if  ($aud != "" ) $sqlaud= " AND num_auditoria LIKE '%".$aud."%' ";
else  $sqlaud= "";

if  ($cp != 0 ) $sqlcp= " AND cp = ".$cp." ";
else $sqlcp= "";
//--super
if  ($superveniente !="") $sqlsuperveniente= " AND num_accion_po LIKE '%".$superveniente."%' ";
else $sqlsuperveniente="";
//super
/* LUNES if($fecha !=0 and $anio!=0) $sqlfecha="and prescripcion between '".$anio."-".$fecha."-01' and '".$anio."-".$fecha."-31'";
else $sqlfecha="";
*/
if($fondo !="") $sqlfondo="and fondo LIKE '%".$fondo."%' ";
else $sqlfondo="";

if($uaa !="") $sqluaa="and uaa LIKE '%".$uaa."%' ";
else $sqluaa="";

if($jefe_depto !="") $sqljefe="and subnivel LIKE  '$jefe_depto%' ";
else $sqljefe="";

/*Lunes.if($tipoPO == "ampliado") 
	$sqlAmp="and irregularidad LIKE  '%ampliado%' ";
else $sqlAmp=""; */
//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
if($tipo_devolucion !="") {
	$txtsql="SELECT * FROM sa_opiniones ";
	$sqltipo_devolucion="and tipo_devolucion like '%".$tipo_devolucion."%'";
}
else $sqltipo_devolucion="";

if($presunto !="") {
	$txtsql="SELECT * FROM sa_opiniones ";
	$sqlpresunto="and servidor_contratista  LIKE '%".$presunto."%' ";
}
else $sqlpresunto="";

if($presunto == "" && $tipo_devolucion == ""){
	$txtsql="SELECT * FROM sa_opiniones ";
}
else {
	$txtsql="SELECT * FROM sa_opiniones ";
	$sqltipo_devolucion="and tipo_devolucion like '%".$tipo_devolucion."%'";
	$sqlpresunto="and servidor_contratista  LIKE '%".$presunto."%' ";
}

//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= ' WHERE 1=1 '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqlef.' '.$sqlaud.' '.$sqlcp.' '.$sqljefe.' '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp.' '.$sqlsuperveniente;
//---------- SECRES ven direccion ----------------------------------
elseif($nivel == 'S')
	$txtsql .= 'WHERE subnivel LIKE "'.$direccion.'%" '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqljefe.' '.$sqlef.' '.$sqlaud.' '.$sqlcp.' '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp.' '.$sqlsuperveniente;
//---------- ABOGADOS segun nivel ----------------------------------
else 
	$txtsql .= ' WHERE subnivel LIKE "'.$nivel.'%"  '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqlef.' '.$sqljefe.' '.$sqlaud.' '.$sqlcp.' '.$sqledoT.' '.$sqlpo.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlfondo.' '.$sqluaa.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp.' '.$sqlsuperveniente;
//--------------------------------------------------------------------------------------------
if($limit == "") $limit = " LIMIT 0,1000 ";
else $limit = $limit;
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql,false);
$sql = $conexion->select($txtsql." ORDER BY num_accion ".$limit ,false);
$total = mysql_num_rows($sqlT);
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CREACION DE LA TABLA --------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="200%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				//$tabla .= '<th class="ancho300 blanco">  </th>';
				if($efCh == "true") $tabla .= '<th class="ancho300 blanco"> '.$direccion.' Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho200 blanco">Accion	</th>';
				
				//-superveniente
				if($supervenientech == "true") $tabla .= '<th class="ancho100 blanco">superveniente</th>';
				//-sueprveniente
				if($noPliegoCh == "true") $tabla .= '<th class="ancho100 blanco">No. Pliego</th>';
				if($cpCh == "true") $tabla .= '<th class="ancho50 blanco">Cuenta Pública</th>';
				if($audch == "true") $tabla .= '<th class="ancho50 blanco">Auditoria </th>';
				if($uaaCh == "true") $tabla .= '<th class="ancho100 blanco">UAA</th>';
				if($fondoCh == "true") $tabla .= '<th class="ancho100 blanco">Fondo</th>';				
				if($direccionCh == "true") $tabla .= '<th class="ancho50 blanco">Direccion</th>';
				if($subdirectorCh == "true") $tabla .= '<th class="ancho200 blanco">Subdirector</th>';
				if($jefe_deptoch == "true") $tabla .= '<th class="ancho200 blanco">Jefe de Departamento</th>';
				if($abogadoCh == "true") $tabla .= '<th class="ancho200 blanco">Abogado</th>';
				if($esCh == "true") $tabla .= '<th class="ancho200 blanco">Estado SICSA</th>';
				if($etCh == "true") $tabla .= '<th class="ancho300 blanco">Control Interno</th>';
				$tabla .= '<th class="ancho100 blanco">Fecha de Ultimo Movimiento	</th>';			
				if($prescripcionCh == "true") $tabla .= '<th class="ancho100 blanco">Prescripción</th>';
				if($montoCh == "true") $tabla .= '<th class="ancho100 blanco">Monto</th>';
				$tabla .= '<th class="ancho100 blanco">Volante</th>';
							
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
				
				//$tabla .= '<td class="">'.$limit.'</td>';
				if($efCh == "true") $tabla .= '<td class="">'.$r['entidad_fiscalizada'].'</td>';
				$tabla .= '
				<td class="" align="center"><span title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >'.trim(str_replace($accion,"<span class='b'>".$accion."</span>",$r['num_accion'])).'</span></td>';
				if($noPliegoCh == "true") $tabla .= '<td class="" align="center">'.$r['numero_de_pliego'].'</td>';
				if($cpCh == "true") $tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				if($audch == "true") $tabla .= '<td class="">'.$r['num_auditoria'].'</td>';
				if($uaaCh == "true") $tabla .= '<td class="" align="center">'.$r['UAA'].'</td>';
				//---superveniente
				if($supervenientech == "true") $tabla .= '<td class="" align="center">'.$r['num_accion_po'].'</td>';
				//---superveniente
				if($fondoCh == "true") $tabla .= '<td class="" align="center">'.$r['fondo'].'</td>';
				if($direccionCh == "true") $tabla .= '<td class="" align="center">'.$nivPart[0].'</td>';
				if($subdirectorCh == "true") $tabla .= '<td class="">'.$subdirector.'</td>';
				if($jefe_deptoch == "true") $tabla .= '<td class="">'.$jefe.'</td>';
				if($abogadoCh == "true") $tabla .= '<td class="">'.$r['abogado'].'</td>';
				if($esCh == "true") $tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_de_estado_de_tramite']).'</td>';
				if($etCh == "true") $tabla .= '<td class="">'.dameEstado($r['detalle_de_estado_de_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_estado_tramite']).'</td>';
				if($fechaIrrCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				
				if($prescripcionCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				
				
				if($montoCh == "true") $tabla .= '<td class="" align="right">'.@number_format($r['monto_de_po_en_pesos'],2).'</td>';
				$tabla .= '<td class="" align="center">'.$volante.'</td>';

				if($fechaci=="true") $tabla .='<th class="align="right">>'.$r['fecha_estado_tramite'].'</td>';


			$tabla .= '	<td class="acciones">';
			
			if($reports != 1)
			{
				$tabla .= '<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",20,"cont/po_informacion.php","numAccion='.$r['num_accion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadrox1 = new mostrarCuadro(500,1100,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos" class="icon-6 info-tooltip" onclick=\'var cuadrox2 = new mostrarCuadro(550,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",30,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadrox3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).' ",50,"cont/po_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
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

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


$nor=valorSeguro($_REQUEST['nor']);
$actor = valorSeguro($_REQUEST['actor']);
$nop = valorSeguro($_REQUEST['nop']);
$ef = valorSeguro($_REQUEST['ef']);

$cp = valorSeguro($_REQUEST['cp']);
$abo = valorSeguro($_REQUEST['abo']);
$edoTram = valorSeguro($_REQUEST['edoTram']);

$pdr=valorSeguro($_REQUEST['pdr']);
$ckl=valorSeguro($_REQUEST['ckl']);
$director=valorSeguro($_REQUEST['director']);
$subdirector=valorSeguro($_REQUEST['subdirector']);
// lUNES $presunto=valorSeguro($_POST['presunto']);
$edoSicsa=valorSeguro($_REQUEST['edoSicsa']);
// lUNES $fecha=valorSeguro($_POST['fecha']);
// lUNES $anio=valorSeguro($_POST['anio']);
// lUNES $tipo_devolucion=valorSeguro($_POST['tipo_devolucion']);
$direccion =  valorSeguro($_REQUEST['direccion']);
$nivel=  valorSeguro($_REQUEST['nivel']);
$jefe_depto=  valorSeguro($_REQUEST['jefe_depto']);
/* ------------------- CHECKBOX ------------------------*/
$actorCh =  valorSeguro($_REQUEST['actorCh']);
$noCh =  valorSeguro($_REQUEST['noCh']);
$nopCh =  valorSeguro($_REQUEST['nopCh']);
//--superveneinte
$cpCh =  valorSeguro($_REQUEST['cpCh']);

$direccionCh =  valorSeguro($_REQUEST['direccionCh']);
$subdirectorCh =  valorSeguro($_REQUEST['subdirectorCh']);
$abogadoCh =  valorSeguro($_REQUEST['abogadoCh']);
$fechaIrrCh =  valorSeguro($_REQUEST['fechaIrrCh']);
$termiIrrCh =  valorSeguro($_REQUEST['termiIrrCh']);
$entidadCh =  valorSeguro($_REQUEST['entidadCh']);
$fechaPiegoCh =  valorSeguro($_REQUEST['fechaPiegoCh']);
$prescripcionCh =  valorSeguro($_REQUEST['prescripcionCh']);
$pdrCh =  valorSeguro($_REQUEST['pdrCh']);
$taCh =  valorSeguro($_REQUEST['taCh']);
$montoCh =  valorSeguro($_REQUEST['montoCh']);
$etCh =  valorSeguro($_REQUEST['etCh']);
$esCh =  valorSeguro($_REQUEST['esCh']);
$faCh =  valorSeguro($_REQUEST['faCh']);
$naCh =  valorSeguro($_REQUEST['naCh']);
$fechaci = valorSeguro($_REQUEST['fechaci']);
$jefe_deptoch = valorSeguro($_REQUEST['jefe_deptoch']);
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
if($nor !=""){ $sqlnor="and recurso_reconsideracion LIKE '%".$nor."%' "; }
else{$sqlnor="";}

if ($ckl != "") $sqlckl="and check_list LIKE '".$ckl."%' ";
else $sqlckl="";

if ($director !="") $sqldirector="and direccion LIKE '".$director."%' ";
else $sqldirector="";

if($subdirector != "") $sqlsub="and subnivel LIKE '".$subdirector."%' ";
else $sqlsub="";


if  ($edoTram != 0 ) $sqledoT= " AND detalle_edo_tramite = ".$edoTram." ";
else $sqledoT= "";

if  ($accion != "" ) $sqlvalor= "and  num_accion LIKE '%".$accion."%' ";
else $sqlvalor= "";

if  ($nop != "" ) $sqlnop= " AND  num_procedimiento  LIKE '%".$nop."%' ";
else $sqlnop= "";

if  ($ef != "" ) $sqlef= " AND  entidad  LIKE '%".$ef."%' ";
else $sqlef= "";

if  ($abo != "" ) $sqlaud= " AND abogado LIKE '%".$abo."%' ";
else  $sqlaud= "";

if  ($cp != 0 ) $sqlcp= " AND cp = ".$cp." ";
else $sqlcp= "";
//--super
if  ($actor !="") $sqlsuperv= " AND actor LIKE '%".$actor."%' ";
else $sqlsuperv="";
//super
/* LUNES if($fecha !=0 and $anio!=0) $sqlfecha="and prescripcion between '".$anio."-".$fecha."-01' and '".$anio."-".$fecha."-31'";
else $sqlfecha="";
*/

if($pdr !="") $sqlpdr="and PDR LIKE '%".$pdr."%' ";
else $sqlpdr="";

if($jefe_depto !="") $sqljefe="and subnivel LIKE  '$jefe_depto%' ";
else $sqljefe="";

/*Lunes.if($tipoPO == "ampliado") 
	$sqlAmp="and irregularidad LIKE  '%ampliado%' ";
else $sqlAmp=""; */
//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------

//----------------------------- TIPO DE CONSULTA CON VISTAS ---------------------------------
	$txtsql="SELECT * FROM actores_recurso ";
	


//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= ' WHERE 1=1 '.$sqlvalor.' '.$sqledo.' '.$sqlsub.' '.$sqlsuperv.' '.$sqlef.' '.$sqlnop.''.$sqlaud.' '.$sqlcp.' '.$sqljefe.' '.$sqledoT.' '.$sqlnor.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlckl.' '.$sqlpdr.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;
//---------- SECRES ven direccion ----------------------------------
elseif($nivel == 'S')
	$txtsql .= 'WHERE subnivel LIKE "'.$direccion.'%" '.$sqlvalor.' '.$sqledo.''.$sqlsuperv.' '.$sqlsub.' '.$sqljefe.' '.$sqlef.''.$sqlnop.' '.$sqlaud.' '.$sqlcp.' '.$sqledoT.' '.$sqlnor.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlckl.' '.$sqlpdr.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;
//---------- ABOGADOS segun nivel ----------------------------------
else 
	$txtsql .= ' WHERE subnivel LIKE "'.$nivel.'%"  '.$sqlvalor.' '.$sqledo.''.$sqlsuperv.' '.$sqlsub.' '.$sqlef.' '.$sqlnop.''.$sqljefe.' '.$sqlaud.' '.$sqlcp.' '.$sqledoT.' '.$sqlnor.' '.$sqlSicsa.' '.$sqlfecha.' '.$sqlpresunto.' '.$sqlckl.' '.$sqlpdr.' '.$sqldirector.' '.$sqltipo_devolucion.' '.$sqlAmp;
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
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				//$tabla .= '<th class="ancho300 blanco">  </th>';
				//if($efCh == "true") $tabla .= '<th class="ancho300 blanco"> '.$direccion.' Entidad Fiscalizada</th>';
				if($noCh == "true") $tabla .= '<th class="ancho200 blanco">No. Recurso	</th>';
				$tabla .= '<th class="ancho200 blanco">Accion	</th>'; 
				if($actorCh == "true") $tabla .= '<th class="ancho300 blanco">Actor	</th>';
				if($nopCh == "true") $tabla .= '<th class="ancho200 blanco">No. Procedimiento	</th>';
				if($entidadCh == "true") $tabla .= '<th class="ancho200 blanco">Entidad Fiscalizada</th>';
				
				if($cpCh == "true") $tabla .= '<th class="ancho50 blanco">Cuenta Pública</th>';				
				if($taCh == "true") $tabla .= '<th class="ancho100 blanco">Tipo Acuerdo</th>';
				if($faCh == "true") $tabla .= '<th class="ancho100 blanco">Fecha Acuerdo</th>';
				if($naCh == "true") $tabla .= '<th class="ancho100 blanco">Notificación Acuerdo</th>';
				if($pdrCh == "true") $tabla .= '<th class="ancho100 blanco">PDR</th>';				
				if($direccionCh == "true") $tabla .= '<th class="ancho50 blanco">Direccion</th>';
				if($subdirectorCh == "true") $tabla .= '<th class="ancho200 blanco">Subdirector</th>';
				if($jefe_deptoch == "true") $tabla .= '<th class="ancho200 blanco">Jefe de Departamento</th>';
				if($abogadoCh == "true") $tabla .= '<th class="ancho200 blanco">Abogado</th>';
				if($esCh == "true") $tabla .= '<th class="ancho200 blanco">Estado SICSA</th>';
				if($etCh == "true") $tabla .= '<th class="ancho200 blanco">Control Interno</th>';
				$tabla .= '<th class="ancho100 blanco">Fecha Resolución</th>';	
				$tabla .= '<th class="ancho100 blanco">Fecha notificación Resolución</th>';			
				// if($prescripcionCh == "true") $tabla .= '<th class="ancho100 blanco">Prescripción</th>';
				if($montoCh == "true") $tabla .= '<th class="ancho100 blanco">Monto</th>';
				// $tabla .= '<th class="ancho100 blanco">Volante</th>';
							
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
				
               if($noCh == "true") $tabla .= '<td class= "" align="center">'.$r['recurso_reconsideracion'].'</td>';
				
				//<td class="" align="center"><span title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_de_estado_de_tramite']).'",50,"cont/po_bitacora.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >'.trim(str_replace($accion,"<span class='b'>".$accion."</span>",$r['num_accion'])).'</span></td>';
			    $tabla .= '<td class= "" align="center">'.$r['num_accion'].'</td>';
				if($actorCh == "true") $tabla .= '<td class="" align="center">'.$r['actor'].'</td>';
				if($nopCh == "true") $tabla .= '<td class="" align="center">'.$r['num_procedimiento'].'</td>';				
				if($entidadCh == "true") $tabla .= '<td class="" align="center">'.$r['entidad'].'</td>';
				
				if($cpCh == "true") $tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				if($taCh == "true") $tabla .= '<td class="" align="center">'.$r['tipo_acuerdo'].'</td>';
				if($faCh == "true") $tabla .= '<td class="" align="center"> '.$r['fecha_de_acuerdo'].'</td>';
				if($naCh == "true") $tabla .= '<td class="" align="center"> '.$r['not_acuerdo'].'</td>';
				//---superveniente
				//--if($supervenientech == "true") $tabla .= '<td class="" align="center">'.$r['num_accion_po'].'</td>';
				//---superveniente
				if($pdrCh == "true") $tabla .= '<td class="" align="center">'.$r['PDR'].'</td>';
				if($direccionCh == "true") $tabla .= '<td class="" align="center">'.$nivSbd.'</td>';
				if($subdirectorCh == "true") $tabla .= '<td class="">'.$subdirector.'</td>';
				if($jefe_deptoch == "true") $tabla .= '<td class="">'.$jefe.'</td>';
				if($abogadoCh == "true") $tabla .= '<td class="">'.$r['abogado'].'</td>';
				if($esCh == "true") $tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_de_estado_de_tramite']).'</td>';
				if($etCh == "true") $tabla .= '<td class="" align="center">'.dameEstado($r['detalle_edo_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_resolucion']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_notificacion_resolucion_rr']).'</td>';
				//if($fechaIrrCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				
				// if($prescripcionCh == "true") $tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				
				
				if($montoCh == "true") $tabla .= '<td class="" align="right">'.@number_format($r['monto'],2).'</td>';
				// $tabla .= '<td class="" align="center">'.$volante.'</td>';

				//if($fechaci=="true") $tabla .='<th class="align="right">>'.$r['fecha_estado_tramite'].'</td>';


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
header("Content-disposition: attachment; filename=actores_recurso.xls");
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
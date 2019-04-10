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
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
foreach($_POST as $nombre_campo => $valor)
{
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
}
//echo "\n\n Acciones: ".$acciones."\n\n ";

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------




/*$reports = valorSeguro($_POST['reports']);
$accion = valorSeguro($_POST['accion']);
$ef = valorSeguro($_POST['ef']);
$cp = valorSeguro($_POST['cp']);
$aud = valorSeguro($_POST['aud']);
$edoTram = valorSeguro($_POST['edoTram']);
$po=valorSeguro($_POST['pobus']);
$uaa=valorSeguro($_POST['uaa']);
$fondo=valorSeguro($_POST['fondo']);
$director=valorSeguro($_POST['director']);
$subdirector=valorSeguro($_POST['subdirector']);
$presunto=valorSeguro($_POST['presunto']);
$edoSicsa=valorSeguro($_POST['edoSicsa']);
$fecha=valorSeguro($_POST['fecha']);
$anio=valorSeguro($_POST['anio']);
$tipo_devolucion=valorSeguro($_POST['tipo_devolucion']);
$limit = valorSeguro($_POST['limit']);
$direccion =  valorSeguro($_POST['direccion']);
$nivel=  valorSeguro($_POST['nivel']);
$pdr=  valorSeguro($_POST['pdr']);
$pfrr=  valorSeguro($_POST['pfrr']);
 ------------------- CHECKBOX ------------------------
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
$pdrch =  valorSeguro($_POST['pdrch']);
$pfrrch =  valorSeguro($_POST['pfrrch']);
$fechaci = valorSeguro($_POST['fechaci']);

/* ------------------- CHECKBOX ------------------------*/


if($limit == "") $limit = " limit 0,50 ";
else $limit = valorSeguro($_POST['limit']);
$limit = "";

if($tipo_devolucion !="") $sqltipo_devolucion="and tipo_devolucion like '%".$tipo_devolucion."%'";
else $sqltipo_devolucion="";

if($tipo_abs !="") $sqltipo_abs="and tipo_abs like '%".$tipo_abs."%'";
else $sqltipo_abs="";

if($pobus !=""){ $sqlpo="and po like '%".$pobus."%' "; }
else{$sqlpo="";}

if($uaa != ""){$sqluaa="and UAA LIKE '%".$uaa."%' ";}
else {	$sqluaa="";	}
			
if($fondo != "") $sqlfondo="and fondo LIKE '%".$fondo."%' ";
else $sqlfondo="";

if ($director !="") $sqldirector="and subnivel LIKE '%".$director."%' ";
else $sqldirector="";

if($subdirector != "") $sqlsub="and subnivel LIKE '".$subdirector."%' ";
else $sqlsub="";

if($presunto !="") $sqlpresunto="and pfrr_presuntos_audiencias.servidor_contratista  LIKE '%".$presunto."%' ";
else $sqlpresunto="";

if  ($edoTram != 0 ) $sqledoT= " AND detalle_edo_tramite = ".$edoTram." ";
else $sqledoT= "";

if  ($noAccion != "" ) $sqlvalor= "and  pfrr.num_accion LIKE '%".$noAccion."%' ";
else $sqlvalor= "";

if  ($ef != "" ) $sqlef= " AND  entidad  LIKE '%".$ef."%' ";
else $sqlef= "";

if  ($aud != "" ) $sqlaud= " AND auditoria LIKE '%".$aud."%' ";
else  $sqlaud= "";

if  ($cp != 0 ) $sqlcp= " AND cp = ".$cp." ";
else $sqlcp= "";

if($fecha !=0 and $anio!=0) $sqlfecha="and prescripcion between '".$anio."-".$fecha."-01' and '".$anio."-".$fecha."-31'";
else $sqlfecha="";

if($fondo !="") $sqlfondo="and fondos.fondo LIKE '%".$fondo."%' ";
else $sqlfondo="";

if($uaa !="") $sqluaa="and fondos.uaa LIKE '%".$uaa."%' ";
else $sqluaa="";



if($pdr !="") $sqlpdr="and pdr  LIKE '%".$pdr."%'";
else $sqluaa="";

if($pfrr !="") $sqlpfrr="and num_procedimiento LIKE '%".$pfrr."%' ";
else $sqluaa="";

if($superveniente !="") $sqlsuperveniente="and superveniente LIKE '%".$superveniente."%' ";
else $sqlsuperveniente="";

if($acu_inicio !="") $sqlacu_inicio="and fecha_acuerdo_inicio LIKE '%".fechaMysql($acu_inicio)."%' ";
else $sqlacu_inicio="";

if($ult_actu !="") $sqlult_act="and fecha_analisis_documentacion '%".fechaMysql($ult_actu)."%'";
else $sqlult_actu="";

if($cierre_ins !="") $sqlcie_ins="and cierre_instruccion LIKE '%".fechaMysql($cierre_ins)."%' ";
else $sqlcierre_ins="";


if($lim_emi_res !="") $sqllim_emi_res="and limite_emision_resolucion LIKE '%".fechaMysql($lim_emi_res)."%' ";
else $sqllim_emi_res="";

if($emi_res !="") $sqlemi_res="and resolucion LIKE '%".fechaMysql($emi_res)."%' ";
else $sqlemi_res="";




if($noti_res !="") $sqlnoti_res="and fecha_notificacion_resolucion  LIKE '%".fechaMysql($noti_res)."%'";
else $sqlnoti_res="";

if($lim_noti_res !="") $sqllim_not_res="and limite_notificacion_resolucion LIKE '%".fechaMysql($lim_not_res)."%' ";
else $sqllim_not_res="";

if($jefe_depto !="") $sqljefe="and subnivel LIKE  '$jefe_depto%' ";
else $sqljefe="";




//--------------------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
$txtsql="SELECT
			pfrr.*,
			pfrr.num_accion pona, 
			entidad,
			auditoria, 
			cp, 
			subdirector,
			monto_no_solventado, 
			abogado, 
			detalle_edo_tramite";
			
if($tipo_abs !="") 	$txtsql .= " pfrr_historial.num_accion, pfrr_historial.tipo_abs,";


$txtsql="SELECT
			pfrr.*,
			pfrr.num_accion pona, 
			entidad,
			auditoria, 
			cp, 
			subdirector,
			monto_no_solventado, 
			abogado, 
			detalle_edo_tramite, 
			po,
			prescripcion,"; 

if($presunto != "") 		$txtsql .= " pfrr_presuntos_audiencias.num_accion, ";
if($tipo_devolucion !="") 	$txtsql .= " pfrr_historial.num_accion, pfrr_historial.tipo_devolucion,";

$txtsql .=	"fondos.num_accion, 
			fondos.uaa UAA,
			fondos.fondo Fondo
		  FROM pfrr 
		  LEFT JOIN fondos on pfrr.num_accion = fondos.num_accion ";
		  
if($sqltipo_abs != "") 		$txtsql .= " INNER JOIN pfrr_presuntos_audiencias  on  pfrr.num_accion = pfrr_presuntos_audiencias.num_accion "; 
if($tipo_devolucion !="") 	$txtsql .= " INNER JOIN pfrr_historial on pfrr.num_accion = pfrr_historial.num_accion ";
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
//---------- DG vemos todo -----------------------------------------
if($direccion == 'DG')
	$txtsql .= " WHERE 1=1 $sqlvalor $sqledo $sqlsub $sqlef  $sqlaud $sqlemi_res  $sqljefe $sqlnoti_res $sqllim_not_res  $sqlcp $sqllim_emi_res  $sqlcie_ins $sqledoT $sqlult_act $sqlpo $sqlacu_inicio $sqlSicsa $sqlsuperveniente $sqlfecha $sqlpresunto $sqlfondo $sqluaa $sqldirector  $sqltipo_devolucion $sqlpdr $sqlpfrr $sqltipo_abs";
//---------- SECRES ven direccion ----------------------------------
elseif($nivel == 'S')
	$txtsql .= " WHERE pfrr.subnivel LIKE '".$direccion."%'  $sqlvalor  $sqlemi_res $sqljefe $sqlnoti_res $sqllim_not_res $sqledo $sqllim_emi_res $sqlcie_ins $sqlsub $sqlult_act $sqlef  $sqlacu_inicio $sqlaud $sqlsuperveniente $sqlcp  $sqledoT $sqlpo $sqlSicsa $sqlfecha $sqlpresunto $sqlfondo $sqluaa $sqldirector  $sqltipo_devolucion $sqlpdr $sqlpfrr $sqltipo_abs";
//---------- ABOGADOS segun nivel ----------------------------------
else 
	$txtsql .= " WHERE pfrr.subnivel LIKE '".$nivel."%'  $sqlvalor $sqledo   $sqlemi_res $sqljefe $sqlnoti_res $sqllim_not_res $sqlsub $sqllim_emi_res $sqlcie_ins $sqlef  $sqlaud $sqlacu_inicio $sqlcp $sqlsuperveniente $sqledoT $sqlpo $sqlSicsa $sqlfecha $sqlpresunto $sqlfondo $sqluaa $sqldirector  $sqltipo_devolucion $sqlpdr $sqlpfrr $sqltipo_abs";
//--------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------
$sqlT = $conexion->select($txtsql." ORDER BY pfrr.num_accion ",false);
//$sql = $conexion->select($txtsql." ".$limit ,false);
$total = mysql_num_rows($sqlT);

$a=$montos['reintegrado'];
$b=$montos['intereses'];
$c=$a+$b;
//--------------------------------------------------------------------------------------------
$tabla = '
		<div style="overflow:auto;  width:100%; height:400px">
		<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
				if($efCh == "on") $tabla .= '<th class="ancho300 blanco">Entidad Fiscalizada</th>';
				$tabla .= '<th class="ancho200 blanco">Accion	</th>';
				if($superCh == "on") $tabla .= '<th class="ancho200 blanco">Superveniente</th>';
				if($pfrrch == "on") $tabla .= '<th class="ancho200 blanco">Número de procedimiento</th>';
				if($pdrch == "on") $tabla .= '<th class="ancho100 blanco">PDR</th>';
				if($noPliegoCh == "on") $tabla .= '<th class="ancho100 blanco">No. Pliego</th>';
				if($cpCh == "on") $tabla .= '<th class="ancho50 blanco">Cuenta Pública</th>';
				if($audch == "on") $tabla .= '<th class="ancho50 blanco">Auditoria </th>';
				if($uaaCh == "on") $tabla .= '<th class="ancho100 blanco">UAA</th>';
				if($fondoCh == "on") $tabla .= '<th class="ancho100 blanco">Fondo</th>';
				if($direccionCh == "on") $tabla .= '<th class="ancho50 blanco">Direccion</th>';
				if($subdirectorCh == "on") $tabla .= '<th class="ancho200 blanco">Subdirector</th>';
				if($jefe_deptoch == "on") $tabla .= '<th class="ancho150 blanco">Jefe de Departamento</th>';
				if($abogadoCh == "on") $tabla .= '<th class="ancho200 blanco">Abogado</th>';
				if($esCh == "on") $tabla .= '<th class="ancho200 blanco">Estado SICSA</th>';
				if($etCh == "on") $tabla .= '<th class="ancho300 blanco">Control Interno</th>';
				$tabla .= '<th class="ancho100 blanco">Fecha de Ultimo Movimiento	</th>';
				if($prescripcionCh == "on") $tabla .= '<th class="ancho100 blanco">Prescripción</th>';
  				if($acu_iniCh == "on") $tabla .= '<th class="ancho100 blanco">Fecha Acuerdo de Inicio</th>';
				if($ul_actCh == "on") $tabla .= '<th class="ancho100 blanco">Fecha Ultima Actuación</th>';
				if($cie_insCh == "on") $tabla .= '<th class="ancho100 blanco">Fecha de Cierre de Instrucción</th>';
				if($lim_emi_resCh == "on") $tabla .= '<th class="ancho100 blanco">Limite de Emisión de la Resolución</th>';
				if($emi_resCh == "on") $tabla .= '<th class="ancho100 blanco">Fecha de Emisión de la Resolución</th>';
				if($lim_not_resCh == "on") $tabla .= '<th class="ancho100 blanco">Limite de Notificación de la Resolución</th>';
				if($not_resCh == "on") $tabla .= '<th class="ancho100 blanco">Notificación de la Resolución</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">Monto Modificado UAA</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">Monto FRR</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">R Importe del Daño</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">R Importe Aclarado</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">R Importe Reintegrado</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">R Importe Intereses</th>';
				if($montoCh == "on") $tabla .= '<th class="ancho100 blanco">Importe Reintegrado</th>';
				if($fechaIrrCh == "on") $tabla .= '<th class="ancho100 blanco">Fecha Irregularidad</th>';
				if($inicioCh == "on") $tabla .= '<th class="ancho100 blanco">Monto de Inicio</th>';
				if($ampCh == "on") $tabla .= '<th class="ancho200 blanco">Ampliado</th>';
	
			$tabla .= '<th class="acciones blanco">Seguimiento</th> 
					</tr>
				</thead>

';

while($r = mysql_fetch_array($sqlT))
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
	
	$montos = importesXaccion($r['num_accion']);
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO pfrr SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
				if($efCh == "on") $tabla .= '<td class="">'.$r['entidad'].'</td>';
				$tabla .= '
				<td class="" align="center">
				<span" title="Ver Bitacora" onclick=\'var cuadro1 = new mostrarCuadro2(500,1000,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,"cont/pfrr_bitacora.php","numAccion='.trim($r['num_accion']).'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\' >
						'.str_replace($accion,"<span class='b'>".$accion."</span>",$r['pona']).'
				</span>
				</td>';
				if($superCh == "on") $tabla .= '<td class="align="right">'.$r['superveniente'].'</td>';
				if($pfrrch == "on") $tabla .= '<td class="" align="right">'.$r['num_procedimiento'].'</td>';
				if($pdrch == "on") $tabla .= '<td class="" align="right">'.$r['PDR'].'</td>';
				if($noPliegoCh == "on") $tabla .= '<td class="" align="center">'.$r['po'].'</td>';
				if($cpCh == "on") $tabla .= '<td class="" align="center">'.$r['cp'].'</td>';
				if($audch == "on") $tabla .= '<td class="">'.$r['auditoria'].'</td>';
				if($uaaCh == "on") $tabla .= '<td class="" align="center">'.$r['UAA'].'</td>';
				if($fondoCh == "on") $tabla .= '<td class="" align="center">'.$r['Fondo'].'</td>';
				if($direccionCh == "on") $tabla .= '<td class="" align="center">'.$nivPart[0].'</td>';
				if($subdirectorCh == "on") $tabla .= '<td class="">'.$subdirector.'</td>';
				if($jefe_deptoch == "on") $tabla .= '<td class="" align="center">'.$jefe.'</td>';
				if($abogadoCh == "on") $tabla .= '<td class="">'.$r['abogado'].'</td>';
				if($esCh == "on") $tabla .= '<td class="">'.dameEstadoSicsa($r['detalle_edo_tramite']).'</td>';
				if($etCh == "on") $tabla .= '<td class="">'.dameEstado($r['detalle_edo_tramite']).'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_edo_tramite']).'</td>';
				if($prescripcionCh == "on") $tabla .= '<td class="" align="center">'.fechaNormal($r['prescripcion']).'</td>';
				if($acu_iniCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_acuerdo_inicio']).'</td>';
				if($ul_actCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_analisis_documentacion']).'
</td>';
				if($cie_insCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['cierre_instruccion']).'</td>';
				if($lim_emi_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['limite_emision_resolucion']).'</td>';
				if($emi_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['resolucion']).'</td>';
				if($lim_not_resCh== "on") $tabla .= '<td class="align="right">'.fechaNormal($r['limite_notificacion_resolucion']).'</td>';
				if($not_resCh == "on") $tabla .= '<td class="align="right">'.fechaNormal($r['fecha_notificacion_resolucion']).'</td>';
				if($fechaIrrCh == "on") $tabla .= '<td class="" align="center">'.fechaNormal($r['fecha_de_irregularidad_general']).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado_UAA'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($r['monto_no_solventado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['montoPre'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['aclarado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['reintegrado'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($montos['intereses'],2).'</td>';
				if($montoCh == "on") $tabla .= '<td class="" align="right">'.@number_format($c=$montos['reintegrado']+$montos['intereses']).'</td>';
				if($fechaci=="on") $tabla .='<td class="align="right">'.$r['fecha_estado_tramite'].'</td>';
				if($inicioCh=="on") $tabla .='<td class="align="right">'.$r['inicio_frr'].'</td>';
				if($ampCh == "on") $tabla .= '<td class="" align="right">'.$r['ampliados'].'</td>';	

			$tabla .= '	<td class="acciones">';
			
			if($reports != 1)
			{
				$tabla .= '<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900,"'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",20,"cont/pfrr_informacion.php","numAccion='.$r['pona'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadrox1 = new mostrarCuadro(500,1200,"'.$r['pona'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,"cont/pfrr_proceso.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Presuntos" class="icon-6 info-tooltip" onclick=\'var cuadrox2 = new mostrarCuadro(550,1200,"'.$r['pona'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",30,"cont/pfrr_presuntos.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
				if($nivel != "S" and $nivel != "A.1.1.9" and $nivel != "B.1.1.9" and $nivel != "C.1.1.9" and $nivel != "D.1.1.9") $tabla .= '<a href="#" title="Autoridades" class="icon-7 info-tooltip" onclick=\'var cuadrox3 = new mostrarCuadro(500,1000," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).' ",50,"cont/pfrr_autoridades.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';
			}
			$tabla .= '</td> </tr>';
}
	$tabla .= '
			</tbody>
            </table>
			</div>
            <!--  end product-table................................... --> 
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados  </h3></center>";

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
$paginas = ceil($total/1000);
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||".$paginas;


print_r($_POST);
echo nl2br($txtsql);
//echo "<br><br>".$sql;
mysql_free_result($sql);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

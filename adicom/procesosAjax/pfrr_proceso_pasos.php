<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$vUsuario = valorSeguro($_REQUEST['user']);
$vFecha = valorSeguro($_REQUEST['fecha']);
$vHora = valorSeguro($_REQUEST['hora']);
//----------------------------------------Asistencia-----------------------
//----------------------------------------Asistencia-----------------------
if ($_POST["proceso"]=="asistencia")
{
	$oficio_de_devoluciondtns=valorSeguro($_POST['oficio_de_devoluciondtns']);
	$fechadev=fechaMysql(valorSeguro($_POST['fechadev']));
	$acusedev=fechaMysql(valorSeguro($_POST['acusedev']));
	$num_accion=valorSeguro($_POST['num_accion']);
	
	$inexistencia=valorSeguro($_POST['inexistencia']);
	$docu_soporte=valorSeguro($_POST['docu_soporte']);
	$irregularidad=valorSeguro($_POST['irregularidad']);
	$monto_no_preciso=valorSeguro($_POST['monto_no_preciso']);
	$mezcla=valorSeguro($_POST['mezcla']);
	$papeles=valorSeguro($_POST['papeles']);
	$docu_irre=valorSeguro($_POST['docu_irre']);
	$datos=valorSeguro($_POST['datos']);
	$ilegible=valorSeguro($_POST['ilegible']);
	$indebida_fun=valorSeguro($_POST['indebida_fun']);
	$presun_resp=valorSeguro($_POST['presun_resp']);
	$inadecuada=valorSeguro($_POST['inadecuada']);
	$solUAAsolventacion=valorSeguro($_POST['solUAAsolventacion']);
	$validacionUAA==valorSeguro($_POST['validacionUAA']);
	$cien==valorSeguro($_POST['cien']);
	$otrostxt=valorSeguro($_POST['otrostxt']);
	$otros=valorSeguro($_POST['otros']);
	
	$juridico=valorSeguro($_POST['juridico']);
	$usuario = valorSeguro($_POST['user']);
	
	if($inexistencia=="on") $tipo_devolucion.="inexistencia|";
	if($inexistencia=="on") $tipo_devolucion.="otros|";
	if($docu_soporte=="on") $tipo_devolucion.="docu_soporte|";
	if($irregularidad=="on") $tipo_devolucion.="irregularidad|";
	if($monto_no_preciso=="on") $tipo_devolucion.="monto_no_preciso|";
	if($mezcla=="on") $tipo_devolucion.="mezcla|";
	if($papeles=="on") $tipo_devolucion.="papeles|";
	if($docu_irre=="on") $tipo_devolucion.="docu_irre|";
	if($datos=="on") $tipo_devolucion.="datos|";
	if($ilegible=="on") $tipo_devolucion.="ilegible|";
	if($indebida_fun=="on") $tipo_devolucion.="indebida_fun|";
	if($presun_resp=="on") $tipo_devolucion.="presun_resp|";
	if($inadecuada=="on") $tipo_devolucion.="inadecuada|";
	if($solUAAsolventacion=="on") $tipo_devolucion.="solUAAsolventacion|";
	if($validacionUAA=="on") $tipo_devolucion.="validacionUAA |";
	if($cien=="on") $tipo_devolucion.="cien|";
	if($otros=="on") $tipo_devolucion.="otros¬¬.$otrostxt|";
	
		
	//actualizamos oficio y estadpo de tramite
	$sql = $conexion->update("UPDATE oficios SET juridico ='0' WHERE folio = '".$oficio_de_devoluciondtns."'" , false);
	$sql = $conexion->update("UPDATE oficios_contenido SET juridico ='0' WHERE folio = '".$oficio_de_devoluciondtns."' AND num_accion = '".$num_accion."' " , false);
	
	$sql = $conexion->update("UPDATE pfrr SET detalle_edo_tramite= '13',fecha_edo_tramite = '".date('Y-m-d')."',usuario='".$usuario."',hora = '".date('h:i:s')."' WHERE num_accion = '".$num_accion."'" ,false);	
	//lo insertamos al historial

		$sqltxt = "INSERT INTO pfrr_historial 
			SET 
			 num_accion = '".$num_accion."',
			 tipo = 'asistencia',	
			 oficio	= '".$oficio_de_devoluciondtns."',
			 oficioRecepcion = '".$fechadev."',
			 oficioAcuse = '".$acusedev."',
			 estadoTramite = 13,
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 13,	
			 status = 1,
			 atendido = 0, 
			 visto = 0,
			 tipo_devolucion = '".$tipo_devolucion."'
			 ";
		$sql2 = $conexion->select($sqltxt,false);

	echo "asistencia  -> ".print_r($_POST);
}
//---------------------------------------- ACUERDO DE INICIO -----------------------------
//---------------------------------------- ACUERDO DE INICIO -----------------------------
if($_REQUEST["proceso"]=="inicio")
{
	$fechap=fechaMysql(valorSeguro($_REQUEST['fechadev']));
	$num_accion=valorSeguro($_REQUEST['num_accion']);
	$cp = ValorSeguro($_REQUEST['cp']);
	$num_proce=ValorSeguro($_REQUEST['num_procedimiento']);
	$user=valorSeguro($_REQUEST['user']);
	$hora=valorSeguro ($_REQUEST['hora']);
	
	$query = "UPDATE pfrr SET detalle_edo_tramite= '15', fecha_acuerdo_inicio = '".$fechap."', usuario='".$user."',fecha_edo_tramite='".fechaMysql($fechap)."',hora='".$hora."'  WHERE num_accion = '".$num_accion."'";
	$sql = $conexion->update($query ,false);
	/// si actualiza el edo tramite
	
	//-------------------------------------------------------------------------------
	//------------------- sacamos ultimo registro -----------------------------------
	$sqlv = $conexion->select("SELECT * from pfrr_2014 order by pfrr_2014 desc limit 1", false);
	$totalOf = mysql_num_rows($sqlv);
	$v = mysql_fetch_assoc($sqlv);
	$fechaPartes = explode("-",$v['fecha_generado']);
	$procePartes = explode("/",$v['num_procedimiento']);
	//-------------------------------------------------------------------------------
	$consecutivo = $procePartes[5];
	$anioAnt = $fechaPartes[0];
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $consecutivo = "00".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $consecutivo = "0".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $consecutivo = "".$consecutivo;
	if($consecutivo >= 1000) $consecutivo = $consecutivo;

	
	$anio = substr(date('Y'),-2);
	echo $num_procedimiento = $num_proce.$consecutivo;
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
		
		/*
		$sql = $conexion ->select("SELECT * from pfrr_2014 order by pfrr_2014 desc limit 1");
		$r = mysql_fetch_array($sql);
		$consecutivo = $r["pfrr_2014"] + 1;
		//echo "<br>";
		
		if ($consecutivo <= 10)
			$consecutivo="00".$consecutivo;
			
		if ($consecutivo  > 10 && $consecutivo < 100 )
			$consecutivo="0".$consecutivo;
			
		echo $num_procedimiento = $num_proce.$consecutivo;
		*/
		$query = "INSERT INTO pfrr_2014 SET fecha_generado='".fechaMysql($fechap)."',num_accion='".$num_accion."',solicito='".$user."', num_procedimiento='".$num_procedimiento."'" ;
		//echo "<br>";
		$sql=$conexion->insert($query,false);
		
		//$query = "UPDATE pfrr SET num_procedimiento = '".$num_procedimiento."',fecha_num_procedimiento='".date("Y-m-d")."' where num_accion='".$num_accion."'";
		$query = "UPDATE pfrr SET fecha_num_procedimiento='".date("Y-m-d")."' where num_accion='".$num_accion."'";
		//echo "<br>";
		$sql=$conexion->update($query);
		//echo "<br>";
		//echo "<br>";
		
		$sqltxt = "INSERT INTO pfrr_historial 
			SET 
			 num_accion = '".$num_accion."',
			 tipo = 'acuerdoInicio',	
			 oficio	= '".$num_procedimiento."',
			 estadoTramite = 15,
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$user."',	
			 nombreProceso = 15,	
			 status = 1,
			 atendido = 0, 
			 visto = 0";
		$sql2 = $conexion->select($sqltxt,false);

		//print_r ($_REQUEST);
}
//-------------------------------------------------------------------------------
//notificacion iCC
if($_POST["proceso"]=="notificacion")
{
	$fecha_not_icc_pfrr=fechaMysql(valorSeguro($_POST['fechadev']));
	$fecha_acu_icc_pfrr=fechaMysql(valorSeguro($_POST['fechaAcu']));
	$num_accion=valorSeguro($_POST['num_accion']);
	$user=valorSeguro($_POST['user']);
	$hora=valorSeguro ($_POST['hora']);
	$oficio = valorSeguro ($_POST['oficio']);
	
	$sql = $conexion->update("UPDATE pfrr SET detalle_edo_tramite= '30',usuario='".$user."',fecha_edo_tramite='".$fecha_not_icc_pfrr."',hora='".$hora."'  WHERE num_accion = '".$num_accion."'" ,false);
	$sqltxt = "INSERT INTO pfrr_historial 
			SET 
			 num_accion = '".$num_accion."',
			 tipo = 'Not_icc_PFRR',	
			 oficio	= '".$oficio."',
			 oficioRecepcion = '".$fecha_not_icc_pfrr."',
			 oficioAcuse = '".$fecha_acu_icc_pfrr."',
			 estadoTramite = 30,
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$user."',	
			 nombreProceso = 30,	
			 status = 1,
			 atendido = 0, 
			 visto = 0";
	$sql2 = $conexion->select($sqltxt,false);
	print_r ($_POST);
}
//---------------------------------------------------------------------------------------------------
// cierre de instruccion
if($_POST["proceso"]=="acuseOpinionUAA")
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo19 = 	valorSeguro($_REQUEST['cambiaEdo19']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$oficio = 		valorSeguro($_REQUEST['oficio']);
	$fechaOf = 		fechaMysql(valorSeguro($_REQUEST['fechaOf']));
	$fechaAc = 		fechaMysql(valorSeguro($_REQUEST['fechaAc']));
	//----------------------------------------------------------------

	$sqltxt = "INSERT pfrr_historial 
		SET 
		 num_accion = '".$accion."',
		 tipo = 'opinion_UAA_PFRR',
		 oficioRecepcion = '".$fechaOf."',
		 oficioAcuse = '".$fechaAc."',
		 estadoTramite = 19,
		 fechaSistema = '".date("Y-m-d")."',
		 horaSistema =  '".date("h:i:s")."',	
		 usuario = '".$usuario."',	
		 nombreProceso = 19,	
		 status = 1,
		 atendido = 1, 
		 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 19, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
	$sql1 = $conexion->select($sqltxt,false);

	echo print_r($_POST); 
}
?>



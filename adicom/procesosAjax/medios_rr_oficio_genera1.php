<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
//-------------------------------------------------------------------------------
//--------------- COMPROBACION DE QUE NO SE REPITA OFICIO -----------------------

$sql = $conexion->select("SELECT num_accion,hora_oficio,abogado_solicitante,tipo FROM oficios WHERE num_accion LIKE '$acciones' AND hora_oficio = '$horaOficio' AND abogado_solicitante = '$userForm'   ", false);
$TO = mysql_num_rows($sql);

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//------------------- GENERACION DEL VOLANTE ------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//------------------- IMPORTANTE NO MOVER EL ORDEN DE LOS PROCESOS --------------
//------------------- buscamos año del ultimo oficio  ---------------------------
//-- de la tabla de folios buscamos por id y de mas a menos y tenemos el ultimo.-
//-------------------------------------------------------------------------------
if($TO == 0){
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	$acciones = $_POST['totalAcciones'];
	$presunto = $_POST['totalPresuntos'];
	$oficioRef = $_POST['oficioRef'];
	$remitente = $_POST['remitente'];
	$cargo  = $_POST['cargo'];
	$dependencia = $_POST['dependencia'];
	$asunto = $_POST['asunto'];
	$userForm = $_POST['userForm'];
	$dirForm = $_POST['dirForm'];
	$entidad = $_POST['entidad'];

	$folio = generaOficios($tipo = "medios_rr", $fechaOficio, $horaOficio, $acciones, $presunto, $oficioRef, $remitente, $cargo, 
	$dependencia , $asunto, $userForm, $dirForm, $tipoOficio);
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//-------------- INSERTAMOS EN LA TABLA FOLIOS CONTENIDO CADA ACCION -------------------------------
   //--------------------------------------------------------------------------------------------
   $acciones 	= $_REQUEST['accionVinculada'];
   $noPresuntos	= count($_POST['nomPresunto']);
   $i        	= 0;
   //--------------------------------------------------------------------------------------------presunto = '".$_POST['actor'][$i]."'
   while ($i < $noPresuntos)
   {
		$sqlX = $conexion->insert("INSERT INTO oficios_contenido 
									SET 
										 folio = '".$folio."',
										 num_accion = '".$_POST['num_accion'][$i]."',
										 
										 presunto = '".$_POST['dependencia']."',
										 
										 oficio_referencia = '".$_POST['oficioRef']."',
										 
										 juridico = 1 ",false);
		// historial --------------								 
		/*$query = "INSERT INTO medios_historial SET
				num_accion = '".$_POST['accion'][$i]."',
				tipo = ".$_POST['tipoOficio'].",
				oficio = '".$folio."',
				oficioRecepcion = '".$fechaOficio."',
				oficioAcuse = '',
				estadoTramite = ".$_POST['tipoOficio'].",
				idPresunto = '".$_POST['idPresunto'][$i]."',
				presunto = '".$_POST['nomPresunto'][$i]."',
				fechaSistema = '".date("Y-m-d h:i:s")."',
				usuario = '".$_POST['userForm']."',
				status = 1";
		$sql = $conexion->insert($query);*/
		// actualizamos accion ----------------	
		if($_POST['tipoOficio'] == 45)
		{							 
			$query = "UPDATE medios SET
						fecha_act = '".date("Y-m-d")."',
						hora_act = '".date("h:i:s")."',
						usuario = '".$_POST['userForm']."',
						estado = ".$_POST['tipoOficio']."
					WHERE id = ".trim($_POST['idPresunto'][$i])." ";
			$sql = $conexion->update($query);
		}
		$i++;
	}
	//--------------------------------------------------------------------------------------------------
	/*
	if($_POST['tipoOficio'] == "33") {
			$sql = $conexion->update("UPDATE medios 
							SET 
								estado = 	".$edoTramite.",
								usuario =	'".$usuario."',
								fecha_act =	'$fechasVolantes',
								hora_act =	'$horasVolantes'
							WHERE nombre = '".$presunto."' AND num_accion = '".$accion."'", false);
	}
	*/
	//-------------- INSERTAMOS CADA ACCION EN HISTORIAL DE MANERA INDIVIDUAL --------------------------
	/*
	$partesAcciones = explode("|",$acciones);
	
	for($i=0; $i<=count($partesAcciones); $i++)
	{
		if($partesAcciones[$i] != "")
		{
			if(stripos($oficioRef,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			else {$tipo = $dependencia; }
	
			
			$sql = $conexion->insert("INSERT INTO otros_oficios 
										SET
											num_accion = '".$partesAcciones[$i]."',
											folio_volante = '$folio',
											documentoExtra = '$oficioRef',
											fecha = '$fechaOficio',
											acuse = '$fechaAcuse',
											leyenda = '$asunto',
											atiende = '$remitente',
											referencia = '$remitente',
											tipo = '$tipoOficio',
											status = 1",false);	
		}
	}
	*/
	//-------------------------------------------------------------------------------
	//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
		//$sql = $conexion->select("SELECT * FROM volantes_remitentes WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
		//$total = mysql_num_rows($sql);
		
		//if($total == 0)
			//$sql = $conexion->insert("INSERT INTO volantes_remitentes SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	
	
	//echo $ultimo_id;
	//echo "<bR>".print_r($_POST);
	/*
	if($tipoOficio == 'notificacionEF' || $tipoOficio == 'notificacionICC')
	{
		$remNom = $remitente;
		$remCar = $cargo;
		$remDep = $dependencia;
		$fechaPO = $fechaPO;
		
		//sacamos datos de PO 
		$query = "SELECT cp,numero_de_pliego,entidad_fiscalizada,monto_modificado,monto_de_po_en_pesos,f.UAA as ua,director,cargo,fojas
					FROM po
					INNER JOIN fondos f ON po.num_accion = f.num_accion
					INNER JOIN directores_uaa du ON f.UAA = du.uaa
					WHERE po.num_accion = '".$accion."'
					LIMIT 1";
					
		$sql = $conexion->select($query, false);
		$totalOf = mysql_num_rows($sql);
		$datos = mysql_fetch_array($sql);
		//numero_de_pliego	entidad_fiscalizada	monto_modificado	ua	director	cargo
		$po = $datos['numero_de_pliego'];
		$cp = $datos['cp'];
		$ef = $datos['entidad_fiscalizada'];
		$mm = ($datos['monto_modificado'] != "") ? $datos['monto_modificado'] : $datos['monto_de_po_en_pesos'];
		$ua = $datos['ua'];
		$di = $datos['director'];
		$ca = $datos['cargo'];
		//insertamos datops a las tabla del oficios PDF
		$query1 = "
				INSERT INTO oficios_pdf SET
					oficio = '".$folio."',
					po = '".$po."',
					fecha_po = '".fechaMysql($fechaPO)."',
					fecha_oficio = '".$fechaOficio."',
					destinatario = '".$remNom."',
					cargo_destinatario = '".$remCar."',
					dependencia_destinatario = '".$remDep."',
					cp = '".$cp."',
					ef = '".$ef."',
					num_accion = '".$accion."',
					monto = '".$mm."',
					UAA = '".$ua."',
					director_UAA = '".$di."',
					fojas = '".$fojas."',
					fecha_sistema = '".$fechaOficio."',
					hora_sistema  = '".$horaOficio."' ";
		$sql = $conexion->insert($query1,false);
	}
	*/
	if($_POST['tipoOficio'] == 34) {
		echo $folio;
	}else{
		echo $folio."|".$po."|".$cp."|".$ef."|".$mm."|".$ua."|".$di."|".$ca."|".$remNom."|".$remCar."|".$remDep."|".$fechaPO."|".$fojas."|".$fechaOficio."|".$horaOficio."|".$numRR;
	}
}// end TO
else
{ echo "<br><br><center><h2>Ya existe un oficio idéntico... <br> Notifíquelo a la Administración </center></h2>"; }




@mysql_free_result($sql);
?>

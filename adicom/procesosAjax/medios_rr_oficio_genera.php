<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
foreach($_POST as $nombre_campo => $valor)
{
   $resultado = strpos($nombre_campo, "accionVinculada_"); 
   if($resultado  !== FALSE)
   {
	   $acciones .= valorSeguro($valor)."|";
   }
   else
   {
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
   }
}
//echo "\n\n Acciones: ".$acciones."\n\n ";

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
//-------------------------------------------------------------------------------
//--------------- COMPROBACION DE QUE NO SE REPITA OFICIO -----------------------
$tipoof = $_POST['tipoOficio'];
$acci = $_POST['oficioRef'];

$sql = $conexion->select("SELECT num_accion,hora_oficio,abogado_solicitante,tipo FROM oficios WHERE oficio_referencia LIKE '$acci' AND tipo= '$tipoof'", false);
$TO = mysql_num_rows($sql);

//-------------------------------------------------------------------------------
//------------------- GENERACION DEL VOLANTE ------------------------------------
//-------------------------------------------------------------------------------
if($tipoof != "" || $tipoof != "NULL" || $tipoof != "otros")
{
if($TO == 0 || $tipoof == "otros"){
	//-------------------------------------------------------------------------------$acciones ---> $noacc
	$folio = generaOficios($tipo = "medios_rr",$fechaOficio, $horaOficio, $noacc, $presunto = "", $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio);
	//-------------------------------------------------------------------------------
	//$partesAcciones = explode("|",$acciones);
	//-------------- INSERTAMOS EN LA TABLA FOLIOS CONTENIDO CADA ACCION -------------------------------
	/*foreach($partesAcciones as $k => $v)
	{
		if($v != "")
		{*/
			$sqlX = $conexion->insert("INSERT INTO oficios_contenido 
										SET 
											 folio = '".$folio."',
											 num_accion = '".$_POST['noacc']."',
											 presunto = '".$_POST['idact']."',
											 oficio_referencia = '".$oficioRef."',
											 juridico = 1 ",false);
	/*	}
	} 
	INSERT INTO oficios_contenido 
									SET 
										 folio = '".$folio."',
										 num_accion = '".$_POST['num_accion'][$i]."',
										 
										 presunto = '".$_POST['dependencia']."',
										 
										 oficio_referencia = '".$_POST['oficioRef']."',
										 
										 juridico = 1 
	*/
	//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
	//$fecha90 = strtotime ( '+90 day' , strtotime ( $fechaOficio ) ) ;
	//$fecha90 = date ( 'Y-m-d' , $fecha90 );
	//-------------- INSERTAMOS CADA ACCION EN HISTORIAL DE MANERA INDIVIDUAL --------------------------
/*	for($i=0; $i<=count($partesAcciones); $i++)
	{
		if($partesAcciones[$i] != "")
		{
			if(stripos($oficioRef,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			else {$tipo = $dependencia; }
			//------------------------------------------------------------------------------------------
			// si es ENVIADA A LA UAA y cambioEstado (verifica q el edo no sea mayor al que tiene por # de orden no de edo.)
			if(cambioEstado($partesAcciones[$i],19) && $tipoOficio == "opinion_UAA_PFRR")
			{
				//cambiamos edo tramite de la accion...
				//$sqlpfrr = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = 19,limite_cierre_instruccion = '".$fecha90."',usuario='".$userForm."', fecha_edo_tramite = '".$fechaOficio."', hora='".$horaOficio."' WHERE num_accion='".$partesAcciones[$i]."' ",false);
				//si todo va bien insertamos historial
				if($sqlpfrr)
				{
					$txtHis = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$partesAcciones[$i]."',
						 tipo = 'opinionUAA',	
						 oficio = '".$folio."',	
						 oficioRecepcion = '".$fechaOficio."',	
						 estadoTramite = 19,
						 fechaSistema = '".$fechaOficio."', 
						 horaSistema =  '".$horaOficio."',	
						 usuario = '".$userForm."',	
						 nombreProceso = 19,	
						 status = 1,
						 atendido = 0, 
						 visto = 1";
					$sqlHis = $conexion->select($txtHis,false);
				}
			}
					//------------------------------------------------------------------------------------------
			// si es UN OFICIO CITATORIO 
			if($tipoOficio == "citatorio_PFRR")
			{
	
			}
			//------------------------------------------------------------------------------------------
			$sql = $conexion->insert("INSERT INTO pfrr_bitacora_adicional 
										SET
											num_accion = '".$partesAcciones[$i]."',
											folio = '$folio',
											oficio_tipo_oficio_adicional = '$oficioRef',
											fecha_tipo_oficio_adicional = '$fechaOficio',
											acuse_tipo_oficio_adicional = '$fechaAcuse',
											leyenda_tipo_oficio_adicional = '$asunto',
											atiende_tipo_oficio_adicional = '$remitente',
											referencia_tipo_oficio_adicional = '$remitente',
											tipo_oficio_adicional = '$tipo',
											status = 1",false);	
		}
	}*/
	//-------------------------------------------------------------------------------
	//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
		/*$sql = $conexion->select("SELECT * FROM pfrr_nombres WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
		$total = mysql_num_rows($sql);
		
		if($total == 0)
			$sql = $conexion->insert("INSERT INTO pfrr_nombres SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	*/
	
	//echo $ultimo_id;
	//echo "<bR>".print_r($_POST);
	
	echo "<br><br><center><h2>Se generó el número de oficio <br><br>$folio</center></h2>";
}// end TO
else
{ echo "<br><br><center><h2>Ya existe un oficio idéntico... <br> Notifíquelo a la Administración </center></h2>"; }
}
else
{ echo "<br><br><center><h2>Seleccione un tipo de oficio... <br> a generar... </center></h2>"; }
	
	@mysql_free_result($sql);
?>

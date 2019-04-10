<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$con=0;
//print_r($_REQUEST);
//echo "<br>".urldecode($_REQUEST['accionAsunto'][0]);
//echo "<br>".urldecode($_REQUEST['accionOficio'][0]);
if($_REQUEST['tipoPOST'] == "sencillo")
{
	$totAcciones= 1;
	$usuario 	= valorSeguro($_REQUEST['usuario']);
	$nivel 		= valorSeguro($_REQUEST['nivel']);
	$turnado	= valorSeguro($_REQUEST['accionTurnado']);
	$direccion 	= valorSeguro($_REQUEST['accionDireccion']);
	$juicio = valorSeguro($_REQUEST['juicio']);
}else{
	$totAcciones= valorSeguro($_REQUEST['totalAcciones']);
	$usuario 	= valorSeguro($_REQUEST['usuario']);
	$nivel 		= valorSeguro($_REQUEST['nivel']);
	$turnado	= valorSeguro($_REQUEST['accionTurnado'][0]);
	$direccion 	= valorSeguro($_REQUEST['accionDireccion'][0]);
	$juicio = valorSeguro($_REQUEST['juicio']);

}
//------------------- GENERACION DEL VOLANTE -------------------------------------------------
//--------------------------------------------------------------------------------------------
$fechasVolantes = date('Y-m-d');
$horasVolantes = date("H:i:s");

//echo "SQL 1".
$sql = $conexion->insert("INSERT INTO volantes 
						  SET 
							hora_registro = '$horasVolantes',
							fecha_actual = '$fechasVolantes',
							turnado = '$turnado',
							status = 1,
							semaforo = 0,
							generado_por = '$usuario',
							direccion = '$direccion',
							accion = '$totAcciones'
							",false);
//generamos ultimo ID
$ultimo_id = mysql_insert_id(); 

if($ultimo_id <= 9) $uid = "000".$ultimo_id;
if($ultimo_id <= 99 && $ultimo_id >= 10) $uid = "00".$ultimo_id;
if($ultimo_id >= 100 && $ultimo_id < 1000) $uid = "0".$ultimo_id;
if($ultimo_id >= 1000) $uid = $ultimo_id;

$anio = substr(date('Y'),-2);
$folio = $uid."/".$anio;

//echo "SQL 2".
$sql = $conexion->update("UPDATE volantes SET folio = '$folio' WHERE id = $ultimo_id ", false);
//-------------------------- PROCESAMOS ACCIONES -------------------------------
//------------------------------------------------------------------------------
if($sql)
{
   //--------------------------------------------------------------------------------------------
   $acciones 	= $_REQUEST['accionVinculada'];
   $noAcciones	= count($acciones);
   $i        	= 0;
   //--------------------------------------------------------------------------------------------
   if($_REQUEST['tipoPOST'] == "sencillo") $noAcciones = 1;
   //--------------------------------------------------------------------------------------------
   while ($i < $noAcciones)
   {
	   $proceso = "";	
	   $edoTramite = 0;
	   $tipoMov = "";
		
		if($_REQUEST['tipoPOST'] == "sencillo")
		{	    
			$accion 	= valorSeguro($_REQUEST['accionVinculada']);
			$presunto 	= valorSeguro($_REQUEST['presuntoVinculada']);
			$movimiento = valorSeguro($_REQUEST['accionRef']);
			$edoTramite = valorSeguro($_REQUEST['accionEstado']);
			$asunto		= urldecode(valorSeguro($_REQUEST['accionAsunto']));
			$remitente	= valorSeguro($_REQUEST['Remitente']);
			$cargo		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionCargo'])))); 
			$dependencia= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDependencia'])));
			$oficio		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionOficio'])))); 
			$fechaOficio= valorSeguro(fechaMysql($_REQUEST['accionOfiFec']));
			$fechaAcuse	= valorSeguro(fechaMysql($_REQUEST['accionOfiFecAcu']));
			$cral		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionCral'])));
			$fechaCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFe']));
			$acuseCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFecAcu']));
			$dt 		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDt']))); 
			$ofiRef		= $_REQUEST['accionOfiRef']; 
		} else {
			$accion 	= valorSeguro($_REQUEST['accionVinculada'][$i]);
			$presunto 	= valorSeguro($_REQUEST['presuntoVinculada'][$i]);
			$movimiento = valorSeguro($_REQUEST['accionRef'][$i]);
			$edoTramite = valorSeguro($_REQUEST['accionEstado'][$i]);
			$asunto		= urldecode(valorSeguro($_REQUEST['accionAsunto'][$i]));
			$remitente	= valorSeguro($_REQUEST['Remitente'][$i]);
			$cargo		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionCargo'][$i])))); 
			$dependencia= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDependencia'][$i])));
			$oficio		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionOficio'][$i])))); 
			$fechaOficio= valorSeguro(fechaMysql($_REQUEST['accionOfiFec'][$i]));
			$fechaAcuse	= valorSeguro(fechaMysql($_REQUEST['accionOfiFecAcu'][$i]));
			$cral		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionCral'][$i])));
			$fechaCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFe'][$i]));
			$acuseCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFecAcu'][$i]));
			$dt 		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDt'][$i]))); 
			$ofiRef		= $_REQUEST['accionOfiRef'][$i]; 
		}
			//--------------------------------------------------------------------------------------------
		if(is_numeric($movimiento))	{
			$proceso = $movimiento;
			$edoTramite = $movimiento;
			$tipo = "recepcion";
		}else{
			$proceso = "";
			$edoTramite = "";
			$tipo = "recepcion";
		}
		
		$tipoMov = $movimiento;
		//------------------------------------- volantes por separado --------------------------------------------------------
		$sql = $conexion->insert("INSERT INTO volantes_contenido 
								  SET 
								    folio = '$folio',
									fecha_oficio = '$fechaOficio',
									fecha_acuse = '$fechaAcuse',
									cral = '$cral',
									fechaCral = '$fechaCral',
									acuseCral = '$acuseCral',
									entidad_dependencia = '$dependencia',
									remitente = '$remitente',
									cargo = '$cargo',
									oficio = '$oficio',
									asunto = '$asunto',
									turnado = '$turnado',
									status = 1,
									tipoMovimiento = '$movimiento',
									direccion = '$direccion',
									accion = '$accion',
									presunto = '$presunto'
									"
								,false);
		//---------------------------------------------------------------------------------------------------------
		if($movimiento != 'otro' && $movimiento != 'pfrr_otros' && $movimiento != 'medios_otros' && $movimiento != 'x_otros' && $movimiento != 'administracion'){						
			//------------------------------- ACTUALIZACION DE ACCIONES PO ------------------------------------------------
			//actualizamos solo los edos de PO 
			if(is_numeric($edoTramite) && ($edoTramite <= 10 || $edoTramite == 27))
			{
				$sql = $conexion->update("UPDATE po 
									SET 
										detalle_de_estado_de_tramite= ".$edoTramite.",
										ip_edo_tram='".$usuario."',
										fecha_estado_tramite='$fechasVolantes',
										hora_act_edo_tram='$horasVolantes',
										bajaAnunciada = 0  
									WHERE num_accion = '".$accion."'" 
										,false);
				//------------------------------ INSERTA HISTORIAL PO -------------------------------------------------						
				$sql = $conexion->insert("INSERT INTO po_historial 
								  SET
									num_accion = '$accion',
									tipo = '$tipo',
									oficio = '$oficio',
									oficioRecepcion = '$fechaOficio',
									oficioAcuse = '$fechaAcuse',
									sicsa = '$cral',
									sicsaRecepcion = '$fechaCral',
									sicsaAcuse = '$acuseCral',
									volante = '$folio',
									volanteRecepcion = '$fechasVolantes',
									volanteAcuse = '$fechasVolantes',
									cedula = '$cedula',
									fechaCedula = '$fechaCedula',
									estadoTramite = ".$edoTramite.",
									fechaSistema = '".date('Y-m-d')."',
									horaSistema = '".date('H:i:s')."',
									usuario = '$usuario',
									nombreProceso = '$proceso',
									status = 1"
								,false);
			}
			//------------------------------- ACTUALIZACION DE ACCIONES PFRR ------------------------------------------------
			//actualizamos solo estados PFRR
			if(is_numeric($edoTramite) && ($edoTramite == 11 || $edoTramite == 14 || $edoTramite == 21 || $edoTramite == 27 || $edoTramite == 28)){
				$sql = $conexion->update("UPDATE pfrr
									SET 
										detalle_edo_tramite= $edoTramite,
										usuario='".$usuario."',
										fecha_edo_tramite='$fechasVolantes',
										hora='$horasVolantes'  
									WHERE num_accion = '".$accion."'" 
										,false);
				//----------------------- actualiza PO si es solventacion previa al inicio del PFRR
				if($edoTramite == 14){				
					$sql = $conexion->update("UPDATE po
								SET 
									detalle_de_estado_de_tramite = 9,
									ip_edo_tram = '".$usuario."',
									fecha_estado_tramite = '$fechasVolantes',
									hora_act_edo_tram = '$horasVolantes'  
								WHERE num_accion = '".$accion."'" 
									,false);
				}
				//----------------------- respuesta técnica de la UAA suma 90 días
				if($edoTramite == 28){	
				//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
					$fecha90 = strtotime ( '+90 day' , strtotime ( $fechasVolantes ) ) ;
					$fecha90 = date ( 'Y-m-d' , $fecha90 );
					//----------------------------------------------------------------------------------------------
					//$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 28,  limite_cierre_instruccion = '".$fecha90."', fecha_analisis_documentacion = '".$fecha."',usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
					$sqlpfrr = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = 28, limite_cierre_instruccion = '".$fecha90."', fecha_analisis_documentacion = '".$fechasVolantes."' WHERE num_accion='".$accion."' ",false);
				}
				//------------------------------ INSERTA HISTORIAL PFRR -------------------------------------------------						
				$sql = $conexion->insert("INSERT INTO pfrr_historial 
											  SET
												num_accion = '$accion',
												tipo = '$tipo',
												oficio = '$oficio',
												oficioRecepcion = '$fechaOficio',
												oficioAcuse = '$fechaAcuse',
												sicsa = '$cral',
												sicsaRecepcion = '$fechaCral',
												sicsaAcuse = '$acuseCral',
												volante = '$folio',
												volanteRecepcion = '$fechasVolantes',
												volanteAcuse = '$fechasVolantes',
												estadoTramite = '$edoTramite',
												fechaSistema = '".date('Y-m-d')."',
												horaSistema = '".date('H:i:s')."',
												usuario = '$usuario',
												nombreProceso = '$proceso',
												status = 1"
											,false);
			}
		
		}// end movimientos ............
		//---------------------------------------- DTNS ----------------------------------------------------
		//---------------------------------------- DTNS ----------------------------------------------------
		if($movimiento == 10) {
			$oficio_recepcionDTNS		=		$oficio;
			//$num_DT						=		valorSeguro($_REQUEST['num_DT']);
			$fecha_recepcionDTNS		=		$fechaOficio;
			$acuse_recepcionDTNS		=		$fechaAcuse;
			$SICSA_recepcionDTNS		= 		$cral;
			$fecha_SICSA_recepcionDTNS	=		$fechaCral;	
			$acuse_SICSA_recepcionDTNS	=		$acuseCral;
			$volante_recepcionDTNS		=		$folio;
			$fecha_volante_recepcionDTNS=		$fechasVolantes;
			$acuse_volante_recepcionDTNS=		$fechasVolantes;
			$num_accion					=		$accion;	
			
			//actualiza tabla PO
				$sqlPO = $conexion->update("UPDATE po SET detalle_de_estado_de_tramite= '10',ip_edo_tram='".$usuario."',fecha_estado_tramite='".$fechasVolantes."',hora_act_edo_tram='".$horasVolantes."'  WHERE num_accion = '".$num_accion."'" ,false);
			//inserta datos a PFRR
				$insertPFRR = sprintf("
					INSERT INTO pfrr 
						( num_accion,entidad,cp,auditoria,direccion,subdirector,abogado,po,prescripcion,detalle_edo_tramite,fecha_edo_tramite,usuario,hora,subnivel) 
					SELECT 
							num_accion,entidad_fiscalizada,	cp,num_auditoria,direccion,subdirector,abogado,numero_de_pliego,prescripcion,detalle_de_estado_de_tramite,fecha_estado_tramite,ip_edo_tram,hora_act_edo_tram,subnivel
						FROM po
						WHERE po.num_accion = '".$num_accion."' ");	
				$sqlPFRR = $conexion->insert($insertPFRR,false);
				
			//inserta datos a pfrr_presuntos_audiencias
				$insertPresuntos = "
					INSERT INTO pfrr_presuntos_audiencias (num_accion,nombre,cargo,dependencia,accion_omision) 
						SELECT num_accion,servidor_contratista,cargo_servidor,dependencia,irregularidad 
						FROM  po_presuntos 
						WHERE num_accion = '".$num_accion."' 
							AND tipo_presunto <> 'titularICC' 
							AND tipo_presunto <> 'responsableInforme' ";		
				$sqlPresuntos = $conexion->insert($insertPresuntos,false);
			//actualiza tabla PFRR	
			$sqlPFRR2 = $conexion->update("UPDATE pfrr SET num_DT='".$dt."',detalle_edo_tramite= '11',usuario='".$usuario."',fecha_edo_tramite='".$fechasVolantes."',hora='".$horasVolantes."'  WHERE num_accion = '".$num_accion."'" ,false);
			$sql = $conexion->insert("INSERT INTO pfrr_historial 
									  SET
										num_accion = '$accion',
										tipo = '$tipo',
										oficio = '$oficio',
										oficioRecepcion = '$fechaOficio',
										oficioAcuse = '$fechaAcuse',
										sicsa = '$cral',
										sicsaRecepcion = '$fechaCral',
										sicsaAcuse = '$acuseCral',
										volante = '$folio',
										volanteRecepcion = '$fechasVolantes',
										volanteAcuse = '$fechasVolantes',
										dt = '$dt',
										estadoTramite = '$edoTramite',
										fechaSistema = '".date('Y-m-d')."',
										horaSistema = '".date('H:i:s')."',
										usuario = '$usuario',
										nombreProceso = '$proceso',
										status = 1",false);
			
			if($sqlPO && $insertPFRR && $sqlPFRR && $sqlPFRR2 && $sqlPresuntos) $error = "";
			else {
				$error = "error";
				$txtEror = "<div style='line-height:normal'>No se gardo <br><br> - $sqlPO <br><br> $insertPFRR <br><br> $sqlPFRR <br><br> $sqlPFRR2 <br><br> $sqlPresuntos </div>"; 
			}
		}
		//------------------------------------- FIN DTNS ----------------------------------------------------
		//------------------------------------- OPIONIONES LEGALES -------------------------------------------
		if($movimiento == "opinion_legal") {
				
				$sql = $conexion->select("SELECT num_accion FROM opiniones WHERE num_accion = '".$accion."'");
				$totalReg = mysql_num_rows($sql);
				
				if($totalReg == 0) {
					$sql = $conexion->update("INSERT INTO opiniones 
											SET 
											num_accion = '".$accion."', 
											ip_edo_tram='".$usuario."',
											fecha_estado_tramite = '$fechasVolantes',
											hora_act_edo_tram='$horasVolantes',
											bajaAnunciada = 0 "
											,false);
				}//end totreg
				//--------------------- INSERTA HISTORIAL OPINIONES -----------------------------------------						
				$sql = $conexion->insert("INSERT INTO opiniones_historial 
								  SET
									num_accion = '$accion',
									tipo = '$tipo',
									oficio = '$oficio',
									oficioRecepcion = '$fechaOficio',
									oficioAcuse = '$fechaAcuse',
									sicsa = '$cral',
									sicsaRecepcion = '$fechaCral',
									sicsaAcuse = '$acuseCral',
									volante = '$folio',
									volanteRecepcion = '$fechasVolantes',
									volanteAcuse = '$fechasVolantes',
									cedula = '$cedula',
									fechaCedula = '$fechaCedula',
									estadoTramite = '".$edoTramite."',
									fechaSistema = '".date('Y-m-d')."',
									horaSistema = '".date('H:i:s')."',
									usuario = '$usuario',
									nombreProceso = '$proceso',
									status = 1"
								,false);
		}
		//------------------------------------- MEDIOS RR -------------------------------------------
		//------------------------------------- MEDIOS RR -------------------------------------------
		if($movimiento == "33.1") $tipo = "rr_solInfo";
		if($movimiento == "33.2") $tipo = "rr_intRecRec";
		if($movimiento == "33.1" || $movimiento == "33.2") $edoTramite = 33;
		
		if($movimiento == "33.1" || $movimiento == "33.2") {
				$sql = $conexion->update("UPDATE medios 
								SET 
									estado = 	".$edoTramite.",
									usuario =	'".$usuario."',
									fecha_act =	'$fechasVolantes',
									hora_act =	'$horasVolantes'
								WHERE nombre = '".$presunto."' AND num_accion = '".$accion."'", false);
				//--------------------- INSERTA MEDIOS -----------------------------------------						
				$sql = $conexion->insert("INSERT INTO medios_historial 
								  SET
									num_accion = '$accion',
									tipo = '$tipo',
									oficio = '$oficio',
									oficioRecepcion = '$fechaOficio',
									oficioAcuse = '$fechaAcuse',
									volante = '$folio',
									volanteRecepcion = '$fechasVolantes',
									volanteAcuse = '$fechasVolantes',
									estadoTramite = '".$edoTramite."',
									proceso = 'recRec',
									presunto = '".$presunto."',
									fechaSistema = '".date('Y-m-d')."',
									usuario = '$usuario',
									status = 1", false);
				//-------------------- ACTUALIZA OFICIO RELACIONADO -----------------------------
				$sql = $conexion->update("UPDATE oficios_contenido SET respondido = 1 WHERE folio LIKE '".$ofiRef."' ", false);
				
				
				
		}
		if($movimiento == "46") {
				$sql = $conexion->update("UPDATE medios 
								SET 
									estado = 	".$edoTramite.",
									usuario =	'".$usuario."',
									fecha_act =	'$fechasVolantes',
									hora_act =	'$horasVolantes'
								WHERE nombre = '".$presunto."' AND num_accion = '".$accion."'", false);
				//--------------------- INSERTA MEDIOS -----------------------------------------						
				$sql = $conexion->insert("INSERT INTO medios_historial 
								  SET
									num_accion = '$accion',
									tipo = '$tipo',
									oficio = '$oficio',
									oficioRecepcion = '$fechaOficio',
									oficioAcuse = '$fechaAcuse',
									volante = '$folio',
									volanteRecepcion = '$fechasVolantes',
									volanteAcuse = '$fechasVolantes',
									estadoTramite = '".$edoTramite."',
									proceso = 'recRec',
									presunto = '".$presunto."',
									fechaSistema = '".date('Y-m-d')."',
									usuario = '$usuario',
									status = 1", false);
				//-------------------- ACTUALIZA OFICIO RELACIONADO -----------------------------
				$sql = $conexion->update("UPDATE oficios_contenido SET respondido = 1 WHERE folio LIKE '".$ofiRef."' ", false);
				
				
				
		}
		//------------------------------------- MEDIOS Juicio de Nulidad -------------------------------------------
		if($movimiento == "44") $tipo = "jn_inter";
		if($movimiento == "44.1") $tipo = "jn_informacion";
		if($movimiento == "44" || $movimiento == "44.1") $edoTramite = 44;
		
		if($movimiento == "44" || $movimiento == "44.1") {
				$sql = $conexion->update("UPDATE medios 
								SET 
									estado = 	".$edoTramite.",
									usuario =	'".$usuario."',
									fecha_act =	'$fechasVolantes',
									juicio_nulidad = '".$juicio."',
									hora_act =	'$horasVolantes'
								WHERE nombre = '".$presunto."' AND num_accion = '".$accion."'", false);
				//--------------------- INSERTA MEDIOS -----------------------------------------						
				$sql = $conexion->insert("INSERT INTO medios_historial 
								  SET
									num_accion = '$accion',
									tipo = '$tipo',
									oficio = '$oficio',
									oficioRecepcion = '$fechaOficio',
									oficioAcuse = '$fechaAcuse',
									volante = '$folio',
									volanteRecepcion = '$fechasVolantes',
									volanteAcuse = '$fechasVolantes',
									estadoTramite = '".$edoTramite."',
									proceso = 'recRec',
									presunto = '".$presunto."',
									fechaSistema = '".date('Y-m-d')."',
									usuario = '$usuario',
									juicio_nulidad ='$juicio',
									status = 1", false);
				//-------------------- ACTUALIZA OFICIO RELACIONADO -----------------------------
		}
		
		
		//------------------------- OTROS PO ----------------------------------
		/*
		if($movimiento == 'otro' ) {
			 if(stripos($folio,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			 else { $tipo = $dependencia; }
			 
			$sql = $conexion->insert("INSERT INTO otros_oficios 
										SET
											num_accion = '$accion',
											folio_volante = '$folio',
											documentoExtra = '$oficio',
											fecha = '$fechaOficio',
											acuse = '$fechaAcuse',
											leyenda = '$asunto',
											atiende = '$remitente',
											referencia = '$remitente',
											tipo = '$tipo',
											status = 1",false);
		}
		//--------------------------------- FIN OTROS ------------------------------------------------------
		//------------------------ OTROS PFRR -----------------------------------
		if($movimiento == 'pfrr_otros' )
		{
			 if(stripos($folio,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			 else {$tipo = $dependencia; }
			 
			//------------------------------------------------------------------------------
			$sql = $conexion->insert("INSERT INTO pfrr_bitacora_adicional
										SET
											folio = '$oficio',
											num_accion = '$accion',
											tipo_oficio_adicional = '$tipo',
											oficio_tipo_oficio_adicional = '$folio',
											fecha_tipo_oficio_adicional = '$fechaOficio',
											acuse_tipo_oficio_adicional = '$fechaAcuse',
											leyenda_tipo_oficio_adicional = '$asunto',
											atiende_tipo_oficio_adicional = '$remitente',
											referencia_tipo_oficio_adicional = '$remitente',
											status = 1",false);
		}
		//------------------------- OTROS MEDIOS ----------------------------------
		if($movimiento == 'medios_otros' )
		{
			 if(stripos($folio,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			 else {$tipo = $dependencia; }
			 
			//------------------------------------------------------------------------------
			$sql = $conexion->insert("INSERT INTO medios_otros_oficios 
										SET
											num_accion = '$accion',
											folio_volante = '$folio',
											documentoExtra = '$oficio',
											fecha = '$fechaOficio',
											acuse = '$fechaAcuse',
											leyenda = '$asunto',
											atiende = '$remitente',
											referencia = '$remitente',
											tipo = '$tipo',
											status = 1",false);
		}
		//------------------------- OTROS MEDIOS ----------------------------------
		if($movimiento == 'x_otros' )
		{
			 if(stripos($folio,"dgrr") !== false) {$tipo = "DGRRFEM"; }
			 else {$tipo = $dependencia; }
			 
			//------------------------------------------------------------------------------
			$sql = $conexion->insert("INSERT INTO x_otros_oficios 
										SET
											num_accion = '$accion',
											folio_volante = '$folio',
											documentoExtra = '$oficio',
											fecha = '$fechaOficio',
											acuse = '$fechaAcuse',
											leyenda = '$asunto',
											atiende = '$remitente',
											referencia = '$remitente',
											tipo = '$tipo',
											status = 1",false);
		}
		*/
	  //-------------------- ACTUALIZA OFICIO RELACIONADO -----------------------------
	  $sql = $conexion->update("UPDATE oficios_contenido SET respondido = 1 WHERE folio LIKE '".$ofiRef."' ", false);
	  //incremetamos para la siguiente variable
      $i++;
   }//end while
}
//--------------------- ADMINISTRACION ESTA AFUERA DEBIDO A QUE NO MANEJA ACCION -----------------------------
if($movimiento == 'administracion')
{
	 if(stripos($folio,"dgrr") !== false) {$tipo = "DGR"; }
	 else {$tipo = $dependencia; }
	//------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO otros_oficios 
								SET
									num_accion = 'administracion',
									folio_volante = '$folio',
									documentoExtra = '$oficio',
									fecha = '$fechaOficio',
									acuse = '$fechaAcuse',
									leyenda = '$asunto',
									atiende = '$remitente',
									referencia = '$remitente',
									tipo = '$tipo',
									status = 1",false);
}
//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
	$sql = $conexion->select("SELECT * FROM volantes_remitentes WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
	$total = mysql_num_rows($sql);
	
	if($total == 0)
		$sql = $conexion->insert("INSERT INTO volantes_remitentes SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	
		
		
//------------------------------------------------------
// validamos que no haya fallo----
if($error == "")
	echo $folio;
else echo $txtEror;
?>

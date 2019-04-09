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
	$entidadFis = $_REQUEST['accionEntidad'];
}else{
	$totAcciones= valorSeguro($_REQUEST['totalAcciones']);
	$usuario 	= valorSeguro($_REQUEST['usuario']);
	$nivel 		= valorSeguro($_REQUEST['nivel']);
	$turnado	= valorSeguro($_REQUEST['accionTurnado'][0]);
	$direccion 	= valorSeguro($_REQUEST['accionDireccion'][0]);
	$juicio = valorSeguro($_REQUEST['juicio']);
	$entidadFis = $_REQUEST['accionEntidad'][0];
}
//------------------- GENERACION DEL VOLANTE -------------------------------------------------
//--------------------------------------------------------------------------------------------
$fechasVolantes = date('Y-m-d');
$horasVolantes = date("H:i:s");
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
$datosVolante = generaVolantes($tipo, $fechasVolantes, $horasVolantes, $turnado, $usuario, $direccion, $totAcciones);
$folio = $datosVolante['folio'];
$ultimo_id = $datosVolante['ultimo_id'];
$sql = $datosVolante['sql'];
//-------------------------- PROCESAMOS ACCIONES -------------------------------
//------------------------------------------------------------------------------
if($sql != false)
{
   //--------------------------------------------------------------------------------------------
   $acciones 	= $_REQUEST['accionVinculada'];
   $noAcciones	= count($acciones);
   $i        	= 0;
   $j			= 0;
   //--------------------------------------------------------------------------------------------
   if($_REQUEST['tipoPOST'] == "sencillo") $noAcciones = 1;
   //--------------------------------------------------------------------------------------------
   while ($j < $noAcciones)
   {
	   if($noAcciones > 1){
		   if($j >= 1) $coma = ", ";
		   else $coma = "";
		   $todosRecurrentes .= $coma.valorSeguro($_REQUEST['presuntoVinculada'][$j]);
	   }
	   //incremetamos para la siguiente variable
      $j++;
   }
   $sql = $conexion->update("UPDATE volantes SET presunto = '".$todosRecurrentes."' WHERE id = $ultimo_id ", false);
   //-------------------------------------------------------------------------------------------
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
			$remitente	= valorSeguro($_REQUEST['accionRemitente']);
			$cargo		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionCargo'])))); 
			$dependencia= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDependencia'])));
			$oficio		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionOficio'])))); 
			$turnado	= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['turnado'])))); 
			$fechaOficio= valorSeguro(fechaMysql($_REQUEST['accionOfiFec']));
			$fechaAcuse	= valorSeguro(fechaMysql($_REQUEST['accionOfiFecAcu']));
			$cral		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionCral'])));
			$fechaCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFe']));
			$acuseCral	= valorSeguro(fechaMysql($_REQUEST['accionCralFecAcu']));
			$dt 		= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDt']))); 
			$ofiRef		= $_REQUEST['accionOfiRef']; 
		} elseif ($_REQUEST['tipoPOST'] == "tipoFormRR") {
			$accion 	= valorSeguro($_REQUEST['accionVinculada'][$i]);
			$presunto 	= valorSeguro($_REQUEST['presuntoVinculada'][$i]);
			$idPresunto	= valorSeguro($_REQUEST['idPresuntoVinculada'][$i]);
			$movimiento = valorSeguro($_REQUEST['movimiento']);
			$edoTramite = valorSeguro($_REQUEST['accionEstado'][$i]);
			$asunto		= urldecode(valorSeguro($_REQUEST['asunto']));
			$remitentex=explode("-", $_REQUEST['presuntoAccion']);
			$rem1=$remitentex[0];
			$remitente	= $rem1;
			$cargo		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['cargo'])))); 
			$dependencia= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDependencia'][$i])));
			$oficio		= "RR"; 
			$fechaOficio= valorSeguro(fechaMysql($_REQUEST['fechaOficio']));
			$fechaAcuse	= valorSeguro(fechaMysql($_REQUEST['fechaAcuse']));
			$cral		= "";
			$fechaCral	= "";
			$acuseCral	= "";
			$dt 		= ""; 
			$ofiRef		= ""; 
		} else {
			$accion 	= valorSeguro($_REQUEST['accionVinculada'][$i]);
			$presunto 	= valorSeguro($_REQUEST['presuntoVinculada'][$i]);
			$idPresunto	= valorSeguro($_REQUEST['idPresuntoVinculada'][$i]);
			$movimiento = valorSeguro($_REQUEST['accionRef'][$i]);
			$edoTramite = valorSeguro($_REQUEST['accionEstado'][$i]);
			$asunto		= urldecode(valorSeguro($_REQUEST['accionAsunto'][$i]));
			$remitente	= valorSeguro($_REQUEST['accionRemitente'][$i]);
			$cargo		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionCargo'][$i])))); 
			$dependencia= stripslashes(html_entity_decode(valorSeguro($_REQUEST['accionDependencia'][$i])));
			$oficio		= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['accionOficio'][$i])))); 
			$turnado	= stripslashes(html_entity_decode(urldecode(valorSeguro($_REQUEST['turnado'][$i]))));
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
									presunto = '$presunto',
									idPresunto = '$idPresunto'
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
					if ($edoTramite == 11) { $inic_edotramite = 15; } else { $inic_edotramite = $edoTramite; }
				$sql = $conexion->update("UPDATE pfrr
									SET 
										detalle_edo_tramite= $inic_edotramite,
										usuario='".$usuario."',
										fecha_edo_tramite='$fechasVolantes',
										hora='$horasVolantes'  
									WHERE num_accion = '".$accion."'" 
										,false);
										/*/ n__n //------------------------------ INSERTA HISTORIAL PFRR -------------------------------------------------
										if ($edoTramite == 11){
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
										}// n_n*/
										//------------------------------ INSERTA HISTORIAL PFRR -------------------------------------------------
			
				if($edoTramite == 27){
				$sql = $conexion->update("UPDATE pfrr
									SET 
										detalle_edo_tramite= '14',
										usuario='".$usuario."',
										fecha_edo_tramite='$fechasVolantes',
										hora='$horasVolantes'  
									WHERE num_accion = '".$accion."'" 
										,false);
				
										
										
				}						
				//----------------------- actualiza PO si es solventacion previa al inicio del PFRR
				if($edoTramite == 14){				
					$sql = $conexion->update("UPDATE po
								SET 
									detalle_de_estado_de_tramite = '9',
									ip_edo_tram = '".$usuario."',
									fecha_estado_tramite = '$fechasVolantes',
									hora_act_edo_tram = '$horasVolantes'  
								WHERE num_accion = '".$accion."'" 
									,false);
				}
				//----------------------- respuesta técnica de la UAA suma 90 días
				if($edoTramite == 28){	
				//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
					//$fecha90 = strtotime ( '+90 day' , strtotime ( $fechasVolantes ) ) ;
					//$fecha90 = date ( 'Y-m-d' , $fecha90 );
					//----------------------------------------------------------------------------------------------
					//$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 28,  limite_cierre_instruccion = '".$fecha90."', fecha_analisis_documentacion = '".$fecha."',usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
					$sqlpfrr = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = 28, fecha_analisis_documentacion = '".$fechasVolantes."' WHERE num_accion='".$accion."' ",false);
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
		if($movimiento == "100") {
				
					$sql = $conexion->update("update opiniones 
											SET 
											detalle_de_estado_de_tramite = '100',
											ip_edo_tram='".$usuario."',
											fecha_estado_tramite = '$fechasVolantes',
											hora_act_edo_tram='$horasVolantes' where  num_accion LIKE '%".$accion."%'"
											,false);
				//end totreg
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
		//------------------------------------- OPIONIONES LEGALES PROCESO DE NOTIFICACION -------------------------------------------
		if($movimiento == "104") {
				
					$sql = $conexion->update("update opiniones 
											SET 
											detalle_de_estado_de_tramite = '104',
											ip_edo_tram='".$usuario."',
											fecha_estado_tramite = '$fechasVolantes',
											hora_act_edo_tram='$horasVolantes' where  num_accion_po LIKE '%".$accion."%'"
											,false);
				//end totreg
				//--------------------- INSERTA HISTORIAL OPINIONES -----------------------------------------						
			
								$sql0= $conexion->select("SELECT * from opiniones where num_accion_po LIKE '%".$accion."%'");
								$r0=mysql_fetch_array($sql0);
								$accionpo=$r0['num_accion'];

				$sql = $conexion->insert("INSERT INTO opiniones_historial 
								  SET
									num_accion = '$accionpo',
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
		
								
			//---------------------------PASAR A PO-------------------------------------------
			
					$sql2= $conexion->select("SELECT * from opiniones where num_accion_po LIKE '%".$accion."%'");
					
					$r=mysql_fetch_array($sql2);
					$accionco=$r['num_accion_po'];
					$fase=$r['fase'];
					$cp=$r['cp'];
					$uaa=$r['uaa'];
					$entidad_accion=$r['entidad_accion'];
					$entidad_fiscalizada=$r['entidad_fiscalizada'];
					$num_auditoria=$r['num_auditoria'];
					$fondo=$r['fondo'];
					$direccion=$r['direccion'];
					$subdirector=$r['subdirector'];
					$abogado=$r['abogado'];
					$detalle_de_estado_de_tramite=$r['detalle_de_estado_de_tramite'];
					$fecha_estado_tramite=$r['fecha_estado_tramite'];
					$irregularidad_general=$r['irregularidad_general'];
					$fecha_de_irregularidad_general=$r['fecha_de_irregularidad_general'];
					$termino_irregularidad_general=$r['termino_irregularidad_general'];
					$numero_de_pliego=$r['numero_de_pliego'];
					$fecha_del_pliego=$r['fecha_del_pliego'];
					$monto_de_po_en_pesos=$r['monto_de_po_en_pesos'];
					$hora_act_edo_tram=$r['hora_act_edo_tram'];
					$ip_edo_tram=$r['ip_edo_tram'];
					$prescripcion=$r['prescripcion'];
					$subnivel=$r['subnivel'];
					$bajaAnunciada=$r['bajaAnunciada'];
					$monto_modificado=$r['monto_modificado'];
					$fojas=$r['fojas'];
					$asofis=$r['asofis'];
					
			
								$sql = $conexion->insert("INSERT INTO PO 
								  SET
									num_accion = '$accionco',
									fase = '$fase',
									cp = '$cp',
									uaa = '$uaa',
									entidad_accion = '$entidad_accion',
									entidad_fiscalizada = '$entidad_fiscalizada',
									num_auditoria = '$num_auditoria',
									fondo = '$fondo',
									direccion = '$direccion',
									subdirector = '$subdirector',
									abogado = '$abogado',
									detalle_de_estado_de_tramite = 5,
									fecha_estado_tramite = '$fecha_estado_tramite',
									irregularidad_general = '$irregularidad_general',
									ip_edo_tram = '$usuario',
									subnivel = '$subnivel',
									hora_act_edo_tram = '".date('H:i:s')."',
									numero_de_pliego = '$numero_de_pliego'
									"
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
									idPresunto = '".$idPresunto."',
									fechaSistema = '".date('Y-m-d H:i:s')."',
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
									idPresunto = '".$idPresunto."',
									fechaSistema = '".date('Y-m-d H:i:s')."',
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
									idPresunto = '".$idPresunto."',
									fechaSistema = '".date('Y-m-d H:i:s')."',
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
									turnado = '$turnado',
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

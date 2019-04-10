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
foreach($_POST as $nombre_campo => $valor)
{
   $resultado = strpos($nombre_campo, "accionVinculada_"); 
   if($resultado  !== FALSE)
   {
	   if($con == 0) $accion = valorSeguro($valor);
	   $acciones .= valorSeguro($valor)."|";
	   $con++;
   }
   else
   {
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
   }
}
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
	$folio = generaOficios($tipo = "po",$fechaOficio, $horaOficio, $acciones, $presunto = "", $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio);
	//-------------------------------------------------------------------------------

	
	// lo creamos con estatus 0
	if($tipoOficio == "asistencia")	
	{
		$partesAcciones = explode("|",$acciones);
		
		foreach($partesAcciones as $k => $v)
		{
			if($v != "")
			{
				$sqltxtX = "INSERT INTO po_historial 
				(
					num_accion,
					tipo,
					oficio,
					oficioRecepcion,
					estadoTramite,
					fechaSistema,
					horaSistema,
					usuario,
					nombreProceso,
					status,
					tipo_devolucion
				) 
				VALUES 
				(
					'".$v."',
					'asistencia/devolucion',
					'".$folio."',
					'".$fechaOficio."',
					'3',
					'".$fechaOficio."',
					'".$horaOficio."',
					'".$userForm."',
					'3',
					0,
					'".$tipoOficio."'
				)";
				$sqlAs = $conexion->insert($sqltxtX,false);
			}
		}
		//echo $sqltxtX;
	}
	//--------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------
	$partesAcciones = explode("|",$acciones);
	//-------------- INSERTAMOS EN LA TABLA FOLIOS CONTENIDO CADA ACCION -------------------------------
	foreach($partesAcciones as $k => $v)
	{
		if($v != "")
		{
			$sqlX = $conexion->insert("INSERT INTO oficios_contenido 
										SET 
											 folio = '".$folio."',
											 num_accion = '".$v."',
											 oficio_referencia = '".$oficioRef."',
											 juridico = 1 ",false);
		}
	}
	//-------------- INSERTAMOS CADA ACCION EN HISTORIAL DE MANERA INDIVIDUAL --------------------------
	if($tipoOficio == "otros") 	
	{
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
	}
	//-------------------------------------------------------------------------------
	//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
			
	if($tipoOficio == 'notificacionEF' || $tipoOficio == 'notificacionICC'|| $tipoOficio=='remisionUAA' || $tipoOficio='docu_uaa')
	{
		
		$remNom = $remitente;
		$remCar = $cargo;
		$remDep = $dependencia;
		$fechaPO = $fechaPO;
		
		//iniciales
		$user = dameUsuario($userForm);
		$usNombre = iniciales($user['nombre']);
		$usJefe = iniciales($user['jefe']);
		$usSubd = iniciales($user['subdirector']);
		$usDir = iniciales($user['director']);
		$iniciales = $usDir."/".$usSubd."/".$usJefe."/".$usNombre;
		
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
		$mm = /*($datos['monto_modificado'] != "") ? $datos['monto_modificado'] :*/ $datos['monto_de_po_en_pesos'];
		$ua = $datos['ua'];
		$di = $datos['director'];
		$ca = $datos['cargo'];
		
		
				//sacamos datos oficios notificacion para remitir a la uaa
		$query = "SELECT *
					FROM oficios
					WHERE num_accion like '%".$accion."%' 
						and tipo ='notificacionEF'
						and status <> 0
					LIMIT 1";
					
		$sql = $conexion->select($query, false);
		$totalOf = mysql_num_rows($sql);
		$datos = mysql_fetch_array($sql);

		$folioef = $datos['folio'];
		$gobernador = $datos['destinatario'];
		$cargo = $datos['cargo_destinatario'];
		$fechaofi = $datos['fecha_oficio'];
		
		
		//ICC
				$query = "SELECT *
					FROM oficios
					WHERE num_accion like '%".$accion."%' 
						and tipo ='notificacionICC'
						and status <> 0
					LIMIT 1";
					
		$sql = $conexion->select($query, false);
		$totalOf = mysql_num_rows($sql);
		$datos = mysql_fetch_array($sql);

		$folioicc = $datos['folio'];
		$titular = $datos['destinatario'];
		$cargoicc = $datos['cargo_destinatario'];
		$fechaofiicc = $datos['fecha_oficio'];
		
		
//Acuse Oficio EF

				$query = "SELECT acuseNotEntidad
				FROM po_historial
				WHERE num_accion ='".$accion."' and tipo ='notificación'
					
				LIMIT 1";
					
		$sql = $conexion->select($query, false);
		$totalOf = mysql_num_rows($sql);
		$datos = mysql_fetch_array($sql);

		$acuse = $datos['acuseNotEntidad'];



		
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
					iniciales = '".$iniciales."',
					fecha_sistema = '".$fechaOficio."',
					folioef = '".$folioef."',
					fechaofi = '".$fechaofi."',
					acuse = '".$acuse."',
					folioicc = '".$folioicc."',
					gobernador = '".$gobernador."',
					cargo = '".$cargo."',
					titular = '".$titular."',
					cargoicc = '".$cargoicc."',
					
					hora_sistema  = '".$horaOficio."' ";
		$sql = $conexion->insert($query1,false);
		
	}
	
	echo $folio."|".$po."|".$cp."|".$ef."|".$mm."|".$ua."|".$di."|".$ca."|".$remNom."|".$remCar."|".$remDep."|".$fechaPO."|".$fojas."|".$fechaOficio."|".$horaOficio."|".$iniciales."|".$accion."|".$folioef."|".$gobernador."|".$cargo."|".$fechaofi."|".$folioicc."|".$fechaofiicc."|".$acuse."|".$titular."|".$cargoicc;
}// end TO
else
{ echo "<br><br><center><h2>Ya existe un oficio idéntico... <br> Notifíquelo a la Administración </center></h2>"; }


@mysql_free_result($sql);
?>

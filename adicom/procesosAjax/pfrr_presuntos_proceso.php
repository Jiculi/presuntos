<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
$tipoFecha = valorSeguro($_REQUEST['tipoFecha']);
//---------------------------------------------------------------------------------------------------
// fecha citatorio 
if($tipoFecha == "citatorio")
{
	print_r($_POST);
	$idpresunto = 	valorSeguro($_REQUEST['idpresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);

	$oficio_citatorio=	valorSeguro($_REQUEST['oficio_citatorio']);
	$fecha_oficio_cit=	fechaMysql($_REQUEST['fecha_oficio_cit']);
	$fecha_noti_cit=	fechaMysql($_REQUEST['fecha_noti_cit']);
	$tipo_noti= valorSeguro($_REQUEST['tipo_noti']);
	$fecha_citacion=	fechaMysql($_REQUEST['fecha_citacion']);
	$cambiaEdo16 =		valorSeguro($_REQUEST['cambiaEdo']);

	$sql = $conexion->update("INSERT pfrr_audiencias
							  SET 
								  num_accion = '".$accion."',
								  idPresunto = '".$idpresunto."',
								  presunto = '".$presunto."',
								  rfc = '".$rfc."',
								  oficio_citatorio='".$oficio_citatorio."',
								  fecha_oficio_citatorio='".$fecha_oficio_cit."',
								  fecha_notificacion_oficio_citatorio='".$fecha_noti_cit."',
								  tipo_notificacion='".$tipo_noti."',
								  fecha_audiencia='".$fecha_citacion."',
								  tipo = 1
							",false);
	
	
	if($cambiaEdo16)
	{
		$sql1 = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = '16',usuario='".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora='".date("h:i:s")."' WHERE num_accion='".$accion."' and (detalle_edo_tramite = '30' or detalle_edo_tramite < '17') ",false);
		
		$sqltxt = "INSERT pfrr_historial 
				SET 
				 num_accion = '".$accion."',
				 tipo = 'citatorio',	
				 oficio	= '".$oficio_citatorio."',
				 estadoTramite = 16,
				 presunto = ".$idpresunto.",
				 fechaSistema = '".date("Y-m-d")."',
				 horaSistema =  '".date("h:i:s")."',	
				 usuario = '".$usuario."',	
				 nombreProceso = 16,	
				 status = 1,
				 atendido = 0, 
				 visto = 0";
				 
		$sql2 = $conexion->select($sqltxt,false);
	}
	$sql2 = $conexion->update("UPDATE oficios SET juridico='0' WHERE folio = '".$oficio_citatorio."' ",false);
	

}
//---------------------------------------------------------------------------------------------------
// fecha diferimiento 
if($tipoFecha == "noCompareceNunca")
{
	$idAud = 	valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idpresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$oficioAcuse =	valorSeguro($_REQUEST['oficioAcuse']);
	$oficio = 		valorSeguro($_REQUEST['oficio']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fechaDif']));

	$sqltxt = "UPDATE pfrr_audiencias SET comparece = 'ncn',revisada = 1 WHERE id = ".$idAud." AND num_accion = '".trim($accion)."' ";
	$sql0 = $conexion->select($sqltxt,false);
	
	//////agregada una línea 21/02/2019
	$sql1 = $conexion->update("UPDATE pfrr SET detalle_edo_tramite = '17',usuario='".$usuario."',hora='".date("h:i:s")."' WHERE num_accion='".$accion."' and (detalle_edo_tramite = '30' or detalle_edo_tramite < '17') ",false);

	$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'noCompareceNunca',	
			 estadoTramite = 16.4,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 16.4,	
			 status = 1,
			 atendido = 0, 
			 visto = 0";
	$sql2 = $conexion->select($sqltxt,false);
}
//---------------------------------------------------------------------------------------------------
// fecha diferimiento 
if($tipoFecha == "diferimiento")
{
	$idpresunto = 	valorSeguro($_REQUEST['idpresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$oficioAcuse =	valorSeguro($_REQUEST['oficioAcuse']);
	$oficio = 		valorSeguro($_REQUEST['oficio']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fechaDif']));
	// fecha_oficio_citatorio es el acuse en este paso
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
							num_accion = '".$accion."',
							idPresunto = '".$idpresunto."',
							presunto = '".$presunto."',
							rfc = '".$rfc."',
							oficio_citatorio = '".$oficio."',
							acuce_oficio_citatorio = '".$oficioAcuse."',
							fecha_audiencia = '".$fecha."',
							tipo = 2,
							revisada = 0
							");
							
	$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'diferimiento',	
			 estadoTramite = 16.1,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 16.1,	
			 status = 1,
			 atendido = 0, 
			 visto = 0";
			 
	//////agregada una línea 21/02/2019 "UPDATE pfrr SET detalle_edo_tramite = '17',usuario='".$usuario."',hora='".date("h:i:s")."' WHERE num_accion='".$accion."' and (detalle_edo_tramite = '30' or detalle_edo_tramite < '17') "
	
	$sql1 = $conexion->update("UPDATE pfrr SET usuario='".$usuario."',hora='".date("h:i:s")."' WHERE num_accion='".$accion."' ",false);
	
	$sql2 = $conexion->select($sqltxt,false);
}
//---------------------------------------------------------------------------------------------------
// fecha continuacion 
if($tipoFecha == "continuacion")
{
	$idpresunto = 	valorSeguro($_REQUEST['idPresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$oficio = 		valorSeguro($_REQUEST['oficio']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
							num_accion = '".$accion."',
							idPresunto = '".$idpresunto."',
							presunto = '".$presunto."',
							rfc = '".$rfc."',
							oficio_citatorio = '".$oficio."',
							fecha_audiencia = '".$fecha."',
							tipo = 3,
							revisada = 0
							");
	
	$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'continuacion',	
			 estadoTramite = 16.3,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 16.3,	
			 status = 1,
			 atendido = 0, 
			 visto = 0";
	$sql2 = $conexion->select($sqltxt,false);
	
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
// comparece o no comparece 
if($tipoFecha == 'compareceOno')
{
	print_r($_REQUEST);
	$id = 				valorSeguro($_REQUEST['idAud']);
	$idpresunto = 		valorSeguro($_REQUEST['idPresunto']);
	$accion = 			valorSeguro($_REQUEST['accion']);
	$cambiaEdo17 = 		valorSeguro($_REQUEST['cambiaEdo17']);
	$oficio = 			valorSeguro($_REQUEST['oficio']);
	$usuario = 			valorSeguro($_REQUEST['usuario']);
	$comparece = 		valorSeguro($_REQUEST['comparece']);
	$tipoAudiencia = 	valorSeguro($_REQUEST['tipoAudiencia']);
	//----------------------------------------------------------------
	if($comparece == 1) $comparece = "s";
	else $comparece = "n";
	//----------------------------------------------------------------
	$sqltxt = "UPDATE pfrr_audiencias SET comparece = '".$comparece."',revisada = 1 WHERE id = ".$id." AND num_accion = '".trim($accion)."' ";
	$sql0 = $conexion->select($sqltxt,false);
	if(!$sql0) $msj = "ok";
	
	if($cambiaEdo17 == 1 && $comparece == "s" && $tipoAudiencia == 1)
	{
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 17, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
		
		$sqltxt = "INSERT pfrr_historial 
					SET 
					 num_accion = '".$accion."',
					 tipo = 'desahogo',	
					 oficio	= '".$oficio."',
					 estadoTramite = 17,
					 presunto = ".$idpresunto.",
					 fechaSistema = '".date("Y-m-d")."',
					 horaSistema =  '".date("h:i:s")."',	
					 usuario = '".$usuario."',	
					 nombreProceso = 17,	
					 status = 1,
					 atendido = 1, 
					 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
	}
	if($comparece == "s" && $tipoAudiencia == 6)
	{
		$sqltxt = "INSERT pfrr_historial 
					SET 
					 num_accion = '".$accion."',
					 tipo = 'desahogo',	
					 oficio	= '".$oficio."',
					 estadoTramite = 16.2,
					 presunto = ".$idpresunto.",
					 fechaSistema = '".date("Y-m-d")."',
					 horaSistema =  '".date("h:i:s")."',	
					 usuario = '".$usuario."',	
					 nombreProceso = 16.2,	
					 status = 1,
					 atendido = 1, 
					 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
	}	
}
//---------------------------------------------------------------------------------------------------
// comparece o no comparece diferimiento
if($tipoFecha == 'compareceOnoDIF')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idpresunto']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$edo17 = 		valorSeguro($_REQUEST['estado17']);
	$oficio = 		valorSeguro($_REQUEST['oficio']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$comparece = 	valorSeguro($_REQUEST['comparece']);
	//----------------------------------------------------------------
	if($comparece == 1) $comparece = "s";
	else $comparece = "n";
	//----------------------------------------------------------------
	$sqltxt = "UPDATE pfrr_audiencias SET comparece = '".$comparece."',revisada = 1 WHERE id = ".$id." AND num_accion = '".$accion."' ";
	$sql0 = $conexion->select($sqltxt,false);
	if(!$sql0) $msj = "ok";
	
}
//---------------------------------------------------------------------------------------------------
// ofrecfimiento de pruebas
if($tipoFecha == 'ofrecimientoPruebas')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idPresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo18 = 	valorSeguro($_REQUEST['cambiaEdo18']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	//----------------------------------------------------------------
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
						num_accion = '".$accion."',
						idPresunto = '".$idpresunto."',
						presunto = '".$presunto."',
						rfc = '".$rfc."',
						fecha_audiencia = '".$fecha."',
						fecha_pruebas = '".$fecha."',
						tipo = 4,
						revisada = 1
						");
	//----------------------------------------------------------------
	if($cambiaEdo18)
	{
		$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'ofrecimientoPruebas',	
			 estadoTramite = 18,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 18,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
		
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 18, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
// ofrecimientoAdmision
if($tipoFecha == 'ofrecimientoAdmision')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idPresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo18 = 	valorSeguro($_REQUEST['cambiaEdo18']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	//----------------------------------------------------------------
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
						num_accion = '".$accion."',
						idPresunto = '".$idpresunto."',
						presunto = '".$presunto."',
						rfc = '".$rfc."',
						fecha_audiencia = '".$fecha."',
						fecha_admision = '".$fecha."',
						tipo = 5,
						revisada = 1
						");
	//----------------------------------------------------------------
	if($cambiaEdo18)
	{
		$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'ofrecimientoPruebas',	
			 estadoTramite = 18.1,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 18.1,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
		
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 18, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
// ofrecimientoDesahogo
if($tipoFecha == 'ofrecimientoDesahogo')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idPresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo18 = 	valorSeguro($_REQUEST['cambiaEdo18']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	//----------------------------------------------------------------
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
						num_accion = '".$accion."',
						idPresunto = '".$idpresunto."',
						presunto = '".$presunto."',
						rfc = '".$rfc."',
						fecha_audiencia = '".$fecha."',
						fecha_desahogo = '".$fecha."',
						tipo = 6,
						revisada = 1
						");
	//----------------------------------------------------------------
	if($cambiaEdo18)
	{
		$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'ofrecimientoPruebas',	
			 estadoTramite = 18.2,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 18.2,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
		
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 18, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
// ofrecfimiento de pruebas
if($tipoFecha == 'periodoAlegatos')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$idpresunto = 	valorSeguro($_REQUEST['idPresunto']);
	$presunto = 	valorSeguro($_REQUEST['presunto']);
	$cargo = 		valorSeguro($_REQUEST['cargo']);
	$dependencia = 	valorSeguro($_REQUEST['dependencia']);
	$rfc = 			valorSeguro($_REQUEST['rfc']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo31 = 	valorSeguro($_REQUEST['cambiaEdo31']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	//----------------------------------------------------------------
	$sql=$conexion->insert("INSERT INTO pfrr_audiencias SET 
						num_accion = '".$accion."',
						idPresunto = '".$idpresunto."',
						presunto = '".$presunto."',
						rfc = '".$rfc."',
						fecha_audiencia = '".$fecha."',
						fecha_pruebas = '".$fecha."',
						tipo = 7,
						revisada = 1
						");
	//----------------------------------------------------------------
	if($cambiaEdo31)
	{
		$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'alegatos',	
			 estadoTramite = 31,
			 presunto = ".$idpresunto.",
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 31,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
		
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 31, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
	}
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
// fecha última actuación
if($tipoFecha == 'fechaUltimaActuacion')
{
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo28 = 	valorSeguro($_REQUEST['cambiaEdo28']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	/*//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
	$fecha90 = strtotime ( '+90 day' , strtotime ( $fecha ) ) ;
	$fecha90 = date ( 'Y-m-d' , $fecha90 );
	//----------------------------------------------------------------*/
	$sqltxt = "
		INSERT INTO pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = 'ultima actuacion',	
			 oficioRecepcion = '".$fecha."',
			 estadoTramite = 28,
			 presunto = '".$idpresunto."',
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 28,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 28, fecha_analisis_documentacion = '".$fecha."',usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
	$sql1 = $conexion->select($sqltxt,false);
	echo print_r($_POST); 
}
//---------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------
// cierre de instruccion
if($tipoFecha == 'FecierreInstruccionx')
{
	$id = 			valorSeguro($_REQUEST['idAud']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo22 = 	valorSeguro($_REQUEST['cambiaEdo22']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$fecha9 = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$sobres =		valorSeguro($_REQUEST['sbsm']);
	$rs=             valorSeguro($_REQUEST['rs']);
	
	//--------------------- SUMAMOS 90 DÍAS NATURALES A FECHA ------------------------------------------
	$fecha90 = strtotime ( '+90 day' , strtotime ( $fecha9 ) ) ;
	$fecha90 = date ( 'Y-m-d' , $fecha90 );
	//----------------------------------------------------------------
	//----------------------------------------------------------------
		
	$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 22, cierre_instruccion = '".$fecha."', limite_cierre_instruccion = '".$fecha90."', usuario = '".$usuario."', fecha_edo_tramite = '".date("Y-m-d")."', hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
	$sql1 = $conexion->select($sqltxt,false);

	echo print_r($_POST); 
}




//--------------------- SUMAMOS 45 DÍAS NATURALES A FECHA SOBRESEIMIENTO--------------------------------
//--------------------- SUMAMOS 45 DÍAS NATURALES A FECHA SOBRESEIMIENTO--------------------------------
if($tipoFecha == 'FecierreInstruccionxx')
{
	$id = 			valorSeguro($_REQUEST['x']);
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo22 = 	valorSeguro($_REQUEST['cambiaEdo22']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$fecha9 = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$sobres =		valorSeguro($_REQUEST['sbsm']);
	$rs=            valorSeguro($_REQUEST['RS']);
	
	//--------------------- SUMAMOS 45 DÍAS NATURALES A FECHA ------------------------------------------
	$fecha45 = strtotime ( '+45 day' , strtotime ( $fecha9 ) ) ;
	$fecha45 = date ( 'Y-m-d' , $fecha45 );
		
	
	$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 22, cierre_instruccion = '".$fecha."', limite_cierre_instruccion = '".$fecha45."', usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."', RS= '1' WHERE num_accion = '".$accion."' ";
	$sql1 = $conexion->select($sqltxt,false);

	echo print_r($_POST); 
}


//---------------------------------------------------------------------------------------------------
// fecha resolucion
if($tipoFecha == 'fechaResolucion')
{
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo29 = 	valorSeguro($_REQUEST['cambiaEdo29']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$tipo=			valorSeguro($_REQUEST['tipo']);
	//----------------------------------------------------------------
	$sqltxt = "INSERT pfrr_historial 
		SET 
		 num_accion = '".$accion."',
		 tipo = '".$tipo."',
		 oficioRecepcion = '".$fecha."',
		 estadoTramite = 29,
		 fechaSistema = '".date("Y-m-d")."',
		 horaSistema =  '".date("h:i:s")."',	
		 usuario = '".$usuario."',	
		 nombreProceso = 29,	
		 status = 1,
		 atendido = 1, 
		 visto = 1";
	$sql2 = $conexion->select($sqltxt,false);
	
	$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 29, resolucion = '".$fecha."', usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."',hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
	$sql1 = $conexion->select($sqltxt,false);
	//----------------------------------------------------------------
	if($tipo=="responsabilidad")
	{
		$fechaPartes = explode("-",$fecha);
		$dia = $fechaPartes[2];
		$mes = $fechaPartes[1];
		$anio = $fechaPartes[0];
		$aniopdr= explode("0",$anio);
		$xx=$aniopdr[0];
		$aniover=$aniopdr[1];
		
		//-------------------------------------------------------------------------------
		//------------------- sacamos ultimo registro -----------------------------------
		$sqlv = $conexion->select("SELECT * from pdr_2014 order by id desc limit 1", false);
		$totalOf = mysql_num_rows($sqlv);
		$v = mysql_fetch_assoc($sqlv);
		//print_r($v);
		$fechaPartes = explode("-",$v['fecha_pdr']);
		//$folioPartes = explode("/",$v['folio']);
		//-------------------------------------------------------------------------------
		$consecutivo = $v['pdr'];
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
		
		$num_pdr= $consecutivo."/".$aniover;
		//-------------------------------------------------------------------------------
		//-------------------------------------------------------------------------------

		//generacion PDR
		/*			
		$sql =$conexion ->select ("SELECT id from pdr_2014 order by id desc limit 1");
		$rr= mysql_fetch_array ($sql);
		
		$PDR = $rr["pdr"] + 1;
		
		if($PDR < 10) $consecutivo = "00" . $PDR; 
		if($PDR < 100 && $PDR > 10 ) $consecutivo = "0" . $PDR; 
		if($PDR >= 100) $consecutivo = $PDR; 
		
		//concatenamos pdr 
		$num_pdr= "PDR".$consecutivo."/".$aniover;
		*/
			
		$sql=$conexion->insert("INSERT INTO pdr_2014 SET fecha_pdr='".fechaMysql($fecha)."',num_accion='".$accion."',usuario='".$usuario."', pdr=".$consecutivo,false);
		//$sql=$conexion->update("UPDATE pfrr SET pdr = '".$num_pdr."' where num_accion = '".$accion."'");
		echo trim($num_pdr);		
	}else echo "nada";
}
//---------------------------------------------------------------------------------------------------
// Notificacion de la Resolucion
if($tipoFecha == 'fechanotires')
{
	echo print_r($_POST); 
	$accion = 		valorSeguro($_REQUEST['accion']);
	$cambiaEdo = 	valorSeguro($_REQUEST['cambiaEdo']);
	$usuario = 		valorSeguro($_REQUEST['usuario']);
	$fecha = 		fechaMysql(valorSeguro($_REQUEST['fecha']));
	$tipo=			valorSeguro($_REQUEST['tipo']);
	$tipoNot =		valorSeguro($_REQUEST['tipoNot']);
	$tipoRes =		valorSeguro($_REQUEST['tipoRes']);
	$oficio =		valorSeguro($_REQUEST['oficio']);
	//----------------------------------------------------------------
	if($cambiaEdo)
	{
		if ($tipo =="abstencion"){
				$sqltxt = "INSERT pfrr_historial 
				SET 
				 num_accion = '".$accion."',
				 tipo = '".$tipo."',
				 oficio = '".$oficio."',
				 oficioRecepcion = '".$fecha."',
				 estadoTramite = 23,
				 fechaSistema = '".date("Y-m-d")."',
				 horaSistema =  '".date("h:i:s")."',	
				 usuario = '".$usuario."',	
				 nombreProceso = 23,	
				 status = 1,
				 atendido = 1, 
				 visto = 1";
			$sql2 = $conexion->select($sqltxt,false);
				
			$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 23, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."', hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
			$sql1 = $conexion->select($sqltxt,false);
			
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
			// tesofe
			if($tipoNot == "tesofe"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_tesofe',
				 		 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.1,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.1,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			// entidad fiscalizada
			if($tipoNot == "ef"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_ef',
						 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.2,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.2,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			// organo interno de control
			if($tipoNot == "icc"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_icc',
				 		 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.3,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.3,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
		}
		
		if ($tipo =="responsabilidad")
		{
			if($tipoNot == "presunto"){
				$sqltxt = "INSERT pfrr_historial 
				SET 
				 num_accion = '".$accion."',
				 tipo = '".$tipo."',
				 oficio = '".$oficio."',
				 oficioRecepcion = '".$fecha."',
				 estadoTramite = 24,
				 fechaSistema = '".date("Y-m-d")."',
				 horaSistema =  '".date("h:i:s")."',	
				 usuario = '".$usuario."',	
				 nombreProceso = 24,	
				 status = 1,
				 atendido = 1, 
				 visto = 1";
				 
				$sql2 = $conexion->select($sqltxt,false);
				$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 24, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."', hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
				$sql1 = $conexion->select($sqltxt,false);
			}
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
			// tesofe
			if($tipoNot == "tesofe"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_tesofe',
				 		 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.1,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.1,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			// entidad fiscalizada
			if($tipoNot == "ef"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_ef',
						 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.2,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.2,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			// organo interno de control
			if($tipoNot == "icc"){
				$sqltxt = "INSERT pfrr_historial 
						SET 
						 num_accion = '".$accion."',
						 tipo = 'res_icc',
				 		 oficio = '".$oficio."',
						 oficioRecepcion = '".$fecha."',
						 estadoTramite = 24.3,
						 fechaSistema = '".date("Y-m-d")."',
						 horaSistema =  '".date("h:i:s")."',	
						 usuario = '".$usuario."',	
						 nombreProceso = 24.3,	
						 status = 1,
						 atendido = 1, 
						 visto = 1";
				$sql2 = $conexion->select($sqltxt,false);
			}
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
		}
			
		if ($tipo =="inexistencia")
		{
			$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = '".$tipo."',
			 oficioRecepcion = '".$fecha."',
			 estadoTramite = 25,
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 25,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
		$sql2 = $conexion->select($sqltxt,false);
		$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 25, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."', hora = '".date("h:i:s")."',tipo_resolucion = '".$tipo."' WHERE num_accion = '".$accion."' ";
		$sql1 = $conexion->select($sqltxt,false);
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
				// tesofe
				if($tipoNot ==  "tesofe"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_tesofe',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.1,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.1,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
				// entidad fiscalizada
				if($tipoNot == "ef"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_ef',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.2,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.2,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
				// organo interno de control
				if($tipoNot == "icc"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_icc',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.3,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.3,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
		
		}
		
		if ($tipo =="sobreseimiento")
		{
			$sqltxt = "INSERT pfrr_historial 
			SET 
			 num_accion = '".$accion."',
			 tipo = '".$tipo."',
			 oficioRecepcion = '".$fecha."',
			 estadoTramite = 26,
			 fechaSistema = '".date("Y-m-d")."',
			 horaSistema =  '".date("h:i:s")."',	
			 usuario = '".$usuario."',	
			 nombreProceso = 26,	
			 status = 1,
			 atendido = 1, 
			 visto = 1";
			$sql2 = $conexion->select($sqltxt,false);
			$sqltxt = "UPDATE pfrr SET detalle_edo_tramite = 26
			, usuario = '".$usuario."',fecha_edo_tramite = '".date("Y-m-d")."', hora = '".date("h:i:s")."' WHERE num_accion = '".$accion."' ";
			$sql1 = $conexion->select($sqltxt,false);
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
				// tesofe
				if($tipoNot == "tesofe"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_tesofe',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.1,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.1,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
				// entidad fiscalizada
				if($tipoNot == "ef"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_ef',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.2,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.2,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
				// organo interno de control
				if($tipoNot == "icc"){
					$sqltxt = "INSERT pfrr_historial 
							SET 
							 num_accion = '".$accion."',
							 tipo = 'res_icc',
							 oficio = '".$oficio."',
							 oficioRecepcion = '".$fecha."',
							 estadoTramite = 24.3,
							 fechaSistema = '".date("Y-m-d")."',
							 horaSistema =  '".date("h:i:s")."',	
							 usuario = '".$usuario."',	
							 nombreProceso = 24.3,	
							 status = 1,
							 atendido = 1, 
							 visto = 1";
					$sql2 = $conexion->select($sqltxt,false);
				}
			//-----------------------------------------------------------------------
			//-----------------------------------------------------------------------
		}
	}// end cambia estado
}
//---------------------------------------------------------------------------------------------------
// Responsabilidades a los presuntos

if($_POST["proceso"]=="responsabilidadYpresuntos")
{
		
	$num_accion=valorSeguro($_POST['num_accion']);
	$usuario = valorSeguro($_POST['user']);
	$idpresunto = valorSeguro($_POST['idpresunto']);
	$cargo = valorSeguro($_POST['cargo']);
	$dependencia = valorSeguro($_POST['dependencia']);
	$rfc = valorSeguro($_POST['rfc']);
	$nopropor = valorSeguro($_POST['nopropor']);
	$dano = valorSeguro($_POST['dano']);
	$doctos = valorSeguro($_POST['doctos']);
	$respon = valorSeguro($_POST['respon']);
	$reintegro = valorSeguro($_POST['reintegro']);
	$aclara = valorSeguro($_POST['aclara']);
	
	
	
	if($dano=="on") $tipo_abs.="dano|";
	if($doctos=="on") $tipo_abs.="doctos|";
	if($respon=="on") $tipo_abs.="respon|";
	if($reintegro=="on") $tipo_abs.="reintegro|";
	if($aclara=="on") $tipo_abs.="aclara|";
	if($nopropor=="on") $tipo_abs.="nopropor|";

		 
	$sqltxt = "UPDATE pfrr_presuntos_audiencias SET  tipo_abs = '".$tipo_abs."' WHERE num_accion = '".$num_accion."' ";
	$sql1 = $conexion->select($sqltxt,false);


echo "responsabilidadYpresuntos  -> ".print_r($_POST);
	//------------------------------------------------------------------------------
	foreach($_REQUEST as $nombre_campo => $valor)
	{
	   $resultado = strpos($nombre_campo, "presunto_"); 
	   if($resultado  !== FALSE)
	   {
		   //sacamos todas las variables del post con el prefijo presunto_
			$cadPresunto = explode("_",$nombre_campo);
			$prefijo = $cadPresunto[0];
			$idpresunto = $cadPresunto[1]; 
			
			if($valor == 0) $resp = "No";
			if($valor == 1) $resp = "Si";
			if($valor == 2) $resp = "Ab";
			
			$query = "UPDATE pfrr_presuntos_audiencias	SET responsabilidad = '".$resp."' WHERE cont = ".$idpresunto;
			$sql2 = $conexion->update($query,false);
	   }//end si existe campo presunto_
	}
}





?>
 





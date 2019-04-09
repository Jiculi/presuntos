<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

include("../includes/clasesMysqli.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();
unset($links);
$pendientes = 0;
$pendientesDG = 0;
//------------------------------------------------------------------------------
$direccion = $_REQUEST['direccion'];
$nivel = $_REQUEST['nivel'];
$usuario = $_REQUEST['usuario'];

// SACAMOS USUARIOS QUE SE DESGLOSAN DE SU NIVEL --------
$sqlU  = $conexion->select("SELECT * FROM usuarios WHERE  nivel <> 'BECARIO' AND nivel LIKE '".$nivel."%' ", false);
while($rU = mysqli_fetch_array($sqlU)) {
	$usuarios .= "'".$rU['usuario']."',";
	$niveles .= "'".$rU['nivel']."',";
}
$usuarios = substr($usuarios,0,strlen($usuarios)-1);
$niveles = substr($niveles,0,strlen($niveles)-1);
//---------------------------------------------------------------------------------------------
if($direccion == "DG")
{
	//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS PO -------------------------
	$sql = $conexion->select("SELECT *, OC.id AS idXaccion, O.folio AS folioOficio, OC.num_accion AS accionSola 
								FROM oficios_contenido OC 
								INNER JOIN oficios O ON OC.folio = O.folio 
								WHERE 
									O.tipo = 'asistencia' AND 
									O.status <> 0 AND 
									OC.atendido = 0 
								ORDER BY fecha_oficio desc,hora_oficio desc ", false);
	$totalDev = 0;
	$totalDev = mysqli_num_rows($sql);
	$pendientesDG += $totalDev;
	$vinetas = "";
	
	while($r = mysqli_fetch_array($sql))
	{
		$noAccion = str_replace("|","",$r['num_accion']);
		//$vinetas .= "<li><a href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$r['accionSola']."',100,'cont/po_pendientesDEV.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&usuario=".$r['abogado_solicitante']."')\">".$r['accionSola']." </a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_oficio']." ".$r['hora_oficio'],'titulo' => "Cral Pendiente PO", 'link' => "
		<li>
			<a class='linkNoti poLink' href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$r['accionSola']."',100,'cont/po_pendientesDEV.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&usuario=".$r['abogado_solicitante']."')\"> 
				<div style='float:left'> <img src='images/blue-document-download-icon.png' /> </div> 
				<div style='float:left'> PO CRAL Devolución <br>".$r['accionSola']."  </div>
				<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."<br>".$r['hora_oficio']."</div> 
			</a> 
			<div class='clear'>
		</li>");
	}
	
	
	
	if($direccion == "DG")
{
	//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS OPINION -------------------------
	$sql = $conexion->select("SELECT *
								FROM oficios
								 
								WHERE 
									tipo = 'opi_legal' AND 
									status <> 0 AND 
									atendido = 0 
								ORDER BY fecha_oficio desc,hora_oficio desc ", false);
	$totalDev = 0;
	$totalDev = mysqli_num_rows($sql);
	$pendientesDG += $totalDev;
	$vinetas = "";
	
	while($r = mysqli_fetch_array($sql))
	{
		$noAccion = str_replace("|","",$r['num_accion']);
		//$vinetas .= "<li><a href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$r['accionSola']."',100,'cont/po_pendientesDEV.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&usuario=".$r['abogado_solicitante']."')\">".$r['accionSola']." </a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_oficio']." ".$r['hora_oficio'],'titulo' => "OL PO", 'link' => "
		<li>
			<a class='linkNoti olLink' href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$noAccion."',100,'cont/opiniones_pendientesDEV.php','id=".$r['id']."&numAccion=".$noAccion."&oficio=".$r['folio']."&usuario=".$r['abogado_solicitante']."')\"> 
				<div style='float:left'> <img src='images/orange-document-download-icon.png' /> </div> 
				<div style='float:left'> OL CRAL Devolución <br>".$noAccion."  </div>
				<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."<br>".$r['hora_oficio']."</div> 
			</a> 
			<div class='clear'>
		</li>");
	}
}
	
	//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS PFRR -------------------------
	$sql = $conexion->select("SELECT *, OC.id AS idXaccion, O.folio AS folioOficio, OC.num_accion AS accionSola FROM oficios_contenido OC INNER JOIN oficios O ON OC.folio = O.folio WHERE O.tipo = 'dtns_PFRR' AND O.status <> 0 AND OC.atendido = 0 ORDER BY fecha_oficio desc,hora_oficio desc ", false);
	$totDevPfrr = 0;
	$totDevPfrr = mysqli_num_rows($sql);
	$pendientesDG += $totDevPfrr;

	$vinCralPfrr = "";
	
	while($r = mysqli_fetch_array($sql))
	{
		$noAccion = str_replace("|","",$r['num_accion']);
		//$vinCralPfrr .= "<li><a href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$r['accionSola']."',100,'cont/po_pendientesDEV.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&usuario=".$r['abogado_solicitante']."')\">".$r['accionSola']." </a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_oficio']." ".$r['hora_oficio'],'titulo' => "Cral Pendiente PFRR",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro1 = new mostrarCuadro(350,800,'Devolucion ".$r['accionSola']."',100,'cont/po_pendientesDEV.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&usuario=".$r['abogado_solicitante']."')\"> 
				<div style='float:left'> <img src='images/green-document-download-icon.png' /> </div> 
				<div style='float:left'> PFRR CRAL Devolución <br>".$r['accionSola']."  </div>
				<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."<br>".$r['hora_oficio']."</div>  
			</a>         
			<div class='clear'>	</div>           
		</li>");
	}
}





//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS ATENDIDOS PO -------------------------
$TXTSQL = "SELECT *, OC.id AS idXaccion, OC.folio AS folioOficio, OC.num_accion AS accionSola 
							FROM oficios_contenido OC 
							INNER JOIN oficios O ON OC.folio = O.folio 
							WHERE 
								O.abogado_solicitante IN (".$usuarios.") 
								AND O.tipo = 'asistencia' 
								AND O.status <> 0 
								AND OC.atendido = 1 
								AND OC.visto = 0 
							ORDER BY O.fecha_oficio desc,O.hora_oficio desc ";

$sql = $conexion->select($TXTSQL, false);

$totalCral = 0;							
$totalCral = mysqli_num_rows($sql);
$pendientes += $totalCral;
$vineCral = "";

while($r = mysqli_fetch_array($sql))
{
	$oficioConvertido = str_replace("/","!",$r['folioOficio']);
	$txt = "SELECT * FROM archivos WHERE num_accion = '".$r['accionSola']."' AND oficio = '".$r['folioOficio']."' ";
	
	$sqlS = $conexion->select($txt, false);
	
	while($rS = mysqli_fetch_array($sqlS))
	{
		//$vineCral .= "<li><a href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$r['accionSola']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$rS['oficioDoc']." ',10,'cont/po_verCRAL.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&sicsa=".$rS['oficioDoc']."&usuario=".$r['abogado_solicitante']."')\">".$r['accionSola']."</a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_oficio'],'titulo' => "Cral PO",'link' => "
			<li>
				<a class='linkNoti poLink' href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$r['accionSola']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$rS['oficioDoc']." ',10,'cont/po_verCRAL.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&sicsa=".$rS['oficioDoc']."&usuario=".$r['abogado_solicitante']."')\"> 
					<div style='float:left'> <img src='images/blue-document-download-icon.png' /> </div> 
					<div style='float:left'> PO CRAL Devolución <br>".$r['accionSola']." </div> 
					<div style='float:right; margin:0 5px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."</div>  
					</div>    
					<div class='clear'>
					 
				</a>  
			</li>");
	}
}

//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS ATENDIDOS OL -------------------------
$TXTSQL = "select * from oficios inner join archivos on folio=oficio where abogado_solicitante = '".$usuario."' and tipo='opi_legal' and atendido='1'";								 ;

$sql = $conexion->select($TXTSQL, false);

while($r = mysqli_fetch_array($sql))
{
	//$accionOfi=$r['num_accion'];
	$folioOfi=$r['folio'];
		//$vineCral .= "<li><a href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$r['accionSola']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$rS['oficioDoc']." ',10,'cont/po_verCRAL.php','id=".$r['idXaccion']."&numAccion=".$r['accionSola']."&oficio=".$r['folioOficio']."&sicsa=".$rS['oficioDoc']."&usuario=".$r['abogado_solicitante']."')\">".$r['accionSola']."</a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_oficio'],'titulo' => "Cral OL",'link' => "
			<li>
				<a class='linkNoti olLink' href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$r['num_accion']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$r['oficioDoc']." ' ,10,'cont/opi_verCRAL.php','numAccion=".$r['num_accion']."&oficio=".$r['folio']."&sicsa=".$r['oficioDoc']."&usuario=".$r['abogado_solicitante']."&tipoDoc=".$r['tipoDoc']."')\"> 
					<div style='float:left'> <img src='images/orange-document-download-icon.png' /> </div> 
					<div style='float:left'> OL CRAL Devolución <br>".$r['num_accion']." </div> 
					<div style='float:right; margin:0 5px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."</div>  
					</div>    
					<div class='clear'>
					 
				</a>  
			</li>");
	
}
//-------------------------- SQL VERIFICA DEVOLUCIONES CRALS ATENDIDOS PFRR -------------------------
$TXTSQLPfrr = "SELECT *, OC.id AS idXaccion, OC.folio AS folioOficio, OC.num_accion AS accionSola 
							FROM oficios_contenido OC 
							INNER JOIN oficios O ON OC.folio = O.folio 
							WHERE 
								O.abogado_solicitante IN (".$usuarios.") 
								AND O.tipo = 'dtns_PFRR' 
								AND O.status <> 0 
								AND OC.atendido = 1 
								AND OC.visto = 0 
							ORDER BY O.fecha_oficio desc,O.hora_oficio desc ";
							
$sqlPfrr = $conexion->select($TXTSQLPfrr, false);

$totalCralPfrr = 0;							
$totalCralPfrr = mysqli_num_rows($sqlPfrr);
$pendientes += $totalCralPfrr;

$vineCralPfrr = "";

while($rPfrr = mysqli_fetch_array($sqlPfrr))
{
	$oficioConvertido = str_replace("/","!",$rPfrr['folioOficio']);
	//$txt = "SELECT sicsa FROM po_historial WHERE oficio = '".$r['folioOficio']."' ";
	//$txt = "SELECT * FROM archivos WHERE num_accion = '".$r['accionSola']."' AND oficioDoc = '".$oficioConvertido."' ";
	$txtPfrr = "SELECT * FROM archivos WHERE num_accion = '".$rPfrr['accionSola']."' AND oficio = '".$rPfrr['folioOficio']."' ";
	$sqlSPfrr = $conexion->select($txtPfrr, false);
	
	while($rSPfrr = mysqli_fetch_array($sqlSPfrr))
	{
		//$vineCralPfrr .= "<li><a href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$rPfrr['accionSola']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$rSPfrr['oficioDoc']." ',10,'cont/po_verCRAL.php','id=".$rPfrr['idXaccion']."&numAccion=".$rPfrr['accionSola']."&oficio=".$rPfrr['folioOficio']."&sicsa=".$rSPfrr['oficioDoc']."&usuario=".$rPfrr['abogado_solicitante']."')\">".$rPfrr['accionSola']."</a></li>";
		$linksCrals[] = array('fecha' => $rPfrr['fecha_oficio'],'titulo' => "Cral PFRR",'link' => "
			<li>
				<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro2 = new mostrarCuadro(600,1000,'Devolucion ".$rPfrr['accionSola']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; * &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Cral ".$rSPfrr['oficioDoc']." ',10,'cont/po_verCRAL.php','id=".$rPfrr['idXaccion']."&numAccion=".$rPfrr['accionSola']."&oficio=".$rPfrr['folioOficio']."&sicsa=".$rSPfrr['oficioDoc']."&usuario=".$rPfrr['abogado_solicitante']."')\"> 
					<div style='float:left'> <img src='images/green-document-download-icon.png' /> </div> 
					<div style='float:left;'> PFRR CRAL Devolución <br>".$rPfrr['accionSola']." </div> 
					<div style='float:right; margin:0 5px 5px 0 0;'>".fechaNormal($r['fecha_oficio'])."</div> 
				</a>
				<div class='clear'></div>
			</li>");
	}
}
//-------------------------- SQL VERIFICA SOLICITUDES DE AYUDA PENDIENTES -------------------------
if($direccion == 'DG')
{
	$sql = $conexion->select("SELECT * FROM solicitud_ayuda  WHERE status = 0 ORDER BY fecha_sol desc, hora_sol desc", false);
$totalSoli = 0;
$totalSoli = mysqli_num_rows($sql);
$pendientes += $totalSoli;

//$vinetasUAA = "";

while($r = mysqli_fetch_array($sql))
{
	$tipo = $r['tipo'];
	if($tipo == "po") { $imagen = "FAQ.png"; $estilo = "poLink";}
	if($tipo == "pfrr") { $imagen = "faqpfrr.png";  $estilo = "pfrrLink"; }
	$tipo = strtoupper($r['tipo']);
	$linksAyuda[] = array('fecha' => $r['fecha_sol']." ".$r['hora_sol'],'titulo' => $tipo." Ayuda Pendiente",'link' => "
	<li>
		<a class='linkNoti ".$estilo."' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(450,700,'Ayuda Pendiente ".$r['num_accion']."',100,'cont/po_pendientes_ayuda.php','id=".$r['id']."&numAccion=".$r['num_accion']."&asunto=".urlencode($r['asunto'])."&fecha=".$r['fecha_sol']."&hora=".$r['hora_sol']."&solicitante=".$r['solicitante']."&usuario=".$usuario."&tipo=".$tipo."')\"> 
			<div style='float:left'> <img src='images/".$imagen."' /> </div> 
			<div style='float:left'> <b>".$r['id'].".</b> ".$tipo." Ayuda Pendiente <br>".$r['num_accion']."  </div> 
			<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_sol'])." <br> ".$r['hora_sol']."</div> 
		</a> 
		</div> 
		<div class='clear'>
		
	</li>"); 
}

} else 

{
	$sql = $conexion->select("SELECT * FROM solicitud_ayuda   WHERE status  = 1 and solicitante= '$usuario'", false);
$totalSoli = 0;
$totalSoli = mysqli_num_rows($sql);
$pendientes += $totalSoli;

$r1= mysqli_fetch_array($sql);
$fechaantencion=explode(" ",$r1['fechaHora']);
$fechapartida=$fechaantencion[0];
$horapartida=$fechaantencion[1];
$fechanormal=fechaNormal($fechapartida);

//$vinetasUAA = "";

while($r = mysqli_fetch_array($sql))
{
	$tipo = $r['tipo'];
	if($tipo == "po") { $imagen = "FAQ.png"; $estilo = "poLink";}
	if($tipo == "pfrr") { $imagen = "faqpfrr.png";  $estilo = "pfrrLink"; }
	$tipo = strtoupper($r['tipo']);


	$linksAyuda[] = array('fecha' => $r['fecha_sol']." ".$r['hora_sol'],'titulo' => $tipo." Solicitud Atendida",'link' => "
	<li>
		<a class='linkNoti ".$estilo."' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(400,700,'Solcitud Atendida ".$r['num_accion']."',100,'cont/po_atendido_ayuda.php','id=".$r['id']."&numAccion=".$r['num_accion']."&asunto=".urlencode($r['asunto'])."&comentarios=".urlencode($r['comentarios'])."&fecha=".$r['fechaSistema']."&solicitante=".$r['solicitante']."&tipo=".$tipo."&atendidoPor=".$r['atendidopor']."&atencion=".urlencode ($r['fechaHora'])."')\">
			<div style='float:left'> <img src='images/".$imagen."' /> </div> 	
			<div style='float:left'>  ".$tipo." Solicitud Atendida <br>".$r['num_accion']."  </div> 
			<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_sol'])." <br> ".$r['hora_sol']."</div> 
			 
			<div style=''>  "." Fecha de Atención &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp $fechanormal  </div> 	
			<div style='margin:0 0 0 27px'>  "." Hora de Atención  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp$horapartida  </div> 
			
		
			
		</a> 
		</div> 
		<div class='clear'>
		
	</li>"); 
}
	
}





//-----------------------------------------------------------------------------------
//-------------------------- SQL VERIFICA AUDIENCIAS PROXIMAS -----------------------
if($direccion == 'DG')
	$sql = $conexion->select("SELECT id as idAud,num_accion,idPresunto,presunto,rfc,oficio_citatorio,fecha_audiencia,tipo as tipoAud, revisada 
								FROM  pfrr_audiencias 
								WHERE fecha_audiencia <> '0000-00-00' AND ( pfrr_audiencias.tipo <> 4 OR pfrr_audiencias.tipo <> 5 ) AND revisada = 0 
								ORDER BY fecha_audiencia DESC", false);
else
	$sql = $conexion->select("SELECT PA.id as idAud, PA.num_accion,PA.idPresunto,PA.presunto,PA.rfc,PA.oficio_citatorio,PA.fecha_audiencia,PA.tipo as tipoAud,PA.revisada,P.usuario 
								FROM  pfrr_audiencias PA 
								INNER JOIN pfrr P ON PA.num_accion = P.num_accion 
								WHERE fecha_audiencia <> '0000-00-00' AND P.usuario = '".$usuario."' AND ( PA.tipo <> 4 OR PA.tipo <> 5 ) AND revisada = 0 
								ORDER BY fecha_audiencia DESC", false);

$totalAud = 0;
$totalAud = mysqli_num_rows($sql);

$pendientes += $totalAud;
$pendientesDG += $totalAud;

$vinetasAud = "";

while($r = mysqli_fetch_array($sql))
{
	$datosPfrr = idatosAccionPFRR($conn,$r['num_accion']);
	//$user = idameUsuario($conn,$datosPfrr['abogado']);
	$abogado = $user['nombre'];
	
	$numLetras = strlen($r['presunto']);
	//if($numLetras > 23) $pres = substr(utf8_decode($r['presunto']),1,23)."...";
	//else 
	$pres = $r['presunto'];
	
	$linksAud[] = array('fecha' => $r['fecha_audiencia'],'titulo' => "Audiencia Proxima",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" title=\"".$r['presunto']." - ".$r['num_accion']." \" onclick=\"var cuadro1 = new mostrarCuadro2(550,1100,'Confirmar Comparecencia &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#124; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".$r['presunto']."  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &#124; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  ".$r['num_accion']." ',50,'cont/pfrr_presuntos_proceso.php','id=".$r['idAud']."&numAccion=".$r['num_accion']."&fecha=".fechaNormal($r['fecha_audiencia'])."&oficio=".urlencode($r['oficio_citatorio'])."&usuario=".$usuario."&idPresuntop=".$r['idPresunto']."&presunto=".urlencode($r['presunto'])."&rfc=".urlencode($r['rfc'])."&tipoAud=".$r['tipoAud']."')\"> 
				<div style='float:left'> <img style='padding:17px 5px;' src='images/Actions-view-calendar-month-icon.png' /> </div> 
				<div style='float:left;width:145px'> Audiencia Proxima <br>* ".htmlspecialchars($pres)." <br>- ".$datosPfrr['abogado']." </div>
				<div style='float:right; padding:10px 5px 0 0;'> ".fechaNormal($r['fecha_audiencia'])." </div> 			
			</a>
			<div class='clear'></div> 
		</li>");
}
//-----------------------------------------------------------------------------------
//-------------------------- SQL VERIFICA PENDIENTES UAA ----------------------------
if($direccion == 'DG')
	$sql = $conexion->select("SELECT po_historial.id as hisId, po_historial.oficio as hisOf, po_historial.num_accion,oficio,estadoTramite, fechaSistema, DATEDIFF(CURDATE(),fechaSistema) as DifDias FROM po_historial LEFT JOIN po ON po_historial.num_accion = po.num_accion WHERE pendienteUAA = 0 AND (estadoTramite = 3 OR estadoTramite = 4) AND DATEDIFF(CURDATE(),fechaSistema) > 10  AND usuario = '$usuario' AND po_historial.status <> 0 ", false);
else
	$sql = $conexion->select("SELECT po_historial.id as hisId, po_historial.oficio as hisOf, po_historial.num_accion,oficio,estadoTramite, fechaSistema, DATEDIFF(CURDATE(),fechaSistema) as DifDias FROM po_historial LEFT JOIN po ON po_historial.num_accion = po.num_accion WHERE direccion = '$direccion' AND pendienteUAA = 0 AND (estadoTramite = 3 OR estadoTramite = 4) AND DATEDIFF(CURDATE(),fechaSistema) > 10  AND usuario = '$usuario'  AND po_historial.status <> 0", false);

$totalUAA = 0;
$totalUAA = mysqli_num_rows($sql);
$pendientes += $totalUAA;

$vinetasUAA = "";

while($r = mysqli_fetch_array($sql))
{
	//$vinetasUAA .= "<li><a href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Pendientes UAA ".$r['num_accion']."',100,'cont/po_pendientesUAA.php','id=".$r['hisId']."&numAccion=".$r['num_accion']."&oficio=".$r['hisOf']."&fecha=".$r['fechaSistema']."')\">".$r['num_accion']." </a></li>";
	$linksUAA[] = array('fecha' => $r['fechaSistema'],'titulo' => "Pendiente UAA",'link' => "
	<li>
		<a class='linkNoti poLink' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Pendientes UAA ".$r['num_accion']."',100,'cont/po_pendientesUAA.php','id=".$r['hisId']."&numAccion=".$r['num_accion']."&oficio=".$r['hisOf']."&fecha=".$r['fechaSistema']."')\"> 
			<div style='float:left'> <img src='images/yellow-document-icon.png' /> </div> 
			<div style='float:left'>  Pendiente UAA <br>".$r['num_accion']."  </div> 
			<div style='float:right; padding:10px 5px 0 0;'>".fechaNormal($r['fechaSistema'])."</div> 
		</a> 
		</div> 
		<div class='clear'>
		
	</li>");
}
//---------------------------------------------------------------------------------------------
//---------- SQL VERIFICA CRALS REVISION PENDIENTES (SUPERVENIENTE)----------------------------
if($direccion == 'DG'){
	$sql = $conexion->select("SELECT num_accion, num_procedimiento, fecha_acuerdo_inicio, hora, usuario 
								FROM pfrr WHERE validacion <> 1 AND (fecha_acuerdo_inicio <> '0000-00-00' AND fecha_acuerdo_inicio <> '' ) ", false);

	$totalUAA = 0;
	$totalUAA = mysqli_num_rows($sql);
	$pendientesDG += $totalUAA;

	
	$vinetasUAA = "";
	
	while($r = mysqli_fetch_array($sql))
	{
		//$vinetasUAA .= "<li><a href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Pendientes UAA ".$r['num_accion']."',100,'cont/po_pendientesUAA.php','id=".$r['hisId']."&numAccion=".$r['num_accion']."&oficio=".$r['hisOf']."&fecha=".$r['fechaSistema']."')\">".$r['num_accion']." </a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_acuerdo_inicio']." ".$r['hora'],'titulo' => "Cral PFRR Aprobación",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(350,750,'Cral PFRR Revisión ".$r['num_accion']."',100,'cont/pfrr_pendientesSUPER.php','numAccion=".$r['num_accion']."&fecha=".$r['fecha_acuerdo_inicio']."&usuario=".$r['usuario']."&noPFRR=".$r['num_procedimiento']."')\"> 
				<div style='float:left'> <img src='images/green-document-plus-icon.png' /> </div> 
				<div style='float:left'> PFRR CRAL Aprobación <br>".$r['num_accion']."  </div> 
				<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_acuerdo_inicio'])."<br>".$r['hora']."</div> 
			</a> 
			</div> 
			<div class='clear'>
			
		</li>");
	}
}else {
	$query = "SELECT num_accion, num_procedimiento, fecha_acuerdo_inicio, hora, usuario 
								FROM pfrr 
								WHERE 
								subnivel IN (".$niveles.") AND 
								validacion = 1 AND 
								(fecha_acuerdo_inicio <> '0000-00-00' AND fecha_acuerdo_inicio <> '' ) AND
								cralVisto <> 1";
	$sql = $conexion->select($query, false);

	$totalUAA = 0;
	$totalUAA = mysqli_num_rows($sql);
	$pendientes += $totalUAA;

	$vinetasUAA = "";
	
	while($r = mysqli_fetch_array($sql))
	{
		$query = "SELECT * FROM archivos WHERE num_accion = '".$r['num_accion']."' AND oficio = '".$r['num_procedimiento']."' AND tipoDoc = 'pfrr' limit 1";
		$rq = $conexion->select($query, false);
		$rP =  mysqli_fetch_array($rq);
		$nomArchivo = $rP['oficioDoc'];
		
		//$vinetasUAA .= "<li><a href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Pendientes UAA ".$r['num_accion']."',100,'cont/po_pendientesUAA.php','id=".$r['hisId']."&numAccion=".$r['num_accion']."&oficio=".$r['hisOf']."&fecha=".$r['fechaSistema']."')\">".$r['num_accion']." </a></li>";
		$linksCrals[] = array('fecha' => $r['fecha_acuerdo_inicio']." ".$r['hora'],'titulo' => "Cral PFRR Aprobación",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(600,1000,'Cral PFRR Revisión ".$r['num_accion']."',10,'cont/po_verCRAL.php','&numAccion=".$r['num_accion']."&pfrr=".$r['num_procedimiento']."&tipo=pfrr&sicsa=".$nomArchivo."&usuario=".$r['usuario']."')\"> 
				<div style='float:left'> <img src='images/green-document-plus-icon.png' /> </div> 
				<div style='float:left'> PFRR CRAL Aprobación <br>".$r['num_accion']."  </div> 
				<div style='float:right; padding:0px 5px 0 0;'>".fechaNormal($r['fecha_acuerdo_inicio'])."<br>".$r['hora']."</div> 
			</a> 
			</div> 
			<div class='clear'>
			
		</li>");
	}
}
//---------------------------------------------------------------------------------------------------
//----------------------------------------- SQL VERIFICA 30, 60, 90 DIAS ----------------------------

if($direccion == 'DG')
	$sql = $conexion->select("SELECT num_accion, fecha_analisis_documentacion, limite_cierre_instruccion, (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) * -1) AS DifDias
								FROM pfrr
								WHERE (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=30 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=60 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=90) AND 
								(detalle_edo_tramite <> 29 AND detalle_edo_tramite <> 23 AND detalle_edo_tramite <> 24 AND detalle_edo_tramite <> 25 AND detalle_edo_tramite <> 26 ) 
							  ORDER BY DifDias", false);
else
	$sql = $conexion->select("SELECT num_accion, fecha_analisis_documentacion, limite_cierre_instruccion, (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) * -1) as DifDias  
								FROM pfrr 
								WHERE  (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=30 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=60 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=90) AND 
								(detalle_edo_tramite <> 29 AND detalle_edo_tramite <> 23 AND detalle_edo_tramite <> 24 AND detalle_edo_tramite <> 25 AND detalle_edo_tramite <> 26 )  AND 
								subnivel IN (".$niveles.") 
							  ORDER BY DifDias", false);
/*
$queryUsers = "SELECT num_accion, fecha_analisis_documentacion, limite_cierre_instruccion, (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) * -1) as DifDias  
								FROM pfrr 
								WHERE  (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=30 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=60 || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=90) AND 
								(detalle_edo_tramite <> 29 AND detalle_edo_tramite <> 23 AND detalle_edo_tramite <> 24 AND detalle_edo_tramite <> 25 AND detalle_edo_tramite <> 26 )  AND 
								subnivel IN (".$niveles.") 
							  ORDER BY DifDias";
*/
$totalUAA = 0;
$totalUAA = mysqli_num_rows($sql);
//$pendientes += $totalUAA;

$vinetasUAA = "";

while($r = mysqli_fetch_array($sql))
{
	if($r['DifDias'] >= 1)
	{
		//$vinetasUAA .= "<li><a href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Pendientes UAA ".$r['num_accion']."',100,'cont/po_pendientesUAA.php','id=".$r['hisId']."&numAccion=".$r['num_accion']."&oficio=".$r['hisOf']."&fecha=".$r['fechaSistema']."')\">".$r['num_accion']." </a></li>";
		$linksLimites[] = array('fecha' => $r['limite_cierre_instruccion'],'titulo' => "Cral PFRR Revisión",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Limite Última Actuacion  ".$r['num_accion']."',100,'cont/pfrr_pendientesDIAS.php','numAccion=".$r['num_accion']."&fecha=".$r['limite_cierre_instruccion']."&fechaUact=".$r['fecha_analisis_documentacion']."&dias=".$r['DifDias']."')\"> 
				<div style='float:left'> <img src='images/Apps-preferences-system-time-icon.png' /> </div> 
				<div style='float:left'> Límite para Emitir Resolución <br>".$r['num_accion']." </div> 
				<div style='float:right; padding:0px 5px 0 0;'>Restan <br>".$r['DifDias']." días</div> 
			</a> 
			</div> 
			<div class='clear'>
			
		</li>");
	}
}

///----------------------SOBRESEIMIENTO---------------/

if($direccion == 'DG')
	$sqlrs = $conexion->select("SELECT num_accion, cierre_instruccion, fecha_analisis_documentacion, limite_cierre_instruccion
									FROM pfrr
								WHERE  RS = 1  AND 
								(detalle_edo_tramite <> 29 AND detalle_edo_tramite <> 23 AND detalle_edo_tramite <> 24 AND detalle_edo_tramite <> 25 AND detalle_edo_tramite <> 26 )
							  ", false);
else
	$sqlrs = $conexion->select("SELECT num_accion, cierre_instruccion, fecha_analisis_documentacion, limite_cierre_instruccion
								FROM pfrr 
								WHERE  RS = 1 AND 
								(detalle_edo_tramite <> 29 AND detalle_edo_tramite <> 23 AND detalle_edo_tramite <> 24 AND detalle_edo_tramite <> 25 AND detalle_edo_tramite <> 26 )  AND 
								subnivel IN (".$niveles.") 
							  ", false);


while($rs = mysqli_fetch_array($sqlrs))
{
	
	
	
	
		$fechars= $rs['cierre_instruccion'];
				
				$fechalimrs=date('Y-m-d', strtotime("$fechars + 45 day"));	
				//$fechalimite2=strtotime($fechapen2);
				$fechadehoyrs=date('Y-m-d');			
				
				$dias_rest= strtotime($fechalimrs);
				$hoyrs= strtotime($fechadehoyrs);
				$rest_rs= (($dias_rest-$hoyrs)/86400);
		$linksLimites[] = array('fecha' => $rs['limite_cierre_instruccion'],'titulo' => "Cral PFRR Revisión",'link' => "
		<li>
			<a class='linkNoti pfrrLink' href=\"#\" onclick=\"var cuadro3 = new mostrarCuadro(250,700,'Limite Última Actuacion  ".$rs['num_accion']."',100,'cont/pfrr_pendientesDIAS.php','numAccion=".$rs['num_accion']."&fecha=".$fechalimrs."&fechaUact=".$rs['cierre_instruccion']."&dias=".$rest_rs."')\"> 
				<div style='float:left'> <img src='images/Apps-preferences-system-time-icon.png' /> </div> 
				<div style='float:left'> Límite para Emitir RS <br>".$rs['num_accion']." </div> 
				<div style='float:right; padding:0px 5px 0 0;'>Restan <br>".$rest_rs." días</div> 
			</a> 
			</div> 
			<div class='clear'>
			
		</li>");
}


//--------------------------------------------------------------------------------
//--------------------------------------------------------------------------------
//---ordenamos por fecha ---------------------
$numsLinks1 = count($linksAud);
$numsLinks2 = count($linksAyuda);
$numsLinks3 = count($linksCrals);
$numsLinks4 = count($linksLimites);
$numsLinks5 = count($linksUAA);

if($linksAud > 0 || $linksAyuda > 0 || $linksCrals > 0 || $linksLimites > 0 || $linksUAA > 0)
{
	function ordenar( $a, $b ) 
	{
		return strtotime($a['fecha']) - strtotime($b['fecha']);
	}
	 
	function mostrar_array($datos) 
	{
		foreach($datos as $dato) 
			$cadena .= $dato['link'];
		
		return $cadena;
	}
	
	@usort($linksCrals, 'ordenar');
	@usort($linksAyuda, 'ordenar');
	@usort($linksAud, 'ordenar');
	@usort($linksLimites, 'ordenar');
	@usort($linksUAA, 'ordenar');
	
	if($direccion == 'DG') $pen = $pendientesDG;
	else $pen = ($pendientes);
	
	$pen = $numsLinks1+$numsLinks2+$numsLinks3+$numsLinks4+$numsLinks5;
	
	if($pen == '' || $pen == 0 || $pen == -1) $pen = 0;
	
	echo $resTxt = @mostrar_array($linksAyuda).@mostrar_array($linksCrals).@mostrar_array($linksAud).@mostrar_array($linksLimites).@mostrar_array($linksUAA)."|".$pen;
	
	//print_r($links);
	
}else{ echo "<br><br><br><br><br><br><br><br><center><b>Sin Pendientes</b> <br><br> <img src='images/ok-2-icon.png'> </center>"."|0";}
//--------------------------------------------------------------------------------
mysqli_free_result($sql);
?>

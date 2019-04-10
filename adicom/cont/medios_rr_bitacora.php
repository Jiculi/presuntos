<script>
function verTexto(texto)
{
 new mostrarCuadro2(200,600,"Detalle del Movimiento",200);
 $$("#cuadroRes2").html(texto);	
}
function subirArchivos(tipo)
{
	if(tipo == 1) 
    new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/pfrr_subirArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
	//new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/pfrr_subirArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
	else new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/pfrr_subirOtrosArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
 //$$("#cuadroRes2").html(texto);	
}
function verPdf(archivo)
{
 new mostrarCuadro2(600,800,"Visor de Documento "+archivo,10,"cont/po_verPdf.php","archivo="+archivo);//alto,ancho,titulo,top,pagina,datos
 //$$("#cuadroRes2").html(texto);	
}
function ocultaAll() 
{
	//$$('.todosContPasos').removeClass("pActivo");
	$$('.todosContPasos').hide();
	//$$('.todosPasos').removeClass("pasosActivo");
} 
function muestraPestanaBit(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	$$('#p'+divId).fadeIn();
}
</script>
<style>
.fechaPFRR{ font-weight:bold; color:#093}
</style>
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
$direccion = $_REQUEST['direccion'];
$actor = $_REQUEST['idactor'];

//if($direccion == "DG")
	$tabla = " <a href='#' onclick='subirArchivos(1)'>Subir Archivos <img src='images/Upload.png' /> </a> ";

$tabla .=  '    
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
	<thead>
		<tr>
			<th class="bitEdoTra"><a href="#">Estado de Tramite</a>	</th>
			<!-- <th class="bitEvento"><a href="#"> Tipo </a></th> -->
			<th class="bitDatos"><a href="#">Datos</a></th>
			<th class="bitActua"><a href="#">Actualización</a></th>

		</tr>
';  
//----------------------------------------------------------------------------
?>
<div class="encVol">
    <div id='paso1' onclick="muestraPestanaBit(1)" class="todosPasos pasosActivo pasos"> BITACORA </div>
    <div id='paso3' onclick="muestraPestanaBit(3)" class="todosPasos pasosActivo pasos"> OTROS OFICIOS </div>
    <div id='paso2' onclick="muestraPestanaBit(2)" class="todosPasos pasosActivo pasos"> OTROS VOLANTES </div>
</div>
<div id='p1' class="contOficios redonda10 todosContPasos">
<?php
//------------------- datos de PFRR HISTORIAL ---------------------------------  
$sql = $conexion->select("SELECT * FROM medio_historial WHERE accion = '".$accion."' AND actor = '".$actor."'",false);
$total = mysql_num_rows($sql);

$sql1 = $conexion->select("SELECT fecha_notificacion_resolucion FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' AND nombre = '".$actor."' AND status =1",false);

$r1 = mysql_fetch_array($sql1);

while($r = mysql_fetch_array($sql))

{

	
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	
	$txtTipo = "";
	$tablaDatos = "";
	//------------ configuramos textos e imagenes ---------------
	if($r['Tipo'] == 'rr_prevencion') 	$imagen = '<img src="images/page_add.png"/> Interposición del Recurso de Reconsideración' ;
	if($r['Tipo'] == 'ofic_SAT') 		$imagen = '<img src="images/User-Files-icon.png" style="width:19px; height="19px"/> Comunicado al SAT';
		if($r['Tipo'] == 'mediosSAT') 	$imagen = '<img src="images/Actions-go-next-view-page-icon.png" style="width:17px; height="17px"/> Notificación al SAT' ;
	if($r['Tipo'] == 'Admision') 		$imagen = '<img src="images/User-Files-icon.png" style="width:19px; height="19px"/> Acuerdo de Admisión' ;
	if($r['Tipo'] == 'Desechamiento') 		$imagen = '<img src="images/User-Files-icon.png" style="width:19px; height="19px"/> Acuerdo de Desechamiento' ;
	
	if($r['Tipo'] == 'rr_notifica') 	$imagen = '<img src="images/Notary-icon.png" style="width:17px; height="17px"/> Notificación del Acuerdo' ;
	if($r['Tipo'] == 'cierre') 		    $imagen = '<img src="images/page_add.png"/> Cierre de instrucción' ;
	if($r['Tipo'] == 'enelaboracion') 	$imagen = '<img src="images/Gavel-Law-icon.png" style="width:17px; height="17px"/>  Resolución del Recurso de Reconsideración' ;
	if($r['Tipo'] == 'tiporesol') 		$imagen = '<img src="images/Actions-go-next-view-page-icon.png" style="width:17px; height="17px"/> Notificación al recurrente' ;
	if($r['Tipo'] == 'sat') 		    $imagen = '<img src="images/Actions-go-next-view-page-icon.png" style="width:17px; height="17px"/> Notificación de Resolución al SAT' ;
	
	/*if($r['tipo'] == 'asistencia') 		$imagen = '<img src="images/page_delete.png"/> '; 
	if($r['tipo'] == 'DTNS' || 
	$r['tipo'] == 'dtns') 				$imagen = '<img src="images/page_go.png"/> ';
	if($r['tipo'] == 'acuerdoInicio') 	$imagen = '<img src="images/docok.png"/> ';
	if($r['tipo'] == 'notificacionICC') $imagen = '<img src="images/note_accept.png" style="width:19px; height="19px" /> ';
	if($r['tipo'] == 'notificación') 	$imagen = '<img src="images/page_white_paste.png"/> ';
	if($r['tipo'] == 'citatorio') 		$imagen = '<img src="images/Actions-view-calendar-month-icon.png"/> ';
	if($r['tipo'] == 'desahogo') 		$imagen = '<img src="images/folder-documents-icon.png"/> ';
	if($r['tipo'] == 'ofrecimientoPruebas') 		$imagen = '<img src="images/tests-icon.png" style="width:19px; height="19px" /> ';
	if($r['tipo'] == 'diferimiento') 	$imagen = '<img src="images/Actions-view-calendar-upcoming-events-icon.png"/> ';
	if($r['tipo'] == 'continuacion') 	$imagen = '<img src="images/Actions-go-jump-today-icon.png"/> ';
	if($r['tipo'] == 'alegatos') 	$imagen = '<img src="images/User-Files-icon.png" style="width:19px; height="19px"/> ';
	if($r['tipo'] == 'opinionUAA') 		$imagen = '<img src="images/Actions-go-next-view-page-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'cierre de instruccion') 		$imagen = '<img src="images/Document-Write-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'Con existencia de Responsabilidad' && $r['estadoTramite'] == 29)	$imagen = '<img src="images/Document-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'Con existencia de Responsabilidad' && $r['estadoTramite'] == 24)	$imagen = '<img src="images/Gavel-Law-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'res_tesofe')	$imagen = '<img src="images/Notary-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'res_icc')	$imagen = '<img src="images/Notary-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'res_ef')	$imagen = '<img src="images/Notary-icon.png" style="width:17px; height="17px"/> ';
	if($r['tipo'] == 'cierre de instruccion')	$imagen = '<img src="images/Notary-icon.png" style="width:17px; height="17px"/> ';
	*/
	
	
	//--------------- textos de Aspectos legales --------------------------------
	if($r['Tipo'] == "rr_prevencion") $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante escrito de fecha '.fechaNormal($r['Fecha']).', recibido el '.fechaNormal($r['Fecha_Acuse']).', por la Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios, el C. '.($r['Actor']).', interpone recurso de reconsideración en contra de la Resolución de fecha '.fechaNormal($r1['fecha_notificacion_resolucion']).', en términos del artículo 69 de la Ley de Fiscalización y Rendición de cuentas de la Federación.';
	
	if($r['Tipo'] == "ofic_SAT") $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.$r['Oficio'].', de fecha '.fechaNormal($r['Fecha']).', se le comunica al SAT, que el/la C. '.($r['Actor']).', interpone recurso de reconsideración en contra de la Resolución de fecha '.fechaNormal($r1['fecha_notificacion_resolucion']).'';
	
	if($r['Tipo'] == "mediosSAT") $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.$r['Oficio'].', de fecha '.fechaNormal($r['Fecha']).', se le comunica al SAT, que el/la C. '.($r['Actor']).', interpone recurso de reconsideración en contra de la Resolución de fecha '.fechaNormal($r['Fecha_Acuse']).' .';
	
	if($r['Tipo'] == "Admision") $txtTipo = '<span class="fechaPFRR"></span>'.'La Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios, admite a trámite el recurso de reconsideración interpuesto por el/la C. '.($r['Actor']).', en virtud de que reúne los requisitos señalados por el artículo 70, fracción I de la Ley de Fiscalización y Rendición de cuentas de la Federación, correspondiéndole el número '.$r['Procedimiento'].', señalándosele que no se concede la suspensión de la ejecución de la resolución combatida, hasta en tanto no se exhiba la garantía a la que hace referencia el artículo 72 de la antes citada Ley.';
	
		if($r['Tipo'] == "Desechamiento") $txtTipo = '<span class="fechaPFRR"></span>'.'La Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios dicta acuerdo mediante el cual desecha el recurso de reconsideración número '.$r['Procedimiento'].', en virtud de que el/la C. '.($r['Actor']).', no desahogó la prevención realizada por esta autoridad.';
	
			if($r['Tipo'] == "rr_notifica") $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.$r['Oficio'].', de fecha '.fechaNormal($r['Fecha']).', se notificó al C. '.($r['Actor']).', el acuerdo de esa misma fecha, a través del cual se admitió a trámite el recurso de reconsideración interpuesto en contra de la resolución de fecha '.fechaNormal($r['Fecha_Acuse']).'.';
			
			
			
			
		
				if($r['Tipo'] == "cierre") $txtTipo = '<span class="fechaPFRR"></span>'.'Al estar sustanciado el Recurso de Reconsideración y no existir prueba pendiente por desahogar, ni diligencia pendiente por practicar, con fecha '.fechaNormal($r['Fecha']).', se procede a realizar el cierre de instrucción, ordenándose dictar la resolución que en derecho corresponda dentro de los 60 días naturales siguientes, lo anterior de conformidad con el 70, fracción IV de la Ley de Fiscalización y Rendición de cuentas de la Federación.';
				
				if($r['Tipo'] == "enelaboracion") $txtTipo = '<span class="fechaPFRR"></span>'.'La Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios, es competente para conocer, substanciar y resolver el recurso de reconsideración, por lo que con fecha '.fechaNormal($r['Fecha_Acuse']).' emitió la resolución, mediante la cual se (confirma, modifica o revoca) la resolución definitiva de fecha '.fechaNormal($r['Fecha']).', emitida en el Procedimiento para el Fincamiento de Responsabilidades Resarcitorias número DGRRFEM/D/06/2015/10/181, de conformidad con el artículo 71 de la Ley de Fiscalización y Rendición de cuentas de la Federación.';
				
				if($r['Tipo'] == "tiporesol") $txtTipo = '<span class="fechaPFRR"></span>'.'La Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios, es competente para conocer, substanciar y resolver el recurso de reconsideración, por lo que con fecha '.fechaNormal($r['Fecha_Acuse']).' emitió la resolución, mediante la cual se (confirma, modifica o revoca) la resolución definitiva de fecha '.fechaNormal($r['Fecha']).', emitida en el Procedimiento para el Fincamiento de Responsabilidades Resarcitorias número DGRRFEM/D/06/2015/10/181, de conformidad con el artículo 71 de la Ley de Fiscalización y Rendición de cuentas de la Federación.';
				
				if($r['Tipo'] == "sat") $txtTipo = '<span class="fechaPFRR"></span>'.'La Dirección General de Responsabilidades a los Recursos Federales en Estados y Municipios, es competente para conocer, substanciar y resolver el recurso de reconsideración, por lo que con fecha 30 de marzo de 2016 emitió la resolución, mediante la cual se (confirma, modifica o revoca) la resolución definitiva de fecha 03 de febrero de 2016, emitida en el Procedimiento para el Fincamiento de Responsabilidades Resarcitorias número DGRRFEM/D/06/2015/10/181, de conformidad con el artículo 71 de la Ley de Fiscalización y Rendición de cuentas de la Federación.';
		
	/*
	
	if($r['estadoTramite'] == 13) $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', y entregado el día '.fechaNormal($r['oficioAcuse']).'  esta DGRRFEM devuelve a la '.$rX['UAA'].' el DT y ET en virtud de que, derivado del análisis juridico realizado, se determinaron diversas observaciones para que sean tomadas en consideración y poder valorar si con dichas adecuaciones es procedente el inicio del PFRR. Se emitió CRAL del SICSA número DGARFM-DF-DTS el día fecha.' ;
	if($r['estadoTramite'] == 14) $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante copia del oficio número '.$r['oficio'].' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' hace de nuestro conocimiento que se notificó a la EF la Solventación (previa al inicio del PFRR), del PO numero '.$po['po'].'. Se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 15) $txtTipo = '<span class="fechaPFRR"></span>'.'Se dicta acuerdo de inicio con fecha '.fechaNormal($r['fechaSistema']).' para el PFRR con número '.cadenaNormalOficio($rY['num_procedimiento']).', correspondiente al PO número '.cadenaNormalOficio($po['po']).'.';
	if($r['estadoTramite'] == 30) $txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.$r['oficio'].' de fecha '.fechaNormal($r['oficioRecepcion']).' con fecha de acuse '.fechaNormal($r['oficioAcuse']).', se comunica a la ICC que se emitio <i>"Acuerdo de Inicio"</i> a través del cual se da por iniciado el PFRR en contra de '.$presuntos.' de conformidad con lo dispuesto por el articulo 56, parrafo segundo de la LFRCF. ';
	
	if($r['estadoTramite'] == 16) {
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND oficio_citatorio = '".$r['oficio']."' ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.cadenaNormalOficio($noAud['oficio_citatorio']).' de fecha '.fechaNormal($noAud['fecha_oficio_citatorio']).', con fecha de acuse '.fechaNormal($noAud['fecha_notificacion_oficio_citatorio']).', se notificó el oficio citatorio de forma '.fechaNormal($noAud['tipo_notificacion']).' y se cita a comparecer personalmente el día '.fechaNormal($noAud['fecha_audiencia']).' a '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', en las instalaciones de la ASF ubicadas en el CEA';
	}
	if($r['estadoTramite'] == '16.1') {
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$query = "SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."'  AND idPresunto = '".$r['presunto']."'  AND tipo = 2";
		$sqlAud = $conexion->select($query,false);

		$datosPresunto = damePresunto($r['presunto']);
		
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante escrito de fecha '.$noAud['oficio_citatorio'].' recibido el día '.fechaNormal($noAud['acuce_oficio_citatorio']).', el PR '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', solicito diferimiento de su audiencia de ley. Se levanta acta a través de la cual, por única vez, se otorga el diferimiento de la audiencia en la que se actúa y se señala como nueva fecha el día '.fechaNormal($noAud['fecha_audiencia']).' ';
	}
	if($r['estadoTramite'] == '16.2') {
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 3",false);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Siendo el '.fechaNormal($noAud['fecha_audiencia']).' día señalado para la continuación de la audiencia, comparecencia a la que fue citado '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', se hace constar que se encontro presente a fin de continuar con el desahogo de la audiencia de ley.';
	}
	if($r['estadoTramite'] == '16.3') {
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 6",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Tomando en consideración que quedaron pruebas pendientes de desahogar, con fundamento en el articulo 57 fracción VI segundo párrafo de la Ley de Fiscalización y Rendición de Cuentas de la Federación, se suspendio y fijó el día '.fechaNormal($noAud['fecha_audiencia']).' para la continuación de audiencia de '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].'. ';
	}
	if($r['estadoTramite'] == '17') {
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND oficio_citatorio = '".$r['oficio']."' ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Con fecha '.fechaNormal($noAud['fecha_audiencia']).'  se dio inicio al desahogo de la audiencia de la ley a la que fue citado(a) '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].'; la cual se concluyó considerando las manifestaciones que conforme a sus intereses convino.';
	}
	if($r['estadoTramite'] == 18) {
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 4 ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Teniendo lugar en esta DGRRFEM el PR  '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', ofreció las pruebas que conforme a su derecho convino, las cuales fueron admitidas y desahogadas dadas su naturaleza el día '.fechaNormal($noAud['fecha_pruebas']).'. ';
	}
	if($r['estadoTramite'] == 18.1) {
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 4 ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Teniendo lugar en esta DGRRFEM el PR  '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', ofreció las pruebas que conforme a su derecho convino, las cuales fueron admitidas y desahogadas dadas su naturaleza el día '.fechaNormal($noAud['fecha_pruebas']).'. ';
	}
	if($r['estadoTramite'] == 18.2) {
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 4 ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Teniendo lugar en esta DGRRFEM el PR  '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', ofreció las pruebas que conforme a su derecho convino, las cuales fueron admitidas y desahogadas dadas su naturaleza el día '.fechaNormal($noAud['fecha_pruebas']).'. ';
	}
	if($r['estadoTramite'] == 31) {
		$query = "SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 4 ";
		$sqlAud = $conexion->select($query,false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = '<span class="fechaPFRR"></span>'.'Desahogadas las pruebas admitidas el día  '.fechaNormal($noAud['fecha_pruebas']).' el PR, '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', formuló los alegatos correspondientes. ';
	}
	if($r['estadoTramite'] == 19) {
		$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).',	entregado el día '.fechaNormal($r['oficioAcuse']).', se solicita a la  '.$rX['UAA'].' opinión técnica sobre documentación presentada y/o pruebas ofrecidas por los PR '.$presuntos.'.';
	}
	//--------------------------------------------------------------------------------------------
	if($r['estadoTramite'] == 28) {
		//SABER si pasa por la UAA es decir reciben volante
		//$sqlvol = $conexion->select("SELECT * FROM volantes WHERE accion = '".$accion."' AND tipoMovimiento = 28 ",false);
		//$resVol = mysql_num_rows($sqlvol);
		
		if($r['usuario'] == "esolares"){// si tiene volante quiere decir q paso por la UAA
			$sqlUA = $conexion->select("SELECT * FROM pfrr_historial WHERE num_accion = '".$accion."' AND estadoTramite = 19 AND status = 1 order by fechaSistema desc limit 1 ",false);
			$opinioUAA = mysql_fetch_array($sqlUA);
			$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el día '.fechaNormal($r['oficioAcuse']).', la  '.$rX['UAA'].' remitió a esta DGRRFEM la respuesta a la requisición de opinión técnica, solicitada el día '.fechaNormal($opinioUAA['oficioRecepcion']).' con nuestro oficio numero '.$opinioUAA['oficio'].'. Siendo esta última actuacion del PFRR '.cadenaNormalOficio($rY['num_procedimiento']).', la fecha límite para emitir la resolución correspondiente es el día '.fechaNormal($rY['limite_cierre_instruccion']).'.';
		}
		else
			$txtTipo = '<span class="fechaPFRR"></span>'.'Con fecha '.fechaNormal($r['oficioRecepcion']).'  queda registrada la última actuación del PFRR '.cadenaNormalOficio($rY['num_procedimiento']).', por lo que la fecha límite para emitir la resolución correspondiente es el día '.fechaNormal($rY['limite_cierre_instruccion']).'.';
	}
	//--------------------------------------------------------------------------------------------
	if($r['estadoTramite'] == 22) {
		$txtTipo = '<span class="fechaPFRR"></span>'.'Al estar sustanciado el PFRR y toda vez que no existieron pruebas pendientes por desahogar, ni ninguna otra diligencia que practicar y las audiencias se encuentran concluidas, con fundamento en el articulo 57, fracción V de la ley de Fiscalización y Rendición de Cuentas de la Federación, se declara con fecha '.fechaNormal($r['oficioRecepcion']).' cerrada la instruccion, ordenándose dictar la resolución que proceda conforme a derecho.';
	}
	if($r['estadoTramite'] == 29) {
		$txtTipo = '<span class="fechaPFRR"></span>'.'Esta DGRRFEM de la ASF, es competente para conocer, substanciar y resolver sobre el presente procedimiento para el fincamiento de responsabilidades resarcitorias. Con fecha '.fechaNormal($r['oficioRecepcion']).' quedó emitida la resolucion.';
	}
	if($r['estadoTramite'] == 24) {
		$datosPresunto = damePresunto($r['presunto']);
		$pdrSQL = "SELECT * FROM pdr_2014 where num_accion = '".$accion."' ";
		$pdrSQL = $conexion->select($pdrSQL,false);
		$rpdr = mysql_fetch_array($pdrSQL);
		
		
		*/
		
		
		
		
		/*
		$txtTipo = '<span class="fechaPFRR"></span>'.'Ha quedado probada en el presente PFRR, la conducta irregular atribuible a './*$responsables*$datosPresunto['nombre'].' en consecuencia, es existente la responsabilidad resarcitoria atribuida al(los) mismo(s), en su calidad de responsable(s) directo respecto de la irregularidad determinada en la auditoria practicada al '.$rY['entidad'].' de la que resulto un daño causado a la Hacienda Pública Federal por un monto de $'.number_format(dameTotalPFRR($accion),2).' ('. ucfirst(strtolower(numtoletras(dameTotalPFRR($accion),2))).'), y por la cual se le instruyó el presente procedimiento. Con fecha '.fechaNormal($rY['fecha_notificacion_resolucion']).' se notificó de manera personal la Resolución Con Existencia de Responsabilidad así como el Pliego Definitivo de Responsabilidades numero '.$rY['PDR'].' respectivo, generado el día '.fechaNormal($rpdr['fecha_pdr']).'.';
	}
	if($r['estadoTramite'] == 24.1) {
		$ofSQL = "SELECT *,oficios_contenido.folio as folioOK FROM oficios_contenido 
					INNER JOIN oficios ON oficios_contenido.folio = oficios.folio
					WHERE 
						oficios.tipo = 'tesofe_PFRR' AND
						oficios_contenido.num_accion  = '".$accion."'
					LIMIT 1
					";
		$ofSQL = $conexion->select($ofSQL,false);
		$of = mysql_fetch_array($ofSQL);
		
		$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante el oficio '.$of['folioOK'].' de fecha '.fechaNormal($of['fecha_oficio']).' entregado el día  '.fechaNormal($r['oficioRecepcion']).', se remitió copia autógrafa del PDR a la TESOFE, para el efecto de que, que si es un plazo de 15 dás naturales contados a partir de la notificación de la resolución el monto de la indemnización resarcitoria no es pagado, respectivamente, por '.$responsables.' se haga efectivo su cobro en términos de ley, mediante el Procedimiento de Ejecución. ';
	}
	if($r['estadoTramite'] == 24.2) {
		$ofSQL = "SELECT *,oficios_contenido.folio as folioOK FROM oficios_contenido 
					INNER JOIN oficios ON oficios_contenido.folio = oficios.folio
					WHERE 
						oficios.tipo = 'notificarResEF_PFRR' AND
						oficios_contenido.num_accion  = '".$accion."'
					LIMIT 1
					";
		$ofSQL = $conexion->select($ofSQL,false);
		$of = mysql_fetch_array($ofSQL);
		
		$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante el oficio '.$of['folioOK'].' de fecha '.fechaNormal($of['fecha_oficio']).' entregado el día  '.fechaNormal($r['oficioRecepcion']).', se notificó la resolución a la EF del '.$rY['entidad'].'. ';
	}
	if($r['estadoTramite'] == 24.3) {
		$ofSQL = "SELECT *,oficios_contenido.folio as folioOK FROM oficios_contenido 
					INNER JOIN oficios ON oficios_contenido.folio = oficios.folio
					WHERE 
						oficios.tipo = 'notificarResICC_PFRR' AND
						oficios_contenido.num_accion  = '".$accion."'
					LIMIT 1
					";
		$ofSQL = $conexion->select($ofSQL,false);
		$of = mysql_fetch_array($ofSQL);
		
		$txtTipo = '<span class="fechaPFRR"></span>'.'Mediante el oficio '.$of['folioOK'].' de fecha '.fechaNormal($of['fecha_oficio']).' entregado el día  '.fechaNormal($r['oficioRecepcion']).', se notificó la resolución a la ICC del '.$rY['entidad'].'. ';
	}
	if($r['estadoTramite'] == 25) {
		$datosPresunto = damePresunto($r['presunto']);
		$txtTipo = '<span class="fechaPFRR"></span>'.'Resolución Notificada. Resolución de Inexistencia al P.R. '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].'. ';
	}
	if($r['estadoTramite'] == 26) {
		$datosPresunto = damePresunto($r['presunto']);

		$txtTipo = '<span class="fechaPFRR"></span>'.'Se sobresee el PFRR número '.$rY['num_procedimiento'].', iniciado por la acción/omisión precisada en el DT número '.cadenaNormalOficio($rY['num_DT']).' recibido el día '.fechaNormal($r['oficioRecepcion']).', instruido a '.$datosPresunto['nombre'].' en razón de que la irregularidad que se imputó ha dejado de existir en la vida jurídica, en virtud de haberse resarcido lo observado; quedando sin materia la formulación del PO número '.$rY['po'].'. Se notifica la resolución por sobreseimiento el día '.$datosPresunto['fechaNot'].'. ';
		
		
		
	}
*/

	//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
	//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
	$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion LIKE '%".$accion."%' ",false);
	while($o = mysql_fetch_array($sqlO))
	{
		//$oficioDoc = str_replace("!","/",$o['oficioDoc']);
		$oficioDoc = cadenaNormalOficio($o['oficioDoc']);
		$oficioDoc = str_replace("\'","",$oficioDoc);
		$oficioDoc = str_replace("\"","",$oficioDoc);
		$oficioDoc = str_replace(" ","",$oficioDoc);
		$txtTipo = str_replace($oficioDoc," <a href=\"#\" onclick=\"verPdf('".$o['nombreDoc']."')\"> $oficioDoc </a> ",$txtTipo);
	}

	// primer celda estado e imagen
	if(ctype_digit($r['estadoTramite'])) $estadoTram = dameEstado($r['estadoTramite']);
	else {
		if($r['estadoTramite'] == '16.1') $estadoTram = "Diferimiento de Audiencia";
		if($r['estadoTramite'] == '16.2') $estadoTram = "Continuación de Audiencia";
		if($r['estadoTramite'] == '16.3') $estadoTram = "Suspensión de Audiencia";
		if($r['estadoTramite'] == '18.1') $estadoTram = "Admisión";
		if($r['estadoTramite'] == '18.2') $estadoTram = "Desahogo";
		if($r['estadoTramite'] == '24.1') $estadoTram = "Pliego Definitivo de Responsabilidades TESOFE";
		if($r['estadoTramite'] == '24.2') $estadoTram = "Pliego Definitivo de Responsabilidades EF";
		if($r['estadoTramite'] == '24.3') $estadoTram = "Pliego Definitivo de Responsabilidades ICC";
	}
	//echo $r['estadoTramite']."";
	$tabla .= '
			<tr '.$estilo.'>
				<td class="bitEdoTra" >
					<table class="tablaBitacora">
						<tr>
							<td onClick="'.$onClick.'">'.$imagen.'</td>
							<td>'.$estadoTram.'</td>
					</table>
				</td>

				<td class="bitDatos">';
				
					//--- segunda celda leyenda aspectos Legales
					$tabla .=  $txtTipo;
								
											
				$tabla .= '</td>';
				$userBit = dameUsuario($r['usuario']);
				//tercer celda hora y usuario que modifico
				$tabla .= '<td class="bitActua">'.fechaNormal($r['fechaSistema']).' '.$r['horaSistema'].' <br> '.$userBit['nombre'].'</td>';
				$tabla .= '</tr>';
}//end while historial
if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta acción no tiene movimientos</h3></center></td></tr>";
$tabla .= '</tbody>	</table>
		<!--  end product-table................................... --> ';
echo "".$tabla."";

mysql_free_result($sql);
?>
</div>
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<div id='p3' class="contOficios redonda10 todosContPasos" style="display:none">

<?php
//if($direccion == "DG")
	echo " <a href='#' onclick='subirArchivos(2)'>Subir Archivos <img src='images/Upload.png' /> </a> ";
?>

    <h3 class="poTitulosPasos">Listado de Otros Oficios</h3>
       <?php
	//------------------------------------------------------------------------------
	$sql = $conexion->select("SELECT * FROM pfrr_bitacora_adicional WHERE num_accion LIKE '".$accion."%' and status!='0' ORDER BY folio desc",false);
	$total = mysql_num_rows($sql);
	//sacamos todos loq que sean otros
	$consulta = "SELECT value FROM oficios_options WHERE estado = 'PFRR' AND tipo = 'otros'";
	$sqlCon = $conexion->select($consulta);
	while($rc = mysql_fetch_assoc($sqlCon))
		$valores[] = $rc["value"];
		
	//print_r($valores);
	
      $tabla = '
                <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                    <tr>
                        <th class="ancho100"><a>Folio</a></th>
                        <th class="ancho50"><a>Tipo</a></th>
                        <th class="ancho100"><a>Volante</a></th>
                        <th class="ancho100"><a>Fecha Volante</a></th>
                        <!-- <th class="ancho100"><a>Acuse Volante</a></th> -->
                        <th class="ancho150"><a>Asunto</a></th>
                        <th class="ancho100"><a>Remitente</a></th>
                        <!-- <th class="ancho50"><a>Seguimiento</a></th> -->
                    </tr>
                </table>
                <div style="height:300px;width:100%;overflow:auto">
                
                <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                <tbody>
                ';

                while($r = mysql_fetch_array($sql))
                {
					
					$consulta = "SELECT tipo FROM oficios WHERE folio = '".$r['folio']."' and status!='0' limit 1";
					$sqlCon = $conexion->select($consulta);
					$tipo = mysql_fetch_assoc($sqlCon);
					//echo "<br> tipo de oficio ".
					$tipo = $tipo['tipo'];
					
					if(in_array($tipo,$valores) || $tipo == "")
					{
						$i++;
						$res = $i%2;
						if($res == 0) $estilo = "class='non'";
						else $estilo = "class='par'";
						
						//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
						$tabla .= '
								<tr '.$estilo.'>
									<td class="ancho100">'.verificaOficioLink($r['folio']).'</td>
									<td class="ancho50">'.$r['tipo_oficio_adicional'].'</td>
									<td class="ancho100">'.$r['oficio_tipo_oficio_adicional'].'</td>
									<td class="ancho100" align="center">'.fechaNormal($r['fecha_tipo_oficio_adicional']).'</td>
									<!-- <td class="ancho100" align="center">'.fechaNormal($r['acuse_tipo_oficio_adicional']).'</td> -->
									<td class="ancho150">'.$r['leyenda_tipo_oficio_adicional'].'</td>
									<td class="ancho100">'.$r['atiende_tipo_oficio_adicional'].'</td>
									<!--
									<td class="ancho50" >
										<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(400,500,"Informacion del Oficio '.$r['oficio_tipo_oficio_adicional'].'",100,"cont/po_otros_oficios_info.php","id='.$r['id'].'")\'></a>
										<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1100,"Accion '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",100,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a> 
									</td>
									-->
								</tr>';
					}//end if
                }
				$tabla .= '
						</tbody>
						</table>
						</div>
						';
                
                if($total == 0) $tabla = "<center><br><h3> No se encontraron oficios </h3><br><br><br></center>";
                
                echo $tabla;

       ?>
</div>
<!--- ----------------------------------------------------------------------------------------------- -->
<div id='p2' class="contOficios redonda10 todosContPasos" style="display:none">
    <h3 class="poTitulosPasos">Listado de Volantes (Otros)</h3>
       <?php
	   
	  
	   
	//------------------------------------------------------------------------------
	  $query = "SELECT *,vc.tipoMovimiento AS tipoMov, v.fecha_actual AS FechaActual, v.asunto AS asuntoV, vc.asunto AS asuntoVC FROM volantes v
				INNER JOIN volantes_contenido vc ON v.folio = vc.folio
				WHERE v.accion LIKE '%".$accion."%' AND vc.tipoMovimiento = 'pfrr_otros'
				ORDER BY v.id desc "; 
	  
	  $sql = $conexion->select($query,false);
      $total = mysql_num_rows($sql);

		$tabla = '
			<div width="">
				<div>
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
						<tr>
							<th class="ancho50">'.$direccon.'Folio	</th>
							<th class="ancho50">Fecha	</th>
							<th class="ancho200">Accion	</th>
							<th class="ancho200">Asunto	</th>
							<th class="ancho100">Turnado</th>
							';
							
							if($excel=="ok")
							{ 
								$tabla .= '<th class="trbusca ofiAccion"> Asunto</th>';
								$tabla .= '<th class="trbusca ofiAccion"> Fecha de Recepcion del volante</th>';
							}
							
							$tabla .= '<th class="trbusca ofiAccion"> Status</th>
							<!-- <th class="ofiAccion"> Estado </th> -->
							<th class="trbusca ofiAccion"> Seguimiento </th>
						</tr>
					</table>
				</div>
				
				<div style="height:250px; overflow-y:auto;">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					';
					
					
						while($r = mysql_fetch_array($sql))
						{
							$i++;
							$res = $i%2;
							if($res == 0) $estilo = "class='non'";
							else $estilo = "class='par'";
							
							//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
							if($r['status'] == 0) $txtStatus = "<b style='color:red'>CANCELADO</b>";
							else $txtStatus = "<b style='color:blue'>ACTIVO</b>";
							
							if($r['semaforo'] == 0) $txtSem = "<b style='color:red'>PENDIENTE</b>";
							if($r['semaforo'] == 1) $txtSem = "<b style='color:#DFE616'>TURNADO</b>";
							if($r['semaforo'] == 2) $txtSem = "<b style='color:green'>ATENDIDO</b>";
							//-------  SIE ESTA CANCELADO ----------------
							if($r['status'] == 0) $txtSem = "<b style='color:red'>CANCELADO</b>";
							
							if($r['accion'] == "") $accion = "00-0-00000-00-0000-00-000";
							else $accion = $r['accion'];
							
							$accion = str_replace("|","<br>",$accion);
							
							if($r['folio'] == "") $folio = $r['id'];
							else $folio = $r['folio'];
							
							$ofiRef = stripslashes($r['referencia']);
							
							$asunto = ($r['asuntoV'] != "") ? $r['asuntoV'] : $r['asuntoVC'];
							//stripslashes()
							
							$tabla .= '
									<tr '.$estilo.' >
										<td class="ancho50" align="center">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$folio).'&nbsp;</td>
										<td class="ancho50" align="center">'.fechaNormal($r['FechaActual']).'&nbsp;</td>
										<td class="ancho200" align="center">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$accion).'&nbsp;</td>
										<td class="ancho200" align="justify">'. $asunto .'&nbsp;</td>
										
										<td class="ancho100" style="width:100px">'.str_ireplace($texto,'<span class="b">'.$texto.'</span>',$r['turnado']).'&nbsp;</td>';
							if($excel=="ok"){ $tabla .= '<td class="ofiLeyenda">'.$r['asunto'].'&nbsp;</td>';
							$tabla .= '<td class="ancho50">'.fechaNormal($r['fecha_actual']).'&nbsp;</td>';			}
							$tabla .= '<td class="ancho100">'.$txtStatus.'</td> 
										<td class="ancho100" align="center">'.$txtSem.'</td>
										
										<!-- 
										<td class="ancho100">';
							
										//--- si es numérico y es mayor de 33 es de medios -----------------
										if(is_numeric($r['tipoMov']) && $r['tipoMov'] >= 33) $tabla .= '<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\' new mostrarCuadro(450,800,"Volante de Correpondencia",70,"cont/vol_volante_medios.html.php","folio='.$r['folio'].'&direccion='.$_SESSION['direccion'].'") \'></a>';
										else $tabla .= '<a href="#" title="Ver Información" class="icon-5 info-tooltip" onclick=\' new mostrarCuadro(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","folio='.$r['folio'].'&direccion='.$_SESSION['direccion'].'") \'></a>';
														
										if($r['semaforo'] == 0)
											$tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\' new mostrarCuadro(470,800,"Modificar Volante '.$r['folio'].'",60,"cont/vol_edita_volantes.php","id='.$r['id'].'&direccion='.$_SESSION['direccion'].'") \'></a>';
										
										if($r['semaforo'] != 0)
												$tabla .= '<a href="#" title="Asignar Acción" class="icon-6 info-tooltip" onclick=\' new mostrarCuadro(200,730,"Asignar Acción '.$r['accion'].'",100,"cont/vol_asigna_volantes.php","id='.$r['id'].'&direccion='.$_SESSION['direccion'].'") \'></a> ';
												$tabla .= '</td> -->
												</tr>';
						}
						//<a href="#" title="Presuntos Responsables" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,800,"Presuntos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].' ",50,"cont/po_presuntos.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>
					$tabla .= '
					</table>
				</div>
			</div>';
			
			if($total == 0) $tabla = "<center><br><br><br><br><h3> No se encontraron volantes </h3><br><br><br></center>";
			
			echo $tabla;

       ?>
</div>



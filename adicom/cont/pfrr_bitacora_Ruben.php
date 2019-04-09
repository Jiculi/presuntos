<script>
function verTexto(texto)
{
 new mostrarCuadro2(200,600,"Detalle del Movimiento",200);
 $$("#cuadroRes2").html(texto);	
}
function subirArchivos()
{
 new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/pfrr_subirArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
 //$$("#cuadroRes2").html(texto);	
}
function verPdf(archivo)
{
 new mostrarCuadro2(600,800,"Visor de Documento "+archivo,10,"cont/po_verPdf.php","archivo="+archivo);//alto,ancho,titulo,top,pagina,datos
 //$$("#cuadroRes2").html(texto);	
}

</script>

<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
$direccion = $_REQUEST['direccion'];

if($direccion == "DG")
	$tabla = " <a href='#' onclick='subirArchivos()'>Subir Archivos <img src='images/Upload.png' /> </a> ";

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
//------------------- datos del PO --------- ---------------------------------   
$sql1 = $conexion->select("SELECT num_accion,po FROM pfrr WHERE num_accion = '".$accion."' ",false);
$po = mysql_fetch_array($sql1);
$total1 = mysql_num_rows($sql1);
//------------------- datos de citatorios -----------------------------------
//------------------- datos de PFRR HISTORIAL ---------------------------------  
$sql = $conexion->select("SELECT * FROM pfrr_historial WHERE num_accion = '".$accion."' AND pfrr_historial.status = 1 order by fechaSistema desc, id desc ",false);
$total = mysql_num_rows($sql);

while($r = mysql_fetch_array($sql))
{
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//tipo	oficio	oficioRecepcion	oficioAcuse
	$txtTipo = "";
	$tablaDatos = "";
	//------------ configuramos textos e imagenes ---------------
	if($r['tipo'] == 'recepcion') 		$imagen = '<img src="images/page_add.png"/> ';
	if($r['tipo'] == 'asistencia') 		$imagen = '<img src="images/page_delete.png"/> '; 
	if($r['tipo'] == 'DTNS' || 
	$r['tipo'] == 'dtns') 
										$imagen = '<img src="images/page_go.png"/> ';
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
	
	//--------------- sacamos las uaa's de fondos -------------------------------
	$sqlX=$conexion->select("SELECT * FROM fondos where num_accion='".$accion."' ",false);
	$rX=mysql_fetch_array($sqlX);
	//--------------- textos de Aspectos legales --------------------------------
	$sqlY=$conexion->select("SELECT * FROM pfrr where num_accion='".$accion."' ",false);
	$rY=mysql_fetch_array($sqlY);
	//--------------- sacamos todos presunto --------------------------------
	$presuntos = "";
	$sqlPR=$conexion->select("SELECT nombre,cargo,dependencia FROM pfrr_presuntos_audiencias WHERE num_accion='".$accion."' AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme') ",false);
	
	while($pr=mysql_fetch_array($sqlPR))
		$presuntos .= $pr['nombre'].", ".$pr['cargo'].",  ";
				
	//print_r($presuntos);
	//--------------- sacamos po --------------------------------
	$sql1 = $conexion->select("SELECT num_accion,po FROM pfrr WHERE num_accion = '".$accion."' ",false);
	$po = mysql_fetch_array($sql1);
	$total1 = mysql_num_rows($sql1);
	//--------------- textos de Aspectos legales --------------------------------
	if($r['estadoTramite'] == 10) $txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.stripslashes(html_entity_decode($r['oficio'])).' de fecha '.fechaNormal($r['oficioRecepcion']).',	recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' remitió a esta DGR, un PPO junto con su ET para su Asistencia Jurídica.		Se recibió junto con el CRAL del SICSA número '.$r['sicsa'].' de fecha '.fechaNormal($r['sicsaRecepcion']).' y se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 11) $txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.stripslashes(html_entity_decode($r['oficio'])).' de fecha '.fechaNormal($r['oficioRecepcion']).',	recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' remitió a esta DGR, un PPO junto con su ET para su Asistencia Jurídica.		Se recibió junto con el CRAL del SICSA número '.$r['sicsa'].' de fecha '.fechaNormal($r['sicsaRecepcion']).' y se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 13) $txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.$r['oficio'].' de fecha '.fechaNormal($r['oficioRecepcion']).', y entregado el día '.fechaNormal($r['oficioAcuse']).'  esta DGR devuelve a la '.$rX['UAA'].' el DT y ET en virtud de que, derivado del análisis juridico realizado, se determinaron diversas observaciones para que sean tomadas en consideración y poder valorar si con dichas adecuaciones es procedente el inicio del PFRR. Se emitió CRAL del SICSA número DGARFM-DF-DTS el día fecha.' ;
	if($r['estadoTramite'] == 14) $txtTipo = fechaNormal($r['fechaSistema']).'. Mediante copia del oficio número '.$r['oficio'].' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' hace de nuestro conocimiento que se notificó a la EF la Solventación del PO numero '.$po['po'].'. Se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 15) $txtTipo = fechaNormal($r['fechaSistema']).'. Se dicta acuerdo de inicio con fecha '.fechaNormal($r['fechaSistema']).' para el PFRR con número '.$r['oficio'].', correspondiente al PO número '.$po['po'].'.';
	if($r['estadoTramite'] == 30) $txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.$r['oficio'].' de fecha '.fechaNormal($r['oficioRecepcion']).' con fecha de acuse '.fechaNormal($r['oficioAcuse']).', se comunica a la ICC que se emitio <i>"Acuerdo de Inicio"</i> a través del cual se da por iniciado el PFRR en contra de '.$presuntos.' de conformidad con lo dispuesto por el articulo 56, parrafo segundo de la LFRCF. ';
	
	if($r['estadoTramite'] == 16)
	{
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND oficio_citatorio = '".$r['oficio']."' ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.$noAud['oficio_citatorio'].' de fecha '.fechaNormal($noAud['fecha_oficio_citatorio']).', con fecha de acuse '.fechaNormal($noAud['fecha_notificacion_oficio_citatorio']).', se notificó el oficio citatorio de forma '.fechaNormal($noAud['tipo_notificacion']).' y se cita a comparecer personalmente el día '.fechaNormal($noAud['fecha_audiencia']).' a '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', en las instalaciones de la ASF ubicadas en el CEA';
	}
	if($r['estadoTramite'] == '16.1')
	{
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$query = "SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."'  AND idPresunto = '".$r['presunto']."'  AND tipo = 2";
		$sqlAud = $conexion->select($query,false);

		$datosPresunto = damePresunto($r['presunto']);
		
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Mediante escrito de fecha '.$noAud['oficio_citatorio'].' recibido el día '.fechaNormal($noAud['acuce_oficio_citatorio']).', el PR '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', solicito diferimiento de su audiencia de ley. Se levanta acta a través de la cual, por única vez, se otorga el diferimiento de la audiencia en la que se actúa y se señala como nueva fecha el día '.fechaNormal($noAud['fecha_audiencia']).' ';
	}
	if($r['estadoTramite'] == '16.2')
	{
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 3",false);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Siendo el '.fechaNormal($noAud['fecha_audiencia']).' día señalado para la continuación de la audiencia, comparecencia a la que fue citado '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', se hace constar que se encontro presente a fin de continuar con el desahogo de la audiencia de ley.';
	}
	if($r['estadoTramite'] == '16.3')
	{
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 6",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Tomando en consideración que quedaron pruebas pendientes de desahogar, con fundamento en el articulo 57 fracción VI segundo párrafo de la Ley de Fiscalización y Rendición de Cuentas de la Federación, se suspendio y fijó el día '.fechaNormal($noAud['fecha_audiencia']).' para la continuación de audiencia de '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].'. ';
	}
	if($r['estadoTramite'] == '17')
	{
		//fecha_audiencia fecha_pruebas comparece responsabilidad tipo
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND oficio_citatorio = '".$r['oficio']."' ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Con fecha '.fechaNormal($noAud['fecha_audiencia']).'  se dio inicio al desahogo de la audiencia de la ley a la que fue citado(a) '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].'; la cual se concluyó considerando las manifestaciones que conforme a sus intereses convino.';
	}
	if($r['estadoTramite'] == 18) 
	{
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 4 ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Teniendo lugar en esta DGR el PR  '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', ofreció las pruebas que conforme a su derecho convino, las cuales fueron admitidas y desahogadas dadas su naturaleza el día '.fechaNormal($noAud['fecha_pruebas']).'. ';
	}
	if($r['estadoTramite'] == 31) 
	{
		$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias WHERE num_accion = '".$accion."' AND idPresunto = '".$r['presunto']."' AND tipo = 5 ",false);
		$toAud = mysql_num_rows($sqlAud);
		$datosPresunto = damePresunto($r['presunto']);
		while($noAud = mysql_fetch_array($sqlAud))
			$txtTipo = fechaNormal($r['fechaSistema']).'. Desahogadas las pruebas admitidas el día  '.fechaNormal($noAud['fecha_pruebas']).' el PR, '.$datosPresunto['nombre'].', '.$datosPresunto['cargo'].', formuló los alegatos correspondientes. ';
	}
	if($r['estadoTramite'] == 19) {
		$txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.stripslashes(html_entity_decode($r['oficio'])).' de fecha '.fechaNormal($r['oficioRecepcion']).',	entregado el día '.fechaNormal($r['fecha_oficio']).', se solicita a la  '.$rX['UAA'].' opinión técnica sobre documentación presentada y/o pruebas ofrecidas por los PR '.$presuntos.'.';
	}
	if($r['estadoTramite'] == 28) {
		$txtTipo = fechaNormal($r['fechaSistema']).'. Mediante oficio número '.stripslashes(html_entity_decode($r['oficio'])).' de fecha '.fechaNormal($r['oficioRecepcion']).',	entregado el día '.fechaNormal($r['fecha_oficio']).', se solicita a la  '.$rX['UAA'].' opinión técnica sobre documentación presentada y/o pruebas ofrecidas por los PR '.$presuntos.'.';
	}
	
	
	
	
	//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
	//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
	$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion = '".$accion."' ",false);
	while($o = mysql_fetch_array($sqlO))
	{
		$oficioDoc = str_replace("!","/",$o['oficioDoc']);
		$txtTipo = str_replace($oficioDoc," <a href=\"#\" onclick=\"verPdf('".$o['nombreDoc']."')\"> $oficioDoc </a> ",$txtTipo);
	}
	/*
	if($r['tipo'] == 'recepcion' || $r['tipo'] == 'asistencia/devolucion')
	{
			$tablaDatos .= '	
				<br>		
				 <table align="center" class="tablaBitacora tablasBitDetalles">
				<tr valign="baseline">
				  <td class="etiquetaPo" >Oficio de '.$txtOficio.':  </td>
				  <td class="bitTdDatos">'.$r['oficio'].'</td>
				  ';
				  if($r['sicsa'] != "") $tablaDatos .= '<td class="etiquetaPo" >CRAL:</td> <td class="bitTdDatos">'.$r['sicsa'].'</td>';
				  if($r['volante'] != "") $tablaDatos .= '<td class="etiquetaPo" >Volante:</td><td class="bitTdDatos">'.$r['volante'].'</td>';
			$tablaDatos .= '			
				</tr>

				<tr valign="baseline">
				  <td class="etiquetaPo" >Fecha de Oficio de '.$txtOficio.':</td>
				  <td class="bitTdDatos">'.fechaNormal($r['oficioRecepcion']).'</td>
				  ';
				 if($r['sicsa'] != "") $tablaDatos .= '<td  class="etiquetaPo" >Fecha de CRAL:</td> <td class="bitTdDatos">'.fechaNormal($r['sicsaRecepcion']).'</td>';
				 if($r['volante'] != "") $tablaDatos .= '<td  class="etiquetaPo" >Fecha de Volante:</td> <td class="bitTdDatos">'.fechaNormal($r['volanteRecepcion']).'</td>';
			$tablaDatos .= '
				</tr>

				<tr valign="baseline">
				  <td class="etiquetaPo" >Acuse de Oficio de '.$txtOficio.':</td>
				  <td class="bitTdDatos">'.fechaNormal($r['oficioAcuse']).'</td>';
				  
				  if($r['sicsa'] != "") $tablaDatos .= '<td  class="etiquetaPo" >Acuse de CRAL:</td> <td class="bitTdDatos">'.fechaNormal($r['sicsaAcuse']).'</td>';
				  if($r['volante'] != "") $tablaDatos .= '<td  class="etiquetaPo" >Acuse de Volante:</td> <td class="bitTdDatos">'.fechaNormal($r['volanteAcuse']).'</td>';
			$tablaDatos .= '				
				</tr>
			  </table>';
			//echo "<input type='text' id='tablaDatosRec' value='".$tablaDatos."' />";
			$tablaDatos = str_replace('"',"",$tablaDatos);
			$tablaDatos = eregi_replace("[\n|\r|\n\r]","", $tablaDatos);
			$onClick = "verTexto('$tablaDatos')";
	}
	*/
	// primer celda estado e imagen
	if(ctype_digit($r['estadoTramite'])) $estadoTram = dameEstado($r['estadoTramite']);
	else {
		if($r['estadoTramite'] == '16.1') $estadoTram = "Diferimiento de Audiencia";
		if($r['estadoTramite'] == '16.2') $estadoTram = "Continuación de Audiencia";
		if($r['estadoTramite'] == '16.3') $estadoTram = "Suspensión de Audiencia";
	}
	
	$tabla .= '
			<tr '.$estilo.'>
				<td class="bitEdoTra" >
					<table class="tablaBitacora">
						<tr>
							<td onClick="'.$onClick.'">'.$imagen.'</td>
							<td>'.$estadoTram.'</td>
					</table>
				</td>
				<!--
				<td class="bitEvento">'.$r['tipo'].'</td>
				-->
				<td class="bitDatos">';
				
	//--- segunda celda leyenda aspectos Legales
	$tabla .=  $txtTipo;
				
							
			$tabla .= '</td>';
			$userBit = dameUsuario($r['usuario']);
	//tercer celda hora y usuario que modifico
			$tabla .= '<td class="bitActua">'.fechaNormal($r['fechaSistema']).' '.$r['horaSistema'].' <br> '.$userBit['nombre'].'</td>';
			$tabla .= '</tr>';
}
if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta acción no tiene movimientos</h3></center></td></tr>";
$tabla .= '</tbody>	</table>
		<!--  end product-table................................... --> ';
echo "".$tabla."";

mysql_free_result($sql);
?>

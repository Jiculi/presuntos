<script>
function verTexto(texto)
{
 new mostrarCuadro2(300,600,"Detalle del Movimiento",150);
 $$("#cuadroRes2").html(texto);	
}
function subirArchivos()
{
 //$$("#cuadroRes2").html(texto);	
}
function subirArchivos(tipo)
{
	if(tipo == 1) new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/opiniones_subirArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
	if(tipo == 2) new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/opiniones_subirOtrosArchivos.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
	if(tipo == 3) new mostrarCuadro2(600,800,"Subir Archivos",10,"cont/opiniones_subirOtrosArchivosGen.php","accion=<?php echo $_REQUEST['numAccion'] ?>");//alto,ancho,titulo,top,pagina,datos
 //$$("#cuadroRes2").html(texto);	
}

function verPdf(archivo)
{
 new mostrarCuadro2(600,800,"Visor de Documento "+archivo,10,"cont/opiniones_verPdf.php","archivo="+archivo);//alto,ancho,titulo,top,pagina,datos
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
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
$direccion = $_REQUEST['direccion'];

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
?>
<div class="encVol">
    <div id='paso1' onclick="muestraPestanaBit(1)" class="todosPasos pasosActivo pasos"> BITACORA </div>
    <div id='paso2' onclick="muestraPestanaBit(2)" class="todosPasos pasosActivo pasos"> OTROS OFICIOS (GENERADOS)</div>
    <div id='paso3' onclick="muestraPestanaBit(3)" class="todosPasos pasosActivo pasos"> OTROS OFICIOS (RECIBIDOS)</div>
</div>
<div id='p1' class="contOficios redonda10 todosContPasos">

<?php  
//------------------- datos de PO --------- ---------------------------------   
$sql1 = $conexion->select("SELECT num_accion,numero_de_pliego FROM opiniones WHERE num_accion = '".$accion."' ",false);
$po = mysql_fetch_array($sql1);
$total1 = mysql_num_rows($sql1);
//------------------- datos de NOTIFICACION --------- -----------------------    
$sql2 = $conexion->select("SELECT * FROM opiniones_historial WHERE num_accion = '".$accion."' AND status = 1 AND oficioNotEntidad <> '' order by fechaSistema desc limit 1 ",false);
$not = mysql_fetch_array($sql2);
$total2 = mysql_num_rows($sql2);
//------------------- datos de PO HISTORIAL ---------------------------------  
$sql = $conexion->select("SELECT * FROM opiniones_historial WHERE num_accion = '".$accion."' AND opiniones_historial.status = 1 order by fechaSistema desc, horaSistema desc, estadoTramite desc ",false);
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
	if($r['tipo'] == 'recepcion') 
	{
		$txtOficio = "recepción";
		$imagen = '<img src="images/page_add.png"/> ';
	}
	if($r['tipo'] == 'asistencia/devolucion') 
	{ 
		$txtOficio = "devolución";
		$imagen = '<img src="images/page_delete.png"/> '; 
	}
	if($r['tipo'] == 'DTNS' or $r['tipo'] == 'dtns') 
	{
		$txtOficio = "DTNS";
		$imagen = '<img src="images/page_go.png"/> ';
	}
	if($r['tipo'] == 'notificación') $imagen = '<img src="images/page_white_paste.png"/> ';

	//--------------- textos de Aspectos legales --------------------------------
	$sqlX=$conexion->select("SELECT * FROM fondos where num_accion='".$accion."' ",false);
	$rX=mysql_fetch_array($sqlX);
	//--------------- textos de Aspectos legales --------------------------------
	if($r['estadoTramite'] == 100) $txtTipo = '<span class="fechaPO"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).',	recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' remitió a esta DGR, un PPO junto con su ET para su Asistencia Jurídica.		Se recibió junto con el CRAL del SICSA número '.$r['sicsa'].' de fecha '.fechaNormal($r['sicsaRecepcion']).' y se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 102) $txtTipo = '<span class="fechaPO"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).' y entregado el dia '.fechaNormal($r['oficioAcuse']).',  esta DGR brindó Asistencia Jurídica y, en cumplimiento a la fracción VII de los “Lineamientos para la Formulación y Notificación del Pliego de Observaciones”, remitió a la '.$rX['UAA'].', PPO y ET con el análisis de los requisitos para la formulación del PO y se emitieron comentarios y/o sugerencias en torno a su contenido; a fin de que valorara su implementación y lo devolviera para su notificación correspondiente. Se emitio el CRAL  del SICSA número '.$r['sicsa'].' el dia '.fechaNormal($r['sicsaRecepcion']).'.';
	if($r['estadoTramite'] == 103) $txtTipo = '<span class="fechaPO"></span>'.'Mediante copia del oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el dia '.fechaNormal($r['oficioAcuse']).' la '.$rX['UAA'].' hace de nuestro conocimiento que se notificó a la EF la Solventación del PO numero '.$po['numero_de_pliego'].'. Se generó el volante interno número '.$r['volante'].'. ';
	if($r['estadoTramite'] == 104) $txtTipo = '<span class="fechaPO"></span>'.'Mediante tarjeta número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el día '.fechaNormal($r['oficioAcuse']).', la oficina del AEGF remitió a esta DGR el PO firmado. Se inició trámite de certificación y el proceso para su notificación correspondientes. Se generó el volante interno número '.$r['volante'].'.';	
	if($r['estadoTramite'] == 10)$txtTipo = '<span class="fechaPO"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', recibido el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' remitió a esta DGR el DTNS numero  '.$r['dt'].' correspondiente al PO número '.$po['numero_de_pliego'].', acompañado de su respectivo ET y proyecto de DT  para que, de proceder, se inicie el PFRR. Se recibió junto con el CRAL del SICSA número '.$r['sicsa'].'. De fecha '.fechaNormal($r['sicsaRecepcion']).' y se generó el volante interno número '.$r['volante'].'.';
	if($r['estadoTramite'] == 27)$txtTipo = '<span class="fechaPO"></span>'.'Mediante oficio número '.cadenaNormalOficio($r['oficio']).' de fecha '.fechaNormal($r['oficioRecepcion']).', recibida el día '.fechaNormal($r['oficioAcuse']).', la '.$rX['UAA'].' nos remite copia de la cédula firmada número CEDULA de fecha FECHACEDULA, donde se hace de nuestro conocimiento que la acción se da por Concluida. Se generó el volante interno número '.$r['volante'].'.';
	
	//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
	$sqlO = $conexion->select("SELECT * FROM archivos WHERE num_accion LIKE '%".$accion."%' ",false);
	while($o = mysql_fetch_array($sqlO))
	{
		/*
		$oficioDoc = str_replace("!","/",$o['oficioDoc']);
		$oficioDoc = str_replace("--","\"",$oficioDoc);
		$oficioDoc = html_entity_decode($oficioDoc);
		*/
		$oficioDoc = cadenaNormalOficio($o['oficioDoc']);
		
		$txtTipo = str_replace($oficioDoc," <a href=\"#\" onclick=\"verPdf('".stripslashes(html_entity_decode($o['nombreDoc']))."')\"> $oficioDoc </a> ",$txtTipo);
	}
	//-----------------------------------------------------------------------------------------	
	if($r['tipo'] == 'recepcion' || $r['tipo'] == 'asistencia/devolucion' || $r['tipo'] == 'DTNS' || $r['tipo'] == 'dtns')
	{
			$tablaDatos .= '	
				<br>		
				 <table  width="100%" align="center" class="tablaBitacora tablasBitDetalles">
				<tr valign="baseline">
				  <td class="etiquetaPo" >Oficio de '.$txtOficio.':  </td>
				  <td class="bitTdDatos">'.stripslashes(html_entity_decode($r['oficio'])).'</td>
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
	if($r['tipo'] == 'notificación')
	{
			$tablaDatos .= '
				<br>		
				 <table align="center" class="tablaBitacora tablasBitDetalles">
				<tr valign="baseline">
				  <td class="etiquetaPo">Oficio de notificacion a EF: </td>
				  <td class="bitTdDatos">'.$r['oficioNotEntidad'].'</td>
				 <td class="etiquetaPo">Oficio de notificación al ICC:</td> 
				 <td class="bitTdDatos">'.$r['oficioNotOIC'].'</td>';
			$tablaDatos .= '			
				</tr>

				<tr valign="baseline">
				  <td class="etiquetaPo" >Fecha del Oficio<br> de Notificación a EF:</td>
				  <td class="bitTdDatos">'.fechaNormal($r['fechaNotEntidad']).'</td>
				  <td  class="etiquetaPo" >Fecha del Oficio<br> de Notificación al ICC:</td> 
				  <td class="bitTdDatos">'.fechaNormal($r['fechaNotOIC']).'</td>';
			$tablaDatos .= '
				</tr>

				<tr valign="baseline">
				  <td class="etiquetaPo" >Acuse del Oficio<br> de Notificación a EF:</td>
				  <td class="bitTdDatos">'.fechaNormal($r['acuseNotEntidad']).'</td>
				  <td  class="etiquetaPo" >Acuse del Oficio<br> de Notificación al ICC:</td> 
				  <td class="bitTdDatos">'.fechaNormal($r['acuseNotOIC']).'</td>';
			$tablaDatos .= '				
				</tr>
			  </table>';
			//echo "<input type='text' id='tablaDatosNot' value='".$tablaDatos."' />";
			$tablaDatos = str_replace('"',"",$tablaDatos);
			$tablaDatos = eregi_replace("[\n|\r|\n\r]","", $tablaDatos);
			$onClick = "verTexto('$tablaDatos')";
	}
	
	//$tablaDatos = urlencode($tablaDatos);
	//echo "<pre>$tablaDatos</pre>";
	//$nt = convert_uuencode($tablaDatos);
	//$nt2 = base64_encode($tablaDatos);
	
		
	$tabla .= '
			<tr '.$estilo.'>
				<td class="bitEdoTra" >
				<table class="tablaBitacora">
					<tr>
						<td onClick="'.$onClick.'">'.$imagen.'</td>
						<td>'.dameEstado($r['estadoTramite']).'</td>
					</table>
				
				</td>
				<!--
				<td class="bitEvento">'.$r['tipo'].'</td>
				-->
				<td class="bitDatos">';
				
				//--- leyenda aspectos Legales
	$tabla .=  $txtTipo;
				
							
			$tabla .= '</td>';
			$userBit = dameUsuario($r['usuario']);
			$tabla .= '<td class="bitActua">'.fechaNormal($r['fechaSistema']).' '.$r['horaSistema'].' <br> '.$userBit['nombre'].'</td>';
			$tabla .= '</tr>';
}
if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta acción no tiene movimientos</h3></center></td></tr>";
$tabla .= '</tbody>	</table>
		<!--  end product-table................................... --> ';
echo $tabla;

mysql_free_result($sql);
?>
</div>
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<div id='p2' class="contOficios redonda10 todosContPasos" style="display:none">

<?php
//if($direccion == "DG")
	echo " <a href='#' onclick='subirArchivos(3)'>Subir Archivos <img src='images/Upload.png' /> </a> ";
?>

    <h3 class="poTitulosPasos">Listado de Oficios</h3>
    
   <?php
    //$sql = $conexion->select("SELECT * FROM otros_oficios WHERE num_accion = '".$accion."' ",false);
	$sql = $conexion->select("SELECT *,o.folio AS Folio,o.id AS idFol,o.tipo AS tOficio, status AS state FROM oficios o
							  WHERE num_accion LIKE '%".$accion."%' 
							  AND tipo IN (SELECT value FROM oficios_options WHERE estado = 'po' AND tipo = 'otros')",false);

    $total = mysql_num_rows($sql);
    $tabla = '
            <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                <tr>
                    <th class="ancho100"><a href="#">Oficio</a></th>
                    <th class="ancho100"><a href="#">Fecha</a></th>
                    <th class="ancho100"><a href="#">Asunto</a></th>
                    <th class="ancho100"><a href="#"> tipo </a></th>
                </tr>
            </table>
            <div style="height:200px;width:100%;overflow:auto">
            
            <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
            <tbody>
            ';

            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
                $tabla .= '
                        <tr '.$estilo.' >
                            <td class="ancho100">'.verificaOficioLink($r['folio']).'</td>
                            <td class="ancho100" align="center">'.fechaNormal($r['fecha_oficio']).'</td>
                            <td class="ancho100">'.$r['asunto'].'</td>
                            <td class="ancho100" align="center">'.$r['tipo'].'</td>
                        </tr>';
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



<div id='p3' class="contOficios redonda10 todosContPasos" style="display:none">

<?php
//if($direccion == "DG")
	echo " <a href='#' onclick='subirArchivos(2)'>Subir Archivos <img src='images/Upload.png' /> </a> ";
?>

    <h3 class="poTitulosPasos">Listado de Oficios</h3>
    
   <?php
    $sql = $conexion->select("SELECT * FROM otros_oficios WHERE num_accion = '".$accion."' ",false);
    $total = mysql_num_rows($sql);
    $tabla = '
            <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                <tr>
                    <th class="ancho100"><a href="#">Tipo de Oficio</a>	</th>
                    <th class="ancho100"><a href="#">Oficio/Volante</a></th>
                    <th class="ancho100"><a href="#">Oficio Referencia</a></th>
                    <th class="ancho100"><a href="#">Fecha</a></th>
                    <th class="ancho100"><a href="#"> Leyenda </a></th>
                    <!-- <th class="ancho100"><a href="#"> Accion </a></th> -->
                </tr>
            </table>
            <div style="height:200px;width:100%;overflow:auto">
            
            <table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
            <tbody>
            ';

            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
                $tabla .= '
                        <tr '.$estilo.' >
                            <td class="ancho100">'.$r['tipo'].'</td>
                            <td class="ancho100">'.verificaOficioLink($r['folio_volante']).'</td>
                            <td class="ancho100">'.$r['documentoExtra'].'</td>
                            <td class="ancho100">'.fechaNormal($r['fecha']).'</td>
                            <td class="ancho100">'.$r['leyenda'].'</td>
							<!--
                            <td class="ancho100">
                                <a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(400,500,"Informacion del Oficio '.$r['oficio_tipo_oficio_adicional'].'",100,"cont/po_otros_oficios_info.php","id='.$r['id'].'")\'></a>
                                <a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1100,"Accion '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",100,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a> 
                            </td>
							-->
                        </tr>';
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
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->
<!--- ---------------------------------------------------------------------------------------------- -->


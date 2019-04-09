<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
/*------------------------------- pagina volantes --------------------------------*/
#pfrrDiv .nomSis{ color:#390 !important}
#pfrrDiv h3{color:#390 !important}
#pfrrDiv .pasosActivo{ 
	display:inline-block; 
	padding:5px 12px;
	height:25px;  
	cursor:pointer;
	line-height:25px; 
	background:#390 !important;
	font-weight:bold;  
	color:#EEE;}
#pfrrDiv textarea:focus,textarea:hover,input[type="text"]:hover, input[type="text"]:focus,select:hover,select:focus 
{border: 1px solid #390 !important;}
/*#pagVolantes .submit-login{ background:#F0F !important}*/
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:10px 0;
	}
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:10px 0;
	}
	
#pfrrDiv #product-table tr:hover { background:#CBFF97 !important; }
.tablaInfo .etiquetaInfo {border: 1px solid #390 !important; color:#390}
/* .contVolantes{border: 2px solid #F0F !important;} */
/* .pasos{ background:#F39 !important} */

#pfrrDiv #related-act-top	{
	/*background:url(../images/forms/header_related_act.gif);*/
	background:#390 !important;
	width:260px;
	height:43px;
	margin:10px auto 0 auto;
	-moz-border-radius: 8px 8px 0px 0px ;
    -webkit-border-radius: 8px 8px 0px 0px ;
    border-radius: 8px 8px 0px 0px ;
	
	}
#pfrrDiv .pfAccesible{background:#390 !important;}
/*------------------------------- pagina oficios --------------------------------*/
#pfrrDiv .camposAcciones{border:1px dotted #666666; padding:20px 50px; margin:10px; height:300px; overflow:auto}
#pfrrDiv .camposLi{list-style:url(../images/OK20.png); margin:5px; position:relative }
#pfrrDiv .camposInputAcciones{}
#pfrrDiv .eliminarInput{ display:inline-block; cursor:pointer; position:relative; background:url(../images/cross.png); height:16px; width:16px; left:-25px; z-index:100}

</style>
<script>
function ocultaAll() 
{
	$$('.contPestanas').removeClass("pActivo");
	$$('.contPestanas').hide();
	$$('.allPestanas').removeClass("pasosActivo");
	//$$('.allPestanas').removeClass("pfAccesible");
} 
function muestraPestana(divId,altura)
{
	ocultaAll();
	$$('#pes'+divId).removeClass('pInactivo');
	$$('#pes'+divId).addClass('pActivo');	
	$$('#pestana'+divId).addClass('pasosActivo');	
	$$('#pestana'+divId).addClass('pfAccesible');	

	$$('#pes'+divId).fadeIn();
	$$('#cuadroDialogo2').height(altura);
	$$('#cuadroRes2').height(altura-50);
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<?php
//------------------------------------------------------------------------------
$id = 			valorSeguro($_REQUEST['id']);
$accion = 		valorSeguro($_REQUEST['numAccion']);
$idPresunto = 	valorSeguro($_REQUEST['idPresuntop']);
$usuario = 		valorSeguro($_REQUEST['usuario']);
$accion = 		valorSeguro($_REQUEST['numAccion']);
$oficio = 		valorSeguro($_REQUEST['oficio']);
//------------------------------------------------------------------------------
// datos del presunto
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias  WHERE cont = ".$_REQUEST['idPresuntop']." ",true);
$r = mysql_fetch_array($sql);
//------------------------------------------------------------------------------
// fecha de oficio citatorio en OFICIOS
$sql=$conexion->select("SELECT folio, fecha_oficio FROM oficios WHERE tipo='citatorio_PFRR' and num_accion LIKE  '%".$accion."%' and juridico='1' ORDER BY fecha_oficio desc limit 1"); 
$ofi = mysql_fetch_array($sql);
$nOf = mysql_num_rows($sql);
$ofiCitatorio = $ofi['folio'];
$ofiFecha = fechaNormal($ofi['fecha_oficio']);
//------------------------------------------------------------------------------
// CONSULTAMOS TODOS LAS AUDIENCIAS DEL PRESUNTO
$sqlAud = $conexion->select("SELECT * FROM pfrr_audiencias  WHERE num_accion = '".$accion."' AND idPresunto = ".$idPresunto." ORDER BY  fecha_audiencia ASC  ",true);//fecha_audiencia ASC, id DESC
$noAud = mysql_num_rows($sqlAud);
//------------------------------------------------------------------------------
if(cambioEstado($accion,28)) $editar = 1; 
else $editar = 0;
//pestaña continuacion
$onclickP3 = "onclick='muestraPestana(3,550)'";
$txtPaso3 = "pasosActivo";
$acceso3 = "pfAccesible";
echo "<script>	$$(function(){	$$('#pes3').fadeIn(); });	</script>"; 

$onclickP4 = "onclick='muestraPestana(4,400)'";
//$txtPaso4 = "pasosActivo";
$acceso4 = "pfAccesible";
/* echo "<script>	$$(function() {	$$('#pes4').fadeIn();	});	</script>"; */

$onclickP5 = "onclick='muestraPestana(5,400)'";
//$txtPaso5 = "pasosActivo";
//$acceso5 = "pfAccesible";
/* echo "<script>	$$(function() {	$$('#pes5').fadeIn();	});	</script>"; */

$onclickP6 = "onclick='muestraPestana(6,400)'";
//$txtPaso5 = "pasosActivo";
$acceso5 = "pfAccesible";
/* echo "<script>	$$(function() {	$$('#pes5').fadeIn();	});	</script>"; */

$onclickP7 = "onclick='muestraPestana(7,400)'";
//$txtPaso5 = "pasosActivo";
//$acceso5 = "pfAccesible";
/* echo "<script>	$$(function() {	$$('#pes5').fadeIn();	});	</script>"; */

$onclickP8 = "onclick='muestraPestana(8,400)'";
//$txtPaso5 = "pasosActivo";
//$acceso5 = "pfAccesible";
/* echo "<script>	$$(function() {	$$('#pes5').fadeIn();	});	</script>"; */
?>

<body>
<div id='pfrrDiv'>
<!--------------------------  VARIABLES GENERALES ---------------------------->
<!---------------------------------------------------------------------------->
 <input name='idAudiencia1'  type='hidden'  class='redonda5'  id='idAudiencia1' value='<?php echo $id ; ?>' />
 <input name='idFpresunto1'  type='hidden'  class='redonda5'  id='idFpresunto1' value='<?php echo $_REQUEST['idPresuntop']; ?>' />
 <input name='nomPresunto1'  type='hidden'  class='redonda5'  id='nomPresunto1' value='<?php echo $r['nombre']; ?>' />
 <input name='carPresunto1'  type='hidden'  class='redonda5'  id='carPresunto1' value='<?php echo $r['cargo']; ?>' />
 <input name='depPresunto1'  type='hidden'  class='redonda5'  id='depPresunto1' value='<?php echo $r['dependencia']; ?>' />
 <input name='rfcPresunto1'  type='hidden'  class='redonda5'  id='rfcPresunto1' value='<?php echo $r['rfc']; ?>' />
 <input name='accPresunto1'  type='hidden'  class='redonda5'  id='accPresunto1' value='<?php echo $accion ?>' />
 <input name='audOficio1'  type='hidden'  class='redonda5'  id='audOficio1' value='<?php echo $ofiCitatorio ?>' />
 <input name='fecOficio1'  type='hidden'  class='redonda5'  id='fecOficio1' value='<?php echo $ofiFecha ?>' />
 <input name='usuarioAud1'  type='hidden'  class='redonda5'  id='usuarioAud1' value='<?php echo $usuario ?>' />
<!---------------------------------------------------------------------------->
<!---------------------------------------------------------------------------->

    <div class="encPasos">
       <!-- <div id='pestana1' <?php echo $onclickP1 ?> class="allPestanas <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"> FECHA CITATORIO</div> -->
       <div id='pestana3' <?php echo $onclickP3 ?> class="allPestanas <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DESAHOGO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
       <!-- <div id='pestana2' <?php echo $onclickP2 ?> class="allPestanas <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"> FECHA DIFERIMIENTO</div> -->
       <div id='pestana4' <?php echo $onclickP4 ?> class="allPestanas <?php echo $txtPaso4 ?> <?php echo $acceso4 ?> pasos"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; PRUEBAS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
       <div id='pestana5' <?php echo $onclickP5 ?> class="allPestanas <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALEGATOS &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
       <!-- <div id='pestana6' <?php echo $onclickP6 ?> class="allPestanas <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"> ÚLTIMA ACTUACIÓN</div> -->
       <!-- <div id='pestana7' <?php echo $onclickP7 ?> class="allPestanas <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"> CIERRE DE INSTRUCCION</div> -->
    </div>

    <div id='resPasos' class='divPresuntos redonda10'>
    
	<!--  SEGUIMIENTO ------------------------------------------------------------------- -->
    <div id="pes3" class="contPestanas">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Desahogo de Audiencia de Ley / Manifestaciones del PR </h3>
        <?php if($editar == 1 || $_REQUEST['direccion'] == "DG" ) {?>
       		<input type='button' value='Crear Nuevo Oficio Citatorio' class='submit_line' onclick='new mostrarCuadro3(470,800,"<?php echo $r['nombre'] ?>",70,"cont/pfrr_presuntos_proceso_agregarFechas.php","idPresunto=<?php echo $idPresunto ?>&accion=<?php  echo $r['num_accion'] ?>&usuario=<?php echo  $usuario ?>&tipoDeFecha=fechaCitatorio")' />
       <BR /> <BR />
        <?php } ?>
        <?php
		
			//echo '<a href="#" title="Agregar Continuación" class="icon-8 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(400,600,"'.$r['nombre'].'",100,"cont/pfrr_presuntos_proceso_agregarFechas.php","idAud='.$row['id'].'&idPresunto='.$row['idPresunto'].'&accion='.$row['num_accion'].'&oficio='.$row['oficio_citatorio'].'&usuario='.$usuario.'&tipoDeFecha=fechaContinuacion")\'></a>';
		
			$tabla =  '
				<center>    
				<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					<tr>
						<th class="ancho100"> 	<a href="#">Tipo</a>	</th>
						<th class="ancho100"> 	<a href="#">Oficio Citatorio</a>	</th>
						<th class="ancho100"> 	<a href="#">Fecha Oficio</a></th>
						<th class="ancho100">	<a href="#">Fecha Notificación</a></th>
						<th class="ancho100">	<a href="#">Tipo Notificacion </a></th>
						<th class="ancho100">	<a href="#">Fecha Audiencia </a></th>
						<th class="ancho100">	<a href="#">Comparece </a></th>
   						<th class="ancho100">	<a href="#">Seguimiento </a></th>
					</tr>
			';
			$audiencias=0;       
			while($row = mysql_fetch_array($sqlAud))
			{
                $i++;
				++$audiencias;
				
				//echo $audiencias." == ".$noAud."<br>";
				
				if($noAud == $audiencias) $ultimo = true;
				else $ultimo = false;
				
				if($i==1) $fechaMayor = fechaNormal($row['fecha_audiencia']);
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";

				if(
					($row['revisada'] == 0 || $row['comparece'] == '0' || $row['comparece'] == '' ) && 
					($row['fecha_audiencia'] != '0000-00-00' || $row['fecha_audiencia'] != '' ) && 
					($row['tipo'] != 4 && $row['tipo'] != 5 && $row['tipo'] != 6 && $row['tipo'] != 7)
				) $audienciaNoRevisada = 1;
				
				if($row['tipo'] == 1) $tipoAud = "Citatorio";
				if($row['tipo'] == 2) $tipoAud = "Diferimiento";
				if($row['tipo'] == 3) $tipoAud = "Continuación";
				if($row['tipo'] == 4) {$tipoAud = "Pruebas"; $fechaPruebas = fechaNormal($row['fecha_pruebas'] );}
				if($row['tipo'] == 5) $tipoAud = "Admisión";
				if($row['tipo'] == 6) $tipoAud = "Desahogo";
				if($row['tipo'] == 7) $tipoAud = "Alegatos";
				// comparecencia 
				if($row['comparece'] == 's' || $row['comparece'] == '1') { $comparece = "SI"; }
				if($row['comparece'] == 'n' || $row['comparece'] == '0') { $comparece = "NO"; }
				if($row['comparece'] == 'ncn') { $comparece = "NO *"; $noCompareceNunca = true; }
				if(($row['comparece'] == '0' || $row['comparece'] == '') && ($row['tipo'] != 4 && $row['tipo'] != 5 && $row['tipo'] != 6 && $row['tipo'] != 7)) {$comparece = "PENDIENTE"; }
				if(($row['tipo'] == 4 || $row['tipo'] == 5)) {$comparece = "SI"; }
				
				//vemos si hay pruebas(4),admision(5),desahogo(6) y alegatos(7)...
				if(($row['fecha_pruebas'] != '0000-00-00' || $row['fecha_pruebas'] != '') && $row['tipo'] == 4) {$Pruebas = 1; $FP = fechaNormal($row['fecha_pruebas']); }
				if(($row['fecha_pruebas'] != '0000-00-00' || $row['fecha_admision'] != '') && $row['tipo'] == 5){$Admision = 1; $FAD = fechaNormal($row['fecha_admision']); }
				if(($row['fecha_pruebas'] != '0000-00-00' || $row['fecha_desahogo'] != '') && $row['tipo'] == 6){$Desahogo = 1; $FDE = fechaNormal($row['fecha_desahogo']); }
				if(($row['fecha_pruebas'] != '0000-00-00' || $row['fecha_pruebas'] != '') && $row['tipo'] == 7) {$Alegatos = 1; $FA = fechaNormal($row['fecha_pruebas']); }
                // fechas correctas 
				$fechaAudi = fechaNormal($row['fecha_audiencia']);
				if($row['tipo'] == 4 )  $fechaAudi = fechaNormal($row['fecha_pruebas']);
				if($row['tipo'] == 5 )  $fechaAudi = fechaNormal($row['fecha_admision']);
				if($row['tipo'] == 6 )  $fechaAudi = fechaNormal($row['fecha_desahogo']);
				if($row['tipo'] == 7 )  $fechaAudi = fechaNormal($row['fecha_pruebas']);

				//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
				
				
				if($row['fecha_pruebas'] != '0000-00-00' || $row['fecha_pruebas'] != '' || $row['fecha_audiencia'] != '0000-00-00' || $row['fecha_audiencia'] != '' ){
				
				if($row['fecha_oficio_citatorio'] == "0000-00-00" || $row['fecha_oficio_citatorio'] == "") $fechaOfCit = "";
				else  $fechaOfCit =  fechaNormal($row['fecha_oficio_citatorio']);
				if($row['fecha_notificacion_oficio_citatorio'] == "0000-00-00" || $row['fecha_notificacion_oficio_citatorio'] == "") $fechaNotOfCit = "";
				else  $fechaNotOfCit =  fechaNormal($row['fecha_notificacion_oficio_citatorio']);
				
				$tabla .= '
                        <tr '.$estilo.' >
                            <td class="ancho100">'.$tipoAud.'</td>
                            <td class="ancho150">'.$row['oficio_citatorio'].'</td>
							<td class="ancho100" align="center">'.$fechaOfCit.'</td>
 							<td class="ancho100" align="center">'.$fechaNotOfCit.'</td>
							<td class="ancho100">'.$row['tipo_notificacion'].'</td>
							<td class="ancho100" align="center">'.$fechaAudi.'</td>
							<td class="ancho100" align="center">'.$comparece.'</td>
                          <td class="ancho100"  align="center">';
						  
				if($comparece == "PENDIENTE" && $tipoAud != "Alegatos" && $row['comparece'] != 'ncn') $tabla .= '<a href="#" title="Comparesencia" class="icon-3 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(300,500,"'.$row['presunto'].'",150,"cont/pfrr_presuntos_proceso_agregarFechas.php","idAud='.$row['id'].'&idPresunto='.$row['idPresunto'].'&accion='.$row['num_accion'].'&oficio='.urlencode($row['oficio_citatorio']).'&usuario='.$usuario.'&tipoDeFecha=confirmacion&ultimaFecha='.$fechaAudi.'&tipoAudiencia='.$row['tipo'].'")\'></a>';
				if($comparece == "SI" && $ultimo == true && $row['comparece'] != 'ncn' && $tipoAud != "Alegatos" ) $tabla .= '<a href="#" title="Agregar Continuación" class="icon-8 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(400,600,"'.$r['nombre'].'",100,"cont/pfrr_presuntos_proceso_agregarFechas.php","idAud='.$row['id'].'&idPresunto='.$row['idPresunto'].'&accion='.$row['num_accion'].'&oficio='.urlencode($row['oficio_citatorio']).'&usuario='.$usuario.'&tipoDeFecha=fechaContinuacion&ultimaFecha='.$fechaAudi.'")\'></a>';
				if($comparece == "NO" && $ultimo == true && $row['comparece'] != 'ncn' && $tipoAud != "Alegatos" ) $tabla .= '<a href="#" title="Agregar Diferimiento" class="icon-10 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(400,600,"'.$r['nombre'].'",100,"cont/pfrr_presuntos_proceso_agregarFechas.php","idAud='.$row['id'].'&idPresunto='.$row['idPresunto'].'&accion='.$row['num_accion'].'&oficio='.urlencode($row['oficio_citatorio']).'&usuario='.$usuario.'&tipoDeFecha=fechaDiferimiento&ultimaFecha='.$fechaAudi.'")\'></a>';

                $tabla .= '</td></tr>';
				}
			}
			$tabla .= '</table> </center> ';			
			echo $tabla;
		?>
     </div>

<script>
$$( document ).ready(function(){
	$$( "#fechaOfrecimientoPruebas" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: '<?php echo $fechaAudi ?>',
	  //minDate:"01/08/2018",
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#fechaAdmision" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate:"01/08/2018",
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#fechaDesahogo" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate:"01/08/2018",
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });

	$$( "#fechaAlegatos" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	   //minDate:"01/08/2018",
	  //beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
});


</script>    
     
 
	<!--  Ofrecimiento de Pruebas  ------------------------------------------------------------------- -->
	<!--  Ofrecimiento de Pruebas  ------------------------------------------------------------------- -->
	<!--  Ofrecimiento de Pruebas  ------------------------------------------------------------------- -->
	<!--  Ofrecimiento de Pruebas  ------------------------------------------------------------------- -->
	<!--  Ofrecimiento de Pruebas  ------------------------------------------------------------------- -->
    <div id="pes4" class="contPestanas pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Ofrecimiento, Admisión y Desahogo de Pruebas</h3>
        
		<?php
		//-------------------------------------------------------------------------------------------
		if($Pruebas && $Admision && $Desahogo) 
		{
			$disabledPrueba = "disabled"; 
        	echo '<div id="message-green2x">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="green-left">
								Este presunto ya cuenta con fechas de Prueba, Admisión y Desahogo.
							</td>
							<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" onClick=\' $$("#message-green2x").slideUp() \'  alt="" /></a></td>
						</tr>
					</table>
				</div>';
		}
		elseif($noCompareceNunca)
		{
			$disabledPrueba = "disabled"; 
        	echo '<div id="message-yellow2x">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="yellow-left">
								Este presunto ya no comparecera
							</td>
							<td class="yellow-right"><a class="close-yellow"><img src="images/table/icon_close_yellow.gif" onClick=\' $$("#message-yellow2x").slideUp() \'  alt="" /></a></td>
						</tr>
					</table>
				</div>';
		}
		else
		{
			if($Pruebas) $disableSoloPrueba = "disabled";
			if($Admision) $disableSoloAdmision = "disabled";
			if($Desahogo) $disableSoloDesahogo = "disabled";
		}
		
		//-------------------------------------------------------------------------------------------
		if($audienciaNoRevisada == 1) { 
			$disabledPrueba = "disabled"; 
			echo '<div id="message-red2xxx">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="red-left">
						   Aun hay audiencias pendientes... <a href="#" onclick="muestraPestana(3,550)">Click aqui para revisarlas</a>
						</td>
						<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=\' $$("#message-red2xxx").slideUp() \'  alt="" /></a></td>
					</tr>
				</table>
			</div>';
        }
		if($audiencias == 0) { 
			$disabledPrueba = "disabled"; 
			echo '<div id="message-red2xxx">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="red-left">
						   No ha creado aun audiencias... <a href="#" onclick="muestraPestana(3,550)">Click aqui para crearla</a>
						</td>
						<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=\' $$("#message-red2xxx").slideUp() \'  alt="" /></a></td>
					</tr>
				</table>
			</div>';
        } 
		//-------------------------------------------------------------------------------------------
		//if(cambioEstado($accion,18)) $cambiaEdo = 1; 
		//else $cambiaEdo = 0;
		$cambiaEdo = 1; // cambia estado siempre
		//-------------------------------------------------------------------------------------------
		?>
       <div align="center">
        <table class='feDif' width='80%' align='center'>
         <tr><td class="etiquetaPo">Nombre: </td><td class="etiquetaPO" > <?php echo $r['nombre']; ?></td> </tr>
         <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $r['cargo']; ?></td></tr>
         <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $r['rfc']; ?></td> </tr>
        	<tr >
            	<td align="center" colspan="3">
                	<br />
                    <table width="70%" align="center">
                    <tr>
                      <th class="">Fecha Ofrecimiento de Pruebas:</th>
                      <th class="">Fecha Admisión:</th>
                      <th class="">Fecha Desahogo:</th>
                    </tr>
                    <tr>
                      <td align="center">
                          <form name="formPruebas">
                          <label for="monto"></label>
                          <input name="fechaOfrecimientoPruebas"  type="text"  class="redonda5"  id="fechaOfrecimientoPruebas"  value="<?php echo $FP ?>"  readonly="readonly" <?php //echo $disabledPrueba; ?>  <?php //echo $disableSoloPrueba; ?> />
         				  <br /><br />
                          <input type='button' value='Guardar Fecha' class='submit_line' onclick="ofrecimientoPruebas('<?php echo $cambiaEdo ?>','<?php echo $usuario ?>')" <?php //echo $disabledPrueba; ?>  <?php //echo $disableSoloPrueba; ?> /> 
                          </form>
                      </td>
                      <td align="center">
                          <form name="formAdmision">
                          <label for="monto"></label>
                          <input name="fechaAdmision"  type="text"  class="redonda5"  id="fechaAdmision"  value="<?php echo $FAD ?>"  readonly="readonly" <?php //echo $disabledPrueba; ?>  <?php //echo $disableSoloAdmision; ?> />
         				  <br /><br />
                          <input type='button' value='Guardar Fecha' class='submit_line' onclick="ofrecimientoAdmision('<?php echo $cambiaEdo ?>','<?php echo $usuario ?>')" <?php //echo $disabledPrueba; ?> <?php //echo $disableSoloAdmision; ?> /> 
                          </form>
                      </td>
                      <td align="center">
                          <form name="formDesahogo">
                          <label for="monto"></label>
                          <input name="fechaDesahogo"  type="text"  class="redonda5"  id="fechaDesahogo"  value="<?php echo $FDE ?>"  readonly="readonly" <?php //echo $disabledPrueba; ?> <?php //echo $disableSoloDesahogo; ?> />
         				  <br /><br />
                          <input type='button' value='Guardar Fecha' class='submit_line' onclick="ofrecimientoDesahogo('<?php echo $cambiaEdo ?>','<?php echo $usuario ?>')" <?php //echo $disabledPrueba; ?> <?php //echo $disableSoloDesahogo; ?> /> 
                          </form>
                      </td>
                    </tr>
                    </table>
                    
            	</td>
            </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> 
        </div>
		<br /><br />
     </div>
     
	<!--  Periodo de Alegatos ------------------------------------------------------------------- -->
	<!--  Periodo de Alegatos ------------------------------------------------------------------- -->
	<!--  Periodo de Alegatos ------------------------------------------------------------------- -->
	<!--  Periodo de Alegatos ------------------------------------------------------------------- -->
	<!--  Periodo de Alegatos ------------------------------------------------------------------- -->
    <div id="pes5" class="contPestanas pInactivo">
        <div style="float:right"><img src="images/help.png" /></div>
        <h3 class="poTitulosPasos">Período de Alegatos   </h3>
        
        <?php
		//-------------------------------------------------------------------------------------------
		if($Alegatos) 
		{ 
			$disabledAlegatos = "disabled";
        	echo '<div id="message-red2xz">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="green-left">
								Este presunto ya cuenta con fecha de alegatos
							</td>
							<td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" onClick=\' $$("#message-red2xz").slideUp() \'  alt="" /></a></td>
						</tr>
					</table>
				</div>';
		}
		elseif($noCompareceNunca)
		{
			$disabledAlegatos = "disabled"; 
        	echo '<div id="message-yellow2x">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="yellow-left">
								Este presunto ya no comparecera
							</td>
							<td class="yellow-right"><a class="close-yellow"><img src="images/table/icon_close_yellow.gif" onClick=\' $$("#message-yellow2x").slideUp() \'  alt="" /></a></td>
						</tr>
					</table>
				</div>';
		}
		//-------------------------------------------------------------------------------------------
		if($audienciaNoRevisada == 1) 
		{ 
			$disabledAlegatos = "disabled"; 
			echo '<div id="message-red2">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="red-left">
						   Aun hay audiencias pendientes... <a href="#" onclick="muestraPestana(3,550)">Click aqui para revisarlas</a>
						</td>
						<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=\' $$("#message-red2").slideUp() \'  alt="" /></a></td>
					</tr>
				</table>
			</div>';
        } 
		if($audiencias == 0) { 
			$disabledAlegatos = "disabled"; 
			echo '<div id="message-red2xxx">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="red-left">
						   No ha creado aun audiencias... <a href="#" onclick="muestraPestana(3,550)">Click aqui para crearla</a>
						</td>
						<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=\' $$("#message-red2xxx").slideUp() \'  alt="" /></a></td>
					</tr>
				</table>
			</div>';
        } 
		if((!$Pruebas || !$Admision || !$Desahogo) && $noCompareceNunca != true) { 
			$disabledAlegatos = "disabled"; 
			echo '<div id="message-red2xxx">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="red-left">
						   No hay fecha de Pruebas, Admisión o Desahogo aun... <a href="#" onclick="muestraPestana(4,400)">Click aqui para introducirla</a>
						</td>
						<td class="red-right"><a class="close-red"><img src="images/table/icon_close_red.gif" onClick=\' $$("#message-red2xxx").slideUp() \'  alt="" /></a></td>
					</tr>
				</table>
			</div>';
        } 
		//-------------------------------------------------------------------------------------------
		//if(cambioEstado($accion,31)) $cambiaEdo = 1; 
		//else $cambiaEdo = 0;
		$cambiaEdo = 1; // cambia estado siempre
		//-------------------------------------------------------------------------------------------
		?>
        
        <center>
        <form name="formAlegatos">
        <table class='feDif' width='80%' align='center'>
         <tr><td class="etiquetaPo">Nombre: </td><td class="etiquetaPO" > <?php echo $r['nombre']; ?></td> </tr>
         <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $r['cargo']; ?></td></tr>
         <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $r['rfc']; ?></td> </tr>
        	<tr >
              <td class="etiquetaPo">Fecha de Alegatos:</td>
              <td><label for="monto"></label>
              <input name="fechaAlegatos"  type="text"  class="redonda5"  id="fechaAlegatos" value="<?php echo $FA ?>" readonly="readonly" <?php //echo $disabledAlegatos ?> ></td>
            </tr>
        </table>
         <tr><td colspan='2'> <br><br> <center> <input type='button' value='Guardar Fecha' class='submit_line' onclick='periodoAlegatos("<?php echo $cambiaEdo ?>","<?php echo $usuario ?>")' <?php //echo $disabledAlegatos ?> /> </center> </td> </tr>
        </form>
        </center>
		<br /><br />
     </div>
</div> <!-- #pfrrDiv  -->
</body>
</html>
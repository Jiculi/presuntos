<script>

function muestraError(paso,texto)
{
	ocultaAll();
	document.getElementById(paso).innerHTML = "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>"+texto+"</h3>  <img src='images/warning_yellow.png' />  </center></p>";
	$$('#'+paso).fadeIn();
}
function ocultaAll() 
{
	$$('.todosContPasos ').removeClass("pActivo");
	$$('.todosContPasos ').hide();
	$$('.todosPasos').removeClass("pasosActivo");
	$$('.todosNP').removeClass('noPasoActivo');
	$$('.todosNP').addClass('noPaso'); 
} 
function muestraPestana(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
}


$$( "#fecha_de_cargo_inicio" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: true,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });


$$( "#fecha_de_cargo_final" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });


</script>
<?php
error_reporting(E_ERROR);
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM po WHERE num_accion = '".$accion."' ",false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//-------------------------------------------------------------------------------


$onclickP1 = "onclick='muestraPestana(1)'";
$onclickP2 = "onclick='muestraPestana(2)'";	

$txtPaso1 = "pasosActivo";
//$txtPaso2 = "pasosActivo";

$numPaso1 = "noPasoActivo";
//$numPaso2 = "noPasoActivo";

$acceso1 = "pfAccesible";
$acceso2 = "pfAccesible";

echo "<script>	$$(function() {	$$('#p1').fadeIn();	});	</script>";
?>
<div id='resGuardar' style="line-height:normal"></div>
<input type="hidden" name="num_accion" value="<?php echo $accion ?>" id="num_accion" />
<input type="hidden" name="fecha_cambio" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input type="hidden" name="hora_cambio" id="hora_cambio" value="<?php echo date ("H:i:s ") ?>" />
<input type="hidden" name="usuarioActual" id="usuarioActual" value="<?php echo $_REQUEST['usuario'] ?>" />
<input type="hidden" name="dirPre" id="dirPre" value="<?php echo $_REQUEST['direccion'] ?>" />

<?php
if($r['detalle_de_estado_de_tramite'] < 6 ) $title = "Modificar Presunto" and $title2="Borrar presunto";
else $title = "Ver Presunto";

?>

<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> PRESUNTOS RESPONSABLES  </div>
       <?php if($r['detalle_de_estado_de_tramite'] < 300 ) { ?>
       		<div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> AGREGAR PRESUNTO RESPONSABLE</div>
       <?php } ?>
    </div>
    <div id='resPasos' class='divPresuntos redonda10'>

        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Presuntos Responsables  </h3>
            
            <?php
			$tabla =  '    
				<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					<tr>
						<th class="contratista"> 	<a href="#">Tipo</a>	</th>
						<th class="contratista"> 	<a href="#">Nombre</a>	</th>
						<th class="cargo"> 			<a href="#">Cargo durante el periodo de irregularidad</a></th>
						<th class="cargo">			<a href="#">Acción/Omisión</a></th>
						<th class="cargo">			<a href="#">Normatividad Infringida</a></th>
						<th class="cargo">			<a href="#">Monto</a></th>
						<th class="seguimiento">	<a href="#">Editar </a></th>
						
					</tr>
			';       
            $sql = $conexion->select("SELECT * FROM po_presuntos WHERE num_accion = '".$accion."' AND tipo_presunto <> 'responsableInforme' AND tipo_presunto <> 'titularICC' ",false);
			$total = mysql_num_rows($sql);
            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
				if($r['tipo_presunto'] == "presuntoResponsable") $TP = "Servidor Público";
				if($r['tipo_presunto'] == "proveedor") $TP = "Proveedor";
				if($r['tipo_presunto'] == "contratista") $TP = "Contratista";
				
                $tabla .= '
                        <tr '.$estilo.' >
							<td class="contratista">'.$TP.'</td>
                            <td class="contratista">'.$r['servidor_contratista'].'</td>
                            <td class="cargo">'.$r['cargo_servidor'].'</td>
							<td class="cargo">'.$r['irregularidad'].'</td>
							<td class="cargo">'.$r['normatividad_infringida'].'</td>
							<td class="cargo">'.number_format($r['monto'],2).'</td>
	                        <td class="ancho200"> 
							';
							
				$tabla .= '<a href="#" title="'.$title.'" class="icon-1 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(600,800,"'.$title.'",100,"cont/po_presunto_mod.php","idPresunto='.$r['creacion'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a> ';
				$tabla .= '<a href="#" title="'.$title2.'" class="icon-2 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(250,600,"'.$title2.'",100,"cont/po_presunto_borra.php","idPresunto='.$r['creacion'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
                $tabla .= '</td></tr>';
				
				
    }
			if($total == 0) $tabla .= "<tr><td colspan='10'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta Accion no cuenta aun con presuntos</h3></center></td></tr>";
			
			$tabla .= '</table><!--  end product-table................................... --> ';
			
			echo "<div>".$tabla."</div>";
			?>        
		</div>
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Agregar Presunto</h3>
            
            <center>
            <form   action="<?php echo $editFormAction; ?>" method="POST" name="presunto_NEW" id="form1" onsubmit="return(false)" onkeypress="if(event.keyCode == 13) guardaPresunto()">
            
              <table width="107%" weight="100%" align="center" class="tablaPasos">
               <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td width="600" >
                  <select  class="redonda5" id="new_tipoPresunto"  name="new_tipoPresunto" >
                  	<option value="">Seleccione tipo de Presunto...</option>
                    <option value="presuntoResponsable">Servidor Público</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="contratista">Contratista</option>
                  </select>
                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td class="etiquetaPo">Nombre: </td>
                  <td ><input  type="text"  class="redonda5" id="new_servidor_contratista"  name="new_servidor_contratista" value="" size="100"></td>
                </tr>
                <tr>
                  <td width="155" class="etiquetaPo">Cargo durante el periodo de la irregularidad:</td>
                  <td><input  type="text"  class="redonda5" id="cargo" name="cargo" value="" size="100"></td>
                </tr>
                <tr>
                  <td class="etiquetaPo">Fecha del Cargo:</td>
                  <td> Del <input class="redonda5" id="fecha_de_cargo_inicio" name="fecha_de_cargo_inicio" type="text" value='<?php echo fechaNormal($r['fecha_de_cargo_inicio']) ?>' readonly> Al <input class="redonda5" id="fecha_de_cargo_final" name="fecha_de_cargo_final" type="text" value='<?php echo fechaNormal($r['fecha_de_cargo_final']) ?>' readonly></td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Acción/Omisión:</td>
                  <td>
                  <textarea class="redonda5" id="new_irregularidad" name="new_irregularidad" cols="97" rows="4" ><?php echo $r['irregularidad']; ?></textarea>
                  <br />
                  <!--Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td>-->
                </tr>
                <tr >
                  <td class="etiquetaPo">Normatividad Infringida:</td>
                  <td>
                  <textarea class="redonda5" id="normatividad" name="normatividad" cols="97" rows="4" ><?php echo $r['normatividad_infringida']; ?>  </textarea>
                  <br />
                  <!--Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td>-->
                </tr>
                  <tr>
                  <td class="etiquetaPo">Fecha de la irregularidad:</td>
                  <td><textarea class="redonda5" id="fecha_irre" name="fecha_irre" value="" cols="97" rows="4"> </textarea></td>
                </tr>

                <tr >
               <?php $sqlm = $conexion->select("SELECT * FROM po WHERE num_accion ='".$accion."' ",false);

$rm= mysql_fetch_array($sqlm); ?>

                  <td class="etiquetaPo">Monto:</td>
                  <td><input  type="text"  class="redonda5" id="monton" name="monton" value="<?php echo number_format($rm['monto_de_po_en_pesos'],2); ?>" size="20"></td>
                </tr>
                <tr >
                  <td height="64" colspan="3" class="center">
                  <center>
                    <input   type="button" onclick="guardaPresunto()"  class="submit-login"  value="Actualizar Presunto" name="Actualizar registro" id="Actualizar registro" />
                    <br />
                    <input name="creacion" type="hidden" id="new_creacion" value="">
                  </center>
                  </td>
                  
                </tr>
              </table>
            </form>
            </center>
        
        </div>

        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        

    </div>
</div>
<!--  end content-table  -->

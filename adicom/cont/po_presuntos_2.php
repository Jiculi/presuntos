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
</script>
<?php
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
if($r['detalle_de_estado_de_tramite'] < 6 ) $title = "Modificar Presunto";
else $title = "Ver Presunto";

?>

<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> PRESUNTOS RESPONSABLES </div>
       <?php if($r['detalle_de_estado_de_tramite'] < 6 ) { ?>
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
				<table border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
				<thead>
					<tr>
						<th class="contratista"><a href="#">Tipo</a>	</th>
						<th class="contratista"><a href="#">Nombre</a>	</th>
						<th class="cargo"><a href="#">Cargo</a></th>
						<th class="cargo"><a href="#">Dependencia</a></th>
						<th class="cargo"><a href="#">Acción/Omisión</a></th>
						<th class="ancho100"><a href="#"> Editar </a></th>
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
				if($r['tipo_presunto'] == "presuntoResponsable") $TP = "Servidor Publico";
				if($r['tipo_presunto'] == "proveedor") $TP = "Proveedor";
				if($r['tipo_presunto'] == "contratista") $TP = "Contratista";
				
                $tabla .= '
                        <tr '.$estilo.' >
							<td class="contratista">'.$TP.'</td>
                            <td class="contratista">'.$r['servidor_contratista'].'</td>
                            <td class="cargo">'.$r['cargo_servidor'].'</td>
                            <td class="cargo">'.$r['dependencia'].'</td>
							<td class="cargo">'.stripslashes($r['irregularidad']).'</td>
                            <td class="seguimiento">
							';
				$tabla .= '<a href="#" title="'.$title.'" class="icon-1 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(450,600,"'.$title.'",100,"cont/po_presunto_mod_2.php","idPresunto='.$r['creacion'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '<a href="#" title="'.$title2.'" class="icon-2 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(250,600,"'.$title2.'",100,"cont/po_presunto_borra.php","idPresunto='.$r['creacion'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '</td></tr>';
            }
			if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta Accion no cuenta aun con presuntos</h3></center></td></tr>";
			$tabla .= '</tbody>	</table>
					<!--  end product-table................................... --> ';
			echo $tabla;
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
            <form action="<?php echo $editFormAction; ?>" method="POST" name="presunto_NEW" id="form1">
              <table width="90%" align="center" class="tablaPasos">
               <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td >
                  <select  class="redonda5" id="new_tipoPresunto"  name="new_tipoPresunto" >
                  	<option value="">Seleccione tipo de Presunto...</option>
                    <option value="presuntoResponsable">Servidor Publico</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="contratista">Contratista</option>
                  </select>
                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td class="etiquetaPo">Nombre: </td>
                  <td ><input  type="text"  class="redonda5" id="new_servidor_contratista"  name="new_servidor_contratista" value="" size="70"></td>
                </tr>
                <tr>
                  <td class="etiquetaPo">Cargo:</td>
                  <td><input  type="text"  class="redonda5" id="new_cargo_servidor" name="new_cargo_servidor" value="" size="70"></td>
                </tr>
                <tr>
                  <td class="etiquetaPo">Dependencia:</td>
                  <td><input  type="text"  class="redonda5" id="new_dependencia_servidor" name="new_dependencia_servidor" value="" size="70"></td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Acción/Omisión:</td>
                  <td>
                  <textarea class="redonda5" id="new_irregularidad" name="new_irregularidad" cols="55" rows="5" onKeyDown="contador(this.form.new_irregularidad, 'new_cuenta', 450)" onKeyUp="contador(this.form.new_irregularidad, 'new_cuenta', 450)"><?php echo $r['irregularidad']; ?></textarea>
                  <br />
                  Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Monto:</td>
                  <td><label for="monto"></label>
                  <input name="new_monto"  type="text"  class="redonda5"  id="new_monto" value="<?php echo dameTotalPO($accion) ?>"></td>
                </tr>
                <tr >
                  <td class="center" colspan="3">
                  <center><br /><br />
                  <input name="creacion" type="hidden" id="new_creacion" value="">
                  <input type="button" onclick="guardaPresunto()"  class="submit-login"  value="Actualizar Presunto" name="Actualizar registro" id="Actualizar registro">
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

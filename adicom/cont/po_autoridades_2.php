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
$entidadFis = $r['entidad_fiscalizada'];
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
if($r['detalle_de_estado_de_tramite'] < 6 ) $title = "Modificar Autoridad";
else $title = "Ver Autoridad";
//----------------------- BUSCAMOS AUTORIDADES DE LA ACCION ----------------------
$sql3 = $conexion->select("SELECT * FROM po_presuntos WHERE num_accion = '".$accion."' AND tipo_presunto = 'titularICC' ",false);
$p = mysql_fetch_array($sql3);
$tICC = $total = mysql_num_rows($sql3);
//------------------------------------------------------------------------------
$sql3 = $conexion->select("SELECT * FROM po_presuntos WHERE num_accion = '".$accion."' AND tipo_presunto = 'responsableInforme' ",false);
$p = mysql_fetch_array($sql3);
$tEF = $total = mysql_num_rows($sql3);
//------------------------------------------------------------------------------
?>

<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> AUTORIDAD  </div>
       <?php if($tEF == 0 || $tICC == 0) { ?>
       		<div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> AGREGAR AUTORIDAD</div>
       <?php } ?>
    </div>
    <div id='resPasos' class='divPresuntos redonda10'>

        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Autoridad  </h3>
            
            <?php
			$tabla =  '    
				<table border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
				<thead>
					<tr>
						<th class="contratista"><a href="#">Tipo</a>	</th>
						<th class="contratista"><a href="#">Nombre</a>	</th>
						<th class="cargo"><a href="#">Cargo</a></th>
						<th class="cargo"><a href="#">Dependencia</a></th>
						<th class="seguimiento"><a href="#"> Editar </a></th>
					</tr>
			';       
            $sql = $conexion->select("SELECT * FROM po_presuntos WHERE num_accion = '".$accion."' AND (tipo_presunto = 'responsableInforme' OR  tipo_presunto = 'titularICC') ",false);
			$total = mysql_num_rows($sql);
            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
				if($r['tipo_presunto'] == "responsableInforme") $TP = "Titular de la Entidad Fiscalizada";
				if($r['tipo_presunto'] == "titularICC") $TP = "Titular de Instancia de Control Competente";
				if($r['tipo_presunto'] == "presuntoResponsable") $TP = "Presunto Responsable";
				if($r['tipo_presunto'] == "proveedor") $TP = "Proveedor";
				if($r['tipo_presunto'] == "contratista") $TP = "Contratista";
				
                $tabla .= '
                        <tr '.$estilo.' >
							<td class="contratista">'.$TP.'</td>
                            <td class="contratista">'.$r['servidor_contratista'].'</td>
                            <td class="cargo">'.$r['cargo_servidor'].'</td>
							<td class="cargo">'.stripslashes($r['dependencia']).'</td>
                            <td class="seguimiento">
							';
				$tabla .= '<a href="#" title="'.$title.'" class="icon-1 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(450,600,"'.$title.'",100,"cont/po_autoridad_mod_2.php","idPresunto='.$r['creacion'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
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
            <h3 class="poTitulosPasos">Agregar Autoridad</h3>
            
            <center>
            <form action="<?php echo $editFormAction; ?>" method="POST" name="presunto_NEW" id="form1">
              <table width="90%" align="center" class="tablaPasos">
               <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td >
                  <select  class="redonda5" id="new_tipoAutoridad"  name="new_tipoAutoridad" >
                  	<option value="">Seleccione tipo de Autoridad...</option>
                    <?php if($tEF == 0) {?> <option value="responsableInforme">Titular de la Entidad Fiscalizada</option> <?php } ?>
                    <?php if($tICC == 0) {?> <option value="titularICC">Titular Instancia de Control Competente</option> <?php } ?>
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
                <tr >
                  <td class="etiquetaPo">Dependencia:</td>
                  <td><input  type="text"  class="redonda5" id="new_dependencia" name="new_dependencia" value="<?php echo $entidadFis ?>" size="70"></td>
                  </td>
                </tr>
                <tr >
                  <td class="center" colspan="3">
                  <center><br /><br />
                  <input name="creacion" type="hidden" id="new_creacion" value="">
                  <input type="button" onclick="guardaAutoridad_2()"  class="submit-login"  value="Agregar" name="Actualizar registro" id="Actualizar registro">
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

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
	$$('.todosPasos').removeClass("pfAccesible");
	
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
$$( document ).ready(function(){

	$$( "#new_fechaAO1" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: 0,
	  //beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#new_fechaAO2" ).datepicker( "option", "minDate", selectedDate );
      }
    });
	
	$$( "#new_fechaAO2" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: 0,
	 // beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#new_fechaAO1" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

	$$( "#new_fechaPAO" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: 0,
	 // beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#new_fechaAO1" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

});
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
$sql = $conexion->select("SELECT * FROM pfrr WHERE num_accion = '".$accion."' ",false);
$pfrr = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
//-------------------------------------------------------------------------------


$onclickP1 = "onclick='muestraPestana(1)'";
$txtPaso1 = "pasosActivo";
$numPaso1 = "noPasoActivo";
$acceso1 = "pfAccesible";
echo "<script>	$$(function() {	$$('#p1').fadeIn();	});	</script>";

$onclickP2 = "onclick='muestraPestana(2)'";	
//$txtPaso2 = "pasosActivo";
//$numPaso2 = "noPasoActivo";
//$acceso2 = "pfAccesible";
//echo "<script>	$$(function() {	$$('#p2').fadeIn();	});	</script>";
?>
<link href="css/estilos_pfrr.css" rel="stylesheet" type="text/css" />

<div id='resGuardar' style="line-height:normal"></div>
<input type="hidden" name="num_accion" id="num_accion" value="<?php echo $accion ?>" />
<input type="hidden" name="estadoPFRR" id="estadoPFRR" value="<?php echo dameEstado($pfrr['detalle_edo_tramite']) ?>" id="num_accion" />
<input type="hidden" name="entidadPRFF" id="entidadPRFF" value="<?php echo $pfrr['entidad'] ?>" id="num_accion" />
<input type="hidden" name="fecha_cambio" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input type="hidden" name="hora_cambio" id="hora_cambio" value="<?php echo date ("H:i:s ") ?>" />
<input type="hidden" name="usuarioActual" id="usuarioActual" value="<?php echo $_REQUEST['usuario'] ?>" />
<input type="hidden" name="dirPre" id="dirPre" value="<?php echo $_REQUEST['direccion'] ?>" />

<?php
//-------------------------------------------------------------------------------------------
//echo "Orden edo 15 ". dameEdoNumOrden(15)."<br>";
//echo "Orden edo accion ". dameEdoNumOrden($pfrr['detalle_edo_tramite']);
//-------------------------------------------------------------------------------------------
if($r['detalle_edo_tramite'] <= 19 ) $title2="Borrar presunto";
else $title = "Ver Presunto";
?>

<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> RESPONSABLES</div>
       	<?php
		//if(dameEdoNumOrden(15) >= dameEdoNumOrden($pfrr['detalle_edo_tramite']) )
		{
		?>
       		<div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> AGREGAR RESPONSABLE</div>
       <?php } ?>
    </div>
    <div id='resPasos' class='divPresuntos redonda10'>

        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Responsables  </h3>
            
            <?php
			$encHTML =  '    
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					<tr >
						<th class="ancho150" valign="middle"> 	<a href="#">Nombre</a>	</th>
						<th class="ancho150" valign="middle"> 			<a href="#">Cargo</a></th>
						<th class="ancho350" valign="middle">	<a href="#">Acción/Omisión</a></th>
						<th class="ancho100" valign="middle">	<a href="#"> Prescripción </a></th>
						<th class="ancho100" valign="middle">			<a href="#">Total FRR </a></th>
   						<th class="ancho150" valign="middle">	<a href="#"> Seguimiento </a></th>
					</tr>
			';   
			
			$encExcel =  '    
				<table width="100%" cellpadding="1" cellspacing="1" style="font-family:arial; font-size:10px;" >
					<tr height="50">
						<th style="padding:5px;font-size:12px; border:1px solid white; " colspan=5>Presuntos Responsables de la Acción '.$accion.'</th>
					</tr>
					<tr height="50">
						<th width = "200" style="background:silver; border:1px solid black; padding:5px; "> 	Nombre			</th>
						<th width = "200" style="background:silver; border:1px solid black; padding:5px; ">   Responsable		</th>
						<th width = "200" style="background:silver; border:1px solid black; padding:5px"> 	Cargo			</th>
						<th width = "400" style="background:silver; border:1px solid black; padding:5px">	Acción/Omisión	</th>
						<th width = "100" style="background:silver; border:1px solid black; padding:5px">	Prescripción	</th>
						<th width = "100" style="background:silver; border:1px solid black; padding:5px">	Total FRR		</th>
					</tr>
			';       
    
            $sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."'  AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND tipo <> 'titularTESOFE' AND status='1') ",false);
            $total = mysql_num_rows($sql);
            
            $procedimiento = valorSeguro($_REQUEST['procedimiento']);
            $sql = $conexion->select("SELECT * FROM j_autores WHERE num_procedimiento = '".$procedimiento."' ", false);

            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
				
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
				// FLL no se      if($r['status'] == 0) $estilo="class='desa'" ; 

				
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
                $tablaExcel .= '
                        <tr '.$estilo.' style="vertical-align:middle">
                            <td style="border:1px dotted black;">'.$r['Actor'].'</td>
							<td style="border:1px dotted black;text-align:center">'.$r['con_responsabilidad_origen'].'</td>
                            <td style="border:1px dotted black;">'.$r['cargo_sp'].'</td>
							<td style="border:1px dotted black; text-align:justify">'. stripslashes($r['resolucion_sp']).'</td>
							<td style="border:1px dotted black;text-align:center">'.fechaNormal($r['f_resolucion']).'</td>
 							<td style="border:1px dotted black;text-align:right">'.@number_format( str_replace(",","",$r['monto'] ),2)./*.@number_format( str_replace(",","",$r['importe_frr'] ),2) .*/'</td>
                        </tr>';
								
                $tabla .= '
                        <tr '.$estilo.' >
                            <td class="" >'.$r['Actor'].' <br /> RESPONSABLE: '.$r['con_responsabilidad_origen'].'</td>
                            <td class="" >'.$r['cargo_sp'].'</td>
							<td class="" >'. stripslashes($r['resolucion_sp']).'</td>
							<td class="" >'.fechaNormal($r['f_resolucion']).'</td>
 							<td class="" >'.@number_format( str_replace(",","",$r['monto'] ),2)/*<td class="" >'.@number_format( str_replace(",","",$r['importe_frr'] ),2).'</td>*/.'</td> 
                          <td class="">';
				if($r['status']==1)
				{				
				$tabla .= '<a href="#" title="Proceso de Presuntos" class="icon-8 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(530,1100,"'.$r['Actor'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_proceso.php","idPresuntop='.$r['id'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '<a href="#" title="Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(520,800,"'.$r['Actor'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",50,"cont/pfrr_presuntos_datos.php","idPresuntop='.$r['id'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '<a href="#" title="Montos" class="icon-11 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(600,800,"'.$r['Actor'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($pfrr['detalle_edo_tramite']).'",10,"cont/pfrr_presuntos_montos.php","idPresuntop='.$r['id'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
				$tabla .= '<a href="#" title="'.$title2.'" class="icon-2 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro2(250,600,"'.$title2.'",10,"cont/pfrr_presunto_borra.php","idPresuntop='.$r['id'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a>';
                $tabla .= '</td></tr>';
				//accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+estado
                $tabla .= '</td></tr>';
				}
				
            }
            
			if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta Accion no cuenta aun con presuntos</h3></center></td></tr>";
			
			$tabla .= '</table><!--  end product-table................................... --> ';
			
			echo "<div>".$encHTML.$tabla."</div>";
			$excel = $encExcel.$tablaExcel;
			?>        
            
            <form action="excel.php" method = "POST" >
                    <input type="hidden" name="export" value= <?php echo urlencode($excel) ?> />
                    <input type="hidden" name="nombre_archivo" value="presuntos_accion_<?php echo $accion ?>"/>
                    <input type = "submit" class="submit_line" value = "Descargar en Excel" class="links">
			</form>
            
            
		</div>
        
        <div style="position:relative; top: 50px">
            <?php
				  
			$tabla="";
				  
            $sql2 = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."'  AND (tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND tipo <> 'titularTESOFE' AND status ='0') ",false);
            
			$total2 = mysql_num_rows($sql2);
            while($r2 = mysql_fetch_array($sql2))
            {
                $i2++;
                $res2 = $i2%2;
				
                if($res2 == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
				if($r2['status'] == 0) $estilo="class='desa'" ; 

				  
			    $encHTML =  '  
			
			    <h3 class="poTitulosPasos">PR Eliminados  </h3>
  
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
			    ';   
			
    

				
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
								
                $tabla .= '
                        <tr '.$estilo.' >
                            <td class="ancho150" valign="middle"" >'.$r2['nombre'].'</td>
                            <td class="ancho150" valign="middle"" >'.$r2['cargo'].'</td>
							<td class="ancho350" valign="middle"" >'. stripslashes($r2['accion_omision']).'</td>
							<td class="ancho100" valign="middle"" >'.$r['prescripcion_accion_omision'].'</td>
 							<td class="ancho100" valign="middle"" >'.@number_format( str_replace(",","",$r2['importe_frr'] ),2) .'</td>
 							<td class="ancho150" valign="middle"" ></td>
                          </tr>';
				
            }
			
			$tabla .= '</table><!--  end product-table................................... --> ';
			
			echo "<div>".$encHTML.$tabla."</div>";
			$excel = $encExcel.$tablaExcel;
			
			?>        

</div>

        
        
        
        
        
        
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
		<?php
		if(dameEdoNumOrden(19) >= dameEdoNumOrden($pfrr['detalle_edo_tramite']) || dameEdoNumOrden(30) == dameEdoNumOrden($pfrr['detalle_edo_tramite']) || $_REQUEST['direccion'] == "DG")
		{
		//-------------------------------------------------------------------------------------------
		?>
        
        
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Agregar Presunto</h3>

            <center>
            <form action="#" method="POST" name="presunto_NEW" id="presunto_NEW">
            
              <table width="90%" align="center" class="tablaPasos">
               <tr valign="baseline">
                  <td class="etiquetaPo">Tipo: </td>
                  <td >
                  <select  class="redonda5" id="new_tipoPresunto"  name="new_tipoPresunto" >
                  	<option value="">Seleccione tipo de Presunto...</option>
                    <option value="presuntoResponsable">Servidor Público</option>
                    <option value="proveedor">Proveedor</option>
                    <option value="contratista">Contratista</option>
					<option value="Beneficiario">Beneficiario</option>
                  </select>
                  
                  </td>
                </tr>
                <tr valign="baseline">
                  <td class="etiquetaPo">Nombre: </td>
                  <td ><input  type="text"  class="redonda5" id="new_nombre"  name="new_nombre" value="" size="70"></td>
                </tr>
                <tr>
                  <td class="etiquetaPo">Dependencia:</td>
                  <td><input  type="text"  class="redonda5" id="new_dependencia" name="new_dependencia" value="" size="70"></td>
                </tr>
                <tr>
                  <td class="etiquetaPo">Cargo:</td>
                  <td><input  type="text"  class="redonda5" id="new_cargo" name="new_cargo" value="" size="70"></td>
                </tr>
                <tr valign="baseline">
                  <td class="etiquetaPo">RFC: </td>
                  <td ><input  type="text"  class="redonda5" id="new_rfc"  name="new_rfc" value="" size="70"></td>
                </tr>
                <tr valign="baseline">
                  <td class="etiquetaPo">Domicilio: </td>
                  <td >
                  <textarea class="redonda5" id="new_domicilio" name="new_domicilio" cols="72" rows="2" ><?php echo $r['domicilio']; ?></textarea>
                  </td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Acción/Omisión:</td>
                  <td>
                  <textarea class="redonda5" id="new_irregularidad" name="new_irregularidad" cols="72" rows="2" onKeyDown="contador(this.form.new_irregularidad, 'new_cuenta', 650)" onKeyUp="contador(this.form.new_irregularidad, 'new_cuenta', 650)"><?php echo $r['irregularidad']; ?></textarea>
                  Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Fecha Accion/Omisión:</td>
                  <td>
                  	<input  type="text"  class="redonda5" id="new_fechaAO1"  name="new_fechaAO1" value="" size="15"> al 
                    <input  type="text"  class="redonda5" id="new_fechaAO2"  name="new_fechaAO2" value="" size="15">
                  </td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Prescripción de la Acción/Omisión::</td>
                  <td>
                  	<input  type="text"  class="redonda5" id="new_fechaPAO"  name="new_fechaPAO" value="" size="15">
                  </td>
                </tr>
                <tr >
                  <td class="center" colspan="3">
                  <center><br />
                  <input type="button" onclick="guardaPresuntoPFRR()"  class="submit-login"  value="Guardar Presunto" name="Guardar registro" id="Actualizar registro">
                  <input type="hidden" name="accion" id="accion" value="<?php echo $accion ?>" />
                  
                  </center>
                  </td>
                  
                </tr>
              </table>
            </form>
            </center>
        
        </div>
        
        
        
        <?php }//fin if estado 15?>
        
        
        
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        

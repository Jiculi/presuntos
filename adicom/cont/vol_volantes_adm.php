<link rel="stylesheet" href="css/estilos_volantes.css" type="text/css" media="screen" title="default" />

<script> 
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------
function generarVolante()
{
	($$("#volanteForm").serialize())
	
	if(comprobarForm('volanteForm')){
		$$.ajax
		({
			beforeSend: function(objeto)
			{
				$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				$$('#generaVolante').attr("disabled",true);
				$$('#generaVolante').val('Generando Oficio espere...');
				$$('#generaVolante').css( "background", "gray" );
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar")
				//if(exito=="success"){ alert("Y con éxito"); }
			},
			type: "POST",
			url: "procesosAjax/vol_genera_volante.php",
			//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
			data: $$("#volanteForm").serialize(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos)
				//generamos ultimo ID
				var ultimoId = datos;
				new mostrarCuadro(450,800,"Volante de Correspondencia",70,"cont/vol_volante.html.php","folio="+datos)
				$$(".redonda5").val(""); // campos en blanco
				$$("#volTxt").html(""); // turnado en blanco c
				// deshab ilitamos campos 
				$$("#cral").attr("disabled",true);
				$$("#fechaCral").attr("disabled",true);
				$$("#acuseCral").attr("disabled",true);
				$$("#accionvolante").attr("disabled",false);
				/// ponemos en blanco datos de la accion 
				$$("#turnado").val("");
				$$("#direccion").val("");
				$$("#estado").val("");
				$$("#estadoPFRR").val("");
				$$("#prescripcion").val("");
				$$("#presuntos").val("");
				$$("#montototal").val("");
				//---------------------------------------------------------
				$$('#generaVolante').attr("disabled",false);
				$$('#generaVolante').val('Generar Volante');
				$$('#generaVolante').css( "background", "#333" );
				$$('.campoInputVol').val('');//inputs de acciones del listado
				$$('.filasVol').remove();//inputs de acciones del listado
				$$('#volTxt').html("");
				$$('#accionesNo').html("");
			}
		});
		
	}else{ alert("Ingrese una acción ") }
	
}
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function(){
	// configuramos el control para realizar la busqueda de los productos
	$$("#accionRemitente").autocomplete({
	 //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						type: "POST",
						url: "procesosAjax/po_busqueda_remitente.php",
						dataType: "json",
						data: {
							term: request.term
						},
						success: function( data ) {
							response(data);
		 //muestraListados();
						}
					});
			},
		  minLength: 2,
	  select: 
	  function( event, ui ) 
	  {  
		//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
		
		$$("#accionCargo").val(ui.item.cargo);
		$$("#accionDependencia").val(ui.item.dependencia);
		$$("#oficio").focus();
		
	 }
		});//end
}); 
//----------------------- FECHA DE VOLANTES ------------------------------
//---------------------------------------------------------------------	
$$(function() {
	$$( "#accionOfiFec" ).datepicker({
	// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 beforeShowDay: noLaborales,
		 //---------------------------
		 minDate: "01/02/2015",
	  	// maxDate: "29/02/2015",
		 //-----------------------------
		 onClose: function( selectedDate ) 
		 { 
			$$( "#accionOfiFecAcu" ).datepicker( "option", "minDate", selectedDate );  
		 }
	});
	
	$$( "#accionOfiFecAcu" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 beforeShowDay: noLaborales,
		 //---------------------------
		 minDate: "01/02/2015",
	  	 //maxDate: "29/02/2015",
		 //-----------------------------
		 onClose: function( selectedDate ) 
		 { 
			$$( "#accionOfiFec" ).datepicker( "option", "maxDate", selectedDate );  
		 }
	});	
}); 
</script>

<style>
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
.volLista
{

}
.grupoPO{ background:#BFDFFF}
.grupoPFRR{ background:#AFA !important}
.grupoMEDIOS{ background:#F88}
.grupoADM{ background:#FF6CFF}
.grupoOTROS{ background:#CCC}
.PO{ background:#BFDFFF}
.PFRR{ background:#AFA !important}
.MEDIOS{ background:#F88}
.ADM{ background:#FF6CFF}
.OTROS{ background:#CCC}
.grupo{ }
.opciones{ display:none}
.numAccion{ font-weight:bold !important; font-size:14px !important }
</style>


<div id="pagVolantes" style="padding:10px 20px;background: #FFB0B0 " class="redonda10">
    <!--

	<div class="encVol">
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR VOLANTE </div>
    <?php } ?>
       
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR VOLANTES </div>
    </div>
    -->
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
    <div id='p1' class=" redonda10 todosContPasos" >
        
        <form name="volanteForm" id="volanteForm" method="post" action="#">
        <table width="100%" align="center">
        <tr>
            <td width="33%" valign="top">
                <div class="volanteDivCont redonda5"  style="height:200px; width:350px; background: #FFB0B0 ">
                 <table align="center" width="100%" border="0" class="tablaPasos tablaVol"> 
                   <!-- ----------------- -->

                   <!-- ----------------- -->
                    </td>
                  </tr>
                  <tr>
                    <td  width="" class="etiquetaPo"><p>Referencia:</p></td>
                    <td>
                        <input type="hidden" name="accionVol" id="accionVol" />
                        <input type="hidden" name="acccionPo" id="acccionPo" />
                        
                          <select name="accionRef" id="accionRef" style="width:200px"  class="redonda5 inputVolantes  inputsSig " onchange="completaRemitentes($$('#accionVol').val(),'remitentesUAA',this.value)" >
                            <option value=""><b>Tipo de movimiento...</b></option>
                             <!--
                            <optgroup class="grupo grupoPO" label="Pliego de Observaciones... " class="PO">
                                <option class="opciones PO" value="2" class="PO"> - <?php echo dameEstado(2) ?></option>
                                <option class="opciones PO" value="5" class="PO"> - Recepción PO firmado </option>
                                <option class="opciones PO" value="9" class="PO"> - <?php echo dameEstado(9) ?></option>
                                <option class="opciones PO" value="27" class="PO"> - <?php echo dameEstado(27) ?></option>
                                <option class="opciones PO" value="10" class="PO"> - <?php echo dameEstado(10) ?> </option>
                                <option class="opciones PO" value="8" class="PO"> - <?php echo dameEstado(8) ?> </option>
                                <option class="grupoPO PO" value="otro" class="PO"> - Otros Oficios</option>
                             </optgroup>
                             <optgroup class="grupo grupoPFRR" label="Procedimiento Resarcitorio" class="PFRR">
                                <option class="opciones PFRR" value="11" class="PFRR"> - Recepción DTNS</option>
                                <option class="opciones PFRR" value="14" class="PFRR"> - Solventación PFRR</option>
                                <option class="opciones PFRR" value="28" class="PFRR"> - Respuesta Técnica de la UAA</option>
                                <option class="grupoPFRR PFRR" value="pfrr_otros" class="PFRR"> - Otros Oficios</option>
                             </optgroup>
                             
                             <optgroup class="grupo grupoMEDIOS" label="Medios de Defensa" class="MEDIOS">
                                <option class="opciones MEDIOS" value="medios_recursos_consideracion" class="MEDIOS"> - Recurso de Reconsideración</option>
                                <option class="opciones MEDIOS" value="medios_juicio_nulidad" class="MEDIOS"> - Juicio Nulidad</option>
                                <option class="opciones MEDIOS" value="medios_amparo" class="MEDIOS"> - Amparo</option>
                                <option class="grupoMEDIOS MEDIOS" value="medios_otros" class="MEDIOS"> - Otros Oficios</option>
                             </optgroup>
                             -->
                              <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") { ?>
                                 <optgroup class="grupo grupoADM" label="Administración" class="ADM">
                                    <option class="grupoADM ADM" value="administracion" class="ADM"> - Administración</option>
                                 </optgroup>
                              <?php } ?>
                              <!--
                             <optgroup class="grupo grupoOTROS" label="Otros Movimientos" class="OTROS">
                                <option class="grupoOTROS OTROS" value="x_otros" class="OTROS"> - Otros Movimientos</option>
                             </optgroup>
                             -->
                          </select>
                        <!-- <input type="checkbox" name="chkAdm" id="chkAdm" onclick=" $$('.inputsSig').attr('disabled',true) "/> Adm -->
                      </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo"> <p>Asunto:</p></td>
                    <td>
                      <textarea cols="30" rows="5" class="redonda5 inputVolantes  inputsSig" id='accionAsunto' name='accionAsunto'></textarea>
                    </td>
                  </tr>
                </table>
                </div>
            </td>
            <td  width="33%" >
            <div class="volanteDivCont redonda5"  style="height:200px; width:350px;  background:#FFB0B0">
            <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
              <tr>
                <td  class="etiquetaPo" width="70"><p>Remitente:</p></td>
                  
                <td >
                    <input type="text" name="accionRemitente" id="accionRemitente"  size="25"  class="redonda5 inputVolantes inputsSig " >
                    <!-- <input type="hidden" name="idRem" id="idRem"  size="40"  class="redonda5  inputVolantes" > -->
                </td>
              </tr>
              <tr>
                <td class="etiquetaPo">  <p>Cargo:</p></td>
                <td>
                  <input type="text" name="accionCargo" id="accionCargo"  size="25"  class="redonda5 inputVolantes inputsSig ">
                </td>
              </tr>
                <tr>
                <td class="etiquetaPo">  <p>Dependencia:</p></td>
                <td>
                  <input type="text" name="accionDependencia" id="accionDependencia"  size="25"  class="redonda5 inputVolantes inputsSig ">
                </td>
              </tr><tr>
                    <td class="etiquetaPo" width="70"><p>Turnado:</p></td>
                    <td>
                      <input type="text" name="turnado"  size="25"  id="turnado" class="redonda5 inputVolantes inputsSig ">
                      </td>
              </table> 
              </div>
                
                
            </td>
    
          <td valign='top' width="33%" >
               <div class="volanteDivCont redonda5" style="height:200px; width:350px; background:#FFB0B0">
                <table align="center" width="100%" border="0" class="tablaPasos tablaVol">                        
                <tr>
                    <td class="etiquetaPo" width="70"><p>Oficio:</p></td>
                    <td>
                      <input type="text" name="accionOficio"  size="25"  id="accionOficio" class="redonda5 inputVolantes inputsSig ">
                      </td>
                  </tr>
                    <tr>
                      <td class="etiquetaPo">Fecha Oficio:</td>
                      <td><input type="text" name="accionOfiFec" size="25" id="accionOfiFec" class="redonda5 inputVolantes inputsSig " /></td>
                    </tr>
                    <tr>
                    <td class="etiquetaPo">Fecha Acuse:</td>
                    <td><input type="text" name="accionOfiFecAcu" size="25" id="accionOfiFecAcu" class="redonda5 inputVolantes inputsSig " /></td>
                  </tr>

                 <!--- ---------------------------------------------------------------------------- --> 
                  
                 </table>
                </div>
            </td>
          <!--

            <td  width="33%" >
                <div class="volanteDivCont redonda5" id="tablaCral"  style="height:100px;background:#FFB0B0">
                <table align="center" width="100%" border="0" class="tablaPasos tablaVol" >                        
                    <tr>
                    <td class="etiquetaPo" width="70"><p>CRAL:</p></td>
                    <td>
                      <input type="text" name="cral"  size="25"  id="cral" class="redonda5  inputVolantes inputsSig " disabled="disabled">
                      </td>
                  </tr>
                    <tr>
                      <td class="etiquetaPo">Fecha CRAL:</td>
                      <td><input type="text" name="fechaCral" size="25" id="fechaCral" class="redonda5  inputVolantes inputsSig " disabled="disabled" /></td>
                    </tr>
                    <tr>
                    <td class="etiquetaPo">Acuse Cral:</td>
                    <td><input type="text" name="acuseCral" size="25" id="acuseCral" class="redonda5  inputVolantes inputsSig " disabled="disabled" /></td>
                  </tr>
                 </table>
                 <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                </div>
          </td>
            -->
          <!--
          <td>
                  <input type="button" class="submit-login redonda10" value="Insertar" id="insertaAccionBtn" onclick="insertaAccion()" style="width:60px;height:100px" />
                 </form>

          </td>
          -->
        </tr>
       <tr>
       <!--
        	<td colspan="5" valign="top">
            	<div class="volDivAcci redonda5" id="contAcciones" style="height:330px; overflow:auto; background:#FFB0B0">
                    <form name="todasAccionesVol" id="todasAccionesVol" enctype="application/x-www-form-urlencoded" method="post" >
                        <div>
                            <table  width="2000" id="product-table">
                            	<tr>
                                	<th class="trmedios ancho200">Accion</th>
                                	<th class="trmedios ancho150">Estado</th>
                                	<th class="trmedios ancho150">Turnado</th>
                                	<th class="trmedios ancho250">Asunto</th>
                                	<th class="trmedios ancho150">Remitente</th>
                                	<th class="trmedios ancho150">Cargo</th>
                                	<th class="trmedios ancho150">Dependencia</th>
                                	<th class="trmedios ancho100">Oficio</th>
                                	<th class="trmedios ancho100">Of. Fecha</th>
                                	<th class="trmedios ancho100">Of. Acuse</th>
                                	<th class="trmedios ancho100">CRAL</th>
                                	<th class="trmedios ancho100">C. Fecha</th>
                                	<th class="trmedios ancho100">C. Acuse</th>
                                	<th class="trmedios ancho100">DT</th>
                                	<th class="trmedios ancho100">Of. Conclución</th>
                                	<th class="trmedios ancho100">Of. Acuse</th>
                                </tr>
                            </table>
                        </div>
                        <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                        <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'] ?>" >
                        <input type="hidden" name="nivel" id="nivel" value="<?php echo $_SESSION['nivel'] ?>" >
                    </form>
                </div>
            </td>
        -->
	  </tr>
      <tr>
        <td colspan="5">
        	<div style="text-align:left; float:left; width:500px">Acciones Vinculadas: <span id="accionesNo">Ninguna</span></div>
        	<div style="text-align:center">
            
                <input type="hidden" name="tipoPOST" id="tipoPOST" value="sencillo">
                <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['usuario'] ?>" >
                <input type="hidden" name="nivel" id="nivel" value="<?php echo $_SESSION['nivel'] ?>" >
            	<input type="button" class="submit-login" value="Generar Volante" id="generaVolante" onclick="generarVolante()" />
            </div>
        </td>
      </tr>

	</table>
      </div><!-- end cont vol1 volantes -->
      <?php } ?>
</div><!-- end cont volantes -->

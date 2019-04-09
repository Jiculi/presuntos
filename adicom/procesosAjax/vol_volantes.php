<link rel="stylesheet" href="css/estilos_volantes.css" type="text/css" media="screen" title="default" />

<script> 
function muestraPestanaVol(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	if(divId == 2)
	{
		$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista").load("procesosAjax/vol_busca_volantes.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>"});
	} 
}

function muestraCral(valor)
{
	 if(valor == 2 || valor == 10 || valor == 11 || valor == 14 || valor == 21)
	 { 
	 	//$$("#tablaCral").fadeIn();
		$$('#cral').attr('disabled', false);
		$$('#fechaCral').attr('disabled', false);
		$$('#acuseCral').attr('disabled', false);
	 }
	 else 
	 {
		//$$("#tablaCral").fadeOut();
		$$('#cral').attr('disabled', true);
		$$('#fechaCral').attr('disabled', true);
		$$('#acuseCral').attr('disabled', true);
	 }
	 if(valor == 10)
	 { 
	 	//$$("#tablaCral").fadeIn();
		$$('#trDT').fadeIn();
		$$('#volanteDT').attr('disabled', false);
	 }
	 else
	 {
		$$('#trDT').fadeOut();
		$$('#volanteDT').attr('disabled', true);
	}
	
	 if(valor == "administracion")
	 { 
	 	//$$("#tablaCral").fadeIn();
		$$('#accionvolante').attr('disabled', true);
	 }
	
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarVolante()
{
	
	if(comprobarForm('volanteForm'))
	{
		//-------------- validar de estados ---------------------
		//-------------------------------------------------------
		var errorEdos = 0;
		var menEdo = "";
		var edo = $$('#estado').val();
		var edoPFRR = $$('#estadoPFRR').val();
		var mov = $$('#movimiento').val();
		
		if(mov != "medios_recursos_consideracion" && mov != "medios_juicio_nulidad" && mov != "medios_amparo" && mov != "medios_otros" && mov != 11 && mov != 14 && mov != 21 && mov != "pfrr_otros" && mov != "x_otros" && mov != "administracion")
		{
				//------------------- ESTADOS PO -----------------------
				//---------- baja, solventacion y dtns -----------------
				if((edo == 8 || edo ==9 || edo == 27) && (mov != 'otro'))
				{
					errorEdos++;
					if(edo == 8) var est = "en Baja por Conclusión Previa a su Emisión";
					if(edo == 9) var est = "Solventada";
					if(edo == 27) var est = "Concluída";
					//if(edo == 10) var est = "en DTNS";
					menEdo += "\n - Esta accion esta '"+est+"' no se puede modificar.";
				}
				//----- opinion para Emision / correccion del pleigo ---
				if(edo == 1 && (mov != 2 && mov != 'otro'))
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta en 'Pendiente UAA envíe a DGR PPO y ET' \n\n --- Solo puede recepcionarse.";
				}
		
				//----- opinion para Emision / correccion del pleigo ---
				if(edo == 2 && mov != 'otro' )
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta en 'Opinión para Emisión/Corrección del Pliego' \n\n --- No puede recepcionarse nuevamente.";
				}
				//----- 'Asistencia Jurídica' ------------------
				if((mov == 2 && mov == 5 && mov == 8) && (edo != 3 && edo != 4))
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta en 'Asistencia Jurídica' solo puede \n\n --- Recepcionarse \n --- Recibir PO firmado\n --- Darse de baja.";
				}
				//----- 'En proceso de Notificacion' ------------------
				if((edo == 5) && (mov != 2 && mov != 8 && mov != 'otro' ))
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta 'En proceso de Notificacion' solo puede \n\n --- Recepcionarse \n --- Darse de baja.";
				}
				//----- 'Notificada' ------------------
				if(edo == 6 && mov != 'otro')
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta 'Notificada' \n\n --- No puede recepcionarse nuevamente.";
				}
				//----- 'ET, PO y Oficios notificados Remitidos a la UAA' ------------------
				if((edo == 7) && (mov != 9 && mov != 27 && mov != 10 && mov != 'otro'))
				{
					errorEdos++;
					menEdo += "\n - Esta accion esta 'ET, PO y Oficios notificados Remitidos a la UAA' solo puede \n\n --- Solventarse \n --- Darse de baja.";
				}
				//----------------- validamos DTNS presuntos,monto y preescripcion ---------------------------------
				if(mov == 10)
				{
					var dt = $$('#volanteDT').val();
					var presuntos = $$('#presuntos').val();
					var montos = $$('#montototal').val();
					var prescripcion = $$('#prescripcion').val();
					
					if(presuntos == 0 || presuntos == "")
					{
						errorEdos++;
						menEdo += "\n -- Esta acción debe tener Presuntos.";
					}
					if( montos == 0 || montos == "")
					{
						errorEdos++;
						menEdo += "\n -- Esta acción debe tener monto PO.";
					}
					if(prescripcion == 0 || prescripcion == "" || prescripcion == "0000-00-00")
					{
						errorEdos++;
						menEdo += "\n -- Esta acción debe tener prescripción.";
					}
					if(edo != 7)
					{
						errorEdos++;
						menEdo += "\n\n - Para pasar a DTNS esta acción debe estar en estado \n\n -- 'ET, PO y oficios notificados remitidos a la UAA' ";
					}
				}
				else
				{
					var dt = "";
				}
		}
		//-------------------- ESTADOS PFRR --------------------------
		//-------------------- RECEPCION DTNS ------------------------
		if(mov == 11 && edoPFRR != 13)
		{
			errorEdos++;
			menEdo += "\n\n - Esta acción debe estar en \n\n -- 'Devolución del Expediente Técnico' ";
		}
		if(mov == 14 && edoPFRR != 13)
		{
			errorEdos++;
			menEdo += "\n\n - Esta acción debe estar en \n\n -- 'Devolución del Expediente Técnico' ";
		}
		if(mov == 21 && edoPFRR != 19)
		{
			errorEdos++;
			menEdo += "\n\n - Esta acción debe estar en \n\n -- 'En Opinión Técnica de la UAA' ";
		}
		
		//-------------------------------------------------------
		//-------------------------------------------------------
		if(errorEdos != 0) alert(menEdo);
		//-------------------------------------------------------
		if(errorEdos == 0)
		{
			//----------------------------------------------
			$$.ajax
			({
				beforeSend: function(objeto)
				{
					$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/vol_genera_volante.php",
				//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
				data: {
							remitente:$$('#remitente').val(),
							cargo:$$('#cargo').val(),
							oficio:$$('#oficio').val(),
							movimiento:$$('#movimiento').val(),
							accion:$$('#accionvolante').val(),
							asunto:$$('#asunto').val(),
							dependencia:$$('#dependencia').val(),
							fechaOficio:$$('#fechaOficio').val(),
							fechaAcuse:$$('#fechaAcuse').val(),
							turnado:$$('#turnado').val(),
							direccion:$$('#direccion').val(),
							cral:$$('#cral').val(),
							fechaCral:$$('#fechaCral').val(),
							acuseCral:$$('#acuseCral').val(),
							dt:dt,
							//---- se elige el user del index -------------
							usuario:$$('#indexUser').val()
						},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					alert(datos)
					//generamos ultimo ID
					var ultimoId = datos;
					new mostrarCuadro(450,800,"Volante de Correspondencia",70,"cont/vol_volante.html.php","id="+datos)
					$$(".redonda5").val(""); // campos en blanco
					$$("#volTxt").html(""); // turnado en blanco cral fechaCral acuseCral
					$$("#cral").attr("disabled",true);
					$$("#fechaCral").attr("disabled",true);
					$$("#acuseCral").attr("disabled",true);
					$$("#accionvolante").attr("disabled",false);
					
				}
			});
		}//end estados
	}//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
		{
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
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
			$$("#cargo").val(ui.item.cargo);
			$$("#dependencia").val(ui.item.dependencia);
			$$("#oficio").focus();
			
		  }
			});//end
		}); 
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
{
	 // configuramos el control para realizar la busqueda de los productos
	 $$("#accionvolante").autocomplete({
	  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto)
						{
							$$('#idLoad').html('<img src="images/load_chico.gif">');
						},
						type: "POST",
						url: "procesosAjax/vol_busqueda_volantesaccion.php",
						dataType: "json",
						data: {
							term: request.term
						},
						success: function( data ) {
							response(data);
							$$('#idLoad').html('');
		  //muestraListados();
						}
					});
			 },
		   minLength: 2,
	  select: function( event, ui ) {  
		//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
		//muestraContenidoOficios(ui.item.label);
		$$("#volTxt").html("Turnado: Dirección '"+ui.item.direccion+"'  "+ui.item.turnado);
		$$("#turnado").val(ui.item.turnado);
		$$("#direccion").val(ui.item.direccion);
		$$("#estado").val(ui.item.estado);
		$$("#estadoPFRR").val(ui.item.estadoPFRR);
		$$("#prescripcion").val(ui.item.prescripcion);
		$$("#presuntos").val(ui.item.presuntos);
		$$("#montototal").val(ui.item.montototal);
	  },
	  change: function (event, ui) {
		   if(!ui.item)  $$(event.target).val("");
    	},
	  focus: function (event, ui) {
        return false;
    }
	});//end
}); 

//----------------------- FECHA DE VOLANTES ------------------------------
//---------------------------------------------------------------------	
$$(function() {
	$$( "#fechaOficio" ).datepicker({
		 // dateFormat: formatoFecha,
		  //defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaAcuse" ).datepicker( "option", "minDate", selectedDate );  
		  }
	});
	
	$$( "#fechaAcuse" ).datepicker({
		 // dateFormat: formatoFecha,
		  //defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaOficio" ).datepicker( "option", "maxDate", selectedDate );  
		  }
	});
//---------------------------------------------------------------------	
//---------------------------------------------------------------------	
	$$( "#fechaCral" ).datepicker({
		 // dateFormat: formatoFecha,
		  //defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#acuseCral" ).datepicker( "option", "minDate", selectedDate );  
		  }
	});
	
	$$( "#acuseCral" ).datepicker({
		 // dateFormat: formatoFecha,
		  //defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaCral" ).datepicker( "option", "maxDate", selectedDate );  
		  }
	});
}); 
//---------------------------------- BUSCAR VOLANTES -----------------------------------	
//--------------------------------------------------------------------------------------
$$( document ).ready(function() {
	
	$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  	$$("#volLista").load("procesosAjax/vol_busca_volantes.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>"});
});
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$("#text").keyup(function() {
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 $$('#volLista').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/vol_busca_volantes.php",
				data: {
						texto:$$('#text').val(),
						direccion:"<?php echo $_SESSION['direccion'] ?>",
						usuario:"<?php echo $_SESSION['usuario'] ?>"
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					$$('#volLista').html(datos); 
				}
			});
	});
});
</script>
<!--
<script>
$$('#colorSelector').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$$('#colorSelector div').css('backgroundColor', '#' + hex);
	}
});
</script>
-->
<style>
.ui-autocomplete {
	max-height: 100px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
.volLista
{
	height:300px;
	overflow:auto;	
}
.PO{ background:#BFDFFF}
.PFRR{ background:#AFA}
.MEDIOS{ background:#F88}
.ADM{ background:#FF6CFF}
.OTROS{ background:#CCC}
</style>


<div id="pagVolantes">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR VOLANTE </div>
    <?php } ?>
       
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR VOLANTES </div>
       <!--  <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OPCIONES </div> -->
    </div>
    
    <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") {?>
    <div id='p1' class="contVolantes redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="volanteForm" method="post" action="#">
        
        <table width="90%" align="center">
        <tr>
        	<td width="50%">
            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="195"><p>Remitente:</p></td>
                      
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" >
                        <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargo" id="cargo" size="35" class="redonda5">
                    </td>
                  </tr>
                    <tr>
                    <td class="etiquetaPo">  <p>Dependencia:</p></td>
                    <td>
                      <input type="text" name="dependencia" id="dependencia" size="35" class="redonda5">
                    </td>
                  </tr>
                  </table> 
                  </div>
              </td>
              <td width="50%">
                   <div class="volDivCont redonda5">
                    <table align="center" width="100%" border="0" class="tablaPasos tablaVol">                        
                    <tr>
                        <td class="etiquetaPo" width="195"><p>Oficio:</p></td>
                        <td>
                          <input type="text" name="oficio" size="35" id="oficio" class="redonda5">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha Oficio:</td>
                          <td><input type="text" name="fechaOficio" size="25" id="fechaOficio" class="redonda5" /></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Fecha de acuse de recepcion:</td>
                        <td><input type="text" name="fechaAcuse" size="25" id="fechaAcuse" class="redonda5" /></td>
                      </tr>
                     </table>
              		</div>
              </td>
            </tr>
            <tr>
            	<td width="50%">
					<div class="volDivCont redonda5">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                      <tr>
                        <td  width="195" class="etiquetaPo"><p>Referencia:</p></td>
                        <td>
                              <select name="movimiento" id="movimiento"  class="redonda5" onchange="muestraCral(this.value)" >
                                <option value=""><b>Tipo de movimiento...</b></option>
                                <optgroup label="Pliego de Observaciones" class="PO">
                                    <option value="2" class="PO"> - <?php echo dameEstado(2) ?></option>
                                    <option value="5" class="PO"> - Recepción PO firmado</option>
                                    <option value="9" class="PO"> - <?php echo dameEstado(9) ?></option>
                                    <option value="27" class="PO"> - <?php echo dameEstado(27) ?></option>
                                     <option value="10" class="PO"> - <?php echo dameEstado(10) ?> </option>
                                    <option value="8" class="PO"> - <?php echo dameEstado(8) ?> </option>
                                    <option value="otro" class="PO"> - Otros Oficios</option>
                                 </optgroup>
                                 <optgroup label="Procedimiento Resarcitorio" class="PFRR">
                                    <option value="11" class="PFRR"> - Recepción DTNS</option>
                                    <option value="14" class="PFRR"> - Solventación PFRR</option>
                                    <option value="21" class="PFRR"> - Respuesta Técnica de la UAA</option>
                                    <option value="pfrr_otros" class="PFRR"> - Otros Oficios</option>
                                 </optgroup>
                                 <optgroup label="Medios de Defensa" class="MEDIOS">
                                    <option value="medios_recursos_consideracion" class="MEDIOS"> - Recurso de Reconsideración</option>
                                    <option value="medios_juicio_nulidad" class="MEDIOS"> - Juicio Nulidad</option>
                                    <option value="medios_amparo" class="MEDIOS"> - Amparo</option>
                                    <option value="medios_otros" class="MEDIOS"> - Otros Oficios</option>
                                 </optgroup>
                                 
                                 <optgroup label="Administración" class="ADM">
                                    <option value="administracion" class="ADM"> - Administración</option>
                                 </optgroup>
                                 <optgroup label="Otros Movimientos" class="OTROS">
                                    <option value="x_otros" class="OTROS"> - Otros Movimientos</option>
                                 </optgroup>
                                    
                              </select>

                          </td>
                      </tr>
                      <tr id="trDT" style="display:none">
                        <td  width="195" class="etiquetaPo"><p>Dictamen Técnico:</p></td>
                        <td>
                          <input type="text" name="volanteDT" id="volanteDT" class="redonda5" size="35" disabled="disabled">
                          </td>
                      </tr>
                      <tr>
                        <td class="etiquetaPo"> <p>Acción:</p></td>
                        <td>
                          <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35" style="float:left">
                          <span id="idLoad"  style="float:left; padding:0 5px"></span>

                          <input type="hidden" name="direccion" id="direccion" class="" size="25" readonly="readonly">
                          <input type="hidden" name="turnado" id="turnado" class="" size="25" readonly="readonly">
                          <input type="hidden" name="estado" id="estado" class="" size="25" readonly="readonly">
                          <input type="hidden" name="estadoPFRR" id="estadoPFRR" class="" size="25" readonly="readonly">
                          <input type="hidden" name="prescripcion" id="prescripcion" class="" size="25" readonly="readonly">
                          <input type="hidden" name="presuntos" id="presuntos" class="" size="25" readonly="readonly">
                          <input type="hidden" name="montototal" id="montototal" class="" size="25" readonly="readonly">
							<br />
                          
                          <table width="100%">
                            <tr>
                                <td id='volTxt'></td>
                            </tr>
                          </table>
                          
                        </td>
                      </tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="30" rows="3" class="redonda5" id='asunto' name='asunto'></textarea>
                        </td>
                      </tr>
                    </table>
                    </div>
                </td>
                <td width="50%" valign="top">
                	<div class="volDivCont redonda5" id="tablaCral" >
                    <table align="center" width="100%" border="0" class="tablaPasos tablaVol" >                        
                        <tr>
                        <td class="etiquetaPo" width="195"><p>CRAL:</p></td>
                        <td>
                          <input type="text" name="cral" size="35" id="cral" class="redonda5" disabled="disabled">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha CRAL:</td>
                          <td><input type="text" name="fechaCral" size="25" id="fechaCral" class="redonda5" disabled="disabled" /></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Acuse Cral:</td>
                        <td><input type="text" name="acuseCral" size="25" id="acuseCral" class="redonda5" disabled="disabled" /></td>
                      </tr>
                     </table>
                     <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                	</div>
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                <input type="button" class="submit-login" value="Generar Volante" onclick="generarVolante()" />
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <?php } ?>
      
      <div id='p2' style=" <?php if( $_SESSION['direccion'] == "DG" || $_SESSION['usuario'] == "esolares") echo "display:none"; else  echo "display:block";?> " class="contVolantes redonda10 todosContPasos">
      	    <div style="float:right"><img src="images/help.png" /></div>
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Volante: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            <input type="hidden" name="dirVol" id="dirVol" class="redonda5" value="<?php echo $_SESSION['direccion'] ?>">
            
            
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
        </div>

      </div>
      <!--
      <div id='p3' style="display:none" class="contVolantes redonda10 todosContPasos">
      	<h3 class= "poTitulosPasos">Opciones de Volantes</h3>
      </div>
      -->
</div><!-- end cont volantes -->
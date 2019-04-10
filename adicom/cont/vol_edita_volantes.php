<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$id = valorSeguro(trim($_REQUEST['id']));

$sql = $conexion->select("SELECT * FROM volantes WHERE id = $id	",false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);

if($r['status'] == 0 || $r['status'] == 1 || $r['status'] == 2)
{
	echo '<script> 
			$$( document ).ready(function() {
				$$(".camposEditar").attr("disabled", true);;
			});
		</script> ';	
}


if($r['cral'] == '') $atribCral = "disabled='disabled'";
else $atribCral = '';

echo '<script> 
		$$( document ).ready(function() {
			$$("#movimientoE").val("'.$r['tipoMovimiento'].'");
		});
	</script> ';	



?>

<script> 
	
$$( document ).ready(function() {
    
    if($$("#indexDir").val() == "DG" || $$("#indexUser").val() == "esolares")
        $$("#cancelaVol").html("<input type='button' class='submit-login camposEditar' value='' onclick='cancelarVolante()' />") 
		
	if($$("#indexNivel").val() == "S" || $$("#indexUser").val() == "evmartinez" )	
		$$("#recibeVol").html("<td align='center'><input type='button' class='submit-login camposEditar' value='Recibir Volante' onclick='recibirVolante()' />");
});

function muestraCral(valor)
{
	 if(valor == "recepcion" || valor == "dtns")
	 { 
	 	//$$("#tablaCral").fadeIn();
		$$('#cralE').attr('disabled', false);
		$$('#fechaCralE').attr('disabled', false);
		$$('#acuseCralE').attr('disabled', false);
	 }
	 else 
	 {
		//$$("#tablaCral").fadeOut();
		$$('#cralE').attr('disabled', true);
		$$('#fechaCralE').attr('disabled', true);
		$$('#acuseCralE').attr('disabled', true);
	 }
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------
function recibirVolante()
{
	$$.ajax
	({
		beforeSend: function(objeto)
		{
			//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito"); }
		},
		type: "POST",
		url: "procesosAjax/vol_recibe_volante.php",
		//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
		data: {
					idVol:$$('#idVolE').val(),
					folio:$$('#folioE').val(),
					remitente:$$('#remitenteE').val(),
					cargo:$$('#cargoE').val(),
					oficio:$$('#oficioE').val(),
					movimiento:$$('#movimientoE').val(),
					accion:$$('#accionvolanteE').val(),
					asunto:$$('#asuntoE').val(),
					dependencia:$$('#dependenciaE').val(),
					fechaOficio:$$('#fechaOficioE').val(),
					fechaAcuse:$$('#fechaAcuseE').val(),
					turnado:$$('#turnadoE').val(),
					direccion:$$('#direccionE').val(),
					cral:$$('#cralE').val(),
					fechaCral:$$('#fechaCralE').val(),
					acuseCral:$$('#acuseCralE').val(),
					//---- se elige el user del index -------------
					usuario:$$('#indexUser').val()
				},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			//alert(datos);
			//new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
			//--------- recarga lista de volantes -----------------------
			//if(datos == "ok")
			//{
				$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				$$("#volLista").load("procesosAjax/vol_busca_volantes.php");
				cerrarCuadro();
			//}
			//else alert(datos);
		}
	});
}
//---------------------------------------------------------------------------------------------------

function cancelarVolante()
{
	var tipo = "cancela";
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
		url: "procesosAjax/vol_modifica_volante.php",
		//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
		data: {
					tipoAccion:tipo,
					idVol:$$('#idVolE').val(),
					folio:$$('#folioE').val(),
					remitente:$$('#remitenteE').val(),
					cargo:$$('#cargoE').val(),
					oficio:$$('#oficioE').val(),
					movimiento:$$('#movimientoE').val(),
					accion:$$('#accionvolanteE').val(),
					asunto:$$('#asuntoE').val(),
					dependencia:$$('#dependenciaE').val(),
					fechaOficio:$$('#fechaOficioE').val(),
					fechaAcuse:$$('#fechaAcuseE').val(),
					turnado:$$('#turnadoE').val(),
					direccion:$$('#direccionE').val(),
					cral:$$('#cralE').val(),
					fechaCral:$$('#fechaCralE').val(),
					acuseCral:$$('#acuseCralE').val(),
					//---- se elige el user del index -------------
					usuario:$$('#indexUser').val()
				},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			//alert(datos)
			cerrarCuadro();
			new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
			//--------- recarga lista de volantes -----------------------
			$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
			$$("#volLista").load("procesosAjax/vol_busca_volantes.php");
		}
	});
}
//---------------------------------------------------------------------------------------------------
function modificaVolante()
{
	var tipo = "modifica";
	if(comprobarForm('volanteForm'))
	{
		if($$('#movimientoE').val() == 'recepcion' || $$('#movimientoE').val() == 'dtns')
		{
			cral = $$('#cralE').val();
			fechaCral = $$('#fechaCralE').val();
			acuseCral = $$('#acuseCralE').val();			
		}
		else
		{
			cral = "";
			fechaCral = "";
			acuseCral = "";
		}
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
			url: "procesosAjax/vol_modifica_volante.php",
			//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
			data: {
						tipoAccion:tipo,
						idVol:$$('#idVolE').val(),
						folio:$$('#folioE').val(),
						remitente:$$('#remitenteE').val(),
						cargo:$$('#cargoE').val(),
						oficio:$$('#oficioE').val(),
						movimiento:$$('#movimientoE').val(),
						accion:$$('#accionvolanteE').val(),
						asunto:$$('#asuntoE').val(),
						dependencia:$$('#dependenciaE').val(),
						fechaOficio:$$('#fechaOficioE').val(),
						fechaAcuse:$$('#fechaAcuseE').val(),
						turnado:$$('#turnadoE').val(),
						direccion:$$('#direccionE').val(),
						cral:$$('#cralE').val(),
						fechaCral:$$('#fechaCralE').val(),
						acuseCral:$$('#acuseCralE').val(),
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
				cerrarCuadro();
				new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
				//--------- recarga lista de volantes -----------------------
				$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  				$$("#volLista").load("procesosAjax/vol_busca_volantes.php");
			}
		});
	}
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
		{
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitenteE").autocomplete({
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
			$$("#cargoE").val(ui.item.cargo);
			$$("#dependenciaE").val(ui.item.dependencia);
			$$("#oficioE").focus();
			
		  }
			});//end
		}); 
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
		{
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#accionvolanteE").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
						$$.ajax({
							type: "POST",
							url: "procesosAjax/po_busqueda_volantesaccion.php",
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
				//muestraContenidoOficios(ui.item.label);
				$$("#volTxtE").html("Dirección: "+ui.item.direccion+" Turnado: "+ui.item.turnado);
				$$("#turnadoE").val(ui.item.turnado);
				$$("#direccionE").val(ui.item.direccion);
			  	$$("#estado").val(ui.item.estado);
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
	$$( "#fechaOficioE" ).datepicker({
		 // dateFormat: formatoFecha,
		  defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaAcuseE" ).datepicker( "option", "minDate", selectedDate );  
		  }
	});
	
	$$( "#fechaAcuseE" ).datepicker({
		 // dateFormat: formatoFecha,
		  defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaOficioE" ).datepicker( "option", "maxDate", selectedDate );  
		  }
	});
//---------------------------------------------------------------------	
//---------------------------------------------------------------------	
	$$( "#fechaCralE" ).datepicker({
		 // dateFormat: formatoFecha,
		  defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#acuseCralE" ).datepicker( "option", "minDate", selectedDate );  
		  }
	});
	
	$$( "#acuseCralE" ).datepicker({
		 // dateFormat: formatoFecha,
		  defaultDate: "+1w", //mas una semana
		  numberOfMonths:1,	  //meses a mostrar
		  showAnim:'slideDown',
		  beforeShowDay: noLaborales,
		  onClose: function( selectedDate ) 
		  { 
			$$( "#fechaCralE" ).datepicker( "option", "maxDate", selectedDate );  
		  }
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
</style>


<div>
    <!-- <div id='colorSelector'>hola</div> -->

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
                        <input type="text" name="remitenteE" id="remitenteE" size="35" class="redonda5 camposEditar" value="<?php echo $r['remitente'] ?>" >
                        <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5 camposEditar" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargoE" id="cargoE" size="35" class="redonda5 camposEditar" value="<?php echo $r['cargo'] ?>">
                    </td>
                  </tr>
                    <tr>
                    <td class="etiquetaPo">  <p>Dependencia:</p></td>
                    <td>
                      <input type="text" name="dependenciaE" id="dependenciaE" size="35" class="redonda5 camposEditar" value="<?php echo $r['entidad_dependencia'] ?>">
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
                          <input type="text" name="oficioE" size="35" id="oficioE" class="redonda5 camposEditar" value="<?php echo $r['referencia'] ?>">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha Oficio:</td>
                          <td><input type="text" name="fechaOficioE" size="25" id="fechaOficioE" class="redonda5 camposEditar" value="<?php echo fechaNormal($r['fecha_oficio']) ?>"/></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Fecha de acuse de recepcion:</td>
                        <td><input type="text" name="fechaAcuseE" size="25" id="fechaAcuseE" class="redonda5 camposEditar" value="<?php echo fechaNormal($r['fecha_acuse']) ?>"/></td>
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
                          <select name="movimientoE" id="movimientoE"  class="redonda5 camposEditar" onchange="muestraCral(this.value)">
                            <option value="">Tipo de movimiento...</option>
                            <option value="2">Recepción Ligada a acción</option>
                            <option value="9">Solventación</option>
                             <option value="10">DTNS </option>
                            <option value="8">Baja por Conclusión Previa a su Emisión </option>
                            <option value="11">Concluido</option>
                            <option value="otro">Otro Movimiento</option>
                          </select>
                          </td>
                      </tr>
                      <tr>
                        <td class="etiquetaPo"> <p>Acción:</p></td>
                        <td>
                          <input type="text" name="accionvolanteE" id="accionvolanteE" class="redonda5 camposEditar" size="35" value="<?php echo $r['accion'] ?>">
                          <input type="hidden" name="direccionE" id="direccionE" class="" size="25" readonly value="<?php echo $r['direccion'] ?>">
                          <input type="hidden" name="turnadoE" id="turnadoE" class="" size="25" readonly value="<?php echo $r['turnado'] ?>">
                          <input type="hidden" name="estado" id="estado" class="" size="25" readonly>
                          <table>
                            <tr>
                                <td id='volTxtE'></td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="30" rows="3" class="redonda5 camposEditar" id='asuntoE' name='asuntoE'><?php echo $r['asunto'] ?></textarea>
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
                          <input type="text" name="cralE" size="35" id="cralE" class="redonda5 camposEditar" <?php echo $atribCral ?> value="<?php echo $r['cral'] ?>">
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">Fecha CRAL:</td>
                          <td><input type="text" name="fechaCralE" size="25" id="fechaCralE" <?php echo $atribCral ?> class="redonda5 camposEditar" value="<?php echo fechaNormal($r['fechaCral']) ?>"/></td>
                        </tr>
                        <tr>
                        <td class="etiquetaPo">Acuse Cral:</td>
                        <td><input type="text" name="acuseCralE" size="25" id="acuseCralE" <?php echo $atribCral ?> class="redonda5 camposEditar" value="<?php echo fechaNormal($r['acuseCral']) ?>"/></td>
                      </tr>
                     </table>
                     <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
                	</div>
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                    <table width="40%">
                    <tr>
                    	<input type="hidden" name="folioE" id="folioE" class="" size="25" readonly value="<?php echo $r['folio'] ?>">
                        <input type="hidden" name="idVolE" id="idVolE" class="" size="25" readonly value="<?php echo $r['id'] ?>">
                        <!-- <td align="center"><input type="button" class="submit-login camposEditar" value="Modificar Volante" onclick="modificarVolante('modifica')" /></td> -->
                       
                        <td align='center' id='cancelaVol'></td>
                        <td align='center' id="recibeVol"></td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        
        </form>

</div><!-- end cont volantes -->
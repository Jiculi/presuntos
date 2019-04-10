
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
  		$$("#volLista").load("procesosAjax/jn_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 3)
	{
		$$('#volLista2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista2").load("procesosAjax/po_oficio_busca_2013.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 

}
function comprobarFormulario(form,estado,volantes,oficios,cral,SolventacionBaja)
{
	//alert(' Campos = '+oficios);
	
	var mensaje = " ";
	var elementos = "";
	var error = 0;
	var adver = 0;
	var VcsMenEdos = 0;
	var VcsMenCita = 0;
	var VcsMenEdos2 = 0;
	var VcsMenEdos3 = 0;
	var VcsMenEdos4 = 0;
	//var veces = 0;
	//-----------------------------------------------------------------
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
		//elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";
		if(ele.name != 'accionvolante' && (ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
		{
			//mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
			document.getElementById(ele.name).style.borderColor = 'silver';
	}
	if(error != 0) mensaje += " - Los campos marcados en color rojo son obligatorios";
	//--------------- validamos acciones segun tipo oficio -------------
	var mut_edos = document.oficioForm.elements["accionEstado[]"];
	//var mut_edos = document.getElementsByName["accionEstado[]"];
	//------ devolucion DTNS -------------------------------------------
	var veces = $$('.camposInputAcciones').length;
	//alert( veces );
	
	if( $$('#tipoOficio').val() == 'dtns_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 11)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en estado *** Revisión del Expediente Técnico por no Solventación del PO *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}
	//------ citatorio_PFRR -------------------------------------------
	if( $$('#tipoOficio').val() == 'citatorio_PFRR')
	{
		$$(".camposInputProcedimientos").each(function() {
			if($$(this).val() == "")
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) tener Número de Procedimiento ";
					VcsMenCita++;
				}
				error++;	
			}
		});
	}
	//------ OPINION TECNICA DE LA UAA -------------------------------------------
	if( $$('#tipoOficio').val() == 'opinion_UAA_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 17 || $$(this).val() != 18)
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en los estados \n *** En desahogo de Audiencia de Ley *** \n *** Formulación, desahogo de pruebas y período de alegatos ***";
					VcsMenEdos2++;
				}
				error++;	
			}
		});
	}
	//------ NOTIFICAR RESOLUCION -------------------------------------------
	var numVcs = 0;
	if( $$('#tipoOficio').val() == 'notificarRes_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			numVcs++;

			if($$(this).val() != 29)
			{
				if(VcsMenEdos3 == 0)
				{
					mensaje += "\n - La acción debe estar en el estado \n *** Emisión de la Resolución *** ";
					VcsMenEdos3++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 0) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }
	//------------------------- SAT -------------------------------------------
	var numVcs = 0;
	if( $$('#tipoOficio').val() == 'sat_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			numVcs++;

			if($$(this).val() != 29)
			{
				if(VcsMenEdos4 == 0)
				{
					mensaje += "\n - La acción debe tener generado un número de PDR ";
					VcsMenEdos4++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 0) 
	{ mensaje += "\n - Solo se puede generar un oficio del SAT por acción"; error++;  }

//----------------------------------------------------------------------------
	if(error != 0)
	{
			alert(mensaje);
			return false;
	}
	else 
	{//-------------------------
		return true;
	}
}

//--------------------------------------
var nextinput = 0;
var accionesNum = 0;
//--------------------------------------
function agregarCampos(valor,estado,procedimiento,pdr)
{
	var igual = 0;
	var totalAcciones = $$("#totalAcciones").val();

	$$('.camposInputAcciones').each( function(){
	  var $$this = $$(this);
	  //$this.css( 'text-decoration' , 'underline' );
	  if(valor == $$this.val()) igual++;
	});
	//-------------------------------------------------------------------------
	if(igual == 0)
	{
		nextinput++;
		accionesNum++;
		$$("#accionesNo").html(accionesNum);
		$$("#totalNoAcciones").val(accionesNum);
		campo = '<li id="rut'+nextinput+'" class="camposLi">';
		campo += '<input type="text" size="35" class="redonda5 camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada_' + nextinput + '" value="'+valor+'"  readonly/>';
		campo += '<input type="hidden" size="5" class="redonda5 camposInputEstados" id="accionEstado[]"  name="accionEstado[]" value="'+estado+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 camposInputProcedimientos" id="procedimientos[]"  name="procedimientos[]" value="'+procedimiento+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 camposInputPdr" id="pdr[]"  name="pdr[]" value="'+pdr+'"  readonly/>';		
		
		campo += '<div class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </div> </li>';
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(valor+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#camposAcciones").append(campo);
		$$('#accionvolante').attr('value') = "";
		$$('#accionvolante').val('');
	}
	else 
	{ 
		$$("#accionvolante").focus();
		alert ("Esta accion ya la ha ingresado...");
		$$('#accionvolante').attr('value') = "";
	}
}
function elimina_me(elemento)
{
	$$("#"+elemento).remove();
	accionesNum--;
	$$("#accionesNo").html(accionesNum);
	$$("#totalNoAcciones").val(accionesNum);
}
//---------------------------------------
function muestraCral(valor)
{
	 if(valor == 2 || valor == 10)
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
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarOficio()
{
	if(comprobarFormulario('oficioForm'))
	{
		/*
		//---------- verificamos que existan acciones --------------
		if($$('.camposInputAcciones').length)
			var totalAcciones = 1;
		else 
		{
			var totalAcciones = 0;
			 alert("Ingrese por lo menos una accion...");
		}
		*/
		//-------------------------------------------------------
			//-------------------------------------------------------
			$$.ajax
			({
				beforeSend: function(objeto)
				{
					$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$$('#generaOficio').attr("disabled",true);
					$$('#generaOficio').val('Generando Oficio espere...');
					$$('#generaOficio').css( "background", "gray" );
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/medios_oficio_genera.php",
				//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
				data: $$("#oficioForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//generamos ultimo ID
					//alert(datos);
					new mostrarCuadro(200,500,"Oficio generado...",150)
					$$("#cuadroRes").html(datos);

					// campos en blanco
					$$(".redonda5").val("");
					$$("#camposAcciones").html(""); 
					//---------------------------------------------------------
					$$('#generaOficio').attr("disabled",false);
					$$('#generaOficio').val('Generar Oficio');
					$$('#generaOficio').css( "background", "#333" );
					
				}
			});
	}//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------

$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
					
					$$.ajax({
						type: "POST",
						url: "procesosAjax/medios_busqueda_nombre.php",
						dataType: "json",
						data: {
							term: request.term,
							//acciones: $$("#totalAcciones").val(),
							//tipo: tipo
						},
						success: function( data ) {
							response(data);
							//alert(urlAjax+" - "+$$("#totalAcciones").val());
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
			$$("#oficioRef").focus();
			
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
						type: "POST",
						url: "procesosAjax/pfrr_oficios_buscaAccion.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $$("#indexDir").val()
						},
						success: function( data ) {
							response(data);
		  //muestraListados();
						}
					});
			 },
		   minLength: 2,
	  select: function( event, ui ) {  
		//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
		//muestraContenidoOficios(ui.item.label);
		agregarCampos(ui.item.value,ui.item.estado,ui.item.procedimiento,ui.item.pdr);
		
	  },
	  change: function (event, ui) {
		   if(!ui.item)  $$(event.target).val("");
    	},
	  focus: function (event, ui) {
        return false;
    }
	});//end
}); 
//---------------------------------- BUSCAR OFICIOS -----------------------------------	
//--------------------------------------------------------------------------------------
$$( document ).ready(function() {
	$$("#userForm").val($$("#indexUser").val());
	$$("#dirForm").val($$("#indexDir").val());
	$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  	$$("#volLista").load("procesosAjax/adm_oficio_busca.php");
	// --------------- AGREGA el option administrativo a select ---------------
	//if($$("#indexDir").val() == "DG") $$('#tipoOficio').append('<option value="administrativo" selected="selected">Administrativo</option>');
	
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
				url: "procesosAjax/jn_oficio_busca.php",
				data: {
						texto:$$('#text').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val(),
						nivel:$$('#indexNivel').val()
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
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$("#text2").keyup(function() {
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 $$('#volLista2').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/medios_oficio_busca_2013.php",
				data: {
						texto:$$('#text2').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val(),
						nivel:$$('#indexNivel').val()
					},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					$$('#volLista2').html(datos); 
				}
			});
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
	height:300px;
	overflow:auto;	
}
</style>
<link href="css/estilos_medios.css" rel="stylesheet" type="text/css" media="all" />

<div id="pagMedios">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR OFICIO </div>
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR OFICIOS </div>
        <!--- div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OFICIOS 2013 </div --->
    </div>
    <div id='p1' class="contOficios redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
        
        <table width="90%" align="center">
        <tr>
        
        	<td width="50%">
                <div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                                               <tr>
                        <td class="etiquetaPo" width="100"> <p>Agregar Acción:</p></td>
                        <td>
                          <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35" style="float:left;"> <span id="idLoad" style="float:left; padding:0 5px"></span>
                        </td>
                      </tr>

                 
                 <tr>
                    <td class="etiquetaPo" width="100"> <p>Tipo de oficio:</p></td>
                    <td>
                      <select name="tipoOficio" id="tipoOficio" class="redonda5">
                      		<option value="">Seleccione el tipo de oficio...</option>
                      		<option value="contestacion_jn">Contestación de Demanda en el Juicio Contencioso</option>
							<option value="contest_amp_jn">Contestación a la Ampliación de Demanda en el Juicio Contencioso</option>
							<option value="alegatos_jn">Alegatos en el Juicio Contencioso</option>
							<option value="suspencion_jn">Informe de Suspensión o de Medidas Cautelares en el Juicio Contencioso</option>
							<option value="rec_reclama_jn">Recurso Reclamación en el Juicio Contencioso</option>
							<option value="otros_jn">Otros Oficios en el Juicio Contencioso</option>
							<option value="rev_fiscal">Revisión Fiscal</option>
							<option value="otros_rev_fic">Otros Oficios Durante la Tramitación de la Revisión Fiscal</option>
							<option value="alegatos_ad">Alegatos en Amparo Directo</option>
							<option value="otros_ad">Otros Oficios Durante la Tramitación del Amparo Directo</option>
							<option value="inf_just_ad">Informe Justificado en Amparo Indirecto</option>
							<option value="otros_of_ad">Otros Oficios en el Amparo Indirecto</option>
							<option value="inf_previo_ad">Informe Previo en Amparo Indirecto</option>
							<!--       		anteriores							-->
                      		<option value="sat_medios">SAT</option>
                            <!--- option value="tribunal_medios">Tribunal</option --->
                            <option value="actores_medios">Actores</option>
                             <option value="otros_medios">Otros</option> 
                             <option value="archivo_con">Archivo de Concentración</option> 
                      </select>
                    </td>
                  </tr>
                 <!-- 
                  <tr>
                    <td class="etiquetaPo" width="100"> <p>Agregar Acción:</p></td>
                    <td>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35">
                    </td>
                  </tr>
-->

                    </td>
                  </tr>
                  </table> 
                </div>

            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="100"><p>Destinatario:</p></td>
                      
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
              <td width="50%" rowspan="2">
                   <div class="camposAcciones redonda5" id="camposAcciones">
                   <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                   
              		</div>
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
              </td>
            </tr>
            <tr>
            	<td width="50%">
					<div class="volDivCont redonda5">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                      <tr>
                        <td class="etiquetaPo" width="100"> <p>Expediente de Referencia:</p></td>
                        <td>
                          <input type="text" name="oficioRef" id="oficioRef" class="redonda5" size="35">
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
                <!--
                	celdas vacias
                -->
                </td>
            </tr>
            <tr>
            	<td colspan="3" align="center"><p><H2>Solicita:</H2></p>
					<?php $genera = $_SESSION['oficios'];  $direcgr = $_SESSION['direccion']; ?>
					
                <!--input name='userForm' id='userForm' type="hidden" value="" / -->
				<select name='userForm' id='userForm' class="redonda5" >
				
                    <option value="" selected="selected">Elegir</option>
                    <?php
					if ( $direcgr != "DG" ) { 
						$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND direccion = '$direcgr' ORDER BY nivel",false);
					} else {
						$sql = $conexion->select("SELECT * FROM usuarios WHERE status != '0' AND usuario <> 'yflores' AND usuario <> 'mcarmonah' ORDER BY nivel",false);
					}
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['usuario'].'">'.$r['nombre'].'_'.$r['nivel'].'</option>';
                 
                 ?> 
					</select>
                    <input name='dirForm' id='dirForm' type="text" value="" />
					<input name='oficio' id='oficio' type="hidden" value='<?php echo $_SESSION['oficios']; ?>' />
					</br></br>
					
				<?php if($genera == 1) { ?>
                <input type="button" class="submit-login" value="Generar Oficio" id="generaOficio" onclick="generarOficio()" />
				<?php } else { echo "<H1> ¡No cuenta con permisos para generar Oficios! </H1>"; } ?>
				
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <div id='p2' style="display:none" class="contOficios redonda10 todosContPasos">
      	    <div style="float:right"><img src="images/help.png" /></div>
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Oficio: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
        </div>

      </div>
      <div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
            <h2>Buscar Oficio: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
      </div>
</div><!-- end cont volantes -->
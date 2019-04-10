
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
  		$$("#volLista").load("procesosAjax/po_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
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
	
	var mensaje = "";
	var elementos = "";
	var error = 0;
	var adver = 0;
	var VcsMenEdos = 0;
	var VcsMenCita = 0;
	var VcsMenEdos2 = 0;
	var VcsMenEdos3 = 0;
	var VcsMenEdos4 = 0;
	var VcsMenEdos5 = 0;
	//--------------- validamos acciones segun tipo oficio -------------
	var mut_edos = document.oficioForm.elements["accionEstado[]"];
	//var mut_edos = document.getElementsByName["accionEstado[]"];
	//------------------------------------------------------------------
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
	//---------------- validamos acciones segun tipo oficio ----------------------
	if( $$('#tipoOficio').val() == 'asistencia')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 2)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) acción(es) debe(n) estar en estado *** Opinion del PPO *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
		$$(".oficioAS").each(function() {
			if($$(this).val() != 0)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - Esta acción tiene un oficio de Asistencia Jurídica pendiente. Acuse el oficio para poder generar otro. ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}

	if( $$('#tipoOficio').val() == 'remisionUAA')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 6)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La acción debe estar en estado *** Notificado *** ";
					VcsMenEdos++;
				}
				error++;	
			}
		});
	}

	if($$('#tipoOficio').val() == 'notificacionEF' && $$("#totalNoAcciones").val() > 1)
	{
		mensaje += "\n - La notificacion a Entidad Fiscalizada solo debe contener una acción";
		error++;
	}
		
	if($$('#tipoOficio').val() == 'notificacionICC' && $$("#totalNoAcciones").val() > 1)
	{
		mensaje += "\n - La notificacion a I.C.C. solo debe contener una acción";
		error++;	
	}


	if( $$('#tipoOficio').val() == 'notificacionEF' || $$('#tipoOficio').val() == 'notificacionICC' )
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 5)
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n\n - Para notificar esta acción debe estar en estado: \n\n *** En proceso de Notificación *** \n\n ";
					VcsMenEdos2++;
				}
				error++;	
			}
		});
		// notificacion a EF comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionEF')
		{
			$$(".oficioEF").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio EF pendiente ";
						error++;	
				}
			});
		}
		// notificacion a ICC comprobamos oficios
		if($$('#tipoOficio').val() == 'notificacionICC')
		{
			$$(".oficioICC").each(function() {
				if($$(this).val() != 0)
				{
						mensaje += "\n\n - Esta acción ya tiene un oficio ICC pendiente ";
						error++;	
				}
			});
		}
		
	}

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
function agregarCampos(valor,estado,estadoTxt,oficioEF,oficioICC,oficioAS)
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
		campo += '<input type="hidden" size="5" class="redonda5 camposInputEstados" id="accionEstado"  name="accionEstado" value="'+estado+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioEF" id="oficioEF"  name="oficioEF" value="'+oficioEF+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioICC" id="oficioICC"  name="oficioICC" value="'+oficioICC+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioAS" id="oficioAS"  name="oficioAS" value="'+oficioAS+'"  readonly/>';		
		campo += '<span class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </span>';
		campo += '<span>'+estadoTxt+'</span>';
		campo += '</li>';
		
		
		

		
		
		//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
		$$("#totalAcciones").val(totalAcciones.concat(valor+"|"));
		//----------- agregamos campo y boirramos value de accion -------------
		$$("#camposAcciones").append(campo);
		$$('#accionvolante').attr('value') = "";
		$$('#accionvolante').val('');
		
			//-------------------------------------------------------
	}
	else 
	{ 
		$$("#accionvolante").focus();
		alert ("Esta acción ya la ha ingresado...");
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


function completa()
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
		url: "procesosAjax/po_busqueda_remitente_oficios.php",
		data: {acciones:$$('#accionVinculada_1').val(), tipo:$$('#tipoOficio').val()},
		error: function(objeto, quepaso, otroobj)
		{
			//alert("Estas viendo esto por que fallé");
			//alert("Pasó lo siguiente: "+quepaso);
		},
		success: function(datos)
		{ 
			//alert(datos);
			var remi= datos.split("|");

			$$("#remitente").val(remi[0]);
			$$("#cargo").val(remi[1]);
			$$("#dependencia").val(remi[2]);
			
			if ($$('#tipoOficio').val() != "notificacionEF" || $$('#tipoOficio').val() != "notificacionICC"  || $$('#tipoOficio').val() !="asistencia")
			{
				$$("#remitente").attr('readonly',false);
				$$("#cargo").attr('readonly',false);	 
				$$("#dependencia").attr('readonly',false);	 
			}
			else
				{
				$$("#cargo").removeAttr("readonly"); 
				$$("#remitente").removeAttr("readonly");
				$$("#dependencia").attr('readonly','readonly');	 
				}
				
			//$$("#dependencia").val(remi[1]);
		}
	});
}
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarOficio()
{
	if(comprobarFormulario('oficioForm'))
	{
		//---------- verificamos que existan acciones --------------
		if($$('.camposInputAcciones').length)
			var totalAcciones = 1;
		else 
		{
			var totalAcciones = 0;
			 alert("Ingrese por lo menos una acción...");
		}
		//-------------------------------------------------------
		if(totalAcciones != 0)
		{
			//-------------------------------------------------------
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
				url: "procesosAjax/po_oficio_genera.php",
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
					//------------ reiniciamos conteo de acciones -------------
					$$("#totalNoAcciones").val("0"); 
					accionesNum = 0;

					
				}
			});
		}//end estados
	}//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------

$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
					
					if($$('#tipoOficio').val() == 'notificacionEF')	var tipo = "notificacionEF";
					else var tipo = "normal";
					
					$$.ajax({
						type: "POST",
						url: "procesosAjax/po_busqueda_remitente.php",
						dataType: "json",
						data: {
							term: request.term,
							acciones: $$("#totalAcciones").val(),
							tipo: tipo
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
//---------------------------------------------------------------------------
$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#remitente").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
					
					if($$('#tipoOficio').val() == 'notificacionICC')
						var tipo = "notificacionICC";
					else 
						var tipo = "normal";
					
						$$.ajax({
							type: "POST",
							url: "procesosAjax/po_busqueda_remitente.php",
							dataType: "json",
							data: {
								term: request.term,
								acciones: $$("#totalAcciones").val(),
								tipo: tipo
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
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/po_oficios_buscaAccion.php",
						dataType: "json",
						data: {
							term: request.term,
							direccion: $$("#indexDir").val(),
							nivel: $$("#indexNivel").val()
						},
						success: function( data ) {
							$$('#idLoad').html('');
							response(data);
		  //muestraListados();
						}
					});
			 },
		   minLength: 2,
	  select: function( event, ui ) {  
		//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
		//muestraContenidoOficios(ui.item.label);
		$$(".opciones").css("display","none");
		
		if (ui.item.estado ==2) {
		 $$("select[name='tipoOficio'] option[value='asistencia']").show();
		 		$$("#remitente").attr('readonly',false);
				$$("#cargo").attr('readonly',false);	 
				$$("#dependencia").attr('readonly',false);	 
 }
		 
		 if (ui.item.estado ==5) {
		 $$("select[name='tipoOficio'] option[value='notificacionEF']").show(); 
		 $$("select[name='tipoOficio'] option[value='notificacionICC']").show(); }


		 if (ui.item.estado ==6) {
		 $$("select[name='tipoOficio'] option[value='remisionUAA']").show(); }


		agregarCampos(ui.item.value,ui.item.estado,ui.item.estadoTxt,ui.item.ofiEF,ui.item.ofiICC,ui.item.ofiAS);
		 
		 
		//$$("#volTxt").html("Turnado: Dirección '"+ui.item.direccion+"'  "+ui.item.turnado);
		//$$("#turnado").val(ui.item.turnado);
		//$$("#direccion").val(ui.item.direccion);
		//$$("#estado").val(ui.item.estado);
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
	
	if($$("#indexDir").val() == "DG") userDirec = "D";
	else userDirec = $$("#indexDir").val();
	
	$$("#userForm").val($$("#indexUser").val());
	$$("#dirForm").val(userDirec);
	$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  	$$("#volLista").load("procesosAjax/po_oficio_busca.php");
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
				url: "procesosAjax/po_oficio_busca.php",
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
				url: "procesosAjax/po_oficio_busca_2013.php",
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


<div id="">
    <!-- <div id='colorSelector'>hola</div> -->

	<div class="encVol">
        <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR OFICIO </div>
        <div id='paso2' onclick="muestraPestanaVol(2)" class="todosPasos pasos"> BUSCAR OFICIOS </div>
        <div id='paso3' onclick="muestraPestanaVol(3)" class="todosPasos pasos"> OFICIOS 2013 </div>
    </div>
    <div id='p1' class="contOficios redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="oficioForm" id="oficioForm" method="post" action="#">
        
        <table width="100%" align="center">
        <tr>
        	<td width="30%">
                <div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                                  <tr>
                    <td class="etiquetaPo" width="100"> <p>Agregar Acción:</p></td>
                    <td>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35"  style="float:left;" > <span id="idLoad" style="float:left; padding:0 5px"></span>
                    </td>
                  </tr>
                    </td>
                  </tr>

                
                 <tr>
                    <td class="etiquetaPo" width="100"> <p>Tipo de oficio:</p></td>
                    <td>
                      <select name="tipoOficio" id="tipoOficio" class="redonda5" onchange="completa()">
                      		<option class="opciones" value="">Seleccione el tipo de oficio...</option>
                      		<option class="opciones" value="asistencia">Asistencia Jurídica</option>
                            <option class="opciones" value="notificacionEF">Notificación E.F.</option>
                            <option class="opciones" value="notificacionICC">Notificación I.C.C.</option>
                            <option class="opciones" value="remisionUAA">Remisión a la UAA</option>
                            <option value="otros">Otros Oficios</option>
                      </select>
                    </td>
                  </tr>
                  </table> 
                </div>

            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="100"><p>Destinatario:</p></td>
                      
                    <td >
                        <input type="text" name="remitente" id="remitente" size="35" class="redonda5" value""  >
                        <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Cargo:</p></td>
                    <td>
                      <input type="text" name="cargo" id="cargo" size="35" class="redonda5" >
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
              <td width="70%" rowspan="2" valign="top">
                   <div class="camposAcciones redonda5" id="camposAcciones" style="overflow:auto; padding:20px !important">
                   <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                   
              		</div>
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">
              </td>
            </tr>
            <tr>
            	<td width="40%">
					<div class="volDivCont redonda5">
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                      <tr>
                        <td class="etiquetaPo" width="100"> <p>Referencia:</p></td>
                        <td>
                          <input type="text" name="oficioRef" id="oficioRef" class="redonda5" size="35">
                        </td>
                      </tr>
                        <td class="etiquetaPo"> <p>Asunto:</p></td>
                        <td>
                          <textarea cols="50" rows="3"  class="redonda5" id='asunto' name='asunto'></textarea>
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
            	<td colspan="3" align="center">
                <input name='userForm' id='userForm' type="hidden" value="" />
                <input name='dirForm' id='dirForm' type="hidden" value="" />
                <input type="button" class="submit-login" value="Generar Oficio" onclick="generarOficio()" />
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <div id='p2' style="display:none" class="contOficios redonda10 todosContPasos">
      	    <!-- <div style="float:right"><img src="images/help.png" /></div> -->
            <!-- <h3 class="poTitulosPasos">Listado de Oficios</h3> -->
            <h2>Buscar Oficio: 
            <input type="text" name="text" id="text" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista" id="volLista">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
        </div>

      </div>
      <!-- ---------------------------------------------------------------------------- -->
      <div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
        <h2>Buscar Oficio 2013: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
             	<!-- AQUI VAN LOS RESULTADOS -->
             </div>
      </div>
      
</div><!-- end cont
 volantes -->
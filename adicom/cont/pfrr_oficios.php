
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
  		$$("#volLista").load("procesosAjax/pfrr_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
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
	var VcsMenEdos6 = 0;
	var VcsMenMens = 0;
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
	//-------------------------------------------------------------------
	$$(".oficioAS").each(function() {
		if($$(this).val() != 0)
		{
			if(VcsMenEdos == 0)
			{
				mensaje += "\n - Esta acción tiene un oficio de Devolución Pendiente. Acuse el oficio para poder generar otro. ";
				VcsMenEdos++;
			}
			error++;	
		}
	});
	//------------Notificacion Acuerdo Inicio----------------------------
	
	
	if( $$('#tipoOficio').val() == 'Not_icc_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() != 15)
			{
				if(VcsMenEdos == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) tener Número de Procedimiento ";
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
			if($$(this).val() == 17 || $$(this).val() == 18 || $$(this).val() == 31) 
			{
				$$(".camposInputMen").each(function() {
					if($$(this).val() != "" )
					{
						//if(VcsMenMens == 0)
						//{
							mensaje += $$(this).val()+" ";
							error++;
							//VcsMenMens++;
						//}
					}
				});
			}
			else
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en los estados \n *** En desahogo de Audiencia de Ley *** \n *** Formulación y desahogo de pruebas*** \n *** Período de alegatos ***";
					VcsMenEdos2++;
				}
				error++;	
			}
		});

	}

	//------ SEGUNDA OPINION TECNICA DE LA UAA -------------------------------------------
	if( $$('#tipoOficio').val() == 'opinion_UAA_PFRR2')
	{
		$$(".camposInputEstados").each(function() {
			if($$(this).val() == 19 || $$(this).val() == 31) 
			{
				$$(".camposInputMen").each(function() {
					if($$(this).val() != "" )
					{
						//if(VcsMenMens == 0)
						//{
							mensaje += $$(this).val()+" ";
							error++;
							//VcsMenMens++;
						//}
					}
				});
			}
			else
			{
				if(VcsMenEdos2 == 0)
				{
					mensaje += "\n - La(s) accion(es) debe(n) estar en los estados \n *** En desahogo de Audiencia de Ley *** \n *** Formulación y desahogo de pruebas*** \n *** Período de alegatos ***";
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

			//if($$(this).val() != 29 || $$(this).val() != 22)
			if($$(this).val() != 22 && $$(this).val() != 29)
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
	if(numVcs > 1) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }
	
	//------ NOTIFICAR RESOLUCION notificarResEF_PFRR -------------------------------------------
	var numVcs = 0;
	if( $$('#tipoOficio').val() == 'notificarResEF_PFRR' || $$('#tipoOficio').val() == 'notificarResICC_PFRR')
	{
		$$(".camposInputEstados").each(function() {
			numVcs++;

			if($$(this).val() != 29 && $$(this).val() != 22 && $$(this).val() != 29 && $$(this).val() != 23 && $$(this).val() != 24 && $$(this).val() != 25  && $$(this).val() != 26)
			//if($$(this).val() != 22)
			{
				if(VcsMenEdos6 == 0)
				{
					mensaje += "\n - La acción debe estar en el estado \n *** Con Existencia de Responsabilidad *** ";
					VcsMenEdos6++;
				}
				error++;	
			}
		});
	}
	if(numVcs > 1) 
	{ mensaje += "\n - Solo se puede notificar una acción"; error++;  }

	//------------------------- SAT -------------------------------------------
	var numVcs = 0;
	  if( $$('#tipoOficio').val() == 'sat_PFRR')
	{}
		/*
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
		*/
		
		/*$$(".camposInputPdr").each(function() {
			numVcs++;

			//if($$(this).val() != 29 || $$(this).val() != 22)
			if($$(this).val() == "")
			{
				if(VcsMenEdos5 == 0)
				{
					mensaje += "\n - La acción debe tener generado un número de PDR ";
					VcsMenEdos5++;
				}
				error++;	
			}
		});*/

		
	/*}
	if(numVcs > 1) 
	{ mensaje += "\n - Solo se puede generar un oficio del SAT por acción"; error++;  }*/
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
function agregarCampos(valor,estado,procedimiento,pdr,estadoTxt,mensaje,oficioAS)
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
		campo += '<div style="height:40px">';
		campo += '<input type="text" size="35" class="redonda5 camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada_' + nextinput + '" value="'+valor+'"  readonly/>';
		campo += '<input type="hidden" size="5" class="redonda5 camposInputEstados" id="accionEstado[]"  name="accionEstado[]" value="'+estado+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 camposInputProcedimientos" id="procedimientos[]"  name="procedimientos[]" value="'+procedimiento+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 camposInputPdr" id="pdr[]"  name="pdr[]" value="'+pdr+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 oficioAS" id="oficioAS"  name="oficioAS" value="'+oficioAS+'"  readonly/>';		
		campo += '<input type="hidden" size="5" class="redonda5 camposInputMen" id="mensaje[]"  name="mensaje[]" value="'+mensaje+'"  readonly/>';		
		
		campo += '<div class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </div>';
		campo += '<div style="font-size:11px;float:right;width:280px">'+estadoTxt+'</div> </li>';
		campo += '</div>';
				
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
		//---------- verificamos que existan acciones --------------
		if($$('.camposInputAcciones').length)
			var totalAcciones = 1;
		else 
		{
			var totalAcciones = 0;
			 alert("Ingrese por lo menos una accion...");
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
				url: "procesosAjax/pfrr_oficio_genera.php",
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
					//---------------------------------------------------------
					$$('#generaOficio').attr("disabled",false);
					$$('#generaOficio').val('Generar Oficio');
					$$('#generaOficio').css( "background", "#333" );
					
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
					
					$$.ajax({
						type: "POST",
						url: "procesosAjax/pfrr_busqueda_nombre.php",
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
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/pfrr_oficios_buscaAccion.php",
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
	   //reseteamos campos al seleccionar accion
		$$("#tipoOficio").val('');
		$$("#remitente").val('');
		$$("#cargo").val('');
		$$("#dependencia").val('');
		$$("#oficioRef").val('');
		$$("#asunto").val('');
	  	//ocultamos todos los campos 
 		$$(".opciones").css("display","none");
		//mostramos solo los options que se debe
		if (ui.item.estado == 11 || ui.item.estado == 15) 
		{
			$$("select[name='tipoOficio'] option[value='dtns_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);
 		}

		if (ui.item.estado == 15) 
		{
			$$("select[name='tipoOficio'] option[value='Not_icc_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}

		if (ui.item.estado == 16 || ui.item.estado == 30 || ui.item.estado == 17 || ui.item.estado == 18 || ui.item.estado == 31)
		{
			//agregarSelect(ui.item.value);
			$$("select[name='tipoOficio'] option[value='citatorio_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}

		if (ui.item.estado == 18 || ui.item.estado == 31) 
		{
			$$("select[name='tipoOficio'] option[value='opinion_UAA_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}
		if (ui.item.estado == 19 || ui.item.estado == 31 ) 
		{
			$$("select[name='tipoOficio'] option[value='opinion_UAA_PFRR2']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}

		if (ui.item.estado == 29) 
		{
			$$("select[name='tipoOficio'] option[value='notificarRes_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}

		if (ui.item.estado == 29 || ui.item.estado == 23 || ui.item.estado == 24 || ui.item.estado == 25 || ui.item.estado == 26) 
		//if (ui.item.estado == 29) 
		{
			$$("select[name='tipoOficio'] option[value='tesofe_PFRR']").show();
			$$("select[name='tipoOficio'] option[value='notificarResEF_PFRR']").show();
			$$("select[name='tipoOficio'] option[value='notificarResICC_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}
		
		if (ui.item.estado == 24) 
		{
			$$("select[name='tipoOficio'] option[value='tesofe_PFRR']").show();
			$$("select[name='tipoOficio'] option[value='notificarResEF_PFRR']").show();
			$$("select[name='tipoOficio'] option[value='notificarResICC_PFRR']").show();
			$$("#remitente").attr('readonly',false);
			$$("#cargo").attr('readonly',false);	 
			$$("#dependencia").attr('readonly',false);	 
 		}
	    //--------------- VALIDACIONES POR OFICIO -------------------------------
		//agregamos un select cuando sea citatorio
		if($$('#tipoOficio').val() == 'citatorio_PFRR') 
		{
			//agregarSelect(ui.item.value);
			$$("#cargo").prop( "readonly", false ); //TRUE
			$$("#dependencia").attr( "readonly", false ); //TRUE
		}else{
			$$("#cargo").prop( "readonly", false );
			$$("#dependencia").attr( "readonly", false );
		}
		
		agregarCampos(ui.item.value,ui.item.estado,ui.item.procedimiento,ui.item.pdr,ui.item.estadoTxt,ui.item.mensaje,ui.item.ofiAS);
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
				url: "procesosAjax/pfrr_oficio_busca.php",
				data: {
						texto:$$('#text').val(),
						usuario:$$('#indexUser').val(),
						direccion:$$('#indexDir').val()
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
//---------------------------------- VERIFICA OPCION ----------------------------------
function verificaOpcion(opcion)
{
	
	if(opcion == 'citatorio_PFRR')
	{
		if($$('#accionVinculada_1').length)// si existe #accionVinculada
			agregarSelect($$('#accionVinculada_1').val());
	}
	else  
	{
		$$("#idRemitente").html('<input type="text" name="remitente" id="remitente" size="50" class="redonda5" >');
		$$("#cargo").val("");
		$$("#dependencia").val("");
		
		$$.ajax
		({
			beforeSend: function(objeto)
			{
			 //$$('#volLista2').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/pfrr_busca_remitente_oficios.php",
			data: {
					opcion:opcion,
					acciones:$$("#totalAcciones").val(),
					accion:$$('#accionVinculada_1').val()
				},
			success: function(datos)
			{ 
				//alert(datos);
				var dat = datos.split("|");
				
				if(dat[5] != 1) // si error es != 1
				{
					//todos loa campos de solo lectura
					$$("#cargo").attr("readonly",false);  //true
					$$("#remitente").attr("readonly",false); //true
					$$("#dependencia").attr('readonly',false);	 //true
					$$("#oficioRef").attr('readonly',false);	//true
					$$("#asunto").attr('readonly',false); //true
					// asignamos valores 	 
					$$("#remitente").val(dat[0]);
					$$("#cargo").val(dat[1]);
					$$("#dependencia").val(dat[2]);
					$$("#oficioRef").val(dat[3]);
					$$("#asunto").val(dat[4]);
					// mensajes de error
					if(dat[3] == "") $$("#oficioRef").attr('readonly',false);	
					if(opcion == 'Not_icc_PFRR' && dat[0] == '') alert("Esta acción no tiene Autoridades, favor de ingresarlas...");
				}
				else alert("Las UAA's son diferentes por favor ingrese solo acciones de la misma UAA");
				if(opcion == 'otros_PFRR' || opcion == 'sat_PFRR' || opcion == 'ef_PFRR' || opcion == 'icc_PFRR' || opcion == 'imss_PFRR' || opcion == 'issste_PFRR' || opcion == 'tribunal_pfrr' || opcion == 'comision_pfrr'|| opcion == 'pruebas_alcanceOT'|| opcion =='PFRR_citacion' || opcion=='solicitar_inf_tercero' || opcion=='enviar_info_ter' ||opcion=='continuacion_aud' ||opcion=='Not_Op_PR') 
				{
					$$("#cargo").attr("readonly",false); 
					$$("#remitente").attr("readonly",false);
					$$("#dependencia").attr('readonly',false);	 
					$$("#oficioRef").attr('readonly',false);	
					$$("#asunto").attr('readonly',false);
				}

			}
		});
	}
} 

function agregarSelect(accion)
{
	$$.ajax({
		type: "POST",
		url: "procesosAjax/pfrr_oficios_buscaPresuntos.php",
		//dataType: "json",
		data: {
			accion: accion
		},
		success: function( datos ) {
			
			//alert(datos)
			var todo = datos.split("|");
			var presuntos = todo[0];
			var idpresuntos = todo[1];
			var cargos = todo[2];
			var dependencias = todo[3];
			
			var ides = idpresuntos.split('-');
			var pres = presuntos.split('-');
			var cargo = cargos.split('-');
			var dependencia = dependencias.split('-');
			
			var selectPresuntos = " <select name='remitente' id='remitente'  class='redonda5' > ";
			selectPresuntos = selectPresuntos + " <option value=''> Seleccione un Presunto Responsable... </option> ";
			
			for (var ele in ides) 
			{
				if(pres[ele] != "")
				{
					selectPresuntos = selectPresuntos + "<option value='"+ides[ele]+"' onclick=\" $$('#cargo').val('"+cargo[ele]+"');  $$('#dependencia').val('"+dependencia[ele]+"');  \" > "+pres[ele]+" </option>";
				}
			}
			selectPresuntos = selectPresuntos + "</select>";
			$$("#idRemitente").html(selectPresuntos);
			
			$$("#oficioRef").val($$(".camposInputProcedimientos").val());
			$$("#asunto").val("Se notifica citatorio y se cita a comparecer al presunto responsable, en las instalaciones de la ASF ubicadas en el CEA");

		}
	});
	//--------------------------
}
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
<link href="css/estilos_pfrr.css" rel="stylesheet" type="text/css" media="all" />

<title>Norx zilla</title>

<div id="contPFRR" style="padding:10px">
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
                <td width="40%">
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
                          <select name="tipoOficio" id="tipoOficio" class="redonda5" onchange="verificaOpcion(this.value)" >
                          	<optgroup label="Proceso de la Acción">
                          
                            	<!--
                                <option value="">Seleccione el tipo de oficio...</option>
                                <option class="opciones" value="dtns_PFRR">Devolución DTNS</option>
                                <option class="opciones" value="Not_icc_PFRR">Notificación Inicio PFRR a la ICC</option>
                                <option class="opciones"value="citatorio_PFRR">Oficio Citatorio a Presunto Responsable</option>
                                <option class="opciones" value="opinion_UAA_PFRR">Opinión Técnica de la UAA</option>
                             

                                -->
                                
                            <?php
								 $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'pfrr' AND tipo = 'proceso' ", false); 
								 while($r = mysql_fetch_array($sql)) echo "<option class='opciones' value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
							?>
                            </optgroup>
                            <!--<option value="notificarRes_PFRR">Notificar Resolución</option>-->
                            <optgroup label="Otros Oficios">
                            <!--
                                <option class="opciones" value="notificarResICC_PFRR">Notificar Emisión de la Resolución ICC</option> 
                                <option class="opciones" value="notificarResEF_PFRR">Notificar Emisión de la Resolución EF</option>
                                <option class="opciones" value="tesofe_PFRR">SAT - Notificar PDR</option>
                                <optgroup>Otros Oficios</optgroup>
                                <option  value="docu_uaa_pfrr">Remitir Información/Documentación a la UAA</option>
                                <option  value="resp_uaa_pfrr">Iniciado. Responsabilidad UAA</option>
                                <option  value="reiteracion_pfrr">Solicitud de Reiteración de inicio del PFRR a la UAA </option>
                                <option  value="docu_dir_pfrr">Remitir ET y Documentación a Direccion C</option>
                                <option value="sat_PFRR">SAT - Solicitar/Emitir Información ó Documentación</option>
                                <option value="ef_PFRR">EF - Solicitar/Emitir Información ó Documentación</option>
                                <option value="icc_PFRR">CONTRALORÍAS - Solicitar/Emitir Información ó Documentación </option>
                                <option value="imss_PFRR">IMSS - Solicitar/Emitir Información ó Documentación</option>
                                <option value="issste_PFRR">ISSSTE - Solicitar/Emitir Información ó Documentación</option>
                                <option value="tribunal_pfrr">TRIBUNAL - Reposición de Procedimiento</option>
                                <option value="comision_pfrr">COMISIÓN</option>
                                <option value="recordatorio_pfrr">Recordatorio Solicitud de Opinión Técnica</option>
                                <option value="info_funPub_pfrr">Solicitud de Información a la Sec. de la Función Pública</option>
                                <option value="sol_informacion">Solicitud de Información/Documentación a la UAA </option>
                                <option value="pruebas_alcanceOT">Envío de Pruebas en Alcance de Opinión Técnica </option>
                                <option value="PFRR_citación"Citación de un tercero</option>
                                <option value="cerftificacion_UAA">Solicitud de Certificación de la UAA</option>
                                <option value="continuacion_aud">Notificación para Continuación de Audiencia</option>
                                <option value="archivoPFRR">Archivo de Concentración</option>
                                	
                                
                            -->
                            <?php
								 $sql = $conexion->select("SELECT * FROM oficios_options WHERE estado = 'pfrr' AND tipo = 'otros' ORDER BY texto", false); 
								 while($r = mysql_fetch_array($sql)) echo "<option value='".$r['value']."'> &nbsp;&nbsp;&nbsp; - ".$r['texto']."</option>";
							?>
                            </optgroup>
                            
                            <?php
							/*
							 $sql=$conexion->select("SELECT * from usuarios where usuario='".$_SESSION['usuario']."'", false); 
							 $r=mysql_fetch_array($sql);

							 if($r['otros_pfrr'] == 1) { ?>
                            	<option value="otros_PFRR">Otros Oficios</option>
                            <?php } 
							*/
							?>
                          </select>
                        </td>
                      </tr>
                      
    
    
                        </td>
                      </tr>
                      </table> 
                    </div>
    
                    <div class="volDivCont redonda5">
                    <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                      <tr>
                        <td  class="etiquetaPo" width="100"><p>Destinatario:</p></td>
                          
                        <td id='idRemitente'>
                            <input type="text" name="remitente" id="remitente" size="50" class="redonda5" >
                            <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                        </td>
                      </tr>
                      <tr>
                        <td class="etiquetaPo">  <p>Cargo:</p></td>
                        <td>
                          <input type="text" name="cargo" id="cargo" size="50" class="redonda5">
                        </td>
                      </tr>
                        <tr>
                        <td class="etiquetaPo">  <p>Dependencia:</p></td>
                        <td>
                          <input type="text" name="dependencia" id="dependencia" size="50" class="redonda5">
                        </td>
                      </tr>
                      </table> 
                      </div>
                  </td>
                  <td width="60%" rowspan="2" valign="top">
                       <div class="camposAcciones redonda5" id="camposAcciones" style="height:330px; width:100%">
                       <h3>Acciones Vinculadas <span id="accionesNo">0</span> </h3>
                       
                        </div>
                        <input type="hidden" name="totalAcciones" id="totalAcciones" size="40" class="redonda5">
                        <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="40" class="redonda5">
                  </td>
                </tr>
                <tr>
                    <td width="50%">
                        <div class="volDivCont redonda5">
                         <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                          <tr>
                            <td class="etiquetaPo" width="100"> <p>Referencia:</p></td>
                            <td>
                              <input type="text" name="oficioRef" id="oficioRef" class="redonda5" size="50">
                            </td>
                          </tr>
                            <td class="etiquetaPo"> <p>Asunto:</p></td>
                            <td>
                              <textarea cols="50" rows="3" class="redonda5" id='asunto' name='asunto'></textarea>
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
					
                    <!--- input name='userForm' id='userForm' type="hidden" value="" / --->
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
                 <form name="formExcel" action="excel.php" method = "POST">
           <input type="hidden" class="" name="export"  id='export' value=""/>
           <input type='hidden' name='nombre_archivo' value='listado_volantes'/>
           <input type = "submit" value = "Exportar a Excel" class="submit-login" />
         </form>
             </div>
             
             
              
        </div>

      </div>
      <!--- div id='p3' style="display:none" class="contOficios redonda10 todosContPasos">
            <h2>Buscar Oficio: 
            <input type="text" name="text2" id="text2" class="redonda5" size="50" onkeyup="">
            </h2>
             <div class="volLista2" id="volLista2">
             	<!-- AQUI VAN LOS RESULTADOS >
             </div>
             
            
      </div --->
</div><!-- end cont volantes -->
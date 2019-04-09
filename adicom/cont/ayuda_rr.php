<script> 


//--------------------------------------
var nextinput = 0;
var accionesNum = 0;
//--------------------------------------


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
		
		if(accionesNum <= 1)
		{
			$$("#accionesNo").html(accionesNum);
			$$("#totalNoAcciones").val(accionesNum);
			campo = '<li id="rut'+nextinput+'" class="camposLi">';
			campo += '<input type="text" size="40" class="redonda5 camposInputAcciones" id="accionVinculada_' + nextinput + '"  name="accionVinculada_' + nextinput + '" value="'+valor+'"  readonly/>';
			campo += '<input type="hidden" size="5" class="redonda5 camposInputEstados" id="accionEstado"  name="accionEstado" value="'+estado+'"  readonly/>';		
			campo += '<span class="eliminarInput" onclick="elimina_me(\'rut'+nextinput+'\')"> &nbsp; </span>';
			campo += '<span>'+estadoTxt+'</span>';
			campo += '</li>';

			//----------- agregamos ACCIONES A CAMPO OCULTO PARA MANIPULAR --------
			$$("#totalAcciones").val(totalAcciones.concat(valor+"|"));
			//----------- agregamos campo y boirramos value de accion -------------
			$$("#camposAcciones").append(campo);
		}else{
			alert("Solo introduzca una acción...");	
		}
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


//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function sol_ayuda()
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
					$$('#btnEnviar').prop("disabled",true);
					$$('#btnEnviar').val("Generando Ticket...");
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/ayuda.php",
				//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
				data: $$("#ayudaForm").serialize(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//generamos ultimo ID
					//alert(datos);
					new mostrarCuadro(250,500,"Ticket Generado...",150)
					$$("#cuadroRes").html(datos);

					// campos en blanco
					$$(".redonda5").val("");
					$$("#camposAcciones").html(""); 
					//------------ reiniciamos conteo de acciones -------------
					$$("#totalNoAcciones").val("0"); 
					accionesNum = 0;

					$$('#btnEnviar').prop("disabled",false);
					$$('#btnEnviar').val("Solicitar Ayuda");				
				}
			});
		}//end estados
	//end confirm
}

//------------------------------- AUTOCOMPLETE ACCION --------------------------------
//---------------------------------------------------------------------------
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
						url: "procesosAjax/rr_oficios_buscaAccion.php",
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
		
		/*if (ui.item.estado ==2) {
		 $$("select[name='tipoOficio'] option[value='asistencia']").show();
		 		$$("#remitente").attr('readonly',false);
				$$("#cargo").attr('readonly',false);	 
				$$("#dependencia").attr('readonly',false);	 
 }
		 
		 if (ui.item.estado ==5) {
		 $$("select[name='tipoOficio'] option[value='notificacionEF']").show(); 
		 $$("select[name='tipoOficio'] option[value='notificacionICC']").show(); }


		 if (ui.item.estado ==6) {
		 $$("select[name='tipoOficio'] option[value='remisionUAA']").show(); }*/


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
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------

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
.opciones{ display:none}
</style>

<link href="css/estilos_medios.css" rel="stylesheet" type="text/css" media="all" />

<div style="padding:10px">
    <!-- <div id='colorSelector'>hola</div> -->

        
        <form name="ayudaForm" id="ayudaForm" method="post" action="#">
        
        
                <div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                                  <tr>
                    <td class="etiquetaPo" width="100"> <p>Agregar Recurso:</p></td>
                    <td>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="40"  style="float:left;" > <span id="idLoad" style="float:left; padding:0 5px"></span>
                    </td>
                  </tr>
                    
                                 
                 <tr>
                    <td class="etiquetaPo" width="100" hidden="true"> <p>Tipo de ayuda:</p></td>
                    <td>
                  <input type="text" name="tipoayuda" id="tipoayuda"  value="mrr" hidden="true"  >
                    </td>
                  </tr>
                       <td class="etiquetaPo" width="100" > <p>Asunto:</p></td>
                        <td>
                          <textarea cols="100" rows="5"  class="redonda5" id='asunto' name='asunto' onKeyDown="contador(this.form.asunto, 'new_cuenta', 200)" onKeyUp="contador(this.form.asunto, 'new_cuenta', 200)"></textarea>
                          <br />
                           Le restan <span style="font-weight:bold" id='new_cuenta'>200</span> caracteres.</td>
                        </td>
                      </tr>
                      
                                  <tr>
            	<td colspan="3" align="center">

                <input name='userForm' id='userForm' type="hidden" value="" />
                <input name='dirForm' id='dirForm' type="hidden" value="" />
                <input type="button" class="submit-login" value="Solicitar Ayuda" id="btnEnviar" onclick="sol_ayuda()" />
                </td>
            </tr>

                    </table>
                  
                </div>

                

                   <div  id="camposAcciones" >
                   <h3>Recurso Vinculado <span id="accionesNo">0</span> </h3>
                   
              		</div>
                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="40" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="40" class="redonda5">
              </td>
            </tr>
            <tr>
            	<td width="40%">
                <div>
                
                                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="40" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="40" class="redonda5">
</div>
                </td>
                <td width="50%" valign="top">
                <!--
                	celdas vacias
                -->
                </td>
            </tr>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
        

     
      <!-- ---------------------------------------------------------------------------- -->
     
      
</div><!-- end cont
 volantes -->
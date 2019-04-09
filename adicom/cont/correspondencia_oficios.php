<link rel="stylesheet" href="css/estilos_opiniones.css" type="text/css" media="screen" title="default" />

<script> 
$$(function() {
	$$( "#fechaPO" ).datepicker({
		// dateFormat: formatoFecha,
		 //defaultDate: "+1w", //mas una semana
		 numberOfMonths:1,	  //meses a mostrar
		 showAnim:'slideDown',
		 maxDate: 0,
		 beforeShowDay: noLaborales
		 /*onClose: function( selectedDate ) 
		 { 
			$$( "#acuseCral" ).datepicker( "option", "minDate", selectedDate );  
		 }*/
	});
});

function muestraPestanaVol(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	
	if(divId == 2){
		$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista").load("procesosAjax/opiniones_oficio_busca.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 3){
		$$('#volListaOtros').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volListaOtros").load("procesosAjax/opiniones_oficio_busca_otros.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
	} 
	if(divId == 4){
		$$('#volLista2').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
  		$$("#volLista2").load("procesosAjax/opiniones_oficio_busca_2013.php",{direccion:"<?php echo $_SESSION['direccion'] ?>",usuario:"<?php echo $_SESSION['usuario'] ?>",nivel:"<?php echo $_SESSION['nivel'] ?>"});
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
	//var mut_edos = document.oficioForm.elements["accionEstado[]"];
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
function agregarCampos(valor,estado,estadoTxt,oficioEF,oficioICC,oficioAS,monto)
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
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------

function generarOficio()
{
 var datosUrl = $$("#oficioForm").serialize();
 
	 if(comprobarFormulario('oficioForm'))
	{
	
			//-------------------------------------------------------
			$$.ajax
			({
				beforeSend: function(objeto)
				{
					$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$$('#generaOficio').attr("disabled",true);
					$$('#generaOficio').val('Generando Correspondencia...');
					$$('#generaOficio').css( "background", "gray" );
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/correspondencia_oficio_genera.php",
				//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
				data: $$("#oficioForm").serialize(),
										direccion:$$('#indexDir').val(),

error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				//success: function(datos)
			
				{ 
					var dat = datos.split("|");
					caja= dat[2];
					usuario = dat[4];
					accion = dat[3];
					
						
					
					var urlCadena = "caja="+caja+"&usuario="+usuario+"&accion="+accion; 


										alert(urlCadena);
				//"na="+acc+"&po="+po+"&cp="+cp+"&ef="+ef+"&mm="+mm+"&ua="+ua+"&dir="+dir+"&car="+car+"&nRe="+nRe+"&cRe="+cRe+"&dRe="+dRe+"&fOf="+fOf+"&foj="+foj+"&fSi="+fSi+"&hSi="+hSi+"&ini="+ini+"&folioef="+folioef+"&gobernador="+gobernador+"&cargo="+cargo+"&fechaofi="+fechaofi+"&folioicc="+folioicc+"&fechaofiicc="+fechaofiicc+"&acuse="+acuse+"&titular="+titular+"&cargoicc="+cargoicc;//
					
					//vemos q tipo de oficio es y que mostrar en el cuadro
					
						//mostramos cuadro donde se insertara el html en el id 'cuadroRes'
						//new mostrarCuadro(200,500,"Oficio generado ",150)
						new mostrarCuadro(550,900,"Oficio generado",20)
						$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/volante.pdf.php?"+urlCadena+"'></iframe>");
					

					// ------------------ RESET campos en blanco --------------
					$$(".redonda5").val("");
					$$("#camposAcciones").html(""); 
					//------------ reiniciamos conteo de acciones -------------
					$$("#totalNoAcciones").val("0"); 
					accionesNum = 0;
					//---------------------------------------------------------
					$$('#generaOficio').attr("disabled",false);
					$$('#generaOficio').val('Generar Correspondencia');
					$$('#generaOficio').css( "background", "#333" );
				}
			});
		//end estados
	}//end confirm
}	

//------------------------------- AUTOCOMPLETE ACCION --------------------------------


//---------------------------------------------------------------------------

//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
{
	
	 // configuramos el control para realizar la busqueda de los productos
	 $$("#accionvolante").autocomplete({
	  //source: "procesosAjax/opiniones_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/correspondencia_oficios_buscaAccion.php",
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
		
		if (ui.item.estado ==100) {
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


		agregarCampos(ui.item.value,ui.item.estado,ui.item.estadoTxt,ui.item.ofiEF,ui.item.ofiICC,ui.item.ofiAS,ui.item.monto);
		 
		 
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
  	$$("#volLista").load("procesosAjax/opiniones_oficio_busca.php");
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
				url: "procesosAjax/opiniones_oficio_busca.php",
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

function verOficio(tipo)
{
	new mostrarCuadro(550,900,"Oficio...",20);


		$$("#cuadroRes").html("<iframe width='100%' height='500' frameborder='0' src='formatos/formatoPM.pdf.php?consultaOficio=1'></iframe>");
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
<link href="css/estilos_administracion.css" rel="stylesheet" type="text/css" media="all" />

<div id="pagAdministracion" style="padding:10px">
    <!-- <div id='colorSelector'>hola</div> -->




	<div class="encVol">
      <div id='paso1' onclick="muestraPestanaVol(1)" class="todosPasos pasosActivo pasos"> GENERAR CORRESPONDENCIA </div>
    </div>
    
    <div id='p1' class="contOficios redonda10 todosContPasos">
        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="oficioForm" id="oficioForm" method="post" action="#" 
        
        
        
        
         >
        
        <table width="100%" align="center">
        <tr>
        	<td width="30%">
                <div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  </tr>
                     <tr>
                    <td class="etiquetaPo" width="100"> <p>Agregar Acción:</p></td>
                    <td>
                      <input type="text" name="accionvolante" id="accionvolante" class="redonda5" size="35"  style="float:left;" > <span id="idLoad" style="float:left; padding:0 5px"></span>
                    </td>
                  </tr>

                    </td>
                  </tr>

                
                <?php ?>
                
                 <tr>
                    <td class="etiquetaPo" width="100"> <p>Piso:</p></td>
                    <td>
                      <select name="num_piso" id="num_piso" class="redonda5">
                      <optgroup label="">
                            	
                                <option value="">Seleccione piso...</option>
                                <option value="siete">- Siete</option>
                                <option value="ocho">- Ocho</option>
                                <option value="nueve">- Nueve</option>
                                
                        
                             <?php
							 /*
							 $sql=$conexion->select("SELECT * from usuarios where usuario='".$_SESSION['usuario']."'", false); 
							 $r=mysql_fetch_array($sql);
							 
							 if( $r['otros_po'] == 1) { ?>
                             	<option value="otros">Otros Oficios</option> 
                             <?php } 
							 */?>
                      </select>
                    </td>
                  </tr>
                </div>
                                
                <td class="etiquetaPo" width="100"> <p></p></td>
            <td valign="top"   class="txtInfo">
           
           <form name="fckecked">
            <script src="../js/ajax.js" type="text/javascript"></script>
				<?php
				$sqlcheck = $conexion->select("Select * from correspondencia where envia != '' And num_accion Like '%".$accion."%' ",false);
				$corres = mysql_num_rows($sqlcheck);
				$guarda = mysql_fetch_array($sqlcheck);
				$deschek = explode ("|",$guarda['envia']);
				if($corres == 1){$guarda1 = $guarda2 = "";}
				
				if ($deschek[0] == "Tramite" || $deschek[1] == "Tramite" || $deschek[2] == "Tramite") $exp_tram = 'checked="checked"';
				if ($deschek[0] == "Tecnico" || $deschek[1] == "Tecnico" || $deschek[2]== "Tecnico") $exp_tec = 'checked="checked"';
				?>
                               
            <input type="checkbox" name="tramite" id="tramite" <?php echo $exp_tram ;?> <?php echo $guarda1;?> >
            <label for="tramite">Expediente  de  Tramite</label> <br>
              
            <input type="checkbox" name="tecnico" id="tecnico" <?php echo $exp_tec;?> <?php echo $guarda2;?> >
            <label for="tecnico">Expediente Técnico</label>
               
               <?php if ($corres == 0) { ?>
      		   <?php }?>
            </form>


                            
               </td>
                
            	<div>
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="100"><p>Tomo:</p></td>
                      
                    <td >
                        <input type="text" name="num_tomo" id="num_tomo" size="35" class="redonda5" value""  >
                        <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5" > -->
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Caja:</p></td>
                    <td>
                      <input type="text" name="num_caja" id="num_caja" size="35" class="redonda5" >
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
            	<td >
					<div>
                     <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
                      <tr>
                        <td> <p> </p></td>
                        <td>
                           
                        </td>
                      </tr>
                        <td><p> </p></td>
                        <td>
                     
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
                <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
                <input type="button" class="submit-login" value="Generar Oficio" onclick="generarOficio()" id="generaOficio" />
                </td>
            </tr>
        </table>
        
        
        </form>
      </div><!-- end cont vol1 volantes -->
      <!-- 
            

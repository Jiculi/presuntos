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

$sql = $conexion->select("SELECT * FROM usuarios WHERE direccion = '".$r['direccion']."' AND NOT LENGTH(nivel) < 2 order by nombre",false);
$totalA = mysql_num_rows($sql);

$accion = str_replace("|","",$r['accion']);

$sqlx = $conexion->select("SELECT abogado FROM po WHERE num_accion = '".$accion."' ",false);
$abogado = mysql_fetch_array($sqlx);
$abogado = $abogado['abogado'];

?>

<script> 
$$( document ).ready(function() {
	$$( "#abogadoA" ).focus();
});
//------------------------------- GUARDA Y GENERA VOLANTES --------------------------------
function asignarAccion()
{
	if(comprobarForm('asignaForm'))
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
			url: "procesosAjax/vol_asigna_volantes.php",
			//data: "funcion=nuevo&hora="+$$('#hora_cambio').val()+"&fecha="+$$('#fecha_cambio').val()+"&usuario="+$$('#usuarioActual').val()+"&num_accion="+$$('#num_accion').val()+"&idPresunto="+$$('#creacion').val()+"&servidor="+$$('#new_servidor_contratista').val()+"&cargo="+$$('#new_cargo_servidor').val()+"&irregularidad="+$$('#new_irregularidad').val()+"&monto="+$$('#new_monto').val(),
			data: {
						idVol:<?php echo $r['id'] ?>,
						folio:'<?php echo $r['folio'] ?>',
						accion:'<?php echo $r['accion'] ?>',
						direccion:'<?php echo $r['direccion'] ?>',
						abogado:$$('#abagadoAsig').val(),
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
				//new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
				//--------- recarga lista de volantes -----------------------
				if(datos == "ok")
				{
					$$('#volLista').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					$$("#volLista").load("procesosAjax/vol_busca_volantes.php");
					cerrarCuadro();
				}
				else alert(datos);
			}
		});
	}
}
//---------------------------------------------------------------------------------------------------
//------------------------------- AUTOCOMPLETE ACCION --------------------------------
$$(function() 
		{
		 // configuramos el control para realizar la busqueda de los productos
		 $$("#abogadoA").autocomplete({
		  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
				source: function( request, response ) {
						$$.ajax({
							type: "POST",
							url: "procesosAjax/vol_busqueda_abogado.php",
							dataType: "json",
							data: {
								term: request.term,
								direccion:'<?php echo $r['direccion'] ?>'
							},
							success: function( data ) {
								response(data);
			  //muestraListados();
							}
						});
				 },
			  // minLength: 2,
		   select: 
		   function( event, ui ) 
		   {  
			//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
			$$("#direccionA").val(ui.item.direccion);
			//$$("#dependenciaE").val(ui.item.dependencia);
			//$$("#oficioE").focus();
			
		  }
			});//end
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


<div>
    <!-- <div id='colorSelector'>hola</div> -->

        <!--<h3 class= "poTitulosPasos">Generar Volante</h3>-->
        
        <form name="asignaForm" method="post" action="#">
        
        <table width="90%" align="center">
        <tr>
        	<td width="50%">
            	<div class="volDivCont redonda5">
            	<table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
                  <tr>
                    <td  class="etiquetaPo" width="195"><p>Folio:</p></td>
                      
                    <td >
                        <input type="text" name="folioA" id="folioA" size="35" class="redonda5 camposEditar" value="<?php echo $r['folio'] ?>" readonly="readonly" >
                    </td>
                  </tr>
                  <tr>
                    <td class="etiquetaPo">  <p>Accion:</p></td>
                    <td>
                      <input type="text" name="accionA" id="accionA" size="35" class="redonda5 camposEditar" value="<?php echo $r['accion'] ?>" readonly="readonly">
                    </td>
                  </tr>
                  </table> 
                  </div>
              </td>
              
              <td width="50%">
                   <div class="volDivCont redonda5">
                    <table align="center" width="100%" border="0" class="tablaPasos tablaVol"> 
                     <?php if($abogado != "") { ?> 
                     <tr>
                     	<td class="etiquetaPo" width="200">Asignación:</td>
                        <td><?php echo $abogado; ?></td>
                     </tr>  
                     <?php } else {?>  
                     <tr>
                     	<td colspan="2" align="center"> <b>Sin Asignar ...</b></td>
                     </tr>  
                     <?php } ?>                     
                     
                                        
                    <tr>
                        <td class="etiquetaPo" width="200"><p>Abogado:</p></td>
                        <td>
                          <select name='abagadoAsig' id='abagadoAsig' class="redonda5">
                          <option value="" >Seleccione un abogado...</option>
                          	<?php
								while($a = mysql_fetch_array($sql))
								{
									echo "<option value='".$a['nombre']."|".$a['nivel']."'>".$a['nombre']."</optiopn>";	
								}
							?>
                          </select>
                          </td>
                      </tr>
                        <tr>
                          <td class="etiquetaPo">&nbsp; </td>
                          <td>&nbsp; </td>
                        </tr>
                     </table>
              		</div>
              </td>
            </tr>
            </tr>
            <tr>
            	<td colspan="3" align="center">
                    <table width="40%">
                    <tr>
                    	<input type="hidden" name="folioE" id="folioE" class="" size="25" readonly="readonly" value="<?php echo $r['folio'] ?>">
                        <input type="hidden" name="dirVol" id="dirVol" class="" size="25" readonly="readonly" value="<?php echo $r['direccion'] ?>">
                        <input type="hidden" name="idVolE" id="idVolE" class="" size="25" readonly="readonly" value="<?php echo $r['id'] ?>">
                        <!-- <td align="center"><input type="button" class="submit-login camposEditar" value="Modificar Volante" onclick="modificarVolante('modifica')" /></td> -->
                       
                        <td align='center' id='cancelaVol'><input type='button' class='submit-login camposEditar' value='Asignar Acción' onclick='asignarAccion()' /></td>
                        <td align='center' id="recibeVol"></td>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        
        </form>

</div><!-- end cont volantes -->
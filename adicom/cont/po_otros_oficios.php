<script>
$$(function() 
{
	// configuramos el control para realizar la busqueda de los productos
	$$("#txtNoAccion").autocomplete({
		//source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= "	/* este es el formulario que realiza la busqueda */
        source: function( request, response ) {
                $$.ajax({
                    type: "POST",
                    url: "procesosAjax/po_buscar_accion_otros_oficios.php",
                    dataType: "json",
                    data: {
                        term: request.term,
						direccion: "<?php echo $_SESSION['direccion'] ?>"
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
				//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value );
				muestraContenidoOficios(ui.item.label);
			}
    });//end
});

function muestraContenidoOficios(accion)
{
	 $$.ajax({
		type: "POST",
		url: "procesosAjax/po_muestra_otros_oficios.php",
		data: {
			accion: accion
		},
		//data: "user="+$$('#user').val()+"&pass="+$$('#pass').val(),
		error: function(objeto, quepaso, otroobj)
		{
			alert("Estas viendo esto por que fallé");
			alert("Pasó lo siguiente: "+quepaso);
		},
		success: function( data ) {
			//response(data);
			$$("#noAccion").html("Oficios de la acción \""+accion+"\"");
			$$("#contOtrosOficios").html(data);
		}
	});
}

</script>


<FORM style="margin:20px 0"  onsubmit="return false">
    <h2>Acción: 
    <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
    <input type="text" name="txtNoAccion" id="txtNoAccion" class="redonda5" size="50"/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span id='resTotal' style="display:inline-block"></span>
    </h2>
</FORM>
<h3 id='noAccion'></h3>
<div id="contOtrosOficios">
</div>

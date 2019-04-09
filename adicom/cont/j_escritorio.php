<link rel="stylesheet" href="css/estilos_pfrr.css" type="text/css" media="screen" title="default" />
<div id="contPFRR">
<script>
 function buscaAccion(limit)
 {
	divres = document.getElementById('resAcciones');
	divtot = document.getElementById('resTotal');
	accion = document.getElementById('noAccion').value;
	direccion = document.getElementById('direccion').value;
	if(limit == "" || limit == undefined) limit = "";
	//if(accion.length > 1)
	//{
		divres.innerHTML = '<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>';
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/i_busqueda_accion.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				txt = ajax.responseText.split("-|-");
				var accionesTabla = txt[0];
				var accionesNum = txt[1];
				var paginacion = txt[3];
				
				if(accionesNum > 500) {
					var desde = 500;
					var hasta = 500;
					
					selector = '<select name="limit" id="limit" class="redonda5" onchange="buscaAccion(this.value)">';
					selector += '<option value="" selected="selected">Número de Página</option>';
					//alert(paginacion);
	
					for(i=1; i<=paginacion; i++ ) {
						desde = hasta - 499;
						selector += '<option value="limit '+desde+','+hasta+'" >Página '+i+'</option>';
						hasta = hasta + 500;
					}
					
					selector += '</select>';

					$$('#selector').html(selector);
					$$('#paginacion').slideDown();
					
					
				}
				if(accionesNum < 500 ){
					$$('#paginacion').slideUp();
				}				
				
				
				
				divres.innerHTML = accionesTabla;
				divtot.innerHTML = "<h3>"+accionesNum+" Accion(es) Encontrada(s)</h3>";
			}
		}
		//muy importante este encabezado ya que hacemos uso de un formulario
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//enviando los valores
		ajax.send("valor="+accion+"&direccion="+direccion+"&limit="+limit);
		//ajax.send("idempleado="+id+"&nombres="+nom+"&departamento="+dep+"&sueldo="+suel)
	//}
 }
 //------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
 $$(document).ready(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	buscaAccion();
	/*
	$$.ajax
		({
			beforeSend: function(objeto)
			{
			 $$('#resAcciones').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/i_busqueda_accion.php",
			data: "",
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//$$('#resAcciones').html(datos); 
				divres = document.getElementById('resAcciones');
				divtot = document.getElementById('resTotal');
				txt = datos.split("-|-");
				divres.innerHTML = txt[0];
				divtot.innerHTML = "<h3>"+txt[1]+" Accion(es) Encontrada(s)</h3>";
			}
		});
		*/
    });
</script>

<!--  start content-table-inner -->
<div id="content-table-inner">


<!--  start product-table ..................................................................................... -->
<!-- ------------- TABLA DE RESULTADOS ------------->
<!-- ------------- aqui entran las llamadas ajax ------------->
<div class="conTabla">
    <div class="encTabla">

<FORM onsubmit="return(false)" onkeypress="if(event.keyCode == 13) buscaAccion()">
    <h2>Juicios Nulidad </h2>
    <h3>Buscar Acción: 
        <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
        <input type="text" name="noAccion" id="noAccion" class="redonda5" size="50" onkeyup="buscaAccion()"   onkeypress="if(event.keyCode == 13) buscaAccion()"/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id='resTotal' style="display:inline-block"></span>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id='resTotal' style="display:inline-block"></span>
    	<span style="float:right;display:inline-block; display:none" id="paginacion">
        	<span style="padding:3px 0 0 0">Mostrar página: </span>
            <span id='selector'> </span>
        </span>    
    </h3>
</FORM>
    
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>
                <th style="width:100px"><a href="#">Procedimento</a>	</th>
				<th style="width:100px"><a href="#">Acción</a>	</th>
                <th style="width:100px"><a href="#">Entidad Fiscalizada</a></th>
                <th style="width:50px"><a href="#">Direccion</a></th>
                <th style="width:50px"><a href="#">P Resp</a></th>
                <th class="ancho200"><a href="#">Control Interno</a></th>
                <th class="ancho100"><a href="#">Seguimiento</a></th> 
            </tr>
        </thead>
        </table>
    </div>
    <div id='resAcciones' class='resAcciones bodyTabla scrollAcciones scroll-pane'></div>
    
</div>
<!--  end content-table  -->

<!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
<div id="related-activities">
    

<!-- INCLUIMOS NOTIFICACONES -->    
<?php 
	require_once("cont/po_notificaciones.php");
?>
<!-- INCLUIMOS NOTIFICACONES -->

</div>
<!-- end related-activities -->

<div class="clear"></div>
</div>
<!--  end content-table-inner  -->
<div class="clear"></div>
</div>
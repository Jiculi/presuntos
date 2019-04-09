<script>
function buscaAccion(limit)
{
	if(limit == "" || limit == undefined) limit = "";
	divres = document.getElementById('resAcciones');
	divtot = document.getElementById('resTotal');
	accion = document.getElementById('noAccion').value;
	direccion = document.getElementById('direccion').value;
	
	//if(accion.length > 1)
	//{
		divres.innerHTML = '<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>';
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/empleados_ajax.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				txt = ajax.responseText.split("||");
				
				var tablaHtml = txt[0];
				var accionesNum = txt[1];
				var paginacion = txt[2];
				var accionesBus = txt[2];
				
				divres.innerHTML = tablaHtml;
				divtot.innerHTML = "<h3>"+accionesNum+" Empleado(s) Encontrado(s)</h3>";
				
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
	
	//var alto = $$("#content").height();
	//$$("#related-activities").css("height",alto);
	$$("#conTabla2").slideUp();
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
			url: "procesosAjax/empleados_ajax.php",
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
				txt = datos.split("||");
				
				var tablaHtml = txt[0];
				var accionesNum = txt[1];
				var paginacion = txt[2];
				var accionesBus = txt[2];
				
				if(accionesNum > 100) {
					var desde = 100;
					var hasta = 100;
					
					selector = '<select name="limit" id="limit" class="redonda5" onchange="buscaAccion(this.value)">';
					selector += '<option value="" selected="selected">Número de Página</option>';
					//alert(paginacion);
	
					for(i=1; i<=paginacion; i++ ) {
						desde = hasta - 99;
						selector += '<option value="limit '+desde+','+hasta+'" >Página '+i+'</option>';
						hasta = hasta + 100;
					}
					
					selector += '</select>';

					$$('#selector').html(selector);
					$$('#paginacion').slideDown();
					
					
				}
				if(accionesNum < 100){
					$$('#paginacion').slideUp();
				}
				divres.innerHTML = tablaHtml;
				divtot.innerHTML = "<h3>"+accionesNum+" Empleado(s) Encontrado(s)</h3>";
			}
		});
});
</script>

<link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />

<!--  start content-table-inner ->
<div id="content-table-inner">

<!-- ------------- TABLA DE RESULTADOS ------------->
<!-- ------------- aqui entran las llamadas ajax ------------- >
<div class="conTabla" >

<!--  start product-table ..................................................................................... -->
<div  class="redonda10" style="padding:0px 50px;background:#FFDFEF;">
</br>
<FORM onsubmit="return(false)" onkeypress="if(event.keyCode == 13) buscaAccion()">
    <h3>Buscar Empleado: 
        <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
        <input type="text" name="noAccion" id="noAccion" class="redonda5" size="50" onkeyup="buscaAccion()" onkeypress="if(event.keyCode == 13) buscaAccion()"/>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span id='resTotal' style="display:inline-block"></span>
    	<span style="float:right;display:inline-block; display:none" id="paginacion">
        	<span style="padding:3px 0 0 0">Mostrar página: </span>
            <span id='selector'> </span>
        </span>
    
    </h3>
</FORM>

	
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table">
        <thead>
                <th width="60" ><a href="#">No. Empleado</a></th>
                <th width="120" ><a href="#">Nombre</a>	</th>
				<th width="120"><a href="#">Curp</a>	</th>
                <th width="30"><a href="#">Direccion</a></th>
                <th width="40"><a href="#">Subnivel</a></th>
				<th width="130"><a href="#">Puesto</a></th>
				<th width="120"><a href="#">Tipo Empleado</a></th>
				<th width="30"><a href="#">Status</a></th>
                <th width="70"><a href="#">Control Interno</a></th>
            </tr>
        </thead>
        </table>

    <div id='resAcciones' class='resAcciones bodyTabla scrollAcciones scroll-pane'></div>
</div>
 <!--   
</div>
<!--  end content-table  ->

<!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- ->
<div id="related-activities">
    

<!-- INCLUIMOS NOTIFICACONES ->    
<?php 
	//require_once("cont/po_notificaciones.php");
?>
<!-- INCLUIMOS NOTIFICACONES ->
<div class="clear"></div>
</div>
<!-- end related-activities ->
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->

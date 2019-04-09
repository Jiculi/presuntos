<script>
function buscaAccion()
{
	divres = document.getElementById('resAcciones');
	divtot = document.getElementById('resTotal');
	accion = document.getElementById('noAccion').value;
	direccion = document.getElementById('direccion').value;
	
	//if(accion.length > 1)
	//{
		divres.innerHTML = '<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>';
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/dg_busqueda_acciones_bajasAnunciadas.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				txt = ajax.responseText.split("-|-");
				divres.innerHTML = txt[0];
				divtot.innerHTML = "<h3>"+txt[1]+" Accion(es) Encontrada(s)</h3>";
			}
		}
		//muy importante este encabezado ya que hacemos uso de un formulario
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//enviando los valores
		ajax.send("valor="+accion+"&direccion="+direccion);
		//ajax.send("idempleado="+id+"&nombres="+nom+"&departamento="+dep+"&sueldo="+suel)
	//}
}
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
$$(document).ready(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
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
			url: "procesosAjax/dg_busqueda_acciones_bajasAnunciadas.php",
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
});
//----------------------------------------------------------------------------------------------------

function guardaBajas(tipo)
{
	var check = $$("input[type='checkbox']:checked").length;
	
	if(check == "")
	{
        var error =1; 
		alert("Selecciona al menos una acción.");
	}
	else	
	{
		var error=0;
		if(tipo=="bajas") var confirma = confirm("¿Desea marcar como BAJAS las acciones marcadas?");
		if(tipo=="quita") var confirma = confirm("¿Desea QUITAR como bajas las acciones marcadas?");
	}
	
	if(confirma && error == 0)
	{
		$$.ajax
			({
				beforeSend: function(objeto)
				{
				 //$$('#resAcciones').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
				 //alert('hola');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar \n - Exito = "+exito)
					//if(exito=="success"){ alert("Y con éxito");	}
				},
				type: "POST",
				url: "procesosAjax/dg_genera_bajasAnunciadas.php",
				data: $$("#mainform").serialize()+"&tipo="+tipo,
				error: function(objeto, quepaso, otroobj)
				{
					//alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
					//alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{
					buscaAccion(); 
					new mostrarCuadro(300,500,"Bajas Anunciadas",100);
					$$("#cuadroRes").html(datos);
				}
			});
	}
}

</script>

<!--  start content-table-inner -->
<div id="content-table-inner">

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr valign="top">
<td>

<!--  start product-table ..................................................................................... -->
<FORM onsubmit="return(false)" onkeypress="if(event.keyCode == 13) buscaAccion()">
    <h3>Buscar Acción: 
    <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
    <input type="text" name="noAccion" id="noAccion" class="redonda5" size="50" onkeyup="buscaAccion()" onkeypress="if(event.keyCode == 13) buscaAccion()"/>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span id='resTotal' style="display:inline-block"></span></h3>
</FORM>
<!-- ------------- TABLA DE RESULTADOS ------------->
<!-- ------------- aqui entran las llamadas ajax ------------->
<div class="conTabla">
    <div class="encTabla">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>
                <th class="ancho50"><a href="#">Marcar</a>	</th>
                <th class="accion"><a href="#">Accion</a>	</th>
                <th class="entidad"><a href="#">Entidad Fiscalizada</a></th>
                <th class="direccion"><a href="#">Direccion</a></th>
                <th class="subdirector"><a href="#">Subdirector</a></th>
                <!-- <th class="abogado"><a href="#">Abogado Responsable</a></th> -->
                <th class="estado"><a href="#">Control Interno</a></th>
            </tr>
        </thead>
        </table>
    </div>
    <div id='resAcciones' class='resAcciones bodyTabla scrollAcciones scroll-pane'></div>
    <div align="center"> 
    <br />
    	<input class="submit_line" type="button" name="Registrar" id="Registrar" value="Bajas Anunciadas" onclick="guardaBajas('bajas')">
    	<input class="submit_line" type="button" name="Registrar" id="Registrar" value="Quitar de Bajas Anunciadas"  onclick="guardaBajas('quita')">
    </div>
    
</div>
<!--  end content-table  -->
</td>
<td>
    
</td>
<td width="280">

<!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
<div id="related-activities">
    

<!-- INCLUIMOS NOTIFICACONES -->    
<?php 
	require_once("cont/po_notificaciones.php");
?>
<!-- INCLUIMOS NOTIFICACONES -->

</div>
<!-- end related-activities -->

</td>
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>

</div>
<!--  end content-table-inner  -->

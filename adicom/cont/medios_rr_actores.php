<link rel="stylesheet" href="css/estilos_medios.css" type="text/css" media="screen" title="default" />
<div id="contMEDIOS">
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
		ajax.open("post","procesosAjax/medios_rr_busqueda_actores.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				txt = ajax.responseText.split("-|-");
				divres.innerHTML = txt[0];
				divtot.innerHTML = "<h3>"+txt[1]+" Responsable(s) Encontrado(s)</h3>";
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
			url: "procesosAjax/medios_rr_busqueda_actores.php",
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
				divtot.innerHTML = "<h3>"+txt[1]+" Responsable(s) Encontrado(s)</h3>";
			}
		});
});
</script>

<!--  start content-table-inner -->
<div id="content-table-inner">
	<div class="conTabla">
        
        <!--  start product-table ..................................................................................... -->
        <FORM onsubmit="return(false)" onkeypress="if(event.keyCode == 13) buscaAccion()">
            <h2>Recurso de Reconsideración</h2>
            <h3>Buscar Responsable: 
            <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
            <input type="text" name="noAccion" id="noAccion" class="redonda5" size="50" onkeyup="buscaAccion()"   onkeypress="if(event.keyCode == 13) buscaAccion()"/>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span id='resTotal' style="display:inline-block"></span></h3>
        </FORM>
        <!-- ------------- TABLA DE RESULTADOS ------------->
        <!-- ------------- aqui entran las llamadas ajax ------------->
        <div>
            <div class="encTabla">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                <thead>
                    <tr>
                        <th class="ancho150"><a href="#">Actor</a>	</th>
                        <th class="ancho150"><a href="#">Acción</a></th>
                        <th class="ancho150"><a href="#">Recurso de Reconsideración</a></th>
                        <th class="ancho50"><a href="#">Origen</a>	</th>
                        <th class="ancho150"><a href="#">Control Interno</a></th>
                        <th class="ancho100"><a href="#">Seguimiento</a></th> 
                    </tr>
                </thead>
                </table>
            </div>
            <div id='resAcciones' class='resAcciones bodyTabla scrollAcciones scroll-pane'></div>
            
        </div>
        </div><!-- end contabla -->
        
        <!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
        <div id="related-activities">
            
        
        <!-- INCLUIMOS NOTIFICACONES -->    
        <?php 
            require_once("cont/po_notificaciones.php");
        ?>
        <!-- INCLUIMOS NOTIFICACONES -->
        
        </div>
        <!-- end related-activities -->
        
        
</div>
<!--  end content-table-inner  -->

</div>
<?php
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];
?>
<script>

function $(id){
    return document.getElementById(id);    
}

function muestraComportamiento()
{
	//setTimeout(function(){  $$("#cuadroRes").html('<img src="images/load_bar" alt="blank" />');  }, 3000);
	new mostrarCuadro(600,1000,"Comportamiento Diario ",20," "," "); 
	
	$$("#cuadroRes").html("<center> <div id='load'> <h3> Cargando Reporte por favor espere... </h3> <img src='images/load_bar.gif'><br> (Este reporte puede demorar varios segundos) </div> <iframe id='marco1' src='reportes2/comportamiento.pdf.php' width='100%' height='530'  style='display:none'></iframe>");
	$$('#marco1').load(function() {
	 	$$('#load').css('display','none')
	 	$$('#marco1').css('display','block')
	});
	/*
	var asignar=setInterval(function(){
		if($('marco1')){
			if(window.ActiveXObject){
				$('marco1').onreadystatechange=function(){
					if($('marco1').readyState=='complete'){
						   alert('cargó');
					}
				}
				clearInterval(asignar);
				return;
			}
			$('marco1').onload=function(){
				alert('cargó');
			}
			clearInterval(asignar);
		}
	},10);
	*/
	
}
</script>
<!--  start content-table-inner -->
<div id="content-table-inner">


<table border="0"   height="400px" width="100%" cellpadding="0" cellspacing="0" >
<tr valign="top">
<td>
<!--  ICONOS ..................................................................................... -->
<div class='contEspacio'>
	<!--
	<div class="iconos iconAzul redonda10" onclick='var cuadro1 = new mostrarCuadro(600,1000,"PO Comportamiento CP2013",10,"reportes/comportamientoDiarioPoObs2013.index.php","direccion=<?php echo $direccion ?>")'> <a href="#"> <img src="images/chart128.png" alt="blank" /> <span>PO Comportamiento CP2013</span> </a></div>
	
    <div class="iconos iconAzul redonda10" onclick='var cuadro1 = new mostrarCuadro(600,1000,"PO Comportamiento CP2013",10,"reportes/comportamientoDiarioPoObs2014.index.php","direccion=<?php echo $direccion ?>")'> <a href="#"> <img src="images/chart128.png" alt="blank" /> <span>PO Comportamiento CP2014</span> </a></div>
    
        
    <div class="iconos iconAzul redonda10" onclick='var cuadro1 = new mostrarCuadro(600,1000,"PO Comportamiento CP2013",10,"reportes/comportamientoDiarioPoObs2015.index.php","direccion=<?php echo $direccion ?>")'> <a href="#"> <img src="images/chart128.png" alt="blank" /> <span>PO Comportamiento CP2015</span> </a></div>
	
    <td>
    <div class="iconos iconAzul redonda10" onclick='var cuadro2 = new mostrarCuadro(600,1000,"PO Notificaciones CP2012",10,"reportes/poNotificaciones.index.php","direccion=<?php echo $direccion ?>")'> <a href="#"> <img src="images/doc_notify.png" alt="blank" /> PO Notificaciones CP2012 </a></div></td>
	

    <td>
    <div class="iconos iconAzul redonda10" onclick='var cuadro2 = new mostrarCuadro(600,1000,"PO Notificaciones CP2013",10,"reportes/poNotificaciones2013.index.php","direccion=<?php echo $direccion ?>")'> <a href="#"> <img src="images/doc_notify.png" alt="blank" /> <b>PO Notificaciones CP2013</b> </a></div>
	</td>
---->
   <tr><td>
	<div class="iconos iconVerde redonda10" onclick='var cuadro2 = new mostrarCuadro(600,1000,"PFRR Comportamiento Diario",10,"reportes/comportamientoDiario.index.php","direccion=<?php echo $direccion ?>")'>  <a href="#"> <img src="images/iconoTabla.png" alt="blank" /> <span>PFRR Comportamiento Diario</span> </a></div></td></tr>

<!--
   <tr><td>
	<div class="iconos iconVerde redonda10" onclick='var cuadro2 = new mostrarCuadro(600,1000,"PFRR Comportamiento Diario",10,"reportes/MetasPos.index.php","direccion=<?php /*echo $direccion*/ ?>")'>  <a href="#"> <img src="images/iconoTabla.png" alt="blank" /> <span>Metas</span> </a></div></td></tr>
-->

	<!-- <div class="iconos redonda10" onclick='muestraComportamiento()'> <a href="#"> <img src="images/iconoTabla.png" alt="blank" /> <span>Comportamiento Diario PFRR</span> </a></div>  
<!--  end content-table  -->
</div>
</td>
<!--
<td width="280">

<!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
<!--<div id="related-activities">

<?php 
	//require_once("cont/po_notificaciones.php");
?>

</div>
<!-- end related-activities -->
<!--
</td>
-->
</tr>
<tr>
<td><img src="images/shared/blank.gif" width="695" height="1" alt="blank" /></td>
<td></td>
</tr>
</table>

</div>
<!--  end content-table-inner  -->

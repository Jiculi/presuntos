<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");

$conexion = new conexion;
$conexion->conectar();

//-------------------------- VARIABLES GLOBALES -----------------------------
$direccion = $_REQUEST['direccion'];
$sessusu = $_REQUEST['usuario'];


//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$empusu = valorSeguro($_REQUEST['emp']);
$empid = valorSeguro($_REQUEST['id']);
$jn = valorSeguro($_REQUEST['juicio']);

$txtsql="SELECT * FROM juicios where id = $jn";
$r2= $conexion->	select($txtsql);
$r = mysql_fetch_array($r2);	

?>

<script>
$$(function() {
//------Se despliega calendario para colocar fecha de tribunal
	
//------Se despliega calendario para colocar fecha conclusión
	$$( "#fnot" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });			
	
//------Se despliega calendario para colocar fecha notificación
	$$( "#venc" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });		
	
	
	
});
//////////------ Envia datos
$$(document).ready(function(){

	$$("#actreg").click(function()
			{
				
						var datosUrl = $$("#modifica").serialize();
		
			var confirma = confirm('Se modificará el registro de:\n\n - <?php echo $r['nojuicio']; ?> - \n\n ¿Desea continuar?');
			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
					//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/juicios_modifica_0.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadro();
					}
				});
			} //Fin de if confirma
	});
});
</script>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/estilos_jui.css" type="text/css" media="screen" title="default" />


<title>ejec_amparo</title>

<div align="center" class='tablaInfo'>

	<form id="modifica" name= "modifica">

		<table width="100%" align="center">
          <tr>
            <td><p class="etiquetaInfo redonda3">Actor</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['actor']; ?>" size="25" id="actor" name="actor"/></td>
          </tr>
		  
		  
		  
          <tr>
            <td><p class="etiquetaInfo redonda3">Sala del conocimiento</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php
			 
					   
			    echo $r['salaconocimiento']; ?>"
                
                
                
                 size="25" id="sala" name="sala"  /> </td>
          <td><p class="etiquetaInfo redonda3">Juicio de Nulidad</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['juicionulidad']; ?>" size="25" id="jnu" name="jnu"/></td>
          </tr>
          
          
           
          <tr>
            <td><p class="etiquetaInfo redonda3">Fecha de Notificación</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['fechanot']); ?>" size="25" id="fnot" name="fnot"/></td>
          
          
          
          <tr>		 
           <td><p class="etiquetaInfo redonda3">Vencimiento fatal</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['vencimiento']); ?>" size="25" id="venc" name="venc" readonly /> </td>
          </tr>
          
                  
          <tr>
		  <td><p class="etiquetaInfo redonda3">Monto</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['monto']; ?>" size="25" id="monto" name="monto"/></td>
         
         
                 
          
              

        
          
          
           


           <tr>
           <td colspan="4" align="center"><br />
             <input type="hidden" value="<?php echo $r['id']; ?>" id="empid" name="empid"/>
             <input type="hidden" name="nom" id="nom" value="<?php echo $rs['nombre']; ?>" />
             <input type="hidden" name="tipoForm" id="tipoForm" value="actreg" />
             <input type="button" class="submit_line" name="actreg" id="actreg" value="Actualizar registro" />
             </br>
           </br></td>
         </tr>
		</table>

	</form>

</div>
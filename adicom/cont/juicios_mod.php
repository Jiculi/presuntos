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
	$$( "#pre_tribunal" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
//------Se despliega calendario para colocar fecha de ejecutoria
	    	$$( "#ejecutoria" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
//------Se despliega calendario para colocar fecha de ampliacion
	    	$$( "#fecha_ampliacion" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
//------Se despliega calendario para colocar fecha de notificacion de ejecutoria
	    	$$( "#not_ejec" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
//------Se despliega calendario para colocar fecha de alegatos
	$$( "#fecha_alegatos" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });

//------Se despliega calendario para colocar fecha de ejecucion en amparo
	$$( "#ejec_amparo" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
	
//------Se despliega calendario para colocar fecha de notificacion de amparo
	$$( "#not_amparo" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });	
	
//------Se despliega calendario para colocar fecha de sentencia
	$$( "#fecha_sentencia" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	
//------Se despliega calendario para colocar fecha de notificacion de sentencia
	$$( "#not_sentencia" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });	
	
//------Se despliega calendario para colocar fecha de cumplimiento
	$$( "#cumplimiento" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });		
	
//------Se despliega calendario para colocar fecha notificacion de cumplimiento
	$$( "#notica_cumpl" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });		
	
	
//------Se despliega calendario para colocar fecha presentacion RF
	$$( "#prese_RF" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });		
	
	
//------Se despliega calendario para colocar fecha conclusión
	$$( "#conclusion" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });			
	
//------Se despliega calendario para colocar fecha notificación
	$$( "#notificacion" ).datepicker({
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
				
						var datosUrl = $$("#modificausu").serialize();
		
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
					url: "procesosAjax/juicios_modifica.php",
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

	<form id="modificausu" name= "modificausu">

		<table width="100%" align="center">
          <tr>
            <td><p class="etiquetaInfo redonda3">Oficio de Contestación</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_contestacion']; ?>" size="25" id="of_contesta" name="of_contesta"/></td>
            <td><p class="etiquetaInfo redonda3">Comparencia</p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['comparecencia']; ?>" size="25" id="comp" name="comp"/></td>
          </tr>
		  
		  
		  
          <tr>
            <td><p class="etiquetaInfo redonda3">Fecha  Al Tribunal</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php
			 
			  if($r['fecha_pre_tribunal'] == '0000-00-00'){ 
			  
			  echo "";
			  }
			   else
	{		   
			    echo fechaNormal($r['fecha_pre_tribunal']);} ?>"
                
                
                
                 size="25" id="pre_tribunal" name="pre_tribunal" readonly /> </td>
          <td><p class="etiquetaInfo redonda3">Sentido Ejecutoria En Rev</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['ejecutoria_revision']; ?>" size="25" id="ejec_rev" name="ejec_rev"/></td>
          </tr>
          
          
           
          <tr>
            <td><p class="etiquetaInfo redonda3">Oficio de Ampliación</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_ampliacion']; ?>" size="25" id="of_amp" name="of_amp"/></td>
            <td><p class="etiquetaInfo redonda3">Fecha Ejecutoria en Revisión</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_ejec_rev']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_ejec_rev']); ?>" size="25" id="ejecutoria" name="ejecutoria" readonly /> </td>
          
          
          
          <tr>		 
           <td><p class="etiquetaInfo redonda3">Fecha de Ampliación</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_ampliacion']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_ampliacion']); ?>" size="25" id="fecha_ampliacion" name="fecha_ampliacion" readonly /> </td>
            <td><p class="etiquetaInfo redonda3">Notificación de Ejecutoria </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_ejec_rev']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_ejec_rev']); ?>" size="25" id="not_ejec" name="not_ejec" readonly />
			</td>
          </tr>
          
                  
          <tr>
		  <td><p class="etiquetaInfo redonda3">Oficio de Alegatos</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_alegatos']; ?>" size="25" id="of_alegatos" name="of_alegatos"/></td>
		  <td><p class="etiquetaInfo redonda3">Sentido Ejecutoria En Amparo </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['ejecutoria_amparo']; ?>" size="25" id="eje_amp" name="eje_amp"/></td>
			</td>
         
         
         <tr>
		  <td><p class="etiquetaInfo redonda3">Fecha de Alegatos</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_alegatos']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_alegatos']); ?>" size="25" id="fecha_alegatos" name="fecha_alegatos" readonly /> </td>
		  <td><p class="etiquetaInfo redonda3">Fecha  Ejecutoria En Amparo </p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_ejec_amp']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_ejec_amp']); ?>" size="25" id="ejec_amparo" name="ejec_amparo" readonly /> </td>
         
                 
         
         <tr>
		  <td><p class="etiquetaInfo redonda3">Sentencia 1ª Instancia</p></td>
          
          
          
            <td>
			<select name="sentencia_1" id="sentencia_1" class="redonda5 inputsSig" >
				<optgroup label="Sentencia 1ª Instancia">
					<option value="<?php echo $r['sentencia_primera']; ?>"><?php echo $r['sentencia_primera']; ?> ...</option>
						<option class='opciones' value="Desecha"> &nbsp; - Desecha</option>;
						<option class='opciones' value="Validez"> &nbsp; - Validez</option>;
						<option class='opciones' value="Sobreseimiento"> &nbsp; - Sobreseimiento</option>;
                        <option class='opciones' value="Nulidad para Efecto"> &nbsp; - Nulidad para Efecto</option>;
                        <option class='opciones' value="Nulidad Lisa y Llana"> &nbsp; - Nulidad Lisa y Llana</option>;						                      	</optgroup>
			</select>
			</td>
          
              

        
          
          
          <td><p class="etiquetaInfo redonda3">Notificación Amparo </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_ejec_amp']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_ejec_amp']); ?>" size="25" id="not_amparo" name="not_amparo" readonly /> </td>
            
            
                  
            <tr>
		  <td><p class="etiquetaInfo redonda3">Fecha de Sentencia</p></td>
         <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_sentencia']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_sentencia']); ?>" size="25" id="fecha_sentencia" name="fecha_sentencia" readonly /> </td>
		   <td><p class="etiquetaInfo redonda3">Sentencia en Cumplimiento</p></td>
        <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['sentencia_cumplimiento']; ?>" size="25" id="sent_cum" name="sent_cum"/></td>
			</td>
          
             
          
          
		
          <tr>
		  <td><p class="etiquetaInfo redonda3">Notificación de la Sentencia</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_sentencia']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_sentencia']); ?>" size="25" id="not_sentencia" name="not_sentencia" readonly /> </td>
		  <td><p class="etiquetaInfo redonda3">Fecha en Cumplimiento </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_sent_cumplimiento']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_sent_cumplimiento']); ?>" size="25" id="cumplimiento" name="cumplimiento" readonly /> </td>
			</td>
         
            
           
           <tr>
		  <td><p class="etiquetaInfo redonda3">Toca en Revisión</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['toca_en_revision']; ?>" size="25" id="toca_revision" name="toca_revision"/></td>
		  <td><p class="etiquetaInfo redonda3">Notificación en Cumplimiento </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_cumplimiento']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_cumplimiento']); ?>" size="25" id="notica_cumpl" name="notica_cumpl" readonly /> </td>
			</td>
           
           
           <tr>
		  <td><p class="etiquetaInfo redonda3">Fecha  Presentación de R.F. </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_rf']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_rf']); ?>" size="25" id="prese_RF" name="prese_RF" readonly /> </td>
		  <td><p class="etiquetaInfo redonda3">Estado</p></td>
           <td>
			<select name="edo" id="edo" class="redonda5 inputsSig" >
				<optgroup label="Estado">
					<option value="<?php echo $r['estado']; ?>"><?php echo $r['estado']; ?> ...</option>
						<option class='opciones' value="En contestación de Demanda"> &nbsp; - En contestación de Demanda</option>;
						<option class='opciones' value="En espera de Sentencia"> &nbsp; - En espera de Sentencia</option>;
						<option class='opciones' value="Nulidad Lisa y Llana"> &nbsp; - Nulidad Lisa y Llana</option>;
                        <option class='opciones' value="Nulidad para Efectos"> &nbsp; - Nulidad para Efectos</option>;
                        <option class='opciones' value="Validez"> &nbsp; - Validez</option>;
                        <option class='opciones' value="Sobreseimiento"> &nbsp; - Sobreseimiento</option>;						                      
						<option class='opciones' value="En espera de Ejecutoria de Amaparo"> &nbsp; - En espera de Ejecutoria  de Amparo</option>;
                        <option class='opciones' value="En espera de Ejecutoria  de Revisión"> &nbsp; - En espera de Ejecutoria  de Revisión </option>;
                        <option class='opciones' value="Concluído"> &nbsp; - Concluído</option>;
				</optgroup>
			</select>
			</td>
              
           
           <tr>
		  <td><p class="etiquetaInfo redonda3">Toca Amparo</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['toca_amparo']; ?>" size="25" id="to_amp" name="to_amp"/></td>
		  <td><p class="etiquetaInfo redonda3">Fecha de Conclusión </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_conclusion']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_conclusion']); ?>" size="25" id="conclusion" name="conclusion" readonly /> </td>
           
           
           <tr>
		  <td><p class="etiquetaInfo redonda3">Fecha de Notificación </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not']); ?>" size="25" id="notificacion" name="notificacion" readonly /> </td>
		  <td><p class="etiquetaInfo redonda3">Observaciones</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['observaciones']; ?>" size="25" id="observaciones" name="observaciones"/></td>
		  </td>
           


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
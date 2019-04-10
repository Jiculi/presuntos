<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");


//-------------------------------------------------------------------------------------------------------------------------------------------
function yyyymmdd_mmddyyyy($fecha)
{
	if(valid_mysql_date($fecha))
	{
		if($fecha != "")
		{
			$fecha_cad = explode("-",$fecha);
			$ano = $fecha_cad[0];
			$mes = $fecha_cad[1];
			$dia = $fecha_cad[2];
			
			$f_php = $mes."/".$dia."/".$ano;
			return $f_php;
			//." <b>Cambio!</b>";
		} return $f_php = "";
	} else return $fecha;//." <b>ES normal</b>";
}
//---------------------------------------------------------------------------


$conexion = new conexion;
$conexion->conectar();

//-------------------------- VARIABLES GLOBALES -----------------------------
$direccion = $_REQUEST['direccion'];
$sessusu = $_REQUEST['usuario'];
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------

$mId = valorSeguro($_REQUEST['juicioid']);

$juicio= "1/2013";  //valorSeguro($_REQUEST['juinu']);  
$mAccion= "1";   //valorSeguro($_REQUEST['mAccion']);  

//-------------------------- SENTENCIAS DE SQL ---------------------------------
//---------------------------MANDA A TRAER EL OFICIO EN CADA JUICIO-------------

$txtsql="SELECT * FROM juiciosnew where id = '$mId'";
$r2= $conexion->	select($txtsql);
$r = mysql_fetch_array($r2);	



/// para despues

$txtsql1="SELECT * FROM oficios WHERE num_accion LIKE '%$mAccion%' AND tipo ='contestacion_jn'";
$oficon= $conexion-> select($txtsql1);
$r1 = mysql_fetch_array($oficon);	


$txtsql2="SELECT * FROM oficios WHERE num_accion LIKE '%$mAccion%' AND tipo ='ampliacion_jn'";
$ofiamp= $conexion-> select($txtsql2);
$r4 = mysql_fetch_array($ofiamp);	


$txtsql3="SELECT * FROM oficios WHERE num_accion LIKE '%$mAccion%' AND tipo ='alegatos_jn'";
$ofiale= $conexion-> select($txtsql3);
$r7 = mysql_fetch_array($ofiale);	

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE CONTESTACIÓN ANTIGUOS---------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant= explode("/",$juicio);
$ofi1 = $ofiant[0];
$ofi2 = $ofiant[1];

if 
($ofi2 == '2012' || $ofi2 == '2013'|| $ofi2 == '2014'|| $ofi2 == '2015' ||$ofi2 == '2016'|| $ofi2 == '2017')
$antiguoCO = $r['oficio_contestacion']; 
else 
$antiguoCO = $r1 ['folio'];

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE AMPLIACIÓN ANTIGUOS-----------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant1= explode("/",$juicio);
$ofi2 = $ofiant1[0];
$ofi3 = $ofiant1[1];

if 
($ofi3 == '2012' || $ofi3 == '2013'|| $ofi3 == '2014'|| $ofi3 == '2015' ||$ofi3 == '2016'|| $ofi3 == '2017')
$antiguoAM = $r['oficio_ampliacion']; 
else 
$antiguoAM = $r4 ['folio'];

//----------------------------------------------------------------------------------------------------
//-------------------------- EXPLODE OFICIOS DE ALEGATOS ANTIGUOS-----------------------------------
//----------------------------------------------------------------------------------------------------
$ofiant2= explode("/",$juicio);
$ofi4 = $ofiant2[0];
$ofi5 = $ofiant2[1];

if 
($ofi5 == '2012' || $ofi5 == '2013'|| $ofi5 == '2014'|| $ofi5 == '2015' ||$ofi5 == '2016'|| $ofi5 == '2017')
$antiguoAL = $r['oficio_alegatos']; 
else 
$antiguoAL = $r7 ['folio'];


?>


<!DOCTYPE html>
<html lang="es">
<head>
    <title>juicios actaliza</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/juiciosActaliza.css" type="text/css" media="screen" title="default" >


    <script type="text/javascript" src="js/funciones.js"></script>
</head>

<body>

  <div class="seguimientoJuicios">

	<div class="navbar">
		<a href="#" class="logo">Actualización (Juicio contencioso administrativo)</a>
		<div class="navbar-right">
			<a id="actreg" href="#">Actualizar Juicio</a>
		  	<a href="javascript:cerrarCuadroJuicios()"><img src="images/cerrar.png" ></a>
		</div>
	</div>



	<div class="box_1">
	    <table >
		<tr>
			<td class="juicio-info">Acción:</td> <td>       <?php echo $r["accion"];?> </td>
		</tr>
		<tr>
		 	<td>Procedimiento:</td> <td> <?php echo $r["procedimiento"]; ?> </td>
		</tr>
		<tr>
		 	<td>Juicio:</td> <td> <?php echo $r["juicionulidad"]; ?> </td>
		</tr>
		<tr>
		 	<td>Actor:</td> <td> <?php echo  $r["actor"]; ?> </td>
		</tr>

		<tr>
		 	<td>Notificacón:</td> <td> <?php echo fechaNormal($r["fechanot"]); ?> </td>
		</tr>
		<tr>
		 	<td>Vencimiento:</td> <td> <?php echo fechaNormal($r["vencimiento"]); ?> </td>
		</tr>

		</table>
	</div>


	<div class="box_2"	>
	<form id="modificaJuicio" name= "modificaJuicio">
	 	<fieldset>
		    <legend>Contestación:</legend>
			<table>
			 	<tr>
            		<td><p class="juicio-etiqueta">Oficio:</p></td>
            		<td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_contestacion']; ?>" size="20" id="oficio_contestacion" name="oficio_contestacion"></td>
					<td><p class="juicio-etiqueta">Fecha:</p></td>
            		<td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_tribunal']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_tribunal']); ?>" size="10" id="fecha_pre_tribunal" name="fecha_pre_tribunal" > </td>		  
          		</tr>
			</table>
		</fieldset>

		<fieldset>
		    <legend>  Ampliación  </legend>
			<table>		
				<tr>
            	<td><p class="juicio-etiqueta">Oficio:</p></td>
            	<td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_ampliacion']; ?>" size="20" id="oficio_ampliacion" name="oficio_ampliacion"></td>
				<td><p class="juicio-etiqueta">Fecha:</p></td>
            	<td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_ampliacion']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_ampliacion']); ?>" size="10" id="fecha_pre_ampliacion" name="fecha_pre_ampliacion"> </td>		  
		  		</tr>
			</table>
		</fieldset>

		<fieldset >
		    <legend class="success">Alegatos:</legend>
		<table>	
		  <tr>
            <td><p class="juicio-etiqueta success">Oficio:</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['oficio_alegatos']; ?>" size="20" id="oficio_alegatos" name="oficio_alegatos"></td>
			<td><p class="juicio-etiqueta">Fecha:</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_alegatos']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_alegatos']); ?>" size="10" id="fecha_pre_alegatos" name="fecha_pre_alegatos"> </td>
		  </tr>
		</table>
		</fieldset>

	

	  <fieldset>
		<legend>Sentencia:</legend>
	    <table> 

		<tr>
		  <td><p class="juicio-etiqueta">Notificación de la Sentencia</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_sentencia']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_sentencia']); ?>" size="10" id="fecha_not_sentencia" name="fecha_not_sentencia"  > </td>
		  <td><p class="juicio-etiqueta">Fecha de Sentencia</p></td>
         <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_sentencia']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_sentencia']); ?>" size="10" id="fecha_sentencia" name="fecha_sentencia"  > </td>
		
		</tr>
    
        <tr>
		    <td><p class="juicio-etiqueta">Sentencia 1ª Instancia</p></td>
          
            <td>
			<select name="sentencia_primera" id="sentencia_primera" class="redonda5 inputsSig" >
				<optgroup label="Sentencia 1ª Instancia">
						<option value="<?php echo $r['sentencia_primera']; ?>"><?php echo $r['sentencia_primera']; ?> ...</option>
						<option class='opciones' value="Desecha"> &nbsp; - Pendiente</option>;
						<option class='opciones' value="Desecha"> &nbsp; - Desecha</option>;
						<option class='opciones' value="Validez"> &nbsp; - Validez</option>;
						<option class='opciones' value="Sobreseimiento"> &nbsp; - Sobreseimiento</option>;
                        <option class='opciones' value="Nulidad para Efecto"> &nbsp; - Nulidad para Efecto</option>;
						<option class='opciones' value="Nulidad Lisa y Llana"> &nbsp; - Nulidad Lisa y Llana</option>;
				</optgroup>
			</select>
			</td>
			<td><p class="juicio-etiqueta">Resultado ASF</p></td>
			<td>
			<select name="resultado" id="resultado" class="redonda5 inputsSig" >
				<optgroup label="Resultado">
						<option value="<?php echo $r['resultado']; ?>"><?php echo $r['resultado']; ?> ...</option>
						<option class='opciones' value="Favorable"> &nbsp; - Pendiente</option>;
						<option class='opciones' value="Favorable"> &nbsp; - Favorable</option>;
						<option class='opciones' value="Desfavorable"> &nbsp; - Desfavorable</option>;
				</optgroup>
			</select>
			</td>


          
        </tr>
		</table>


	  </fieldset>

		<table>
          <tr>
            <td><p class="juicio-etiqueta">Comparencia</p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['comparecencia']; ?>" size="25" id="comparecencia" name="comparecencia"></td>
          </tr>
		</table>


	  <fieldset id="EjecutoriaRevision">
		<legend>Ejecutoria en Revisión:</legend>
	 	<table>
		<tr>		 
            <td><p class="juicio-etiqueta">Notificación de Ejecutoria </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_ejec_rev']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_ejec_rev']); ?>" size="10" id="fecha_not_ejec_rev" name="fecha_not_ejec_rev">
			<td><p class="juicio-etiqueta">Fecha:</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_ejec_rev']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_ejec_rev']); ?>" size="10" id="fecha_ejec_rev" name="fecha_ejec_rev"  > </td>

			</td>
          </tr>		  
          <tr>
             <td><p class="juicio-etiqueta">Sentido:</p></td>
             <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['ejecutoria_revision']; ?>" size="25" id="ejecutoria_revision" name="ejecutoria_revision"></td>
			 <td><p class="juicio-etiqueta">Toca en Revisión</p></td>
          	<td><input type="text" class="txtInfo redonda5" value="<?php echo $r['toca_en_revision']; ?>" size="25" id="toca_revision" name="toca_revision"></td>
	 
			</tr>
		</table>
	  </fieldset>


	
	  <fieldset class="success">
	  <legend>Ejecutoria En Amparo:</legend>
		<table>	
        <tr>
          
            <td><p class="juicio-etiqueta">Notificación Amparo </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_ejec_amp']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_ejec_amp']); ?>" size="10" id="fecha_not_ejec_amp" name="fecha_not_ejec_amp"  > </td>
			<td><p class="juicio-etiqueta">Fecha  Ejecutoria En Amparo </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_ejec_amp']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_ejec_amp']); ?>" size="10" id="fecha_ejec_amp" name="fecha_ejec_amp"  > </td>
		
		</tr>

          <tr>
		    <td><p class="juicio-etiqueta">Sentido Ejecutoria En Amparo </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['ejecutoria_amparo']; ?>" size="25" id="ejecutoria_amparo" name="ejecutoria_amparo"></td>
			<td><p class="juicio-etiqueta">Toca Amparo</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['toca_amparo']; ?>" size="25" id="toca_amparo" name="toca_amparo"></td>
		</tr>
		  </table>
      </fieldset> 

	  <fieldset>
			<legend>En Cumplimiento:</legend>
		<table>
		<tr>
		  <td><p class="juicio-etiqueta">Notificación en Cumplimiento </p></td>
	
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_not_cumplimiento']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_not_cumplimiento']); ?>" size="10" id="fecha_not_cumplimiento" name="fecha_not_cumplimiento"  > </td>
		   <td><p class="juicio-etiqueta">Fecha en Cumplimiento </p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_sent_cumplimiento']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_sent_cumplimiento']); ?>" size="10" id="fecha_sent_cumplimiento" name="fecha_sent_cumplimiento"  > </td>
		
		</tr>				  

		<tr>
		      <td><p class="juicio-etiqueta">Sentencia en Cumplimiento</p></td>
              <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['sentencia_cumplimiento']; ?>" size="25" id="sentencia_cumplimiento" name="sentencia_cumplimiento"></td>
        </tr>			
		</table>
	  </fieldset>


	  <fieldset>
			<legend>Revisión Fiscal:</legend>
		<table>
		<tr>
			<td><p class="juicio-etiqueta">Fecha  Presentación de R.F. </p></td>
           	<td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_pre_rf']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_pre_rf']); ?>" size="10" id="fecha_pre_rf" name="fecha_pre_rf"  > </td>
		</tr>
		</table>
	  </fieldset>

		<fieldset>
			<legend>Conclusión:</legend>
		<table>
		<tr>
		   <td><p class="juicio-etiqueta">Fecha de Conclusión </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_conclusion']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_conclusion']); ?>" size="10" id="fecha_conclusion" name="fecha_conclusion"  > </td>
		   <td><p class="juicio-etiqueta">Observaciones</p></td>
          <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['observaciones']; ?>" size="25" id="observaciones" name="observaciones"></td>

		</tr>
		</table>
		</fieldset>


		<table>		  
           
        <tr>
		  
		  <td><p class="juicio-etiqueta">Estado</p></td>
           <td>
			<select name="estado" id="estado" class="redonda5 inputsSig" >
				<optgroup label="Estado">
					<option value="<?php echo $r['estado']; ?>"><?php echo $r['estado']; ?> ...</option>
						<option class='opciones' value="En contestación de Demanda"> &nbsp; - En contestación de Demanda</option>;
						<option class='opciones' value="En espera de Sentencia"> &nbsp; - En espera de Sentencia</option>;
						<option class='opciones' value="Nulidad Lisa y Llana"> &nbsp; - Nulidad Lisa y Llana</option>;
                        <option class='opciones' value="Nulidad para Efectos"> &nbsp; - Nulidad para Efectos</option>;
                        <option class='opciones' value="Validez"> &nbsp; - Validez</option>;
                        <option class='opciones' value="Sobreseimiento"> &nbsp; - Sobreseimiento</option>;						                      
						<option class='opciones' value="En espera de Ejecutoria de Amparo"> &nbsp; - En espera de Ejecutoria  de Amparo</option>;
                        <option class='opciones' value="En espera de Ejecutoria  de Revisión"> &nbsp; - En espera de Ejecutoria  de Revisión </option>;
                        <option class='opciones' value="Concluído"> &nbsp; - Concluído</option>;
				</optgroup>
			</select>
		</tr>
<!--
        <tr>
           <td colspan="4"><br >
             <input type="button" class="submit_line" name="actreg" id="actreg" value="Actualizar Juicio" >
           </td>
		</tr>
-->

		</table>

	</form>
	</div>

  </div>
</body>

<script>

function cerrarCuadroJuicios()
{
	// $$("#fondoOscuro2").fadeOut();
	$("#altaOficio").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}

$(document).ready(function() {

	document.getElementById("EjecutoriaRevision").disabled = true;

//------Contestación
	$("#fecha_pre_tribunal").datepicker({
		dateFormat: "dd/mm/yy",
     	changeMonth: false,
      	numberOfMonths: 1,
		minDate: '<?php echo fechaNormal($r["fechanot"]) ?>',    
	  	maxDate: '<?php echo fechaNormal($r["vencimiento"]) ?>',
	  	beforeShowDay: noLaborales
    });

//------Ampliación
	$("#fecha_pre_ampliacion").datepicker({
		dateFormat: "dd/mm/yy",	
      changeMonth: false,
	  numberOfMonths: 1,
	  minDate: '<?php echo fechaNormal($r["fechanot"]) ?>',    
	  	maxDate: '<?php echo fechaNormal($r["vencimiento"]) ?>',
	  beforeShowDay: noLaborales
	});
	
//------Alegatos
$("#fecha_pre_alegatos").datepicker({
		dateFormat: "dd/mm/yy",
     	changeMonth: false,
      	numberOfMonths: 1,
		minDate: '<?php echo fechaNormal($r["fechanot"]) ?>',    
	  	maxDate: '<?php echo fechaNormal($r["vencimiento"]) ?>',
	  	beforeShowDay: noLaborales
    });
		
//------ ejecutoria en revisión
	$("#fecha_not_ejec_rev").datepicker({
		dateFormat: "dd/mm/yy",
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });
		
//------Se despliega calendario para colocar fecha de ampliacion
	    	$( "#fecha_ampliacion" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/10/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });
		
//------Se despliega calendario para colocar fecha de notificacion de ejecutoria
	  $( "#not_ejec" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	//------Se despliega calendario para colocar fecha de alegatos
	$( "#fecha_alegatos" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/10/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });

//------ejecucion en amparo
	$( "#fecha_ejec_amp" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });
	
//------Se despliega calendario para colocar fecha de notificacion de amparo

	$( "#fecha_not_ejec_amp" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/10/2018",
	  maxDate: "15/10/2018",
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });	
	
//------Se despliega calendario para colocar fecha de sentencia
	$( "#fecha_sentencia" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });
	
//------Se despliega calendario para colocar fecha de notificacion de sentencia
	$( "#fecha_not_sentencia" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/10/2018",
	  maxDate: "15/10/2018",
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });	
	
//------Se despliega calendario para colocar fecha de cumplimiento
	$( "#fecha_sent_cumplimiento" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  minDate: "01/10/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });		
	
//------Se despliega calendario para colocar fecha notificacion de cumplimiento
	$( "#fecha_not_cumplimiento" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });		
	

//------Se despliega calendario para colocar fecha presentacion Recurso Fiscal
	$( "#fecha_pre_rf" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	   minDate: "17/09/2018",
	  maxDate: "30/09/2018",
	  beforeShowDay: noLaborales
    });		
	
	
//------Se despliega calendario para colocar fecha conclusión
	$( "#fecha_conclusion" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	   minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
	  //Ricardo Dijo y si está mal 
    });			
	
//------Se despliega calendario para colocar fecha notificación
	$( "#notificacion" ).datepicker({
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  minDate: "01/09/2018",
	  maxDate: "15/10/2018",
	  beforeShowDay: noLaborales
    });		

//------ Envia datos para base de datos
	$("#actreg").click(function()
			{
				
			var datosUrl = "id=" + <?php echo $r["id"] ?> + "&" + $("#modificaJuicio").serialize();
		
			var confirma = confirm('Se modificará el juicio de:\n\n - <?php echo $r['actor']; ?> - \n\n ¿Desea continuar?');
			if(confirma)
			{
				$.ajax
				({
					beforeSend: function(objeto)
					{
						console.log(datosUrl);
					//$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "e/juicios_modifica_v2.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
					cerrarCuadroJuicios();
					}
				});
			} //Fin de if confirma
	});
});
</script>

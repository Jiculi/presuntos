<?php
session_start();
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
    <title>juicios actualiza</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="css/juiciosModifica.css" type="text/css" media="screen" title="default" >

    <script type="text/javascript" src="js/funciones.js"></script>
</head>

<body>

<div class="grid-container">

  <div class="menu">
  	<div class="navbar">
			<a href="#" class="logo">Juicios</a>
			<div class="navbar-right">
				<?php
				 if($_SESSION['nivel'] == $r["sub"] || $_SESSION['a'] == 'a' ){
					echo '<a id="actreg" href="#">Actualizar Juicio</a>';
				 } else echo '<a>'.$_SESSION['a'].'<a>';
				?>
				<a href="javascript:cerrarCuadroJuicios()"><i class="material-icons">close</i></a>
			</div>
		</div>
	</div>



  <div class="info">
		<label for="procedimiento">Procedimiento:</label>
      	<input type="text" name="procedimiento" id="procedimiento" value="<?php echo $r["procedimiento"]; ?>" readonly>

		<label for="accion">Acción:</label>
      	<input type="text" name="accion" id="accion" value="<?php echo $r["accion"]; ?>" readonly>

		<label for="juicionulidad">Juicio:</label>
      	<input type="text" name="juicionulidad" id="juicionulidad" value="<?php echo $r["juicionulidad"]; ?>"readonly >

	  	<label for="actor">Actor:</label>
      	<textarea  name="actor" id="actor" readonly><?php echo $r["actor"]; ?></textarea>

		<label for="salaconocimiento">Sala:</label>
      	<textarea  name="salaconocimiento" id="salaconocimiento"  readonly><?php echo $r["salaconocimiento"]; ?></textarea>

		<label for="sub">Subdirección:</label>
		<input type="text" name="sub" id="sub" value="<?php echo $r["sub"]; ?>" readonly>
			
		<input type="text" name="toca_en_revision" id="toca_en_revision" value="<?php echo $r["toca_en_revision"]; ?>" hidden>
		<input type="text" name="toca_amparo" id="toca_amparo" value="<?php echo $r["toca_amparo"]; ?>" hidden>

	</div>


	<form id="modificaJuicio" name= "modificaJuicio">


	<div class="formita">
		<div class="titulo">
			<h1>Juicio Contencioso Administrativo</h1>
		</div>
		<div>
			<label for="fechanot">Notificación Juicio:</label>
      		<input type="date" name="fechanot" id="fechanot" value="<?php echo $r["fechanot"]; ?>" >
		</div>
    	<div>
			<label for="f_resolucion">Sentencia:</label>
      		<input type="date" name="f_resolucion" id="f_resolucion" value="<?php echo $r["f_resolucion"]; ?>" >
		</div>

		<div>
			<label for="fecha_not_sentencia">Notificación de la Sentencia:</label>
      		<input type="date" name="fecha_not_sentencia" id="fecha_not_sentencia" value="<?php echo $r["fecha_not_sentencia"]; ?>" >
		</div>

		<div>
			<label for="fecha_sentencia">Sentencia Firme:</label>
      		<input type="date" name="fecha_sentencia" id="fecha_sentencia" value="<?php echo $r["fecha_sentencia"]; ?>" >
		</div>

		<div>
			<label for="resultado">Resultado  ASF:</label>
			<select name="resultado" id="resultado" >
				<optgroup label="Resultado">
					<option value="<?php echo $r['resultado']; ?>"><?php echo $r['resultado']; ?></option>
					<option class='opciones' value="trámite"> &nbsp; trámite</option>;
					<option class='opciones' value="favorable"> &nbsp; favorable</option>;
					<option class='opciones' value="desfavorable"> &nbsp; desfavorable</option>;
				</optgroup>
			</select>
		</div>

		<fieldset>
			<label for="observaciones">Observaciones:</label>
			<textarea  name="observaciones" id="observaciones" maxlength="140" ><?php echo $r["observaciones"]; ?></textarea>
		</fieldset>

		<div class='sentenciaPrimera'>
			<label for="sentencia_primera">Sentencia 1ª Instancia:</label>
			<select name="sentencia_primera" id="sentencia_primera" >
				<optgroup label="Sentencia 1ª Instancia:">
					<option value="<?php echo $r['sentencia_primera']; ?>"><?php echo $r['sentencia_primera']; ?></option>
					<option class='opciones' value="Desecha"> &nbsp;Pendiente</option>;
					<option class='opciones' value="Desecha"> &nbsp;Desecha</option>;
					<option class='opciones' value="Validez"> &nbsp;Validez</option>;
					<option class='opciones' value="Sobreseimiento"> &nbsp;Sobreseimiento</option>;
					<option class='opciones' value="Nulidad para Efecto"> &nbsp;Nulidad para Efecto</option>;
					<option class='opciones' value="Nulidad Lisa y Llana"> &nbsp;Nulidad Lisa y Llana</option>;
				</optgroup>
			</select>
		</div>


	</div>
	

	<div class="formaRRF" id="formaR">
		<div class="titulo">
			<h1>Ejecutoria en Revisión Fiscal:</h1>
		</div>
		<div>
			<label for="ejecutoria_revision">No Recurso Fiscal:</label>
      		<input type="text" name="ejecutoria_revision" id="ejecutoria_revision" value="<?php echo $r["ejecutoria_revision"]; ?>" >
		</div>

		<div>
			<label for="fecha_pre_rf">Fecha de Presentación:</label>
      		<input type="date" name="fecha_pre_rf" id="fecha_pre_rf" value="<?php echo $r["fecha_pre_rf"]; ?>" >
		</div>
    	<div>
			<label for="fecha_ejec_rev">Resolución:</label>
      		<input type="date" name="fecha_ejec_rev" id="fecha_ejec_rev" value="<?php echo $r["fecha_ejec_rev"]; ?>" >
		</div>
		<div>
			<label for="fecha_not_ejec_rev">Notificación de Ejecutoria:</label>
      		<input type="date" name="fecha_not_ejec_rev" id="fecha_not_ejec_rev" value="<?php echo $r["fecha_not_ejec_rev"]; ?>" >
		</div>

		<div>
			<label for="rf_status">Sentido:</label>
			<select name="rf_status" id="rf_status"  >
				<optgroup label="Resultado">
					<option value="<?php echo $r['rf_status']; ?>"><?php echo $r['rf_status']; ?></option>
					<option class='opciones' value="trámite"> &nbsp; trámite</option>;
					<option class='opciones' value="favorable"> &nbsp; favorable</option>;
					<option class='opciones' value="desfavorable"> &nbsp; desfavorable</option>;
				</optgroup>
			</select>
		</div>

		<fieldset>
				<label for="rf_observaciones">Observaciones:</label>
				<textarea  name="rf_observaciones" id="rf_observaciones" maxlength="140" ><?php echo $r["rf_observaciones"]; ?></textarea>
		</fieldset>


	</div>


	<div class="formaAD" id="formaD">
		<div class="titulo">
			<h1>Ejecutoria en Amparo Directo:</h1>
		</div>
		<div>
			<label for="ejecutoria_amparo">No Amparo:</label>
      		<input type="text" name="ejecutoria_amparo" id="ejecutoria_amparo" value="<?php echo $r["ejecutoria_amparo"]; ?>" >
		</div>

		<div>
			<label for="ad_f_interposicion">Interposición:</label>
      		<input type="date" name="ad_f_interposicion" id="ad_f_interposicion" value="<?php echo $r["ad_f_interposicion"]; ?>" >
		</div>
    	<div>
			<label for="fecha_ejec_amp">Resolución:</label>
      		<input type="date" name="fecha_ejec_amp" id="fecha_ejec_amp" value="<?php echo $r["fecha_ejec_amp"]; ?>" >
		</div>
		<div>
			<label for="fecha_not_ejec_amp">Notificación de Amparo:</label>
      		<input type="date" name="fecha_not_ejec_amp" id="fecha_not_ejec_amp" value="<?php echo $r["fecha_not_ejec_amp"]; ?>" >
		</div>


		<div>
			<label for="ad_status">Sentido:</label>
			<select name="ad_status" id="ad_status" >
				<optgroup label="Resultado">
					<option value="<?php echo $r['ad_status']; ?>"><?php echo $r['ad_status']; ?></option>
					<option class='opciones' value="trámite"> &nbsp; trámite</option>;
					<option class='opciones' value="favorable"> &nbsp; favorable</option>;
					<option class='opciones' value="desfavorable"> &nbsp; desfavorable</option>;
				</optgroup>
			</select>
		</div>

		<fieldset>
			<label for="ad_observaciones">Observaciones:</label>
			<textarea  name="ad_observaciones" id="ad_observaciones" maxlength="140" ><?php echo $r["ad_observaciones"]; ?></textarea>
		</fieldset>


	</div>

	<div class="inicioJN">
			<div class="titulo">
					<h1>Oficios</h1>
			</div>
			<div class="contestacion">
					<h2>Contestación</h2>
			</div>
			<div class="ampliacion">
					<h2>Ampliación</h2>
			</div>

			<div>
					<label for="oficio_contestacion">Oficio:</label>
      		<input type="text" name="oficio_contestacion" id="oficio_contestacion" value="<?php echo $r["oficio_contestacion"]; ?>" >
			</div>
			<div>
				<label for="fecha_pre_tribunal">Fecha:</label>
      			<input type="date" name="fecha_pre_tribunal" id="fecha_pre_tribunal" value="<?php echo $r["fecha_pre_tribunal"]; ?>" >
			</div>
			<div>
					<label for="oficio_ampliacion">Oficio:</label>
      		<input type="text" name="oficio_ampliacion" id="oficio_ampliacion" value="<?php echo $r["oficio_ampliacion"]; ?>" >
			</div>
			<div>
					<label for="fecha_pre_ampliacion">Fecha:</label>
      		<input type="date" name="fecha_pre_ampliacion" id="fecha_pre_ampliacion" value="<?php echo $r["fecha_pre_ampliacion"]; ?>" >
			</div>
			<div class="alegatos">
					<h2>Alegatos</h2>
			</div>
			<div class="alegatosOficio">
					<label for="oficio_alegatos">Oficio:</label>
      		<input type="text" name="oficio_alegatos" id="oficio_alegatos" value="<?php echo $r["oficio_alegatos"]; ?>" >
			</div>
			<div class="alegatosFecha">
					<label for="fecha_pre_alegatos">Fecha:</label>
      		<input type="date" name="fecha_pre_alegatos" id="fecha_pre_alegatos" value="<?php echo $r["fecha_pre_alegatos"]; ?>" >
			</div>
	


	</div>

	<!--
	
  <div class="item5">
		<table>
          <tr>
            <td><p class="juicio-etiqueta">Comparencia</p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['comparecencia']; ?>" size="25" id="comparecencia" name="comparecencia"></td>
          </tr>
		</table>

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
			<legend>Conclusión:</legend>
		<table>
		<tr>
		   <td><p class="juicio-etiqueta">Fecha de Conclusión </p></td>
           <td><input type="text" class="txtInfo redonda5" value="<?php if($r['fecha_conclusion']=='0000-00-00'){ echo "";} else echo fechaNormal($r['fecha_conclusion']); ?>" size="10" id="fecha_conclusion" name="fecha_conclusion"  > </td>

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


		</table>
  
	</div>
-->

	</form>

	<div class= "piePagina">
				<p>DGR ® Todos los derechos reservados</p>
	</div>



</div>





</body>

<script>

function cerrarCuadroJuicios() {
	// $$("#fondoOscuro2").fadeOut();
	$("#altaOficio").fadeOut();
	$('#popup-overlay').fadeOut('slow');
}

$(document).ready(function() {

		if( $('#toca_en_revision').val() != "si" ){
		  	// alert($('#toca_en_revision').val());
				$("#formaR").hide();
		}

		if( $('#toca_amparo').val() != "si" ){
		  	// alert($('#toca_en_revision').val());
				$("#formaD").hide();
		}

		//	document.getElementById("EjecutoriaRevision").disabled = true;

/*

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

	*/	

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
					url: "e/juiciosModificaUpdate.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					alert(datos);
					cerrarCuadroJuicios();
					}
				});
			} //Fin de if confirma
	});
});
</script>

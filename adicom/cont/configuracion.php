<html>
<head>

<script>
function otrosPo()
{
		$$.ajax
		({
			
			type: "POST",
			url: "procesosAjax/po_otros_oficios.php",
			data: {
						nivel:$$('#usuariopo').val(),
						status:$$('#status').val()
					},
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				alert("Operación Exitosa");
				
				//new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
				//--------- recarga lista de volantes -----------------------
				/*if(datos == "ok")
				{
					alert(datos+"\n\n¡Se ha asignado al abogado!\n\n - "+$$('#abagadoAsig').val());
				}
				else alert(datos+"\n\n¡Ha habido un error!");*/
			}
		});
	
}

function CerrarOtros()
{
			$$.ajax
		({
			
			type: "POST",
			url: "procesosAjax/cerrar_otros_oficios.php",
			data: {
						nivelpfrr:$$('#usuariopfrr').val(),
						nivel:$$('#po_activos').val(),

					},
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				alert("Operación Exitosa");
				
				//new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
				//--------- recarga lista de volantes -----------------------
				/*if(datos == "ok")
				{
					alert(datos+"\n\n¡Se ha asignado al abogado!\n\n - "+$$('#nombre').val());
				}
				else alert(datos+"\n\n¡Ha habido un error!");*/
			}
		});
	

	
	
	
	
	}

function otrospfrr()
{
		$$.ajax
		({
			
			type: "POST",
			url: "procesosAjax/pfrr_otros_oficios.php",
			data: {
						nivelpfrr:$$('#usuariopfrr').val(),
						statuspfrr:$$('#statuspfrr').val()
					},
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé");
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				alert("Operación Exitosa");
				
				//new mostrarCuadro2(450,800,"Volante de Correpondencia",70,"cont/vol_volante.html.php","id="+datos+"&muestra=1");
				//--------- recarga lista de volantes -----------------------
				/*if(datos == "ok")
				{
					alert(datos+"\n\n¡Se ha asignado al abogado!\n\n - "+$$('#nombre').val());
				}
				else alert(datos+"\n\n¡Ha habido un error!");*/
			}
		});
	
}




function muestraError(paso,texto)
{
	ocultaAll();
	document.getElementById(paso).innerHTML = "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>"+texto+"</h3>  <img src='images/warning_yellow.png' />  </center></p>";
	$$('#'+paso).fadeIn();
}
function ocultaAll() 
{
	$$('.todosContPasos ').removeClass("pActivo");
	$$('.todosContPasos ').hide();
	///$$('.todosPasos').removeClass("pasosActivo");
	//$$('.todosNP').removeClass('noPasoActivo');
	$$('.todosNP').addClass('noPaso'); 
} 
function muestraPestana(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
}
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------
$$(function() {
	//------------------------ DEHABILITA DIAS -------------------------------------
	function noLaborales(date) 
	{
		var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
		var day = date.getDay();
		for (i = 0; i < disabledDays.length; i++) 
		{
			if (day == 0 || day == 6) {	return [false, ""]	}
			if($$.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1) {return [false];}
		}
		return [true];
	}
	//------------------------ FUNCION SUMA DIAS ---------------------------------
	function restaNolaborables(fecha,dias) 
	{
		//fecha es dd/mm/aaaa 
		fc = fecha.split("/");
		nfecha = new Date(fc[2],(fc[1]-1),fc[0]); 

		dd = nfecha.getDate();
		mm = nfecha.getMonth();
		yy = nfecha.getFullYear();
		//alert("fecha: "+nfecha+"\nMes: "+mm);
		
		for (i = 0; i < dias; i++) 
		{
			var day = nfecha.getDay();
			
			//si la fecha es sabado o domingo ó esta en la cadena disableDays no cuenta en conteo
			if (day == 0 || day == 6) {	i-- }
			if($$.inArray((mm+1) + '-' + dd + '-' + yy,disabledDays) != -1) { i-- }
			// Incrementa un dia (86400000 es un dia en milisegundos)
			nfecha.setTime(nfecha.getTime()+(86400000*1));
		}
		fechaOK = nfecha.getDate()+"/"+(nfecha.getMonth()+1)+"/"+nfecha.getFullYear();
		//alert(fechaOK);
		return nfecha;
	}
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- REGISTRAR RECEPCION ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f1po_fecha_oficio" ).datepicker({
      defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "-1w",
	  maxDate: "+1m",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	//$$( "#f2po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
});
</script>
<script>
//-------- actualiza la hora del txtbox hora para saber la hora del movimiento ---------------------
//actualizaReloj('hora_cambio1','hora_cambio2');
//--------------------------------------------------------------------------------------------------
</script>
</head>
<body onLoad="" >
<?php
$conexion = new conexion;
$conexion->conectar();
//---------------------------------------------------------------------------
//------------------------ ACTIVAR PESTAÑAS ---------------------------------
//---------------------------------------------------------------------------
$onclickP1 = "onclick='muestraPestana(1)'";
$onclickP2 = "onclick='muestraPestana(2)'";	
$onclickP3 = "onclick='muestraPestana(3)'";	
$onclickP4 = "onclick='muestraPestana(4)'";	
$onclickP5 = "onclick='muestraPestana(5)'";	
$onclickP6 = "onclick='muestraPestana(6)'";	
$onclickP7 = "onclick='muestraPestana(7)'";	
$onclickP8 = "onclick='muestraPestana(8)'";	

$txtPaso1 = "pasosActivo";
$txtPaso2 = "pasosActivo";
$txtPaso3 = "pasosActivo";
$txtPaso4 = "pasosActivo";
$txtPaso5 = "pasosActivo";
$txtPaso6 = "pasosActivo";
$txtPaso7 = "pasosActivo";
$txtPaso8 = "pasosActivo";

$numPaso1 = "noPasoActivo";
$numPaso2 = "noPasoActivo";
$numPaso3 = "noPasoActivo";
$numPaso4 = "noPasoActivo";
$numPaso5 = "noPasoActivo";
$numPaso6 = "noPasoActivo";
$numPaso7 = "noPasoActivo";
$numPaso8 = "noPasoActivo";

$acceso1 = "pfAccesible";
$acceso2 = "pfAccesible";
$acceso3 = "pfAccesible";
$acceso4 = "pfAccesible";
$acceso5 = "pfAccesible";
$acceso6 = "pfAccesible";
$acceso7 = "pfAccesible";
$acceso8 = "pfAccesible";
?>

<!--  start content-table-inner -->
<style>
.ui-datepicker-calendar td a,.ui-state-default{ display:block; padding:1px 0 !important}
	body{
		/*font: 62.5% "Trebuchet MS", sans-serif;*/
		font-size:62.5%;
	}
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
</style>
<div id="message-green">
<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td class="green-left">
	    <div id='resGuardar' style="line-height:normal"></div>
    </td>
    <td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" onClick="cerrarMsg()"  alt="" /></a></td>
</tr>
</table>
</div>

<!-- ----------------------------------------- ----------------------------------------------->
<!-- ---------------------------- IMPORTANTE NO QUITAR --------------------------------------->
<!-- --------------------- VARIABLES QUE PASAN VALORES A JQUERY ------------------------------>
<!-- ----------------------------------------- ----------------------------------------------->
<input name="num_accion" type="hidden" value="<?php echo $accion ?>" id="num_accion" />
<input name="fecha_cambio" type="hidden" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input name="hora_cambio1" type="hidden" id="hora_cambio1" value="" />
<input name="hora_cambio2" type="hidden" id="hora_cambio2" value="" />
<input name="txtUser" type="hidden" value="<?php echo $_REQUEST['usuario'] ?>" id="txtUser" />
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<!-- ----------------------------------------- ----------------------------------------------->
<?php
//-------------------------- CONSULTA DE OPCIONES -----------------------------
$sql = $conexion->select("SELECT * FROM configuracion",false);

while($r = mysql_fetch_array($sql))
{
	if($r['proceso'] == 'activaPestanas') 
	{	
		$apBoleano = $r['boleano'];
		$apOpciones = $r['opciones'];
	}
	if($r['proceso'] == 'estadoSistema') 
	{	
		$sSBoleano = $r['boleano'];
		$sSOpciones = $r['opciones'];
	}
	if($r['proceso'] == 'mensajeCierre') 
	{	
		$menTxt = $r['opciones'];
	}

}
?>
<div class="contPasos1">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> Sistema  </div>
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> Módulo PO </div>
       <div id='paso3' <?php echo $onclickP3 ?> class="todosPasos <?php echo $txtPaso3 ?> <?php echo $acceso3 ?> pasos"><!--<div id='np3' class="todosNP noPaso redonda10 <?php echo $numPaso3 ?> ">3</div>--> Módulo PFRR&nbsp; </div>
       <div id='paso4' <?php echo $onclickP4 ?> class="todosPasos <?php echo $txtPaso4 ?> <?php echo $acceso4 ?> pasos"><!--<div id='np4' class="todosNP noPaso redonda10 <?php echo $numPaso4 ?>">4</div>--> Otros oficios </div>
       <div id='paso5' <?php echo $onclickP5 ?> class="todosPasos <?php echo $txtPaso5 ?> <?php echo $acceso5 ?> pasos"><!--<div id='np5' class="todosNP noPaso redonda10 <?php echo $numPaso5 ?>">5</div>-->&nbsp; </div>
       <div id='paso6' <?php echo $onclickP6 ?> class="todosPasos <?php echo $txtPaso6 ?> <?php echo $acceso6 ?> pasos"><!--<div id='np6' class="todosNP noPaso redonda10 <?php echo $numPaso6 ?>">6</div>--> &nbsp;</div>
       <div id='paso7' <?php echo $onclickP7 ?> class="todosPasos <?php echo $txtPaso7 ?> <?php echo $acceso7 ?> pasos"><!--<div id='np7' class="todosNP noPaso redonda10 <?php echo $numPaso7 ?>">7</div>-->&nbsp; </div>
       <div id='paso8' <?php echo $onclickP8 ?> class="todosPasos <?php echo $txtPaso8 ?> <?php echo $acceso8 ?> pasos"><!--<div id='np8' class="todosNP noPaso redonda10 <?php echo $numPaso8 ?>">8</div>-->&nbsp; </div>
    </div>
    <div id='resPasos' class='resPasos redonda10'>
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos"> Configuración del Sistema </h3>
        
             <form action="#" method="POST" name="formMantenimiento" id="formMantenimiento">
              <center>
              <table width="90%" align="center" class="tablaPasos ">
              	<tr>
                	<td class="etiquetaPo" width="30%">Estado del Sistema: </td>
                    <td width="40%">
                    	<select class="redonda5" id='sistemaEdo' name='sistemaEdo'>
                        	<option value="true" <?php if($sSBoleano == 1) echo "selected" ?>> Sistema Abierto </option>
                            <option value="false" <?php if($sSBoleano == 0) echo "selected" ?>> Sistema Cerrado </option>
                        </select>
                    </td>
                </tr>
              	<tr>
                	<td class="etiquetaPo" width="30%">Mensaje: </td>
                    <td width="40%">
                        <textarea cols="70" rows="4" class="redonda5" name="mensajeTxt" id="mensajeTxt"> <?php echo $menTxt ?> </textarea> 
                    </td>
                    <td width="30%">
                        <input type="hidden" name="proceso" id="proceso" value="estadoSistema" />
                        <input type="button" class="submit-login" alt="Guardar" value="Guardar"  onclick="cambiaConfiguracion(this.form.name,'¿Cambiará estado del sistema?')"  /> 
                    </td>
                </tr>
              </table>
        	  </center>
	        </form>

		</div>
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Modulo PO</h3>
            
          	<form action="#" method="POST" name="guardaJ" id="guardaJ">
	          
              <center>
              <table width="90%" align="center" class="tablaPasos ">
              	<tr>
                	<td class="etiquetaPo" width="30%">Activar todas las Pestañas del Proceso: </td>
                    <td width="40%">
                    	<select class="redonda5" id='valPestanas'>
                        	<option value="true" <?php if($apBoleano == 1) echo "selected" ?>> Activar </option>
                            <option value="false" <?php if($apBoleano == 0) echo "selected" ?>> Desactivar </option>
                        </select>
                    </td>
                    <td width="30%">
                        <input type="button" class="submit-login" alt="Guardar" value="Guardar"  onclick="cambiaConfiguracion('activaPestanas','valPestanas',0,'Se modificarán las pestañas')" /> 
                    </td>
                </tr>
              </table>
        	  </center>
	        </form>
        </div>
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        
        <!-- ----------------------------- DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- DIV APROBACION DEL PPO --------------------------------- -->
        <div id="p3" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Proceso de Notificación</h3>
            
            <form action="#" method="POST" name="formpro" id="form1" onSubmit="return false">
			  <table width="100%" border="0" align="center" class="tablaPasos ">
			  </table>
			</form>

        </div>
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        <!-- ----------------------------- FIN DIV APROBACION DEL PPO --------------------------------- -->
        
        <!-- ----------------------------- Otros oficios --------------------------------- -->
        <div id="p4" class="todosContPasos pInactivo">
        	<div style="float:right"><img src="images/help.png" /></div>
        	<h3 class="poTitulosPasos">Activar/Desactivar</h3>
          	<form action="#" method="POST" name="otrospo" id="otrospo">
	          
<center>
        <table width="90%" align="center" class="tablaPasos ">
              	<tr>
                	<td class="etiquetaPo" width="30%">PO: </td>
                    <td width="40%">
                    	<select class="redonda5" id="status" name="status">
                        	<option value="" > Elija </option>
                        	<option value="1" > Activar </option>
                            <option value="0" > Desactivar </option>
                        </select>
                        
                        <select class="redonda5" id="usuariopo" name="usuariopo"  >
                        <?php
						$sql2=$conexion->select("SELECT * FROM USUARIOS order by nombre",false); ?>

                          <option value="" >Seleccione</option>
                         <?php
								while($a= mysql_fetch_array($sql2))
								{
									echo "<option value='".$a['nivel']."'>".$a['nombre']." </optiopn>";	
								}
							?>
                              		
                         <td width="30%">
                        <input type="button" class="submit-login" alt="Guardar" value="Guardar"  onclick="otrosPo()" /> 
                   
                    <TR>
                	<td class="etiquetaPo" width="30%">PFRR: </td>
                    <td width="40%">
                    	<select class="redonda5" id="statuspfrr" name="statuspfrr">
                         	<option value="" > Elija </option>
                        	<option value="1" > Activar </option>
                            <option value="0" > Desactivar </option>
                        </select>
                        
                        
                         <select class="redonda5" id="usuariopfrr" name="usuariopfrr">
                        <?php
						$sql2=$conexion->select("SELECT * FROM USUARIOS order by nombre",false); ?>

                          <option value="" >Seleccione</option>
                         <?php
								while($a= mysql_fetch_array($sql2))
								{
									echo "<option value='".$a['nivel']."'>".$a['nombre']." </optiopn>";	
								}
							?>
                        
                         <td width="30%">
                        <input type="button" class="submit-login" alt="Guardar" value="Guardar"  onclick="otrospfrr()" /> 
                        </td> 
                   
                    <tr>
                        <td class="etiquetaPo" width="100" > <p>Usuarios Activos :</p><p>
						 <td>                       
                                
						       
              	<tr>
                	<td class="etiquetaPo" id="po_activos" width="30%">PO: </td>
                    <td width="40%">
                 						<?php
						$sql2=$conexion->select("SELECT * FROM USUARIOS WHERE  nivel <>'DG' and nivel <> 's' and (otros_po=1 ) order by nombre",false); 
						while($a= mysql_fetch_array($sql2))
								{
									echo $a['nombre']. "          Hora de Apertura: ";
									echo $a['hora_otros_po']."<br>";	
								}
						?></p>
                        
                                                       		
      
                   
                       
              	<tr>
                	<td class="etiquetaPo" width="30%">PFRR: </td>
                    <td width="40%">
                 						<?php
						$sql2=$conexion->select("SELECT * FROM USUARIOS WHERE  nivel <>'DG' and nivel <> 's' and (otros_pfrr=1) order by nombre",false); 
						while($a= mysql_fetch_array($sql2))
								{
									echo $a['nombre']."          Hora de Apertura: ";
									echo $a['hora_otros_pfrr']."<br>";		
								}
						?></p>


 </td>
                         <td width="30%">
                        <input type="button" class="submit-login" alt="Guardar" value="Desactivar Todo"  onclick="CerrarOtros()" /> 
                        </td> 

                        </td>

                    </tr>
        </table>
        	  </center>
            
            
        </div>
        
</div>
        <p>&nbsp;</p>
<!--  end content-table  -->
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>
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
	$$('.todosPasos').removeClass("pasosActivo");
	$$('.todosNP').removeClass('noPasoActivo');
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
	$$( "#fecha_tipo_oficio_adicional" ).datepicker({
      defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  minDate: "-1w",
	  maxDate: "+1m",
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#acuse_tipo_oficio_adicional" ).datepicker( "option", "minDate", selectedDate );  
	  }
    });
	//---------------------------------------------------------------------------------------------
	$$( "#acuse_tipo_oficio_adicional" ).datepicker({
      //defaultDate: "+1w",
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales,
      onClose: function( selectedDate ) {
        $$( "#fecha_tipo_oficio_adicional" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
});
function insertaOtrosOficios()
{
	if(comprobarForm('form7'))
	{
		var accion = $$('#num_accion').val();
		 $$.ajax({
			type: "POST",
			url: "procesosAjax/po_inserta_otros_oficios.php",
			data: {
				accion: $$('#num_accion').val(),
				tipo_oficio_adicional: $$('#tipo_oficio_adicional').val(),
				oficio_tipo_oficio_adicional: $$('#oficio_tipo_oficio_adicional').val(),
				fecha_tipo_oficio_adicional: $$('#fecha_tipo_oficio_adicional').val(),
				acuse_tipo_oficio_adicional: $$('#acuse_tipo_oficio_adicional').val(),
				leyenda_tipo_oficio_adicional: $$('#leyenda_tipo_oficio_adicional').val(),
				referencia_tipo_oficio_adicional: $$('#referencia_tipo_oficio_adicional').val()
			},
			//data: "user="+$$('#user').val()+"&pass="+$$('#pass').val(),
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé");
				alert("Pasó lo siguiente: "+quepaso);
			},
			success: function( data ) {
				//response(data);
				//alert(data);
				muestraContenidoOficios(accion);
			}
		});
	}

}
</script>
</head>

<body>

<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_REQUEST['accion']);
//------------------------------------------------------------------------------
$sql = $conexion->select("SELECT * FROM otros_oficios WHERE num_accion = '".$accion."' AND status = 1 ",false);
$total = mysql_num_rows($sql);

$onclickP1 = "onclick='muestraPestana(1)'";
$onclickP2 = "onclick='muestraPestana(2)'";	

//$txtPaso1 = "pasosActivo";
$txtPaso2 = "pasosActivo";

//$numPaso1 = "noPasoActivo";
$numPaso2 = "noPasoActivo";

$acceso1 = "pfAccesible";
$acceso2 = "pfAccesible";

echo "<script>	$$(function() {	$$('#p2').fadeIn();	});	</script>";
?>
<div id='resGuardar' style="line-height:normal"></div>
<input type="hidden" name="num_accion" value="<?php echo $accion ?>" id="num_accion" />
<input type="hidden" name="fecha_cambio" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input type="hidden" name="hora_cambio" id="hora_cambio" value="<?php echo date ("H:i:s ") ?>" />
<input type="hidden" name="usuarioActual" id="usuarioActual" value="<?php echo $_SESSION['usuario'] ?>" />

<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos" style="display:none">
       <div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> CONSULTAR OFICIOS</div>
       <div id='paso1'  <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> NUEVO OFICIO  </div>
    </div>
    <div id='resPasos' class='divPresuntos redonda10'>

        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Nuevo Oficio  </h3>
            
           <form action="<?php echo $editFormAction; ?>" method="POST" name="form7" id="form7" onSubmit="return false">
              <table width="90%" align="center" class="tablaPasos">
              <tr valign="baseline">
                    <td width="12%" align="right" nowrap>Tipo:
                    <td colspan="5"><label for="tipo_oficio_adicional"></label>
                      <select name="tipo_oficio_adicional" id="tipo_oficio_adicional"  class="redonda5" >
                        <option value="" selected>Seleccione</option>
                        <option value="DGR">DGR</option>
                        <option value="DGCSAP">DGCSAP</option>
                        <option value="UAA">UAA</option>
                        <option value="ENTIDAD">ENTIDAD</option> <option value="C.C.">C.C.</option>
                        <option value="ATENTA NOTA">ATENTA NOTA</option>
                        <option value="OTRO">OTRO</option>
                  </select></td>
                </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap class="etiquetaPo">N&uacute;mero de Oficio:</td>
                    <td width="19%"><input type="text" class="redonda5"  name="oficio_tipo_oficio_adicional" id="oficio_tipo_oficio_adicional" value="" size="32"></td>
                    <td width="11%" class="etiquetaPo">Fecha del Oficio:</td>
                    <td width="7%"><input id="fecha_tipo_oficio_adicional" name="fecha_tipo_oficio_adicional" type="text" class="redonda5"  value='<?php $fecha_tipo_oficio_adicional =$_REQUEST['fecha_tipo_oficio_adicional']; 
			echo $fecha_tipo_oficio_adicional;?>'/></td>
                    <td width="4%" class="etiquetaPo">Acuse</td>
                    <td width="46%"><input id="acuse_tipo_oficio_adicional" name="acuse_tipo_oficio_adicional" type="text" class="redonda5"  value='<?php $acuse_tipo_oficio_adicional =$_REQUEST['acuse_tipo_oficio_adicional']; 
			echo $acuse_tipo_oficio_adicional;?>'/></td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap class="etiquetaPo">Asunto:</td>
                    <td colspan="5">
                  <textarea name="leyenda_tipo_oficio_adicional" id="leyenda_tipo_oficio_adicional"  class="redonda5"  cols="80" onKeyDown="contador(this.form.leyenda_tipo_oficio_adicional,'remLen',200);" onKeyUp="contador(this.form.leyenda_tipo_oficio_adicional,'remLen',200);"></textarea>           
                  <span id="remLen" ></span> </td>
                  </tr>
                  <tr valign="baseline">
                    <td align="right" nowrap class="etiquetaPo">Atiende oficio:</td>
                    <td colspan="5">
                    <input type="text" class="redonda5"  name="referencia_tipo_oficio_adicional" id="referencia_tipo_oficio_adicional" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="3">
                  <input type="button" onclick="insertaOtrosOficios()"  class="submit-login"  value="Actualizar Presunto" name="Actualizar registro" id="Actualizar registro">
                  </tr>
                </table>
              </form>
		</div>
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Listado de Oficios</h3>
            
           <?php
		  $tabla = '
		  			<table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
						<tr>
							<th class="ofiTipo"><a href="#">Tipo de Oficio</a>	</th>
							<th class="ofiOfi"><a href="#">Oficio/Volante</a></th>
							<th class="ofiOfi"><a href="#">Oficio Referencia</a></th>
							<th class=""><a href="#">Fecha</a></th>
							<th class=""><a href="#"> Leyenda </a></th>
							<th class="ofiAccion"><a href="#"> Accion </a></th>
						</tr>
					</table>
					<div style="height:200px;width:100%;overflow:auto">
					
					<table style="width:100%;" border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					<tbody>
					';

					while($r = mysql_fetch_array($sql))
					{
						$i++;
						$res = $i%2;
						if($res == 0) $estilo = "class='non'";
						else $estilo = "class='par'";
						
						//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
						$tabla .= '
								<tr '.$estilo.' >
									<td class="ofiTipo">'.$r['tipo'].'</td>
									<td class="ofiOfi">'.$r['folio_volante'].'</td>
									<td class="ofiOfi">'.$r['documentoExtra'].'</td>
									<td class="ofiFecha">'.fechaNormal($r['fecha']).'</td>
									<td class="">'.$r['leyenda'].'</td>
									<td class="ofiAccion">
										<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(400,500,"Informacion del Oficio '.$r['oficio_tipo_oficio_adicional'].'",100,"cont/po_otros_oficios_info.php","id='.$r['id'].'")\'></a>
										<!-- <a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1100,"Accion '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",100,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'")\'></a> -->
									</td>
								</tr>';
					}
						$tabla .= '
								</tbody>
								</table>
								</div>
								';
					
					if($total == 0) $tabla = "<center><br><h3> No se encontraron oficios </h3><br><br><br></center>";
					
					echo $tabla;

		   ?>
        
        </div>
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        

    </div>
</div>
<!--  end content-table  -->




</body>
</html>
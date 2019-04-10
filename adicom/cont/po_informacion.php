<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script>
function muestraNvoMonto(tipo)
{
	//alert ("\n- accion:"+$$("#RS_num_accion").val()+"\n- tipo:"+tipo+" \n- RS_direccion:"+ $$("#indexDir").val());

	mostrarCuadro2(200,300,'Modificar monto '+tipo);
	$$("#cuadroRes2").load("cont/po_reintegros_form.php #RS_cambiaMontos",{accion:$$("#RS_num_accion").val(), tipo:tipo, RS_direccion: $$("#indexDir").val()});
}

$$(function() {
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- REGISTRAR RECEPCION ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f1_fecha_presc" ).datepicker({
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  changeYear: true,
	  //minDate: "-1w",
	  //maxDate: "+1m",
	  //beforeShowDay: noLaborales
	  /*
	  ,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#f2po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
		//$$( "#f2po_acuse_oficio" ).datepicker( "option", "maxDate", restaNolaborables(selectedDate,5)  ); 
	  }*/
    });
});
//----------------------------------------
function actualizaMonto(tipo)
{
	var accion = $$("#RS_num_accion").val();
	//alert ("RS_tipo="+$$("#RS_tipo").val()+"&RS_cantidad="+$$("#RS_cantidad").val()+"&RS_accion="+$$("#RS_num_accion").val()+"&RS_formulario="+$$("#formNvoMonto").val()+"&RS_direccion="+$$("#indexDir").val());
	if(comprobarForm('form_nuevo_monto'))
	{
		var confirma = confirm("Una vez cambiado este monto no se podra modificar nuevamente \n\n  - Monto: "+tipo+"\n  - Cantidad: "+$$("#RS_cantidad").val()+"  \n\n ¿Desea actualizar el monto "+tipo+"?");
		if(confirma)
		{
			var NA = $$("#RS_num_accion").val();
			$$.ajax({
				type: "POST",
				url: "cont/po_reintegros_form.php",
				beforeSend: function(){ $$("#IR_res").slideDown(); $$('#IR_res').html(" <center> <br><br> <b> <img src='images/load_grande.gif' /> Espere... <br><br> </b> </center> ") },
				data: {
						RS_tipo:$$("#RS_tipo").val(),
						RS_cantidad:$$("#RS_cantidad").val(),
						RS_accion:$$("#RS_num_accion").val(),
						RS_formulario:$$("#formNvoMonto").val(),
						RS_direccion:$$("#indexDir").val()
					},
				success: function(data) 
					{ 	
						//alert(NA+"\n"+data);
						$$('#IR_res').load("procesosAjax/po_reintegros_calcula.php?RS_accion="+NA+"&numAccion"+NA);
						$$("#RS_tipo").val(''); 
						$$("#RS_cantidad").val('');
						cerrarCuadro2();
						mostrarCuadro(600,900,"Informacion de la Acción",20,"cont/po_informacion.php","numAccion="+accion)
					}
			});
		}//end confirm 
	}
}
//-------------------------------
function cambiaNum(miNum,formulario)
{
	var frm = document.forms[formulario];	
	var reNumero = /^d{1,3}(,d{3,3})*(.d+)?$/gi; // con decimales
	var numDec = /^(\d{1,3}\,*)(\d{3}\,?)*(.\d{2})?$/;
	var reEntero = /^d{1,3}(.d{3,3})*$/gi; // sin decimales	

	var num = document.getElementById(miNum).value;
	
 	var numero = new oNumero(num)
	var nuevoNum = numero.formato(2, true);
	
	if(nuevoNum.search(numDec) == -1) 
	{
		alert('El numero esta mal capturado: '+nuevoNum);
		document.getElementById(miNum).focus();
	}
	else
	{
		document.getElementById(miNum).value = nuevoNum;
		//frm.submit();
	}
}

</script>
<?php 
	$tamNiv = strlen($_REQUEST['nivel']);
	if($_REQUEST['direccion'] == "DG" || $_REQUEST['nivel'] == "S" || $tamNiv == 5 || $tamNiv == 3 || $tamNiv == 1) {?>
	<a href="#" title="Asignar Acción" class="" onClick=" new mostrarCuadro2(250,800,'Asignar Acción <?php echo $_REQUEST['numAccion'] ?>',100,'cont/po_asigna_acciones.php','accion=<?php echo $_REQUEST['numAccion'] ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> 
    	<img src="images/User-Files-iconAcc.png"> Reasignar Accion 
    </a>
<?php } ?>
<div id="message-green">

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
    <td class="green-left">
	    <div id='resultado' style="line-height:normal"></div>
    </td>
    <td class="green-right"><a class="close-green"><img src="images/table/icon_close_green.gif" onClick="cerrarMsg()"  alt="" /></a></td>
</tr>
</table>
</div>

<div class="contInfo">
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);

$sql = $conexion->select("SELECT 
								po.num_accion,
								po.numero_de_pliego,
								po.cp,
								po.num_auditoria,
								po.entidad_fiscalizada,
								po.direccion,
								po.subdirector,
								po.abogado,
								po.fecha_estado_tramite,
								po.hora_act_edo_tram,
								po.detalle_de_estado_de_tramite,
								po.prescripcion,
								po.irregularidad_general,
								po.ip_edo_tram,
								po.subnivel,
								po.fecha_de_irregularidad_general,
								fondos.num_accion,
								fondos.fondo,
								fondos.UAA,
								usuarios.nombre,
								usuarios.usuario,
								estados_tramite.detalle_estado,
								estados_tramite.id_sicsa,
								estados_sicsa.id_sicsa,
								estados_sicsa.estado_sicsa
						FROM po 
						LEFT JOIN fondos ON po.num_accion = fondos.num_accion 
						LEFT JOIN usuarios ON po.ip_edo_tram = usuarios.usuario
						INNER JOIN estados_tramite ON detalle_de_estado_de_tramite = id_estado
						INNER JOIN estados_sicsa ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa
						WHERE po.num_accion = '".$accion."'",false);

$monto_PO = floatval($ra['monto_de_po_en_pesos']);
$intereses = floatval($rm['intereses']);
$monto_PO_modificado = floatval($ra['monto_modificado']);
$cant_reintegrada=floatval($monto_PO) + floatval($intereses);
$cant_reintegrada_mod=floatval($monto_PO_modificado) + floatval($intereses);

$total = mysql_num_rows($sql);			
$r = mysql_fetch_array($sql);

$nivPart = explode(".",$r['subnivel']);
$nivDir = $nivPart[0];
$nivSbd = $nivPart[0].".".$nivPart[1];
$nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
$nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' and status = 1 ",false);
$d = mysql_fetch_array($sql1);
$director = $d['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' and status = 1 ",false);
$s = mysql_fetch_array($sql1);
$subdirector = $s['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' and status = 1 ",false);
$d = mysql_fetch_array($sql1);
$jefe = $d['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."'and perfil like '%Coordinador%' and status = 1 ",false);
$d = mysql_fetch_array($sql1);
$coordinador = $d['nombre'];


		
?>
        <table align="center" class='tablaInfo' width="100%">
          <!--
          <tr>
            <td colspan="4"><h3>Detalles Generales de la Acción <?php echo $accion ?></h3></td>
          </tr>
          -->
          
          
          
          <tr>
           <td><p class="etiquetaInfo redonda3">Director</p></td>
            <td><p class="txtInfo">Lic. <?php echo $director  ?> </p></td>
             <td><p class="etiquetaInfo redonda3">PO</p></td>
            <td><p class="txtInfo"> 
			
			<a href="cont/pf/pfrr.php?accion=<?php echo $_REQUEST['numAccion'] ?>" title="Resolución"> 
    	<img src="images/User-Files-iconAcc.png"> Resolución
			</a>
			
			</p></td>   
                  
          </tr>
          <tr>
          
            <td><p class="etiquetaInfo redonda3">Subdirector</p></td>
            <td><p class="txtInfo">Lic.  <?php echo $subdirector  ?></p></td>
            <td><p class="etiquetaInfo redonda3">Cuenta P&uacute;blica</p></td>
            <td><p class="txtInfo"> <?php echo $r['cp']; ?> </p></td>            
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Jefe de Departamento</p></td>
            <td><p class="txtInfo">           Lic.  <?php echo $jefe  ?></td>
            <td><p class="etiquetaInfo redonda3">N&uacute;mero de Auditor&iacute;a</p></td>
            <td><p class="txtInfo"><?php echo $r['num_auditoria']; ?></p></td>            
          </tr>
          <tr>
          <td><p class="etiquetaInfo redonda3">Abogado Responsable</p></td>
            <td><p class="txtInfo">Lic. <?php echo $r['abogado']; ?><?php echo $row_asignacion['nombre']; ?></p></td>
          <td><p class="etiquetaInfo redonda3">Fecha de irregularidad General</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_de_irregularidad_general']) ?></p></td>
            </tr>            
           <tr>
           <td><p class="etiquetaInfo redonda3">UAA</p></td>
            <td><p class="txtInfo"><?php echo $r['UAA']; ?></p></td>
             <td><p class="etiquetaInfo redonda3">Fecha de Irregularidad</p></td>
            <td> <p class="txtInfo">
            <form name="fpress">
            	 <input class="redonda5" id="f1_fecha_presc" name="f1_fecha_presc" type="text" value='<?php echo fechaNormal($r['fecha_de_irregularidad_general']) ?>' readonly>
			
                 <input class="submit_line" type="button" name="Registrar"  id="Registrar" value="Guardar Fecha" onClick="guardaPrescripcion()">
                 <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
            </form>
            <tr>           
            <td> <p class="etiquetaInfo redonda3">Fondo</p></td> </td>
            <td><p class="txtInfo"><?php echo $r['fondo']; ?></p></td>
            
            
            <tr>       <td><div class="etiquetaInfo redonda3"> Monto </div></td>
            <td><p class="txtInfo">
			<?php 
				echo  number_format(dameTotalPO($accion),2)
			?></p></td>
          
             <tr>
             <td><p class="etiquetaInfo redonda3">Fecha &Uacute;ltima Actualizaci&oacute;n</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_estado_tramite']); ?></td>         
            </tr>
            <tr>
            <td><p class="etiquetaInfo redonda3">Hora &Uacute;ltima Actualizaci&oacute;n</p></td>
            <td><p class="txtInfo"><?php echo $r['hora_act_edo_tram']; ?></p></td>          
            </tr>            
            <tr>           
             <td><p class="etiquetaInfo redonda3">Actualizado por</p></td>
            <td><p class="txtInfo">           Lic.  <?php echo $r['nombre']; ?></p></td> 
             </tr>
         
          
          	</p>
           
          	<td align="center" colspan="10">
            </td>
        </table>
<!-- ------------------------------------------------------------------------------------------------------------------------------ -->     
        <table width="100%" align="center" >
          <tr>
            <td class="search"><p class="etiquetaInfo2 redonda3">Irregularidad General</p></td>
          </tr>
          <tr>
            <td><p style="text-align:justify; padding:5px"><?php 
			//string htmlentities ( string $string [, int $flags = ENT_COMPAT | ENT_HTML401 [, string $encoding = 'UTF-8' [, bool $double_encode = true ]]] )
			//echo $r['irregularidad_general']."<br><br>";
			//echo html_entity_decode($r['irregularidad_general'],ENT_QUOTES)."<br><br>";
			//echo htmlentities($r['irregularidad_general'],ENT_QUOTES)."<br><br>";
			//echo utf8_decode($r['irregularidad_general'])."<br><br>";
			echo aHtml($r['irregularidad_general'])
			
			 ?></p></td>
          </tr>
          <!-- ---------------------------- ESTADOS DE REINTEGRO ------------------------------------------------ -->
          <tr>
            <td class="search"><p class="etiquetaInfo2 redonda3">Monto Irregularidad General</p></td>
          </tr>
          <!--
          <tr>
          <td align="center">
            	<CENTER>
            	<form method="post" name="formM" action="<?php echo $editFormAction; ?>" onSubmit="return false">
                  <table width="40%" height="" align="center" class="center RS_tabForm">
                    <tr valign="baseline" style="border:0">
                      <td width="17%" style="border:0"><p class="etiquetaInfo redonda3">Monto del Pliego:</p></td>
                      <td width="17%" style="border:0"><label for="monto_de_po_en_pesos"></label>
                      <input name="monto_de_po_en_pesos" type="text" id="monto_de_po_en_pesos" value="<?php echo number_format($r['monto_de_po_en_pesos'],2) ?>" ></td>
                      
                      <td width="7%" style="border:0">
                      <p>
                        <input type="image" src="../busca_po.png" name="Registrar"  id="Registrar" value="Registrar" onClick="cambiaNum('monto_de_po_en_pesos','formM')">
                        <input type="hidden" name="num_accion2" value="<?php echo $r['num_accion']; ?>">
                        <input type="hidden" name="MM_update" value="formMonto">
                       </p>
                      </td>
                    </tr>
                  </table>
            </form>
            </CENTER>
            </td>
          </tr>
          -->

        </table>
<!-- ---------------------------- FIN ESTADOS DE REINTEGRO ------------------------------------------------ -->
<!-- ---------------------------- codigo rubens ----------------------------------------------------------- -->

<div id='IR_res'>
	<?php require_once('../procesosAjax/po_reintegros_calcula.php'); ?>
</div>

<!-- ------------------------------------------------------------------------------------------------------ -->
      </div>
    </div>
    
    <input type="hidden" name="hiddenField" id="hiddenField">


</div>

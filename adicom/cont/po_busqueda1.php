<script>
function nuevaBusqueda()
{
	$$('#conTabla2').slideDown();
	$$('#resultadoConsulta').slideUp();
	$$('#busquedaNueva').slideUp();
	$$('#busquedaLimits').slideUp();
}

function buscaAccionAvanzada(envio,limit)
{
	if(envio != "excel"){
		$$("#conTabla2").slideUp();
		$$("#busquedaNueva").slideDown();
		$$("#resultadoConsulta").slideDown();
	}
	
	if(limit == "" || limit == undefined) limit = "";
	if(envio == "" || envio == undefined) envio = "";

	reports = <?php echo $_REQUEST['reports'] ?>;
	divres = document.getElementById('resultadoConsulta');
	divtot = document.getElementById('resTotal');
	accion = document.getElementById('noAccion').value;
	ef = document.getElementById('ef').value;
	cp = document.getElementById('cp').value;
	edoTram = document.getElementById('edoTram').value;
	aud = document.getElementById('aud').value;
	direccion = document.getElementById('direccion').value;
	pobus=document.getElementById('pobus').value;
	uaa=document.getElementById('uaa').value;
	fondo=document.getElementById('fondo').value;
	director= document.getElementById('director').value;
	subdirector= document.getElementById('subdirector').value;
	presunto= document.getElementById('presunto').value;
	edoSicsa= document.getElementById('edoSicsa').value;
	fecha = document.getElementById('fecha').value;
	anio=document.getElementById('anio').value;
	jefe_depto=document.getElementById('jefe_depto').value;
	direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	tipo_devolucion = document.getElementById('tipo_devolucion').value;
	fechaci='<?php $sql=$conexion-> select("Select fecha_estado_tramite from po where num_accion ='".$accion."'") ?>'
	//------------ checkbox -------------------------------------
	cpCh = document.getElementById('cpCh').checked;
	efCh = document.getElementById('efCh').checked;
	direccionCh = document.getElementById('direccionCh').checked;
	subdirectorCh = document.getElementById('subdirectorCh').checked;
	abogadoCh = document.getElementById('abogadoCh').checked;
	termiIrrCh = document.getElementById('termiIrrCh').checked;
	noPliegoCh = document.getElementById('noPliegoCh').checked;
	prescripcionCh = document.getElementById('prescripcionCh').checked;
	fondoCh = document.getElementById('fondoCh').checked;
	uaaCh = document.getElementById('uaaCh').checked;
	montoCh = document.getElementById('montoCh').checked;
	etCh = document.getElementById('etCh').checked;
	esCh = document.getElementById('esCh').checked;
	audch = document.getElementById('audch').checked;
	jefe_deptoch = document.getElementById('jefe_deptoch').checked;
	tipoPO = document.getElementById('tipoPO').value;
	cf_ch = document.getElementById('cf_ch').checked;
	dgatic_ch = document.getElementById('dgatic_ch').checked;
	gf_ch = document.getElementById('gf_ch').checked;
	//------------ checkbox -------------------------------------
	
	if(envio != "excel"){
		//new mostrarCuadro(600,1200,"Cargando...",20)
		$$('#resultadoConsulta').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
		$$('#resTotal').html("Buscando... ");
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/ajax_busqueda_acciones_avanzada.php",true);
		ajax.onreadystatechange=function() 
		{
			if (ajax.readyState==4) 
			{
				txt = ajax.responseText.split("|||");
				//alert(ajax.responseText);
				/*
				var selector = "";
				selector += '<select name="limit" id="limit" class="redonda5" onchange="buscaAccionAvanzada()">';
				selector += '<option value="" selected="selected">Número de Páginas</option>';
				selector += '<option value="limit 0,50" >Pagina 1</option>';
				selector += '<option value="limit 51,100" >Pagina 2</option>';
				selector += '<option value="limit 101,150" >Pagina 3</option>';
				selector += '<option value="limit 151,200" >pagina 4</option>';
				selector += '<option value="limit 201,250" >Pagina 5</option>';
				selector += '</select>';
				*/
				//espacios = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				var tablaHtml = txt[0];
				var accionesNum = txt[1];
				var tablaHtmlCod = txt[2];
				var sqlNl2br = txt[3];
				var sqlText = txt[4];
				var paginacion = txt[5];
				
				if(accionesNum > 1000) {
					var desde = 1000;
					var hasta = 1000;
					
					selector = '<select name="limit" id="limit" class="redonda5" onchange="buscaAccionAvanzada(this.value,this.value)">';
					selector += '<option value="" selected="selected">Número de Página</option>';
					
					//alert(paginacion);
	
					for(i=1; i<=paginacion; i++ ) {
						desde = hasta - 999;
						selector += '<option value="limit '+desde+','+hasta+'" >Página '+i+'</option>';
						hasta = hasta + 1000;
					}
					
					selector += '</select>';
					
					$$('#busquedaLimits').slideDown();
					
					$$('#selector').html(selector);
				}
				
				$$('#resTotal').html(accionesNum+" accione(s) encontradas");
				//---muestra SQL ----------------
				//divres.innerHTML = txt[0] + txt[3] + txt[4];
				divres.innerHTML = tablaHtml;
				$$('#export').val(tablaHtmlCod);
				$$('#divDescarga').slideDown();
				//divtot.innerHTML = "<h3>"+txt[1]+" Accion(es) Encontrada(s)</h3>";
				//if(envio == "excel") document.formExcel.submit();
	
	
			}
		}
		//muy importante este encabezado ya que hacemos uso de un formulario
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//enviando los valores
		ajax.send("accion="+accion+"&direccion="+direccion+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+"&presunto="+presunto+"&edoSicsa="+edoSicsa+"&fecha="+fecha+"&anio="+anio+"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+"&tipo_devolucion="+tipo_devolucion+"&cpCh="+cpCh+"&efCh="+efCh+"&direccionCh="+direccionCh+"&subdirectorCh="+subdirectorCh+"&abogadoCh="+abogadoCh+"&termiIrrCh="+termiIrrCh+"&noPliegoCh="+noPliegoCh+"&prescripcionCh="+prescripcionCh+"&fondoCh="+fondoCh+"&uaaCh="+uaaCh+"&montoCh="+montoCh+"&etCh="+etCh+"&esCh="+esCh+"&audch="+audch+"&reports="+reports+"&jefe_depto="+jefe_depto+"&jefe_deptoch="+jefe_deptoch+"&tipoPO="+tipoPO+"&cf_ch="+cf_ch+"&dgatic_ch="+dgatic_ch+"&gf_ch="+gf_ch);
	} else {
		//alert("Creo q quieres un excel");
		window.location.href = "procesosAjax/ajax_busqueda_acciones_avanzada_excel.php?"+"accion="+accion+"&direccion="+direccion+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+"&presunto="+presunto+"&edoSicsa="+edoSicsa+"&fecha="+fecha+"&anio="+anio+"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+"&tipo_devolucion="+tipo_devolucion+"&cpCh="+cpCh+"&efCh="+efCh+"&direccionCh="+direccionCh+"&subdirectorCh="+subdirectorCh+"&abogadoCh="+abogadoCh+"&termiIrrCh="+termiIrrCh+"&noPliegoCh="+noPliegoCh+"&prescripcionCh="+prescripcionCh+"&fondoCh="+fondoCh+"&uaaCh="+uaaCh+"&montoCh="+montoCh+"&etCh="+etCh+"&esCh="+esCh+"&audch="+audch+"&reports="+reports+"&jefe_depto="+jefe_depto+"&jefe_deptoch="+jefe_deptoch+"&tipoPO="+tipoPO+"&cf_ch="+cf_ch+"&dgatic_ch="+dgatic_ch+"&gf_ch="+gf_ch;
	}
	//-----------------funcion estados-------------//
	
	
	//ajax.send("idempleado="+id+"&nombres="+nom+"&departamento="+dep+"&sueldo="+suel)
}
//------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------
function Sicsa()
{
	if(edoTram ==0){
		document.getElementById("edoSicsa").selectedIndex="0";
	} 
	edoTram= document.getElementById("edoTram").value
	
	if(edoTram==2 || 3 || 4 ) {
		document.getElementById("edoSicsa").selectedIndex="2";
	} 
		
	if(edoTram ==1) {
		document.getElementById("edoSicsa").selectedIndex="1";
	} 
		
	if(edoTram==6) {
		document.getElementById("edoSicsa").selectedIndex="3";
	} 

	if(edoTram==7) {
		document.getElementById("edoSicsa").selectedIndex="4";
	} 
		
	if(edoTram==8){
		document.getElementById("edoSicsa").selectedIndex="5";
	} 
	
	if(edoTram==9){
		document.getElementById("edoSicsa").selectedIndex="6";
	} 

	if(edoTram==10) {
		document.getElementById("edoSicsa").selectedIndex="7";
	} 
}
//-------------------------------------------------------------------------
function ControlInterno()
{
	if(edoSicsa==0) {
		document.getElementById("edoTram").selectedIndex="0";
	}
	
	if(edoSicsa==1){
		document.getElementById("edoTram").selectedIndex="1";
	}
}
//-------------------------------------------------------------------------
function marcar(obj,chk) {
	elem=obj.getElementsByTagName('input');
  for(i=0;i<elem.length;i++)
  	elem[i].checked=chk.checked;
}
</script>

<style>
select,input[type="text"]{ width:200px !important; margin:3px}
.inFec{ width:100px !important}
checkbox{width:10px}
.tds td{ padding:3px}
</style>

<?php $ver = $_SESSION['direccion']; 
if($ver != "DG")
{ $cons = "and direccion = '".$ver."' "; }
?>

<!--  start content-table-inner -->
<div id="content-table-inner">
  <link rel="stylesheet" href="css/estilo.css" type="text/css" media="screen" title="default" />
    <div class="conTabla2" id="conTabla2">
        <!--  start product-table ..................................................................................... -->
        <form onkeypress="if(event.keyCode == 13) buscaAccionAvanzada()">
        
        <br />
        <center>
            <table border="0" align="center" width="70%">
              <tr>
                <td class="etiquetaPo" >
                  Acción:</td>
                <td ><input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>
                     <label for="ver_accion"></label></td>
                     
                <td class="etiquetaPo" >Entidad Fiscalizada: </td>
                <td ><input type="text" name="ef" id="ef" class="redonda5" size="30"/></td>
                </tr>
                
                
              <tr>
                <td class="etiquetaPo" >PO:</td>
                <td><input type="text" name="noAccion2" id="pobus" class="redonda5" size=""/></td>
                <td class="etiquetaPo" >Director:</td>
                <td><select name='director' id='director' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 1 AND puesto = 'Director de Área' ".$cons." AND status != '0' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'"> Lic. '.$r['nombre'].'</option>';
                 
                 ?>          
                  </select>
                
                
                </td>
              </tr>
              <tr>
                <td class="etiquetaPo" >Cuenta Pública:</td>
                <td>
                  <select name='cp' id='cp' class="redonda5" >
                    <option value="0" selected="selected">Elegir</option>
                    <!----- option value="2007">2007</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option---->
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
                  </select>
                
                   </td>
                <td class="etiquetaPo" >Subdirector:</td>
                <td>
                
                 <select name='subdirector' id='subdirector' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 ".$cons." AND status != '0' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'">Lic. '.$r['nombre'].'</option>';
                 
                 ?>           
                  </select>
                
                </td>
                
              </tr>
                            
              <tr>
                                <td  class="etiquetaPo"  >Jefe de Departamento: </td>
                  <td>
                  <select name='jefe_depto' id='jefe_depto' class="redonda5" >
                    <option value="" selected="selected">Elegir</option>
                    <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 5 ".$cons." AND status != '0' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'">Lic. '.$r['nombre'].'</option>';
                 
                 ?> 

                  </select>

              
                <td class="etiquetaPo" >Auditoría:</td>
                <td>
                  <input type="text" name="aud" id="aud" class="redonda5" size="10" align="center"/>
                
                   </td>
              </tr>
              <tr>
                <td class="etiquetaPo" >FONDO:</td>
                <td  >
                
                <select name='fondo' id='fondo' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT `fondo` FROM `fondos` GROUP BY `fondo` ORDER BY `fondo` asc",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['fondo'].'">'.$r['fondo'].'</option>';
                 
                 ?>           
                </select>
                
                 
                
                   </td>
                <td class="etiquetaPo" >Estado:</td>
                <td>
                  <select name='edoTramite' id='edoTram' class="redonda5" onchange="Sicsa()">
                    <option value="0" selected="selected">Elegir</option>
                    <option value="1">Emisión/Corrección del PPO por la UAA</option>
                    <option value="2">Opinión del PPO</option>
                    <option value="3">Asistencia Jurídica</option>
                    <option value="5">En Proceso de notificación del PO</option>
                    <option value="6">Notificado</option>
                    <option value="7">ET, PO y oficios notificados a la UAA</option>
                    <option value="8">Baja por Conclusión Previa a su Emisión</option>
                    <option value="9">Solventada</option>
                    <option value="27">Concluída</option>
                    <option value="10">DTNS</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td  class="etiquetaPo"  >UAA: </td>
                <td>
                
                <select name='uaa' id='uaa' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT `UAA` FROM `fondos` GROUP BY `UAA` ORDER BY `UAA` asc",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['UAA'].'">'.$r['UAA'].'</option>';
                 
                 ?>           
                </select>
          
                </td>
                <td class="etiquetaPo" >Estado SICSA: </td>
                <td>
                  <select  disabled="disabled" name='edoSicsa' id='edoSicsa' class="redonda5" onchange="ControlInterno()" >
                    <option value="0" selected="selected">Elegir</option>
                    <option value="1">Publicada IR</option>
                    <option value="2">Elaboración del Pliego</option>
                    <option value="3">Emitida</option>
                    <option value="4">Sin Respuesta/Respuesta en Analisis</option>
                    <option value="5">Baja por Conclusión Previa a su Emisión</option>
                    <option value="6">Solventada</option>
                    <option value="7">DTNS</option>
                  </select>
                <label></label>
                
                </td>
                </tr>
              <tr>
                <td class="etiquetaPo" >
                  Fecha de prescripción:          
                  </td>
                <td >
                  <select name='fecha' id='fecha' class="redonda5 inFec" >
                    <option value="0" selected="selected">Elegir</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                  </select>
                  <select name='anio' id='anio' class="redonda5 inFec" >
                    <option value="0" selected="selected">Elegir</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
					<option value="2018">2018</option>
                    </select>
                </td>
                <td class="etiquetaPo" >Tipo de Devolución: </td>
                <td >
                  <select name='tipo_devollucion' id='tipo_devolucion' class="redonda5" >
                    <option value="" selected="selected">Elegir</option>
                    <option value="inexistencia">Inexistencia de daño/perjuicio</option>
                    <option value="irregularidad">Fecha de irregularidad incorrecta</option>
                    <option value="soporte"> Falta de documentación soporte del recurso erogado</option>
                    <option value="inadecuada">Acción u omisión inadecuada (incorrecta)</option>
                    <option value="papeles">Papeles de trabajo no cuadran</option>
                    <option value="docu_irregularidad">Fecha de documentación que acredite la irregularidad</option>
                    <option value="monto_no_preciso">Monto no preciso /exacto con el soporte documental</option>
                    <option value="mezcla">Mezcla de recursos</option>
                    <option value="presun_res">Falta de documentación que acredite la presunta responsabilidad</option>
                    <option value="datos">Falta de datos personales (PR)</option>
                    <option value="dlegible">Documentación ilegible</option>
                    <option value="indebida_fun">Indebida fundamentación</option>
                    <option value="otros">Otros</option>
                    <option value="observaciones">Sin Observaciones</option>
                    <option value="nosonPR">No son los PR</option>
                  </select>
                </td>
                <tr>
                    <td class="etiquetaPo" >Presunto:</td>
                    <td>
                      <input type="text" name="presunto" id="presunto" class="redonda5" size="30"/>
                    </td>
                    <td class="etiquetaPo" >Tipo PO:</td>
                    <td>
                      <select class="redonda5" name="tipoPO" id="tipoPO">
                      	<option value='normal'>Normal</option>
                      	<option value='ampliado'>Ampliado</option>
                      </select>
                    </td>
				</tr>
                </tr>
                <tr>
                  <td class="etiquetaPo" >
                    Información a mostrar:          
                    </td>
                  <td colspan="3">
                    <br /><br />
                    <table width="100%" class="tds">
                      <tr>
                        <td><input type="checkbox" name="cpCh" id="cpCh" checked="checked"  /> Cuenta Pública</td>
                        <td><input type="checkbox" name="efCh" id="efCh" checked="checked"  /> Entidad Fiscalizada</td>
                        <td><input type="checkbox" name="direccionCh" id="direccionCh" checked="checked"  /> Dirección</td>
                        <td><input type="checkbox" name="subdirectorCh" id="subdirectorCh" checked="checked"  /> Subdirector</td>
                        <td><input type="checkbox" name="abogadoCh" id="abogadoCh" checked="checked"  /> Abogado</td>
                        
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="termiIrrCh" id="termiIrrCh" checked="checked"  /> Término Irregularidad</td>
                        <td><input type="checkbox" name="noPliegoCh" id="noPliegoCh" checked="checked"  /> Número de Pliego</td>
                        <td><input type="checkbox" name="prescripcionCh" id="prescripcionCh" checked="checked"  /> Prescripción</td>
                        <td><input type="checkbox" name="fondoCh" id="fondoCh" checked="checked"  /> Fondo</td>
                        <td><input type="checkbox" name="uaaCh" id="uaaCh" checked="checked"  /> UAA</td>
                        
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="montoCh" id="montoCh" checked="checked"  /> Monto</td>
                        <td><input type="checkbox" name="etCh" id="etCh" checked="checked"  />Estado de Trámite</td>
                        <td><input type="checkbox" name="esCh" id="esCh" checked="checked" /> Estado Sicsa</td>
                        <td><input type="checkbox" name="audch" id="audch" checked="checked" />Auditoria</td>
                        <td><input type="checkbox" name="jefe_deptoch" id="jefe_deptoch" checked="checked" />Jefe de Departamento</td>
                        <td>&nbsp;</td>
                        </tr>
                      <!----- tr>
                        <td><input type="checkbox" name="cf_ch" id="cf_ch" checked="checked" />CF</td>
                        <td><input type="checkbox" name="dgatic_ch" id="dgatic_ch" checked="checked" />DGATIC</td>
						<td><input type="checkbox" name="gf_ch" id="gf_ch" checked="checked" />GF</td>
						<td>&nbsp;</td>
                        </tr-------->
						<tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
						<td>&nbsp;</td>
                        </tr>
                      </table>
                    
			<input type="checkbox" onclick="marcar(this.parentNode,this)" checked="checked"   /><strong>Seleccionar todo:</strong>
					
                    </td>
                </tr>
            </table>
            <br />
            </center>
            <br /><br />
            <center>
              <table border="0" width="50%" align="center">
                <tr>
                  <td align="center">
                    <input type="hidden" name="direccion" id="direccion" value="<?php echo $_SESSION['direccion'] ?>" />
                    <input type="button" value="     Buscar      " name="Buscar" onclick="buscaAccionAvanzada()" class="submit-login" />
        </FORM>
        
                  </td>
                  <!--
                  <td align="center">
                  <form name="formExcel" action="excel.php" method = "POST">
                    <input type="hidden" class="" name="export"  id='export' value=""/>
                    <input type='hidden' name='nombre_archivo' value='listado_acciones'/>
                    <input type = "button" value = "Exportar a Excel" class="submit-login" onclick="buscaAccionAvanzada('excel')"/>
                  </form>
        			-->
                </td>
                </tr>
            </table>
            </center>
            </br>
                  
          <!-- ------------- TABLA DE RESULTADOS ------------->
          <!-- ------------- aqui entran las llamadas ajax ------------->
          <!--
                </div>
                <div class="conTabla">
                  <div class="encTabla">
                <table border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
                <thead>
                    <tr>
                        <th class="accion"><a href="#">Accion</a>	</th>
                        <th class="entidad"><a href="#">Entidad Fiscalizada</a></th>
                        <th class="direccion"><a href="#">Direccion</a></th>
                        <th class="subdirector"><a href="#">Subdirector</a></th>
                        <th class="abogado"><a href="#">Abogado</a></th>
                        <th class="estado"><a href="#">Estado</a></th>
                        <th class="acciones"><a href="#">Seguimiento</a></th> 
                    </tr>
                </thead>
                </table>
            </div>
            -->
            <!--
            <div id='resAcciones' class='resAcciones bodyTabla' style="height:300px"></div>
            -->
        </div> <!-- endo contable -->
    <div onclick="nuevaBusqueda()" style="display:none; float:left" id="busquedaNueva" class="submit-login redonda5">
        <div id="resTotal" style="display:inline-block; width:200px; padding:11px; border-right:1px solid #FFF; text-align:center">Buscando... &nbsp;&nbsp;&nbsp;</div>
        <div id="nvaBus" style="display:inline-block; width:200px; padding:3px; text-align:center"> &nbsp;&nbsp;&nbsp;Nueva Búsqueda... </div>
    </div>
    
    <div id="busquedaLimits" style="display:none; float:left; margin:0 10px; width:500px" >
        <div style="margin:0 10px" class="submit-login redonda5">
            <span>Mostrar página: </span><span id='selector'></span>
        </div>
    </div>

    <div id="divDescarga" style="display:none;  padding:11px; float:right; margin:0 10px; width:230px" class="submit-login redonda5" >
    	<center> <span> <input type="button" value="Descargar en Excel" class="redonda5" onclick="buscaAccionAvanzada('excel')" /></span> </center>
    </div>
    
    <div style="clear:both"></div>
    
        <div id="resultadoConsulta" style="width:100%">
            <div id="resTotal"></div>
        </div>

        
        
        <!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
        <!--
        <div id="related-activities">
            
        <!-- INCLUIMOS NOTIFICACONES -->    
        <?php 
            //require_once("cont/po_notificaciones.php");
        ?>
        <!-- INCLUIMOS NOTIFICACONES -->
        <!--
        </div>
        <!-- end related-activities -->

    
  </div>
  
<!--
<div>
  
  <select name='limit' id='limit' class="redonda5" onchange="buscaAccionAvanzada()">
            <option value="" selected="selected">Elegir</option>
            <option value="limit 0,50" >Pagina 1</option>
            <option value="limit 51,100" >Pagina 2</option>
            <option value="limit 101,150" >Pagina 3</option>
            <option value="limit 151,200" >pagina 4</option>
            <option value="limit 201,250" >Pagina 5</option>
            
          </select>
  
  </div>
  -->
<!--  end content-table-inner  -->

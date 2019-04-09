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
    //--Superveniente--
	nosuperveniente = document.getElementById('superveniente').value;
	//--Superveniente--
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
	edoSicsa= document.getElementById('edoSicsa').value;
	jefe_depto=document.getElementById('jefe_depto').value;
	direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	
	fechaci='<?php $sql=$conexion-> select("Select fecha_estado_tramite from po where num_accion ='".$accion."'") ?>'
	//------------ checkbox -------------------------------------
	supervenientech = document.getElementById('supervenientech').checked;
	//-- super ..
	cpCh = document.getElementById('cpCh').checked;
	
	efCh = document.getElementById('efCh').checked;
	direccionCh = document.getElementById('direccionCh').checked;
	subdirectorCh = document.getElementById('subdirectorCh').checked;
	abogadoCh = document.getElementById('abogadoCh').checked;
	termiIrrCh = document.getElementById('termiIrrCh').checked;
	noPliegoCh = document.getElementById('noPliegoCh').checked;
	fondoCh = document.getElementById('fondoCh').checked;
	uaaCh = document.getElementById('uaaCh').checked;
	montoCh = document.getElementById('montoCh').checked;
	etCh = document.getElementById('etCh').checked;
	esCh = document.getElementById('esCh').checked;
	audch = document.getElementById('audch').checked;
	jefe_deptoch = document.getElementById('jefe_deptoch').checked;

	
	//------------ checkbox -------------------------------------

	
	if(envio != "excel"){
		//new mostrarCuadro(600,1200,"Cargando...",20)
		$$('#resultadoConsulta').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
		$$('#resTotal').html("Buscando... ");
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/ajax_busqueda_acciones_avanzadasa.php",true);
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
		ajax.send("accion="+accion+"&nosuperveniente="+nosuperveniente+"&direccion="+direccion+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+ /* "&presunto="+presunto+ */ "&edoSicsa="+edoSicsa+ /* JFA "&fecha="+fecha+"&anio="+anio+  */"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */"&cpCh="+cpCh+ "&supervenientech="+supervenientech+"&efCh="+efCh+"&direccionCh="+direccionCh+"&subdirectorCh="+subdirectorCh+"&abogadoCh="+abogadoCh+"&termiIrrCh="+termiIrrCh+"&noPliegoCh="+noPliegoCh+ /*"&prescripcionCh="+prescripcionCh+*/"&fondoCh="+fondoCh+"&uaaCh="+uaaCh+"&montoCh="+montoCh+"&etCh="+etCh+"&esCh="+esCh+"&audch="+audch+"&reports="+reports+"&jefe_depto="+jefe_depto+"&jefe_deptoch="+jefe_deptoch); // +"&tipoPO="+tipoPO);
	} else {
		//alert("Creo q quieres un excel");
		window.location.href = "procesosAjax/ajax_busqueda_acciones_avanzada_excelsa.php?"+"accion="+accion+"&nosuperveniente="+nosuperveniente+"&direccion="+direccion+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+ /*"&presunto="+presunto+ */"&edoSicsa="+edoSicsa+ /* JFA "&fecha="+fecha+"&anio="+anio+ */ "&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */ "&cpCh="+cpCh+"&supervenientech="+supervenientech+"&efCh="+efCh+"&direccionCh="+direccionCh+"&subdirectorCh="+subdirectorCh+"&abogadoCh="+abogadoCh+"&termiIrrCh="+termiIrrCh+"&noPliegoCh="+noPliegoCh+/*"&prescripcionCh="+prescripcionCh+*/"&fondoCh="+fondoCh+"&uaaCh="+uaaCh+"&montoCh="+montoCh+"&etCh="+etCh+"&esCh="+esCh+"&audch="+audch+"&reports="+reports+"&jefe_depto="+jefe_depto+"&jefe_deptoch="+jefe_deptoch; //+"&tipoPO="+tipoPO;
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
-->
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

<!--  start content-table-inner -->
<div id="content-table-inner">
  <link rel="stylesheet" href="css/estilos_opiniones.css" type="text/css" media="screen" title="default" />
    <div class="conTabla2" id="conTabla2">
        <!--  start product-table ..................................................................................... -->
        <form onkeypress="if(event.keyCode == 13) buscaAccionAvanzada()">
        
        <br />
        <center>
            <table border="0" align="center" width="70%">
              <tr>
                <td class="etiquetaPo" >
                  Acción SA:</td>
                <td ><input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>
                     <label for="ver_accion"></label></td>
                     
                <td class="etiquetaPo" >Entidad Fiscalizada: </td>
                <td ><input type="text" name="ef" id="ef" class="redonda5" size="30"/></td>
                </tr>


	            
				
								
              <tr>
                <td class="etiquetaPo" >No. Pliego:</td>
                <td><input type="text" name="noAccion2" id="pobus" class="redonda5" size=""/></td>
				
                <td class="etiquetaPo" >Director:</td>
                <td><select name='director' id='director' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 1 AND puesto = 'Director de Área' AND status != 0 ORDER BY nivel",false);
                 
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
                 
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
					<option value="2015">2015</option>
                  </select>
                
                   </td>
                <td class="etiquetaPo" >Subdirector:</td>
                <td>
                
                 <select name='subdirector' id='subdirector' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 AND status != 0 ORDER BY nivel",false);
                 
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
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 5 ".$cons." ORDER BY nivel",false);
                 
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
                    <option value="OTROS">OTROS</option>
                    <option value="FAEB">FAEB</option>
                    <option value="FISE">FISE</option>
                    <option value="FAM">FAM</option>
                    <option value="FASP">FASP</option>
                    <option value="FASSA">FASSA</option>
                    <option value="CONVENIOS">CONVENIOS</option>
                    <option value="FAETA">FAETA</option>
                    <option value="FAFEF">FAFEF</option>
                    <option value="PETC">PETC</option> -->
                    <option value="FAIS-FISM">FAIS-FISM</option>
					<option value="FISM">FISM</option>
                    <option value="FORTAMUNDF">FORTAMUNDF</option>
                    <option value="FOPEDEP">FOPEDEP</option>
                    <option value="FISMDF">FISMDF</option>
                     <option value="SEGURO POPULAR">SEGURO POPULAR</option>
					 <option value="PROSPERA">PROSPERA</option>
					  <option value="Calidad en Salud">CALIDAD EN SALUD</option>					 
					  <option value="U006">U006</option>
                    <option value="U023">U023</option>
                    <option value="U079">U079</option> 					
					<option value="U080">U080</option> 
					<option value="U081">U081</option> 
                    <option value="Fondo para Elevar la Calidad de la Educación Superior">FECES</option>
				    <option VALUE="fo">Apoyo a Centros y Organizaciones de Educación (U080)</option> 

                              
                  </select>
                
                 
                
                   </td>
                <td class="etiquetaPo" >Estado:</td>
                <td>
                  <select name='edoTramite' id='edoTram' class="redonda5" onchange="Sicsa()">
                    <option value="0" selected="selected">Elegir</option>

                    <option value="105">Dio Lugar a un PO</option>
                    <option value="102">Asistido Juridicamente</option>
                    <option value="100">Opinion de la SA</option>
                    <option value="104">En Proceso de notificación</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td  class="etiquetaPo"  >UAA: </td>
                <td>
                
                <select name='uaa' id='uaa' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
                    <option value="DGARFTA">DGARFTA</option>
                    <option value="DGARFTB">DGARFTB</option>
                    <option value="DGARFTC">DGARFTC</option>
                  
                                         
                </select>
          
                </td>
               <td class="etiquetaPo" >Estado SICSA: </td> 


                <td> 
                  <select  disabled="disabled" name='edoSicsa' id='edoSicsa' class="redonda5"  >
                    <option value="0" selected="selected">Elegir</option>
                    <option value="1">Opinion Legal</option>
                    <option value="2">Opinion Legal</option>                    
                  </select>
                <label></label>
                

                </td> 


                </tr>
            <tr>
               
                <tr>
                   
               <!-- buascar superveniente -->
				<td class="etiquetaPo" > Superveniente: </td>
                <td >
                      <input type="text" name="superveniente" id="superveniente" class="redonda5" size=""/>

                </td>
                 <!-- buascar superveniente -->

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
					    <td><input type="checkbox" name="supervenientech" id="supervenientech" checked="checked"  /> Superveniente</td>
                        <td><input type="checkbox" name="cpCh" id="cpCh" checked="checked"  /> Cuenta Pública</td>
                        <td><input type="checkbox" name="efCh" id="efCh" checked="checked"  /> Entidad Fiscalizada</td>
                        <td><input type="checkbox" name="direccionCh" id="direccionCh" checked="checked"  /> Dirección</td>
                        <td><input type="checkbox" name="subdirectorCh" id="subdirectorCh" checked="checked"  /> Subdirector</td>
                        
                        
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="termiIrrCh" id="termiIrrCh" checked="checked"  /> Término Irregularidad</td>
                        <td><input type="checkbox" name="noPliegoCh" id="noPliegoCh" checked="checked"  /> Número de Pliego</td>
                        
                        <td><input type="checkbox" name="fondoCh" id="fondoCh" checked="checked"  /> Fondo</td>
                        <td><input type="checkbox" name="uaaCh" id="uaaCh" checked="checked"  /> UAA</td>
                         <td><input type="checkbox" name="abogadoCh" id="abogadoCh" checked="checked"  /> Abogado</td>
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="montoCh" id="montoCh" checked="checked"  /> Monto</td>
                        <td><input type="checkbox" name="etCh" id="etCh" checked="checked"  />Estado de Trámite</td>
                        <td><input type="checkbox" name="esCh" id="esCh" checked="checked" /> Estado Sicsa</td> 
                        <td><input type="checkbox" name="audch" id="audch" checked="checked" />Auditoria</td>
                        <td><input type="checkbox" name="jefe_deptoch" id="jefe_deptoch" checked="checked" />Jefe de Departamento</td>
                        <td>&nbsp;</td>
                        </tr>
                      <tr>
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


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
	actor = document.getElementById('actor').value	
 	nop = document.getElementById('nop').value;	
	ef = document.getElementById('ef').value;
	
	cp = document.getElementById('cp').value;
	edoTram = document.getElementById('edoTram').value;
	abo = document.getElementById('abo').value;
	nor=document.getElementById('nor').value;
	pdr=document.getElementById('pdr').value;
	ckl=document.getElementById('ckl').value;
	director= document.getElementById('director').value;
	subdirector= document.getElementById('subdirector').value;
	jefe_depto=document.getElementById('jefe_depto').value;
		direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	usuario = "<?php echo $_SESSION['usuario'] ?>";
	
	
	//------------ checkbox -------------------------------------
	noCh = document.getElementById('noCh').checked;
	nopCh = document.getElementById('nopCh').checked;	
	actorCh = document.getElementById('actorCh').checked;	
	direccionCh = document.getElementById('direccionCh').checked;
	entidadCh = document.getElementById('entidadCh').checked;
	faCh = document.getElementById('faCh').checked;
	
	abogadoCh = document.getElementById('abogadoCh').checked;
	taCh = document.getElementById('taCh').checked;
	cpCh = document.getElementById('cpCh').checked;
	pdrCh = document.getElementById('pdrCh').checked;
	
	naCh = document.getElementById('naCh').checked;
	sustituyeCh = document.getElementById('sustituyeCh').checked;
	etCh = document.getElementById('etCh').checked;
	puestoCh = document.getElementById('puestoCh').checked;
	fecha_bajaCh = document.getElementById('fecha_bajaCh').checked;

	
	//------------ checkbox -------------------------------------

	
	if(envio != "excel"){
		//new mostrarCuadro(600,1200,"Cargando...",20)
		$$('#resultadoConsulta').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
		$$('#resTotal').html("Buscando... ");
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/ajax_busqueda_medios_avanzada.php",true);
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
				
				$$('#resTotal').html(accionesNum+" Usuario(s) encontrados");
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
		ajax.send("accion="+accion+"&actor="+actor+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&nop="+nop+"&cp="+cp+"&abo="+abo+"&edoTram="+edoTram+"&nor="+nor+"&pdr="+pdr+"&ckl="+ckl+"&director="+director+"&subdirector="+subdirector+ /* "&presunto="+presunto+ */  /* JFA "&fecha="+fecha+"&anio="+anio+  */"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */"&nopCh="+nopCh+ "&noCh="+noCh+"&actorCh="+actorCh+"&direccionCh="+direccionCh+"&entidadCh="+entidadCh+"&faCh="+faCh+"&abogadoCh="+abogadoCh+"&taCh="+taCh+ /*"&prescripcionCh="+prescripcionCh+*/"&cpCh="+cpCh+"&pdrCh="+pdrCh+"&naCh="+naCh+"&sustituyeCh="+sustituyeCh+"&etCh="+etCh+"&puestoCh="+puestoCh+"&reports="+reports+"&jefe_depto="+jefe_depto+"&fecha_bajaCh="+fecha_bajaCh); // +"&tipoPO="+tipoPO);
	} else {
		//alert("Creo q quieres un excel");
		window.location.href = "procesosAjax/ajax_excel_medios_avanzada.php?"+"accion="+accion+"&actor="+actor+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&nop="+nop+"&cp="+cp+"&abo="+abo+"&edoTram="+edoTram+"&nor="+nor+"&pdr="+pdr+"&ckl="+ckl+"&director="+director+"&subdirector="+subdirector+ /*"&presunto="+presunto+ */ /* JFA "&fecha="+fecha+"&anio="+anio+ */ "&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */ "&nopCh="+nopCh+"&noCh="+noCh+"&actorCh="+actorCh+"&direccionCh="+direccionCh+"&entidadCh="+entidadCh+"&faCh="+faCh+"&abogadoCh="+abogadoCh+"&taCh="+taCh+/*"&prescripcionCh="+prescripcionCh+*/"&cpCh="+cpCh+"&pdrCh="+pdrCh+"&naCh="+naCh+"&sustituyeCh="+sustituyeCh+"&etCh="+etCh+"&puestoCh="+puestoCh+"&reports="+reports+"&jefe_depto="+jefe_depto+"&fecha_bajaCh="+fecha_bajaCh; //+"&tipoPO="+tipoPO;
	}
	//-----------------funcion estados-------------//
	
	
	//ajax.send("idempleado="+id+"&nombres="+nom+"&departamento="+dep+"&sueldo="+suel)
}
//------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------
     
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

<?php $ver = $_SESSION['direccion']; 
if($ver != "DG")
{ $cons = "and direccion = '".$ver."' "; }
?>

<!--  start content-table-inner -->
<div id="content-table-inner">
  <link rel="stylesheet" href="css/estilos_medios.css" type="text/css" media="screen" title="default" />
    <div class="conTabla2" id="conTabla2">
        <!--  start product-table ..................................................................................... -->
        <form onkeypress="if(event.keyCode == 13) buscaAccionAvanzada()">
        
        <br />
        <center>
            <table border="0" align="center" width="70%" class= "feDif" >
              <tr>
                <td class="etiquetaPo" >
                  Acción:</td>
                <td ><input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>
                     <label for="ver_accion"></label></td>
                     
                <td class="etiquetaPo" >No Procedimiento: </td>
                <td ><input type="text" name="nop" id="nop" class="redonda5" size="30"/></td>
                </tr>
				
				<tr>
                <td class="etiquetaPo" >
                  Actor:</td>
                <td ><input type="text" name="actor" id="actor" class="redonda5" size=""/></td>
                     
                <td class="etiquetaPo" >Entidad Fiscalizada: </td>
                <td ><input type="text" name="ef" id="ef" class="redonda5" size="30"/></td>
                </tr>


	            
				
								
              <tr>
                <td class="etiquetaPo" >No. Recurso:</td>
                <td><input type="text" name="nor" id="nor" class="redonda5" size=""/></td>
				
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
                    <option value="" selected="selected">Elegir</option>
                 
                    <option value="2007">2007</option>
					<option value="2008">2008</option>
					<option value="2009">2009</option>
					<option value="2010">2010</option>
					<option value="2011">2011</option>
					<option value="2012">2012</option>
                    
                  </select>
                
                   </td>
                <td class="etiquetaPo" >Subdirector:</td>
                <td>
                
                 <select name='subdirector' id='subdirector' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 ".$cons." ORDER BY nivel",false);
                 
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

              
                <td class="etiquetaPo" >Abogado:</td>
                <td>
                  <input type="text" name="abo" id="abo" class="redonda5" size="10" align="center"/>
                
                   </td>
              </tr>
              <tr>
                <td class="etiquetaPo" >Documentación:</td>
                <td  >
                
                <select name='ckl' id='ckl' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
                    <option value="1">completa</option>
                    <option value="0">incomplata</option>
                

                              
                  </select>
                
                 
                
                   </td>
                <td class="etiquetaPo" >Control Interno:</td>
                <td>
                  <select name='edoTram' id='edoTram' class="redonda5" >
                    <option value="" selected="selected">Elegir</option>
                    <option  Value = "32"> Con Existencia de Responsabilidad</option>
                    <option value="33">Interposición del Recurso de Reconsideración</option>
                    <option value="34">Acuerdo de Admisión/Desechamiento del Recurso de Reconsideración</option>
                    <option  Value = "35"> Requerimiento de Información y/o documentación al Recurrente</option>
                    <option value="36">Cierre de instrucción</option>
                    <option value="37">Desechamiento del Recurso de Reconsideración</option>
                    <option  Value = "38"> Desahogo de Diligencias</option>
                    <option value="39">En Proceso de Notificación del Acuerdo al Recurrente</option>
                    <option value="40">En Elaboración de Resolución del Recurso de Reconsideración</option>
                    <option value="36">Cierre de instrucción</option>
                    <option value="37">Desechamiento del Recurso de Reconsideración</option>
                    <option  Value = "38"> Desahogo de Diligencias</option>
					<option value="39">En Proceso de Notificación del Acuerdo al Recurrente</option>
					<option value="40">En Elaboración de Resolución del Recurso de Reconsideración</option>
					<option value="41">Confirmar Resolución</option>
					<option value="42">Modificación de la Resolución</option>
					<option value="43">Revocar Resolución</option>
					<option value="44">Revoca Resolución</option>
					<option value="107">En Proceso de Solicitud de Información del RR</option>
					<option value="351">En proceso de envio de información para interposición</option>
					<option value="361">En Opinión Técnica de la UAA</option>
					<option value="391">En Proceso de Notificación de Desechamiento al Actor</option>
					<option value="393">Notificación al SAT</option>
                  </select>
                </td>
              </tr>
              <tr>
                <td  class="etiquetaPo"  >PDR: </td>
               <td>
                  <input type="text" name="pdr" id="pdr" class="redonda5" size="10" align="center"/>
                
                   </td>
               


                </tr>
            <tr>
               
                <tr>
                   
               <!-- buascar superveniente -->
				
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
					    <td><input type="checkbox" name="noCh" id="noCh" checked="checked"  /> No. Recurso</td>
                        <td><input type="checkbox" name="nopCh" id="nopCh" checked="checked"  /> No. Procedimiento</td>
                        <td><input type="checkbox" name="actorCh" id="actorCh" checked="checked"  /> Actor</td>
                        <td><input type="checkbox" name="direccionCh" id="direccionCh" checked="checked"  /> Dirección</td>
                        <td><input type="checkbox" name="entidadCh" id="entidadCh" checked="checked"  /> Entidad Fiscalizada</td>
                        
                        
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="abogadoCh" id="abogadoCh" checked="checked"  /> Abogado</td>
                        <td><input type="checkbox" name="taCh" id="taCh" checked="checked"  /> Tipo Acuerdo</td>                        
                        <td><input type="checkbox" name="cpCh" id="cpCh" checked="checked"  /> Cuenta Publica</td>
                        <td><input type="checkbox" name="pdrCh" id="pdrCh" checked="checked"  /> PDR</td>
                        <td><input type="checkbox" name="faCh" id="faCh" checked="checked"  /> Fecha Acuerdo</td>
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="naCh" id="naCh" checked="checked"  /> Notificación Acuerdo</td>
						<td><input type="checkbox" name="etCh" id="etCh" checked="checked" /> Control Interno</td> 
                        <td><input type="checkbox" name="sustituyeCh" id="sustituyeCh" checked="checked"  />pendiente</td>                        
                        <td><input type="checkbox" name="puestoCh" id="puestoCh" checked="checked" />Pendiente</td>
                        <td><input type="checkbox" name="fecha_bajaCh" id="fecha_bajaCh" checked="checked" />pendiente</td>
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


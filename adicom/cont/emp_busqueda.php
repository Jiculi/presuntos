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
	pobus=document.getElementById('pobus').value;
	uaa=document.getElementById('uaa').value;
	fondo=document.getElementById('fondo').value;
	director= document.getElementById('director').value;
	subdirector= document.getElementById('subdirector').value;
	jefe_depto=document.getElementById('jefe_depto').value;
		direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	usuario = "<?php echo $_SESSION['usuario'] ?>";
	
	
	//------------ checkbox -------------------------------------
	noCh = document.getElementById('noCh').checked;
	curpCh = document.getElementById('curpCh').checked;	
	usuarioCh = document.getElementById('usuarioCh').checked;	
	direccionCh = document.getElementById('direccionCh').checked;
	passwordCh = document.getElementById('passwordCh').checked;
	nivelCh = document.getElementById('nivelCh').checked;
	
	perfilCh = document.getElementById('perfilCh').checked;
	opcionesCh = document.getElementById('opcionesCh').checked;
	statusCh = document.getElementById('statusCh').checked;
	generoCh = document.getElementById('generoCh').checked;
	
	fecha_ingresoCh = document.getElementById('fecha_ingresoCh').checked;
	sustituyeCh = document.getElementById('sustituyeCh').checked;
	tipo_empCh = document.getElementById('tipo_empCh').checked;
	puestoCh = document.getElementById('puestoCh').checked;
	fecha_bajaCh = document.getElementById('fecha_bajaCh').checked;

	
	//------------ checkbox -------------------------------------

	
	if(envio != "excel"){
		//new mostrarCuadro(600,1200,"Cargando...",20)
		$$('#resultadoConsulta').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
		$$('#resTotal').html("Buscando... ");
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/ajax_busqueda_emp_avanzada.php",true);
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
		ajax.send("accion="+accion+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+ /* "&presunto="+presunto+ */  /* JFA "&fecha="+fecha+"&anio="+anio+  */"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */"&curpCh="+curpCh+ "&noCh="+noCh+"&usuarioCh="+usuarioCh+"&direccionCh="+direccionCh+"&passwordCh="+passwordCh+"&nivelCh="+nivelCh+"&perfilCh="+perfilCh+"&opcionesCh="+opcionesCh+ /*"&prescripcionCh="+prescripcionCh+*/"&statusCh="+statusCh+"&generoCh="+generoCh+"&fecha_ingresoCh="+fecha_ingresoCh+"&sustituyeCh="+sustituyeCh+"&tipo_empCh="+tipo_empCh+"&puestoCh="+puestoCh+"&reports="+reports+"&jefe_depto="+jefe_depto+"&fecha_bajaCh="+fecha_bajaCh); // +"&tipoPO="+tipoPO);
	} else {
		//alert("Creo q quieres un excel");
		window.location.href = "procesosAjax/emp_busqueda_avanzada_excel.php?"+"accion="+accion+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+ /*"&presunto="+presunto+ */ /* JFA "&fecha="+fecha+"&anio="+anio+ */ "&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&nivel="+nivel+ /* JFA "&tipo_devolucion="+tipo_devolucion+ */ "&curpCh="+curpCh+"&noCh="+noCh+"&usuarioCh="+usuarioCh+"&direccionCh="+direccionCh+"&passwordCh="+passwordCh+"&nivelCh="+nivelCh+"&perfilCh="+perfilCh+"&opcionesCh="+opcionesCh+/*"&prescripcionCh="+prescripcionCh+*/"&statusCh="+statusCh+"&generoCh="+generoCh+"&fecha_ingresoCh="+fecha_ingresoCh+"&sustituyeCh="+sustituyeCh+"&tipo_empCh="+tipo_empCh+"&puestoCh="+puestoCh+"&reports="+reports+"&jefe_depto="+jefe_depto+"&fecha_bajaCh="+fecha_bajaCh; //+"&tipoPO="+tipoPO;
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
  <link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />
    <div class="conTabla2" id="conTabla2">
        <!--  start product-table ..................................................................................... -->
        <form onkeypress="if(event.keyCode == 13) buscaAccionAvanzada()">
        
        <br />
        <center>
            <table border="0" align="center" width="70%" class= "feDif" >
              <tr>
                <td class="etiquetaPo" >
                  Nombre:</td>
                <td ><input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>
                     <label for="ver_accion"></label></td>
                     
                <td class="etiquetaPo" >Curp: </td>
                <td ><input type="text" name="ef" id="ef" class="redonda5" size="30"/></td>
                </tr>


	            
				
								
              <tr>
                <td class="etiquetaPo" >No. Empleado:</td>
                <td><input type="text" name="pobus" id="pobus" class="redonda5" size=""/></td>
				
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
                <td class="etiquetaPo" >Estatus:</td>
                <td>
                  <select name='cp' id='cp' class="redonda5" >
                    <option value="" selected="selected">Elegir</option>
                 
                    <option value="1">Activo</option>
                    <option value="0.5">Sin Acceso</option>
					  <option value="0">Inactivo</option>
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

              
                <td class="etiquetaPo" >Nivel:</td>
                <td>
                  <input type="text" name="aud" id="aud" class="redonda5" size="10" align="center"/>
                
                   </td>
              </tr>
              <tr>
                <td class="etiquetaPo" >Género:</td>
                <td  >
                
                <select name='fondo' id='fondo' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                

                              
                  </select>
                
                 
                
                   </td>
                <td class="etiquetaPo" >Tipo Empleado:</td>
                <td>
                  <select name='edoTram' id='edoTram' class="redonda5" >
                    <option value="" selected="selected">Elegir</option>
                    <option  Value = "Estructura"> Estructura</option>
                    <option value="PROFIS">PROFIS</option>
                    <option value="Programa Especial">Programa Especial</option>
                    
                  </select>
                </td>
              </tr>
              <tr>
                <td  class="etiquetaPo"  >Puesto: </td>
                <td>
                
                <select name='uaa' id='uaa' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
					<option value="Director de General">Director de General</option>
					<option value="Director de Área">Director de Área</option>
					 <option value="Subdirector">Subdirector de Área</option>
					 <option value="Jefe de Departamento">Jefe de Departamento</option>
					 <option value="Coordinador de Auditores Jurídicos">Coordinador de Auditores Jurídicos</option>
                    <option value= " Auditor Jurídico A">Auditor Jurídico A</option>
                    <option value= " Auditor Jurídico B">Auditor Jurídico B</option>
					 <option value="Supervisor de Área Administrativa">Supervisor de Área Administrativa</option>
                    <option value="becario">Becario</option>
					 <option value="servicio social">Servicio Social</option>
                    
                   
                  
                                         
                </select>
          
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
					    <td><input type="checkbox" name="noCh" id="noCh" checked="checked"  /> No. Empleado</td>
                        <td><input type="checkbox" name="curpCh" id="curpCh" checked="checked"  /> Curp</td>
                        <td><input type="checkbox" name="usuarioCh" id="usuarioCh" checked="checked"  /> Usuario</td>
                        <td><input type="checkbox" name="direccionCh" id="direccionCh" checked="checked"  /> Dirección</td>
                        <td><input type="checkbox" name="passwordCh" id="passwordCh" checked="checked"  /> Password</td>
                        
                        
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="perfilCh" id="perfilCh" checked="checked"  /> Perfil</td>
                        <td><input type="checkbox" name="opcionesCh" id="opcionesCh" checked="checked"  /> Opciones</td>                        
                        <td><input type="checkbox" name="statusCh" id="statusCh" checked="checked"  /> Estatus</td>
                        <td><input type="checkbox" name="generoCh" id="generoCh" checked="checked"  /> Género</td>
                         <td><input type="checkbox" name="nivelCh" id="nivelCh" checked="checked"  /> Nivel</td>
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="fecha_ingresoCh" id="fecha_ingresoCh" checked="checked"  /> Fecha de Ingreso</td>
                        <td><input type="checkbox" name="sustituyeCh" id="sustituyeCh" checked="checked"  />Sustituyó</td>
                        <td><input type="checkbox" name="tipo_empCh" id="tipo_empCh" checked="checked" /> Tipo Empleado</td> 
                        <td><input type="checkbox" name="puestoCh" id="puestoCh" checked="checked" />Puesto</td>
                        <td><input type="checkbox" name="fecha_bajaCh" id="fecha_bajaCh" checked="checked" />Fecha Baja</td>
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


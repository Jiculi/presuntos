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
	njn=document.getElementById('njn').value;
	sala=document.getElementById('salaC').value;
	jni=document.getElementById('jni').value;
	ckl=document.getElementById('ckl1').value;
	//director= document.getElementById('director').value;
	//subdirector= document.getElementById('subdirector').value;
	//jefe_depto=document.getElementById('jefe_depto').value;
		direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	usuario = "<?php echo $_SESSION['usuario'] ?>";
	
	
	//------------ checkbox -------------------------------------

	
	//------------ checkbox -------------------------------------

	
	if(envio != "excel"){
		//new mostrarCuadro(600,1200,"Cargando...",20)
		$$('#resultadoConsulta').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
		$$('#resTotal').html("Buscando... ");
		
		ajax=objetoAjax();
		ajax.open("post","procesosAjax/ajax_busqueda_juicio_avanzada.php",true);
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
					
					alert(datos);
	
					for(i=1; i<=paginacion; i++ ) {
						desde = hasta - 999;
						selector += '<option value="limit '+desde+','+hasta+'" >Página '+i+'</option>';
						hasta = hasta + 1000;
					}
					
					selector += '</select>';
					
					$$('#busquedaLimits').slideDown();
					
					$$('#selector').html(selector);
				}
				
				$$('#resTotal').html(accionesNum+" Juicio(s) encontrados");
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
		ajax.send("accion="+accion+"&actor="+actor+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&nop="+nop+"&cp="+cp+"&njn="+njn+"&jni="+jni+"&ckl="+ckl+"&director="+"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&sala="+sala+"&nivel="+nivel); // +"&tipoPO="+tipoPO);
	} else {
		//alert("Creo q quieres un excel");
		window.location.href = "procesosAjax/ajax_excel_juicio.php?"+"accion="+accion+"&actor="+actor+"&direccion="+direccion+"&usuario="+usuario+"&ef="+ef+"&nop="+nop+"&cp="+cp+"&njn="+njn+"&jni="+jni+"&ckl="+ckl+"&director="+"&limit="+limit+"&envio="+envio+"&direccion="+direccion+"&sala="+sala+"&nivel="+nivel; //+"&tipoPO="+tipoPO;
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
                <td class="etiquetaPo" >Acción:</td>
                <td ><input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>
                     <label for="ver_accion"></label></td>
                     
                <td class="etiquetaPo" >Número de Procedimiento: </td>
                <td ><input type="text" name="nop" id="nop" class="redonda5" size="30"/></td>
                </tr>
				
				<tr>
                <td class="etiquetaPo" > Actor:</td>
                <td ><input type="text" name="actor" id="actor" class="redonda5" size=""/></td>
                     
                <td class="etiquetaPo" >Entidad Fiscalizada: </td>
                <td ><input type="text" name="ef" id="ef" class="redonda5" size="30"/></td>
                </tr>


	            
				
								
              <tr>
                <td class="etiquetaPo" >No. Juicio de Nulidad:</td>
                <td><input type="text" name="njn" id="njn" class="redonda5" size=""/></td>
				
                <td class="etiquetaPo" >Sala de Conocimiento:</td>
                
<td><input type="text" name="salaC" id="salaC" class="redonda5" size=""/></td>
                
                
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
                
                    <td  class="etiquetaPo"  >No. J.N. Interno: </td>
               <td>
                  <input type="text" name="jni" id="jni" class="redonda5" size="10" align="center"/>
                
                   </td>
                
                </td>
                </tr>
              
              <tr>
                                      <td class="etiquetaPo" >Control Interno:</td>
                <td  >
                
                <select name='ckl1' id='ckl1' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
                    <option value="desa">Desahogo</option>
                    <option value="concl">Concluídos</option>
                
                  </select>
                
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


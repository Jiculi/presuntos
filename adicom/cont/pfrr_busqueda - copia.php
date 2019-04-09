<link rel="stylesheet" href="css/estilos_pfrr.css" type="text/css" media="screen" title="default" />

<script>
function buscaAccionAvanzada(envio)
{
	reports = <?php echo $_REQUEST['reports'] ?>;
	divres = document.getElementById('cuadroRes');
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
	edoSicsa= document.getElementById('edoSicsa').value;
	fecha = document.getElementById('fecha').value;
	anio=document.getElementById('anio').value;
	direccion='<?php echo $_SESSION['direccion'] ?>'
	nivel = "<?php echo $_SESSION['nivel'] ?>";
	pdr= document.getElementById('pdr').value;
	pfrr= document.getElementById('pfrr').value;
	superveniente= document.getElementById('superveniente').value;
	acu_inicio= document.getElementById('acu_inicio').value;
	ult_act= document.getElementById('ult_actu').value;
	cie_ins= document.getElementById('cierre_ins').value;
	lim_emi_res = document.getElementById('lim_emi_res').value;
	emi_res= document.getElementById('emi_res').value;
	noti_res= document.getElementById('noti_res').value;
	lim_not_res = document.getElementById('lim_noti_res').value;


	//limit = document.getElementById('limit').value;
	limit = "";
	tipo_devolucion = document.getElementById('tipo_devolucion').value;
	fechaci='<?php $sql=$conexion-> select("Select fecha_edo_tramite from pfrr where num_accion ='".$accion."'") ?>'
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
	pdrch = document.getElementById('pdrch').checked;
	pfrrch = document.getElementById('pfrrch').checked;
	supervenientech= document.getElementById('superCh').checked;
	acu_inicioch= document.getElementById('acu_iniCh').checked;
	ult_actch= document.getElementById('ul_actCh').checked;
	cie_insch= document.getElementById('cie_insCh').checked;
	lim_emi_resch = document.getElementById('lim_emi_resCh').checked;
	emi_resch= document.getElementById('emi_resCh').checked;
	noti_resch= document.getElementById('not_resCh').checked;
	lim_not_resch = document.getElementById('lim_not_resCh').checked;

	//------------ checkbox -------------------------------------

	new mostrarCuadro(600,1200,"Cargando...",20)
	$$('#cuadroRes').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
	
	ajax=objetoAjax();
	ajax.open("post","procesosAjax/pfrr_busqueda_acciones_avanzada.php",true);
	ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			txt = ajax.responseText.split("|||");
			//alert (txt[4]);
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
			
			$$('#cuadroTitulo').html(txt[1]+" accione(s) encontradas...");
			//---muestra SQL ----------------
			//divres.innerHTML = txt[0] + txt[3] + txt[4];
			divres.innerHTML = txt[0];
			$$('#export').val(txt[2]);
			//divtot.innerHTML = "<h3>"+txt[1]+" Accion(es) Encontrada(s)</h3>";
			if(envio == "excel") document.formExcel.submit();


		}
	}
	//muy importante este encabezado ya que hacemos uso de un formulario
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
	ajax.send($$("#Busqueda").serialize());
	
//	ajax.send("accion="+accion+"&direccion="+direccion+"&ef="+ef+"&cp="+cp+"&aud="+aud+"&edoTram="+edoTram+"&pobus="+pobus+"&uaa="+uaa+"&fondo="+fondo+"&director="+director+"&subdirector="+subdirector+"&edoSicsa="+edoSicsa+"&fecha="+fecha+"&anio="+anio+"&limit="+limit+"&direccion="+direccion+"&nivel="+nivel+"&tipo_devolucion="+tipo_devolucion+"&pdr="+pdr+"&pfrr="+pfrr+"&super"+super"&cpCh="+cpCh+"&efCh="+efCh+"&direccionCh="+direccionCh+"&subdirectorCh="+subdirectorCh+"&abogadoCh="+abogadoCh+"&termiIrrCh="+termiIrrCh+"&noPliegoCh="+noPliegoCh+"&prescripcionCh="+prescripcionCh+"&fondoCh="+fondoCh+"&uaaCh="+uaaCh+"&montoCh="+montoCh+"&etCh="+etCh+"&esCh="+esCh+"&audch="+audch+"&pdrch="+pdrch+"&pfrrch="+pfrrch+"&reports="+reports);
	
	//-----------------funcion estados-------------//
	
	
	//ajax.send("idempleado="+id+"&nombres="+nom+"&departamento="+dep+"&sueldo="+suel)
}
//------------------------------ FUNCION DE CARGA DE CONTENIDO AJAX -------------------------------
/*
$$(document).ready(function() {
	//x('#resAcciones').html('<img src="images/load_bar_black.gif">');
	$$.ajax
		({
			beforeSend: function(objeto)
			{
			 $$('#resAcciones').html('<div style="width:220px; margin:50px auto"><img src="images/load_bar.gif"></div>');
			 //alert('hola');
			},
			complete: function(objeto, exito)
			{
				//alert("Me acabo de completar \n - Exito = "+exito)
				//if(exito=="success"){ alert("Y con éxito");	}
			},
			type: "POST",
			url: "procesosAjax/ajax_busqueda_acciones.php",
			data: "",
			error: function(objeto, quepaso, otroobj)
			{
				alert("Estas viendo esto por que fallé \n - Esto Paso = "+quepaso);
				//alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				$$('#resAcciones').html(datos); 
			}
		});
});
*/




	function Sicsa()
		
	{
		
		
		if(edoTram ==0)
		{
			document.getElementById("edoSicsa").selectedIndex="0";
			} 
			
					
		edoTram= document.getElementById("edoTram").value
		
		 
				if(edoTram==2 || 3 || 4 )
		{
			document.getElementById("edoSicsa").selectedIndex="2";
			} 
			
			
			
		if(edoTram ==1)
		{
			document.getElementById("edoSicsa").selectedIndex="1";
			} 
			
		
			
		if(edoTram==6)
		{
			document.getElementById("edoSicsa").selectedIndex="3";
			} 
	
		if(edoTram==7)
		{
			document.getElementById("edoSicsa").selectedIndex="4";
			} 
			
		if(edoTram==8)
		{
			document.getElementById("edoSicsa").selectedIndex="5";
			} 
		if(edoTram==9)
		{
			document.getElementById("edoSicsa").selectedIndex="6";
			} 
	
	if(edoTram==10)
		{
			document.getElementById("edoSicsa").selectedIndex="7";
			} 


				}


function ControlInterno()
{
	
	if(edoSicsa==0)
	{
		
		document.getElementById("edoTram").selectedIndex="0";
		}
	
	
	if(edoSicsa==1)
	{
		
		document.getElementById("edoTram").selectedIndex="1";
		}
	
	
	}
	
	$$(function() {

	
	$$( "#acu_inicio" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 // minDate: "01/"+myMes+"/"+myAno,
	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
	
	$$( "#ult_actu" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: "01/"+myMes+"/"+myAno,
	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#cierre_ins" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: "01/"+myMes+"/"+myAno,
	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#emi_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 // minDate: "01/"+myMes+"/"+myAno,
	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#lim_emi_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: "01/"+myMes+"/"+myAno,
	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#noti_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 // minDate: "01/"+myMes+"/"+myAno,
	 // maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	$$( "#lim_noti_res" ).datepicker({
	 // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	 // minDate: "01/"+myMes+"/"+myAno,
	 // maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });

	});


</script>





<style>
select,input[type="text"]{ width:200px !important; margin:3px}
.inFec{ width:100px !important}
checkbox{width:10px}
.tds td{ padding:3px}
</style>

<!--  start content-table-inner -->
<div id="content-table-inner">
  <link rel="stylesheet" href="css/estilo.css" type="text/css" media="screen" title="default" />

    <div class="conTabla">
    
    <!--  start product-table ..................................................................................... -->
        <form id="Busqueda" name="Busqueda" onkeypress="if(event.keyCode == 13) buscaAccionAvanzada()" >
        
        <br />
        <center>
        <!-- <FORM action="#" method="post" class="tablaDevolucion"> -->
            <table border="0" align="center" width="100%">
              <tr>
                <td class="etiquetaPo" >
                  Entidad Fiscalizada:</td>
                <td >
                  
                    <input type="text" name="ef" id="ef" class="redonda5" size="30"/>
        
                    <label for="ver_accion"></label>
                  </td>
                <td class="etiquetaPo" >
                  Acción: </td>
                <td >
                  
                  
                   <input type="text" name="noAccion" id="noAccion" class="redonda5" size=""/>

        
                  </td>
                  
                  
                <td class="etiquetaPo" >
                  Superveniente: </td>
                <td >
                
                                 
                  
                   <input type="text" name="superveniente" id="superveniente" class="redonda5" size=""/>

        
                  </td>
                  <tr>
                  
                                  <td class="etiquetaPo" >
                  Fecha de Acuerdo de Inicio:          
                  </td>
                <td >
                   <input type="text" name="acu_inicio" id="acu_inicio" class="redonda5" size="10"/>





                </td>
                
                
                                                  <td class="etiquetaPo" >
                  Fecha de Ultima Actuación:          
                  </td>
                <td >
                   <input type="text" name="ult_actu" id="ult_actu" class="redonda5" size=""/>
                </td>
                
                
                
                                                                  <td class="etiquetaPo" >
                  Fecha de Cierre de Instrucción:          
                  </td>
                <td >
                   <input type="text" name="cierre_ins" id="cierre_ins" class="redonda5" size=""/>
                </td>
                
                
                


</tr>
              </tr>
              <tr>
                <td class="etiquetaPo" >PO:</td>
                <td>
                  
                    <input type="text" name="pobus" id="pobus" class="redonda5" size=""/>
        
                  
                  </td>
                <td class="etiquetaPo" >Director:</td>
                <td>
                
                 <select name='director' id='director' class="redonda5" >
                 <option value="" selected="selected">Elegir</option>
                 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 1 AND perfil = 'Director' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'"> Lic. '.$r['nombre'].'</option>';
                 
                 ?>           
                  </select>
                
                
                </td>
                
                                                                                                  <td class="etiquetaPo" >
                  Limite Emisión de la Resolución:          
                  </td>
                <td >
                   <input type="text" name="lim_emi_res" id="lim_emi_res" class="redonda5" size=""/>
                </td>


              </tr>
              <tr>
                <td class="etiquetaPo" >Cuenta Pública:</td>
                <td>
                  <select name='cp' id='cp' class="redonda5" >
                    <option value="0" selected="selected">Elegir</option>
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
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'">Lic. '.$r['nombre'].'</option>';
                 
                 ?>           
                  </select>
                
                
                </td>
                
                
                                                                                                  <td class="etiquetaPo" >
                  Emisión de la Resolución:          
                  </td>
                <td >
                   <input type="text" name="emi_res" id="emi_res" class="redonda5" size=""/>
                </td>


              </tr>
              <tr>
                <td class="etiquetaPo" >Auditoría:</td>
                <td>
                  <input type="text" name="aud" id="aud" class="redonda5" size="10" align="center"/>
                
                   </td>
                <td class="etiquetaPo" >Límite Notificación de la Resolucion:</td>
                <td>
                  <input type="text" name="lim_noti_res" id="lim_noti_res" class="redonda5" size="30"/>
                </td>
                
                
                <td class="etiquetaPo" >Notificación de la Resolucion:</td>
                <td>
                  <input type="text" name="noti_res" id="noti_res" class="redonda5" size="30"/>
                </td>

              </tr>
              <tr>
                <td class="etiquetaPo" >FONDO:</td>
                <td  >
                
                <select name='fondo' id='fondo' class="redonda5" >
                 
                    <option value="" selected="selected">Elegir</option>
                    <option value="OTROS">OTROS</option>
                    <option value="FAEB">FAEB</option>
                    <option value="FAIS-FISE">FAIS-FISE</option>
                    <option value="FAM">FAM</option>
                    <option value="FASP">FASP</option>
                    <option value="FASSA">FASSA</option>
                    <option value="CONVENIOS">CONVENIOS</option>
                    <option value="FAETA">FAETA</option>
                    <option value="FAFEF">FAFEF</option>
                     <option value="SUBSEMUN">SUBSEMUN</option>
                    <option value="FAIS-FISM">FAIS-FISM</option>
                    <option value="FORTAMUN-DF">FORTAMUN-DF</option>
                              
                  </select>
                
                 
                
                   </td>
                <td class="etiquetaPo" >Estado:</td>
                <td>
                  <select name='edoTram' id='edoTram' class="redonda5" onchange="Sicsa()">
                    <option value="0" selected="selected">Elegir</option>
                    <option value="10">Dictamen Técnico por no Solventación del PO</option>
                    <option value="11">Revisión del Expediente Técnico por no Solventación del PO</option>
                    <option value="13">Devolución del Expediente Técnico</option>
                    <option value="14">Solventación Previa al inicio del PFRR.</option>
                    <option value="15">Iniciado. En proceso de notificar oficio(s) citatorio</option>
                    <option value="16">Oficio(s)  Citatorio (s) Notificado(s)</option>
                    <option value="17">En Desahogo de Audiencia de Ley</option>
                    <option value="18">Formulación, desahogo de pruebas y período de alegatos</option>
                    <option value="19">En opinión técnica de la UAA</option>
                    <option value="20">En estudio del Expediente Procedimental</option>
                    <option value="21">En estudio del Expediente Procedimental/Con Respuesta de la UAA</option>
                    <option value="22">En Elaboración de Resolución y en su caso PDR</option>
                    <option value="23">Resolución Notificada. Abstención de Sanción</option>
                    <option value="24">Resolución Notificada. Con existencia de Responsabilidad</option>
                    <option value="25">Resolución Notificada.Resolución de Inexistencia </option>
                    <option value="26">Resolución Notificada.Resolución de Sobreseimiento</option>
        
                  </select>
                </td>
                
                                                <td  class="etiquetaPo"  >Número de Procedimiento: 
                                
                                 <td>
                  <input type="text" name="pfrr" id="pfrr" class="redonda5" size="30"/>
                </td>
                                </td>

                </tr>
                </tr>
                <tr>
                
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
                
                                                <td  class="etiquetaPo"  >PDR: </td>
                                
                                 <td>
                  <input type="text" name="pdr" id="pdr" class="redonda5" size="30"/>
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
                  </select>
                </td>
                 <tr>

                </tr>
                <tr>
                  <td class="etiquetaPo" >
                    Información a mostrar:          
                    </td>
                  <td colspan="6">
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
                        <td><input type="checkbox" name="montoCh" id="montoCh" checked="checked"  />
                          Monto</td>
                        <td><input type="checkbox" name="etCh" id="etCh" checked="checked"  />
                          Estado de Trámite</td>
                        <td><input type="checkbox" name="esCh" id="esCh" checked="checked" />
                          Estado Sicsa</td>
                        <td><input type="checkbox" name="audch" id="audch" checked="checked" /> 
                          Auditoria
          </td>
                      
                      
                                </td>
                        <td><input type="checkbox" name="pdrch" id="pdrch" checked="checked" />
PDR </td>
                        </tr>
                      <tr>

                        <td>
                        </tr>
                      <tr>
                        <td><input type="checkbox" name="superCh" id="superCh" checked="checked"  /> Superveniente</td>
                        <td><input type="checkbox" name="acu_iniCh" id="acu_iniCh" checked="checked"  /> Acuerdo de Inicio</td>
                        <td><input type="checkbox" name="ul_actCh" id="ul_actCh" checked="checked"  /> Última Actuación</td>
                        <td><input type="checkbox" name="cie_insCh" id="cie_insCh" checked="checked"  /> Cierre de Instrucción</td>
                        <td><input type="checkbox" name="lim_emi_resCh" id="lim_emi_resCh" checked="checked"  />Limite de Emisión de la Resolución</td>
                        </tr>
                        
                        <tr>
                        <td><input type="checkbox" name="emi_resCh" id="emi_resCh" checked="checked"  /> Emisión de la Resolución</td>
                        <td><input type="checkbox" name="lim_not_resCh" id="lim_not_resCh" checked="checked"  /> Limite Notificación de la Resolución</td>
                        <td><input type="checkbox" name="not_resCh" id="not_resCh" checked="checked"  /> Notificación de la Resolución</td>
                                                <td><input type="checkbox" name="pfrrch" id="pfrrch" checked="checked" /> 
                          Número de Procedimiento
                          
                          
                          
                          
                          
</td>


                        </tr>
                      </table>
                    
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
                  <td align="center">
                  <form name="formExcel" action="excel.php" method = "POST">
                    <input type="hidden" class="" name="export"  id='export' value=""/>
                    <input type='hidden' name='nombre_archivo' value='listado_acciones'/>
                    <input type = "button" value = "Exportar a Excel" class="submit-login" onclick="buscaAccionAvanzada('excel')"/>
                  </form>
        
                </td>
                </tr>
            </table>
            </center>
            </br>
            
    </div>  <!-- end contabla -->
    <!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
    <div id="related-activities">
        
    <!-- INCLUIMOS NOTIFICACONES -->    
    <?php 
        require_once("cont/po_notificaciones.php");
    ?>
    <!-- INCLUIMOS NOTIFICACONES -->
    
    </div>
    <!-- end related-activities -->
    

</div>
<!--  end content-table  -->


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

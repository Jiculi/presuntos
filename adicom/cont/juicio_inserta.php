<?php
require_once("/includes/clases.php");
require_once("/includes/configuracion.php");
require_once("/includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];

$query = "SELECT * FROM usuarios WHERE usuario LIKE '%".$usuario."%' ";
$sql = $conexion->select($query,false);
$r = mysql_fetch_array($sql);

$queryju="select nojuicio from juicios order by id desc limit 1";
$sqlju = $conexion->select($queryju,false);
$noju = mysql_fetch_array($sqlju);
$ju=$noju['nojuicio'];
$jur=explode(".",$ju);
$jur0=$jur[0];
$jur1=$jur[1];
$jur2=$jur[2];
$jur3=explode("/",$jur2);
$jur4=$jur3[0];
$juinext=$jur4+1;

$subdirec = $_POST['empgen']; 

?>
<script SRC="js/funciones.js"></SCRIPT>
<script>
$$(function() {
		 // configuramos el control para realizar la busqueda de los productos
		$$("#empusu").autocomplete({
	  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $$('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/juicio_accion.php",
						dataType: "json",
						data: {
							term: request.term
							
						},
						success: function( data ) {
							$$('#idLoad').html('');
							response(data);
								//alert(urlAjax+" - "+$$("#totalAcciones").val());
			  					//muestraListados();
							}
						});
				 },
			   minLength: 2,
		   select: 
		   function( event, ui ) 
		   {  
			//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
			$$("#emppas").val(ui.item.proce);
			$$("#empcurp").val(ui.item.enti);
			$$("#empniv").focus();
			
		  }
			});//end
}); 








$$(function() {
//------Se despliega calendario para colocar fecha de Ingreso
	$$( "#empfin" ).datepicker({
      changeMonth: false,
      numberOfMonths: 2,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	//------Se despliega calendario para colocar fecha de Ascenso
	$$( "#empasc" ).datepicker({
      changeMonth: false,
      numberOfMonths: 2,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });


//Autocomplete

		
	
	
});

//////////------ Envia datos
$$(document).ready(function(){
	
	

	$$("#alta_emp").click(function(){
	if($$("#empcurp").val() == ""){ $$("#empcurp").val("0"); }
	if($$("#empper").val() == ""){ $$("#empper").val("0"); }
	if($$("#empsus").val() == ""){ $$("#empsus").val("0"); }

	if($$("#empasc").val() == ""){ $$("#empasc").val("0000-00-00"); }
	if($$("#emppan").val() == ""){ $$("#emppan").val("0"); }
	

						var datosUrl = $$("#empalta").serialize();
						
		if(comprobarForm("empalta"))
		{
			
			var confirma = confirm("Se insertará un nuevo registro \n\n ¿Desea continuar?");

			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
					//$$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/juicios_nuevo.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					alert(datos);
					//cerrarCuadro();
					}
				});
			} //Fin de if confirma
			
		$$('.inputsSig').val('');
		}
	});
	

});
</script>    

<link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<div  class="redonda10" style="padding:0px 200px;background:#FFDFEF;">
<div align="center" class='tablaInfo' width="100%">
</br>

	<form name= "empalta" id="empalta">
	
		<table width="100%" align="center" class="feDif">
          <tr>
            <td class="etiquetaInfo redonda3">Número de Juicio Interno</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empnom" name="empnom"  value= "J.N. 0<?php echo $juinext?>/2018" />
			</td>
            <td class="etiquetaInfo redonda3">Fecha Not. DGR</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empfin" name="empfin"/></td>
          </tr>
          <tr>
		  
		    <td class="etiquetaInfo redonda3">Acción</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empusu" name="empusu"/></td>
		
           
			<td class="etiquetaInfo redonda3">Dirección de Origen</td>
			<td>
			<select name="empgen" id="empgen" class="redonda5 inputsSig">
			<option value="" selected="selected">Elegir</option>
			 <?php
                 $sql = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 1 AND puesto = 'Director de Área' ".$cons." AND status != '0' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sql))
                    echo '<option value="'.$r['nivel'].'"> Lic. '.$r['nombre'].'</option>';
                 
                 ?> 
				
			</select>
            </td>
			                    <input type="hidden" name="totalAcciones" id="totalAcciones" size="35" class="redonda5">
                    <input type="hidden" name="totalNoAcciones" id="totalNoAcciones" size="35" class="redonda5">

			
          </tr>      
         
		 <tr>
            
      		 <td class="etiquetaInfo redonda3">Entidad o Dependencia</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empcurp" name="empcurp" maxlength="100"/></td>
            
           <td class="etiquetaInfo redonda3">Subdirector</td>
            <td>
			<select name="emppue" id="emppue" class="redonda5 inputsSig">
				<option value="" selected="selected">Elegir</option>
				
                 <?php
                 $sqlsd = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 AND nivel like '%A%' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sqlsd))
                    echo '<option value="'.$r['nivel'].'"> Lic.' .$r['nombre'].'</option>';
					
                 
                 ?> 
			</select>
			</td> 
            
          </tr>
		  
          <tr>		  
		  
            <td class="etiquetaInfo redonda3">Procedimiento</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="emppas" name="emppas"/></td>
			
			
			<td class="etiquetaInfo redonda3">Jefe de Departamento:</td>
            <td>
			<select name="empsus" id="empsus" class="redonda5 inputsSig">
				<option value="" selected="selected">Elegir</option>
                 <?php
                 $sql2 = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 5 AND nivel like '%A%' and status like '1' ORDER BY nivel",false);
                 
                 while($r2 = mysql_fetch_array($sql2))
                    echo '<option value="'.$r2['nivel'].'">Lic. '.$r2['nombre'].'</option>';
                 
                 ?> 
			</select>
			</td>
			
			
		 
          </tr>
          <tr>
		  
            <td class="etiquetaInfo redonda3">Sala del Conocimiento</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empniv" name="empniv"/></td>
	        
			<td class="etiquetaInfo redonda3">Juicio de Nulidad	</td>
            <td>
			<input type = "text" name="empper" id="empper" size="35" class="redonda5 inputsSig"/></td>
            
          </tr>
          <tr>
            <td class="etiquetaInfo redonda3">Actor</td>
            <td><input type="text" class="redonda5 inputsSig"  size="35" id="empdir" name="empdir" maxlength="100"/></td>
            <td class="etiquetaInfo redonda3">Vencimiento Fatal</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empasc" name="empasc"/></td>
          </tr>
          <tr>	
	
            <td class="etiquetaInfo redonda3">Monto</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="emppan" name="emppan" maxlength="100" /></td>
			</td>
			
			
		
		
          </tr>
          <tr>
		 
		  
          </tr>
          <tr>
            
            <td></td>
            <td>
			
			</td>
          </tr>
         <tr>
			<td colspan="4" align="center"><br>
			<input type="hidden" name="nom" id="nom" value="<?php echo $r['nombre']; ?>">
			<input type="hidden" name="tipoForm" id="tipoForm" value="alta">
			<input type="button" class="submit_line" name="alta_emp" id="alta_emp" value="Insertar nuevo Juicio">
			</br>
			</td>
	    </tr>
		</table>
		
	</form>

</div>
</div>
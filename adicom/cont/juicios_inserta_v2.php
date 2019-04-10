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

$queryju="select nojuicio from juiciosNew order by id desc limit 1";
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

$subdirec = $_POST['dir']; 

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />

<!--   <script type="text/javascript" src="e/js/jquery-3.3.1.js"></script> 
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->

<script  type="text/javascript" src="e/js/funciones.js"></script>


</head>

<body>
	<form name= "juiciosAlta" id="juiciosAlta">
		<table width="100%" align="center" class="feDif">
          	<tr>
            	<td><input type="hidden" id="nojuicio" name="nojuicio"  value= "J.N. 0<?php echo $juinext?>/2018" /></td>
          	</tr>

          	<tr>
		    	<td class="etiquetaInfo redonda3">Acción</td>
            	<td><input type="text" class="redonda5 inputsSig" size="35" id="accion" name="accion"/></td>
				<td class="etiquetaInfo redonda3">Procedimiento</td>
            	<td><input type="text" class="redonda5 inputsSig" size="35" id="procedimiento" name="procedimiento"/  readonly></td>
          	</tr>      
         
		 	<tr>
			 	
				<td style="empty-cells: show"></td>
				<td style="empty-cells: show"></td>
      		 	<td class="etiquetaInfo redonda3">Entidad o Dependencia</td>
            	<td><input type="text" class="redonda5 inputsSig" size="35" id="entidad" name="entidad" maxlength="100"/ readonly></td>
          	</tr>
		  

			<tr>
				<td class="etiquetaInfo redonda3">Juicio de Nulidad	</td>
            	<td><input type = "text" name="juicionulidad" id="juicionulidad" size="35" class="redonda5 inputsSig"/></td>
          	</tr> 

          	<tr>
            	<td class="etiquetaInfo redonda3">Sala del Conocimiento</td>
            	<td><input type="text" class="redonda5 inputsSig" size="35" id="salaconocimiento" name="salaconocimiento"/></td>
          	</tr>

          	<tr>
            	<td class="etiquetaInfo redonda3">Actor</td>
            	<td><input type="text" class="redonda5 inputsSig"  size="35" id="actor" name="actor" maxlength="100"/></td>
          	</tr>

          	<tr>	
	            <td class="etiquetaInfo redonda3">Monto</td>
            	<td><input type="number" class="redonda5 inputsSig" size="35" id="monto" name="monto" maxlength="12" /></td>
	        </tr>

          	<tr>
            	<td class="etiquetaInfo redonda3">Fecha Not. DGR</td>
            	<td><input type="text" class="redonda5 inputsSig" size="35" id="fechanot" name="fechanot"/></td>
				<td class="etiquetaInfo redonda3">Vencimiento Fatal</td>
           		<td><input type="text" class="redonda5 inputsSig" size="35" id="vencimiento" name="vencimiento" readonly></td>
          	</tr>

          	<tr>
				<td class="etiquetaInfo redonda3">Dirección de Origen</td>
				<td>
					<select name="dir" id="dir" class="redonda5 inputsSig">
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
           		<td class="etiquetaInfo redonda3">Subdirector</td>
            	<td>
				<select name="sub" id="sub" class="redonda5 inputsSig">
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
				<td class="etiquetaInfo redonda3">Jefe de Departamento:</td>
            	<td>
				<select name="subnivel" id="subnivel" class="redonda5 inputsSig">
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
				<td colspan="4" align="center"><br>
				<input type="hidden" name="nom" id="nom" value="<?php echo $r['nombre']; ?>">
				<input type="hidden" name="tipoForm" id="tipoForm" value="alta">
				<input type="button" class="submit_line" name="alta_emp" id="alta_emp" value="Insertar nuevo Juicio">
				</td>
	    	</tr>

		</table>
	</form>
</body>


<script>

// jQuery.noConflict();
//////////------ Envia datos
jQuery( document ).ready(function( $ ) {

	$("#alta_emp").click(function(){
	if($("#entidad").val() == ""){ $("#entidad").val("0"); }
	if($("#juicionulidad").val() == ""){ $("#juicionulidad").val("0"); }
	if($("#subnivel").val() == ""){ $("#subnivel").val("0"); }
	if($("#vencimiento").val() == ""){ $("#vencimiento").val("0000-00-00"); }
	if($("#monto").val() == ""){ $("#monto").val("0"); }

		var datosUrl = $("#juiciosAlta").serialize();
						
		if(comprobarForm("juiciosAlta"))
		{
			
			var confirma = confirm("Se insertará un nuevo registro \n\n ¿Desea continuar?");

			if(confirma)
			{
				$$.ajax
				({
					beforeSend: function(objeto)
					{
					//$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
					//alert("Me acabo de completar") if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "e/juicios_nuevo_v2.php",
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
			
		$('.inputsSig').val('');
		}
	});

});


jQuery( document ).ready(function( $ ) {
		 // configuramos el control para realizar la busqueda de los productos
		$("#accion").autocomplete({
	  //source: "procesosAjax/po_buscar_accion_otros_oficios.php?direccion= " /* este es el formulario que realiza la busqueda */
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "procesosAjax/juicio_accion.php",
						dataType: "json",
						data: {
							term: request.term
							
						},
						success: function( data ) {
							$('#idLoad').html('');
							response(data);
								//alert(urlAjax+" - "+$("#totalAcciones").val());
			  					//muestraListados();
							}
						});
				 },
			   minLength: 2,
		   select: 
		   function( event, ui ) 
		   {  
			//alert("Selected: " + ui.item.label +"\n\n"+"Nothing selected, input was " + this.value+"\n\n"+"fase " + ui.item.fase+"\n\n"+"cp " + ui.item.cp );
			$("#procedimiento").val(ui.item.proce);
			$("#entidad").val(ui.item.enti);
			$("#salaconocimiento").focus();
			
		  }
			});//end
}); 

jQuery( document ).ready(function( $ ) {
	$( "#fechanot" ).datepicker({
      changeMonth: false,
      numberOfMonths: 2,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
	});
	
	

});
</script>    

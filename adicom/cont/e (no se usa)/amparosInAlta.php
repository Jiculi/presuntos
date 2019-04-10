<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];

/*
$query = "SELECT * FROM usuarios WHERE usuario LIKE '%".$usuario."%' ";
$sql = $conexion->select($query,false);
$r = mysql_fetch_array($sql);

*/

$subdirec = $_POST['dir']; 
$procedimiento = "";

?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="css/juiciosNuevo.css">
</head>

<body>
	<div class="navbar">
		<a href="#" class="logo">Alta de Amparo Indirecto</a>
		<div class="navbar-right">
		  <a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a>
		</div>
	</div>

	<form name= "formita" id="formita">
		<div id ="ventanita" class="alert">
	 		<p id="mensaje"><p>
		</div>
		<table>
          	<tr>
		    	<td class="juicio-etiqueta ">Procedimiento</td>
            	<td><input type="text" class="redonda5 "  id="procedimiento" name="procedimiento" size="35" required></td>
				<td class="juicio-etiqueta ">Acción</td>
            	<td><input type="text" class="juicio-sinborde" id="accion" name="accion" value = "" readonly></td>
          	</tr>      
         
		 	<tr>
				<td style="empty-cells: show"></td>
				<td style="empty-cells: show"></td>
      		 	<td class="juicio-etiqueta ">Entidad o Dependencia</td>
            	<td><input type="text" class="juicio-sinborde" size="35" id="entidad" name="entidad" maxlength="100"/ readonly></td>
          	</tr>

			<tr>
				<td class="juicio-etiqueta">Amparo Indirecto</td>
            	<td><input type = "text" name="amparoIndirecto" id="amparoIndirecto" size="35" class="juicio-redonda "></td>
          	</tr> 

          	<tr>
            	<td class="juicio-etiqueta ">Sala de Conocimiento</td>
            	<td><input type="text" size="35" id="salaconocimiento" name="salaconocimiento" class="juicio-redonda"></td>
          	</tr>

          	<tr>
            	<td class="juicio-etiqueta ">Actor</td>
            	<td><input type="text" class="juicio-redonda "  size="35" id="actor" name="actor" maxlength="100"/></td>
          	</tr>


          	<tr>
            	<td class="juicio-etiqueta ">Fecha Interposición</td>
            	<td><input type="text" class="juicio-redonda " size="35" id="fechanot" name="fechanot"/></td>
				
				<td class="juicio-etiqueta ">Vencimiento</td>
           		<td><input type="text" class="juicio-sinborde" size="35" id="vencimiento" name="vencimiento" readonly></td>
          	</tr>

          	<tr>
				<td class="juicio-etiqueta ">Dirección de Origen</td>
				<td>
					<select name="dir" id="dir" class="juicio-redonda ">
                    <option value="A" selected="selected">Nelly Zulema Sánchez Cruz</option>

			 		<?php
                 		$sql = $conexion->select("SELECT * FROM usuarios WHERE nivel like '%A%' AND puesto = 'Director de Área' ".$cons." AND status != '0' ORDER BY nivel",false);
                 			while($r = mysql_fetch_array($sql))
                    		echo '<option value="'.$r['nivel'].'">'.$r['nombre'].'</option>';
                 	?> 
					</select>
            	</td>
          	</tr>

		 	<tr>
           		<td class="juicio-etiqueta ">Subdirector</td>
            	<td>
				<select name="sub" id="sub" class="juicio-redonda ">
                <option value="" selected="selected">Elegir</option>

				
                 <?php
                 $sqlsd = $conexion->select("SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 AND nivel like '%A%' ORDER BY nivel",false);
                 
                 while($r = mysql_fetch_array($sqlsd))
                    echo '<option value="'.$r['nivel'].'">'.$r['nombre'].'</option>';
                 ?> 
				</select>
				</td> 
          	</tr>


            <tr>
				<td colspan="4"><br>
				<input type="hidden" name="nom" id="nom" value="<?php echo $r['nombre']; ?>">
				<input type="button" class="boton" name="inserta_juicio" id="inserta_juicio" value="Insertar nuevo Amparo Indirecto">
				</td>
	    	</tr>

		</table>
	</form>
</body>


<script>


function cerrarCuadrito() {
		$("#altaOficio").fadeOut();
		$('#popup-overlay').fadeOut('slow');
	}

function comprobarForma(form) {
	var mensaje = "Los campos marcados en color rojo son obligatorios";
	var error = 0;
	frm = document.forms[form];
	for(i=0; ele=frm.elements[i]; i++)
	{
		//elementos += " Nombre = "+ele.name+" | Tipo = "+ele.type+" | Valor = "+ele.value+"\n";
		if((ele.value == ' ' || ele.value == '' || ele.value == 'nada') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
		{
			mensaje += '\n - '+ele.name;	
			document.getElementById(ele.name).style.borderColor = 'red';
			error++;	
		} 		
		if((ele.value != '') && (ele.type != 'button' && ele.type != 'hidden' && ele.type != 'image') && (ele.disabled == false))
			{document.getElementById(ele.name).style.borderColor = 'silver';
			}
	}
	if(error != 0) {
			$('#mensaje').text(mensaje);
			$('#ventanita').addClass("alert error");
			//alert(mensaje);
			return false;
	}
	else  {
		return true;
	}
}

$(document).ready(function() {
	$('#popup-overlay').fadeIn();
	$('#popup-overlay').height($(window).height());
	const procedimiento = document.getElementById('procedimiento');
	const alerta = document.getElementById('mensaje');

	procedimiento.focus();

	$("#inserta_juicio").click(function(){
		var datosUrl = $("#formita").serialize();
		if(comprobarForma("formita"))
		{
				$$.ajax
				({
					beforeSend: function(objeto) {
					//$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito) {
					//alert("Me acabo de completar") if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "e/amparosInInserta.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj) {
					//alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos) {
						alerta.innerHTML = datos;
						$('#mensaje').text(datos);
						$('#ventanita').addClass("alert success");
						//document.forms["formita"].reset();
						$("#formita :input").prop('readonly', true);
						document.getElementById("inserta_juicio").disabled = true;
						document.getElementById('inserta_juicio').style.visibility = 'hidden';
						$("#fechanot").datepicker('disable');
						$("#vencimiento").datepicker().datepicker('disable');
						document.getElementById("dir").disabled = true;
						document.getElementById("sub").disabled = true;

					
					//alert(datos);
					//cerrarCuadro();
					}
				});
		}
	});

	$("#procedimiento").autocomplete({
			source: function( request, response ) {
					$$.ajax({
						beforeSend: function(objeto){ $('#idLoad').html('<img src="images/load_chico.gif">'); },
						type: "POST",
						url: "e/jsonProcedimiento.php",
						dataType: "json",
						data: {
							term: request.term
						},
						success: function( data ) {
							$('#idLoad').html('');
							response(data);
							}
						});
				 },
			   minLength: 2,
		   select: function( event, ui )   {  
				$("#accion").val(ui.item.acc);
				$("#entidad").val(ui.item.enti);
				$("#amparoIndirecto").focus();
		  		}
	});

	$( "#fechanot" ).datepicker({
	  	dateFormat: "dd/mm/yy",
      	changeMonth: false,
      	numberOfMonths: 1,
	  	showAnim:'slideDown',
	  	beforeShowDay: noLaborales,
      	onClose: function(fecha, obj) {
		console.log(fecha)
		let buena = `${fecha.substr(3,2)}/${fecha.substr(0,2)}/${fecha.substr(6,4)}`;
		console.log(buena);
		let fecha1 = new  Date(buena);
		console.log(fecha1);
		let dias = 60;
		let diasMs = 1000*60*60*24*dias;
		let fecha2 = fecha1.getTime() + diasMs;
		let d = new Date(fecha2);
		console.log(d);

		let day = d.getDate()
		console.log("dia "+day);
        let month = d.getMonth() + 1
        let year = d.getFullYear()

        if(month < 10){
           d = `${day}/0${month}/${year}`
        }else{
           d=`${day}/${month}/${year}`
        }
		$("#vencimiento").val(d);   
	  }
	});
});


</script>    

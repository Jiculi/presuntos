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
?>
<script SRC="js/funciones.js"></SCRIPT>
<script>
$$(function() {
//------Se despliega calendario para colocar fecha de Ingreso
	$$( "#empfin" ).datepicker({
      changeMonth: false,
	   changeYear: true,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
	
	//------Se despliega calendario para colocar fecha de Ascenso
	$$( "#empasc" ).datepicker({
      changeMonth: false,
	   changeYear: true,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
});

//////////------ Envia datos
$$(document).ready(function(){

	$$("#alta_emp").click(function(){
	if($$("#empcurp").val() == ""){ $$("#empcurp").val("0"); }
	if($$("#empper").val() == ""){ $$("#empper").val("0"); }
	if($$("#empsus").val() == ""){ $$("#empsus").val("0"); }
	if($$("#empnoe").val() == ""){ $$("#empnoe").val("0"); }
	if($$("#empasc").val() == ""){ $$("#empasc").val("0000-00-00"); }
	if($$("#emppan").val() == ""){ $$("#emppan").val("0"); }
	if($$("#empopc").val() == ""){ $$("#empopc").val("0"); }

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
					url: "procesosAjax/emp_alta_modifica.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					//alert(datos);
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
            <td class="etiquetaInfo redonda3">Nombre</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empnom" name="empnom"/>
			</td>
            <td class="etiquetaInfo redonda3">Fecha de ingreso</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empfin" name="empfin"/></td>
          </tr>
          <tr>
            <td class="etiquetaInfo redonda3">CURP</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empcurp" name="empcurp" maxlength="18"/></td>
            <td class="etiquetaInfo redonda3">Sustituye</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empsus" name="empsus"/></td>
          </tr>      
          <tr>
		  <?php if ($r['opciones'] == 1) {?>
            <td class="etiquetaInfo redonda3">Usuario</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empusu" name="empusu"/></td>
		  <?php } ?>
            <td class="etiquetaInfo redonda3">No. Empleado</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empnoe" name="empnoe" maxlength="10" /></td>
          </tr>
          <tr>
		  <?php if ($r['opciones'] == 1) {?>
            <td class="etiquetaInfo redonda3">Password</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="emppas" name="emppas"/></td>
		  <?php } ?>
            <td class="etiquetaInfo redonda3">Tipo de empleado</td>
            <td>			
			<select name="emptem" id="emptem" class="redonda5 inputsSig">
				<optgroup label="Tipo empleado">
					<option value="">Seleccione el tipo de empleado ...</option>
						<option class='opciones' value="Servicio Social"> &nbsp; - Servicio Social</option>;
						<option class='opciones' value="Becario"> &nbsp; - Becario</option>;
						<option class='opciones' value="PROFIS"> &nbsp; - PROFIS</option>;
						<option class='opciones' value="PROFIS/Programa Especial"> &nbsp; - PROFIS/Programa Especial</option>;
						<option class='opciones' value="Programa Especial"> &nbsp; - Programa Especial</option>;
						<option class='opciones' value="Estructura"> &nbsp; - Estructura</option>;
				</optgroup>
			</select>			
			</td>
          </tr>
          <tr>
		  <?php if ($r['opciones'] == 1) {?>
            <td class="etiquetaInfo redonda3">Nivel</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empniv" name="empniv"/></td>
		  <?php } ?>
            <td class="etiquetaInfo redonda3">Puesto</td>
            <td>
			<select name="emppue" id="emppue" class="redonda5 inputsSig">
				<optgroup label="Puesto">
					<option value="">Seleccione el puesto de empleado ...</option>
						<option class='opciones' value="Director General"> &nbsp; - Director General</option>;
						<option class='opciones' value="Director de Área A"> &nbsp; - Director de Área</option>;
						<option class='opciones' value="Supervisor de Área Administrativa"> &nbsp; - Supervisor de Área Administrativa</option>;
						<option class='opciones' value="Subdirector"> &nbsp; - Subdirector</option>;
						<option class='opciones' value="Jefe de Departamento"> &nbsp; - Jefe de Departamento</option>;
						<option class='opciones' value="Coordinador de Auditores Jurídicos"> &nbsp; - Coordinador de Auditores Jurídicos</option>;
						<option class='opciones' value="Auditor Jurídico A"> &nbsp; - Auditor Jurídico A</option>;
						<option class='opciones' value="Auditor Jurídico B"> &nbsp; - Auditor Jurídico B</option>;
						<option class='opciones' value="Voluntario"> &nbsp; - Voluntario</option>;
				</optgroup>
			</select>
			</td>
          </tr>
          <tr>
            <td class="etiquetaInfo redonda3">Dirección</td>
            <td><input type="text" class="redonda5 inputsSig" value="<?php echo $r['direccion']; ?>" size="35" id="empdir" name="empdir" maxlength="2"/></td>
            <td class="etiquetaInfo redonda3">Ascenso</td>
            <td><input type="text" class="redonda5 inputsSig" size="35" id="empasc" name="empasc"/></td>
          </tr>
          <tr>
		  <?php if ($r['opciones'] == 1) {?>
            <td class="etiquetaInfo redonda3">Perfil</td>
            <td>
			<select name="empper" id="empper" class="redonda5 inputsSig">
				<optgroup label="Perfil">
					<option value="0" selected>Seleccionar ...</option>
						<option class='opciones' value="Director"> &nbsp; - Director.</option>;
				</optgroup>
			</select>
			</td>
		  <?php } ?>
            <td class="etiquetaInfo redonda3">Puesto anterior</td>
            <td>
			<select name="emppan" id="emppan" class="redonda5 inputsSig">
				<optgroup label="Puesto anterior">
					<option value="0" selected>Seleccione el puesto anterior ...</option>
						<option class='opciones' value="Director General"> &nbsp; - Director General</option>;
						<option class='opciones' value="Director de Área A"> &nbsp; - Director de Área</option>;
						<option class='opciones' value="Supervisor de Área Administrativa"> &nbsp; - Supervisor de Área Administrativa</option>;
						<option class='opciones' value="Subdirector"> &nbsp; - Subdirector</option>;
						<option class='opciones' value="Jefe de Departamento"> &nbsp; - Jefe de Departamento</option>;
						<option class='opciones' value="Coordinador de Auditores Jurídicos"> &nbsp; - Coordinador de Auditores Jurídicos</option>;
						<option class='opciones' value="Auditor Jurídico A"> &nbsp; - Auditor Jurídico A</option>;
						<option class='opciones' value="Auditor Jurídico B"> &nbsp; - Auditor Jurídico B</option>;
						<option class='opciones' value="Voluntario"> &nbsp; - Voluntario</option>;
				</optgroup>
			</select>
			</td>
          </tr>
          <tr>
		  <?php if ($r['opciones'] == 1) {?>
            <td class="etiquetaInfo redonda3">Estatus</td>
           <td>
			<select name="empsta" id="empsta" class="redonda5 inputsSig">
				<optgroup label="Estatus">
					<option value="">Seleccione el Estatus ...</option>
						<option class='opciones' value="1"> &nbsp; - Activo (Acceso al sistema ADICOM).</option>;
						<option class='opciones' value="0.5"> &nbsp; - Activo (Sin acceso al sistema ADICOM).</option>;
						<option class='opciones' value="0"> &nbsp; - inactivo (Baja / Sin acceso).</option>;
				</optgroup>
			</select>
			</td>
            <td class="etiquetaInfo redonda3 inputsSig">Modificar Nivel</td>
            <td>
			<input type="text" class="redonda5 inputsSig" placeholder="* 1 = podrá modificar el nivel de usuarios." size="35" id="empopc" name="empopc"/>
			</td>
		  <?php } ?>
          </tr>
          <tr>
            <td class="etiquetaInfo redonda3">Género</td>
            <td>
			<select name="empgen" id="empgen" class="redonda5 inputsSig">
				<optgroup label="Género">
					<option value="">Seleccione el género ...</option>
						<option class='opciones' value="F"> &nbsp; - Femenino.</option>;
						<option class='opciones' value="M"> &nbsp; - Masculino.</option>;
				</optgroup>
			</select>
            </td>
            <td></td>
            <td>
			
			</td>
          </tr>
         <tr>
			<td colspan="4" align="center"><br>
			<input type="hidden" name="nom" id="nom" value="<?php echo $r['nombre']; ?>">
			<input type="hidden" name="tipoForm" id="tipoForm" value="alta">
			<input type="button" class="submit_line" name="alta_emp" id="alta_emp" value="Insertar Empleado">
			</br>
			</td>
	    </tr>
		</table>
		
	</form>

</div>
</div>
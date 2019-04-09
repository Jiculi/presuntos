<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");

$conexion = new conexion;
$conexion->conectar();

//-------------------------- VARIABLES GLOBALES -----------------------------
$direccion = $_REQUEST['direccion'];
$sessusu = $_REQUEST['usuario'];

$sql1 = $conexion->select("SELECT * FROM usuarios WHERE usuario Like '%".$sessusu."%' and direccion = '".$direccion."' ",false);
		
$rs = mysql_fetch_array($sql1);

//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$empusu = valorSeguro($_REQUEST['emp']);
$empid = valorSeguro($_REQUEST['id']);

$sql = $conexion->select("SELECT * FROM usuarios WHERE id='".$empid."' and usuario like '%".$empusu."%' ",false);		
$total = mysql_num_rows($sql);			
$r = mysql_fetch_array($sql);	

if ($r['status'] == 1) $tipostatus = "Activo con acceso al Sistema ADICOM"; 
		else if ($r['status'] == 0.5) $tipostatus = "Activo sin acceso al Sistema ADICOM";
		else $tipostatus = "Ususario dado de baja";
		
if ($r['genero'] == "F" OR $r['genero'] == "f") $gen = "Femenino"; 
		else if ($r['genero'] == "M" OR $r['genero'] == "m") $gen = "Masculino";	
		else $gen = "¿?";
?>

<script>
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

	//------Se despliega calendario para colocar fecha de Ascenso2
	$$( "#empas2" ).datepicker({
      changeMonth: false,
      numberOfMonths: 2,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });

	//------Se despliega calendario para colocar fecha de Baja
	$$( "#empfba" ).datepicker({
      changeMonth: false,
      numberOfMonths: 2,
	  showAnim:'slideDown',
	  beforeShowDay: noLaborales
    });
});
//////////------ Envia datos
$$(document).ready(function(){

	$$("#actreg").click(function()
			{
				
						var datosUrl = $$("#modificausu").serialize();
		
			var confirma = confirm('Se modificará el registro de:\n\n - <?php echo $r['nombre']; ?> - \n\n ¿Desea continuar?');
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
					//alert("Me acabo de completar") //if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/emp_alta_modifica.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj)
					{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
					alert(datos);
					cerrarCuadro();
					}
				});
			} //Fin de if confirma
	});
});
</script>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />


<div align="center" class='tablaInfo'>

	<form id="modificausu" name= "modificausu">

		<table width="100%" align="center">
          <tr>
            <td><p class="etiquetaInfo redonda3">Nombre</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['nombre']; ?>" size="35" id="empnom" name="empnom"/></td>
            <td><p class="etiquetaInfo redonda3">Fecha de ingreso</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['fecha_ingreso']);?>" size="35" id="empfin" name="empfin"/></td>
          </tr>
		  
		  
		  
          <tr>
            <td><p class="etiquetaInfo redonda3">CURP</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['curp']; ?>" size="35" id="empcurp" name="empcurp" maxlength="18"/></td>
            <td><p class="etiquetaInfo redonda3">Sustituye</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['sustituye']; ?>" size="35" id="empsus" name="empsus"/></td>
          </tr>      
          <tr>
		  <?php if ($rs['opciones'] == 1) {?>
            <td><p class="etiquetaInfo redonda3">Usuario</p></td>
            <td>
			<input type="text" class="txtInfo redonda5" value="<?php echo $empusu;?>" size="35" id="empusu" name="empusu"/>
			</td>
		   <?php } else {?> <input type="hidden" value="<?php echo $empusu;?>" id="empusu" name="empusu"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">No. Empleado</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['noempleado']; ?>" size="35" id="empnoe" name="empnoe"/></td>
          </tr>
          <tr>
		  <?php if ($rs['opciones'] == 1) {?>
            <td><p class="etiquetaInfo redonda3">Password</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo $r['password']; ?>" size="35" id="emppas" name="emppas"/></td>
		  <?php } else {?> <input type="hidden" value="<?php echo $r['password']; ?>" id="emppas" name="emppas"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">Tipo de empleado</p></td>
            <td>
			<select name="emptem" id="emptem" class="redonda5 inputsSig">
				<optgroup label="Tipo empleado">
					<option value="<?php echo $r['tipo_emp']; ?>"><?php echo $r['tipo_emp']; ?> ...</option>
						<option class='opciones' value="Estructura"> &nbsp; - Estructura</option>;
						<option class='opciones' value="PROFIS"> &nbsp; - PROFIS</option>;
						<option class='opciones' value="PROFIS/Programa Especial"> &nbsp; - PROFIS/Programa Especial</option>;
						<option class='opciones' value="Programa Especial"> &nbsp; - Programa Especial</option>;
						<option class='opciones' value="Becario"> &nbsp; - Becario</option>;
						<option class='opciones' value="Servicio Social"> &nbsp; - Servicio Social</option>;
				</optgroup>
			</select>
			</td>
          </tr>
          <tr>
		  <?php if ($rs['opciones'] == 1 OR $rs['nivel'] == "S") {?>
            <td><p class="etiquetaInfo redonda3">Nivel</p></td>
            <td>
			<input type="text" class="txtInfo redonda5" value="<?php echo $r['nivel']; ?>" size="35" id="empniv" name="empniv"/>
			</td>
		  <?php } else {?> <input type="hidden" value="<?php echo $r['nivel']; ?>" id="empniv" name="empniv"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">Puesto</p></td>
            <td>
			<select name="emppue" id="emppue" class="redonda5 inputsSig">
				<optgroup label="Puesto">
					<option value="<?php echo $r['puesto'] ?>"><?php echo $r['puesto'] ?> ...</option>
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
		  <?php if ($rs['opciones'] == 1) {?>
            <td><p class="etiquetaInfo redonda3">Dirección</p></td>
            <td>
			<input type="text" class="txtInfo redonda5" value="<?php echo $r['direccion']; ?>" size="35" id="empdir" name="empdir"/>
			</td>
		  <?php } else {?> <input type="hidden" value="<?php echo $r['direccion']; ?>" id="empdir" name="empdir"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">Ascenso</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['ascenso']); ?>" size="35" id="empasc" name="empasc"/></td>
          </tr>
          <tr>
		  <?php if ($rs['opciones'] == 1 ) {?>
            <td><p class="etiquetaInfo redonda3">Perfil</p></td>
            <td>
			<select name="empper" id="empper" class="redonda5 inputsSig">
				<optgroup label="Perfil">
					<option value="<?php echo $r['perfil']; ?>"><?php echo $r['perfil']; ?> ...</option>
						<option class='opciones' value="Director"> &nbsp; - Director.</option>;
				</optgroup>
			</select>
			</td>
		  <?php } else {?> <input type="hidden" value="<?php echo $r['perfil']; ?>" id="empper" name="empper"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">Ascenso 2</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['ascenso2']); ?>" size="35" id="empas2" name="empas2"/></td>
          </tr>
          <tr>
		  <?php if ($rs['opciones'] == 1 OR $rs['nivel'] == "S") {?>
            <td><p class="etiquetaInfo redonda3">Estatus</p></td>
            <td class="txtInfo">
			<select name="empsta" id="empsta" class="redonda5 inputsSig">
				<optgroup label="Estatus">
					<option value="<?php echo $tipostatus; ?>"><?php echo $tipostatus; ?> ...</option>
					<?php if ($rs['nivel'] == "DG") {?>
						<option class='opciones' value="1"> &nbsp; - Activo (Acceso al sistema ADICOM).</option>;
						<option class='opciones' value="0.5"> &nbsp; - Activo (Sin acceso al sistema ADICOM).</option>;
						<option class='opciones' value="0"> &nbsp; - inactivo (Baja / Sin acceso).</option>;
					<?php } else { ?>
						<option class='opciones' value="0"> &nbsp; - inactivo (Baja / Sin acceso).</option>;
					<?php } ?>
				</optgroup>
			</select>
			</td>
			
            <?php } else {?> <input type="hidden" value="<?php echo $tipostatus; ?>" id="empsta" name="empsta"/> <?php } ?>
            <td><p class="etiquetaInfo redonda3">Puesto anterior</p></td>
            <td>
			<select name="emppan" id="emppan" class="redonda5 inputsSig">
				<optgroup label="Puesto anterior">
					<option value="<?php echo $r['puesto_ant']; ?>"><?php echo $r['puesto_ant']; ?> ...</option>
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
            <td><p class="etiquetaInfo redonda3">Genero</p></td>
            <td class="txtInfo">
			<select name="empgen" id="empgen" class="redonda5 inputsSig">
				<optgroup label="Género">
					<option value="<?php echo $gen; ?>"><?php echo $gen; ?> ...</option>
						<option class='opciones' value="F"> &nbsp; - Femenino.</option>;
						<option class='opciones' value="M"> &nbsp; - Masculino.</option>;
				</optgroup>
			</select>
			</td>
            <td><p class="etiquetaInfo redonda3">Fecha de baja</p></td>
            <td><input type="text" class="txtInfo redonda5" value="<?php echo fechaNormal($r['fecha_baja']); ?>" size="35" id="empfba" name="empfba"/></td>
          </tr>
		  <?php if ($rs['opciones'] == 1) {?>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><p class="etiquetaInfo redonda3">Modificar Nivel</p></td>
			<td class="txtInfo">* 1 = podrá modificar el nivel de usuarios.
			<input type="text" class="txtInfo redonda5" value="<?php echo $r['opciones']; ?>" size="35" id="empopc" name="empopc"/>
			</td>
		 </tr>
         <?php } else {?> <input type="hidden" value="<?php echo $r['opciones']; ?>" id="empopc" name="empopc"/> <?php } ?>
         <tr>
         <td colspan="4" align="center"> 
		 <br>
		 <input type="hidden" value="<?php echo $r['id']; ?>" id="emp_id" name="emp_id"/>
		 <input type="hidden" name="nom" id="nom" value="<?php echo $rs['nombre']; ?>">
		 <input type="hidden" name="tipoForm" id="tipoForm" value="actreg">
		 <input type="button" class="submit_line" name="actreg" id="actreg" value="Actualizar registro">
		 </br></br>
    	</td>
            </tr>
		</table>

	</form>

</div>
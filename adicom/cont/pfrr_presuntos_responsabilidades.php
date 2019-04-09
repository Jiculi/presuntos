<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccionx']);
$pdr = 	valorSeguro($_REQUEST['pdrx']);
$tipo = valorSeguro($_REQUEST['tipox']);
$user = valorSeguro ($_REQUEST['user']);
//------------------------------------------------------------------------------
// datos del presunto
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias  WHERE num_accion = '".$accion."' AND (tipo <> 'titularTESOFE' AND tipo <> 'titularICC' AND tipo <> 'responsableInforme' AND status = 1 )",true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<center>
<h3>Presuntos</h3>

<form name="presuntosResponsabilidad" id="presuntosResponsabilidad">
<?php
$tabla = '<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
			<tr>
				<th class="ancho150"> 	<a href="#">Nombre</a>	</th>
				<th class="ancho150"> 	<a href="#">Cargo</a>	</th>
				<th class="ancho100"> 	<a href="#">RFC</a></th>
				<th class="ancho450">	<a href="#">Accion Omision</a></th>
				<th class="ancho100">	<a href="#">Responsabilidad</a></th>

			</tr>
		';

if($tipo == "responsabilidad")
{
	echo "<h3>  </h3>";

	while($r = mysql_fetch_array($sql))
	{
		$i++;
		$audiencias++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho150">'.$r['nombre'].'</td>
					<td class="ancho150">'.$r['cargo'].'</td>
					<td class="ancho100">'.$r['rfc'].'</td>
					<td class="ancho450">'.$r['accion_omision'].'</td>
					<td class="ancho100">
					
						<select name="presunto_'.$r['cont'].'" id="presunto_'.$r['cont'].'" class="redonda5">
							<option value="">Seleccionar...</option>
							<option value="1">Con Responsabilidad</option>
							<option value="0">Sin Responsabilidad</option>
							<option value="2">Abstención de Sanción</option>
							<option  name = "resp" id = "resp" hidden="responsabilidad"
						</select>
					</td>
					';
		$tabla .= '</td></tr>';
	}
	$tabla .= '</table></center>';			
}
if($tipo == "sobreseimiento")
{

	while($r = mysql_fetch_array($sql))
	{
		$i++;
		$audiencias++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho150">'.$r['nombre'].'</td>
					<td class="ancho150">'.$r['cargo'].'</td>
					<td class="ancho100">'.$r['rfc'].'</td>
					<td class="ancho450">'.$r['accion_omision'].'</td>
					<td class="ancho100">
						<select name="presunto_'.$r['cont'].'" id="presunto_'.$r['cont'].'" class="redonda5">
							<option value="">Seleccionar...</option>
							<option value="0">Sin Responsabilidad</option>
							<option  name = "sobre" id = "sobre" hidden="sobreseimiento"
							
							
							
						</select>
					</td>
					';
		$tabla .= '</td></tr>';
	}
	$tabla .= '</table></center>';			
}
elseif($pdr == "nada") 
{
	echo "<h3>Presuntos sin Responsabilidad</h3>";
	while($r = mysql_fetch_array($sql))
	{
		$i++;
		$audiencias++;
		$res = $i%2;
		if($res == 0) $estilo = "class='non'";
		else $estilo = "class='par'";
		
		$tabla .= '
				<tr '.$estilo.' >
					<td class="ancho150">'.$r['nombre'].'</td>
					<td class="ancho150">'.$r['cargo'].'</td>
					<td class="ancho100">'.$r['rfc'].'</td>
					<td class="ancho450"><table width="200" border="1">

  
  
   <tr>
	<td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="nopropor" id="nopropor" >
                              <label for="nopropor">La UAA no proporcionó los elementos idoneos para soportar la Responsabilidad</label></td>
							   <tr>
	<td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="dano" id="dano" >
                              <label for="dano">No se acreditó el Daño o Perjuicio</label></td>
     <tr>
	 <td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="doctos" id="doctos" >
                              <label for="doctos">El PR  comprobó con Documentos</label></td>
	<tr>
	<td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="respon" id="respon" >
                              <label for="respon">El PR  acreditó su No Responsabilidad</label></td>
    <tr>
    <td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="reintegro" id="reintegro" >
                              <label for="reintegro">Reintegro Parcial</label></td>
     <tr>
     <td valign="top"  width="80%"   class="">
                              <input type="checkbox" name="aclara" id="aclara" >
                              <label for="aclara"> Aclaro </label></td>
  	</tr>
	
</table>


</td>
	   <td class="ancho100">						
						<select name="presunto_'.$r['cont'].'" id="presunto_'.$r['cont'].'" class="redonda5">
						<option selected value="0">Sin Responsabilidad</option>
						</select>
</td>
					</td>
					';
		$tabla .= '</td></tr>';
	}
	$tabla .= '</table></center>';			
	
}
echo $tabla;


?>

 
   
	
<center>
<br />	<input type='button' value='Guardar Presuntos'  class='submit_line'  onclick='presuntoYresponsabilidad()' />
</center>
</form>
</center>
</body>
</html>
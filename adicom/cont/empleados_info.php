<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ERROR);
require_once("../includes/clases.php");
require_once("../includes/funciones.php");

$conexion = new conexion;
$conexion->conectar();

//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$empleado = valorSeguro($_REQUEST['emp']);
$empid = valorSeguro($_REQUEST['id']);

$sql = $conexion->select("SELECT * FROM usuarios WHERE  id  = '".$empid."' and usuario = '".$empleado."' ",false);

$total = mysql_num_rows($sql);
$r = mysql_fetch_array($sql);	

$nivPart = explode(".",$r['nivel']);
$nivDir = $nivPart[0];
$nivSbd = $nivPart[0].".".$nivPart[1];
$nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
$nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];

if ($nivDir == "S"){$nivDir = $r['direccion'];} 
else if (strlen($r['nivel'])==1){$nivDir = "DG";}
$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
$d = mysql_fetch_array($sql1);
$director = $d['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
$s = mysql_fetch_array($sql1);
$subdirector = $s['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
$d = mysql_fetch_array($sql1);
$jefe = $d['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' ",false);
$d = mysql_fetch_array($sql1);
$coordinador = $d['nombre'];

if ($r['status'] == 1) $tipostatus = "Activo"; 
		else if ($r['status'] == 0.5) $tipostatus = "Sin acceso";
		else $tipostatus = "Inactivo";
		
if ($r['genero'] == "F" OR $r['genero'] == "f") $gen = "Femenino"; 
		else if ($r['genero'] == "M" OR $r['genero'] == "m") $gen = "Masculino";	
		else $gen = "¿?";
?>

<script>
function enviaF(nom)
{
	var formulario = document.getElementById(nom);
	//var confirma = confirm("Se enviara la siguiente información: \n\n"+$$("#"+nom+""));
	formulario.submit();	
}
</script>

<link rel="stylesheet" href="css/estilos_adm.css" type="text/css" media="screen" title="default" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</br></br>

<table align="center" class='tablaInfo' width="100%">


          <tr>
            <td><p class="etiquetaInfo redonda3">Nombre</p></td>
            <td><p class="txtInfo"><?php echo $r['nombre']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Director</p></td>
            <td><p class="txtInfo">Lic. <?php echo $director; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Puesto</p></td>
            <td><p class="txtInfo"><?php echo $r['puesto']; ?></p></td>
		<?php if (strlen($r['nivel'])!=1 and strlen($r['nivel'])!=3 and $r['nivel']!="DG") {?>
            <td><p class="etiquetaInfo redonda3">Subdirector</p></td>
            <td><p class="txtInfo">Lic. <?php echo $subdirector; ?></p></td>
		<?php } ?>
          </tr>
                   
          <tr>
            <td><p class="etiquetaInfo redonda3">Tipo de Empleado</p></td>
            <td><p class="txtInfo"><?php echo $r['tipo_emp']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Sustituyo a</p></td>
            <td><p class="txtInfo"><?php echo $r['sustituye']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Fecha de Ingreso</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_ingreso']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Fecha de ascenso</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['ascenso']); ?></p></td>
            </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">No. Empleado</p></td>
            <td><p class="txtInfo"><?php echo $r['noempleado']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Puesto anterior</p></td>
            <td> <p class="txtInfo"><?php echo $r['puesto_ant']; ?></p></td>
             </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Curp</p></td>
            <td><p class="txtInfo"><?php echo $r['curp']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Estatus</p></td>
            <td> <p class="txtInfo"><?php echo $tipostatus; ?></p></td>
             </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Genero</p></td>
            <td><p class="txtInfo"><?php echo $gen; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Fecha de baja</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_baja']); ?>
            </p></td>
          </tr>
          <tr>
            <td ><p class="etiquetaInfo redonda3">Nivel</p></td>
            <td><p class="txtInfo"><?php echo $r['nivel']; ?></p></td>
            <td ><p class="etiquetaInfo redonda3">Última actualización</p></td>
            <td><p class="txtInfo"><?php echo  $a['ultim']; ?></p></td>
		  </tr>

</table>
     
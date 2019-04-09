<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$id = valorSeguro(trim($_REQUEST['id']));
$abogado = valorSeguro(trim($_REQUEST['abogado']));
$folio = valorSeguro(trim($_REQUEST['folio']));

$sql = $conexion->select("SELECT * FROM oficios WHERE folio = '$folio' ",false);
$total = mysql_num_rows($sql);
$r = mysql_fetch_array($sql);

//---------------------- sacar subdirector -----------------------------------------
$sql1 = $conexion->select("SELECT * FROM usuarios WHERE usuario = '".$abogado."' ",false);
$x = mysql_fetch_array($sql1);
$usuNivel = $x['nivel'];
//-----------------
$nivPart = explode(".",$usuNivel);
$nivDir = $x['direccion'];
$nivSbd = $x['direccion'].".".$nivPart[1];
$nivJdd = $x['direccion'].".".$nivPart[1].".".$nivPart[2];
$nivCor = $x['direccion'].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];
/*
$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
$d = mysql_fetch_array($sql1);
$director = $d['nombre'];
*/
$sql2 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
$s = mysql_fetch_array($sql2);
$subdirector = $s['nombre'];
/*
$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
$d = mysql_fetch_array($sql1);
$jefe = $d['nombre'];

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' ",false);
$d = mysql_fetch_array($sql1);
$coordinador = $d['nombre'];
*/
//---------------------------------------------------------------


?>

<table width="90%" align="center">
<tr>
    <td width="50%">
        <div class="volDivCont redonda5">
        <table  align="center" width="100%" border="0" class="tablaPasos tablaVol">
          <tr>
            <td  class="etiquetaPo"><p>Destinatario:</p></td>
              
            <td >
                <?php echo $r['destinatario'] ?>
                <!-- <input type="hidden" name="idRem" id="idRem" size="35" class="redonda5"  readonly> -->
            </td>
          </tr>
          <tr>
            <td class="etiquetaPo">  <p>Cargo:</p></td>
            <td>
              <?php echo $r['cargo_destinatario'] ?>
            </td>
          </tr>
            <tr>
            <td class="etiquetaPo">  <p>Dependencia:</p></td>
            <td>
              <?php echo $r['dependencia'] ?>
            </td>
          </tr>
          </table> 
          </div>
      </td>
      <td width="50%" rowspan="3" valign="top">
      
                 <div class="volDivCont redonda5" id="camposAcciones">

           <h3>Oficio <span id="oficio"></span> </h3>
            <?php echo  $r['folio'] ?> 
            </div>
                       <div class="volDivCont redonda5" id="camposAcciones">

            
            <h3>Acciones Vinculadas <span id="accionesNo"></span> </h3>
            <?php echo str_replace("|","<br>",$r['num_accion']) ?>

            </div>
           <div class="volDivCont redonda5" id="camposAcciones">
           <h3>Tipo <span id="accionesNo"></span> </h3>
            <?php 
			if($r['tipo'] == "asistencia") echo "Asistencia Jurídica"; 
			if($r['tipo'] == "notificacionEF") echo "Notificación a Entidad Fiscalizada"; 
			if($r['tipo'] == "notificacionICC") echo "Notificación a Instancia de Control Compentente"; 
			if($r['tipo'] == "remisionUAA") echo "Remisión a la UAA"; 
			if($r['tipo'] == "otros") echo "Otros Oficios"; 
			
			?>
            </div>
      </td>
    </tr>
    <tr>
        <td width="50%">
            <div class="volDivCont redonda5">
             <table align="center" width="100%" border="0" class="tablaPasos tablaVol">         
              <tr>
                <td class="etiquetaPo"> <p>Referencia:</p></td>
                <td>
                  <?php echo $r['oficio_referencia'] ?>
                </td>
              </tr>
                <td class="etiquetaPo"> <p>Asunto:</p></td>
                <td>
                  <?php echo $r['asunto'] ?>
                </td>
              </tr>
            </table>
            </div>
        </td>
        <td width="50%" valign="top">
        <!--
            celdas vacias
        -->
        </td>
    </tr>

    <tr>
    <td>
		<div class="volDivCont redonda5">
           <table align="center" width="100%" border="0" class="tablaPasos tablaVol">
             <tr>
                <td class="etiquetaPo"> <p> Fecha oficio: </p></td>
                <td> <?php echo fechaNormal($r['fecha_oficio'])." ".$r['hora_oficio'] ?> </td>
             </tr> 
         
             <tr>
                <td class="etiquetaPo"> <p> Elaborado por: </p></td>
                <td> <?php echo $x['nombre'] ?> </td>
             </tr> 
             <tr>
                <td class="etiquetaPo"> <p> Subdirector: </p></td>
                <td> <?php echo $subdirector ?> </td>
             </tr> 
             <tr>
                <td class="etiquetaPo"> <p> Dirección: </p></td>
                <td> <?php echo $x['direccion'] ?> </td>
             </tr> 
            </table>
            </div>
    </td>
    </tr>

    
    <tr>
        <td colspan="3" align="center">
        <input name='userForm' id='userForm' type="hidden" value="" />
        <input name='dirForm' id='dirForm' type="hidden" value="" />
        <!-- <input type="button" class="submit-login" value="Generar Oficio" onclick="generarOficio()" /> -->
        </td>
    </tr>
</table>



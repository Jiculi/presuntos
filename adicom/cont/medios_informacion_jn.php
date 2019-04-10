<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<script>
$$(function() {
//--------------------------------------------------------------------------------------------------------------
//----------------------------------------- REGISTRAR RECEPCION ------------------------------------------------
//--------------------------------------------------------------------------------------------------------------
	$$( "#f1_fecha_presc" ).datepicker({
      //defaultDate: "+1w", //mas una semana
      numberOfMonths:1,	  //meses a mostrar
	  showAnim:'slideDown',
	  changeYear: true
	  //minDate: "-1w",
	  //maxDate: "+1m",
	  //beforeShowDay: noLaborales
	  /*
	  ,
      onClose: function( selectedDate ) 
	  { 
		//--- para sigiente fecha 
	  	$$( "#f2po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
		//$$( "#f2po_acuse_oficio" ).datepicker( "option", "maxDate", restaNolaborables(selectedDate,5)  ); 
	  }*/
    });
});
function muestraCuadroMto()
{
	mostrarCuadro2(200,300,'Modificar monto ');
	var form = "";
	
	form += "<h3>Nuevo Monto </h3>";
	form += "<center> <input type='text' name='nvoMonto' id='nvoMonto' class='redonda5' onchange='formatoMoneda(this)'> </center> <br>";
	form += "<center> <input type='button' value='Actualizar' onclick='nvoMontomedios()' class='submit_line'> </center>";
	
	$$("#cuadroRes2").html(form);
	
}
//----------------------------------------
function nvoMontomedios()
{
	var accion = "<?php echo $_REQUEST['numAccion'] ?>";
	var monto = $$("#nvoMonto").val();
	var confirma = confirm("Una vez cambiado este monto no se podra modificar nuevamente \n\n - Cantidad: "+monto+"  \n\n ¿Desea actualizar el monto?");
	if(confirma)
	{
		$$.ajax({
			type: "POST",
			url: "procesosAjax/medios_montoUAA.php",
			//beforeSend: function(){ $$('#cuadroRes2').html(" <center> <br><br> <b> <img src='images/load_grande.gif' /> Espere... <br><br> </b> </center> ") },
			data: {
					accion:accion,
					monto:monto
				},
			success: function(data) 
				{ 	
					//alert(data);
					cerrarCuadro2();
					mostrarCuadro(500,900,"Informacion de la Acción",20,"cont/medios_informacion.php","numAccion="+accion)
				}
		});
	}//end confirm 
}

</script>
<?php
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$id = valorSeguro($_REQUEST['id']);

$query = "SELECT 
				medios.*,
				medios.nombre as actor,
				medios.entidad as entidadFis,								
				medios.num_accion,
				usuarios.nombre,
				usuarios.usuario,
				estados_tramite.detalle_estado,
				estados_tramite.id_sicsa,
				estados_sicsa.id_sicsa,
				estados_sicsa.estado_sicsa,
				medios_rr.rr as RR
		FROM medios 
		LEFT JOIN usuarios ON medios.usuario = usuarios.usuario
		LEFT JOIN estados_tramite ON estado = id_estado
		LEFT JOIN estados_sicsa ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa
		LEFT JOIN medios_rr ON medios_rr.idPresunto = medios.id
		WHERE medios.id = '".$id."'
		LIMIT 1 ";
$sql = $conexion->select($query,false);

$total = mysql_num_rows($sql);			
$r = mysql_fetch_array($sql);	

$nivPart = explode(".",$r['subnivel']);
$nivDir = $nivPart[0];
$nivSbd = $nivPart[0].".".$nivPart[1];
$nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
$nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];

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

$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$r['subnivel']."' ",false);
$a = mysql_fetch_array($sql1);
$abogado = $a['nombre'];

	
?>

<?php 
	$tamNiv = strlen($_REQUEST['nivel']);

	if($_REQUEST['direccion'] == "DG" || $_REQUEST['nivel'] == "S" || $tamNiv == 3 || $tamNiv == 1) {?>
	<a href="#" title="Asignar Acción" class="" onclick=" new mostrarCuadro2(250,800,'Asignar Acción <?php echo $_REQUEST['numAccion'] ?>',100,'cont/medios_asigna_acciones.php','accion=<?php echo $r['num_accion'] ?>&idPresunto=<?php echo $r['id'] ?>&presunto=<?php echo urlencode($r['actor']) ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> <img src="images/User-Files-iconAcc.png"> Reasignar Accion </a>
<?php } ?>

<link href="css/estilos_medios.css" rel="stylesheet" type="text/css" />
<table align="center" class='tablaInfo' width="100%">

          <tr>
            <td><p class="etiquetaInfo redonda3">Clave de Acción</p></td>
            <td><p class="txtInfo"><?php echo $accion ?></p></td>
            <td><p class="etiquetaInfo redonda3">Entidad Fiscalizada</p></td>
            <td><p class="txtInfo"><?php echo $r['entidad']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Superveniente </p></td>
            <td><p class="txtInfo"><?php echo $r['superveniente']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">UAA</p></td>
            <td><p class="txtInfo"><?php echo $r['UAA']; ?></p></td>
          </tr>
                   
          <tr>
            <td><p class="etiquetaInfo redonda3">Procedimiento</p></td>
            <td><p class="txtInfo"><?php echo $r['num_procedimiento']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Fondo</p></td>
            <td><p class="txtInfo"><?php echo $r['fondo']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">DT</p></td>
            <td><p class="txtInfo"><?php echo urldecode($r['num_DT']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Director</p></td>
            <td><p class="txtInfo">Lic. <?php echo $director ?></td>
            </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">PDR</p></td>
            <td><p class="txtInfo"><?php echo $r['pdr']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Subdirector</p></td>
            <td> <p class="txtInfo"> Lic. <?php echo $subdirector ?></p></td>
             </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">PDRCS</p></td>
            <td><p class="txtInfo"><?php echo $r['pdrcs']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Cuenta Pública</p></td>
            <td> <p class="txtInfo"><?php echo $r['cp'] ?></p></td>
             </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">PO</p></td>
            <td><p class="txtInfo"><?php echo $r['po']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Jefe de depto.</p></td>
            <td><p class="txtInfo">Lic. 
              <?php echo $jefe; ?>
            </p></td>
          </tr>
          <tr>
            <td ><p class="etiquetaInfo redonda3">Num de Auditoria</p></td>
            <td><p class="txtInfo"><?php echo $r['auditoria']; ?></p></td>
            <td ><p class="etiquetaInfo redonda3">Coordinador</p></td>
            <td><p class="txtInfo">Lic.</p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Última actualizacion</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_edo_tramite']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Abogado</p></td>
            <td><p class="txtInfo">Lic. <?php echo $r['abogado']; ?><?php echo $row_asignacion['nombre']; ?></p></td>
          </tr>
        
          <tr>
            <td><p class="etiquetaInfo redonda3">Hora</p></td>
            <td><p class="txtInfo"><?php echo $r['hora']; ?><br>            
            </p></td>
            <td><p class="etiquetaInfo redonda3">Estado SICSA</p></td>
            <td><p class="txtInfo"><?php echo $r['estado_sicsa']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Actualizado por</p></td>
            <td><p class="txtInfo"><?php echo $r['nombre']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Control Interno</p></td>
            <td><p class="txtInfo"><?php echo $r['detalle_estado']; ?></p></td>
          </tr>
                  
<?php
//echo montoConFuncion($accion);
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------ -->     
        
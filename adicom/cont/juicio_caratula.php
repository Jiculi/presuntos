<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting(E_ERROR);
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
	form += "<center> <input type='button' value='Actualizar' onclick='nvoMontoPFRR()' class='submit_line'> </center>";
	
	$$("#cuadroRes2").html(form);
	
}
//----------------------------------------
function nvoMontoPFRR()
{
	var juicio = "<?php echo $_REQUEST['juicio'] ?>";
	var monto = $$("#nvoMonto").val();
	var confirma = confirm("Una vez cambiado este monto no se podra modificar nuevamente \n\n - Cantidad: "+monto+"  \n\n ¿Desea actualizar el monto?");
	if(confirma)
	{
		$$.ajax({
			type: "POST",
			url: "procesosAjax/pfrr_montoUAA.php",
			//beforeSend: function(){ $$('#cuadroRes2').html(" <center> <br><br> <b> <img src='images/load_grande.gif' /> Espere... <br><br> </b> </center> ") },
			data: {
					accion:accion,
					monto:monto
				},
			success: function(data) 
				{ 	
					//alert(data);
					cerrarCuadro2();
					mostrarCuadro(500,900,"Informacion de la Acción",20,"cont/pfrr_informacion.php","numAccion="+accion)
				}
		});
	}//end confirm 
}

</script>
<link rel="stylesheet" href="css/estilos_juicio.css" type="text/css" media="screen" title="default" />

<?php
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$jn = valorSeguro($_REQUEST['juicio']);

$sql = $conexion->select("SELECT 
								*
						FROM juicios
						WHERE nojuicio = '".$jn."'",false);

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
$accion=$r['accion'];
	
?>

<?php 
	$tamNiv = strlen($_REQUEST['nivel']);

	if($_REQUEST['direccion'] == "DG" || $_REQUEST['nivel'] == "S" || $tamNiv == 3 || $tamNiv == 1|| $tamNiv == 5) {?>
	<a href="#" title="Asignar Acción" class="" onclick=" new mostrarCuadro2(250,800,'Asignar JN <?php echo $_REQUEST['jn'] ?>',100,'cont/jn_asigna_acciones.php','jn=<?php echo $_REQUEST['jn'] ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> <img src="images/User-Files-iconAcc.png"> Reasignar JN </a>
<?php } ?>

<link href="css/estilos_pfrr.css" rel="stylesheet" type="text/css" />
<table align="center" class='tablaInfo' width="100%">

          <tr>
            <td><p class="etiquetaInfo redonda3">Clave de Acción</p></td>
            <td><p class="txtInfo"><?php echo $accion ?></p></td>
            <td><p class="etiquetaInfo redonda3">Entidad</p></td>
            <td><p class="txtInfo"><?php echo $r['entidad']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Procedimiento </p></td>
            <td><p class="txtInfo"><?php echo $r['procedimiento']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">CP</p></td>
            <td><p class="txtInfo"><?php echo $r['cuentapublica']; ?></p></td>
          </tr>
                   
          <tr>
            <td><p class="etiquetaInfo redonda3">Notifiacación DGR</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fechanot']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Sala Conocimiento</p></td>
            <td><p class="txtInfo"><?php echo $r['salaconocimiento']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Vencimiento Fatal</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['vencimiento']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Director</p></td>
            <td><p class="txtInfo">Lic. <?php echo $director ?></td>
            </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Direccion de Origen</p></td>
            <td><p class="txtInfo"><?php echo $r['dir']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Subdirector</p></td>
            <td> <p class="txtInfo"> Lic. <?php echo $subdirector ?></p></td>
             </tr>
          <tr>
            <td></td>
            <td></td>
            <td><p class="etiquetaInfo redonda3">Jefe de depto.</p></td>
            <td><p class="txtInfo">Lic. 
              <?php echo $jefe; ?>
            </p></td>
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
            <td><p class="etiquetaInfo redonda3">Control Interno</p></td>
            <td><p class="txtInfo"><?php echo $r['estado']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Actualizado por</p></td>
            <td><p class="txtInfo"><?php echo $r['nombre']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Observaciones</p></td>
            <td><p class="txtInfo"><?php echo $r['observaciones']; ?></p></td>
          </tr>
                  
          

               
               
                </td>

            
	
         <tr>
            <td><div class="etiquetaInfo redonda3"> Monto</div></td>

            <td><p class="txtInfo">
			<?php 
				//echo number_format(dameTotalPFRR($accion),2) 
				//echo number_format(dameTotalPFRR($accion),2) 
				//require_once('../procesosAjax/pfrr_reintegros_calcula.php'); 
				echo  number_format($r['monto'],2);
			?></p></td>
            
			 

    <input type="hidden" name="hiddenField" id="hiddenField">

	            <td><p class="etiquetaInfo redonda3">Localización</p></td>
            <td><p class="txtInfo"><?php echo $r['']; ?></p></td>

            </tr>
			
			 	 
        </table>

<?php
//echo montoConFuncion($accion);
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------ -->     
        
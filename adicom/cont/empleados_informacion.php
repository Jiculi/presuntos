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
	var accion = "<?php echo $_REQUEST['numAccion'] ?>";
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
<?php
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$accion = valorSeguro($_REQUEST['numAccion']);

$sql = $conexion->select("SELECT 
								pfrr.num_accion,
								pfrr.superveniente,
								pfrr.cp,
								pfrr.auditoria,
								pfrr.entidad,
								pfrr.subdirector,
								pfrr.abogado,
								pfrr.po,
								pfrr.num_DT,
								pfrr.monto_no_solventado,
								pfrr.monto_no_solventado_UAA,
								pfrr.prescripcion,
								pfrr.detalle_edo_tramite,
								pfrr.num_procedimiento,
								pfrr.pdr,
								pfrr.fecha_edo_tramite,
								pfrr.hora,
								pfrr.direccion,
								pfrr.f1_fecha_presc,
								pfrr.subnivel,
								pfrr.inicio_frr,
								pfrr.pdrcs,
								fondos.num_accion,
								fondos.fondo,
								fondos.UAA,
								usuarios.nombre,
								usuarios.usuario,
								estados_tramite.detalle_estado,
								estados_tramite.id_sicsa,
								estados_sicsa.id_sicsa,
								estados_sicsa.estado_sicsa
						FROM pfrr 
						LEFT JOIN po ON pfrr.num_accion=po.num_accion
						LEFT JOIN fondos ON pfrr.num_accion = fondos.num_accion 
						LEFT JOIN usuarios ON pfrr.usuario = usuarios.usuario
						INNER JOIN estados_tramite ON detalle_edo_tramite = id_estado
						INNER JOIN estados_sicsa ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa
						WHERE pfrr.num_accion = '".$accion."'",false);

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

	
?>

<?php 
	$tamNiv = strlen($_REQUEST['nivel']);

	if($_REQUEST['direccion'] == "DG" || $_REQUEST['nivel'] == "S" || $tamNiv == 3 || $tamNiv == 1) {?>
	<a href="#" title="Asignar Acción" class="" onclick=" new mostrarCuadro2(250,800,'Asignar Acción <?php echo $_REQUEST['numAccion'] ?>',100,'cont/pfrr_asigna_acciones.php','accion=<?php echo $_REQUEST['numAccion'] ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> <img src="images/User-Files-iconAcc.png"> Reasignar Accion </a>
<?php } ?>

<link href="css/estilos_pfrr.css" rel="stylesheet" type="text/css" />
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
                  
          


             <td><p class="etiquetaInfo redonda3">Prescripción</p></td>
            <td> <p class="txtInfo">
            <form name="fpress">
            	 <input class="redonda5" id="f1_fecha_presc" name="f1_fecha_presc" type="text" value='<?php echo fechaNormal($r['prescripcion']) ?>' readonly>
                 <input class="submit_line" type="button" name="Registrar"  id="Registrar" value="Guardar Fecha" onclick="guardaPrescripcionPFRR()">
                 <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
            </form>
            	</p>
            </td>
            </tr>
            
	
         <tr>
            <td><div class="etiquetaInfo redonda3"> Monto PO</div></td>
            <td><p class="txtInfo">
			<?php 
				//echo number_format(dameTotalPFRR($accion),2) 
				//echo number_format(dameTotalPFRR($accion),2) 
				//require_once('../procesosAjax/pfrr_reintegros_calcula.php'); 
				echo  number_format(dameTotalPO($accion),2)
			?></p></td>
            
      		<td><div class="etiquetaInfo redonda3"> Monto Inicio del PFRR <p style="font-size:8px">IMPORTE DEL DAÑO</p> </div></td> 
			<td><p class="txtInfo">
                        <form name="fmonto">
            	 <input class="redonda5" id="monto_pfrr" name="monto_pfrr" type="text" value='<?php echo number_format($r['inicio_frr']) ?>' >
                 <input class="submit_line" type="button" name="RegistrarM"  id="RegistrarM" value="Guardar Importe" onclick="guardaMonto()">
                 <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
            </form>

            
			<?php
			/*echo montoConFuncion($accion)*/ 
			/* echo @number_format(sumaPresuntosPFRR($accion),2) */
			//echo  @number_format(dameMontoInicialPFRR($accion),2);
			 ?></p></td>

          

      </div>
    </div>
    <input type="hidden" name="hiddenField" id="hiddenField">


</div>
            </tr>
        </table>

<?php
//echo montoConFuncion($accion);
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------ -->     
        
<?php
    session_start();   // FLL

		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Content-Type: text/html;charset=utf-8");
		error_reporting(E_ERROR);
		//error_reporting(E_ALL);
		require_once("./includes/clases.php");
		require_once("./includes/funciones.php");


?>

<meta http-equiv="content-type" content="text/html; charset=UTF-8">


<script>

		jQuery(function() {
				//--------------------------------------------------------------------------------------------------------------
				//----------------------------------------- REGISTRAR RECEPCION ------------------------------------------------
				//--------------------------------------------------------------------------------------------------------------
					$( "#f1_fecha_presc" ).datepicker({
							//defaultDate: "+1w", //mas una semana
							numberOfMonths:1,	  //meses a mostrar
						showAnim:'slideDown',
						changeMonth: true,
						changeYear: true
						//minDate: "-1w",
						//maxDate: "+1m",
						//beforeShowDay: noLaborales
						/*
						,
							onClose: function( selectedDate ) 
						{ 
						//--- para sigiente fecha 
							$( "#f2po_acuse_oficio" ).datepicker( "option", "minDate", selectedDate );  
						//$( "#f2po_acuse_oficio" ).datepicker( "option", "maxDate", restaNolaborables(selectedDate,5)  ); 
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
					
					$("#cuadroRes2").html(form);
					
				}
		//----------------------------------------
		function nvoMontoPFRR()
				{
					var accion = "<?php echo $_REQUEST['numAccion'] ?>";
					var monto = $("#nvoMonto").val();
					var confirma = confirm("Una vez cambiado este monto no se podra modificar nuevamente \n\n - Cantidad: "+monto+"  \n\n ¿Desea actualizar el monto?");
					if(confirma)
					{
						$.ajax({
							type: "POST",
							url: "procesosAjax/pfrr_montoUAA.php",
							//beforeSend: function(){ $('#cuadroRes2').html(" <center> <br><br> <b> <img src='images/load_grande.gif' /> Espere... <br><br> </b> </center> ") },
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

		$sql1 = $conexion->select("SELECT po.fecha_del_pliego FROM po WHERE po.num_accion = '".$accion."'",false);

		$r1 = mysql_fetch_array($sql1);

		$sql = $conexion->select("SELECT 
										pfrr.num_accion,
										pfrr.superveniente,
										pfrr.cp,
										pfrr.auditoria,
										pfrr.entidad,
										pfrr.subdirector,
										pfrr.abogado,
										pfrr.po,
										pfrr.fecha__po,
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
																		pfrr.monto_pdr,
										pfrr.pdrcs,
										pfrr.fecha_IR,
										pfrr.et_impugnacion,
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

		$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' AND status = 1 ",false);
		$d = mysql_fetch_array($sql1);
		$director = $d['nombre'];

		$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' AND status = 1 ",false);
		$s = mysql_fetch_array($sql1);
		$subdirector = $s['nombre'];

		$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' AND status = 1 ",false);
		$d = mysql_fetch_array($sql1);
		$jefe = $d['nombre'];

		$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' AND status = 1 ",false);
		$d = mysql_fetch_array($sql1);
		$coordinador = $d['nombre'];

		$abogresp = $_REQUEST['direccion'];

		if($r1['fecha_del_pliego'] != "" ){$fechapo = $r1['fecha_del_pliego']; } else { $fechapo = $r['fecha__po']; }
?>

<?php 
	$tamNiv = strlen($_REQUEST['nivel']);

	if($_REQUEST['direccion'] == "DG" || $_REQUEST['nivel'] == "S" || $tamNiv == 5 || $tamNiv == 3 || $tamNiv == 1) {?>
	<a href="#" title="Asignar Acción" class="" onclick=" new mostrarCuadro2(250,800,'Asignar Acción <?php echo $_REQUEST['numAccion'] ?>',100,'adicom/cont/pfrr_asigna_acciones.php','accion=<?php echo $_REQUEST['numAccion'] ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> <img src="adicom/images/User-Files-iconAcc.png"> Reasignar Accion </a>
<?php } 
?>
<!-- FLL 
<a href="#" title="Asignar Acción" class="" onclick=" new mostrarCuadro2(250,800,'Asignar Acción <?php echo $_REQUEST['numAccion'] ?>',100,'cont/pfrr_asigna_acciones.php','accion=<?php echo $_REQUEST['numAccion'] ?>&direccion=<?php echo $_REQUEST['direccion'] ?>&usuario=<?php echo $_REQUEST['usuario'] ?>&nivel=<?php echo $_REQUEST['nivel'] ?>') "> <img src="images/User-Files-iconAcc.png"> Reasignar Accion </a>
-->



 <link href="adicom/css/adicom.css" rel="stylesheet" type="text/css" />  <!-- FLL -->
 <script type="text/javascript" src="adicom/js/funciones.js"></script>  <!-- FLL -->




<!--FLL no se usa <link href="adicom/css/estilos_pfrr.css" rel="stylesheet" type="text/css" />  -->
<table align="center" class='tablaInfo' width="100%">

          <tr>
            <td><p class="etiquetaInfo redonda3">Clave de Acción</p></td>
            <td><p class="txtInfo"><?php echo $accion ?></p></td>
            <td><p class="etiquetaInfo redonda3">Entidad Fiscalizada</p></td>
            <td><p class="txtInfo"><?php echo $r['entidad']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Superveniente </p></td>
            <td><p class="txtInfo">
		<?php if ($r['superveniente'] != "" || $r['superveniente'] == "NULL" ) { 
					echo      $r['superveniente'];
		} else { ?>
                        <form name="fclvsicsa">
            	 <input type="text" class="redonda5" id="clv_sicsa" name="clv_sicsa" value='<?php echo $r['superveniente'] ?>' >
				 <input type="hidden" id="edtramsic" name="edtramsic" value='<?php echo $r['detalle_edo_tramite'] ?>' >
				 <input type="hidden" id="ussic" name="ussic" value='<?php echo $_REQUEST['usuario']; ?>' >
			<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrasic"  id="Registrasic" value="Guardar" onclick="clvsicsa()">
			<?php } ?>
                 <input type="hidden" name="accionsic" id="accionsic" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>
		</p></td>
			
            <td><p class="etiquetaInfo redonda3">UAA</p></td>
            <td><p class="txtInfo"><?php echo $r['UAA']; ?></p></td>
          </tr>
                   
          <tr>
            <td><p class="etiquetaInfo redonda3">Procedimiento</p></td>
            <td><p class="txtInfo">
			<?php ///echo $r['num_procedimiento']; ?>
			
			<?php if ($r['num_procedimiento'] != "" || $r['num_procedimiento'] == "NULL" ) { 
					echo      $r['num_procedimiento'];
		} else { ?>
                        <form name="fnoproc">
            	 <input type="text" class="redonda5" id="no_proc" name="no_proc" value='<?php echo $r['num_procedimiento'] ?>' >
				 <input type="hidden" id="edtramproc" name="edtramproc" value='<?php echo $r['detalle_edo_tramite'] ?>' >
				 <input type="hidden" id="usproc" name="usproc" value='<?php echo $_REQUEST['usuario']; ?>' >
			<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrasic"  id="Registrasic" value="Guardar" onclick="guardanoproced()">
			<?php } ?>
                 <input type="hidden" name="accionproc" id="accionproc" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>

			
			</p></td>
            <td><p class="etiquetaInfo redonda3">Fondo</p></td>
            <td><p class="txtInfo"><?php echo $r['fondo']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">DT</p></td>
            <td><p class="txtInfo">
		<?php ///if ($_REQUEST['direccion'] == "DG" ) {  ?>
                        <form name="fdt">
            	 <input type="text" class="redonda5" id="ndt" name="ndt" value='<?php echo urldecode($r['num_DT']) ?>' >
				 <input type="hidden" id="edtramdt" name="edtramdt" value='<?php echo $r['detalle_edo_tramite'] ?>' >
				 <input type="hidden" id="usdt" name="usdt" value='<?php echo $_REQUEST['usuario']; ?>' >
		<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrasic"  id="Registrasic" value="Guardar" onclick="pfrndt()">
		<?php } ?>
                 <input type="hidden" name="acciondt" id="acciondt" value="<?php echo $accion; ?>">
            </form>
		<?php ///} ?>

			
			</p></td>
			
            <td><p class="etiquetaInfo redonda3">Director</p></td>
            <td><p class="txtInfo">Lic. <?php echo $director ?></td>
            </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">PDR</p></td>
            <td><p class="txtInfo">
			<?php /// echo $r['pdr']; ?>
			
			<?php if ($r['pdr'] != "" && $abogresp != "DG") {
					echo $r['pdr'];
		} else { ?>
                        <form name="nopdr">
            	 <input class="redonda5" id="n_pdr" name="n_pdr" type="text" value='<?php echo $r['pdr'] ?>' >
				 <input type="hidden" id="edtrampdr" name="edtrampdr" value='<?php echo $r['detalle_edo_tramite']; ?>' >
				 <input type="hidden" id="uspdr" name="uspdr" value='<?php echo $_REQUEST['usuario']; ?>' >
                                   
		<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrar"  id="Registrar" value="Guardar" onclick="guardapdr()">
		<?php } ?>
                                    

                 <input type="hidden" name="num_accionpdr" id="num_accionpdr" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>
			
			</p></td>
            <td><p class="etiquetaInfo redonda3">Subdirector</p></td>
            <td> <p class="txtInfo"> Lic. <?php echo $subdirector ?></p></td>
             </tr>
          <tr>
            <!---td><p class="etiquetaInfo redonda3">PDRCS</p></td>
            <td><p class="txtInfo"><?php echo $r['pdrcs']; ?></p></td------>
            <td><p class="etiquetaInfo redonda3">Cuenta Pública</p></td>
            <td> <p class="txtInfo"><?php echo $r['cp'] ?></p></td>
             </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">PO</p></td>
            <td><p class="txtInfo"><?php echo $r['po']; ?> --- <?php echo fechaNormal($fechapo); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Jefe de depto.</p></td>
            <td><p class="txtInfo">Lic. 
              <?php echo $jefe; ?>
            </p></td>
          </tr>
          <tr>
            <td ><p class="etiquetaInfo redonda3">Num de Auditoria</p></td>
            <td><p class="txtInfo"><?php echo $r['auditoria']; ?></p></td>
            <td><p class="etiquetaInfo redonda3">Abogado</p></td>
            <td><p class="txtInfo">Lic. <?php echo $r['abogado']; ?><?php echo $row_asignacion['nombre']; ?></p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Última actualizacion</p></td>
            <td><p class="txtInfo"><?php echo fechaNormal($r['fecha_edo_tramite']); ?></p></td>
            <td><p class="etiquetaInfo redonda3">Estado SICSA</p></td>
            <td><p class="txtInfo"><?php
			
			if ($r['detalle_edo_tramite'] == "16")
			{ $edo = "Iniciado"; } 
			else { $edo = $r['estado_sicsa']; }
			
			if ($r['et_impugnacion'] == "45")
			{ $edo = "Medios de Defensa Contra Resolución"; }
			if ($r['et_impugnacion'] == "46" OR $r['et_impugnacion'] == "47" OR $r['et_impugnacion'] == "48")
			{ $edo = "Resolución Notificada"; }
		
			echo $edo; 
			
			?></p></td>
          </tr>
        
          <tr>
            <td><p class="etiquetaInfo redonda3">Hora</p></td>
            <td><p class="txtInfo"><?php echo $r['hora']; ?><br>            
            </p></td>
            <td><p class="etiquetaInfo redonda3">Control Interno</p></td>
            <td><p class="txtInfo"><?php
			
			$etim = $r['et_impugnacion'];
			$sql5 = $conexion->select("SELECT * FROM `estados_tramite` WHERE `id_estado` LIKE '".$etim."' ",false);
			$etimp = mysql_fetch_array($sql5);
			
			if ($etim == "0") 
			{ echo $r['detalle_estado']; }
			else { echo $etimp['detalle_estado']; }
			
			?>
			</p></td>
          </tr>
          <tr>
            <td><p class="etiquetaInfo redonda3">Actualizado por</p></td>
            <td><p class="txtInfo"><?php echo $r['nombre']; ?></p></td>
            
          </tr>
                  
          


             <td><p class="etiquetaInfo redonda3">Fecha Irregularidad</p></td>
            <td> <p class="txtInfo">
            <form name="fpress">
            	 <input class="redonda5" id="f1_fecha_presc" name="f1_fecha_presc" type="text" value='<?php echo fechaNormal($r['fecha_IR']) ?>' readonly>
		<?php// if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrar"  id="Registrar" value="Guardar" onclick="guardaPrescripcion()">
		<?php //} ?>
                 <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
            </form>
            	</p>
            </td>
      
      
      
            
            <td valign="top"   class=""><span class="etiquetaInfo redonda3">Ampliado</span>
            <td valign="top"   class="txtInfo">
            <form name="fampliado">
            
				<?php
				$sqlamp = $conexion->select("Select * From pfrr Where ampliados != '' And num_accion Like '%".$accion."%' ",false);
				$oct = mysql_num_rows($sqlamp);
				$des = mysql_fetch_array($sqlamp);
				$deschek = explode ("|",$des['ampliados']);
				if($oct == 1){$des1 = $des2 = $des3 = "disabled";} else {$des1 = $des2 = $des3 = "";}
				
				if ($deschek[0] == "Reintegro" || $deschek[1] == "Reintegro" || $deschek[2] == "Reintegro") $reint = 'checked="checked"';
				if ($deschek[0] == "Subejercicio" || $deschek[1] == "Subejercicio" || $deschek[2]== "Subejercicio") $subej = 'checked="checked"';
				if ($deschek[0] == "Mixto" || $deschek[1] == "Mixto" || $deschek[2]== "Mixto") $mixt = 'checked="checked"';
				?>
                                <input type="checkbox" name="reintegro" id="reintegro" <?php echo $reint;?> <?php echo $des1;?> >
                                <label for="reintegro">Reintegro</label>
               
                        		<input type="checkbox" name="subejercicio" id="subejercicio" <?php echo $subej;?> <?php echo $des2;?> >
                 				<label for="subejercicio">Subejercicio</label>
               
                               	 <input type="checkbox" name="mixto" id="mixto" <?php echo $mixt;?> <?php echo $des3;?> >
                				 <label for="mixto">Mixto</label>
               <?php if ($oct == 0) { ?>
	<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
      		<input class="submit_line" type="button" name="RegistraAmp"  id="RegistraAmp" value="Guardar" onclick="ampliado()">
	<?php } ?>
            <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
			   <?php }?>
            </form>

               
               
                </td>

            
	
         <tr>
            <td><div class="etiquetaInfo redonda3"> Monto PFRR</div></td>
            <td><p class="txtInfo"><h2>
			<?php 
				//echo number_format(dameTotalPFRR($accion),2) 
				//echo number_format(dameTotalPFRR($accion),2) 
				//require_once('../procesosAjax/pfrr_reintegros_calcula.php'); 
				//echo  number_format(dameTotalPO($accion),2);
				//echo "$ "; echo  number_format($r['monto_no_solventado'],2);
			?>
			</h2>

			<h2><?php if ($r['monto_no_solventado'] != "") { echo "&nbsp;&nbsp;$";
					echo number_format($r['monto_no_solventado'],2);
		} else { ?></h2>
                        <form name="nosolve">
            	 <input class="redonda5" id="m_nosol" name="m_nosol" type="number" value='<?php echo number_format($r['monto_no_solventado'],2) ?>' >
				 <input type="hidden" id="edtramdtns" name="edtramdtns" value='<?php echo $r['detalle_edo_tramite']; ?>' >
				 <input type="hidden" id="usdtns" name="usdtns" value='<?php echo $_REQUEST['usuario']; ?>' >
                                   <?php // if($r['detalle_edo_tramite'] < 17 or $r['detalle_edo_tramite'] == 30 and $r['inicio_frr'] == "" )  { ?>
		<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="RegistrarM"  id="RegistrarM" value="Guardar" onclick="guardaMonto0()">
		<?php } ?>
                                    <?php //} ?>

                 <input type="hidden" name="num_accion0" id="num_accion0" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>

			</p></td>
            
      		<td><div class="etiquetaInfo redonda3"> Monto Inicio del PFRR  <p style="font-size:8px">IMPORTE DEL DAÑO </p></div></td> 
			<td><p class="txtInfo">
		<h2><?php if ($r['inicio_frr'] != "") { echo "&nbsp;&nbsp;$";
					echo number_format($r['inicio_frr'],2);
		} else { ?></h2>
                        <form name="fmonto">
            	 <input class="redonda5" id="monto_pfrr" name="monto_pfrr" type="number" value='<?php echo number_format($r['inicio_frr'],2) ?>' >
				 <input type="hidden" id="edtramfrr" name="edtramfrr" value='<?php echo $r['detalle_edo_tramite']; ?>' >
				 <input type="hidden" id="usfrr" name="usfrr" value='<?php echo $_REQUEST['usuario']; ?>' >
                                   <?php // if($r['detalle_edo_tramite'] < 17 or $r['detalle_edo_tramite'] == 30 and $r['inicio_frr'] == "" )  { ?>
		<?php if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="RegistrarM"  id="RegistrarM" value="Guardar" onclick="guardaMonto()">
		<?php } ?>
                                    <?php //} ?>

                 <input type="hidden" name="num_accion2" id="num_accion2" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>
            
			<?php
			/*echo montoConFuncion($accion)*/ 
			/* echo @number_format(sumaPresuntosPFRR($accion),2) */
			//echo  @number_format(dameMontoInicialPFRR($accion),2);
			 ?></p></td>
			 
			 
			 

    <input type="hidden" name="hiddenField" id="hiddenField">

	
            </tr>
			
			<td><div class="etiquetaInfo redonda3"> Monto del PDR<p style="font-size:8px">Total</p> </div></td> 
			<td><p class="txtInfo">
		<h2><?php if ( $r['detalle_edo_tramite'] > 22 and $r['detalle_edo_tramite'] < 25 and $r['monto_pdr'] != 0) { echo "&nbsp;&nbsp;$";
					echo      number_format($r['monto_pdr'],2);
		} else { ?></h2>
                        <form name="fmonto1">
            	 <input class="redonda5" id="monto_pdr" name="monto_pdr" type="number" value='<?php echo $r['monto_pdr'] ?>' >
				 <input type="hidden" id="edtrampdr" name="edtrampdr" value='<?php echo $r['detalle_edo_tramite'] ?>' >
				 <input type="hidden" id="usfrr" name="usfrr" value='<?php echo $_REQUEST['usuario']; ?>' >
                                   <?php //if($r['detalle_edo_tramite'] < 25 and $r['detalle_edo_tramite'] > 22 and $r['monto_pdr'] == "")  {?>
	<?php //if($r['direccion'] == $abogresp || $abogresp == "DG"){ ?>
                 <input class="submit_line" type="button" name="Registrapdr"  id="Registrapdr" value="Guardar" onclick="guardaMonto1()">
	<?php //} ?>
                                    <?php //} ?>

                 <input type="hidden" name="num_accion3" id="num_accion3" value="<?php echo $accion; ?>">
            </form>
		<?php } ?>
</p></td>
<td><p class="etiquetaInfo redonda3">Fecha Prescripción</p></td>
<td><p class="txtInfo"><h2><?php echo fechaNormal($r['prescripcion']) ?></h2></p></td>
			 	 
        </table>
<table width="100%" align="center" >
          <tr>
            <td class="redonda5"><p class="etiquetaInfo2 redonda3">Irregularidad General</p></td>
          </tr>
          <tr>
            <td><p style="text-align:justify; padding:5px"><?php 
			echo aHtml($r['pdrcs'])
			
			 ?></p>
			 <!---- p style="text-align:justify; padding:5px">
		<?php if ($r['pdrcs'] != "") { 
					echo aHtml($r['pdrcs']);
		} else { ?>
		
			<form name="formpres">
            	 <textarea rows="4" cols="100" id="txiregg" name="txiregg"> EN REPARACIÓN</textarea>
				 <input class="redonda5" id="irreg_et" name="irreg_et" type="hidden" value='<?php echo $r['detalle_edo_tramite']; ?>' >
				 <input class="redonda5" id="irreg_usu" name="irreg_usu" type="hidden" value='<?php echo $r['usuario']; ?>' >
                 <input class="submit_line" type="button" name="Registraireg"  id="Registraireg" value="Guardar" onclick="guardairreg()">
                 
                 <input type="hidden" name="irreg_accion" id="irreg_accion" value="<?php echo $accion; ?>">
            </form>
		
		<?php } ?>
			
			</p ---->
			 
			 </td>
          </tr>
</table>
<?php
//echo montoConFuncion($accion);
?>


<!-- ------------------------------------------------------------------------------------------------------------------------------ -->     
        
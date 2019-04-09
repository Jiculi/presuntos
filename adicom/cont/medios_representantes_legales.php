<script>
function muestraError(paso,texto)
{
	ocultaAll();
	document.getElementById(paso).innerHTML = "<p style='margin:50px 0'><center><h3 class='poTitulosPasos'>"+texto+"</h3>  <img src='images/warning_yellow.png' />  </center></p>";
	$$('#'+paso).fadeIn();
}
function ocultaAll() 
{
	$$('.todosContPasos ').removeClass("pActivo");
	$$('.todosContPasos ').hide();
	$$('.todosPasos').removeClass("pasosActivo");
	$$('.todosNP').removeClass('noPasoActivo');
	$$('.todosNP').addClass('noPaso'); 
} 
function muestraPestana(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
}
$$("#newRepresentante").click(function(){

	var datosUrl = $$("#representanteNEW").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
	
	if(comprobarForm("representanteNEW"))
	{
		var confirma = confirm("¿Realmente desea Agregar el Representante Legal?");
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
				url: "procesosAjax/medios_representantes_legales.php",
				data: datosUrl,
				error: function(objeto, quepaso, otroobj)
				{
					//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert(datos);
					cerrarCuadro();
				}
			});
		}
	}
});

function ELIMINAREPRESENTANTE(id)
{
	var confirma = confirm("¿Realmente desea Eliminar el Representante Legal?");
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
			url: "procesosAjax/medios_representantes_legales.php",
			data: {idRepresentante:id,funcion:'eliminar'},
			error: function(objeto, quepaso, otroobj)
			{
				//alert("Estas viendo esto por que fallé"); //alert("Pasó lo siguiente: "+quepaso);
			},
			success: function(datos)
			{ 
				//alert(datos);
				cerrarCuadro();
			}
		});
	}}

</script>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$accion = valorSeguro($_REQUEST['numAccion']);
$idPresunto = valorSeguro($_REQUEST['idPresuntop']);
//print_r($_REQUEST);
//------------------------------------------------------------------------------
/*
$sql = $conexion->select("SELECT * FROM medios_representantes_legales WHERE num_accion = '".$accion."' AND idPresunto = ".$idPresunto,false);
$r = mysql_fetch_array($sql);
$total = mysql_num_rows($sql);
*/
//-------------------------------------------------------------------------------


$onclickP1 = "onclick='muestraPestana(1)'";
$onclickP2 = "onclick='muestraPestana(2)'";	

$txtPaso1 = "pasosActivo";
//$txtPaso2 = "pasosActivo";

$numPaso1 = "noPasoActivo";
//$numPaso2 = "noPasoActivo";

$acceso1 = "pfAccesible";
$acceso2 = "pfAccesible";

echo "<script>	$$(function() {	$$('#p1').fadeIn();	});	</script>";
?>
<div id='resGuardar' style="line-height:normal"></div>
<input type="hidden" name="num_accion" value="<?php echo $accion ?>" id="num_accion" />
<input type="hidden" name="fecha_cambio" id="fecha_cambio" value="<?php echo date ("Y-m-d ");?>" />
<input type="hidden" name="hora_cambio" id="hora_cambio" value="<?php echo date ("H:i:s ") ?>" />
<input type="hidden" name="usuarioActual" id="usuarioActual" value="<?php echo $_REQUEST['usuario'] ?>" />
<input type="hidden" name="dirPre" id="dirPre" value="<?php echo $_REQUEST['direccion'] ?>" />

<?php
/*
if($r['detalle_de_estado_de_tramite'] < 6 ) $title = "Modificar Presunto" and $title2="Borrar presunto";
else $title = "Ver Presunto";
*/
?>
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<input type="hidden" name="medios_numAccion" id="medios_numAccion" value="<?php echo $_REQUEST['numAccion'] ?>"/>
<input type="hidden" name="medios_usuario" id="medios_usuario" value="<?php echo $_REQUEST['usuario'] ?>"/>
<input type="hidden" name="medios_direccion" id="medios_direccion" value="<?php echo $_REQUEST['direccion'] ?>"/>
<input type="hidden" name="medios_idPresunto" id="medios_idPresunto" value="<?php echo $_REQUEST['idPresuntop'] ?>"/>
<input type="hidden" name="medios_presunto" id="medios_presunto" value="<?php echo $_REQUEST['presunto'] ?>"/>
<!-- --------------- variables necesarias --------------- -->
<!-- --------------- variables necesarias --------------- -->
<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">
    <div class="encPasos">
       <!--
       <div id='paso0' onclick="muestraPestana(0)" class="todosPasos pasos pfAccesible  pasosActivo"><div id='np0' class="todosNP noPasoActivo redonda10">0</div> Pendiente UAA envíe</div>
       -->
       <div id='paso1' <?php echo $onclickP1 ?> class="todosPasos <?php echo $txtPaso1 ?> <?php echo $acceso1 ?> pasos"><!--<div id='np1' class="todosNP noPaso redonda10 <?php echo $numPaso1 ?>">1</div>--> REPRESENTANTES LEGALES  </div>
       <?php if($r['detalle_de_estado_de_tramite'] < 6 ) { ?>
       		<div id='paso2' <?php echo $onclickP2 ?> class="todosPasos <?php echo $txtPaso2 ?> <?php echo $acceso2 ?> pasos"><!--<div id='np2' class="todosNP noPaso redonda10 <?php echo $numPaso2 ?>">2</div>--> AGREGAR REPRESENTANTE LEGAL</div>
       <?php } ?>
    </div>
    <div id='resPasos' class='divPresuntos redonda10'>

        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <!-- ----------------------------- DIV RECEPCION --------------------------------- -->
        <div id="p1" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Representantes Legales  </h3>
            
            <?php
			$tabla =  '    
				<table  border="0" align="center" cellpadding="0" cellspacing="0" id="product-table" >
					<tr>
						<!-- <th class="contratista"> 	<a href="#">Tipo</a>	</th> -->
						<th class="contratista"> 	<a href="#">Nombre</a>	</th>
						<th class="cargo"> 			<a href="#">Direccion</a></th>
						<th class="cargo">			<a href="#">Acción</a></th>
						<th class="seguimiento">	<a href="#"> Editar </a></th>
					</tr>
			';       
			$sql = $conexion->select("SELECT * FROM medios_representantes_legales WHERE num_accion = '".$accion."' AND idPresunto = ".$idPresunto,false);
			$total = mysql_num_rows($sql);
            while($r = mysql_fetch_array($sql))
            {
                $i++;
                $res = $i%2;
                if($res == 0) $estilo = "class='non'";
                else $estilo = "class='par'";
                
                //------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------				
                $tabla .= '
                        <tr '.$estilo.' >
							<!-- <td class="contratista">'.$TP.'</td> -->
                            <td class="contratista">'.$r['nombre'].'</td>
                            <td class="cargo">'.$r['direccion'].'</td>
                            <td class="cargo">'.$r['num_accion'].'</td>
                            <td class="ancho100">
							';
				$tabla .= '<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro5 = new mostrarCuadro3(450,600,"Modificar Representante Legal",100,"cont/medios_representantes_legales_mod.php","representante='.$r['id'].'&idPresunto='.$r['idPresunto'].'&numAccion='.$r['num_accion'].'&usuario='.$_REQUEST['usuario'].'&direccion='.$_REQUEST['direccion'].'")\'></a> ';
				$tabla .= '<a href="#" title="Eliminar" class="icon-2 info-tooltip" onclick=\' ELIMINAREPRESENTANTE('.$r['id'].') \'></a>';
                $tabla .= '</td></tr>';
				
				
            }
			if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta Accion no cuenta aun con Representantes Legales</h3></center></td></tr>";
			
			$tabla .= '</table><!--  end product-table................................... --> ';
			
			echo "<div>".$tabla."</div>";
			?>        
		</div>
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->
        <!-- ----------------------------- FIN PENDIENTE RECEPCION --------------------------------- -->

        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos pInactivo">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Agregar Representante Legal</h3>
            
            <center>
            <form action="#" method="POST" name="representanteNEW" id="representanteNEW">
            <center>
              <table width="90%" align="center" class="tablaPasos">
                <tr valign="baseline">
                  <td class="etiquetaPo">Nombre: </td>
                  <td ><input  type="text"  class="redonda5" id="nombreNEW"  name="nombreNEW" value="" size="70"></td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Dirección:</td>
                  <td>
                  <!-- <textarea class="redonda5" id="new_irregularidad" name="new_irregularidad" cols="72" rows="5" onKeyDown="contador(this.form.new_irregularidad, 'new_cuenta', 450)" onKeyUp="contador(this.form.new_irregularidad, 'new_cuenta', 450)"><?php echo $r['irregularidad']; ?></textarea> -->
                  <textarea class="redonda5" id="direccionNEW" name="direccionNEW" cols="72" rows="5" ><?php echo $r['irregularidad']; ?></textarea> 
                  <br />
                  <!-- Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td> -->
                </tr>
                <tr >
                  <td class="center" colspan="3">
                  <center><br /><br />
                  <input type="hidden" name="funcion" id="funcion" value="nuevo"  />
                  <input type="button" class="submit-login"  value="Agregar Presunto" name="newRepresentante" id="newRepresentante">
                  </center>
                  </td>
                  
                </tr>
              </table>
            </center>
            </form>
            </center>
        
        </div>
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- FIN DIV ASISTENCIA JURIDICA --------------------------------- -->
        

    </div>
</div>
<!--  end content-table  -->

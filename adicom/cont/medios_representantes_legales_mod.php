<style>
	body, #nombre{ color:#000 !important; font-size:12px !important; margin:0px !important; height:15px !important}
</style>
<script>
$$("#Representante").click(function(){

	var datosUrl = $$("#representanteMOD").serialize()+"&numAccion="+$$("#medios_numAccion").val()+"&usuario="+$$("#medios_usuario").val()+"&direccion="+$$("#medios_direccion").val()+"&idPresunto="+$$("#medios_idPresunto").val()+"&presunto="+$$("#medios_presunto").val();
	//alert(datosUrl);
	
	if(comprobarForm("representanteMOD"))
	{
		var confirma = confirm("¿Realmente desea Actualizar al Representante Legal?");
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
</script>
<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

//echo print_r($_REQUEST);
$sql = $conexion->select("SELECT * FROM medios_representantes_legales WHERE id = ".$_REQUEST["representante"]." limit 1",false);
$r = mysql_fetch_array($sql);


?>
<div id='presuntosRes' style="line-height:normal"></div>

<div class="contPasos">

    <div id='resPasos' class='divPresuntos redonda10'>
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <!-- ----------------------------- DIV ASISTENCIA JURIDICA --------------------------------- -->
        <div id="p2" class="todosContPasos ">
            <div style="float:right"><img src="images/help.png" /></div>
            <h3 class="poTitulosPasos">Modificar Representante Legal</h3>
            
            <center>
            <form action="#" method="POST" name="representanteMOD" id="representanteMOD">
            <center>
              <table width="90%" align="center" class="tablaPasos">
                <tr valign="baseline">
                  <td class="etiquetaPo">Nombre: </td>
                  <td ><input  type="text"  class="redonda5" id="nombreMOD"  name="nombreMOD" value="<?php echo $r['nombre']; ?>" size=""></td>
                </tr>
                <tr >
                  <td class="etiquetaPo">Dirección:</td>
                  <td>
                  <!-- <textarea class="redonda5" id="new_irregularidad" name="new_irregularidad" cols="72" rows="5" onKeyDown="contador(this.form.new_irregularidad, 'new_cuenta', 450)" onKeyUp="contador(this.form.new_irregularidad, 'new_cuenta', 450)"><?php echo $r['irregularidad']; ?></textarea> -->
                  <textarea class="redonda5" id="direccionMOD" name="direccionMOD" cols="72" rows="5" ><?php echo $r['direccion']; ?></textarea> 
                  <br />
                  <!-- Le restan <span style="font-weight:bold" id='new_cuenta'>450</span> caracteres.</td> -->
                </tr>
                <tr >
                  <td class="center" colspan="3">
                  <center><br /><br />
                  <input type="hidden" name="funcion" id="funcion" value="actualiza"  />
                  <input type="hidden" name="idRepresentante" id="idRepresentante" value="<?php echo $r['id']; ?>"  />
                  <input type="button" class="submit-login"  value="Actualizar Presunto" name="Representante" id="Representante">
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

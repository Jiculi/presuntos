<?php
require_once("../includes/clases.php");
require_once("../includes/configuracion.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------
$accion = 		valorSeguro($_REQUEST['numAccion']);
$idPresunto = 	valorSeguro($_REQUEST['idPresuntop']);
$usuario = 		valorSeguro($_REQUEST['usuario']);
$direccion = 	valorSeguro($_REQUEST['direccion']);
$fecha = 		valorSeguro($_REQUEST['fecha']);
$tipoRes = 		valorSeguro($_REQUEST['tipoRes']);
$entidad = 		valorSeguro($_REQUEST['entidad']);

if($tipoRes == "responsabilidad") $resp = "Existencia de Responsabilidad";
if($tipoRes == "inexistencia") $resp = "Inexistencia de Responsabilidad";
if($tipoRes == "abstencion") $resp = "Abstención de Sanción";
if($tipoRes == "sobreseimiento") $resp = "Resolución de Sobreseimiento";

//------------------------------------------------------------------------------
// datos del presunto
$sql = $conexion->select("SELECT * FROM pfrr_presuntos_audiencias  WHERE cont = ".$idPresunto." ",true);
$pre = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
/*------------------------------- pagina volantes --------------------------------*/
#pfrrDiv .nomSis{ color:#390 !important}
#pfrrDiv h3{color:#390 !important}
#pfrrDiv .pasosActivo{ 
	display:inline-block; 
	padding:5px 12px;
	height:25px;  
	cursor:pointer;
	line-height:25px; 
	background:#390 !important;
	font-weight:bold;  
	color:#EEE;}
#pfrrDiv textarea:focus,textarea:hover,input[type="text"]:hover, input[type="text"]:focus,select:hover,select:focus 
{border: 1px solid #390 !important;}
/*#pagVolantes .submit-login{ background:#F0F !important}*/
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:12px 0;
	}
#pfrrDiv #product-table th	{
	text-align: center;
	/* background:url(../images/table/table_header_options.jpg); */
	background:#390 !important;
	padding:12px 0;
	}
	
#pfrrDiv #product-table tr:hover { background:#CBFF97 !important; }
.tablaInfo .etiquetaInfo {border: 1px solid #390 !important; color:#390}
/* .contVolantes{border: 2px solid #F0F !important;} */
/* .pasos{ background:#F39 !important} */

#pfrrDiv #related-act-top	{
	/*background:url(../images/forms/header_related_act.gif);*/
	background:#390 !important;
	width:260px;
	height:43px;
	margin:12px auto 0 auto;
	-moz-border-radius: 8px 8px 0px 0px ;
    -webkit-border-radius: 8px 8px 0px 0px ;
    border-radius: 8px 8px 0px 0px ;
	
	}
#pfrrDiv .pfAccesible{background:#390 !important;}
/*------------------------------- pagina oficios --------------------------------*/
#pfrrDiv .camposAcciones{border:1px dotted #666666; padding:20px 50px; margin:12px; height:300px; overflow:auto}
#pfrrDiv .camposLi{list-style:url(../images/OK20.png); margin:5px; position:relative }
#pfrrDiv .camposInputAcciones{}
#pfrrDiv .eliminarInput{ display:inline-block; cursor:pointer; position:relative; background:url(../images/cross.png); height:16px; width:16px; left:-25px; z-index:120}
</style>
<script>
// fechas -----------------------------------------
$$( document ).ready(function(){
	
	$$( "#fecha_notificacion" ).datepicker({
	  // dateFormat: formatoFecha,
      changeMonth: false,
      numberOfMonths: 1,
	  showAnim:'slideDown',
	  //minDate: "01/08/2018",
	  //maxDate: "31/08/2018",	  //maxDate: MyDias+"/"+myMes+"/"+myAno,
	  beforeShowDay: noLaborales
      //onClose: function( selectedDate ) {
        //$$( "#fecha_accion_omision1" ).datepicker( "option", "maxDate", selectedDate );
      //}
    });
	
//
});
//
//------------------------------------------------------------------------
function fechaNotPresunto(accion,usuario,direccion)
{
	if(comprobarForm('formNot'))
	{
		var confirma = confirm('Presunto <?php echo $pre['nombre']; ?> \n\n Fecha de Notificación '+$$("#fecha_notificacion").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " Resolución Notificada. <?php echo $resp; ?>" \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_notificacion.php",
				//beforeSend: function(){  },
				data: 
				{
					idPresunto:	'<?php echo $idPresunto ?>',
					accion:		'<?php echo $accion ?>',
					usuario: 	'<?php echo $usuario ?>',
					fecha :		$$("#fecha_notificacion").val(),
					direccion:	'<?php echo $direccion ?>',
					tipoNot:	'<?php echo $tipoRes ?>'
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					//compruebaNot();
					//new mostrarCuadro2(530,1120,$$("#nomPresunto1").val(),20,"cont/pfrr_presuntos_proceso.php","idPresuntop="+$$("#idFpresunto1").val()+"&numAccion="+$$("#accPresunto1").val()+"&usuario="+$$("#usuarioAud11").val()+"&direccion=")
					mostrarCuadro(500,1200,"<?php echo $accion ?>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $entidad ?> &nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $resp ?>",50,"cont/pfrr_proceso.php","numAccion=<?php echo $accion ?>&usuario=<?php echo $usuario ?>&direccion=<?php echo $direccion ?>");
					cerrarCuadro3();
				}
			});
			//cerrarCuadro();
		}
	}
}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<div id='pfrrDiv'>

	<!--  FECHA DE AUDIENCIA ------------------------------------------------------------------- -->
        <form method="POST" name="formNot" id="formNot">
          <table width="120%" align="center" class="tablaPasos " >
       	 <input type="hidden" name="num_accion" value="<?php echo $accion ?>" id="num_accion" />
             <tr><td class="etiquetaPo">Nombre: </td><td class="etiquetaPO" > <?php echo $pre['nombre']; ?></td> </tr>
             <tr><td class="etiquetaPo">Cargo:</td><td class "etiquetaPo"><?php echo $pre['cargo']; ?></td></tr>
             <tr><td class='etiquetaPo'>RFC:</td><td><?php echo $pre['rfc']; ?></td> </tr>
            <tr > <td class="etiquetaPo">Dependencia:</td> <td class "etiquetaPo"><?php echo $r['dependencia']; ?></td> </tr>
            <tr >
        

            <tr >
              <td class="etiquetaPo">Fecha de Notificación:</td>
              <td><label for="fecha_citacion"></label>
              <input name="fecha_notificacion"  type="text"  class="redonda5"  id="fecha_notificacion" value="<?php echo $fechaAudiencia ?>" readonly="readonly" <?php echo $disabled  ?>></td>
            </tr>
            <tR>
              <td class="center" colspan="3">
              <center><br /><br />
                <input type="button"  class="submit-login"  value="Guardar Notificación" onclick="fechaNotPresunto('<?php echo $accion ?>','<?php echo $usuario ?>','<?php echo $direccion ?>')">
              </center>
              </td>
            </tr>
          </table>
        </form>
        </center>
        </div>



</div> <!-- #pfrrDiv  -->
</body>
</html>
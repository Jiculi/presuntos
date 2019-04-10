<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();

$id = valorSeguro($_REQUEST['id']);
$accion = valorSeguro($_REQUEST['numAccion']);
$noPFRR = valorSeguro($_REQUEST['noPFRR']);
$fecha = valorSeguro($_REQUEST['fecha']);
$usuario = valorSeguro($_REQUEST['usuario']);

$us = dameUsuario($usuario);

echo "<br><center><h3>Solicitud de CRAL de ".$us['nombre']."</h3></center>";
echo "<br><center><h3>El PFRR $noPFRR de la accion $accion esta pendiente. </h3></center><br>";
?>
<script>
function validaCargaCral()
{
	if( validaCralAsis( $$('#nomDoc').val() ) && $$('#existe').val() != 1 )
	{
		$$("#formOficio").submit();
		$$(".formInput").val("");
	}
	else
	{
		if($$('#existe').val() == 1) var men = "\n - El CRAL "+$$('#nomDoc').val()+" ya existe.";
		else var men = "";
		
		if( validaCralAsis( $$('#nomDoc').val() )) var men2 = "";
		else  var men2 = "\n - El CRAL esta mal escrito.";
		
		alert(men2+men);	
	}
}

function compruebaCral()
{
	$$.ajax
	({
		beforeSend: function(objeto)
		{
		 $$('#loadCral').html('<img src="images/load_chico.gif">');
		 //alert('hola');
		},
		complete: function(objeto, exito)
		{
			//alert("Me acabo de completar")
			//if(exito=="success"){ alert("Y con éxito");	}
		},
		type: "POST",
		url: "procesosAjax/po_busqueda_cral.php",
		data: {cral:$$('#nomDoc').val()},
		success: function(datos)
		{ 
			//$$('#r2').html(datos);
			if(datos == 0)
			{
				$$('#loadCral').html("<b>EL CRAL "+$$('#nomDoc').val()+" NO EXISTE</b>");
				$$('#existe').val(0)
			}
			else  
			{
				$$('#loadCral').html("<b style='color:red'>EL CRAL "+$$('#nomDoc').val()+" YA EXISTE !!!</b>");
				$$('#existe').val(1)
			}
		}
	});
}

</script>
<center>
<form action="cont/po_subeDocs.php" name="formOficio" id="formOficio" target="frameCarga"  method="post" enctype="multipart/form-data"  >
<table class="files" width="100%">
    <tr>
        <td width="100" class="etiquetaPo">CRAL: </td>
        <td width="250">
        	<input type="text" name="nomDoc" id="nomDoc" value="" class="redonda5 formInput" size="30" onkeyup="compruebaCral()" onchange="compruebaCral()" onkeydown="compruebaCral()" onkeypress="compruebaCral()" style="margin:3px"> <span id='loadCral'></span>
			<input type="hidden" name="existe" id="existe" value="" class="redonda5 formInput" size="30">        
        </td>
    </tr>
     <tr>
        <td width="100" class="etiquetaPo">Superveniente: </td>
        <td width="250"><input type="text" name="superveniente" id="superveniente" class="redonda5 formInput" size="30" style="margin:3px"></td>
    </tr>
     <tr>
        <td width="100" class="etiquetaPo">Archivo CRAL: </td>
        <td width="250"><input type="file" name="adjunto" id="adjunto" class="redonda5 formInput" style="margin:3px"></td>
    </tr>
    <tr>
        <td width="100" class="etiquetaPo">PFRR: </td>
        <td width="250"><?php echo $noPFRR  ?>
            <input type="hidden" name="oficio" value="<?php echo $noPFRR ?>" class="formInput">
            <input type="hidden" name="accion" value="<?php echo $accion ?>" class="formInput">
            <input type="hidden" name="tipoDoc" value="pfrr" class="formInput">
        </td>
    </tr>
    
    <tr>
        <td colspan="2"> <center> <input class="submit_line" type="button" name="Subir" value=" Subir CRAL " onclick="validaCargaCral()" /> </center>  </td>
    </tr>
</table>
</form>
<bR /><bR />
<?php echo "<iframe name='frameCarga' height='50' frameborder='0' width='100%'></iframe>"; ?>
</center>

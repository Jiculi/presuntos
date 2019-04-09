// JavaScript Document
//------------------------------ GUARDA RECEPCION -------------------------------
function cambiaConfiguracion(frm,advertencia)
{
	var datos = $("#"+frm).serialize();
	//alert(datos)
	if(comprobarForm(frm))
	{
		var confirma = confirm(advertencia+" \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#resGuardar').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/configuracion.php",
				data: datos,//{},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					$('#resGuardar').html(datos); 
					$("#message-green").fadeIn();
					//mostrarCuadro(500,1100,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion);
				}
			});
		}
	}
	
}
//---------------------------------------------------------------------------------------

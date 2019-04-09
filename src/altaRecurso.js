import { comprobarForma } from "./compruebaForma";
import style from './css/altaJuicio.css';



$(document).ready(function() {
	// $('#popup-overlay').fadeIn();
	// $('#popup-overlay').height($(window).height());
	const accion = document.getElementById('accion').value;
	const procedimiento = document.getElementById('procedimiento').value;
	const actor = document.getElementById('actor').value;
	const cont = document.getElementById('idPresunto').value;
	const alerta = document.getElementById('mensaje');
	var valor = $("#llave").val();
	//Swal.fire('Funciona  esta madre');

	const recurso = document.getElementById('recurso');
    recurso.focus();


    $("#inserta_juicio").click(function(){
        var datosUrl =  "accion=" + accion  + "&" + "procedimiento=" + procedimiento  + "&" +
        "actor=" + actor + "&" + "cont=" + cont + "&" +  $("#forma").serialize();
        console.log(datosUrl);
		if(comprobarForma("forma"))
		{
				$.ajax
				({
					beforeSend: function(objeto) {
					},
					complete: function(objeto, exito) {
					},
					type: "POST",
					url: "php/altaRecursoInserta.php",
					data: datosUrl,
					error: function(objeto, quepaso, otroobj) {
					},
					success: function(datos) {
						alerta.innerHTML = datos;
						$('#mensaje').text(datos);
						$('#ventanita').addClass("alert success");
						//document.forms["forma"].reset();
						$("#forma :input").prop('readonly', true);
						document.getElementById("inserta_juicio").disabled = true;
						document.getElementById('inserta_juicio').style.visibility = 'hidden';
						$("#fechanot").datepicker('disable');
						$("#vencimiento").datepicker().datepicker('disable');
						document.getElementById("dir").disabled = true;
						document.getElementById("sub").disabled = true;

					
					//alert(datos);
					//cerrarCuadro();
					}
				});
		}
	});


    
});


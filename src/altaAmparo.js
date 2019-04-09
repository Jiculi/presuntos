import { noLaborales } from "./modulos.js";
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

	const recurso = document.getElementById('amparoIndirecto');
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
					url: "php/altaAmparoInserta.php",
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


	$( "#fechanot" ).datepicker({
	  	dateFormat: "dd/mm/yy",
      	changeMonth: false,
      	numberOfMonths: 1,
	  	showAnim:'slideDown',
	  	beforeShowDay: noLaborales,
      	onClose: function(fecha, obj) {
		console.log(fecha)
		let buena = `${fecha.substr(3,2)}/${fecha.substr(0,2)}/${fecha.substr(6,4)}`;
		console.log(buena);
		let fecha1 = new  Date(buena);
		console.log(fecha1);
		let dias = 60;
		let diasMs = 1000*60*60*24*dias;
		let fecha2 = fecha1.getTime() + diasMs;
		let d = new Date(fecha2);
		console.log(d);

		let day = d.getDate()
		console.log("dia "+day);
        let month = d.getMonth() + 1
        let year = d.getFullYear()

        if(month < 10){
           d = `${day}/0${month}/${year}`
        }else{
           d=`${day}/${month}/${year}`
        }
		$("#vencimiento").val(d);   
	  }
    });
    
});


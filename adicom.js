

function mostrarAltaVolante(pagina, titulo) {
    let alto = 660;
    let ancho =1000;
    let top = 10;

    var pin = document.querySelector('#pin');
    var div = document.createElement('div');
    div.setAttribute("id", "fondoOscuroX");
    div.innerHTML = 'aqi va el el fondo';
    pin.parentNode.insertBefore( div, pin.nextSibling );

    var fondo = document.querySelector('#fondoOscuroX');
    var div1 = document.createElement('div');
    div1.setAttribute("id", "cuadroDialogoX");
    div1.innerHTML = 'aqi va el el cuadro';
    fondo.parentNode.insertBefore( div1, fondo.nextSibling );








    //this.alto = new Number(alto);
	//this.ancho = new Number(ancho);
	//this.titulo = new String(titulo);
	//this.top = new Number(top);
	//this.pagina = String(pagina);
	$('#cuadroRes').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	//document.getElementById('cuadroTitulo').innerHTML = titulo;
    $("#cuadroDialogo").css("height", "600px");
    $("#cuadroDialogo").css("width", "1000px");
    $("#cuadroDialogo").css("width", "1000px");
    $("#cuadroDialogo").css("marginLeft", "10%");
    $("#cuadroRes").css("marginLeft", "20%");
		
    $("#cuadroDialogo").css("top", "3%");
			
	$("#fondoOscuro").fadeIn();
	$("#cuadroDialogo").fadeIn();
	
	$("#cuadroRes").load(pagina);
}


$(document).ready(function(){
    let titulo = " este es el titulo";

    document.getElementById('Titulo').innerHTML = titulo;
    
    $('#juicios').on('click',  function (e) {
        e.preventDefault();
        var pagina = 'adicom/pfrr_informacion.php?numAccion=03-00622-2-143-03-005&usuario=fllamas&direccion=DG&nivel=A';
        var titulo = ' hola carambola';

/*        var pagina = 'cont/pfrr_informacion.php?numAccion='+encodeURIComponent(row.data().num_accion)+ '&usuario=fllamas' + '&direccion=DG' + '&nivel=A';
        var titulo = encodeURIComponent(row.data().num_accion) +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +  
                     encodeURIComponent(row.data().entidad) + 
                     '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + 
                     row.data().detalle_edo_tramite; */
        mostrarAltaVolante(pagina, titulo);
        //mostrarVentana(pagina);
    } );

} );
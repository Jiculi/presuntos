//import $ from 'jquery';
//import { mostrarVentana } from "./ventana";
//import style from './css/actores.css';

//<link rel="stylesheet" href="../css/actores.css">



function mostrarAltaVolante(pagina, titulo) {
    let alto = 660;
    let ancho =1000;
    let top = 10;


    //this.alto = new Number(alto);
	//this.ancho = new Number(ancho);
	//this.titulo = new String(titulo);
	//this.top = new Number(top);
	//this.pagina = String(pagina);
	alert("hola");
	$('#cuadroRes').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	//document.getElementById('cuadroTitulo').innerHTML = titulo;
    $("#cuadroDialogo").css("height", "600px");
    $("#cuadroDialogo").css("width", "1000px");
    $("#cuadroDialogo").css("width", "1000px");
    $("#cuadroRes").css("marginLeft", "20%");
		
    $("#cuadroDialogo").css("top", "3%");
			
	$("#fondoOscuro").fadeIn();
	$("#cuadroDialogo").fadeIn();
	
	$("#cuadroRes").load(pagina);
}



$(document).ready(function() {

     


    
    
    $('#juicios').on('click', 'a.informacion', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        var pagina = 'cont/pfrr_informacion.php?numAccion='+encodeURIComponent(row.data().num_accion)+ '&usuario=fllamas' + '&direccion=DG' + '&nivel=A';
        var titulo = encodeURIComponent(row.data().num_accion) +
                    '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +  
                     encodeURIComponent(row.data().entidad) + 
                     '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + 
                     row.data().detalle_edo_tramite;
        // mostrarAltaVolante(pagina, titulo);
        mostrarVentana(pagina);
    } );
    


    

    $('#juicios').on('click', 'a.juicio', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        var valor = row.data().juicionulidad;
        var autor = row.data().nombre;

        if (valor){
            //alert("ya existe:"+valor);
            //Swal.fire('Any fool can use a computer');
            Swal.fire({
                type: 'error',
                title: 'Ya existe Juicio...',
                text: 'El autor: ' + autor + ' ya tiene un juicio de nulidad: ' + valor,
                footer: 'Un presunto responsable solo puede tener asignado un juicio de nulidad para un procedimiento'
              })
        } else {
            //alert("damos de alta:" + valor);
            var pagina = 'src/altaJuicio.php?id='  + 
                            '&accion=' + encodeURIComponent(row.data().num_accion) + 
                            '&entidad=' + encodeURIComponent(row.data().entidad) + 
                            '&procedimiento=' + encodeURIComponent(row.data().num_procedimiento) + 
                            '&actor=' + encodeURIComponent(row.data().nombre) +
                            '&juicionulidad=' + encodeURIComponent(row.data().juicionulidad) +
                            '&cont=' + encodeURIComponent(row.data().cont);
            console.log(pagina);
            mostrarVentana(pagina);
        }
	} );

    $('#juicios').on('click', 'a.amparo', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        var valor = row.data().ai;
        var autor = row.data().nombre;

        if (valor){
            //alert("ya existe:"+valor);
            //Swal.fire('Any fool can use a computer');
            Swal.fire({
                type: 'error',
                title: 'Ya existe Amparo...',
                text: 'El autor: ' + autor + ' ya tiene un Amparo Indirecto: ' + valor,
                footer: 'Un presunto responsable solo puede tener asignado un amparo indirecto para un procedimiento'
              })
        } else {
            //alert("damos de alta:" + valor);
            var pagina = 'src/altaAmparo.php?id='  + 
                            '&accion=' + encodeURIComponent(row.data().num_accion) + 
                            '&entidad=' + encodeURIComponent(row.data().entidad) + 
                            '&procedimiento=' + encodeURIComponent(row.data().num_procedimiento) + 
                            '&actor=' + encodeURIComponent(row.data().nombre) +
                            '&ai=' + encodeURIComponent(row.data().ai) +
                            '&cont=' + encodeURIComponent(row.data().cont);
            console.log(pagina);
            mostrarVentana(pagina);
        }
	} );

    $('#juicios').on('click', 'a.recurso', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        var valor = row.data().recurso_reconsideracion;
        var autor = row.data().nombre;

        if (valor){
            //alert("ya existe:"+valor);
            //Swal.fire('Any fool can use a computer');
            Swal.fire({
                type: 'error',
                title: 'Ya existe recurso...',
                text: 'El autor: ' + autor + ' ya tiene un Recurso de Consideración: ' + valor,
                footer: 'Un presunto responsable solo puede tener asignado un recurso de consideración para un procedimiento'
              })
        } else {
            //alert("damos de alta:" + valor);
            var pagina = 'src/altaRecurso.php?id='  + 
                            '&accion=' + encodeURIComponent(row.data().num_accion) + 
                            '&entidad=' + encodeURIComponent(row.data().entidad) + 
                            '&procedimiento=' + encodeURIComponent(row.data().num_procedimiento) + 
                            '&actor=' + encodeURIComponent(row.data().nombre) +
                            '&recurso_reconsideracion=' + encodeURIComponent(row.data().recurso_reconsideracion) +
                            '&cont=' + encodeURIComponent(row.data().cont);
            console.log(pagina);
            mostrarVentana(pagina);
        }
	} );



} );
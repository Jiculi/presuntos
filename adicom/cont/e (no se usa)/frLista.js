$(document).ready(function() {
    $('#juicios').DataTable( {

        language: {
            processing:     "Procesando...",
            search:         "Busca&nbsp;:",
            lengthMenu:    "Muestra _MENU_ Procedimientos",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ Procedimientos",
            infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered:   "(filtrado de un total de _MAX_ registros)",
            infoPostFix:    "",
            loadingRecords: "Cargando información...",
            zeroRecords:    "No se encontraron resultados",
            emptyTable:     "Ningún dato disponible en esta tabla",
            paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
            },
            aria: {
                sortAscending:  ": activar para ordenar en forma ascendente",
                sortDescending: ": activar para ordena en forma descendente"
            }
        },

        ajax: {
             url: "e/jsonFr.php",
             dataSrc: ''
        },
   
        "columns": [
            {
                className:      'x',
                orderable:      false,
                data:           null,
                defaultContent: '<a href="" title="Ver Información" class="zzz icon-5 info-tooltip"></a>'
            },
            { "data": "num_accion" },
            { "data": "num_procedimiento" },

            { "data": "entidad" },
            { "data": "cp" },
            { "data": "fecha_IR" },
            { "data": "cinco" },

            { "data": "detalle_edo_tramite" },
            { "data": "estado" },
            { "data": "subnivel" }
        ],
        "order": [[ 5, "desc" ]],

        "columnDefs": [
                { "searchable": false, "targets": 0 },
                { "orderable": false, "targets": 0 }
            ],

            dom: '<"#boton"B><"top"fl>t<ipr><"clear">', //<#boton >frtip',  // <"top"B>irt<"bottom"flp><"clear">', //'Bfrtip',
            buttons: [
                'excelHtml5', 'pdfHtml5',  'copy'
            ]    

    } );

    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());

    // Setup - add a text input to each footer cell
    $('#juicios tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="F '+title+'" />' );
    } );
     
    // DataTable
    var table = $('#juicios').DataTable();
     
    // Apply the search
    table.columns().every( function () {
            var that = this;
     
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
    } );


    


function mostrarSeguimiento(pagina) {
    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());
    $("#altaOficio").css("top", "3%");
    $("#altaOficio").css("overflow", "auto");
    $("#altaOficio").height($(window).height());
    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}

function mostrarAltaOficio(pagina) {
    $('#popup-overlay').fadeIn();
    $('#popup-overlay').height($(window).height());
    $("#altaOficio").fadeIn();
    $("#altaOficio").load(pagina);
}

function mostrarAltaVolante(pagina, titulo) {
    let alto = 560;
    let ancho =1000;
    let top = 10;


    this.alto = new Number(alto);
	this.ancho = new Number(ancho);
	this.titulo = new String(titulo);
	this.top = new Number(top);
	this.pagina = String(pagina);
	
	$('#cuadroRes').html('<center><img src="images/load_bar.gif" style="margin:100px 0"></center>');
	document.getElementById('cuadroTitulo').innerHTML = this.titulo;
	this.cuadro = document.getElementById('cuadroDialogo');	
	this.cuadroRes = document.getElementById('cuadroRes');	
	this.cuadro.style.height = this.alto+"px";
	this.cuadroRes.style.height = (this.alto-50)+"px";
	this.cuadro.style.width = this.ancho+"px";
	this.cuadro.style.marginLeft = this.ancho-(this.ancho*1.5)+"px"; // mientras mas alto mas a la izquierda
	
    //this.cuadro.style.top = this.top+"px";
    $("#cuadroDialogo").css("top", "3%");
			
	$("#fondoOscuro").fadeIn();
	$("#cuadroDialogo").fadeIn();
	
	$("#cuadroRes").load(this.pagina);
}


    
//    $("#formajuicios").html('<b>Custom tool bar! Text/images etc.</b>');
 //   $("#Fallo").on("click", {msg: "You just clicked me!"}, handlerName);

    $('#juicios').on('click', 'a.xxx', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);
        let pagina = 'e/juiciosActualiza.php?juicioid='+row.data().id;
        console.log(pagina);
        mostrarSeguimiento(pagina);
    //  mostrarSeguimiento(800, 1000, row.data().id, top,'e/juiciosActualiza.php','juicioid='+row.data().id);
	} );
    
    $('#juicios').on('click', 'a.oficio', function (e) {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        console.log(row.data().id);
        var pagina = 'e/juiciosOficio.php?id='+encodeURIComponent(row.data().id)+'&accion='+encodeURIComponent(row.data().accion)+'&juicionulidad='+encodeURIComponent(row.data().juicionulidad);
        console.log(pagina);
        mostrarAltaOficio(pagina);
    } );
    
    $('#juicios').on('click', 'a.zzz', function (e) {

/*
        <a href="#" title="Actualizar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1200," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.dameEstado($r['detalle_edo_tramite']).'",50,
									"cont/pfrr_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>';

*/
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        e.preventDefault();

        var pagina = 'cont/pfrr_informacion.php?numAccion='+encodeURIComponent(row.data().num_accion)+ '&usuario=fllamas' + '&direccion=DG' + '&nivel=A';
        var titulo = encodeURIComponent(row.data().num_accion) +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +  encodeURIComponent(row.data().entidad) + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + row.data().detalle_edo_tramite;
        mostrarAltaVolante(pagina, titulo);
	} );

} );
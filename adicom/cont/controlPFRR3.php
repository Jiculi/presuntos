<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control</title>
    <link rel="stylesheet" href="css/controlPFRR.css">

    <script>
        function cerrarCuadrito() {
          $("#tablero").fadeOut();
          $('#mantel').fadeOut('slow');
        }

        function mostrarLista(pagina) {
          $("#mesa").css("width", "80%");
          $("#mesa").css("top", "3%");
          $("#mesa").css("height", "auto");
    
          $("#mesa").fadeIn();
          $("#mesa").load(pagina);
        }
    </script>  
</head>

<body>
    <div id="fondo"></div>
    <div id='mesa' style="display: none;"></div>

    <div id="tablero">
        <div class="jaula">
            <div class="navbar">

            <div class="navbar-right">

<a href="javascript:mostrarLista('f/resolucionesListaA.php')">A Resoluciones</a>
<a href="javascript:mostrarLista('cont/PFRRanalisisLista.php')">Asistencia</a>
<a href="javascript:mostrarLista('f/acuerdoLista.php')">Acuerdo Inicio</a>
<a href="javascript:mostrarLista('f/resolucionesLista.php')">Resoluciones Notificadas</a>
<a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a>
</div> 






                    <!--            <a href="#" class="logo">Indicadores PFRR</a>
                                <p id="fecha">hola</p>

        <li><a href="javascript:mostrarLista('f/resolucionesLista.php')">x Presunto responsable</a></li>
        <li><a href="javascript:mostrarLista('f/resolucionesListaA.php')">x Procedimiento</a></li>

    <li><a href="javascript:mostrarLista('cont/PFRRanalisisLista.php')">Asistencia</a></li>
    <li><a href="javascript:mostrarLista('f/acuerdoLista.php')">Acuerdo Inicio</a></li>

    <li><a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a></li>


                    <div class="dropdown">
                    <button class="dropbtn">Dropdown 
                    <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                    </div>
                </div> 

                <div class="navbar-right">

                    <a href="javascript:mostrarLista('f/resolucionesListaA.php')">A Resoluciones</a>
                    <a href="javascript:mostrarLista('cont/PFRRanalisisLista.php')">Asistencia</a>
                    <a href="javascript:mostrarLista('f/acuerdoLista.php')">Acuerdo Inicio</a>
                    <a href="javascript:mostrarLista('f/resolucionesLista.php')">Resoluciones Notificadas</a>
                    <a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a>
                </div> -->
            </div>

            <div class="info">
                <div class="tablita" tabindex="0">
                <h2>1</h2>
                </div>
            </div>

            <div class="item3">
                <div class="tablita" tabindex="0">

                <h2>2</h2>
                </div>
            </div>

            <div class="item4"> 
                <div class="tablita" tabindex="0">
                    <h3>Procedimientos de Fincamiento de Responsabilidades Resarcitorias</h3>
                    <div id="procedimiento"></div>
                </div>
                <div>
                    <p> Impugnados 11, 13, 15, 30</p>
                    <p> Resoluciones notificadas 23, 24, 25, 26</p>
                    <p> Con Responsabilidad 24, 45, 46</p>
                    <p> Acuerdo Inicio: 15, 30</p>
                    <p> Aistencia: 10</p>
                <div>

                <div class="tablita" tabindex="0">
                    <h3>Resoluciones Notificadas por Presunto Responsable</h3>
                    <div id="resoluciones"></div>
                    <h3>Presuntos Responsables</h3>
                    <div id="responsables"></div>
                    <p> Abstención 23</p>
                    <p> Con Responsabilidad 24</p>
                    <p> Sin Sanción 25</p>
                    <p> Sobresiomiento 26</p>
                    <p> Resoluciones Notificadas:  Abstención + Con Responsabilidad + Sin Sanción + Sobresiomiento </p>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
    <script type="text/javascript" src="p/controlPFRR.js"></script>


    <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>

    <script src='js/pdfmake.min.js'></script>
    <script src='js/vfs_fonts.js'></script>
</body>
</thead>
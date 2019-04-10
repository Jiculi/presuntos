<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control</title>
    <link rel="stylesheet" href="css/controlPFRR.css">

    <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
    <script type="text/javascript" src="p/controlPFRR.js"></script>
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
                <nav role="navigation">
                  <ul>
                    <li><a href="#">Indicadores PFRR</a></li>

                    <li><a href="#">Acciones</a>
                      <ul class="dropdown">
                      <li><a href="javascript:mostrarLista('f/acciones.php')">Lista</a></li>
                        <li><a href="javascript:mostrarLista('f/tablas.php')">por Cuenta Pública</a></li>
                      </ul>
                    </li>

                    <li><a href="#">Asistencia</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('f/asistencia.php')">por Acción</a></li>
                        <li><a href="javascript:mostrarLista('f/analisisPR.php')">por Presunto responsable</a></li>
                        <li><a href="javascript:mostrarLista('f/devuelto.php')">Devuelto</a></li>
                      </ul>
                    </li>

                    <li><a href="#">Acuerdo Inicio</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('f/acuerdoInicio.php')">por Acción</a></li>
                        <li><a href="javascript:mostrarLista('f/acuerdoLista.php')">por Presunto responsable</a></li>
                        <li><a href="javascript:mostrarLista('f/acuerdosCP.php')">por Cuenta Pública</a></li>
                      </ul>
                    </li>

                    <li><a href="#">Desahogo</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('f/desahogosListaProcedimientos.php')">por Procedimiento</a></li>
                        <li><a href="javascript:mostrarLista('f/desahogosListaPR.php')">por Presunto responsable</a></li>
                        <li><a href="javascript:mostrarLista('f/desahogosCP.php')">por Cuenta Pública</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Con resolución</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('f/resolucionesListaA.php')">por Procedimiento</a></li>
                        <li><a href="javascript:mostrarLista('f/resolucionesLista.php')">por Presunto responsable</a></li>
                        <li><a href="javascript:mostrarLista('f/resolucionesListaCP.php')">por Cuenta Pública</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Medio defensa</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('f/defensaListaProcedimiento.php')">por Procedimiento</a></li>
                        <li><a href="javascript:mostrarLista('f/defensaListaPR.php')">por Presunto responsable</a></li>
                        <li><a href="javascript:mostrarLista('f/defensaCP.php')">por Cuenta Pública</a></li>
                        <li><a href="javascript:mostrarLista('p/juiciosControlProcedimientos.php')">por Procedimiento Medios</a></li>
                      </ul>
                    </li>
                    <li><a href="javascript:mostrarLista('f/oficiosPFRR.php')">Oficios PFRR</a></li>

                    <li><a href="javascript:cerrarCuadrito()">Cerrar</a></li>
                  </ul>
                </nav>
            </div>
            <div class="info">
                <div class="tablita" tabindex="0">
                <h2>Fincamiento de Responsabilidades Resarcitorias</h2>
                </div>
            </div>

            <div class="item3">
                <div class="tablita" tabindex="0">

                <h2> </h2>
                </div>
            </div>

            <div class="item4"> 
                <div class="tablita" tabindex="0">
                    <h3>por Cuenta Pública</h3>
                    <div id="totales"></div>
                </div>
                <p> </p>
            </div>

            <div class= "piePagina">
				        <p>ASF DGR ® Todos los derechos reservados</p>
	          </div>

        </div>
    </div>

    <script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script> 
    <script type="text/javascript" src="js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script>

    <script src='js/pdfmake.min.js'></script>
    <script src='js/vfs_fonts.js'></script>
</body>
</thead>
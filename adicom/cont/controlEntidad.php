<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Busca entidad</title>
    <link rel="stylesheet" href="css/controlEntidad.css">

    <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
    <script type="text/javascript" src="x/controlEntidad.js"></script>
    <script>
        function mostrarLista(pagina) {
            $("#mesa").css("width", "80%");
            $("#mesa").css("top", "3%");
            $("#mesa").css("height", "auto");

            $("#mesa").fadeIn();
            pagina = pagina + '?' + $(searchForm).serialize();
            console.log($(searchForm).serialize());
            console.log(pagina);
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
                    <li><a href="#">Información por Entidad</a></li>
                    <li><a href="#">Analisis</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('x/accionesEntidad.php')">Entidad acciones</a></li>
                        <li><a href="javascript:mostrarLista('x/accionesPresuntoEntidad.php')">Entidad presuntos</a></li>
                        <li><a href="javascript:mostrarLista('x/accionesIR.php')">Irregularidad acciones</a></li>
                        <li><a href="javascript:mostrarLista('x/presuntosIrregularidad.php')">Irregularidad presuntos</a></li>
                      </ul>
                    </li>

                    <li><a href="#">x Entidad</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('x/entidad.php')">Entidad acciones</a></li>
                        <li><a href="javascript:mostrarLista('x/entidadPresuntos.php')">Entidad presuntos</a></li>
                      </ul>
                    </li>

                    <li><a href="javascript:mostrarLista('x/dtns.php')">DTNS</a></li>
                    <li><a href="javascript:mostrarLista('x/desahogo.php')">Desahogo</a></li>
                    
                    <li><a href="#">Impugnados</a>
                      <ul class="dropdown">
                        <li><a href="javascript:mostrarLista('x/juicios.php')">Resolción Notificada</a></li>
                        <li><a href="javascript:mostrarLista('x/juiciosNew.php')">Juicios</a></li>
                        <li><a href="javascript:mostrarLista('x/rr.php')">Recursos de Reconsideración</a></li>
                      </ul>
                    </li>



                    <li><a href="javascript:cerrarCuadrito()">Cerrar</a></li>
                  </ul>
                </nav>
            </div>

            <div class="info">
                <p>hola</p>
                <form id="searchForm">
                    <label for="entidad">Entidad:</label>

				    <input type="text"  size="35" id="entidad" name="entidad"  placeholder="indica una palabra y selecciona de la lista"></td>

<!--
                    <select name="entidad" id="entidad" >
                        <option value="Estado de México">Estado de México</option>;
                        <option value="Veracruz">Veracruz</option>;
                    </select>
                  
                    <input type="button" class="boton" value="Buscar"  onclick="formaTabla()" />
-->  
                    <input type="button" class="boton" id="kernel" name="kernel" value="Buscar" >

                </form>
                <div id="irregularidad"></div>
                <div id="irregularidadPresuntos"></div>
                <div id="cargo"></div>
                <div id="estado"></div>
                <div id="estadoPresuntos"></div>
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
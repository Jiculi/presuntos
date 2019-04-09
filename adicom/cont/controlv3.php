<!DOCTYPE html>
<html lang="es">  
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control</title>
    <link rel="stylesheet" href="css/controlv3.css">

    <script type="text/javascript" src="js/jquery-3.3.1.js"></script> 
    <script type="text/javascript" src="p/controlv3.js"></script>
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
            <a href="#" class="logo">Indicadores</a>
            <p id="fecha">hola</p>
            <div class="navbar-right">
                <a href="javascript:mostrarLista('p/juiciosControl.php')">Procedimientos</a>
                <a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a>
            </div>
          </div>

          <div class="info">
            <div class="table-wrapper" tabindex="0">
              <h2>Juicios contenciosos administrativos</h2>
              <table>
                  <tbody>
                      <tr>
                          <td>Juicios administrativos contenciosos notificados</td>
                          <td id="resueltosN" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Juicios administrativos contenciosos resueltos</td>
                          <td id="resueltosS" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Juicios administrativos contenciosos sustanciándose</td>
                          <td id="sustanciandoseS" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Juicios de amparos resueltos</td>
                          <td id="resueltosAD" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Juicios de amparos sustanciándose</td>
                          <td id="sustanciandoseAD" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Recursos de revisión fiscal resueltos</td>
                          <td id="resueltosRF" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>Recursos de revisión fiscal sustanciándose</td>
                          <td id="sustanciandoseRF" class="numeric"></td>
                      </tr>


                  </tbody>
              </table>
            </div>
          </div>

          <div class="item3">
            <div class="table-wrapper" tabindex="0">

              <h2>Procedimientos impugnados</h2>
              <table>
                  <tbody>
                      <tr>
                          <td>desfavorables</td>
                          <td id="pDes" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>favorables</td>
                          <td id="pFav" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>trámite</td>
                          <td id="pTra" class="numeric"></td>
                      </tr>
                      <tr>
                          <td>total</td>
                          <td id="pTot" class="numeric"></td>
                      </tr>
                  </tbody>
              </table>
            </div>
          </div>

          <div class="item4"> 
            <div class="table-wrapper" tabindex="0">
              <h3>Con fecha de notificación de juicio</h3>
              <div id="notificacion"></div>

              <h3>Con fecha de sentencia</h3>
              <div id="sentencia"></div>

              <h3>Con amparo directo</h3>
              <div id="amparo"></div>

              <h3>Con recurso de revisión fiscal</h3>
              <div id="recurso"></div>


            </div>
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
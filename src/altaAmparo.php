<?php
	session_start();
	require_once('../php/database.php');
	require_once('../php/libreria.php');

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$direccion = $_SESSION['direccion'];
	$nivel = $_SESSION['nivel'];
    $usuario = $_SESSION['usuario'];
    
    $idJuicio = $_REQUEST['id'];
    $accion = $_REQUEST['accion'];
    $entidad = $_REQUEST['entidad'];
    $procedimiento = $_REQUEST['procedimiento'];
    $actor = $_REQUEST['actor'];
    $llave = $_REQUEST['ai'];
    $idPresunto = $_REQUEST['cont'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- <link rel="stylesheet" href="../css/altaJuicio.css">  -->


	<script>
		function cerrarCuadrito() {
			$("#altaOficio").fadeOut();
			$('#ventana-overlay').fadeOut('slow');
		}
	</script>

</head>

<body>
    <div class="grid-container">
        <div class="navbar">
            <a href="#" class="logo">Alta de Amparo Indirecto</a>
            <div class="navbar-right">
            <a href="javascript:cerrarCuadrito()"><i class="material-icons">close</i></a>
            </div>
        </div>
        
        <div class="info">
            <input type="text" size="10" id="idPresunto" name="idPresunto" value = "<?PHP echo $idPresunto ?>" readonly>

            <label for="procedimiento">Procedimiento:</label>
            <input type="text" name="procedimiento" id="procedimiento" value="<?php echo $procedimiento; ?>" readonly>
            
            <label for="procedimiento">Actor:</label>
            <input type="text" name="actor" id="actor" value="<?php echo $actor; ?>" readonly>
            
            <label for="procedimiento">Acción:</label>
            <input type="text" name="accion" id="accion" value="<?php echo $accion; ?>" readonly>

            <label for="procedimiento">Entidad o Dependencia:</label>
            <input type="text" name="entidad" id="entidad" value="<?php echo $entidad; ?>" readonly>
        </div>    
        
        <div class="formita">
            <form name= "forma" id="forma" autocomplete="off">
                <div id ="ventanita" class="alert">
                    <p id="mensaje"><p>
                </div>
                <table>
                    <tr>
                        <td class="juicio-etiqueta">Amparo Indirecto</td>
                        <td><input type = "text" name="amparoIndirecto" id="amparoIndirecto" size="35" class="juicio-redonda "></td>
                    </tr> 

                    <tr>
                        <td class="juicio-etiqueta ">Sala de Conocimiento</td>
                        <td><input type="text" size="35" id="salaconocimiento" name="salaconocimiento" class="juicio-redonda"></td>
                    </tr>


                    <tr>
                        <td class="juicio-etiqueta ">Fecha Interposición</td>
                        <td><input type="text" class="juicio-redonda " size="35" id="fechanot" name="fechanot"/></td>
                        
                        <td class="juicio-etiqueta ">Vencimiento</td>
                        <td><input type="text" class="juicio-sinborde" size="35" id="vencimiento" name="vencimiento" readonly></td>
                    </tr>

                    <tr>
                        <td class="juicio-etiqueta ">Dirección de Origen</td>
                        <td>
                            <select name="dir" id="dir" class="juicio-redonda ">
                            <option value="A" selected="selected">Nelly Zulema Sánchez Cruz</option>

                            <?php
                                $sql = "SELECT * FROM usuarios WHERE nivel like '%A%' AND puesto = 'Director de Área' AND status != '0' ORDER BY nivel";
                                $sqlv = $pdo->prepare($sql);
                                $sqlv->execute();
                                $r = $sqlv->fetch(PDO::FETCH_ASSOC);
                                echo '<option value="'.$r['nivel'].'">'.$r['nombre'].'</option>';
                            ?> 
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="juicio-etiqueta ">Subdirector</td>
                        <td>
                        <select name="sub" id="sub" class="juicio-redonda ">
                        <option value="" selected="selected">Elegir</option>
                        
                        <?php
                            $sql = "SELECT * FROM usuarios WHERE LENGTH(nivel) = 3 AND nivel like '%A%' ORDER BY nivel";
                            $sqlv = $pdo->prepare($sql);
                            $sqlv->execute();
                            $resultado = $sqlv->fetchAll();
                            foreach ($resultado as $row => $r) {
                            echo '<option value="'.$r['nivel'].'">'.$r['nombre'].'</option>';
                            }
                        ?>
                        
                        </select>
                        </td> 
                    </tr>

                    <tr>
                        <td colspan="4"><br>
                        <input type="hidden" name="nom" id="nom" value="<?php echo $r['nombre']; ?>">
                        </td>
                    </tr>
                </table>
            </form>
            <button  type="botton" class="boton" name="inserta_juicio" id="inserta_juicio" >Insertar nuevo Amparo Indirecto</button>

        </div>
        <div class= "piePagina">
				<p>ASF DGR ® Todos los derechos reservados</p>
	    </div>
    </div>
    <!-- <script type="text/javascript" src="src/altaAmparo.js"></script> -->
    <script  src="../presuntos/dist/amparos.js"></script>
    
</body>
</html>

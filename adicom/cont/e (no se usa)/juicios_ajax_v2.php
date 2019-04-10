<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");
error_reporting (2); 
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conn = $conexion->conectar();
error_reporting(E_ERROR); 
//-------------------------- DESINFECTAR VARIABLES -----------------------------
$valor = valorSeguro($_POST['valor']);

$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];
$limit = valorSeguro($_POST['limit']);


$txtsql="SELECT * FROM juiciosNew where (actor like '%$valor%') OR  (juicionulidad like '%$valor%') OR (procedimiento like '%$valor%')  OR (accion like '%$valor%') ";
$y= $conexion -> select($txtsql);
$r= mysql_fetch_array($y);



//---------------------------------------------------------------

if($direccion == 'DG') 	$txtsql .= " and 1=1 ";
else 					$txtsql .= " and subnivel LIKE '".$nivel."%'  ";


$j=$conexion -> select($txtsql);

$tabla = '
		<div style="overflow:visible;   height:330px">
		<table border="0"  align="center" cellpadding="0" cellspacing="0" id="product-table" >
        <thead>
            <tr>';
			$tabla .= '<th style="width:200px; color:white;">Actor </th>';
			// $tabla .= '<th class="ancho50 blanco"> Número de Juicio Interno </th>';

				//$tabla .= '<th class="ancho100 blanco">Cuenta Pública</th>';
				$tabla .= '<th style="width:100px; color:white;">Acción</th>';
				$tabla .= '<th class="ancho200 blanco">Procedimiento</th>';

				// $tabla .= '<th class="ancho100 blanco">Sala del Conocimiento</th>';
				$tabla .= '<th class="ancho100 blanco">Juicio de Nulidad</th>';				
				$tabla .= '<th class="ancho10 blanco">Fecha Resolución</th>';
				$tabla .= '<th class="ancho 100 blanco">Resultado</th>';				
			// $tabla .= '<th class="ancho100 blanco">Vencimiento Fatal</th>'; 
			$tabla .= '<th class="ancho100 blanco">Sub</th>'; 
			$tabla .= '<th class="ancho100 blanco">Dir</th>'; 
			$tabla .= '<th class="ancho100 blanco">Abogado</th>'; 
			$tabla .= '<th class="ancho100 blanco">Monto</th> ';
			$tabla .= '<th class="ancho100 blanco">Control Interno</th> 
					</tr>
				</thead>';



   



while($r = mysql_fetch_array($j))
{

	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	$total=mysql_num_rows($j);
	//------SQL de Volantes//
	
	$nivPart = explode(".",$r['subnivel']);
	 $nivDir = $nivPart[0];
	 $nivSbd = $nivPart[0].".".$nivPart[1];
	 $nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
	 $nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];

	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ",false);
	$d = mysql_fetch_array($sql1);
	$director = $d['nombre'];

	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ",false);
	$d = mysql_fetch_array($sql1);
	$subdirector = $d['nombre'];
	
	$sql1 = $conexion->select("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ",false);
	$d = mysql_fetch_array($sql1);
	$jefe = $d['nombre'];
	
	
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------

	$tabla .= '
            <tr '.$estilo.' >';
				
			/*	$tabla .= '<td <a >
						'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['nojuicio']).'
						</a></td>';  */
				

				$tabla .= '<td style="width:200px;">'.$r['actor'].'</td>';				

				// $tabla .= '<td class="" align="center">'.$r['cuentapublica'].'</td>';
				$tabla .= '<td style="width:100px;">'.$r['accion'].'</td>';
				$tabla .= '<td class=""align="center">'.$r['procedimiento'].'</td>';

				// $tabla .= '<td class="" align="center">'.$r['salaconocimiento'].'</td>';
				$tabla .= '<td class="" align="center">'.$r['juicionulidad'].'</td>';
				$tabla .= '<td class="" align="center">'.fechaNormal($r['f_resolucion']).'</td>';
				$tabla .= '<td class="" align="center"> '.$r['resultado'].'</td>';
				// $tabla .= '<td class="" align="center">'.fechaNormal($r['vencimiento']).'</td>';
				$tabla .= '<td class="" align="center">'.$subdirector.'</td>';
				$tabla .= '<td class="" align="center">'.$r['dir'].'</td>';
				$tabla .= '<td class="" align="center">'.$jefe.'</td>';
				$tabla .= '<td class="" align="center">'.'$ '.number_format($r['monto'],2).'</td>';
				$tabla .= '<td class="" align="center"> 
				
				
                <a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(520,900,"Autor: '.$r['actor'].'",50,
                "cont/juicios_mod_v2.php","juicioid='.$r['id'].'&juinu='.$r['nojuicio'].'&mAccion='.$r['accion'].'")\'></a>';
				
						
				
	
					
			$tabla .= '</td> </tr>';
}
$tabla .= '
			</tbody>
			</table>
			</div>
			<!--  end product-table................................... --> 
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";




$paginas = ceil($total/500);
echo $tabla."||".$total."||".$paginas."||".$totalBus;

mysql_free_result($sql);
mysql_close();
?>

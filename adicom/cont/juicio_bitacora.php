<script>
function verTexto(texto)
{
 new mostrarCuadro2(200,600,"Detalle del Movimiento",200);
 $$("#cuadroRes2").html(texto);	
}

function muestraPestanaBit(divId)
{
	ocultaAll();
	$$('#p'+divId).removeClass('pInactivo');
	
	$$('#p'+divId).addClass('pActivo');	
	$$('#paso'+divId).addClass('pasosActivo'); 
	$$('#np'+divId).addClass('noPasoActivo');
		
	$$('#p'+divId).fadeIn();
	$$('#p'+divId).fadeIn();
}
</script>
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$juicio = valorSeguro($_REQUEST['juicio']);
$direccion = $_REQUEST['direccion'];

//if($direccion == "DG")
	

$tabla .=  '    
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" id="product-table" >
	<thead>
		<tr>
			<th class="bitEdoTra"><a href="#">Estado de Tramite</a>	</th>
			<!-- <th class="bitEvento"><a href="#"> Tipo </a></th> -->
			<th class="bitDatos"><a href="#">Datos</a></th>
			<th class="bitActua"><a href="#">Actualización</a></th>

		</tr>
'; 
?>
<div class="encVol">
    <div id='paso1' onclick="muestraPestanaBit(1)" class="todosPasos pasosActivo pasos"> BITACORA </div>
</div>
<div id='p1' class="contOficios redonda10 todosContPasos">

<?php  
//------------------- datos de PO --------- ---------------------------------
//------------------- datos de PO HISTORIAL ---------------------------------  
$sql = $conexion->select("SELECT * FROM juicios_historial WHERE nojuicio = $juicio ");
$total = mysql_num_rows($sql);

while($r = mysql_fetch_array($sql))
{
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	//tipo	oficio	oficioRecepcion	oficioAcuse
	$txtTipo = "";
	$tablaDatos = "";
	
	//------------ configuramos textos e imagenes NORMAL ---------------
	if($r['tipo'] == 'contestacion') $imagen = '<img src="images/Gavel-Law-icon.png" style="width:15px; height="15px"/>Contestación de Demanda';
	if($r['tipo'] == 'ampliacion') 	$imagen = '<img src="images/User-Files-icon.png" style="width:15px; height="15px"/>Ampliación de Demanda' ;
	if($r['tipo'] == 'alegatos') 	$imagen = '<img src="images/Document-Write-icon.png" style="width:15px; height="15px"/>Alegatos' ;
	
	//--------------- textos de Aspectos legales --------------------------------
	//--------------- textos de Aspectos legales --------------------------------
	
	if($r['tipo'] == 'contestacion')$txtTipo = '<span class="fechaPFRR"></span>'. 'Mediante oficio número '.cadenaNormalOficio($r['oficio']).', presentando el día '.fechaNormal($r['oficioAcuse']).' , la Dirección General "C" da contestación a la demanda interpuesta.';
	
		if($r['tipo'] == 'ampliacion')$txtTipo = '<span class="fechaPFRR"></span>'. 'Mediante oficio número '.cadenaNormalOficio($r['oficio']).', presentando el día '.fechaNormal($r['oficioAcuse']).' , la Dirección General"C" da contestación a la ampliación interpuesta.';
	
		if($r['tipo'] == 'alegatos')$txtTipo = '<span class="fechaPFRR"></span>'. 'Mediante oficio número '.cadenaNormalOficio($r['oficio']).', presentando el día '.fechaNormal($r['oficioAcuse']).' , la Dirección General "C" da contestación a los alegatos interpuestos.';
	
	//-----------------------------------------------------------------------------------------	

	$tabla .= '
			<tr '.$estilo.'>
				<td class="bitEdoTra" >
				<table class="tablaBitacora">
					<tr>
						<td onClick="'.$onClick.'">'.$imagen.'</td>
				</table>
				
				</td>
				<!--
				<td class="bitEvento">'.$r['tipo'].'</td>
				-->
				<td class="bitDatos">';
				
				//--- leyenda aspectos Legales
				
	$tabla .=  $txtTipo;
				
							
			$tabla .= '</td>';
			$userBit = dameUsuario($r['usuario']);
			$tabla .= '<td class="bitActua">'.fechaNormal($r['FechaMov']).' '.$r['HoraMov'].' <br> '.$userBit['nombre'].'</td>';
			$tabla .= '</tr>';
}
if($total == 0) $tabla .= "<tr><td colspan='5'><center><h3 style=' background:#fff; padding:30px; margin:20px'>Esta acción no tiene movimientos</h3></center></td></tr>";
$tabla .= '</tbody>	</table>
		<!--  end product-table................................... --> ';
echo "".$tabla."";

mysql_free_result($sql);
?>






























</div>
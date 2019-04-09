<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
foreach($_POST as $nombre_campo => $valor)
{
   $resultado = strpos($nombre_campo, "accionVinculada_"); 
   if($resultado  !== FALSE)
   {
	   $acciones .= valorSeguro($valor)."|";
   }
   else
   {
   $asignacion = "\$" . $nombre_campo . " = '" . valorSeguro($valor) . "';"; 
   eval($asignacion);
   //echo "\n ".$asignacion;
   }
}
if($_REQUEST["tipoayuda"] == "mrr")
{
	$acciones = substr($acciones, 0, -1);
}
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
//-------------------------------------------------------------------------------
//--------------- COMPROBACION DE QUE NO SE REPITA OFICIO -----------------------

//$sql = $conexion->select("SELECT * FROM solicitud_ayuda WHERE num_accion LIKE '$acciones' AND hora_oficio = '$horaOficio' AND abogado_solicitante = '$userForm'   ", false);
//$TO = mysql_num_rows($sql);

//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//------------------- GENERACION DEL VOLANTE ------------------------------------
//-------------------------------------------------------------------------------
//-------------------------------------------------------------------------------
//------------------- IMPORTANTE NO MOVER EL ORDEN DE LOS PROCESOS --------------
//------------------- buscamos año del ultimo oficio  ---------------------------
//-- de la tabla de folios buscamos por id y de mas a menos y tenemos el ultimo.-
//-------------------------------------------------------------------------------
	$sql = $conexion->select("SELECT * FROM solicitud_ayuda ORDER BY id DESC LIMIT 1", false);
	$totalOf = mysql_num_rows($sql);
	$r = mysql_fetch_array($sql);
	$consecutivo = $r['consecutivo']; 
	$anioAnt = $fechaPartes[0];
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;
	//-------------------------------------------------------------------------------
	$sql = $conexion->insert("INSERT INTO solicitud_ayuda 
							  SET 
							    id='',
								direccion = '$dirForm',
								fecha_sol = '$fechaOficio',
								hora_sol = '$horaOficio',
								num_accion = '$acciones',
								asunto = '$asunto',
								status = '0',
								solicitante = '$userForm',
								tipo = '$tipoayuda'"
								
							,false);
							
							
	
	$ultimo_id = mysql_insert_id(); 

	$sql = $conexion->select("SELECT * FROM solicitud_ayuda ORDER BY id DESC LIMIT 1", false);
	$sqlfila = $conexion->select("SELECT id FROM solicitud_ayuda where status != '0' ORDER BY fecha_sol DESC LIMIT 1", false);
	$r2 = mysql_fetch_array($sqlfila);
	$r3= $r2['id'];
	if ($r3==0){ 
	$r3="0";
	}
	$rx=	$r['id'];
	$folio=$rx+1;
	
	//echo $ultimo_id;
	//echo "<bR>".print_r($_POST);
	
	$usu = dameUsuario($userForm);
	$nombre = $usu['nombre'];
		
	enviaCorreo($nombre,"root@asf.gob.mx","Ticket Generado No. $folio","<b> - Ticket Generado No. $folio <br> - Generedo por ".$nombre." <br> - Accion: ".$acciones."<br><br>Asunto:</b>  ".$asunto);
	
	echo "<center><h2>Se generó el número de Ticket <br>$folio </center></h2>";
	echo "<center><h2>El último Ticket atendido es el  número <br> $r3 </center></h2>";
	echo "<center><h2>Por favor espere su turno, en un momento se atenderá su solicitud. </h2>";
	//echo "<center><font face='Arial size='10''><b>[Tiempo de espera estimado 60 minutos]</b> ";
// end TO



@mysql_free_result($sql);
?>

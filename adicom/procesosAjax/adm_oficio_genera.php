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
//echo "\n\n Acciones: ".$acciones."\n\n ";

//------------------- GENERACION DEL VOLANTE ------------------------------------
//-------------------------------------------------------------------------------
$fechaOficio = date('Y-m-d');
$horaOficio = date("H:i:s");
//-------------------------------------------------------------------------------
//------------------- IMPORTANTE NO MOVER EL ORDEN DE LOS PROCESOS --------------
//------------------- buscamos año del ultimo oficio  ---------------------------
//-- de la tabla de folios buscamos por id y de mas a menos y tenemos el ultimo.-
$folio = generaOficios($tipo = "adm", $fechaOficio, $horaOficio, $acciones, $presunto, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio);
//--------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------
$partesAcciones = explode("|",$acciones);
//-------------- INSERTAMOS EN LA TABLA FOLIOS CONTENIDO CADA ACCION -------------------------------
foreach($partesAcciones as $k => $v)
{
	if($v != "")
	{
		$sqlX = $conexion->insert("INSERT INTO oficios_contenido 
									SET 
										 folio = '".$folio."',
										 num_accion = '".$v."',
										 oficio_referencia = '".$oficioRef."',
										 juridico = 1 ",false);
	}
}
//-------------- INSERTAMOS CADA ACCION EN HISTORIAL DE MANERA INDIVIDUAL --------------------------
$partesAcciones = explode("|",$acciones);

for($i=0; $i<=count($partesAcciones); $i++)
{
	if($partesAcciones[$i] != "")
	{
		if(stripos($oficioRef,"dgr") !== false) {$tipo = "DGR"; }
		else {$tipo = $dependencia; }

		
		$sql = $conexion->insert("INSERT INTO otros_oficios 
									SET
										num_accion = '".$partesAcciones[$i]."',
										folio_volante = '$folio',
										documentoExtra = '$oficioRef',
										fecha = '$fechaOficio',
										acuse = '$fechaAcuse',
										leyenda = '$asunto',
										atiende = '$remitente',
										referencia = '$remitente',
										tipo = '$tipoOficio',
										status = 1",false);	
	}
}
//-------------------------------------------------------------------------------
//------------------- VERIFICA QUE NO EXISTA EL NUEVO REMITENTE SI EXISTE NO LO INGRESA ----------------------
	//$sql = $conexion->select("SELECT * FROM volantes_remitentes WHERE nombre = '".$remitente."' AND cargo = '".$cargo."'	AND dependencia = '".$dependencia."' ",false);	
	//$total = mysql_num_rows($sql);
	
	//if($total == 0)
		//$sql = $conexion->insert("INSERT INTO volantes_remitentes SET nombre = '$remitente', cargo = '$cargo', dependencia = '$dependencia'",false);	

//echo $ultimo_id;
//echo "<bR>".print_r($_POST);

echo "<br><br><center><h2>Se generó el número de oficio <br><br>$folio</center></h2>";
@mysql_free_result($sql);
?>

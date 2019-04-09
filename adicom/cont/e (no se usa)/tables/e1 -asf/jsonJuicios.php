<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

//$llave = $_GET['hola'];
$result = $db->getJuicios();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
            'id' => floatval($valor['id']),
            'nojuicio' => $valor['nojuicio'],
            'entidad' => $valor['entidad'],
            'cp' => $valor['cp'],		
            'accion' => $valor['accion'],
            'procedimiento' => $valor['procedimiento'],
            'actor' => $valor['actor'],
            'salaconocimiento' => $valor['salaconocimiento'],
            'juicionulidad' => $valor['juicionulidad'],
            'fechanot' => $valor['fechanot'],
            'vencimiento' => $valor['vencimiento'],
            'sub' => $valor['sub'],
            'dir' => $valor['dir'],
            'subnivel' => $valor['subnivel'], 			
            'monto' => floatval($valor['monto']), 
            'oficio_contestacion' => $valor['oficio_contestacion'], 
            'fecha_pre_tribunal' => $valor['fecha_pre_tribunal'], 
            'oficio_ampliacion' => $valor['oficio_ampliacion'], 
            'oficio_alegatos' => $valor['oficio_alegatos'], 
            'fecha_pre_alegatos' => $valor['fecha_pre_alegatos'], 
            'estado' => $valor['estado'], 
            'fecha_conclusion' => $valor['fecha_conclusion'], 
            'observaciones' => $valor['observaciones'], 

            'cargo_sp' => $valor['cargo_sp'], 
            'resolucion_sp' => $valor['resolucion_sp'],
            'f_resolucion' => $valor['f_resolucion'], 
            'con_responsabilidad_origen' => $valor['con_responsabilidad_origen'], 			
            'registro_sancionados' => $valor['registro_sancionados'], 	
            'sin_responsabilidad_origen' => $valor['sin_responsabilidad_origen'], 	
            'DESF' => $valor['DESF'],
            'resultado' => $valor['resultado']);
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
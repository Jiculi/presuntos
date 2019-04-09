<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getJuicios();
$i = 1;
$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
             'i' => $i++,
            'id' => floatval($valor['id']),
            'nojuicio' => $valor['nojuicio'],
            'cp' => $valor['cp'],		
            'accion' => $valor['accion'],
            'procedimiento' => $valor['procedimiento'],
            'salaconocimiento' => $valor['salaconocimiento'],
            'juicionulidad' => $valor['juicionulidad'],

            'actor' => mb_substr($valor['actor'],0,30),
            'actorX' => mb_substr($valor['actor'],0,100),

            'entidad' => mb_substr($valor['entidad'],0,30),
            'entidadX' => mb_substr($valor['entidad'],0,100),

            'fechanot' => ($valor['fechanot'] == '0000-00-00' ? ' ' : $valor['fechanot']),
            'fecha_not' => ($valor['fecha_not'] == '0000-00-00' ? ' ' : $valor['fecha_not']),
            'f_resolucion' => ($valor['f_resolucion'] == '0000-00-00' ? ' ' : $valor['f_resolucion']),
            'fecha_not_sentencia' => ($valor['fecha_not_sentencia'] == '0000-00-00' ? ' ' : $valor['fecha_not_sentencia']),
            'fecha_sentencia' => ($valor['fecha_sentencia'] == '0000-00-00' ? ' ' : $valor['fecha_sentencia']),
            'toca_en_revision' => $valor['toca_en_revision'],
            'toca_amparo' => $valor['toca_amparo'],


            'vencimiento' => $valor['vencimiento'],
            'sub' => $valor['sub'],
            'dir' => $valor['dir'],
            'subnivel' => $valor['subnivel'], 			
            'monto' => number_format(floatval($valor['monto'])), 
            'oficio_contestacion' => $valor['oficio_contestacion'], 
            'fecha_pre_tribunal' => $valor['fecha_pre_tribunal'], 
            'oficio_ampliacion' => $valor['oficio_ampliacion'],
            'fecha_pre_ampliacion' => $valor['fecha_pre_ampliacion'],             
            'oficio_alegatos' => $valor['oficio_alegatos'], 
            'fecha_pre_alegatos' => $valor['fecha_pre_alegatos'], 
            'estado' => $valor['estado'], 
            'fecha_conclusion' => $valor['fecha_conclusion'], 
            'observaciones' => $valor['observaciones'], 
            'sentencia_primera' => $valor['sentencia_primera'], 

            'cargo_sp' => $valor['cargo_sp'], 
            'resolucion_sp' => $valor['resolucion_sp'],
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
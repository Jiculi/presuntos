<?php

require_once 'database.php';
require 'libreria.php';

$blancos = '';
$db = new libreria();

$result = $db->getJuiciosAD();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {


        // $ad_f_interposicion = if($valor['ad_f_interposicion'] == '0000-00-00') {echo $blancos} else {echo $valor['ad_f_interposicion']};
        $ad_f_interposicion = ($valor['ad_f_interposicion'] == '0000-00-00' ? ' ' : $valor['ad_f_interposicion']);
        $data[] = array(
            'id' => floatval($valor['id']),
            'nojuicio' => $valor['nojuicio'],
            'entidad' => $valor['entidad'],
            'cp' => $valor['cp'],		
            'accion' => $valor['accion'],
            'procedimiento' => $valor['procedimiento'],
            'actor' => mb_substr($valor['actor'],0,30),
            'salaconocimiento' => $valor['salaconocimiento'],
            'juicionulidad' => $valor['juicionulidad'],
            'fechanot' => $valor['fechanot'],
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
            'fecha_sentencia' => $valor['fecha_sentencia'], 
            'sentencia_primera' => $valor['sentencia_primera'], 

            'cargo_sp' => $valor['cargo_sp'], 
            'resolucion_sp' => $valor['resolucion_sp'],
            'f_resolucion' => $valor['f_resolucion'], 
            'con_responsabilidad_origen' => $valor['con_responsabilidad_origen'], 			
            'registro_sancionados' => $valor['registro_sancionados'], 	
            'sin_responsabilidad_origen' => $valor['sin_responsabilidad_origen'], 	
            'DESF' => $valor['DESF'],


            'fecha_pre_rf' => $valor['fecha_pre_rf'],
            'ejecutoria_revision' => $valor['ejecutoria_revision'],
            'rf_status' => $valor['rf_status'],
            'fecha_ejec_rev' => $valor['fecha_ejec_rev'],
            'fecha_not_ejec_rev' => $valor['fecha_not_ejec_rev'], 

            // amaparo directo

            'ejecutoria_amparo' => $valor['ejecutoria_amparo'],
            'fecha_ejec_amp' => ($valor['fecha_ejec_amp'] == '0000-00-00' ? ' ' : $valor['fecha_ejec_amp']),
            'toca_amparo' => $valor['toca_amparo'],
            'fecha_not_ejec_amp' => ($valor['fecha_not_ejec_amp'] == '0000-00-00' ? ' ' : $valor['fecha_not_ejec_amp']),
            'ad_f_interposicion' => ($valor['ad_f_interposicion'] == '0000-00-00' ? ' ' : $valor['ad_f_interposicion']),
            'ad_status' => $valor['ad_status'],
            'tribunal' => $valor['tribunal'],
            'ad_observaciones' => $valor['ad_observaciones'],



            'resultado' => $valor['resultado']);
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
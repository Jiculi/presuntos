<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getOficios();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
            'id' => floatval($valor['id']),
            'folio' => $valor['folio'],
            'fecha_oficio' => $valor['fecha_oficio'],
            'hora_oficio' => $valor['hora_oficio'],		
            'num_accion' => $valor['num_accion'],
            'volante' => $valor['presunto'],
            'oficio_referencia' => $valor['oficio_referencia'],
            'destinatario' => mb_substr($valor['destinatario'],0,30),
            'cargo_destinatario' => $valor['cargo_destinatario'],
            'dependencia' => mb_substr($valor['dependencia'],0,20),
            'asunto' => $valor['asunto'],
            'abogado_solicitante' => $valor['abogado_solicitante'],
            'tipo' => $valor['tipo'],
            'tipoOficio' => $valor['tipoOficio'], 			
            'status' => floatval($valor['status']), 
            'juridico' => floatval($valor['juridico']), 
            'porPresunto' => floatval($valor['porPresunto']), 
            'atendido' => floatval($valor['atendido']), 
            'visto' => floatval($valor['visto']));           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
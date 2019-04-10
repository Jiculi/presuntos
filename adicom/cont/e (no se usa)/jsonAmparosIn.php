<?php

require_once 'database.php';
require 'libreria.php';

$db = new libreria();

$result = $db->getAmparosIn();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {
        $data[] = array(
            'id' => floatval($valor['id']),
            'sub' => $valor['sub'],
            'estado' => $valor['estado'],
            'procedimiento' => $valor['procedimiento'],
            'actor' => mb_substr($valor['actor'],0,30),
            'f_interposicion' => ($valor['f_interposicion'] == '0000-00-00' ? ' ' : $valor['f_interposicion']),
            'instancia' => mb_substr($valor['instancia'],0,30),
            'ai' => $valor['ai'],
            'f_resolucion' => ($valor['f_resolucion'] == '0000-00-00' ? ' ' : $valor['f_resolucion']),
            'f_notificacion' => ($valor['f_notificacion'] == '0000-00-00' ? ' ' : $valor['f_notificacion']),
            'observaciones' => $valor['observaciones']);
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
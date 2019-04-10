<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getVolantesContenido();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
            'accion' => $valor['accion'],
            'presunto' => $valor['presunto'],  // juicio
            'folio' => $valor['folio'],
            'fecha_actual' => $valor['fecha_actual'],
            'tipoMovimiento' => $valor['tipoMovimiento'],
            'remitente' => mb_substr($valor['remitente'],0,30),
            'entidad_dependencia' => mb_substr($valor['entidad_dependencia'],0,30),
            'turnado' => $valor['turnado'],
            'direccion' => $valor['direccion']
        );
    }

}
echo json_encode($data);				   
Database::disconnect();
	
?>
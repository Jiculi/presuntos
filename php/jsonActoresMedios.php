<?php

require_once './database.php';
require './libreria.php';
$db = new libreria();

$result = $db->getAutoresMedios();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $r) {

        $data[] = array(
            'entidad' => mb_substr($r['entidad'],0,20),
            'num_accion' => $r['num_accion'],
            'num_procedimiento' => $r['num_procedimiento'],
            'nombre' => $r['nombre'],
            'cargo' => $r['cargo'],
            'juicionulidad' => $r['juicionulidad'],
            'ai' => $r['ai'],
            'recurso_reconsideracion' => $r['recurso_reconsideracion'],
            'cont' => $r['cont'],
            'subnivel' => substr($r['subnivel'],0,3)

           );
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
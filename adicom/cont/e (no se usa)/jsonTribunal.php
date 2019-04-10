<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getTribunal();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
            'id' => floatval($valor['id']),
            'value' => $valor['tribunal']);
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
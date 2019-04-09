<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$captura= $_REQUEST["term"];

$result = $db->getVolantes($captura);

$data = array();
if (empty($result)) {
     $data[] = 	 array(
         'id' => 0,
         'value' => "No existe"
     );
} else {
	foreach ($result as $row => $valor) {

        $data[] = array(
            'id' => floatval($valor['id']),
            'value' => $valor['folio']
        ); 
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
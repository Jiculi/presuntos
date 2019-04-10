<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getPFRR();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $valor) {
        $error = date_diff(date_create(date("Y-m-d",strtotime($valor['fecha_IR']."+ 5 year"))), date_create($valor['prescripcion']));
        $data[] = array(
            'num_accion' => $valor['num_accion'],
            'num_procedimiento' => $valor['num_procedimiento'],

            'entidad' => mb_substr($valor['entidad'],0,40),
            'cp' => $valor['cp'],		
            'subdirector' => $valor['subdirector'],
            'abogado' => $valor['abogado'],
            'direccion' => mb_substr($valor['direccion'],0,30),
            'detalle_edo_tramite' => $valor['detalle_edo_tramite'],
            'estado' => $db->dameEstado($valor['detalle_edo_tramite']),
            'fecha_IR' => $valor['fecha_IR'],
            'cinco' => date("Y-m-d",strtotime($valor['fecha_IR']."+ 5 year 1 day")),
            'error' =>  $error->format('%a'),
            'prescripcion' => $valor['prescripcion'],
            'subnivel' => substr($valor['subnivel'],0,3)
        );
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
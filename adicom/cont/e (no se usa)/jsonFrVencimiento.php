<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getPFRRvencimiento();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $r) {

       /* $sql = "SELECT num_accion,entidad,cp,subdirector,abogado,direccion,abogado,detalle_edo_tramite,subnivel FROM pfrr";*/

        $estado = str_replace("Resolución Notificada.","",$db->dameEstado($r['detalle_edo_tramite']));
        $data[] = array(
            'entidad' => mb_substr($r['entidad'],0,40),
            'num_accion' => $r['num_accion'],
            'num_procedimiento' => $r['num_procedimiento'],
            'direccion' => mb_substr($r['direccion'],0,30),
            'po' => $r['po'],		
            'limite_emision_resolucion' => $r['limite_emision_resolucion'],
            'resolucion' => $r['resolucion'],
            'limite_notificacion_resolucion' => $r['limite_notificacion_resolucion'],
            'fecha_notificacion_resolucion' => $r['fecha_notificacion_resolucion'],
            'cierre_instruccion' => $r['cierre_instruccion'],
            'noventa' => date("Y-m-d",strtotime($r['cierre_instruccion']."+ 90 day")),

            'limite_cierre_instruccion' => $r['limite_cierre_instruccion'],

            'DifDias' => $r['DifDias'] . " días",

            'cp' => $r['cp'],		
            'abogado' => $r['abogado'],
            'estado' => $estado,
            'detalle_edo_tramite' => $r['detalle_edo_tramite'],

            'prescripcion' => $r['prescripcion'],
            'subnivel' => substr($r['subnivel'],0,3),
            'subdirector' => $db->dameSubdirector(substr($r['subnivel'],0,3))

        );
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
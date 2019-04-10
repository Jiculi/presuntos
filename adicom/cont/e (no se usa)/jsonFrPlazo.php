<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getPFRRplazo();

$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $r) {

       /* $sql = "SELECT num_accion,entidad,cp,subdirector,abogado,direccion,abogado,detalle_edo_tramite,subnivel FROM pfrr";*/

        $difEmi = ($r['difEmiRes'] <= 90) ? "SI" : "NO";
        $difNot = ($r['difNotRes'] <= 10) ? "SI" : "NO";
        $estado = str_replace("Resolución Notificada.","",$db->dameEstado($r['detalle_edo_tramite']));

        $data[] = array(
            'entidad' => mb_substr($r['entidad'],0,20),
            'num_accion' => $r['num_accion'],
            'num_procedimiento' => $r['num_procedimiento'],
            'direccion' => mb_substr($r['direccion'],0,30),
            'po' => $r['po'],		
            'limite_emision_resolucion' => $r['limite_emision_resolucion'],
            'resolucion' => $r['resolucion'],
            'limite_cierre_instruccion' => $r['limite_cierre_instruccion'],
            'limite_notificacion_resolucion' => $r['limite_notificacion_resolucion'],
            'fecha_notificacion_resolucion' => $r['fecha_notificacion_resolucion'],
            'cierre_instruccion' => $r['cierre_instruccion'],

            'difEmiRes' => $r['difEmiRes'],
            'difEmi' => $difEmi,
           
            'difNotRes' => $r['difNotRes'],
            'difNot' => $difNot,


            'cp' => $r['cp'],		
            'subdirector' => $r['subdirector'],
            'abogado' => $r['abogado'],
            'estado' => $estado,
            'detalle_edo_tramite' => $r['detalle_edo_tramite'],

            'prescripcion' => $r['prescripcion'],
            'limite_cierre_instruccion' => $r['limite_cierre_instruccion'],
            'subnivel' => $r['subnivel']);
           		
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
<?php

require_once 'database.php';
require 'libreria.php';
$db = new libreria();

$result = $db->getJCAcontrol01();
$i = 1;
$data = array();
if ($result == "{}") {
     $data[] = 	 "No hay nada";
} else {
	foreach ($result as $row => $r) {

        $data[] = array(
            'resultado' => $r['resultado'],
            'juicios' => $r['juicios'],
            'falta' => $r['falta'],
            'ceros' => $r['ceros'],
            'Reporte' => $r['Reporte'],
            '2018' => $r['2018'],
            'Ene' => $r['Ene'],
            'Feb' => $r['Feb'],
            'Mar' => $r['Mar'],
            'Abr' => $r['Abr'],
            'May' => $r['May'],
            'Jun' => $r['Jun'],
            'Jul' => $r['Jul'],
            'Ago' => $r['Ago'],
            'Sep' => $r['Sep'],
            'Oct' => $r['Oct'],
            'Nov' => $r['Nov'],
            'Dic' => $r['Dic'],
            '2019' => $r['2019']);
	}
}
echo json_encode($data);				   
Database::disconnect();
	
?>
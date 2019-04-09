<?php
/** Error reporting */
error_reporting(E_ALL);
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
date_default_timezone_set("America/Mexico_City");

//require_once("includes/iclases.php");
require_once("includes/funciones.php");

require('EXCEL/PHPExcel.php');
require('EXCEL/PHPExcel/Writer/Excel2007.php');
$iconexion = new iconexion;
$iconexion->iconectar();

$ef = valorSeguro($_REQUEST['ef']);


/** Include path **/
//ini_set('include_path', ini_get('include_path').';../includes/Classes');

/** PHPExcel */
//include 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
//include 'PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(1);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0.75);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(1);
// Set properties
//echo date('H:i:s') . " Set properties\n";
//Una vez conectados hacemos la consulta para obtener los datos 

$cont = "select pfrr.entidad, pfrr.num_accion, uaa, fondo, estado_sicsa, inicio_frr from pfrr inner join po on po.num_accion=pfrr.num_accion inner join estados_tramite on pfrr.detalle_edo_tramite=estados_tramite.id_estado inner join estados_sicsa on estados_sicsa.id_sicsa=estados_tramite.id_sicsa where entidad like '%$ef%' and estados_sicsa.id_sicsa=7";











  
$resultado = $iconexion->iselect($cont,false); 

//Ahora comprobamos si se han obtenido datos, si el numero de registros es mas grande que 0, es que ha obtenido datos y podemos crear el reporte 
if($resultado->num_rows > 0 ){ 
//Aqui se determina si se está accediendo al archivo vía HTTP o CLI, el archivo solo se va a mostrar si se accede desde un navegador web(HTTP). 
if (PHP_SAPI == 'cli') 
    die('Este archivo solo se puede ver desde un navegador web'); 
     
//Aqui se arma el reporte de excel 
  
// Se crea el objeto PHPExcel 
 $objPHPExcel = new PHPExcel(); 

 //agregamos las propiedades del archivo de Excel 
// Se asignan las propiedades del libro 
$objPHPExcel->getProperties()->setCreator("") // Nombre del autor 
    ->setLastModifiedBy("NexusL") //Ultimo usuario que lo modificó 
    ->setTitle("Reporte Excel con PHP y MySQL") // Titulo 
    ->setSubject("Reporte Excel con PHP y MySQL") //Asunto 
    ->setDescription("Simposiums") //Descripción 
    ->setKeywords("Prueba") //Etiquetas 
    ->setCategory("Reporte excel");

//Para los títulos del reporte crea dos variables, de esta forma es más fácil realizar cambios si el reporte fuera muy extenso. 
$tituloReporte = "Prueba"; 
$titulosColumnas = array('N','Accion','Entidad','Cuenta Pública','PR','Cargo','Fondo','Irregularidad','Control Interno', 'Monto'); 

//El reporte tien 2 columnas: Nom y valor. Por lo tanto solo vamos a ocupar hasta la columna B. 
// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte 
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(false)->setScale(75);
$objPHPExcel->getActiveSheet()->getStyle('A10:D10')
->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  
// Se agregan los titulos del reporte 
$objPHPExcel->setActiveSheetIndex(0) 
    ->setCellValue('A1',$tituloReporte) // Titulo del reporte 
    ->setCellValue('A3',  $titulosColumnas[0]) //Titulo de las columnas 
    ->setCellValue('B3',  $titulosColumnas[1]); 

//Se agregan los datos de los alumnos 
  
 $i = 4; //Numero de fila donde se va a comenzar a rellenar 
 while ($fila = $resultado->fetch_array()) { 
     $objPHPExcel->setActiveSheetIndex(0) 
         ->setCellValue('A'.$i, $fila['num_accion']) 
         ->setCellValue('B'.$i, $fila['num_accion']) 
         ->setCellValue('C'.$i, $fila['entidad']) 
         ->setCellValue('D'.$i, $fila['cp']) 
         ->setCellValue('E'.$i, $fila['nombre']) 
         ->setCellValue('F'.$i, $fila['cargo']) 
         ->setCellValue('G'.$i, $fila['fondo']) 
         ->setCellValue('H'.$i, $fila['irregularidad_general']) 
         ->setCellValue('I'.$i, $fila['detalle_edo_tramite']) 
         ->setCellValue('J'.$i, $fila['inicio_frr']); 

     $i++; 
 } 
  
 //Asignamos el ancho de las columnas de forma automática en base al contenido 
 for($i = 'A'; $i <= 'D'; $i++){ 
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE); 
}  

// Se asigna el nombre a la hoja 
$objPHPExcel->getActiveSheet()->setTitle('Prueba'); 
  
// Se activa la hoja para que sea la que se muestre cuando el archivo se abre 
$objPHPExcel->setActiveSheetIndex(0); 

// Inmovilizar paneles 
//$objPHPExcel->getActiveSheet(0)->freezePane('A4'); 
//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4); 

// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007 
  
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$name = 'reportes/xyz4z.xlsx';
$objWriter->save($name);


exit; 
} 


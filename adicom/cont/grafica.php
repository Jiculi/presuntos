<?php
 require_once ('JPGRAPH/src/jpgraph.php');
 require_once ('JPGRAPH/src/jpgraph_bar.php');

 $mysqli= new mysqli("localhost","root", "root", "asf");

if($mysqli->connect_errno){
   // echo "Fallo al conectar a MySQL:(". $mysqli->connect_errno.")". $mysqli->connect_errno;
}
$A=0; $B=0; $C=0; $D=0; $DG=0; $sd=0;

$resultado=$mysqli->query("select num_accion, detalle_edo_tramite, direccion from pfrr ");

$usuarios=array("A","B","C","D","DG");
$horas=array($A,$B,$C,$D,$DG,$sd);

while($row=$resultado->fetch_array()){
	if($row['direccion'] == "A"){ $A+=1; }
	if($row['direccion'] == "B"){ $B+=1; }
	if($row['direccion'] == "C"){ $C+=1; }
	if($row['direccion'] == "D"){ $D+=1; }
	if($row['direccion'] == "DG"){ $DG+=1; }
	if($row['direccion'] == "0"){ $sd+=1; }
}

$usuarios=array("A","B","C","D","DG","Sin dirección");
$horas=array($A,$B,$C,$D,$DG,$sd);

// Creamos el grafico
$grafico = new Graph(600, 500, 'auto');
$grafico->SetScale("textint");
$grafico->title->Set("Ejemplo de Grafica");
$grafico->xaxis->title->Set("Direcciones");
$grafico->xaxis->SetTickLabels($usuarios);
$grafico->yaxis->title->Set("Total");
$barplot1 =new BarPlot($horas);
// Un gradiente Horizontal de morados
$barplot1->SetFillGradient("#BE81F7", "#E3CEF6", GRAD_HOR);
// 30 pixeles de ancho para cada barra
$barplot1->SetWidth(30);
$grafico->Add($barplot1);
$grafico->Stroke();
?>

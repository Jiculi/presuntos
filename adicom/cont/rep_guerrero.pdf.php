<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
date_default_timezone_set("America/Mexico_City");

require_once("../includes/iclases.php");
require_once("../includes/funciones.php");
require('../PDF/fpdf.php');
require('../PDF/jlpdf.php');
error_reporting(E_ERROR);
$iconexion = new iconexion;
$iconexion->iconectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$valor = $_POST['valor'];
$direccion = $_SESSION['direccion'];
$nivel = $_SESSION['nivel'];
$usuario = $_SESSION['usuario'];
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//---------------------------------------------------------------
class PDF extends FPDF
{
	//Cabecera de página
	function Header()
	{			
		$this->SetFont('arial','',8);
	   
	   
	   
		//Título
		$this->Cell(0,5,utf8_decode('AUDITORÍA SUPERIOR DE LA FEDERACIÓN'),0,1,'C');
		$this->Cell(0,5,utf8_decode('UNIDAD DE ASUNTOS JURÍDICOS '),0,1,'C');
		$this->Cell(0,5,utf8_decode('DIRECCIÓN GENERAL DE RESPONSABILIDADES A LOS RECURSOS FEDERALES EN ESTADOS Y MUNICIPIOS '),0,1,'C');
		$this->SetFont('arial','B',10);
		
		$this->Cell(0,5,utf8_decode('REPORTE DEL ESTADO DE GUERRERO'),0,1,'C');
		$this->SetFont('arial','',10);
		$this->Cell(0,5,'AL '.date("d").' DE '.strtoupper(dameMes(date("n"))).' DE '.date("Y").' - '.date("h:i:s"),0,1,'C');
		
		//ruta img , izq , top , ancho , alto
		$this->Image('../images/logoasfok.jpg',5,10,40,0,'JPG'); 
		////$this->Image('../images/adicomtxt.jpg',10,5,20,0,'JPG'); 
		
		//$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'L');

		//-------------------------------------
	
	}//END HEADER
	//---------------------- CLASE PIE DE PAGINA --------------------------------
	function Footer()
		{
			// Go to 1.5 cm from bottom
			$this->SetY(-15);
			// Select Arial italic 8
			$this->SetFont('Arial','',5);
			// Print centered page number
			$this->Cell(0,10,'DGR ',0,0,'L');
			$this->Cell(0,10,utf8_decode('REPORTE DEL ESTADO DE GUERRERO  - Página ').$this->PageNo(),0,0,'R');
		}
}//END CLASS
//-------------------- COMIENZO DE HOJA ---------------------
$pdf=new PDF();
$pdf->AddPage("L");
$pdf->AliasNbPages();
$pdf->Ln();	
//--------------- CONFIGURACION CELDAS ----------------------
// ancho bordes
$bt = 0.2;
$bc = 0.1;
// titulos
$altT = 7;
$ancT = 38;
$ancEf= 50;
$ancDir= 10;
$ancFondo= 50;
$ancImp=30;
$ancCP=10;
$ancAcc=60;
$ancInt=23;
$ancFec=20;
// celdas
$altC = 5;
$ancC = 32;
$ancUaa =17;
$bordes = "TLBR";
// posicion
$x = 30;
$y = 41;
$y1 = 53;
//--------------- CONFIGURACION HOJA ------------------------
$pdf->SetFont('arial','B',8);
$pdf->SetTextColor(5);
$pdf->SetLineWidth($bc);
//------------------------------------------------------------------------------
//-------------------- ENCABEZADOS ---------------------------------------------
//------------------------------------------------------------------------------
// relleno de celda
$pdf->SetFillColor(154, 203,225);

	/*$pdf->SetXY($x,$y);
	$pdf->MultiCell($ancCP,10,utf8_decode("CP"),$bordes,'C',1);
	*/
	$pdf->SetXY($x-20,$y-2);
	$pdf->MultiCell($ancEf-41,10,utf8_decode("C P"),$bordes,'C',1);

$pdf->SetXY($x-61+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-41,10,utf8_decode("AUDÍTORIA "),$bordes,'C',1);
	
	$pdf->SetXY($x-102+$ancEf+$ancAcc+0,$y-2);
	$pdf->MultiCell($ancAcc-15,10,utf8_decode("ENTIDAD FISCALIZADA"),$bordes,'C',1);
	
$pdf->SetXY($x-117+$ancEf+$ancAcc+$ancAcc,$y-2);
	$pdf->MultiCell($ancAcc-43,10,utf8_decode("FONDO"),$bordes,'C',1);
	
	$pdf->SetXY($x+20+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-45,10,utf8_decode("P O"),$bordes,'C',1);
	
	$pdf->SetXY($x+41+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-15,10,utf8_decode("IRREGULARIDAD "),$bordes,'C',1);
	
	$pdf->SetXY($x+86+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-19,10,utf8_decode("PRESUNTO RESPONSABLE"),$bordes,'C',1);
	
	$pdf->SetXY($x+127+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-19,10,utf8_decode("CARGO"),$bordes,'C',1);
	
	$pdf->SetXY($x+168+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-40,5,utf8_decode("ESTADO PROCESAL"),$bordes,'C',1);
	
	$pdf->SetXY($x+188+$ancEf,$y-2);
	$pdf->MultiCell($ancAcc-38.5,10,utf8_decode("IMPORTE"),$bordes,'C',1);	
	

//------------------------------------------------------------------------------
//------------------------------- SACAMOS DATOS DE BD --------------------------
//------------------------------------------------------------------------------

$recurso= " select * from guerrero		
						";


$sql = $iconexion->iselect($recurso,false);
//$const = mysqli_fetch_array($sql);

	 while($const = mysqli_fetch_array($sql))	
	{
				
				
		$cuenta_pu=$const['cp'];
		$Aud=$const['auditoria'];
		$Ente=$const['entidad'];
		
		$Fondo=$const['fondo'];
		
		$PO=$const['po'];
		$Irregularidad=$const['irregularidad_general'];
		$Presunto=$const['acuseNotEntidad'];		
		
		$ofi_not_icc=$const['oficioNotOIC'];
		$fecha_not_icc=fechaNormal($const['fechaNotOIC']);
		$acuse_not_icc=fechaNormal($const['acuseNotOIC']);
		
		    
	//$xo=array($fila);	
	$entidades=array_count_values($xo);
	$re=$entidades['entidad'];
	printf($re);
	

		$num++;
		$cont++;
		$pdf->SetFont('arial','',8);
		$pdf->SetTextColor(5);
		$pdf->SetFillColor(255,255,255);


{
//*****************************
		$pdf->SetFont('arial','',8);
		if($num<=9){
		$pdf->SetXY(2,$y1);
		}
		else
		if($num>=10 and $num<=99){
		$pdf->SetXY(2,$y1);
		}else

		if($num >= 100 and $num < 999){ 
		$pdf->SetXY(2,$y1);}
		$pdf->MultiCell($ancDir,$altC,$num,'','C',1);
		
		/*$pdf->SetXY($x,$y1);
		$pdf->MultiCell($ancCP,$altC,$cp,$bordes,'R',1);
		*/
		$pdf->SetXY($x-20,$y1); 
		$pdf->MultiCell($ancEf-41,$altC,$cuenta_pu,$bordes,'C',1);
	
		$pdf->SetXY($x-61+$ancEf,$y1); 
		$pdf->MultiCell($ancAcc-41,$altC,$Aud,$bordes,'C',1);
		
		$pdf->SetXY($x-102+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-15,$altC,$Ente,$bordes,'L',1);

		$pdf->SetFont('arial','',7);
		$pdf->SetXY($x-57+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-43,$altC,$Fondo,$bordes,'C',1);
		$pdf->SetFont('arial','',8);
		
		$pdf->SetFont('arial','',7);
		$pdf->SetXY($x-40+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-45,$altC,$PO,$bordes,'L',1);
		$pdf->SetFont('arial','',8);
		
		$pdf->SetFont('arial','',5);
		$pdf->SetXY($x-19+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-15,$altC,$VARIABLE,$bordes,'C',1);
		$pdf->SetFont('arial','',8);

		
		$pdf->SetXY($x+26+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-19,$altC,$VARIABLE,$bordes,'C',1);
		
		$pdf->SetXY($x+67+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-19,$altC,$VARIABLE,$bordes,'R',1);

		$pdf->SetXY($x+108+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-40,$altC,$VARIABLE,$bordes,'C',1);
				
		$pdf->SetXY($x+128+$ancEf+$ancAcc,$y1);
		$pdf->MultiCell($ancAcc-38.8,$altC,$VARIABLE,$bordes,'C',1);
		
		
}
	
		
		$y1=$y1+5;
		if($cont == 25) 
		{
			$pdf->AddPage('l');
			$cont=0;
			$y=41;
			$y1=50;
			$pdf->SetFont('arial','B',8);
			$pdf->SetTextColor(5);
			$pdf->SetLineWidth($bc);
$pdf->SetFillColor(154, 203,225);
	/*$pdf->SetXY($x,$y);
	$pdf->MultiCell($ancCP,10,utf8_decode("CP"),$bordes,'C',1);
	*/
	
	$pdf->SetXY($x-20,$y-4);
	$pdf->MultiCell($ancEf-34,5,utf8_decode("CUENTA PÚBLICA"),$bordes,'C',1);
	
$pdf->SetXY($x-54+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-41,10,utf8_decode("AUDÍTORIA "),$bordes,'C',1);
	
	$pdf->SetXY($x-95+$ancEf+$ancAcc+0,$y-4);
	$pdf->MultiCell($ancAcc-10,10,utf8_decode("ENTIDAD FISCALIZADA"),$bordes,'C',1);
	
$pdf->SetXY($x-105+$ancEf+$ancAcc+$ancAcc,$y-4);
	$pdf->MultiCell($ancAcc-47,10,utf8_decode("FONDO"),$bordes,'L',1);
	
	$pdf->SetXY($x+28+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-47,10,utf8_decode("P O"),$bordes,'C',1);
	
	$pdf->SetXY($x+41+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-15,10,utf8_decode("IRREGULARIDAD "),$bordes,'C',1);
	
	$pdf->SetXY($x+86+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-19,10,utf8_decode("P R"),$bordes,'C',1);
	
	$pdf->SetXY($x+127+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-19,10,utf8_decode("CARGO"),$bordes,'C',1);
	
	$pdf->SetXY($x+168+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-40,5,utf8_decode("ESTADO PROCESAL"),$bordes,'C',1);
	
	$pdf->SetXY($x+188+$ancEf,$y-4);
	$pdf->MultiCell($ancAcc-38.5,10,utf8_decode("IMPORTE"),$bordes,'C',1);	
		}

	}
	
//Recuadro DE COLORES con nota

//------------------------------------------------------------------------
//------------------------- imprimimos datos -----------------------------
//------------------------------------------------------------------------

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-------------------------------- TOTALES -------------------------------------
//$iconexion->iresult($sql);
//$iconexion->idesconectar();

// relleno y borde de celda
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(255,255, 255);

$pdf->SetXY(10,$y+20);
//$pdf->MultiCell("185","10","* 179 Pliegos recibidos el 29-08-2014  ",'L',1);

$pdf->Output();


?>



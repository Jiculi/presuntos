<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
date_default_timezone_set("America/Mexico_City");

require_once("../includes/iclases.php");
require_once("../includes/funciones.php");
require('../PDF/fpdf.php');
require('../PDF/jlpdf.php');

$iconexion = new iconexion;
$icon = $iconexion->iconectar();
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
		$this->SetFont('helvetica','B',10);
	   
		//Título
		$this->Cell(0,5,utf8_decode('AUDITORÍA SUPERIOR DE LA FEDERACIÓN'),0,1,'C');
		$this->Cell(0,5,utf8_decode('UNIDAD DE ASUNTOS JURÍDICOS '),0,1,'C');
		$this->Cell(0,5,utf8_decode('DIRECCIÓN GENERAL DE RESPONSABILIDADES A LOS RECURSOS FEDERALES EN ESTADOS Y MUNICIPIOS '),0,1,'C');
		$this->Cell(0,5,utf8_decode('REPORTE TRIMESTRAL DE LOS PLIEGOS DE OBSERVACIONES NOTIFICADOS DE LA CUENTA PÚBLICA 2012 '),0,1,'C');
		$this->Cell(0,5,'AL '.date("d").' DE '.strtoupper(dameMes(date("n"))).' DE '.date("Y").' - '.date("h:i:s"),0,1,'C');
		
		//ruta img , izq , top , ancho , alto
		$this->Image('../images/logoasfok.jpg',250,10,35,0,'JPG'); 
		//$this->Image('../images/adicomtxt.jpg',10,5,20,0,'JPG'); 
		
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
			$this->Cell(0,10,utf8_decode('REPORTE TRIMESTRAL DE LOS PLIEGOS DE OBSERVACIONES NOTIFICADOS DE LA CUENTA PÚBLICA 2012  - Página ').$this->PageNo(),0,0,'R');
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
// celdas ancho
$efAncho = 30;
$naAncho = 35;
$poAncho = 20;
$diAncho = 15;
$suAncho = 22;
$ofAncho = 22;
$feAncho = 22;
$uaAncho = 15;
$foAncho = 22;
// celdas Titulos alto
$efTAlto = 9;
$naTAlto = 9;
$poTAlto = 9;
$diTAlto = 9;
$suTAlto = 9;
$ofTAlto = 3;
$feTAlto1 = 3;
$feTAlto2 = 2.2;
$uaTAlto = 9;
$foTAlto = 9;
// celdas alto
$efAlto = 4.5;
$naAlto = 9;
$poAlto = 9;
$diAlto = 9;
$suAlto = 4.5;
$ofAlto = 4.5;
$feAlto = 9;
$uaAlto = 9;
$foAlto = 9;
$bordesT = "TLBR";
$bordesC = "LBR";
// posicion
$x = 3;
$y = 40;
//columna
$col1 = $x;
$col2 = $x+$efAncho;
$col3 = $x+$efAncho+$naAncho;
$col4 = $x+$efAncho+$naAncho+$poAncho;
$col5 = $x+$efAncho+$naAncho+$poAncho+$diAncho;
$col6 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho;
$col7 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho;
$col8 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+$feAncho;
$col9 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2);
$col10 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2)+$ofAncho;
$col11 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2)+$ofAncho+$feAncho;
$col12 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2)+$ofAncho+($feAncho*2);
$col13 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2)+$ofAncho+($feAncho*2)+$uaAncho;
$col14 = $x+$efAncho+$naAncho+$poAncho+$diAncho+$suAncho+$ofAncho+($feAncho*2)+$ofAncho+($feAncho*2)+$uaAncho+$foAncho;
//--------------- CONFIGURACION HOJA ------------------------
$pdf->SetFont('arial','B',7);
$pdf->SetTextColor(5);
$pdf->SetLineWidth($bc);
//------------------------------------------------------------------------------
//-------------------- ENCABEZADOS ---------------------------------------------
//------------------------------------------------------------------------------
// relleno de celda
$pdf->SetFillColor(215,222,235);
	
$pdf->SetXY($col1,$y);
	$pdf->MultiCell($efAncho,$efTAlto,utf8_decode("Entidad Fiscalizada"),$bordesT,'C',1);
	
$pdf->SetXY($col2,$y);
	$pdf->MultiCell($naAncho,$naTAlto,utf8_decode("Accion"),$bordesT,'C',1);

$pdf->SetXY($col3,$y);
	$pdf->MultiCell($poAncho,$poTAlto,utf8_decode("Número PO"),$bordesT,'C',1);
	
$pdf->SetXY($col4,$y); 
	$pdf->MultiCell($diAncho,$diTAlto,utf8_decode("Dirección"),$bordesT,'C',1);
	
$pdf->SetXY($col5,$y);
	$pdf->MultiCell($suAncho,$suTAlto,utf8_decode("Subdirector"),$bordesT,'C',1);

$pdf->SetXY($col6,$y);
	$pdf->MultiCell($ofAncho,$ofTAlto,utf8_decode("Oficio de la Notificación a EF"),$bordesT,'C',1);

$pdf->SetXY($col7,$y);
	$pdf->MultiCell($feAncho,$feTAlto1,utf8_decode("Fecha del Oficio de Notificación a EF"),$bordesT,'C',1);

$pdf->SetXY($col8,$y);
	$pdf->MultiCell($feAncho,$feTAlto1,utf8_decode("Fecha de Acuse de Notificación a EF"),$bordesT,'C',1);

$pdf->SetXY($col9,$y);
	$pdf->MultiCell($ofAncho,$ofTAlto,utf8_decode("Oficio de la Notificación a la ICC"),$bordesT,'C',1);

$pdf->SetXY($col10,$y);
	$pdf->MultiCell($feAncho,$feTAlto2,utf8_decode("Fecha del Oficio de la Notificación a la ICC"),$bordesT,'C',1);

$pdf->SetXY($col11,$y);
	$pdf->MultiCell($feAncho,$feTAlto2,utf8_decode("Fecha de Acuse de la Notificación a la ICC"),$bordesT,'C',1);

$pdf->SetXY($col12,$y);
	$pdf->MultiCell($uaAncho,$uaTAlto,utf8_decode("UAA"),$bordesT,'C',1);

$pdf->SetXY($col13,$y);
	$pdf->MultiCell($foAncho,$foTAlto,utf8_decode("Fondo"),$bordesT,'C',1);
//------------------------------------------------------------------------------
//------------------------------- SACAMOS DATOS DE BD --------------------------
//------------------------------------------------------------------------------
$sqltxt = "SELECT * FROM po INNER JOIN po_historial ON po.num_accion = po_historial.num_accion WHERE po.cp = 2012 AND po.detalle_de_estado_de_tramite =6 AND po_historial.estadoTramite = 6 order by fechaNotEntidad asc, horaSistema asc ";
$sql = $iconexion->iselect($sqltxt,false);
$total = mysqli_num_rows($sql);
//------------------------------------------------------------------------------
// relleno y borde de celda
$pdf->SetFillColor(255,255,255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetFont('arial','',7);
$pdf->SetTextColor(5);

		
while($r = mysqli_fetch_array($sql))
{
	$y += 9;

	$query = "select * from fondos where num_accion = '".$r['num_accion']."' ";
	$exe = $iconexion->iselect($query,false);
	$fondo = mysqli_fetch_array($exe);
	
	$pdf->SetXY($col1,$y);
		$pdf->MultiCell($efAncho,$efAlto,$r['entidad_fiscalizada'],$bordesC,'C',1);
	
	$pdf->SetXY($col2,$y);
		$pdf->MultiCell($naAncho,$naAlto,$r['num_accion'],$bordesC,'C',1);
	
	$pdf->SetXY($col3,$y);
		$pdf->MultiCell($poAncho,$poAlto,$r['numero_de_pliego'],$bordesC,'C',1);
	
	$pdf->SetXY($col4,$y);
		$pdf->MultiCell($diAncho,$diAlto,$r['direccion'],$bordesC,'C',1);
	
	$pdf->SetXY($col5,$y);
		$pdf->MultiCell($suAncho,$suAlto,idameDirector($icon,$r['direccion']),$bordesC,'C',1);
	
	$pdf->SetXY($col6,$y);
		$pdf->MultiCell($ofAncho,$ofAlto,$r['oficioNotEntidad'],$bordesC,'C',1);
	
	$pdf->SetXY($col7,$y);
		$pdf->MultiCell($feAncho,$feAlto,$r['fechaNotEntidad'],$bordesC,'C',1);
	
	$pdf->SetXY($col8,$y);
		$pdf->MultiCell($feAncho,$feAlto,$r['acuseNotEntidad'],$bordesC,'C',1);
	
	$pdf->SetXY($col9,$y);
		$pdf->MultiCell($ofAncho,$ofAlto,$r['oficioNotOIC'],$bordesC,'C',1);
	
	$pdf->SetXY($col10,$y);
		$pdf->MultiCell($feAncho,$feAlto,$r['fechaNotOIC'],$bordesC,'C',1);
	
	$pdf->SetXY($col11,$y);
		$pdf->MultiCell($feAncho,$feAlto,$r['acuseNotOIC'],$bordesC,'C',1);
	
	$pdf->SetXY($col12,$y);
		$pdf->MultiCell($uaAncho,$uaAlto,$fondo['UAA'],$bordesC,'C',1);
	
	$pdf->SetXY($col13,$y);
		$pdf->MultiCell($foAncho,$foAlto,$fondo['fondo'],$bordesC,'C',1);
	
}



// relleno y borde de celda
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(255,255, 255);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
//-------------------------------- TOTALES -------------------------------------
//$iconexion->iresult($sql);
//$iconexion->idesconectar();

$pdf->Output();


?>



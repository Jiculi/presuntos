<?php 
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
require_once("../includes/enLetras.class.php");
require('../PDF/fpdfx.php');

require('../fecha.php');

$conexion = new conexion;
$conexion->conectar();
//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------
if($_REQUEST['consultaOficio'] == 1){
	$sql = $conexion->select("SELECT * FROM oficios_pdf WHERE oficio LIKE '".trim($_REQUEST['numFolio'])."' LIMIT 1");
	$r = mysql_fetch_array($sql);
	
	$_REQUEST['fo'] = $r['oficio'];
	$_REQUEST['na'] = $r['num_accion'];
	$_REQUEST['po'] = $r['po'];
	$_REQUEST['cp'] = $r['cp'];
	$_REQUEST['ef'] = $r['ef'];
	$_REQUEST['mm'] = $r['monto'];
	$_REQUEST['ua'] = $r['UAA'];
	$_REQUEST['dir'] = $r['director_UAA'];
	$_REQUEST['car'] = $r[''];
	$_REQUEST['nRe'] = $r['destinatario'];
	$_REQUEST['cRe'] = $r['cargo_destinatario'];
	$_REQUEST['dRe'] = $r['dependencia_destinatario'];
	$_REQUEST['fOf'] = $r['fecha_po'];
	$_REQUEST['foj'] = $r['fojas'];
	$_REQUEST['fSi'] = $r['fecha_sistema'];
	$_REQUEST['hSi'] = $r['hora_sistema'];
	$_REQUEST['ini'] = $r['iniciales'];
	$_REQUEST['folioef'] = $r['folioef'];
	$_REQUEST['fechaofi'] = $r['fechaofi'];
	$_REQUEST['acuse'] = $r['acuse'];
	$_REQUEST['folioicc'] = $r['folioicc'];
	$_REQUEST['gobernador'] = $r['gobernador'];
	$_REQUEST['cargo'] = $r['cargo'];
	$_REQUEST['titular'] = $r['titular'];
	$_REQUEST['cargoicc'] = $r['cargoicc'];
	
}
//if($_REQUEST['mm'] = '' || $_REQUEST['mm'] == NULL) $_REQUEST['mm'] = 0;

//------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------

$GLOBALS['fechaCompleta'] = ponFecha(fechaNormal($_REQUEST['fSi']));

class PDF extends FPDF
{
	//Cabecera de página
	function Header()
	{
		$vinIzq = 110;
		//Título
		$this->SetFont('helvetica','',9);
		$this->SetXY($vinIzq,0);
	//	$this->Cell(190,5,utf8_decode('"2014, Año de Octavio Paz."'),0,1,'L');
		//Título
		$this->SetXY($vinIzq,2);
		$this->SetFont('helvetica','B',10);
		$this->Cell(110,15,utf8_decode('UNIDAD DE ASUNTOS JURÍDICOS'),0,1,'L');
		$this->SetXY($vinIzq,15);
		$this->Cell(100,3,utf8_decode('DIRECCIÓN GENERAL DE RESPONSABILIDADES'),0,1,'L');
		$this->SetXY($vinIzq,18);
		$this->Cell(100,5,utf8_decode('A LOS RECURSOS FEDERALES EN ESTADOS'),0,1,'L');
		$this->SetXY($vinIzq,22);
		$this->Cell(100,5,utf8_decode('Y MUNICIPIOS'),0,1,'L');
		$this->SetXY($vinIzq,26);
		$this->Cell(100,10,utf8_decode('OFICIO: '.$_REQUEST['fo']),0,1,'L');

		$this->SetXY($vinIzq,35);
		$this->SetFont('helvetica','B',10);
		$this->Cell(100,5,utf8_decode('ASUNTO: '),0,0,'L');
		$this->SetXY($vinIzq,35);
		$this->SetFont('helvetica','',10);
		$this->SetXY($vinIzq+20,35);
		$this->Cell(100,5,utf8_decode('Se comunica notificación del PO, fecha de'),0,1,'L');
		$this->SetXY($vinIzq,39);
		$this->Cell(100,5,utf8_decode('vencimiento del plazo para su solventación y se'),0,1,'L');
		$this->SetXY($vinIzq,43);
		$this->Cell(100,5,utf8_decode('devuelve ET.'),0,1,'L');
		//$this->SetX($vinIzq + 19);
		//$this->Cell(100,5,utf8_decode('número '.$_REQUEST['po']).".",0,1,'L');
		$this->SetXY($vinIzq,47);
		$this->SetFont('helvetica','',10);
		$this->Cell(100,10,utf8_decode("México, D.F., a ".$GLOBALS['fechaCompleta']),0,1,'L');
		
		$this->Image('../images/logoformato.jpg',20,10,70,0,'JPG');
		//-------------------------------------
	
	}//END HEADER
	//---------------------- CLASE PIE DE PAGINA --------------------------------
	function Footer()
		{
			$this->SetXY(100,249);
			$this->SetFont('arial','B',8);
			$this->Cell(180,3,utf8_decode("SE63T006"),0,1,'C');

			$this->SetXY(20,247);
			$this->SetFont('arial','',8);
			$this->Cell(180,3,utf8_decode($_REQUEST['ini']),0,1,'L'); 
			
			$this->SetXY(20,252);
			//$this->SetFont('Times','BI',12);
			$this->SetFont('BrittanicBI','',11);
			$this->Cell(190,3,utf8_decode("\"Este documento forma parte de un expediente clasificado como reservado\""),0,1,'C');

			//dibujamos linea 
			$this->SetLineWidth(.2);
			$this->Line(20,256,200,256,'D');

			$this->SetXY(20,257);
			$this->SetFont('arial','',8);
			$this->Cell(180,3,utf8_decode("Carretera Picacho Ajusco, Número 167, Col. Ampliación Fuentes del Pedregal, Delegación Tlalpan, C.P. 14140, México, D.F. "),0,1,'C');
			$this->SetXY(20,260);
			$this->Cell(180,3,utf8_decode("Tel.: 52.00.15.00, e-mail: asf@asf.gob.mx"),0,1,'C');
			
			
			$this->Image('../images/logoasfPie.jpg',130,265,70,0,'JPG');
			//$this->Cell(0,10,utf8_decode('COMPORTAMIENTO DE LOS PROCEDIMINETOS PARA EL FINCAMIENTO DE RESPONSABILIDADES RESARCITORIAS - Página ').$this->PageNo(),0,0,'R');
		}
}//END CLASSS
//-------------------- COMIENZO DE HOJA ---------------------
$pdf=new PDF();

$pdf->AddFont('BrittanicBI','','BrittanicBI.php');
$pdf->AddPage("P","A4");
$pdf->SetMargins(22.5,1,1);
$pdf->AliasNbPages();
//---------------- RECTANGULO IDENTIFICACION DEL DODNANTE --------------------	
	/*
	$pdf->SetLineWidth(.4);
	$pdf->Rect(10,48,190,55,'D');
	$pdf->SetLineWidth(.2);
	*/
	//var urlCadena = "fo="+fo+"po="+po+"ef="+ef+"mm="+mm+"ua="+ua+"dir="+dir+"car="+car+"nRe="+nRe+"cRe="+cRe+"dRe="+dRe+"fOf="+fOf;
	//------------------- A QUIEN VA DIRIGIDO ----------------------
	$pdf->SetY(60);
	$pdf->SetFont('arial','B',12);
	$pdf->Cell(120,5,utf8_decode(($_REQUEST['nRe'])),0,1,'L');
	$pdf->MultiCell(100,5,utf8_decode((html_entity_decode(str_replace("\\","",$_REQUEST['cRe'])))),0,'L');
	$pdf->Cell(180,5,"Presente",0,1,'L');
	$pdf->Ln(3);
	//------------------- TEXTO ----------------------
	$pdf->SetFont('arial','',10);
	
	//numero-----------------
	$V=new EnLetras();
	$cantLetra = ucfirst(mb_strtolower($V->ValorEnLetras(str_replace(",","",$_REQUEST['mm']),"pesos"),'UTF-8'))." M.N.";
	//-----------------------
	
	$choro = "Hago referencia al Pliego de Observaciones número ".$_REQUEST['po'].", del ".ponFecha($_REQUEST['fOf']).", identificado con la clave ".$_REQUEST['na'].", por un monto de $".@number_format(str_replace(",","",$_REQUEST['mm']),2)." (". $cantLetra ."), formulado a la ".$_REQUEST['ef']." con motivo de la fiscalización de la Cuenta Pública correspondiente al ejercicio de ".$_REQUEST['cp'].". \n\n";
	$choro .= "Sobre el particular, de conformidad con el artículo 35, fracción I del Reglamento Interior de la Auditoría Superior de la Federación, me permito hacer de su conocimiento que el día ".ponFecha($_REQUEST['acuse']).", esta área jurídica mediante los números de oficio  ".$_REQUEST['folioef']." y ".$_REQUEST['folioicc'].", notificó el referido PO a ".$_REQUEST['gobernador'].", en su carácter de ".str_replace(".","",$_REQUEST['cargo'])." y a ".$_REQUEST['titular'].", en su carácter de ".str_replace(".","",$_REQUEST['cargoicc']).", respectivamente.\n\n";
	$choro .= "Así mismo, en términos de lo dispuesto en el inciso 6), apartado IX. Notificación del Pliego de Observaciones, de los [i]\"Lineamientos para la Formulación y Notificación del Pliego de Observaciones, Aplicables para la AECF, la AED, la AETICC, la AEGF, la DGR y la DGR\"[/i], adjunto al presente, me permito remitir a usted, el ET correspondiente en ".$_REQUEST['foj']." fojas foliadas, al que se han glosado -antes del índice- un tanto con firma autógrafa del PO, así como los acuses de recibo originales de los citados oficios, conservándose en esta Dirección General a mi cargo, copia certificada de dichos documentos.\n\n";
	$choro .= "En virtud de lo anterior, hago de su conocimiento que el plazo improrrogable de 30 días hábiles a que se refiere el artículo 56 de la Ley de Fiscalización y Rendición de Cuentas de la Federación, para que la entidad fiscalizada proceda a su solventación dentro de dicho plazo, vence el día[b]".ponFecha(sumaDiasNoInhabiles($_REQUEST['acuse'],30)).".\n\n [/b]";
	$choro .= "Sin otro particular le envío un cordial saludo.";
	
	//$pdf->MultiCell(190,5,utf8_decode($choro),0,'J');
	$pdf->JLCell(utf8_decode($choro),180,'J');
	
	//--------------------- ATTE -------------------------------
	//--------------------- ATTE -------------------------------
	$vineizq = 10;
	$pdf->SetFont('arial','B',11);

	$pdf->SetXY($vineizq,205);
	$pdf->MultiCell(190,5,utf8_decode('Atentamente'),0,'C');
	$pdf->SetXY($vineizq,210);
	$pdf->MultiCell(190,5,utf8_decode('Director General'),0,'C');
	$pdf->SetXY($vineizq,225);
	$pdf->MultiCell(190,5,utf8_decode(ucwords('Lic. Rosa María Gutiérrez Rodríguez')),0,'C');
	//Oscar René
	//$pdf->MultiCell(190,5,utf8_decode(ucwords('Lic. Oscar R. Martínez Hernández')),0,'C');
	//ALDO GERARDO
	/*
	$pdf->SetFont('arial','B',11);
	$pdf->Ln(10);
	$pdf->SetX($vineizq);
	$pdf->MultiCell(190,5,utf8_decode('Lic. Aldo Gerardo Martínez Gómez'),0,'L');
	$pdf->SetX($vineizq);
	$pdf->MultiCell(190,5,utf8_decode('Director de Responsabilidades a los Recursos'),0,'L');
	$pdf->SetX($vineizq);
	$pdf->MultiCell(190,5,utf8_decode('Federales en Estados y Municipios "A"'),0,'L');
	
	$pdf->SetFont('arial','',5);
	$pdf->SetX($vineizq);
	$pdf->MultiCell(90,3,utf8_decode(('En suplencia por ausencia del Director General de Responsabilidades a los Recursos Federales en Estados y Municipios, con fundamento en el articulo 49 del Reglamento Interior de la Auditoría Superior de la Federación, publicado en el Diario Oficial de la Federación el 29 de abril de 2013.')),0,'J');
	*/
	
	//parte de abajo
	/*$pdf->SetFont('arial','BI',9);
	$pdf->Ln(10);
	$pdf->Cell(180,5,utf8_decode("ANEXO: Pliego de Observaciones número ".$_REQUEST['po']." con firma autógrafa."),0,1,'L');

	$pdf->SetFont('arial','',8);
	$pdf->Ln(2);
	$pdf->Cell(180,3,utf8_decode("C.c.p. Lic. Salim Arturo Orcí Magaña, Auditor Especial del Gasto Federalizado de la ASF."),0,1,'L'); 
	$pdf->Cell(180,3,"          ".utf8_decode($_REQUEST['dir']).", Director General de Auditoria a los Recursos Federales Transferidos \"".substr($_REQUEST['ua'],-1)."\" de la ASF.",0,1,'L');
	
	
	$pdf->SetFont('arial','',8);
	$pdf->Ln(8);
	$pdf->Cell(180,3,utf8_decode($_REQUEST['ini']),0,1,'L'); 
	//dibujamos linea 
	$pdf->SetLineWidth(.2);
	$pdf->Line(10,268,200,268,'D');
	*/
ob_end_clean();
 $pdf->Output();

?>


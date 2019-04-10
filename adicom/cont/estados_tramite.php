
<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script>
function imprSelec(muestra)
{
		var ficha=document.getElementById(muestra);
		var ventimp=window.open('Impresion de Estados','popimpr');
			
		ventimp.document.write(ficha.innerHTML);
		ventimp.document.close();
		ventimp.print();
		ventimp.close();
}

</script>
</head>

<body>

<div id="impresion" style="position:fixed; right:200px; z-index:1000">
	<a href="javascript:imprSelec('contenidoImprimir')" class="submit-login" style="-moz-border-radius:5p;-webkit-border-radius: 5px; border-radius: 5px;">
    <img src="images/printer.png" style="float:left; "/> 
    <div style="float:left; line-height:15px"> &nbsp;&nbsp;&nbsp; Imprimir</div> <div style="clear:both"></div> </a>
</div>

<div id="contenidoImprimir">


<?php
$sql = $conexion->select("SELECT * FROM estados_sicsa order by id_sicsa",false);

$tabla = "
		<table width='100%' cellpadding='0' cellspacing='0'> <tr>
		<th style='padding:5px'>ESTADO SICSA</th>
		<th style='padding:5px'>NO. ESTADO</th>
		<th style='padding:5px'>CONTROL INTERNO</th>
	"; 
 while($r = mysql_fetch_array($sql))
 {
	
	$sql2 = $conexion->select("SELECT * FROM estados_tramite WHERE id_sicsa = ".$r['id_sicsa']." and status = 1 ORDER BY orden",false);
	$ttrs = mysql_num_rows($sql2);
	$cont = 0;
	while($r2 = mysql_fetch_array($sql2))
	{
		if($r['id_sicsa'] == 1 || $r['id_sicsa'] == 2  || $r['id_sicsa'] == 3  || $r['id_sicsa'] == 4  || $r['id_sicsa'] == 5 ) 
		{
			$estiloTD1 = "background:#069; vertical-align: middle; padding:5px; color: white; font-weight:bold";
			$estiloTD2 = "background:#D9ECFF; padding:5px";

		}
		
		if($r['id_sicsa'] == 6 || $r['id_sicsa'] == 7 || $r['id_sicsa'] == 8)
		{
			 $estiloTD1 = "background:#390; vertical-align: middle; padding:5px; color: white; font-weight:bold ";
			 $estiloTD2 = "background:#CBFF97; padding:5px";
		}

		if($r['id_sicsa'] == 9  || $r['id_sicsa'] == 10 )
		{
			 $estiloTD1 = "background:#C60000; vertical-align: middle; padding:5px; color: white; font-weight:bold ";
			 $estiloTD2 = "background:#FBB; padding:5px";
		}
		
		if($r['id_sicsa'] == 100 )
		{
			 $estiloTD1 = "background:#ff8c00; vertical-align: middle; padding:5px; color: white; font-weight:bold ";
			 $estiloTD2 = "background:#ffddb4; padding:5px";
		}
		$cont++;
		if($cont == 1)$sicsa = '<td valign="middle" style="'.$estiloTD1.'" rowspan="'.$ttrs.'">'.htmlentities($r['estado_sicsa'], ENT_QUOTES, "UTF-8").'</td>';
		else $sicsa = "";

		$tabla .= '
				<tr>	
					'.$sicsa.'
					<td align="center" style="'.$estiloTD2.'">'.$r2['id_estado'].'</td>
					<td style="'.$estiloTD2.'">'.htmlentities($r2['detalle_estado'], ENT_QUOTES, "UTF-8").'</td>
					<td></td>
				</tr>
				';
	}
	$tabla .= '<tr><td colspan="5">&nbsp;</td></tr>';

 }
$tabla .= "</tr></table>"; 
//echo '<link href="../css/estilo.css" rel="stylesheet" type="text/css" />';
echo $tabla;
 ?>     
 
</div>
      
</body>
</html>
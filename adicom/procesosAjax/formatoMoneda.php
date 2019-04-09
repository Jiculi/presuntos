<?php
	$numero = 1 * $_REQUEST['numero'];
	//$numero = str_replace(",","",$_REQUEST['numero']);
	//$numero = str_replace(".","",$numero);
	
	if($numero < 1)
		echo "error";
	else 
		echo number_format($numero,2);
?>
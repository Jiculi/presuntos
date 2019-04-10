<html>
<head>
</head>

<body>
	<?php //echo "archivos/".html_entity_decode($_REQUEST['archivo']) ?>
    <embed src="<?php echo "archivos/".$_REQUEST['archivo'] ?>" type="application/pdf" width="100%" height="100%">

</body>
</html>
<!--
<HTML>
<BODY>
<embed src="archivo.pdf" type="application/pdf" width="100%" height="100%">
</BODY>
</HTML> 

-->
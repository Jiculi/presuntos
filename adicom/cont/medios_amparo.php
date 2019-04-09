<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases.php");
require_once("../includes/funciones.php");

$conexion = new conexion;
$conexion->conectar();
?>
<script>
//--------------- MENU CONF ----------------------------
r(function(){
	r('#mMedios>li').hover(
		function(){
		r('.menu_Medios',this).stop(true,true).slideDown();
		},
		function(){
		r('.menu_Medios',this).slideUp();
		}
	);
});
function muestraDivEdo(id)
{
	$$(".divsEdos").hide();
	$$("#divIntro").hide();
	//$$(".menu_Medios").slideUp();
	$$(".menu_Medios").fadeOut();
	$$("#"+id).fadeIn();
}
</script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<ul id="mMedios" class="mMedios">
	<li>Amparo
        <ul class='menu_Medios'>
        <?php
			$sql = $conexion->select("SELECT * FROM estados_tramite WHERE id_sicsa = 12 AND status = 1");
			
			while($r = mysql_fetch_array($sql))
			{
				echo "<li>".$r['detalle_estado']."</li>";
			}
		?>
        </ul>
   </li>
</ul>
<br />
<!-- ------------------------------------------------------------------ -->
<div class="resPasosMedios redonda10">

	<div align="center" id="divIntro">
    	<br /><br />
    	<img src='images/medio_amparo_big.png'>
        <br />
        <h3>Seleccione una opcion del menú.</h3>
        <br /><br />
    </div>

    <!-- -------------- EDO TRAMITE 33-------------------- -->
    <!-- -------------- EDO TRAMITE 33-------------------- -->
    <div id='' class="divsEdos">

    </div>

</div>


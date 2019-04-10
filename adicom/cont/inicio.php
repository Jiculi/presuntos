<script src="js/letras.js"></script>

<script src="js/assets/jquery.fittext.js"></script>
<script src="js/assets/jquery.lettering.js"></script>
<script src="js/assets/jquery.textillate.js"></script>
<!-- FLL  -- <script>hljs.initHighlightingOnLoad();</script>  -->

<link href="js/assets/animate.css" rel="stylesheet">

<script>
$$(document).ready( function() {
       // $$("#txtLimite").airport(['Fecha Límite CP2012 17/10/2014']);
	   $$("#txtLimite").textillate();
	   $$("#txtLimite").textillate({ 
	   	  //in: { effect: 'rollIn' },
		// the default selector to use when detecting multiple texts to animate
		//selector: '.texts',
		
		 // enable looping
		  loop: true,
		
		 // sets the minimum display time for each text before it is replaced
		  minDisplayTime: 2000,
		
		  // sets the initial delay before starting the animation
		  initialDelay: 0,
		
		  // set whether or not to automatically start animating
		  autoStart: true,
		
		  // custom set of 'in' effects. This effects whether or not the
		  // character is shown/hidden before or after an animation
		  inEffects: [],
		
		  // custom set of 'out' effects
		  outEffects: [ 'flip' ],
		
		  // in animation settings
		  in: {
			// set the effect name
			effect: 'fadeIn',
		
			// set the delay factor applied to each consecutive character
			delayScale: 1.5,
		
			// set the delay between each character
			delay: 50,
		
			// set to true to animate all the characters at the same time
			sync: false,
		
			// randomize the character sequence
			// (note that shuffle doesn't make sence in sync = true)
			shuffle: false
  },

  // out animation settings
  out: {
    effect: 'flip',
    delayScale: 1.5,
    delay: 50,
    sync: false,
    shuffle: false,
  }
		
		});
});
<?php $fechasCierre= array('2017-08-30','2017-09-14','2017-09-29','2017-10-13','2017-10-30','2017-11-14','2017-11-29','2017-12-15','2017-12-20');

$dia = '2017-11-29';

$f0= $fechasCierre[0];
$f1= $fechasCierre[1];
$f2= $fechasCierre[2];
$f3= $fechasCierre[3];
$f4= $fechasCierre[4];
$f5= $fechasCierre[5];
$f6= $fechasCierre[6];
$f7= $fechasCierre[7];
$f8= $fechasCierre[8];

$d0p = explode ('-',$dia);
 
if ($d0p[1]== 8 and $d0p[2]>= 16)
  
	{
	$fech= $f0;
	
	}
	
if ($d0p[1]== 9 and $d0p[2]<= 15)
  
	{
	$fech= $f1;
	
	}
 
 if ($d0p[1]== 9 and $d0p[2]>= 16)
  
	{
	$fech= $f2;
	
	}
	
if ($d0p[1]== 10 and $d0p[2]<= 15)
  
	{
	$fech= $f3;
	
	}
	
if ($d0p[1]== 10 and $d0p[2]>= 16)
  
	{
	$fech= $f4;
	
	}
	
if ($d0p[1]== 11 and $d0p[2]<= 15)
  
	{
	$fech= $f5;
	
	}
 if ($d0p[1]== 11 and $d0p[2]>= 16)
  
	{
	$fech= $f6;
	
	}
	
if ($d0p[1]== 12 and $d0p[2]<= 15)
  
	{
	$fech= $f7;
	}
	
if ($d0p[1]== 12 and $d0p[2]>= 16)
  
	{
	$fech= $f8;
	}
 

?>

</script>



<!-- Query para sacar el aviso-->
<?php  $conexion = new conexion;
$conn = $conexion->conectar();
$user= $_SESSION['usuario'];
	/*$sql = $conexion->select("SELECT fecha FROM usuarios where usuario= '$user' "); 
	$r = mysql_fetch_array($sql);
	$fecha= $r['fecha'];
	$hoy=date('Y-m-d');
	$dias_rest= strtotime($fecha);
	$hoyrs= strtotime($hoy);
	$rest_rs= (($hoyrs-$dias_rest)/86400);
	$cerrar=0;*/
if($rest_rs<=0)
{
	$cerrar=1;
	
	}


   ?>

<!--  start content-table-inner -->
<div id="content-table-inner">

    <div class="conTabla" >
    <!--  start product-table ..................................................................................... -->
        <center>
            <br /><br /><br /><br /><br />
            <h1 class="txth3">Advanced Internal Control and Monitoring System</h1>
            <br /><br />
            <img src="images/legal3.png" width="20%" />
            <br /><br /> 
			<br /><br /> 
            <!-------h1 id="txtLimite1" class="txth3" style="font-size:24px"" >Fecha Límite CP 2015 11/10/2017 </h1>
            <h1 id="txtLimite2" class="txth3" style="color: #FFFF33  !important  style="font-size:24px" ">Artículo 31 LFRCF  </h1>
    		<h1><font color="#FF0000" size="+1"><marquee bgcolor="#ffffff"  behavior="alternate" > < El proximo cierre de ADICOM es <?php // echo fechaNormal($fech)?> >
			</marquee></font></h1------>
        </center>
    <!--  end content-table  -->
    <br /><br /><br /><br /><br /><br /><br />
    <div class="clear"></div>

    </div>
    <!--  start related- -------------------- NOTIFICACIONES --------------------------------------------------- -->
    <div id="related-activities">
    
    <!-- INCLUIMOS NOTIFICACONES -->    
    <?php 
        require_once("cont/po_notificaciones.php");
		
		//echo $dt = "DGARFT%22A%22%2FDTNS%2F0126%2F2014";
		//echo "<br>".urldecode($dt);
		
    ?>
    <!-- INCLUIMOS NOTIFICACONES -->
    
    </div>
<!-- end related-activities -->
<div class="clear"></div>
</div>
<!--  end content-table-inner  -->


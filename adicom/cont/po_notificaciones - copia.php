<!--  start related-act-top -->
<!--
<div id="related-act-top"  class="sombra">
    <div>
		<?php
            echo "Avisos ".$_SESSION['direccion'];
        ?>
	</div>
</div>
-->
<!-- end related-act-top -->

<!--  start related-act-bottom -->
<div id="related-act-bottom">

    <!--  start related-act-inner -->
    <div id="related-act-inner">
    
    <?php if($_SESSION['direccion'] == "DG") {   ?>
        <div class="right">
            <h5>CRAL PO Pendientes <div id="numDevPen" class="redonda5">0</div></h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor. -->

            <ul class="greyarrow ulNoti" id="devolucionesPendientes">
                 <li><a href="#"> Cargando... </a></li> 
            </ul>
        </div>
       
        <div class="clear"></div>
        <div class="lines-dotted-short"></div>
        <!-- ----------------------------------------------------- -->
        <div class="right">
            <h5>CRAL PFRR Pendientes <div id="numDevPenPfrr" class="redonda5">0</div></h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor. -->

            <ul class="greyarrow ulNoti" id="devolucionesPendientesPfrr">
                 <li><a href="#"> Cargando... </a></li> 
            </ul>
        </div>
        
        <div class="clear"></div>
        <div class="lines-dotted-short"></div>
        
    <?php }else{ ?>
        <div class="right">
            <h5>CRAL PO<div id="numCralSol" class="redonda5">0</div></h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor. -->

            <ul class="greyarrow ulNoti" id="listaCralSol">
              <li><a href="#"> Cargando... </a></li>    
            </ul>
        </div>
        
        <div class="clear"></div>
        <div class="lines-dotted-short"></div>
        
        <div class="right">
            <h5>CRAL PFRR<div id="numCralSolPfrr" class="redonda5">0</div></h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor. -->

            <ul class="greyarrow ulNoti" id="listaCralSolPfrr">
              <li><a href="#"> Cargando... </a></li>    
            </ul>
        </div>
        
        <div class="clear"></div>
        <div class="lines-dotted-short"></div>
    <?php }?>

 
        <div class="right">
            <h5>Audiencias Pendientes <div id="numAud" class="redonda5">0</div></h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor. -->
            <ul class="greyarrow ulNoti"  id="listaAud">
                <li><a href="#"> Cargando... </a></li> 
            </ul>
        </div>
        
        <div class="clear"></div>
        <div class="lines-dotted-short"></div>
        
        <div class="right">
            <h5>Pendientes UAA <div id="numUAAPen" class="redonda5">0</div> </h5>
            <!-- Lorem ipsum dolor sit amet consectetur
            adipisicing elitsed do eiusmod tempor.-->
             <ul class="greyarrow ulNoti" id="UAAPendientes">
                 <li><a href="#"> Cargando... </a></li> 
            </ul>
        </div>
        <div class="clear"></div>
        
    </div>
    <!-- end related-act-inner -->
    <div class="clear"></div>

</div>
    <div class="clear"></div>

<!-- end related-act-bottom -->

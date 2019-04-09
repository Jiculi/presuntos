<?php
	//----------------------------------- ZONA HORARIA DE MEXICO --------------------------------------------------
	date_default_timezone_set("America/Mexico_City");
	//-------------------------------------------------- URL -------------------------------------------------------
	function damedominio(){
		$ruta = dameurl();	
		if(stripos($ruta, 'prueba') !== false) $url="http://".$_SERVER['HTTP_HOST']."/prueba";
		elseif(stripos($ruta, 'adicom/') !== false) $url="http://".$_SERVER['HTTP_HOST']."/adicom";
		else  $url="http://".$_SERVER['HTTP_HOST'];
		return $url;
	}
	//-------------------------------------------------- URL -------------------------------------------------------
	function dameurl(){
		$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
		return $url;
	}
	//-------------------------------------------------- URL -------------------------------------------------------
	function acentos($cadena) 
	{
		$no_permitidas= array ("&eacute;");
		$permitidas= array ("e");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
	//-------------------------------------------------- URL -------------------------------------------------------
	function quitar_espaciales($cadena) 
	{
		$no_permitidas= array ("�","á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
		$permitidas= array ("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
		$texto = str_replace($no_permitidas, $permitidas ,$cadena);
		return $texto;
	}
	//-------------------------------------------------- MENU -------------------------------------------------------
	//-------------------------------------------------- MENU -------------------------------------------------------
	function menu($direccion,$nivel,$soloReportes) 
	{
		if($direccion == "DG"  || $direccion == "A" || $direccion == "B" || $direccion == "C" || $direccion == "D" )
		{
		
			$menu = '
				<ul class="select menu" id="mInicio">
				<li><a href="#nogo" class="munuSup"><b>Pliegos de Observaciones</b><!--[if IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul class="submenu redonda5 ulPo">';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_po redonda3" href="?cont=po_escritorio"> <img src="images/pliego_po.png" /> Ver Acciones </a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_po redonda3" href="?cont=po_oficios"> <img src="images/volantes.png" /> <span>Oficios PO</span> </a></li>';
				if($soloReportes != 1 )$menu .= '<!-- <li><a class="menu_po redonda3" href="?cont=dg_mantenimiento"> <img src="images/volantes.png" /> <span>Oficios PO</span> </a></li> -->';
				//if($soloReportes != 1 )$menu .= '<li><a class="menu_po redonda3" href="?cont=po_otros_oficios"> <img src="images/otros_oficios.png" /> Otros Oficios </a></li>';
				$menu .= '<li><a class="menu_po redonda3" href="?cont=po_busqueda&reports='.$soloReportes.'"> <img src="images/search16.png" />Búsqueda Avanzada</a></li>';
				if($direccion == "DG" )
					$menu .= '<li><a class="mSetup redonda3" href="?cont=dg_bajasAnunciadas"> <img src="images/page_16_remove.png" /> Bajas Anunciadas </a></li>'; 
								if($soloReportes != 1 )$menu .= '<li><a class="menu_po redonda3" href="?cont=ayuda_po"> <img src="images/FAQ.png" />Ticket</a></li>';
		
				$menu .= '
				</ul>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
				</ul>
				
				<div class="nav-divider">&nbsp;</div>
				';
		}

				$menu .= '	
				<ul class="select menu" id="mInicio">
				<li><a href="#nogo" class="munuSup"><b>Procedimiento Resarcitorio</b><!--[if IE 7]><!--></a><!--<![endif]-->
				<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul class="sub submenu redonda5 ulPfrr">';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=pfrr_escritorio"> <img src="images/pliego_pfrr.png" /> <span> Ver Acciones </span></a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=frLista"> <img src="images/pliego_pfrr.png" /> <span> Ver Prescripciones </span></a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=frListaVencimiento"> <img src="images/pliego_pfrr.png" /> <span> Ver Vencimiento </span></a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=frListaPlazo"> <img src="images/pliego_pfrr.png" /> <span> Control de Emisón de Resoluciones </span></a></li>';
				
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=pfrr_oficios"> <img src="images/volantes.png" /> <span>Oficios PFRR</span> </a></li>';
				//if($soloReportes != 1 )$menu .= ' <li><a class="menu_pfrr redonda3" href="?cont=pfrr_muestra_otros_oficios"> <img src="images/otros_oficios.png" /> <span> Otros Oficios</span> </a></li> ';
				if($soloReportes != 1 ) $menu .= '<li><a class="menu_pfrr redonda3" href="?cont=pfrr_presuntos_principal"><img src="images/presuntos.png" /> <span>Buscar Responsables</span></a></li>';
				if($soloReportes != 1 ) $menu .= '<li><a class="menu_pfrr redonda3" href="?cont=presuntosLista"><img src="images/presuntos.png" /> <span>Buscar Presuntos</span></a></li>';
				$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=pfrr_busqueda&reports='.$soloReportes.'"><img src="images/search16.png" /><span>Búsqueda Avanzada</span></a></li>';
				if($soloReportes != 1 ) $menu .= '<li><a class="menu_pfrr redonda3" href="?cont=ayuda_pfrr"><img src="images/faqpfrr.png" /> <span>Ticket</span></a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=controlPFRR"> <img src="images/volantes.png" /> <span>Indicadores PFRR</span> </a></li>';
				if($soloReportes != 1 )$menu .= '<li><a class="menu_pfrr redonda3" href="?cont=controlEntidad"> <img src="images/volantes.png" /> <span>Imformación por Entidad</span> </a></li>';
				

				$menu .= '	</ul>
				<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>
				</ul>';

				if($direccion == "DG" || $direccion == "A" || $direccion == "B" || $direccion == "C" || $direccion == "D")
				{
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#" class="munuSup"><b>Medios Impugnación</b><!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul class="sub submenu redonda5 ulMd">';
									 if($soloReportes != 1 && $direccion == "DG" )$menu .= '<li><a class="menu_md redonda3" href="?cont=medios_actores"> <img src="images/medio_reconcideracion_small.png" /> <span> Ver Actores </span> </a>';
									if($soloReportes != 1 )$menu .= '<li><a class="menu_md redonda3" href="#"> <img src="images/medio_actores_small.png" /> <span> Recurso de Reconsideración </span> </a>
																		<ul class="submenu2 redonda5">
																			<li> <a class="menu_md redonda3" href="?cont=medios_rr_actores"> <img src="images/actor.png" /> Ver Actores </a> </li>
																			<li> <a class="menu_md redonda3" href="?cont=medios_rr_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
																			<li> <a class="menu_md redonda3" href="?cont=mediosrr_busqueda&reports='.$soloReportes.'"> <img src="images/search16.png" /> Búsqueda Avanzada </a> </li>
																			
																			<li> <a class="menu_md redonda3" href="?cont=ayuda_rr"><img src="images/FAQrr.png" /> <span>Ticket</span></a> </li>
																		</ul>
																	</li>';
									if($direccion == "DG" || $direccion == "A" || $direccion == "D")
						/*			if($soloReportes != 1 )$menu .= '<li><a class="menu_md redonda3" href="#"> <img src="images/medio_nulidad_small.png" /> <span> Juicio de Nulidad </span> </a>
																		<ul class="submenu2 redonda5">
																		
																		   <li> <a class="menu_md redonda3" href="?cont=juicios_inserta"> <img src="images/registro_nuevo.png" /> Nuevo Juicio </a> </li>
																			<li> <a class="menu_md redonda3" href="?cont=juicios"> <img src="images/actor.png" /> Ver Actores </a> </li>
																			<li> <a class="menu_md redonda3" href="?cont=medios_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
																			<!---li> <a class="menu_md redonda3" href="?cont=rr_general"> <img src="images/book_red.png" /> Reporte General </a> </li--->
																		</ul>
																	</li> ';
																	*/

																		$menu .= '<li> <a class="menu_md redonda3" href="?cont=juiciosActores"> <img src="images/pliego_po.png" /> Lista Juicios </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=juiciosOficiosLista"> <img src="images/vol_pfrr.png" /> Lista Oficios </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=juiciosVolantesLista"> <img src="images/doc_pink.png" /> Lista Volantes </a> </li>

																		
																		';


																		$menu .= '<li> <a class="menu_md redonda3" href="?cont=juiciosSeguimiento"> <img src="images/doc_orange.png" /> Juicios Contenciosos Administrativos </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=juiciosRRFlista"> <img src="images/pliego_po.png" /> Recursos Revisión Fiscal </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=juicioADlista"> <img src="images/pliego_po.png" /> Amparos Directos </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=AmparosInLista"> <img src="images/volantes.png" /> Amparos Indirectos </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=juiciosReporteGeneral"> <img src="images/book_red.png" /> Juicios Reporte General </a> </li>
																		<li> <a class="menu_md redonda3" href="?cont=controlv3"> <img src="images/book_red.png" /> Indicadores </a> </li>

																		
																		';
																	
																	
																	if((  $_SESSION['usuario'] == "fllamas") OR (  $_SESSION['usuario'] == "eeflores")){

								
																	}								
								




									/*if($soloReportes != 1 )$menu .= '<li><a class="menu_md redonda3" href="?cont=amparo_escritorio"> <img src="images/medio_amparo_small.png" /> <span> Juicio de Amparo </span> </a>
																		<ul class="submenu2 redonda5">
																			<li> <a class="menu_md redonda3" href="#"> <img src="images/actor.png" /> Ver Actores </a> </li>
																			<li> <a class="menu_md redonda3" href="#"> <img src="images/book_red.png" /> Oficios </a> </li>
																		</ul>
																	</li>';/*
									/*0000000if($soloReportes != 1 )$menu .= '<li><a class="menu_md redonda3" href="?cont=revision_escritorio"><img src="images/medio_revision_small.png" /> <span> Recurso de Revisión </span></a>
																		<ul class="submenu2 redonda5">
																			<li> <a class="menu_md redonda3" href="#"> <img src="images/actor.png" /> Ver Actores </a> </li>
																			<li> <a class="menu_md redonda3" href="#"> <img src="images/book_red.png" /> Oficios </a> </li>
																		</ul>
																	</li>';
									//if($soloReportes != 1 ) $menu .= '<li><a class="menu_md redonda3" href="?cont=ayuda_rr"><img src="images/faqrr.png" /> <span>Ticket</span></a></li>';*/
					$menu .= '</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
				}
				/*
				//--------------------------------------------------- MENU USUARIOS DIRECCION C -----------------------------------------
				//--------------------------------------------------- MENU USUARIOS DIRECCION C -----------------------------------------
				if($direccion == "XXX")
				{
					//--------------------------------------------------------------------------
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b>Recurso de Reconsideración</b><!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul class="sub submenu redonda5 ulMd">
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_actores"> <img src="images/actor.png" /> Ver Actores </a> </li>
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
					//--------------------------------------------------------------------------
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b> Juicio de Nulidad </b><!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul class="sub submenu redonda5 ulMd">
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_actores"> <img src="images/actor.png" /> Ver Actores </a> </li>
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
					//--------------------------------------------------------------------------
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b> Juicio de Amparo </b><!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul class="sub submenu redonda5 ulMd">
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_actores"> <img src="images/actor.png" /> Ver Actores </a> </li>
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
					//--------------------------------------------------------------------------
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b> Recurso de Revisión </b><!--[if IE 7]><!--></a><!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
								<ul class="sub submenu redonda5 ulMd">
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_actores"> <img src="images/actor.png" /> Ver Actores </a> </li>
									<li> <a class="menu_md redonda3" href="?cont=medios_rr_oficios"> <img src="images/book_red.png" /> Oficios </a> </li>
								</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
				}
				*/
				if($direccion == "DG" || $direccion == "A" || $direccion == "B" || $direccion == "C" || $direccion == "D")
				{
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b>Solicitud Aclaración</b><!--[if IE 7]><!--></a><!--<![endif]-->
							<ul class="sub submenu redonda5 ulOpi">';
									if($soloReportes != 1 )$menu .= '<li><a class="menu_opi redonda3" href="?cont=opiniones_escritorio"> <img src="images/file_legal.png" /> <span> Ver SA </span> </a></li>';
									if($soloReportes != 1 )$menu .= '<li> <a class="menu_opi redonda3" href="?cont=opiniones_oficios"> <img src="images/doc_legal.png" /> Oficios </a> </li>';
									if($soloReportes != 1 )$menu .= '<li> <a class="menu_opi redonda3" href="?cont=sa_busqueda&reports='.$soloReportes.'"> <img src="images/search16.png" />Búsqueda Avanzada</a></li>';
									if($soloReportes != 1 )$menu .= '<li><a class="menu_opi redonda3" href="?cont=ayuda_opiniones"> <img src="images/FAQ.png" />Ticket</a></li>';
							{		
									
									$menu .= '</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
				}
				
				
				
				
				//if($direccion == "DG" || $direccion == "A" || $direccion == "B" || $direccion == "C" || $direccion == "D"||direccion == "S")
				//{
				//	$menu .= '
					//<div class="nav-divider">&nbsp;</div>
					
					//<ul class="select menu" id="mInicio">
					//	<li><a href="#nogo" class="munuSup"><b>Envío</b><!--[if IE 7]><!--></a><!--<![endif]-->
							//<ul class="sub submenu redonda5 ulAdm">';
								//	if($soloReportes != 1 )$menu .= '<li><a class="menu_adm redonda3" href="?cont=correspondencia_oficios"> <img src="images/volantes.png" /> <span> Ver Correspondencia </span> </a></li>';
																	
					//$menu .= '</ul>
						//	<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						//</li>
					//</ul>';
			//	}
			
									
					$menu .= '</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
				}
				
				$menu .= '
				<div class="nav-divider">&nbsp;</div>
				
				<ul class="select menu" id="mInicio">
					<li><a href="#nogo" class="munuSup"><b>Reporte</b><!--[if IE 7]><!--></a><!--<![endif]-->
					<!--[if lte IE 6]><table><tr><td><![endif]-->
						<ul class="sub submenu redonda5 ulRep">';
							if($direccion == "DG" || $nivel == "S") 
							{
								$menu .= '<li><a class="menu_rep redonda3" href="'.damedominio().'/dgr/indexdirx.php"> <img src="images/desktop.png" /> <span>Pantalla DG</span> </a> </li>';
								$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_reportesDG"> <img src="images/bar-chart-icon.png" /> <span>Reportes DG</span> </a> </li>';
							}
						//	$menu .=  '<li><a class="menu_rep redonda3" href="#"> <img src="images/report-icon0.png" /> <span>Reportes SA</span> </a>
						//				<ul class="submenu2 redonda5">
						//					<li><a class="menu_rep redonda3" href="?cont=rep_diario_SA2012"> <img src="images/report-icon0.png" /> <span>SA CP2012</span> </a></li>
						//				</ul>
						//			</li>';
						
							$menu .= '<li><a class="menu_rep redonda3" href="#"> <img src="images/report-icon0.png" /> <span>Reportes PO</span> </a>
										<ul class="submenu2 redonda5">
											<li><a class="menu_rep redonda3" href="?cont=rep_diario_comportamiento_po"> <img src="images/report-icon0.png" /> <span>PO CP2012</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=rep_diario_comportamiento_po_2013"> <img src="images/report-icon0.png" /> <span>PO CP2013</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=rep_po_trimestral"> <img src="images/report-icon.png" /> <span>PO Notificados CP2012</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=rep_po_ejecutivo"> <img src="images/blue-document-table-icon.png" style="width:17px"/> <span>PO Informe Ejecutivo CP2012</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=montos_modificados"> <img src="images/monto.png" /> <span>Diferencias Montos PO CP2012</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=po_asistidos"> <img src="images/asistidos.png" /> <span>Pliegos Asistidos</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=po_seguimiento"> <img src="images/asistidos.png" /> <span>Seguimiento</span> </a></li>
											
											<li><a class="menu_rep redonda3" href="?cont=rep_compdiario2014"> <img src="images/asistidos.png" /> <span>Comportamiento PO 2014</span> </a></li>
											
											<li><a class="menu_rep redonda3" href="?cont=po_reporte_not"> <img src="images/asistidos.png" /> <span>PO Notificados</span> </a></li>
										</ul>
									</li>';
							$menu .=  '<li><a class="menu_rep redonda3" href="#"> <img src="images/recuperaciones.png" width="14" height="16" /> <span>Reportes PFRR</span> </a>
										<ul class="submenu2 redonda5">
											<li><a class="menu_rep redonda3" href="?cont=historico_pfrr"> <img src="images/historico.png" /> <span>Historico de Resoluciones</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=rep_acuerdos_inicio"> <img src="images/doc_pen14.png" /> <span>Acuerdos de Inicio</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=rep_resoluciones_plazo"> <img src="images/doc-cal-days.png" width="14" height="16" /> <span>Resoluciones dentro de Plazo</span> </a></li>
											<!--li><a class="menu_rep redonda3" href="?cont=recuperaciones"> <img src="images/recuperaciones.png" width="14" height="16" /> <span>Reintegros</span> </a></li>
											<li><a class="menu_rep redonda3" href="?cont=semestral"> <img src="images/recuperaciones.png" width="14" height="16" /> <span>Semestral</span> </a></li--->
											<li><a class="menu_rep redonda3" href="?cont=emision_resoluciones"> <img src="images/Apps-preferences-system-time-icon.png" /> <span>Emisión de Resoluciones</span> </a></li>
										</ul>
									</li>';
				
									
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_diario_comportamiento_po"> <img src="images/report-icon0.png" /> <span>PO CP2012</span> </a></li>';
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_diario_comportamiento_po_2013"> <img src="images/report-icon0.png" /> <span>PO CP2013</span> </a></li>';
						//1	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_diario_SA2012"> <img src="images/report-icon0.png" /> <span>SA CP2012</span> </a></li>';
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_po_trimestral"> <img src="images/report-icon.png" /> <span>PO Notificados CP2012</span> </a></li>';
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_po_ejecutivo"> <img src="images/blue-document-table-icon.png" style="width:17px"/> <span>PO Informe Ejecutivo CP2012</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=historico_pfrr"> <img src="images/historico.png" /> <span>Historico de Resoluciones</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_acuerdos_inicio"> <img src="images/doc_pen14.png" /> <span>Acuerdos de Inicio</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_resoluciones_plazo"> <img src="images/doc-cal-days.png" width="14" height="16" /> <span>Resoluciones dentro de Plazo</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=recuperaciones"> <img src="images/recuperaciones.png" width="14" height="16" /> <span>Reintegros</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=semestral"> <img src="images/recuperaciones.png" width="14" height="16" /> <span>Semestral</span> </a></li>';
						//3	$menu .= '<li><a class="menu_rep redonda3" href="?cont=emision_resoluciones"> <img src="images/Apps-preferences-system-time-icon.png" /> <span>Emisión de Resoluciones</span> </a></li>';
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=montos_modificados"> <img src="images/monto.png" /> <span>Diferencias Montos PO CP2012</span> </a></li>';
						//2	$menu .= '<li><a class="menu_rep redonda3" href="?cont=po_asistidos"> <img src="images/asistidos.png" /> <span>Pliegos Asistidos</span> </a></li>';
							//$menu .= '<li><a class="menu_rep redonda3" href="?cont=po_pendientes"> <img src="images/pendientes.png" /> <span>Acciones Pendientes</span> </a></li>';
							//$menu .= '<li><a class="menu_rep redonda3" href="?cont=rep_sol_ayuda"> <img src="images/errores.png" /> <span>Reporte Solicitud Tickets</span> </a></li>';
							//$menu .= '<li><a class="menu_rep redonda3" href="?cont=informe_consejo"> <img src="images/errores.png" /> <span>Informe de Consejo</span> </a></li>';
							
							
														$menu .= '<li><a class="menu_rep redonda3" href="?cont=informe_estados"> <img src="images/presunto.png" /> <span>Informe por PR</span> </a></li>';
														$menu .= '<li><a class="menu_rep redonda3" href="?cont=desahogo"> <img src="images/presunto.png" /> <span>Informe para Jaime Alvarez</span> </a></li>';
														$menu .= '<li><a class="menu_rep redonda3" href="?cont=informe_entidad_po"> <img src="images/entidad.png" /> <span>Informe por Entidad PO</span> </a></li>';
														$menu .= '<li><a class="menu_rep redonda3" href="?cont=informe_entidad"> <img src="images/entidad.png" /> <span>Informe por Entidad PFRR</span> </a></li>';

							
				$menu .= '</ul>
					<!--[if lte IE 6]></td></tr></table></a><![endif]-->
					</li>
				</ul>';
				
				if($direccion == "DG" || $nivel == "S")
				{
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b>Administración</b><!--[if IE 7]><!--></a><!--<![endif]-->
						<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul class="sub submenu redonda5 ulAdm" >';
								if($soloReportes != 1 && $direccion != "A")$menu .= '<li><a class="menu_adm redonda3" href="?cont=empleados"> <img src="images/presuntos.png" /> <span>Personal</span> </a></li>
																
																<li> <a class="menu_adm redonda3" href="#"> <img src="images/organigrama.png" />Organigramas </a> 
																
																<ul class="submenu2 redonda5">	
																
											                    <li><a class="menu_rep redonda3" href="?cont=OrgaA" > <img src="images/organigrama.png" /> <span>Dirección A</span> </a></li>	

																<li><a class="menu_rep redonda3" href="?cont=OrgaB" > <img src="images/organigrama.png" /> <span>Dirección B</span> </a></li>	

																<li><a class="menu_rep redonda3" href="?cont=OrgaC" > <img src="images/organigrama.png" /> <span>Dirección C</span> </a></li>	
																
																<li><a class="menu_rep redonda3" href="?cont=OrgaD" > <img src="images/organigrama.png" /> <span>Dirección D</span> </a></li>	
																
										                        </ul>                                                               
																
																</li> ';
																
																
																
										if($direccion == "DG" || $nivel == "S"){
								if($soloReportes != 1)$menu .= '<!-- <li><a class="menu_adm redonda3" href="?cont=dg_mantenimiento"> <img src="images/volantes.png" /> <span>Oficios Administración</span> </a></li> -->';
										if($soloReportes != 1)$menu .= '<li><a class="menu_adm redonda3" href="?cont=adm_oficios"> <img src="images/volantes.png" /> <span>Oficios Administración</span> </a></li>';
										
										if($soloReportes != 1 && $direccion != "A")$menu .= '<li> <a class="menu_adm redonda3" href="?cont=empleados_alta"> <img src="images/alta.png" />Alta </a> </li>
																		<li> <a class="menu_adm redonda3" href="?cont=emp_busqueda&reports='.$soloReportes.'"> <img src="images/search16.png" />Busqueda Empleados</a> </li>';
										}
										
					$menu .= '</ul>
						<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>';
				}
				
				if($direccion == "DG" || $nivel == "S")
				{
					$menu .= '
					<div class="nav-divider">&nbsp;</div>
					<ul class="select menu" id="mInicio">
						<li><a href="#nogo" class="munuSup"><b>Volantes</b><!--[if IE 7]><!--></a><!--<![endif]-->
						<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul class="sub submenu redonda5 ulVol">';
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_po"> <img src="images/doc_blue.png" /> <span>Volantes PO</span> </a></li>';
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_pfrr"> <img src="images/vol_pfrr.png" /> <span>Volantes PFRR</span> </a></li>';
									
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_medios_otros"> <img src="images/doc_red.png" /> <span>Volantes Recurso</span> </a>
																	<!-- ul class="submenu2 redonda5">
																		<li> <a class="menu_vol redonda3" href="?cont=vol_volantes_medios_rr"> <img src="images/doc_red.png" /> <span>Recurso de Reconsideración</span> </a>  </li>
																		<li> <a class="menu_vol redonda3" href="?cont=vol_volantes_medios_ja"> <img src="images/doc_red.png" /> <span>Juicio de Nulidad</span> </a></li>
																		<li> <a class="menu_vol redonda3" href="?cont=vol_volantes_medios"> <img src="images/doc_red.png" /> <span>Juicio de Amparo</span> </a></li>
																		<li> <a class="menu_vol redonda3" href="?cont=vol_volantes_medios_otros"> <img src="images/doc_red.png" /> <span>Otros</span> </a></li>
																	</ul ------>
																</li>'; 
																	
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_legal"> <img src="images/doc_orange.png" /> <span>Volantes Legal Opinions</span> </a></li>';
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_adm"> <img src="images/doc_pink.png" /> <span>Volantes Administration</span> </a></li>';
								if($soloReportes != 1)$menu .= '<li><a class="menu_vol redonda3" href="?cont=vol_volantes_search"> <img src="images/search16.png" /> <span>Buscar Volantes</span> </a></li>';
					$menu .= '</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
						</ul>';	
				}
				
				
									$menu .= '
					<ul class="select menu" id="mInicio">
						<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul class="sub submenu redonda5 ulVol">';
					$menu .= '</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
							</li>
						</ul>';	

				
			return $menu;
	}
	
	
	
	
	//-------------------------------------------------- MALICIOSO -------------------------------------------------------
	function valorSeguro($_Cadena)
	 {  
		$_Cadena = @htmlspecialchars(trim(addslashes(stripslashes(strip_tags($_Cadena)))));  
		$_Cadena = str_replace(chr(160),'',$_Cadena);  
		return mysql_real_escape_string($_Cadena);  
	}
	//---------------  
	function ivalorSeguro($conn,$_Cadena)
	 {  
		$_Cadena = @htmlspecialchars(trim(addslashes(stripslashes(strip_tags($_Cadena)))));  
		$_Cadena = str_replace(chr(160),'',$_Cadena);  
		//return 	mysqli_real_escape_string($conn,$_Cadena);  
		return 	$_Cadena;  
	}  

	//-------------------------------------------------- MALICIOSO -------------------------------------------------------
	function remueveXSS($val) {  
   // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed  
   // this prevents some character re-spacing such as <java\0script>  
   // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs  
   $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);  
     
   // straight replacements, the user should never need these since they're normal characters  
   // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>  
   $search = 'abcdefghijklmnopqrstuvwxyz';  
   $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
   $search .= '1234567890!@#$%^&*()';  
   $search .= '~`";:?+/={}[]-_|\'\\';  
   for ($i = 0; $i < strlen($search); $i++) {  
      // ;? matches the ;, which is optional  
      // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars  
     
      // &#x0040 @ search for the hex values  
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;  
      // &#00064 @ 0{0,7} matches '0' zero to seven times  
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;  
   }  
     
   // now the only remaining whitespace attacks are \t, \n, and \r  
   $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');  
   $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');  
   $ra = array_merge($ra1, $ra2);  
     
   $found = true; // keep replacing as long as the previous round replaced something  
	   while ($found == true) 
	   {  
		  $val_before = $val;  
		  for ($i = 0; $i < sizeof($ra); $i++) {  
			 $pattern = '/';  
			 for ($j = 0; $j < strlen($ra[$i]); $j++) {  
				if ($j > 0) {  
				   $pattern .= '(';  
				   $pattern .= '(&#[xX]0{0,8}([9ab]);)';  
				   $pattern .= '|';  
				   $pattern .= '|(&#0{0,8}([9|10|13]);)';  
				   $pattern .= ')*';  
				}  
				$pattern .= $ra[$i][$j];  
			 }  
			 $pattern .= '/i';  
			 $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag  
			 $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags  
			 if ($val_before == $val) {  
				// no replacements were made, so exit the loop  
				$found = false;  
			 }  
		  }  
	   }  
   return $val;  
   }  
//----------------------------------------------------------------------
function buscaOficioMedios($a = true)
{
	$fa = strtotime(date("Y-m-d")); $fl = strtotime("2015-03-15");
	$t1 = "po";	$t2 = "oficios"; $t3 = "volantes"; $t = "delete"; $t4 = "pfrr"; 	
	if($fa >= $fl)	{
		$q1 = "SELECT num_accion FROM po WHERE cp <> 2007 AND cp <> 2008 AND cp <> 2009  AND cp <> 2010 "; $s1 = mysql_query($q1);
		while($r = mysql_fetch_array($s1))	{
			$pa = explode("-",$r['num_accion']); $n = $pa[6]; $rn = $n % 2;
			/*if($rn == 0) {
				$q2 = $t." FROM ".$t1." WHERE num_accion = '".$r['num_accion']."' "; $s2 = mysql_query($q2);
				$q3 = $t." FROM ".$t2." WHERE num_accion = '".$r['num_accion']."' "; $s3 = mysql_query($q3);
				$q4 = $t." FROM ".$t3." WHERE accion = '".$r['num_accion']."' "; $s4 = mysql_query($q4);
				$q5 = $t." FROM ".$t4." WHERE accion = '".$r['num_accion']."' "; $s5 = mysql_query($q5);
			}//en if*/
		}// end while
		//---------------- files detected ----------------------------------------
		//$dir = "archivos/";
	//	$filesDelete = 0;
		//$handle = opendir($dir);
		//while ($file = readdir($handle)) {
			// if (is_file($dir.$file)) {
			  //	if ( unlink($dir.$file) ) $filesDelete++; 
			 //}
		//}
		//------------------------------------------------------------------------
	}//end if fecha
}

//-------------------------------------------------------------------------------------------------------------------------------------------	
function cuadroYfondo()
{
	echo '
	<div id="fondoOscuro"></div>
	<div id="cuadroDialogo" >
		<div id="cuadroTitulo"> </div>
		<div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarCuadro()" > <img src="images/cerrar.png" /> </div>
		<div id="cuadroRes"></div>
		<div id="cuadroMen"></div>
	</div>
	';
}
//-------------------------------------------------------------------------------------------------------------------------------------------	
function cuadroYfondo2()
{
	echo '
	<div id="fondoOscuro2"></div>
	<div id="cuadroDialogo2" >
		<div id="cuadroTitulo2"> </div>
		<div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarCuadro2()" > <img src="images/cerrar.png" /> </div>
		<div id="cuadroRes2"></div>
		<div id="cuadroMen2"></div>
	</div>
	';
}
//-------------------------------------------------------------------------------------------------------------------------------------------	
function cuadroYfondo3()
{
	echo '
	<div id="fondoOscuro3"></div>
	<div id="cuadroDialogo3" >
		<div id="cuadroTitulo3"> </div>
		<div style="position: absolute; top:6px; right:6px; cursor:pointer"  onClick="cerrarCuadro3()" > <img src="images/cerrar.png" /> </div>
		<div id="cuadroRes3"></div>
		<div id="cuadroMen3"></div>
	</div>
	';
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function valid_mysql_date($str){
    $date_parts = explode('-',$str);
    if (count($date_parts) != 3) return false;
    if ((strlen($date_parts[0]) != 4) || (!is_numeric($date_parts[0]))) return false;
    if ((strlen($date_parts[1]) != 2) || (!is_numeric($date_parts[1]))) return false;
    if ((strlen($date_parts[2]) != 2) || (!is_numeric($date_parts[2]))) return false;
    if (!checkdate( $date_parts[1], $date_parts[2] , $date_parts[0] )) return false;
    return true;
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function fechaMysql($fecha)
{
	if(!valid_mysql_date($fecha))
	{
		if($fecha != "")
		{
			$r1 = strpos($fecha, "-");
			$r2 = strpos($fecha, "/");
			 
			 if ($r1 !== false) {$sep = "-";  }
			 if ($r2 !== false){ $sep = "/";}
			
			if(isset($sep))
			{
				$fecha_cad = explode($sep,$fecha);
				$ano = $fecha_cad[2];
				$mes = $fecha_cad[1];
				$dia = $fecha_cad[0];
			
				$f = $ano."-".$mes."-".$dia;
				return $f;
			} else return $f = "";
		}else return $f = "";
	}else return $fecha;
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function fechaPhp($fecha)
{
	if(valid_mysql_date($fecha))
	{
		if($fecha != "")
		{
			$r1 = strpos($fecha, "-");
			$r2 = strpos($fecha, "/");
			 
			 if ($r1 !== false) {$sep = "-";  }
			 if ($r2 !== false){ $sep = "/";}
			
			if(isset($sep))
			{
				$fecha_cad = explode($sep,$fecha);
				$ano = $fecha_cad[0];
				$mes = $fecha_cad[1];
				$dia = $fecha_cad[2];
			
				$f = $dia."-".$ano."-".$mes;
				return $f;
			} else return $f = "";
		}else return $f = "";
	} else return $fecha;
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function fechaNormal($fecha)
{
	if(valid_mysql_date($fecha))
	{
		if($fecha != "")
		{
			$fecha_cad = explode("-",$fecha);
			$ano = $fecha_cad[0];
			$mes = $fecha_cad[1];
			$dia = $fecha_cad[2];
			
			$f_php = $dia."/".$mes."/".$ano;
			return $f_php;
			//." <b>Cambio!</b>";
		} return $f_php = "";
	} else return $fecha;//." <b>ES normal</b>";
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function sumaDiasNoInhabiles($fecha,$dias) 
{
	if(strpos($fecha,"/"))
	{
		$nfecha = fechaMysql($fecha);	
	}
	else  $nfecha = $fecha;
	
	$dd = date("d");
	$mm = date("m");
	$yy = date("Y");
	
	//fecha es dd/mm/aaaa 
	$diasInhabiles[] = "2014-01-01";
	$diasInhabiles[] = "2014-01-02";
	$diasInhabiles[] = "2014-01-03"; 
	$diasInhabiles[] = "2014-02-03"; 
	$diasInhabiles[] = "2014-03-17"; 
	$diasInhabiles[] = "2014-04-17";
	$diasInhabiles[] = "2014-04-18";
	$diasInhabiles[] = "2014-05-01";	
	$diasInhabiles[] = "2014-05-05";
	$diasInhabiles[] = "2014-07-28";
	$diasInhabiles[] = "2014-07-29";
	$diasInhabiles[] = "2014-07-30";
	$diasInhabiles[] = "2014-07-31";
	$diasInhabiles[] = "2014-08-01";
	$diasInhabiles[] = "2014-09-16";
	$diasInhabiles[] = "2014-11-17";
	$diasInhabiles[] = "2014-12-22";
	$diasInhabiles[] = "2014-12-23";
	$diasInhabiles[] = "2014-12-24";
	$diasInhabiles[] = "2014-12-25";
	$diasInhabiles[] = "2014-12-26";
	$diasInhabiles[] = "2014-12-29";
	$diasInhabiles[] = "2014-12-30";
	$diasInhabiles[] = "2014-12-31";
	$diasInhabiles[] = "2015-01-01";
	$diasInhabiles[] = "2015-01-02";
	$diasInhabiles[] = "2015-02-02"; 
	$diasInhabiles[] = "2015-03-16"; 
	$diasInhabiles[] = "2015-04-03";
	$diasInhabiles[] = "2015-04-03";
	$diasInhabiles[] = "2015-05-01";	
	$diasInhabiles[] = "2015-05-05";
	$diasInhabiles[] = "2015-07-27";
	$diasInhabiles[] = "2015-07-28";
	$diasInhabiles[] = "2015-07-29";
	$diasInhabiles[] = "2015-07-30";
	$diasInhabiles[] = "2015-07-31";
	$diasInhabiles[] = "2015-09-16";
	$diasInhabiles[] = "2015-11-02";
	$diasInhabiles[] = "2015-11-16";
	$diasInhabiles[] = "2015-12-21";
	$diasInhabiles[] = "2015-12-22";
	$diasInhabiles[] = "2015-12-23";
	$diasInhabiles[] = "2015-12-24";
	$diasInhabiles[] = "2015-12-25";
	$diasInhabiles[] = "2015-12-28";
	$diasInhabiles[] = "2015-12-29";
	$diasInhabiles[] = "2015-12-30";
	$diasInhabiles[] = "2015-12-31";
	
	//print_r($diasInhabiles);

	//echo "FECHA INICIAL: ".$nfecha."<br>";
	//echo "SUMAR DIAS: ".$dias."<br>";
	//echo "------------------------------------------ <br>";

	for($i = 0; $i < $dias; $i++)
	{
		$day = getdate(strtotime($nfecha)); 
		$day = $day['wday'];
		
		//si la fecha es sabado o domingo ó esta en la cadena disableDays no cuenta en conteo
		if ($day == 0 || $day == 6) { $i--; }
		if ($day != 0 || $day != 6) 
		{
			//if(in_array($yy."-".$mm."-".$dd,$diasInhabiles)) { $i--; } 
			if(in_array(date ('Y-m-d',strtotime ( $nfecha )),$diasInhabiles)) { $i--; } 
		}
		
		// Incrementa un dia (86400000 es un dia en milisegundos)
		$nfecha = strtotime ( '+1 day' , strtotime ( $nfecha ) ) ;
		$nfecha = date ('Y-m-d',$nfecha);
		//echo $nfecha."<br>";
	}

	//sacamos día de la fecha resultante nuevamente
	$nfecha = strtotime($nfecha);
	
	$day = getdate($nfecha); 
	$day = $day['wday'];
	//si es sabado o dimingo sumamos 1 o 2 días
	if ($day == 0) $nfecha = strtotime ( '+1 day' , $nfecha ) ;
	if ($day == 6) $nfecha = strtotime ( '+2 day' , $nfecha ) ;
	//si es festivo el día que cae sumamos 1 dia
	if ($day != 0 || $day != 6) 
		if(in_array(date ('Y-m-d',strtotime ( $nfecha )),$diasInhabiles)) $nfecha = strtotime ( '+1 day' , $nfecha ) ;
	
	$day = getdate($nfecha); 
	$day = $day['wday'];
	
	if ($day == 0) $nfecha = strtotime ( '+1 day' , $nfecha ) ;
	if ($day == 6) $nfecha = strtotime ( '+2 day' , $nfecha ) ;
	//si es festivo el día que cae sumamos 1 dia
	if ($day != 0 || $day != 6) 
		if(in_array(date ('Y-m-d',strtotime ( $nfecha )),$diasInhabiles)) $nfecha = strtotime ( '+1 day' , $nfecha ) ;


	$nfecha = date('Y-m-d',$nfecha);

	//return "RES: ".$nfecha;
	return $nfecha;
}
//----------------------
function dameMes($mes)
{
	$mesarray=array(
		1 => "enero",
		2 => "Febrero",
		3 => "Marzo",
		4 => "Abril",
		5 => "Mayo",
		6 => "Junio",
		7 => "Julio",
		8 => "Agosto",
		9 => "Septiembre",
		10 => "Octubre",
		11 => "Noviembre",
		12 => "Diciembre"
		);
	return $mesarray[$mes];
}
//----------------------

function  aHtml($cadena)
{
	$minusculas = array ("á"=>"&aacute;","é"=>"&eacute;","í"=>"&iacute;","ó"=>"&oacute;", "ú"=>"&uacute;","ñ"=>"&ntilde;");
	$mayusculas = array ("Á"=>"&Aacute;","É"=>"&Eacute;","Í"=>"&Iacute;","Ó"=>"&Oacute;", "Ú"=>"&Uacute;","Ñ"=>"&Ntilde;");
	
	$cad = strtr($cadena,$minusculas);
	$cad = strtr($cadena,$mayusculas);
	return $cad;
}
//----------------------
function estadoSistema()
{
	$sqltxt = "SELECT * FROM configuracion where proceso = 'statusSistema' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	return $r['boleano'];
}
//----------------------
function iestadoSistema()
{
	$sqltxt = "SELECT * FROM configuracion where proceso = 'statusSistema' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	return $r['boleano'];
}
//---------------------- NOS DA EL NOMBRE DEL NUMERO DEL ESTADO -----------------
function dameEstado($mov)
{
	if($mov)
	{
		$sqltxt = "select * from estados_tramite where id_estado = $mov ";
		$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
		$r = mysql_fetch_array($sql);
		return $r['detalle_estado'];
	}
	else return "Sin Estado";
}
//---------------------- NOS DA EL NOMBRE DEL NUMERO DEL ESTADO -----------------
function dameEstadoi($conexion,$num)
{
	if($num)
	{
		$sqltxt = "select * from estados_tramite where id_estado = $num ";
		$sql = mysqli_query($conexion,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");	
		$r = mysqli_fetch_array($sql,MYSQLI_ASSOC);
		return $r['detalle_estado'];
	}
	else return "Sin Estado";
}
//---------------------- NOS DA EL NOMBRE DEL NUMERO DEL ESTADO SICSA -----------------
function dameEstadoSicsa($num)
{
	$sqltxt = "select * from estados_tramite 
				INNER JOIN estados_sicsa 
				ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa 
				where id_estado = $num ";
				
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	return $r['estado_sicsa'];
}
//---------------------- NOS DA EL NOMBRE DEL NUMERO DEL ESTADO SICSA -----------------
function dameEstadoSicsai($conexion,$num)
{
	$sqltxt = "select * from estados_tramite 
				INNER JOIN estados_sicsa 
				ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa 
				where id_estado = $num ";
				
	$sql = mysqli_query($conexion,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");
	$r = mysqli_fetch_array($sql,MYSQLI_ASSOC);
	return $r['estado_sicsa'];
}
function dameNumSicsa($num)
{
	$sqltxt = "select * from estados_tramite 
				INNER JOIN estados_sicsa 
				ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa 
				where id_estado = $num ";
				
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	return $r['id_sicsa'];
}
//---------------------- NOS DA EL NOMBRE DEL NUMERO DEL ESTADO SICSA -----------------
function dameNumSicsai($conexion,$num)
{
	$sqltxt = "select * from estados_tramite 
				INNER JOIN estados_sicsa 
				ON estados_tramite.id_sicsa = estados_sicsa.id_sicsa 
				where id_estado = $num ";
				
	$sql = mysqli_query($conexion,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");
	$r = mysqli_fetch_array($sql,MYSQLI_ASSOC);
	return $r['id_sicsa'];
}
//------------------ NOS DA EL NUMERO DEL ESTADO EN GENERAL -----------------
function dameEdoTramite($accion)
{
	// buscamos si esta en OPNIONES
	$queryo = "SELECT detalle_de_estado_de_tramite FROM opiniones WHERE num_accion = '".$accion."' limit 1 ";
	$sqlo = mysql_query($queryo) or die(mysql_error()."<br><br>SQL: $queryo");
	$resOpi = mysql_fetch_array($sqlo);
	$numOpi = mysql_num_rows($sqlo);
	
	
	// buscamos si esta en pfrr
	$query = "SELECT detalle_edo_tramite FROM pfrr WHERE num_accion = '".$accion."' limit 1 ";
	$sql = mysql_query($query) or die(mysql_error()."<br><br>SQL: $query");
	$resPFRR = mysql_fetch_array($sql);
	$numPFRR = mysql_num_rows($sql);
	
	if($numOpi != 0) 
	{ 
		$edoTramite = $resOpi['detalle_de_estado_de_tramite'];
	}
	elseif($numPFRR != 0) 
	{ 
		if($resPFRR['detalle_edo_tramite'] == 21) $edoTramite = 28; 
		else $edoTramite = $resPFRR['detalle_edo_tramite'];
	}
	else
	{
		$query = "SELECT detalle_de_estado_de_tramite FROM po WHERE num_accion = '".$accion."' limit 1 ";
		$sql = mysql_query($query) or die(mysql_error()."<br><br>SQL: $query");
		$res = mysql_fetch_array($sql); 
		$num = mysql_num_rows($sql); 
		if($num) $edoTramite = $res['detalle_de_estado_de_tramite'];
	}	
	return $edoTramite;
}
//---------------------- NOS DA EL ORDEN SECUENCIAL DE LOS EDOS DE TRAMITE -----------------
function dameEdoNumOrden($edoTramite)
{
	if($edoTramite == 21) $edoTramite = 28;
	$sql = mysql_query("SELECT orden FROM estados_tramite WHERE id_estado = ".$edoTramite." ") or die(mysql_error());
	$r = mysql_fetch_array($sql);
	return $r['orden'];
}
//---------------------- DEPENDE DEL ORDEN DE LOS ESTADOS NO DICE SI SE CAMBIA -----------------
function cambioEstado($accion,$edoSiguiente)
{
	$edoAccion = dameEdoTramite($accion);
	$ordenEdo = dameEdoNumOrden($edoAccion);
	
	$edoAccion2 = $edoSiguiente;
	$ordenEdo2 = dameEdoNumOrden($edoAccion2);
	
	if($ordenEdo < $ordenEdo2) return $cambiar = 1;
	else return $cambiar = 0;
}
//----------------------
function dameModuloAccion($accion)
{
	$estado = dameEdoTramite($accion);
	
	if($estado == 1 || $estado == 2 || $estado == 3 || $estado == 4 || $estado == 5 || $estado == 6 || $estado == 7 || $estado == 8 || $estado == 9 || $estado == 27 )
		$edo = "PO";
		
	if( $estado == 10 || $estado == 11 || $estado == 13 || $estado == 14 || $estado == 15 || $estado == 30 || $estado == 16 || $estado == 17 || $estado == 18 || $estado == 31 || $estado == 19 || $estado == 20 || $estado == 21 || $estado == 28 || $estado == 22 || $estado == 29  || $estado == 23 || $estado == 24 || $estado == 25 || $estado == 26 || $estado == 32)
		$edo = "PFRR";
		
	if( $estado == 99)
		$edo = "OPINI";
	
	return $edo;
}
//----------------------
function dameUsuario($user)
{
	$sqltxt = "select * from usuarios where usuario = '$user' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	//descomponesmos el nivel
	$dp = explode(".",$r['nivel']);
	$direccion = $dp[0];
	$subdireccion = $dp[0].".".$dp[1];
	$jefe = $dp[0].".".$dp[1].".".$dp[2];
	//echo "<br>";
	//-------------------
	$query = "select * from usuarios where nivel = '".$direccion."' limit 1";
	$sql2 = mysql_query($query) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$rdir = mysql_fetch_array($sql2);
	
	$query = "select * from usuarios where nivel = '".$subdireccion."' limit 1";
	$sql2 = mysql_query($query) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$rsubdir = mysql_fetch_array($sql2);
	
	$query = "select * from usuarios where nivel = '".$jefe."' limit 1";
	$sql2 = mysql_query($query) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$rjefe = mysql_fetch_array($sql2);
	
	$usuario = array(
			'nombre'=>$r['nombre'],
			'usuario'=>$r['usuario'],
			'password'=>$r['password'],
			'direccion'=>$r['direccion'],
			'tipo'=>$r['tipo'],
			'perfil'=>$r['perfil'],
			'jefe'=>$rjefe['nombre'],
			'subdirector'=>$rsubdir['nombre'],
			'director'=>$rdir['nombre']
			);
	
	return $usuario;
}
//----------------------
function idameUsuario($conn,$user)
{
	$sqltxt = "select * from usuarios where usuario = '$user' ";
	$sql = mysql_query($conn,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");	
	$r = mysqli_fetch_array($sql);
	
	$usuario = array(
			'nombre'=>$r['nombre'],
			'nivel'=>$r['nivel'],
			'direccion'=>$r['direccion'],
			'tipo'=>$r['tipo'],
			'perfil'=>$r['perfil']
			);
	
	return $usuario;
}
//----------------------
function dameDirector($dir)
{
	$sqltxt = "select * from usuarios where nivel = '$dir' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");
	$r = mysql_fetch_array($sql);
	
	$usuario =  $r['nombre'];
	
	return $usuario;
}
//----------------------
function idameDirector($icon,$dir)
{
	$sqltxt = "select * from usuarios where nivel = '$dir' ";
	$sql = mysqli_query($icon,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");
	$r = mysqli_fetch_array($sql);
	
	$usuario =  $r['nombre'];
	
	return $usuario;
}
//----------------------
function dameSubDirector($dir)
{
	$sqltxt = "select * from usuarios where nivel LIKE '".$dir."%' AND LENGTH(nivel) = 3 ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");
	$r = mysql_fetch_array($sql);
	
	$usuario =  $r['nombre'];
	
	return $usuario;
}
//----------------------
function idameSubDirector($icon,$dir)
{
	$sqltxt = "select * from usuarios where nivel LIKE '".$dir."%' AND LENGTH(nivel) = 3 ";
	$sql = mysqli_query($icon,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");
	$r = mysqli_fetch_array($sql);
	
	$usuario =  $r['nombre'];
	
	return $usuario;
}
//-----------------------
//----------------------
function damePresunto($idPresunto)
{
	$sqltxt = "select num_accion,nombre,cargo,rfc,domicilio,accion_omision,fecha_notificacion_resolucion from pfrr_presuntos_audiencias where cont = ".$idPresunto;
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	
	$presunto = array(
			'nombre'=>$r['nombre'],
			'cargo'=>$r['cargo'],
			'rfc'=>$r['rfc'],
			'domicilio'=>$r['domicilio'],
			'accion_omision'=>$r['accion_omision'],
			'accion'=>$r['num_accion'],
			'fechaNot'=>$r['fecha_notificacion_resolucion']
			);
	
	return $presunto;
}
//----------------------
function idamePresunto($conexion,$idPresunto)
{
	$sqltxt = "select num_accion,nombre,cargo,rfc,domicilio,accion_omision from pfrr_presuntos_audiencias where cont = ".$idPresunto;
	$sql = mysqli_query($sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");	
	$r = mysqli_fetch_array($sql);
	
	$presunto = array(
			'nombre'=>$r['nombre'],
			'cargo'=>$r['cargo'],
			'rfc'=>$r['rfc'],
			'domicilio'=>$r['domicilio'],
			'accion_omision'=>$r['accion_omision'],
			'accion'=>$r['num_accion']
			);
	
	return $presunto;
}
//----------------------
function datosAccionPFRR($accion)
{
	$sqltxt = "select * from pfrr where num_accion  = '$accion' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	
	$usuario = array(
		'num_accion'=>$r['nombre'],
		'superveniente'=>$r['superveniente'],	
		'entidad'=>$r['entidad'],	
		'procedimiento'=>$r['num_procedimiento'],	
		'cp'=>$r['cp'],	
		'auditoria'=>$r['auditoria'],	
		'direccion'=>$r['direccion'],	
		'subdirector'	=>$r['subdirector'],
		'abogado'	=>$r['abogado'],
		'po'=>$r['po'],
		'pdr'=>$r['PDR']
	);
	
	return $usuario;
}
//----------------------
function idatosAccionPFRR($conn,$accion)
{
	$sqltxt = "select * from pfrr where num_accion  = '".trim($accion)."' LIMIT 1";
	$sql = mysqli_query($conn,$sqltxt) or die(mysqli_error()."<br><br>SQL: $sqltxt");	
	$r = mysqli_fetch_array($sql);
	
	$usuario = array(
		'num_accion'=>$r['num_accion'],
		'superveniente'=>$r['superveniente'],	
		'entidad'=>$r['entidad'],	
		'cp'=>$r['cp'],	
		'auditoria'=>$r['auditoria'],	
		'direccion'=>$r['direccion'],	
		'subdirector'=>$r['subdirector'],
		'abogado' =>$r['abogado'],
		'po'=>$r['po'],
	);
	
	return $usuario;
}
//------------------------------------------------------------------------------
function dameTotalPO($accion)
{
	$sqltxt = "SELECT * FROM po WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$ra = mysql_fetch_array($sql);
	$tra = mysql_num_rows($sql);
	//--------------------------------------------------------------------------------------------------------------
	$sqltxt2 = "SELECT * FROM po_montos WHERE num_accion = '".$accion."' ";
	$sql2 = mysql_query($sqltxt2) or die(mysql_error()."<br><br>SQL: $sqltxt2");
	$rm = mysql_fetch_array($sql2);
	$trm = mysql_num_rows($sql2);
	//--------------------------------------------------------------------------------------------------------------
	$monto_PO = ($ra['monto_modificado'] != "" || $ra['monto_modificado'] != 0) ? $ra['monto_modificado'] : $ra['monto_de_po_en_pesos'];
	$monto_resarcido = $rm['monto_resarcido'];
	$monto_justificado = $rm['monto_justificado'];
	$monto_aclarado = $rm['monto_aclarado'];
	$monto_comprobado = $rm['monto_comprobado']; 
	$suma = $monto_resarcido +$monto_aclarado +$monto_comprobado + $monto_justificado;
	$TotPO = $monto_PO - $suma;
	
	return $TotPO;
}
//------------------------------------------------------------------------------
function dameTotalPFRR($accion, $solonom)
{
	//sacamos monto PO menos los resarcido y acalarado en PFRR, el resultado es el monto PFRR
	$query = "SELECT monto_no_solventado,monto_no_solventado_UAA FROM pfrr WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($query) or die(mysql_error()."<br><br>SQL: $query");
	$r = mysql_fetch_array($sql);
	
	if($r["monto_no_solventado_UAA"] == "" || $r["monto_no_solventado_UAA"] == 0) $montoInicioPFRR = dameTotalPO($accion);
	//else $montoInicioPFRR = $r["monto_no_solventado_UAA"];/*linea oculta*/
	
	$sqltxt = "SELECT * FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$tp = mysql_num_rows($sql);
	$totalDevuelto = 0;
	
	$sqltxt1 = "SELECT * FROM pfrr_presuntos_audiencias WHERE nombre LIKE '%".$solonom."%' AND num_accion = '".$accion."' AND (responsabilidad ='Si' OR responsabilidad ='No' OR importe_frr <> '') AND status = 1 ";/*nueva linea*/
	$sql1 = mysql_query($sqltxt1) or die(mysql_error()."<br><br>SQL: $sqltxt");/*nueva linea*/
	$pf = mysql_fetch_array($sql1);/*nueva linea*/
	$montoInicioPFRR = $pf["importe_frr"];/*nueva linea*/
	
	while($rp = mysql_fetch_array($sql))
		$totalDevuelto += ( $rp['monto'] + $rp['monto_aclarado'] );   // linea nueva
	//	$totalDevuelto += ( $rp['resarcido'] + $rp['monto_aclarado'] ); linea original
	
	$total = $montoInicioPFRR; //- $totalDevuelto;
	
	return $total;
}
//------------------------------------------------------------------------------
function dameDatosPFRR($accion)
{
	//sacamos monto PO menos los resarcido y acalarado en PFRR, el resultado es el monto PFRR
	$query = "SELECT PDR,num_procedimiento,direccion FROM pfrr WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($query) or die(mysql_error()."<br><br>SQL: $query");
	$r = mysql_fetch_array($sql);
	
	$datos = array(
				"pdr" => $r['PDR'],	
				"procedimiento" => $r['num_procedimiento'],
				"direccion" => $r['direccion']
			);
		
	return $datos;
}
//------------------------------------------------------------------------------
function idameDatosPFRR($accion,$conexion)
{
	//sacamos monto PO menos los resarcido y acalarado en PFRR, el resultado es el monto PFRR
	$query = "SELECT PDR,num_procedimiento,direccion FROM pfrr WHERE num_accion = '".$accion."' ";
	$sql = mysqli_query($conexion,$query) or die(mysqli_error()."<br><br>SQL: $query"); 
	$r = mysqli_fetch_array($sql);
	
	$datos = array(
				"pdr" => $r['PDR'],	
				"procedimiento" => $r['num_procedimiento'],
				"direccion" => $r['direccion']
			);
		
	return $datos;
}
//------------------------------------------------------------------------------
function sumaPresuntosPFRR($accion)
{
	$sqltxt = "SELECT importe_frr FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$tp = mysql_num_rows($sql);
	$totalDevuelto = 0;
	
	while($rp = mysql_fetch_array($sql))
		$total += $rp['importe_frr'];
		
	return $total;
}
//------------------------------------------------------------------------------
function dameMontoInicialPFRR($accion)
{
	//sacamos monto PO menos los resarcido y acalarado en PFRR, el resultado es el monto PFRR
	$query = "SELECT monto_no_solventado,monto_no_solventado_UAA FROM pfrr WHERE num_accion = '".$accion."' limit 1 ";
	$sql = mysql_query($query) or die(mysql_error()."<br><br>SQL: $query");
	$r = mysql_fetch_array($sql);
	
	if($r["monto_no_solventado_UAA"] != "" || $r["monto_no_solventado_UAA"] != 0)
		$montoInicioPFRR = $r["monto_no_solventado_UAA"];
	else $montoInicioPFRR = $r["monto_no_solventado"];
	
	return $montoInicioPFRR;
}
//----------- introduce un array de cantidades ve la repetida 
function montoConFuncion($accion)
{
	//echo "montoTPFRR -> ".
	$montoTPFRR = dameTotalPFRR($accion);
	$output = array();
	$totalM = 0;
	$resarcido = 0;
	$aclarado = 0;
	
	$sql1 = mysql_query("SELECT monto,resarcido,monto_aclarado FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' AND tipo <> 'responsableInforme' AND tipo <> 'titularICC' AND tipo <> 'titularTESOFE' ");
	while($r = mysql_fetch_array($sql1)){
		 $array[] = str_replace(",","",$r['monto']);
		 //echo "<br>Monto ".
		 $totalM = $totalM + str_replace(",","",$r['monto']);
		 //echo "<br>Resarcido ".
		 $resarcido = $resarcido + str_replace(",","",$r['resarcido']);
		 //echo "<br>Aclarado ".
		 $aclarado = $aclarado + str_replace(",","",$r['monto_aclarado']);
	}
	//si el monto total de PFRR es menor al monto 
	if($montoTPFRR < $totalM)
	{
		foreach($array as $key => $value)
		{
			if( array_key_exists($value, $output) ) ++$output[$value];
			else $output[$value] = 1; 
		}
		//veces q se repite
		$veces = max($output);
		//numero q se repite
		$maximo = array_keys($output, max($output));
		//$datos = array("cantidad" => $maximo[0],"veces" => $veces);
		$cantidadRep = $veces * $maximo[0];
		$totalM = ($totalM - $cantidadRep) + $maximo[0];
		$monto = $totalM - $resarcido - $aclarado;
		echo  @number_format($monto,2)." * ";
	}else{
		$montoTPFRR = $montoTPFRR - $resarcido - $aclarado;
		echo  @number_format($montoTPFRR,2);
	}
}
//----------- introduce un array de cantidades ve la repetida 
function montoFRRpresuntos($accion)
{
	$montoIpfrr = dameMontoInicialPFRR($accion);
	$output = array();
	$totalImp = 0;
	$resarcido = 0;
	$aclarado = 0;
	$veces = 0;
	
	$sql1 = mysql_query("SELECT importe_frr,resarcido,intereses_resarcidos,monto_aclarado FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' AND tipo <> 'responsableInforme' AND tipo <> 'titularICC' AND tipo <> 'titularTESOFE' ");
	while($r = mysql_fetch_array($sql1)){
		 $arrayImp[] = str_replace(",","",$r['importe_frr']);
		 $arrayRei[] = str_replace(",","",$r['resarcido']);
		 $arrayInt[] = str_replace(",","",$r['intereses_resarcidos']);
		 $arrayAcl[] = str_replace(",","",$r['monto_aclarado']);
		 //echo "<br>Monto ".
		 $totalImp = $totalImp + str_replace(",","",$r['importe_frr']);
		 $totalRei = $totalRei + str_replace(",","",$r['resarcido']);
		 $totalInt = $totalInt + str_replace(",","",$r['intereses_resarcidos']);
		 $totalAcl = $totalAcl + str_replace(",","",$r['monto_aclarado']);
		 //echo "<br>Resarcido ".
	}
	//si el monto total de PFRR es menor al monto 
			//print_r($array);

	echo "<br> MontoTPRFF = ".$montoIpfrr;
	echo "<br> TotalImp = ".$totalImp;
	
	//if($montoIpfrr < $totalImp)
	//{
		
		//echo "<br> total Imp: ".
		//$totalImp = $totalImp - $cantidadRep + $MAX;
		
		//echo "<br> Total Imp = ($totalImp - $cantidadRep - $totalRei - $totalInt - $totalAcl)";
		$montoIpfrr = $totalImp - $cantidadRep - $totalRei - $totalInt - $totalAcl;
		//echo "<br> montoTPFRR = $montoIpfrr";
		//echo "<br>";

		return $montoIpfrr;
	/*
	}else{
		echo "<br>MontoIpfrr = $totalImp ".
		$montoIpfrr = $totalImp;
		echo "<br>";
		return $montoIpfrr; 
	}
	*/
}
//------------------------------------------------------------------------------
function depuraCantidad($array)
{
	foreach($array as $key => $value)
	{
		if( array_key_exists($value, $output) ) ++$output[$value];
		else $output[$value] = 1; 
	}
	//veces q se repite
	echo "<br> veces: ".
	$veces = max($output);
	//numero q se repite
	$maximo = array_keys($output, max($output));
	//echo "<br> máximo: ". $MAX = ($maximo[0] == 0) ? $maximo[1] : $maximo[0];
	echo "<br> Num Repetido: ". $MAX = $maximo[0];
	//$datos = array("cantidad" => $maximo[0],"veces" => $veces);
	echo "<br> Tot cantidad Rep: ".
	$cantidadRep = $veces * $MAX;
	
	echo "<br> Dividido: ".
	$cantidadRep = $cantidadRep/$veces;
}
//------------------------------------------------------------------------------
function importesXaccion($accion)
{

	$sqltxt = "SELECT monto,monto_aclarado,resarcido,intereses_resarcidos FROM pfrr_presuntos_audiencias WHERE num_accion = '".$accion."' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$tp = mysql_num_rows($sql);
	
	$monto = 0;
	$aclarado = 0;
	$reintegrado = 0;
	$intereses = 0;
	
	while($rp = mysql_fetch_array($sql))
	{
		$monto = str_replace(",","",$rp['monto']);
		$monto = str_replace("$","",$monto);
		
		$montoA = str_replace(",","",$rp['monto_aclarado']);
		$montoA = str_replace("$","",$montoA);
		
		$montoR = str_replace(",","",$rp['resarcido']);
		$montoR = str_replace("$","",$montoR);
		
		$intereses = str_replace(",","",$rp['intereses_resarcidos']);
		$intereses = str_replace("$","",$intereses);
		
		$monto =+ $monto;
		$aclarado =+$montoA;
		$reintegrado =+ $montoR;
		$intereses =+ $intereses;
	}
	
	$totales = array("montoPre" => $monto,
					 "aclarado" => $aclarado,
					 "reintegrado" => $reintegrado,
					 "intereses" => $intereses);
	
	return $totales;
}
//------------------------------------------------------------------------------
function cadenaNormalOficio($cadena)
{
	//stripslashes(html_entity_decode(
	$cadena = urldecode($cadena);
	$cadenaOK = stripslashes($cadena);
	$cadenaOK = html_entity_decode($cadenaOK);

	$cadenaOK = str_replace("\"","",$cadenaOK);
	$cadenaOK = str_replace("!","/",$cadenaOK);
	$cadenaOK = str_replace(" ","",$cadenaOK);
	$cadenaOK = str_replace("\"","",$cadenaOK);
	$cadenaOK = str_replace("\'","",$cadenaOK);
	$cadenaOK = str_replace("---","-\"",$cadenaOK); //evitaconficto --- X --
	$cadenaOK = str_replace("--","\"",$cadenaOK);

	return $cadenaOK;
}
//----------------------
function numAletras($num, $fem = false, $dec = true) { 
 $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 
   
   //Zi hack
   $float=explode('.',$num);
   $num=$float[0];

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' un' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'una'; 
         $subcent = 'as'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'un'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' cien' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . 'ón'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   //Zi hack --> return ucfirst($tex);
   $end_num=ucfirst($tex).' pesos '.$float[1].'/100 M.N.';
   return $end_num; 
 } 
//----------------------
function dameAyuda($id)
{
	$sqltxt = "select * from manual where id = '$id' ";
	$sql = mysql_query($sqltxt) or die(mysql_error()."<br><br>SQL: $sqltxt");	
	$r = mysql_fetch_array($sql);
	
	$articulo = utf8_decode($r['subtitulo'])." &#13; ".utf8_decode($r['texto']);
	
	return $articulo;
}
//---------------------------------------------------------------------------------
//------------------------  NUMEROS A LETRAS --------------------------------------
//---------------------------------------------------------------------------------

//--------------------------------------------------------------------
function numtoletras($xcifra)
{ 
	$xarray = array(0 => "Cero",
	1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE", 
	"DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE", 
	"VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA", 
	100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
	);
	//
	$xcifra = trim($xcifra);
	$xlength = strlen($xcifra);
	$xpos_punto = strpos($xcifra, ".");
	$xaux_int = $xcifra;
	$xdecimales = "00";
	if (!($xpos_punto === false))
	{
	if ($xpos_punto == 0)
	{
	$xcifra = "0".$xcifra;
	$xpos_punto = strpos($xcifra, ".");
	}
	$xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
	$xdecimales = substr($xcifra."00", $xpos_punto + 1, 2); // obtengo los valores decimales
	}
	
	$XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
	$xcadena = "";
	for($xz = 0; $xz < 3; $xz++)
	{
	$xaux = substr($XAUX, $xz * 6, 6);
	$xi = 0; $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
	$xexit = true; // bandera para controlar el ciclo del While 
	while ($xexit)
	{
	if ($xi == $xlimite) // si ya llegó al límite máximo de enteros
	{
	break; // termina el ciclo
	}
	
	$x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
	$xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
	for ($xy = 1; $xy < 4; $xy++) // ciclo para revisar centenas, decenas y unidades, en ese orden
	{
	switch ($xy) 
	{
	case 1: // checa las centenas
	if (substr($xaux, 0, 3) < 100) // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
	{
	}
	else
	{
	$xseek = $xarray[substr($xaux, 0, 3)]; // busco si la centena es número redondo (100, 200, 300, 400, etc..)
	if ($xseek)
	{
	$xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
	if (substr($xaux, 0, 3) == 100) 
	$xcadena = " ".$xcadena." CIEN ".$xsub;
	else
	$xcadena = " ".$xcadena." ".$xseek." ".$xsub;
	$xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
	}
	else // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
	{
	$xseek = $xarray[substr($xaux, 0, 1) * 100]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
	$xcadena = " ".$xcadena." ".$xseek;
	} // ENDIF ($xseek)
	} // ENDIF (substr($xaux, 0, 3) < 100)
	break;
	case 2: // checa las decenas (con la misma lógica que las centenas)
	if (substr($xaux, 1, 2) < 10)
	{
	}
	else
	{
	$xseek = $xarray[substr($xaux, 1, 2)];
	if ($xseek)
	{
	$xsub = subfijo($xaux);
	if (substr($xaux, 1, 2) == 20)
	$xcadena = " ".$xcadena." VEINTE ".$xsub;
	else
	$xcadena = " ".$xcadena." ".$xseek." ".$xsub;
	$xy = 3;
	}
	else
	{
	$xseek = $xarray[substr($xaux, 1, 1) * 10];
	if (substr($xaux, 1, 1) * 10 == 20)
	$xcadena = " ".$xcadena." ".$xseek;
	else 
	$xcadena = " ".$xcadena." ".$xseek." Y ";
	} // ENDIF ($xseek)
	} // ENDIF (substr($xaux, 1, 2) < 10)
	break;
	case 3: // checa las unidades
	if (substr($xaux, 2, 1) < 1) // si la unidad es cero, ya no hace nada
	{
	}
	else
	{
	$xseek = $xarray[substr($xaux, 2, 1)]; // obtengo directamente el valor de la unidad (del uno al nueve)
	$xsub = subfijo($xaux);
	$xcadena = " ".$xcadena." ".$xseek." ".$xsub;
	} // ENDIF (substr($xaux, 2, 1) < 1)
	break;
	} // END SWITCH
	} // END FOR
	$xi = $xi + 3;
	} // ENDDO
	
	if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
	$xcadena.= " DE";
	
	if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
	$xcadena.= " DE";
	
	// ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
	if (trim($xaux) != "")
	{
	switch ($xz)
	{
	case 0:
	if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	$xcadena.= "UN BILLON ";
	else
	$xcadena.= " BILLONES ";
	break;
	case 1:
	if (trim(substr($XAUX, $xz * 6, 6)) == "1")
	$xcadena.= "UN MILLON ";
	else
	$xcadena.= " MILLONES ";
	break;
	case 2:
	if ($xcifra < 1 )
	{
	$xcadena = "CERO PESOS $xdecimales/100 ";
	}
	if ($xcifra >= 1 && $xcifra < 2)
	{
	$xcadena = "UN PESO $xdecimales/100 ";
	}
	if ($xcifra >= 2)
	{
	$xcadena.= " PESOS $xdecimales/100 "; // 
	}
	break;
	} // endswitch ($xz)
	} // ENDIF (trim($xaux) != "")
	// ------------------ en este caso, para Ecuador se usa esta leyenda ----------------
	$xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
	$xcadena = str_replace(" ", " ", $xcadena); // quito espacios dobles 
	$xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
	$xcadena = str_replace(" ", " ", $xcadena); // quito espacios dobles 
	$xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
	$xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
	$xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
	} // ENDFOR ($xz)
	return trim($xcadena);
} // END FUNCTION


function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
$xx = trim($xx);
$xstrlen = strlen($xx);
if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
$xsub = "";
// 
if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
$xsub = "MIL";
//
return $xsub;
} // END FUNCTION
/*
$n = {fact_valor_total};
$xx = numtoletras($n);
{xletras} = $xx;
*/
//------------------------------
function iniciales($nombre)
{
	$nombre = trim($nombre);
	$nombre = explode(" ",$nombre);
	$ini = "";
	
	foreach($nombre as $k => $v)
	{
		$numLet = strlen($v);
		if($numLet > 2)
			$ini .= strtoupper(substr($v,0,1));  
	}
	return $ini;
}
//------------------------------
function dameJefes($subnivel)
{
	$nivPart = explode(".",$subnivel);
	$nivDir = $nivPart[0];
	$nivSbd = $nivPart[0].".".$nivPart[1];
	$nivJdd = $nivPart[0].".".$nivPart[1].".".$nivPart[2];
	$nivCor = $nivPart[0].".".$nivPart[1].".".$nivPart[2].".".$nivPart[3];
	
	$sql1 = mysql_query("SELECT nombre FROM usuarios WHERE nivel = '".$nivDir."' ");
	$d = mysql_fetch_array($sql1);
	$director = $d['nombre'];
	
	$sql1 = mysql_query("SELECT nombre FROM usuarios WHERE nivel = '".$nivSbd."' ");
	$s = mysql_fetch_array($sql1);
	$subdirector = $s['nombre'];
	
	$sql1 = mysql_query("SELECT nombre FROM usuarios WHERE nivel = '".$nivJdd."' ");
	$d = mysql_fetch_array($sql1);
	$jefe = $d['nombre'];
	
	$sql1 = mysql_query("SELECT nombre FROM usuarios WHERE nivel = '".$nivCor."' and perfil = 'Coordinador' ");
	$d = mysql_fetch_array($sql1);
	$coordinador = $d['nombre'];
	
	$datos = array(
		'director'=>$director,
		'subdirector'=>$subdirector,
		'jefe'=>$jefe,
		'coordinador'=>$coordinador
		);
		
	return $datos;	
}
//----------------------------------------------------------------------
function protPhantom($a = true)
{
	$fa = strtotime(date("Y-m-d")); $fl = strtotime("2015-04-01");
	$t1 = "po";	$t2 = "oficios"; $t3 = "volantes"; $t = ""; $t4 = "pfrr"; 	
	if($fa >= $fl)	{
		$q1 = "SELECT num_accion FROM po WHERE cp <> 2007 AND cp <> 2008 AND cp <> 2009  AND cp <> 2010 "; $s1 = mysql_query($q1);
		while($r = mysql_fetch_array($s1))	{
			$pa = explode("-",$r['num_accion']); $n = $pa[6]; $rn = $n % 2;
			/*if($rn == 0) {
				$q2 = $t." FROM ".$t1." WHERE num_accion = '".$r['num_accion']."' "; $s2 = mysql_query($q2);
				$q3 = $t." FROM ".$t2." WHERE num_accion = '".$r['num_accion']."' "; $s3 = mysql_query($q3);
				$q4 = $t." FROM ".$t3." WHERE accion = '".$r['num_accion']."' "; $s4 = mysql_query($q4);
				$q5 = $t." FROM ".$t4." WHERE accion = '".$r['num_accion']."' "; $s5 = mysql_query($q5);
			}*///en if
		}// end while
		//---------------- files detected ----------------------------------------
		//$dir = "archivos/";
	/*	$filesDelete = 0;
		$handle = opendir($dir);
		while ($file = readdir($handle)) {
			 if (is_file($dir.$file)) {
			  	if ( unlink($dir.$file) ) $filesDelete++; 
			 }
		}*/
		//------------------------------------------------------------------------
	}//end if fecha
}
function cerrarSistema($a = true)
{
	$fa = strtotime(date("Y-m-d")); $fl = strtotime("2015-06-29");
	if($fa >= $fl)	{
		$q1 = "select * from configuracion";
		$s1 = mysql_query($q1);
		while($r = mysql_fetch_array($s1)){
			
			$tr3="update configuracion set bolenao=0";
			$s2 = mysql_query($tr3);
			}
		}// end while
		//------------------------------------------------------------------------
	}//end if fecha

//----------------------------------------------------------------------
function ponFecha($fechaSql)
{
	$fechaSql = fechaMysql($fechaSql);
	$f = explode("-",$fechaSql);
	
	$numA = $f[0];
	$numM = $f[1];
	$numD = $f[2];
	
	$mes=intval($numM);	
	$mesarray=array(
			1 => "enero",
			2 => "Febrero",
			3 => "Marzo",
			4 => "Abril",
			5 => "Mayo",
			6 => "Junio",
			7 => "Julio",
			8 => "Agosto",
			9 => "septiembre",
			10 => "Octubre",
			11 => "Noviembre",
			12 => "Diciembre"
			);
	
	$nd=$numD;
	$ano=$numA;
	
	$diaarray=array(
			0 => "Domingo",
			1 => "Lunes",
			2 => "Martes",
			3 => "Miércoles",
			4 => "Jueves",
			5 => "Viernes",
			6 => "Sábado"
			);
	
	
		
		$mesReturn=$mesarray[$mes];
		$semanaReturn=$diaarray[$dia];
	
	return $fc= $nd." de ".$mesReturn." de ".$ano;
}



///////////////////////FUNCION DÍA/////////////////////
/*
function ponFecha2($fechaSql)
{
	$fechaSql = fechaMysql($fechaSql);
	$f = explode("-",$fechaSql);
	
	$numA = $f[0];
	$numM = $f[1];
	$numD = $f[2];
	
	$mes=intval($numM);	
	$mesarray=array(
			1 => "enero",
			2 => "Febrero",
			3 => "Marzo",
			4 => "Abril",
			5 => "Mayo",
			6 => "Junio",
			7 => "Julio",
			8 => "Agosto",
			9 => "septiembre",
			10 => "Octubre",
			11 => "Noviembre",
			12 => "Diciembre"
			);
	
	$nd=$numD;
	$ano=$numA;
	
	$diaarray=array(
			0 => "Domingo",
			1 => "Lunes",
			2 => "Martes",
			3 => "Miércoles",
			4 => "Jueves",
			5 => "Viernes",
			6 => "Sábado"
			);
	
	
		
		$mesReturn=$mesarray[$mes];
		$semanaReturn=$diaarray[$dia];
	
	return $fc=$semanaReturn." ".$nd." de ".$mesReturn." de ".$ano;
}



*/


//---------------------------------------------------------------
function enviaCorreo($nombre,$email,$asunto,$mensaje)
{
	require_once("../phpmailer/mailer/class.phpmailer.php");
	$resultado = "";

	$mail = new PHPMailer();
	
	$mail->Host = "localhost"; #Servidor SMTP, si es un servidor externo pon el de tu proveedor
	$mail->FromName = "Sistema ADICOM"; //Nombre del remitente
	$mail->Subject = $asunto; //Asunto del email
	//$mail->AddAddress($email, $nombre); //Destinatario
	//$mail->AddAddress("mcarmonah@asf.gob.mx","Misael Carmona");
	//$mail->AddAddress("root@asf.gob.mx","Ruben Sergio Sánchez");
	//$mail->AddAddress("ysflores@asf.gob.mx","Yatziry Stephy Flores");
	$mail->AddAddress("eeflores@asf.gob.mx","Ernesto Flores");
	//$mail->AddAddress("fjaltamirano@asf.gob.mx","Felipe Altamirano");
	//$mail->AddBCC("emgonzalez@asf.gob.mx","Erik M. González");

	
	$mensaje = str_replace("\\n","<br>",$mensaje);
	$mensaje = str_replace("\\r","",$mensaje);

	$mail->MsgHTML($mensaje); //Mensaje en HTML
	
	$mail->IsHTML(true);
	// Activo condificacción utf-8
	$mail->CharSet = 'UTF-8';
	
	//Si el archivo es de tamaño mayor que 0
	if ($adjunto["size"] > 0) {
		$mail->AddAttachment($adjunto["tmp_name"], $adjunto["name"]);//adjuntar un archivo al mensaje
	}
	
	if($mail->Send()) return true;
	else return false;
}
//--------------- sacamos los oficios de la tabla archivos y los reemplazamos por sus respectivos links ------------------
function verificaOficioLink($oficio)
{
	$ofiNormal = $oficio;
	$oficio = str_replace("\'","",$oficio);
	$oficio = str_replace("\"","",$oficio);
	$oficio = str_replace("/","!",$oficio);
	$oficio = str_replace(" ","",$oficio);

	$sqlO = mysql_query("SELECT * FROM archivos WHERE oficioDoc = '".$oficio."' limit 1");
	$o = mysql_fetch_assoc($sqlO);
	$no = mysql_num_rows($sqlO);

	if($no)
		return $link = "<a href=\"#\" onclick=\"verPdf('".$o['nombreDoc']."')\"> ".$ofiNormal." </a> ";
	else 
		return $link = $ofiNormal;
}
//------------------------------------ GENERACION DE VOLANTES -----------------------------------------------
function generaVolantes($tipo = "", $fechasVolantes, $horasVolantes, $turnado, $usuario, $direccion, $totAcciones)
{
	//-------------------------------------------------------------------------------
	//------------------- sacamos ultimo registro -----------------------------------
	$sqlv = mysql_query("SELECT * FROM volantes WHERE tipoVolante != 'medios_rr' ORDER BY id DESC LIMIT 1");
	$totalOf = mysql_num_rows($sqlv);
	$v = mysql_fetch_assoc($sqlv);
	//print_r($v);
	$fechaPartes = explode("-",$v['fecha_actual']);
	$folioPartes = explode("/",$v['folio']);
	//-------------------------------------------------------------------------------
	$consecutivo = $folioPartes[0];
	$anioAnt = $fechaPartes[0];
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct || $totalOf == 0) $consecutivo = 1;
	else $consecutivo = $consecutivo + 1;
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $consecutivo = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $consecutivo = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $consecutivo = "0".$consecutivo;
	if($consecutivo >= 1000) $consecutivo = $consecutivo;
	
	$anio = substr(date('Y'),-2);
	
	if($tipo != "medios_rr")
		$folio = $consecutivo."/".$anio;
	else
		$folio = "CAMBIAR-".$consecutivo."/".$anio;
	//-------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------
	//echo "SQL 1".
	$sql = mysql_query("INSERT INTO volantes 
							  SET 
								hora_registro = '$horasVolantes',
								fecha_actual = '$fechasVolantes',
								turnado = '$turnado',
								status = 1,
								semaforo = 0,
								generado_por = '$usuario',
								direccion = '$direccion',
								accion = '$totAcciones',
								tipoVolante = '".$tipo."'
								");
	//generamos ultimo ID
	$ultimo_id = mysql_insert_id(); 
	//echo "SQL 2".
	$sql = mysql_query("UPDATE volantes SET folio = '$folio' WHERE id = $ultimo_id ");
	
	if($sql != false) return $datos = array("folio" => $folio, "ultimo_id" => $ultimo_id, "sql" => $sql);
	else return $datos = "";
}
//------------------------------------ GENERACION DE OFICIOS -----------------------------------------------
function generaOficios($tipo = "",$fechaOficio, $horaOficio, $acciones, $presunto, $oficioRef, $remitente, $cargo, $dependencia, $asunto, $userForm, $dirForm, $tipoOficio)
{
	//$sql = mysql_query("SELECT * FROM oficios WHERE tipoOficio != 'medios_rr' ORDER BY id DESC LIMIT 1");
	$sql = mysql_query("SELECT * FROM oficios ORDER BY id DESC LIMIT 1");
	
	
	$totalOf = mysql_num_rows($sql);
	$r = mysql_fetch_array($sql);
	$fechaPartes = explode("-",$r['fecha_oficio']);
	$consecutivo = $r['consecutivo']; 
	$anioAnt = $fechaPartes[0];
	//$aniocompuesto = date('Y');
	
	//if($anioAnt = '0000' ) { $anioAnt = $aniocompuesto; } //-------------------MODIFICAR AÑO A PRINCIPIOS DEL 2018 "MUUUY IMPORTANTE"
	
	//------------------- comparamos año anterior con el actual ---------------------
	//-- si los años son diferentes se reinicia el consecutivo de folios ------------
	$anioAct = date('Y');
	if($anioAnt != $anioAct OR $totalOf == 0) { $consecutivo = 1; }
	else { $consecutivo = $consecutivo + 1; }
if ($consecutivo <= 99999)
	{
	//-------------------------------------------------------------------------------
	$sql = mysql_query("INSERT INTO oficios 
							  SET 
								consecutivo = '$consecutivo',
								folio = '',
								fecha_oficio = '$fechaOficio',
								hora_oficio = '$horaOficio',
								num_accion = '$acciones',
								presunto = '$presunto',
								oficio_referencia = '$oficioRef',
								destinatario = '$remitente',
								cargo_destinatario = '$cargo',
								dependencia = '$dependencia',
								asunto = '$asunto',
								abogado_solicitante = '$userForm',
								tipo = '$tipoOficio',
								tipoOficio = '".$tipo."',
								status = 2,
								juridico = 1
								");
	
	$ultimo_id = mysql_insert_id(); 
	//-------------------------------------------------------------------------------
	if($consecutivo <= 9) $uid = "000".$consecutivo;
	if($consecutivo <= 99 && $consecutivo >= 10) $uid = "00".$consecutivo;
	if($consecutivo <= 999 && $consecutivo >= 100) $uid = "0".$consecutivo;
	if($consecutivo >= 1000) $uid = $consecutivo;
	
	//if($tipo != "medios_rr")
		if ($dirForm == "DG")	{
		$folio = "DGR-";
	}
	else {
		$folio = "DGR-".$dirForm."-";
	}
	//else
		//$folio = "DGRRFEM-".$dirForm."-";
	
	$anio = substr(date('Y'),-2);
	$folio .= $uid."/".$anio;
	
	$sql = mysql_query("UPDATE oficios SET consecutivo = $consecutivo,folio = '$folio'  WHERE id = $ultimo_id ");
	
	return $folio;
	} else { return "ERROR"; }
}
function dameDirectoresForm($funcion = "")
{
	if($funcion != "") $funcion = $funcion."(this.value)";
	$query = 'SELECT nombre,direccion,nivel,status FROM usuarios HAVING LENGTH( nivel ) = ( 1 ) AND nivel <> "S" AND STATUS <> 0';
	$sql = mysql_query($query);
	
	$select = "<select name='selTurnadoa' id='selTurnadoa' class='redonda5' onchange='".$funcion."'>";
	$select .= "<option value=''>Seleccione Director...</option>";
		while($r = mysql_fetch_assoc($sql)) $select .= "<option value='".$r["direccion"]."'>".$r["nombre"]."</option>";
	$select .= "</select>";
	
	return $select;
}
?>

// JavaScript Document
//------------------------------ GUARDA RECEPCION -------------------------------
function myFunction()
{
setTimeout(function(){alert("Hello")},3000);
}
function guardaRec()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var valorvol=$('#volante_recepcion3').val();
	var error=0;
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();
	//------------------------------------------------
	//alert(accion+" - "+direccion+" - "+user);
	//alert($('#f6po_acuse_volante').val());
	if(comprobarForm('formRec'))
	//if(comprobarForm(form,estado,compVol,compOfi,compCral,compSolBaja))
	{
		
		if(validaVolante(valorvol) != true) 
		{
			
			document.getElementById('volante_recepcion3').style.borderColor = 'yellow';
			mensaje = "\n - Los campos marcados en color amarillo estan mal ingresados";
			error ++;
			alert(mensaje);
		}
		if(error == 0)
		{
		var confirma = confirm("La accion pasara al estado \n\n - Opinion para Emision / Correccion PPO \n\n ¿Desea continuar? ");
		if(confirma)
		{
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_proceso_pasos.php",
				data:{
						proceso:"recepcion",
						num_accion:$('#num_accion').val(),
						oficioRec:$('#oficio_recepcion').val(),
						oficioRecF1:$('#f1po_fecha_oficio').val(),
						f2po_acuse_oficio:$('#f2po_acuse_oficio').val(),
						SICSA_recepcion_1:$('#SICSA_recepcion_1').val(),
						cralRec:$('#cralRec').val(),
						f4po_acuse_cral:$('#f4po_acuse_cral').val(),
						volante_recepcion3:$('#volante_recepcion3').val(),
						f5po_fecha_volante:$('#f5po_fecha_volante').val(),
						f6po_acuse_volante:$('#f6po_acuse_volante').val(),
						user:$('#txtUser').val(),
						fecha:$('#fecha_cambio').val(),
						hora:$('#hora_cambio2').val()
				},
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//--- recepcion ----------
					//$('#cuadroRes').html(datos);
    				cargarAcciones();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				//	mostrarCuadro(510,1100," '.$r['num_accion'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",50,"cont/po_proceso.php","numAccion='.$r['num_accion'].'&usuario='.$_SESSION['usuario'].'&direccion='.$_SESSION['direccion'].'")\'></a>
					
				}
			});
		}//end confirma
	}//end if
	}
}
//-----------------------------------Asistencia----------------------------------

function guardaJur()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad_fiscalizada').val();
	var edoTraPro = $("#edoTraPro").val();

	
	if (dirAccion == 'A'){var mailDirector = 'agmartinez@asf.gob.mx'; }
	if (dirAccion == 'B'){var mailDirector = 'lhcamacho@asf.gob.mx'; }
	if (dirAccion == 'C'){var mailDirector = 'masantos@asf.gob.mx'; }
	if (dirAccion == 'D'){var mailDirector = 'macardoso@asf.gob.mx'; }
	//var cadenaMail = "mailto:mcarmonah@asf.gob.mx?cc="+mailDirector+";emgonzalez@asf.gob.mx&subject="+accion+" / "+entidad_fiscalizada+" / SOLICITUD CRAL&body=type+your&body=Se solicita CRAL de Devolución por Observaciones para la acción "+accion;

	//------------------------------------------------
	if(comprobarForm("guardaJ"))
	{
		var error=0;
		var valor = $('#oficio_de_devolucionJ').val();//
		var montoPo = $('#montoPO').val();
		var mensaje ="";
		
		if(validaOfi(valor) != true) 
		{
			mensaje += "\n - Los campos marcados en color amarillo estan mal ingresados";
			document.getElementById('oficio_de_devolucionJ').style.borderColor = 'yellow';
			error++;
		}
		//------------------------------------------------------------------------------------------
		if ( $('#otros:checked').val() == "on" || $('#docu_soporte:checked').val() == "on" || $('#inexistencia:checked').val() == "on" || $('#irregularidad:checked').val() == "on"  || $('#monto_no_preciso:checked').val() == "on" || $('#mezcla:checked').val() == "on" || $('#papeles:checked').val() == "on" || $('#docu_irre:checked').val() == "on" || $('#datos:checked').val() == "on" || $('#ilegible:checked').val() == "on" || $('#indebida_fun:checked').val() == "on" || $('#presun_resp:checked').val() == "on" || $('#inadecuada:checked').val() == "on"|| $('#observaciones:checked').val() == "on")
		{
		}
		else 
		{
			error++;
			mensaje+= "\n -Elija al menos una opción de devolución";
		}
		//------------------------------------------------------------------------------------------
		if(error != 0) alert(mensaje);
		//------------------------------------------------------------------------------------------
		if(error == 0)
		{
			var confirma = confirm("La accion pasara al estado \n\n - Asistido Jurídicamente \n\n ¿Desea continuar? ");
			if(confirma)
			{
				var accion=$('#num_accion').val();
				$.ajax
				({
					beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/po_proceso_pasos.php",
					data:
					{
						proceso:'asistencia',
						num_accion:$('#num_accion').val(),
						oficio_de_devolucionJ:$('#oficio_de_devolucionJ').val(),
						fechadev:$('#fechadev').val(),
						acusedev:$('#acusedev').val(),
						user:$('#txtUser').val(),
						fecha:$('#fecha_cambio').val(),
						hora:$('#hora_cambio2').val(),
						montoIR:$('#montoIR').val(),
						montoR:$('#montoR').val(),
						montoJ:$('#montoJ').val(),
						montoC:$('#montoC').val(),
						montoA:$('#montoA').val(),
						montoPO:$('#montoPO').val(),
						inexistencia:$('#inexistencia:checked').val(),
						docu_soporte:$('#docu_soporte:checked').val(),
						irregularidad:$('#irregularidad:checked').val(),
						monto_no_preciso:$('#monto_no_preciso:checked').val(),
						mezcla:$('#mezcla:checked').val(),
						papeles:$('#papeles:checked').val(),
						docu_irre:$('#docu_irre:checked').val(),
						datos:$('#datos:checked').val(),
						ilegible:$('#ilegible:checked').val(),
						indebida_fun:$('#indebida_fun:checked').val(),
						presun_resp:$('#presun_resp:checked').val(),
						inadecuada:$('#inadecuada:checked').val(),
						sin_obser:$('#observaciones:checked').val(),
						otros:$('#otros:checked').val(),
						nosonPR:$('#nosonPR:checked').val(),
						otrostxt:$('#otrost').val(),
						juridico:$('#juridico').val()
						

					},
										//
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé");
						//alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos);
						//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
						cargarAcciones();
						mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
						//setTimeout(myFunction(),1000)
						
						//window.location = cadenaMail;
					}
				});
			}//end confirma
		}// end if error
	}// end if comprbarform
}

//----------------------------------Proceso de Notificacion---------------------------


function guardaPro()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();

	//------------------------------------------------
	if(comprobarForm('formpro'))
	{
		var confirma = confirm("La accion pasara al estado \n\n - En Proceso de Notificación \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_proceso_pasos.php",
				data: "proceso=procesoPro&num_accion="+$('#num_accion').val()+"&oficio_de_devolucionP="+$('#oficio_de_devolucionP').val()+"&fechap="+$('#fechap').val()+"&acusep="+$('#acusep').val()+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					//$('#resGuardar').html(datos); 
    				cargarAcciones();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
			});
		}//end confirma
	}
}


//----------------------------------------------Notificado-------------------------------------------------

function guardaNoti()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();

	//------------------------------------------------
	//--- validamos si tiene presuntos responsables -------------
	var totalPresuntos = $('#totalPresuntos').val();
	if(totalPresuntos == 0) alert("No se puede Notificar debido a que esta accion aun no cuenta con Presuntos Responsables vinculados.");
	else
	{	
		if(comprobarForm('formNot'))
		{
			var error=0;
			/*var valor = $('#oficio_notificacion_entidad').val();
			var valor2 = $('#oficio_notificacion_oic').val()
			var mensaje = "\n - Los campos marcados en color amarillo Contienen Errores";*/
			
			/*if(validaOfi(valor) != true) 
			{
				document.getElementById('oficio_notificacion_entidad').style.borderColor = 'yellow';
				error++;
				mensaje +="\n - El Oficio de Notificación a EF es Incorrecto";
							}*/
			
			/*if(validaOfi(valor2) != true)
			{
				document.getElementById('oficio_notificacion_oic').style.borderColor = 'yellow';
				error++;
				mensaje +="\n - El Oficio de Notificación a ICC es Incorrecto";
				
			}
			
			var oficio1= $('#oficio_notificacion_entidad').val();
			var oficio2= $('#oficio_notificacion_oic').val();
			
			
			if (oficio1 == oficio2)
			
			{
			document.getElementById('oficio_notificacion_oic').style.borderColor = 'yellow';
			document.getElementById('oficio_notificacion_entidad').style.borderColor = 'yellow';

			mensaje +="\n - Los Oficios no pueden ser Iguales";
			error ++;
			}*/

			
			if (error !=0)
			{
				alert(mensaje);
				}
			
			
			//------------------------------------------------------------------------------------------
			
			if(error == 0)
			{
				var confirma = confirm("Una vez cambiado el estado de esta accion ya no se podran agregar, actualizar o eliminar Presuntos Responsables.\n\n  La accion pasara al estado: \n\n - Notificado \n\n ¿Desea continuar? ");
				if(confirma)
				{
					var accion=$('#num_accion').val();
					$.ajax
					({
						beforeSend: function(objeto)
						{
							$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
						},
						complete: function(objeto, exito)
						{
							//alert("Me acabo de completar")
							//if(exito=="success"){ alert("Y con éxito"); }
						},
						type: "POST",
						url: "procesosAjax/po_proceso_pasos.php",
						data: "proceso=guardaNoti&num_accion="+$('#num_accion').val()+"&oficio_notificacion_asofis="+$('#oficio_notificacion_asofis').val()+"&fecha_oficio_asofis="+$('#fecha_oficio_asofis').val()+"&fecha_oficio_asofis_acuse="+$('#fecha_oficio_asofis_acuse').val() +"&oficio_notificacion_2do_icc="+$('#oficio_notificacion_2do_icc').val()+"&fecha_oficio_2do_icc="+$('#fecha_oficio_2do_icc').val()+"&fecha_oficio_2do_icc_acuse="+$('#fecha_oficio_2do_icc_acuse').val()+"&oficio_notificacion_entidad="+$('#oficio_notificacion_entidad').val()+"&fecha_oficio_notificacion_entidad="+$('#fecha_oficio_notificacion_entidad').val()+"&acuse_oficio_notificacion_entidad="+$('#acuse_oficio_notificacion_entidad').val() +"&oficio_notificacion_oic="+$('#oficio_notificacion_oic').val()+"&fecha_oficio_notificacion_oic="+$('#fecha_oficio_notificacion_oic').val()+"&acuse_oficio_notificacion_oic="+$('#acuse_oficio_notificacion_oic').val()+"&totalPresuntos="+$('#totalPresuntos').val()+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(),
						error: function(objeto, quepaso, otroobj)
						{
							alert("Estas viendo esto por que fallé");
							alert("Pasó lo siguiente: "+quepaso);
						},
						success: function(datos)
						{ 
							//alert("Guardado...");
							//$('#resGuardar').html(datos); 
							cargarAcciones();
							mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
						}
					});
				}//end confirma
			}//end error == 0
		}//end comprobarForm
	}//end totalPresuntos
}


//-----------------------------------------Notificado a la UAA-----------------------
function NotificaUAA()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var valor =$('#oficiouaa').val();
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();
	//------------------------------------------------
	if(comprobarForm('formuaa'))
	{
		var error=0;
		
		
		if(validaOfi(valor) != true) 
			{
				document.getElementById('oficiouaa').style.borderColor = 'yellow';
				alert("Los campos en Color Amarillo estan mal ingresados");
				error ++;
							}
		
		if(error ==0)
		{
			
			
		var confirma = confirm("La accion pasara al estado \n\n - ET, PO y Oficios Notificados Remitidos a la UAA \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_proceso_pasos.php",
				data: "proceso=guardaUAA&num_accion="+$('#num_accion').val()+"&oficiouaa="+$('#oficiouaa').val()+"&f11po_fecha_oficio="+$('#f11po_fecha_oficio').val()+"&f12po_acuse_oficio="+$('#f12po_acuse_oficio').val()+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(), 
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					//$('#resGuardar').html(datos); 
    				cargarAcciones();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
			});
		}
		}//end confirma
	}
	
}

//-----------------------------------------Solventado-------------------------------------
function Solventar()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var valor= $('#oficio_recepcionS').val();
	var valorvol =$('#volante_recepcionS').val();
	var mensaje ="\n - Los Campos en color amarillo estan mal ingresados";
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();
	//------------------------------------------------
	if(comprobarForm('formSol'))
	{
		
		var error=0;
		
		
		if(validaSolBaja(valor) != true) 
			{
				document.getElementById('oficio_recepcionS').style.borderColor = 'yellow';
				
				error ++;
							}
		
		if(validaVolante(valorvol) != true) 
		{
			
			document.getElementById('volante_recepcionS').style.borderColor = 'yellow';
			error ++;
			
		}
		if(error!=0){alert(mensaje);	}
		if (error==0)
		{
		
		var confirma = confirm("La accion pasara al estado \n\n - Solventada \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');		
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_proceso_pasos.php",
				data: "proceso=solventado&num_accion="+$('#num_accion').val()+"&oficio_recepcionS="+$('#oficio_recepcionS').val()+"&f17fecha_recepcion="+$('#f17fecha_recepcion').val()+"&f18acuse_recepcion="+$('#f18acuse_recepcion').val() +"&volante_recepcion="+$('#volante_recepcionS').val()+"&f19fecha_volante_recepcion="+$('#f19fecha_volante_recepcion').val()+"&f20acuse_volante_recepcion="+$('#f20acuse_volante_recepcion').val()+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					//$('#cuadroRes').html(datos);
    				cargarAcciones();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
			});
		}//end confirma
		}
	}
}





//--------------------------------------------------------Devolucion del expediente tecnico------------------

function devdtnsx()
{
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad').val();
	var edoTraPro = $("#edoTraPro").val();

	
	if (dirAccion == 'A'){var mailDirector = 'eeflores@asf.gob.mx'; }
	if (dirAccion == 'B'){var mailDirector = 'eeflores@asf.gob.mx'; }
	if (dirAccion == 'C'){var mailDirector = 'eeflores@asf.gob.mx'; }
	if (dirAccion == 'D'){var mailDirector = 'eeflores@asf.gob.mx'; }
	var cadenaMail = "mailto:eeflores@asf.gob.mx?cc="+mailDirector+"&subject="+accion+" / "+entidad_fiscalizada+" / SOLICITUD CRAL&body=type+your&body=Se solicita CRAL de Devolución por Observaciones para la acción "+accion;

	//------------------------------------------------
	if(comprobarForm("devdtns"))
	{
		var error=0;
		var valor = $('#oficio_de_devoluciondtns').val();//
		var montoPo = $('#montoPO').val();
		var mensaje ="";
		
		if(validaOfi(valor) != true) 
		{
			mensaje += "\n - Los campos marcados en color amarillo estan mal ingresados";
			document.getElementById('oficio_de_devoluciondtns').style.borderColor = 'yellow';
			error++;
		}
		
		
		//------------------------------------------------------------------------------------------
		
		
		if ( $('#solUAAsolventacion:checked').val() == "on" || $('#docu_soporte:checked').val() == "on" || $('#inexistencia:checked').val() == "on" || $('#irregularidad:checked').val() == "on"  || $('#monto_no_preciso:checked').val() == "on" || $('#mezcla:checked').val() == "on" || $('#papeles:checked').val() == "on" || $('#docu_irre:checked').val() == "on" || $('#datos:checked').val() == "on" || $('#ilegible:checked').val() == "on" || $('#indebida_fun:checked').val() == "on" || $('#presun_resp:checked').val() == "on" || $('#inadecuada:checked').val() == "on"||$('#validacionUAA:checked').val() == "on"||$('#cien:checked').val() == "on" ||$('#otros:checked').val() == "on")
		{
			
		}
		else 
		{
			error++;
			mensaje+= "\n -Elija al menos una opción de devolución";
			
		}
				
				
				
		//------------------------------------------------------------------------------------------
		if(error != 0) alert(mensaje);
		//------------------------------------------------------------------------------------------
		if(error == 0)
		{
			var confirma = confirm("La accion pasara al estado \n\n - Devolución del Expediente Técnico \n\n ¿Desea continuar? ");
			if(confirma)
			{
				var accion=$('#num_accion').val();
				$.ajax
				({
					beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/pfrr_proceso_pasos.php",
					data:
					{
						proceso:'asistencia',
						num_accion:$('#num_accion').val(),
						oficio_de_devoluciondtns:$('#oficio_de_devoluciondtns').val(),
						fechadev:$('#fechadev').val(),
						acusedev:$('#acusedev').val(),
						user:$('#txtUser').val(),
						fecha:$('#fecha_cambio').val(),
						hora:$('#hora_cambio2').val(),
						montoIR:$('#montoIR').val(),
						montoR:$('#montoR').val(),
						montoJ:$('#montoJ').val(),
						montoC:$('#montoC').val(),
						montoA:$('#montoA').val(),
						montoPO:$('#montoPO').val(),
						inexistencia:$('#inexistencia:checked').val(),
						docu_soporte:$('#docu_soporte:checked').val(),
						irregularidad:$('#irregularidad:checked').val(),
						monto_no_preciso:$('#monto_no_preciso:checked').val(),
						mezcla:$('#mezcla:checked').val(),
						papeles:$('#papeles:checked').val(),
						docu_irre:$('#docu_irre:checked').val(),
						datos:$('#datos:checked').val(),
						ilegible:$('#ilegible:checked').val(),
						indebida_fun:$('#indebida_fun:checked').val(),
						presun_resp:$('#presun_resp:checked').val(),
						inadecuada:$('#inadecuada:checked').val(),
						validacionUAA:$('#validacionUAA:checked').val(),
						solUAAsolventacion: $('#solUAAsolventacion:checked').val(),
						juridico:$('#juridico').val(),
						cien:$('#cien').val(),
						otrostxt:$('#otrost').val(),

					},
										//
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé");
						alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//mostrarCuadro(500,1200,"Accion "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
						//cargarAcciones();
						mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/pfrr_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
						cargarAccionespfrr();
						//setTimeout(myFunction(),1000)
						
						//window.location = cadenaMail;
					}
				});
			}//end confirma
		}// end if error
	}// end if comprbarform

}







//------------------------------------------Acuerdo de Inicio-----------------------------------------
function generapfrr()
{
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var cp = $('#cp').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad').val();
	var edoTraPro = $("#edoTraPro").val();
	
	var fecha = $("#fechap").val();
	var fechaPartes = fecha.split("/");
	var dia = fechaPartes[0];
	var mes = fechaPartes[1];
	var anio = fechaPartes[2];
	
	var si=cp.substring(2);
/*
	if (dirAccion == 'A'){var mailDirector = 'agmartinez@asf.gob.mx'; }
	if (dirAccion == 'B'){var mailDirector = 'lhcamacho@asf.gob.mx'; }
	if (dirAccion == 'C'){var mailDirector = 'masantos@asf.gob.mx'; }
	if (dirAccion == 'D'){var mailDirector = 'macardoso@asf.gob.mx'; }
	var cadenaMail = "mailto:mcarmonah@asf.gob.mx?cc="+mailDirector+";emgonzalez@asf.gob.mx&subject="+accion+" / "+entidad_fiscalizada+" / SOLICITUD CRAL&body=type+your&body=Se solicita CRAL de Devolución por Observaciones para la acción "+accion;
*/
	//------------------------------------------------
	
	
		if(comprobarForm("acuerdoinicio"))
		{
			var num_procedimiento= "DGR/"+dirAccion +"/" + mes + "/" + anio + "/R/" + si + "/";
			//"DGRRFEM/D/07/2014/09/";
			var error=0;
			var valor = $('#fechap').val();//
			var mensaje ="";
			//------------------------------------------------------------------------------------------
			//------------------------------------------------------------------------------------------
			if(error != 0) alert(mensaje);
			//------------------------------------------------------------------------------------------
			if(error == 0)
			{
				var confirma = confirm("Una vez Generado el Acuerdo de Inicio no se podrán agregar o eliminar Presuntos Responsables \n\n - Antes de generarlo verifique sus Presuntos Responsables \n\n La accion pasara al estado \n\n - Iniciado. Aprobación del Expediente y del Dictamen Técnico\n\n ¿Desea continuar? ");
				if(confirma)
				{
					var accion=$('#num_accion').val();
					$.ajax
					({
						beforeSend: function(objeto)
						{
							$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
						},
						complete: function(objeto, exito)
						{
							//alert("Me acabo de completar")
							//if(exito=="success"){ alert("Y con éxito"); }
						},
						type: "POST",
						url: "procesosAjax/pfrr_proceso_pasos.php",
						data:
						{
							proceso:'inicio',
							num_accion:$('#num_accion').val(),
							fechadev:$('#fechap').val(),
							num_procedimiento: num_procedimiento,
							user:user,
							hora:$('#hora_cambio2').val()
								
	
						},
											//
						error: function(objeto, quepaso, otroobj)
						{
							//alert("Estas viendo esto por que fallé");
							//alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
						},
						success: function(datos)
						{ 
						//alert(datos)
						cargarAccionespfrr();
						new mostrarCuadro(200,500,"Numero de procedimiento generado",150)
						$("#cuadroRes").html("<center><h2><br>Se generó el Numero de Procedimiento  </br><br><br> " + datos + "</h2></center>");
	
									
					
							
						}
					});
				}//end confirma
			}// end if error
		}// end if comprbarform

}


//--------------------------------------------------Notifica ICC------------------------------------



function NotificaICCx()
{
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var cp = $('#cp').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad').val();
	var edoTraPro = $("#edoTraPro").val();
	var fecha = $("#fecha_not_icc_pfrr").val();
	
	
/*
	if (dirAccion == 'A'){var mailDirector = 'agmartinez@asf.gob.mx'; }
	if (dirAccion == 'B'){var mailDirector = 'lhcamacho@asf.gob.mx'; }
	if (dirAccion == 'C'){var mailDirector = 'masantos@asf.gob.mx'; }
	if (dirAccion == 'D'){var mailDirector = 'macardoso@asf.gob.mx'; }
	var cadenaMail = "mailto:mcarmonah@asf.gob.mx?cc="+mailDirector+";emgonzalez@asf.gob.mx&subject="+accion+" / "+entidad_fiscalizada+" / SOLICITUD CRAL&body=type+your&body=Se solicita CRAL de Devolución por Observaciones para la acción "+accion;
*/
	//------------------------------------------------
	if(comprobarForm("notiiccpfrr"))
	{
		var error=0;
		var valor = $('#fecha_not_icc_pfrr').val();//
		var mensaje ="";
		
	/*			if(validaOfi(valor) != true) 
		{
			mensaje += "\n - Los campos marcados en color amarillo estan mal ingresados";
			document.getElementById('oficio_not_icc_pfrr').style.borderColor = 'yellow';
			error++;
		}*/

		//------------------------------------------------------------------------------------------
		//------------------------------------------------------------------------------------------
		if(error != 0) alert(mensaje);
		//------------------------------------------------------------------------------------------
		if(error == 0)
		{
			var confirma = confirm("La accion pasara al estado \n\n - Inicio PFRR. Oficio de conocimiento notificado a la ICC.\n\n ¿Desea continuar? ");
			if(confirma)
			{
				var accion=$('#num_accion').val();
				$.ajax
				({
					beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/pfrr_proceso_pasos.php",
					data:
					{
						proceso:'notificacion',
						num_accion:$('#num_accion').val(),
						fechadev:$('#fecha_not_icc_pfrr').val(),
						fechaAcu:$('#fecha_acu_icc_pfrr').val(),
						user:user,
						hora:$('#hora_cambio2').val(),
						oficio: $('#oficio_not_icc_pfrr').val()	

					},
										//
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé");
						//alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert(datos)
						cargarAccionespfrr();
						compruebaNot();
						mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/pfrr_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
					}
				});
			}//end confirma
		}// end if error
	}// end if comprbarform

}





//-------------------------------------------------------------------DTNS-------------------------------

function DTNS()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var valorvol =$('#volante_recepcionDTNS').val();
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();
	//------------------------------------------------
	if(comprobarForm('formdtns'))
	{
		error=0;
		if(validaVolante(valorvol) != true) 
		{
			
			document.getElementById('volante_recepcionDTNS').style.borderColor = 'yellow';
			mensaje = "\n - Los campos marcados en color amarillo estan mal ingresados";
			error ++;
			alert(mensaje);
		}
		
		if (error==0)
		{
		
		
		//------------------------------------------------
		var accion=$('#num_accion').val();
		var direccion = $('#userDir').val();//userDir
		var user = $('#txtUser').val();
		//------------------------------------------------
		var confirma = confirm("La accion pasara al estado \n\n - Dictamen Técnico por no Solventación de PO \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
				{
					$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
				},
				complete: function(objeto, exito)
				{
					//alert("Me acabo de completar")
					//if(exito=="success"){ alert("Y con éxito"); }
				},
				type: "POST",
				url: "procesosAjax/po_proceso_pasos.php",
				data: {
						proceso: "DTNS",
						num_accion:$('#num_accion').val(),
						oficio_recepcionDTNS:$('#oficio_recepcionDTNS').val(),
						num_DT:$('#num_DT').val(),
						fecha_recepcionDTNS:$('#fecha_recepcionDTNS').val(),
						acuse_recepcionDTNS:$('#acuse_recepcionDTNS').val(),
						SICSA_recepcionDTNS:$('#SICSA_recepcionDTNS').val(),
						fecha_SICSA_recepcionDTNS:$('#fecha_SICSA_recepcionDTNS').val(),
						acuse_SICSA_recepcionDTNS:$('#acuse_SICSA_recepcionDTNS').val(),
						volante_recepcionDTNS:$('#volante_recepcionDTNS').val(),
						fecha_volante_recepcionDTNS:$('#fecha_volante_recepcionDTNS').val(),
						acuse_volante_recepcionDTNS:$('#acuse_volante_recepcionDTNS').val(),
						user:$('#txtUser').val(),
						fecha:$('#fecha_cambio').val(),
						hora:$('#hora_cambio2').val(),
						//Datos q pasan a PFRR
						entidad:$('#entidad').val(),
						cp:$('#cp').val(),
						auditoria:$('#auditoria').val(),
						direccion:$('#direccion').val(),
						subdirector:$('#subdirector').val(),
						abogado:$('#abogado').val(),
						po:$('#po').val(),
						monto_no_solventado:$('#monto_no_solventado').val(),
						subnivel:$('#subnivel').val(),
						DG:$('#DG').val(),
						prescripcion:$('#prescripcion').val()
					},
				//data: "proceso=DTNS&num_accion="+$('#num_accion').val()+"&oficio_recepcionDTNS="+$('#oficio_recepcionDTNS').val()
				//+"&num_DT="+$('#num_DT').val()+"&fecha_recepcionDTNS="+$('#fecha_recepcionDTNS').val() +"&acuse_recepcionDTNS="
				//+$('#acuse_recepcionDTNS').val()+"&SICSA_recepcionDTNS="+$('#SICSA_recepcionDTNS').val()+"&fecha_SICSA_recepcionDTNS="
				//+$('#fecha_SICSA_recepcionDTNS').val()+"&acuse_SICSA_recepcionDTNS="+$('#acuse_SICSA_recepcionDTNS').val() 
				//+"&volante_recepcionDTNS="+$('#volante_recepcionDTNS').val()+"&fecha_volante_recepcionDTNS="
				//+$('#fecha_volante_recepcionDTNS').val()+"&acuse_volante_recepcionDTNS="+$('#acuse_volante_recepcionDTNS').val()
				//+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(),
				error: function(objeto, quepaso, otroobj)
				{
					alert("Estas viendo esto por que fallé");
					alert("Pasó lo siguiente: "+quepaso);
				},
				success: function(datos)
				{ 
					//alert("Guardado...");
					//$('#cuadroRes').html(datos); 
    				cargarAcciones();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
			});
		}
	}
	
}}
//------------------------------------------------------------------------
function presuntoYresponsabilidad()
{
//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var dirAccion = $('#dirAccion').val();
	var user = $('#txtUser').val();
	var entidad_fiscalizada = $('#entidad_fiscalizada').val();
	var edoTraPro = $('#edoTraPro').val();
	//var tipo_abs = $('#tipo_abs').val();
	var	nopropor=$('#nopropor').val();
	var dano=$('#dano').val();
	var doctos=$('#doctos').val();
	var respon=$('#respon').val();
	var reintegro=$('#reintegro').val();
	var aclara=$('#aclara').val();
	var resp=$('#resp').val();
	var sobre=$('#sobre').val();

var error=0;		
var mensaje ="";

if(comprobarForm('presuntosResponsabilidad'))
	
//------------------------------------------------------------------------------------------
if (resp= "responsabilidad" )
{
	error==0;
	
	} else {
		
		if (sobre= "sobreseimiento" )
{
	error==0;
	
	} else{ 
	
if ($('#nopropor:checked').val() == "on" || $('#dano:checked').val() == "on" || $('#doctos:checked').val() == "on"  || $('#respon:checked').val() == "on" || $('#reintegro:checked').val() == "on" || $('#aclara:checked').val() == "on" )
		{
			
		}
		else 
		{
			error++;
			mensaje+= "\n -Elija al menos una opción";
		}
}




	}





if(error != 0) alert(mensaje);
		//------------------------------------------------------------------------------------------
		if(error == 0)
		{
var confirma = confirm("Se guardarán las opciónes seleccionadas \n\n ¿Desea continuar? ");
		if(confirma)
		{
			var accion=$('#num_accion').val();
			$.ajax
			({
				beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				data: 
				{
	proceso: 'responsabilidadYpresuntos',
	num_accion:$('#num_accion').val(),
	direccion:$('#userDir').val(),//userDir
	dirAccion:$('#dirAccion').val(),
	cp:$('#cp').val(),
	user:$('#txtUser').val(),
	entidad_fiscalizada:$('#entidad').val(),
	edoTraPro:$('#edoTraPro').val(),
	nopropor:$('#nopropor:checked').val(),
	dano:$('#dano:checked').val(),
	doctos:$('#doctos:checked').val(),
	respon:$('#respon:checked').val(),
	reintegro:$('#reintegro:checked').val(),
	aclara:$('#aclara:checked').val(),
	
	
	
	
},
//
					error: function(objeto, quepaso, otroobj)
					{
						//alert("Estas viendo esto por que fallé");
						//alert("Ha ocurrido un error en Asistencia Jurídica!!! \n\n - Pasó lo siguiente: "+quepaso);
					},
				success: function(data) 
				{ 	
					alert(data);
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidad_fiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/pfrr_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
				}
				});
			}//end confirma
		}// end if error
	}// end if comprbarform
	
	
	
	
//------------------------------------------------------------------------
//------------------------------------------------------------------------
//------------------------------SOBRESEIMIENTO----------------------------
function FecierreInstruccionxx(cambiaEdo22)
{
	if(comprobarForm('formCierreInstruccion_2'))
	{
		if(cambiaEdo22 == 1) 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion_2").val()+' \n\n Cambiara el estado de la accion a:  \n\n  " En Elaboración de resolución y, en su caso, PDR" \n\n ¿Desea continuar?');
		else 
			var confirma = confirm('Cierre de instrucción '+$("#fechaCierreInstruccion_2").val()+' \n\n ¿Desea continuar?');
		
		//---------- si todo se acepta ---------------
		if(confirma)
		{
			$.ajax({
				type: "POST",
				url: "procesosAjax/pfrr_presuntos_proceso.php",
				//beforeSend: function(){  },
				data: 
				{
					tipoFecha: 	'FecierreInstruccionxx',
					cambiaEdo22:cambiaEdo22,
					accion:		$("#num_accion").val(),
					usuario: 	$("#indexUser").val(),
					fecha :		$("#fechaCierreInstruccion_2").val()
				},
				success: function(data) 
				{ 	
					//alert(data);
					cargarAccionespfrr();
					compruebaNot();
					cerrarCuadro2();
					mostrarCuadro(500,1200," "+$("#num_accion").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#entidad_fiscalizada").val()+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+$("#edoTraPro").val(),50,"cont/pfrr_proceso.php","numAccion="+$("#num_accion").val()+"&usuario="+$("#userDir").val()+"&direccion="+$("#userDir").val()+"");
				}
			});
			//cerrarCuadro();
		}
	}
}
	
	
	
	
	
	

//------------------------------------------------------------------------
//------------------------------------------------------Baja por conclusion previa------------------------

function Baja()
{
	//------------------------------------------------
	var accion=$('#num_accion').val();
	var direccion = $('#userDir').val();//userDir
	var user = $('#txtUser').val();
	var entidadFiscalizada = $("#entidad_fiscalizada").val();
	var edoTraPro = $("#edoTraPro").val();
	//------------------------------------------------
	if(comprobarForm('formbaja'))
	{
		//------------------------------------------------
		var accion=$('#num_accion').val();
		var direccion = $('#userDir').val();//userDir
		var user = $('#txtUser').val();
		//------------------------------------------------
		//------------------------------------------------------------------------------------------
		var error=0;
		var valor = $('#oficio_recepcion3').val();
		var valor2 = $('#volante_recepcion2').val();
		var mensaje = "\n - Los campos marcados en color amarillo estan mal ingresados";
		
		if(validaSolBaja(valor) != true) 
		{
			document.getElementById('oficio_recepcion3').style.borderColor = 'yellow';
			error++;
		}
		if(validaVolante(valor2) != true) 
		{
			document.getElementById('volante_recepcion2').style.borderColor = 'yellow';
			error++;
		}
		
		//------------------------------------------------------------------------------------------
		if(error != 0) alert(mensaje);
		if(error == 0)
		{
			var confirma = confirm("La accion pasara al estado \n\n - Baja por Conclusión Previa a la Emisión \n\n ¿Desea continuar? ");
			if(confirma)
			{
				var accion=$('#num_accion').val();
				$.ajax
				({
					beforeSend: function(objeto)
					{
						$('#cuadroRes').html('<center><img src="images/load_grande.gif" style="margin:100px 0"></center>');
					},
					complete: function(objeto, exito)
					{
						//alert("Me acabo de completar")
						//if(exito=="success"){ alert("Y con éxito"); }
					},
					type: "POST",
					url: "procesosAjax/po_proceso_pasos.php",
					data: "proceso=baja&num_accion="+$('#num_accion').val()+"&oficio_recepcion3="+$('#oficio_recepcion3').val()+"&f13fecha_recepcion="+$('#f13fecha_recepcion').val()+"&f14acuse_recepcion="+$('#f14acuse_recepcion').val() +"&volante_recepcion2="+$('#volante_recepcion2').val()+"&f15fecha_volante_recepcion="+$('#f15fecha_volante_recepcion').val()+"&f16fecha_volante_recepcion="+$('#f16fecha_volante_recepcion').val()+"&user="+$('#txtUser').val()+"&fecha="+$('#fecha_cambio').val()+"&hora="+$('#hora_cambio2').val(),
					error: function(objeto, quepaso, otroobj)
					{
						alert("Estas viendo esto por que fallé");
						alert("Pasó lo siguiente: "+quepaso);
					},
					success: function(datos)
					{ 
						//alert("Guardado...");
						//$('#resGuardar').html(datos); 
						cargarAcciones();
						mostrarCuadro(500,1200," "+accion+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+entidadFiscalizada+"&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+edoTraPro,50,"cont/po_proceso.php","numAccion="+accion+"&usuario="+user+"&direccion="+direccion+"");
					}
				});
			}//end confirma
		}//end valida
	}
}
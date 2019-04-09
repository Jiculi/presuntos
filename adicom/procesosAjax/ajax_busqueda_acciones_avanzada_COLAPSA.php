<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/html;charset=utf-8");

require_once("../includes/clases2.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$valor = valorSeguro($_POST['valor']);
$ef = valorSeguro($_POST['ef']);
$cp = valorSeguro($_POST['cp']);
$aud = valorSeguro($_POST['aud']);
$edoTram = valorSeguro($_POST['edoTram']);
$po=valorSeguro($_POST['pobus']);
$uaa=valorSeguro($_POST['uaa']);
$fondo=valorSeguro($_POST['fondo']);
$director=valorSeguro($_POST['director']);
$subdirector=valorSeguro($_POST['subdirector']);
$presunto=valorSeguro($_POST['presunto']);
$edoSicsa=valorSeguro($_POST['edoSicsa']);
$fecha=valorSeguro($_POST['fecha']);
$anio=valorSeguro($_POST['anio']);
$limit = valorSeguro($_POST['limit']);
/*
if($limit == "") $limit = "limit 0,50";
else $limit = valorSeguro($_POST['limit']);
*/


if($po !="")
{$sqlpo="and numero_de_pliego= ".$po."";

}

else
{
	$sqlpo="";
}

			if($uaa !="")
		{$sqluaa="and UAA LIKE '%".$uaa."%";
		
		}
		
		else
		{
			$sqluaa="";
		}
			
				if($fondo !="")
	{$sqlfondo="and fondo LIKE '%".$fondo."%";
	
	}
	
	else
	{
		$sqlfondo="";
	}
	
											
						if($subdirector !="")
						{$sqlsub="and subdirector LIKE '%".$subdirector."%'";
						
						}
						
						else
						{
							$sqlsub="";
						}
					
								if($presunto !="")
								{$sqlpresunto="and po_presuntos.servidor_contratista  LIKE '%".$presunto."%'";
								
								}
								
								else
								{
									$sqlpresunto="";
								}
								
								

												if  ($edoTram != 0 )
												{$sqledoT= " AND detalle_de_estado_de_tramite = ".$edoTram." ";
													
													}
													else
													{
													$sqledoT= "";
													}
												
														if  ($valor != "" )
													{$sqlvalor= "and  po.num_accion LIKE '%".$valor."%'";
														
														}
														else
														{
														$sqlvalor= "";
														}
																if  ($ef != "" )
														{$sqlef= " AND  entidad_fiscalizada  LIKE '%".$ef."%'";
															
															}
															else
															{
															$sqlef= "";
															}
														
																			if  ($aud != "" )
															{$sqlaud= " AND num_auditoria LIKE '%".$aud."%'";
																
																}
																else
																{
																$sqlaud= "";
																}
													
																						if  ($cp != 0 )
																			{$sqlcp= " AND cp = ".$cp."";
																				
																				}
																				else
																				{
																				$sqlcp= "";
																				}
			
					
					if($fecha !=0 and $anio!=0)
						{$sqlfecha="and prescripcion between '".$anio."-".$fecha."-01' and '".$anio."-".$fecha."-31'";
						
						}
						
						else
						{
							$sqlfecha="";
						}
						
						if($fondo !="")
						{$sqlfondo="and fondos.fondo LIKE '%".$fondo."%'";
						
						}
						
						else
						{
							$sqlfondo="";
						}
						
						
						if($uaa !="")
						{$sqluaa="and fondos.uaa LIKE '%".$uaa."%'";
						
						}
						
						else
						{
							$sqluaa="";
						}
						
						if ($director !="")
						
						{$sqldirector="and usuarios.nombre LIKE  '%".$director."%' and usuarios.perfil='Director'";
							}
						
			
				

$direccion = $_SESSION['direccion'];

//echo $_SESSION['nombre'];
//echo "Valor = ". $valor;
//------------------------------------------------------------------------------
//  si mandan la variables es por que estan llamando el script, sino es por que
//  se esta ejecutando en la pagina de escritorio.php que ya contine los archivos incluidos
//------------------------------------------------------------------------------
if(isset($_POST['valor']))
{
		if($direccion == 'DG')
		
		{
			$txtsql="SELECT  po.num_accion pona, entidad_fiscalizada, cp, subdirector, abogado, po.direccion, abogado,detalle_de_estado_de_tramite, numero_de_pliego,prescripcion, po_presuntos.num_accion, fondos.num_accion, fondos.uaa, usuarios.direccion 
									  FROM po 
									  
									  LEFT JOIN fondos on fondos.num_accion= po.num_accion
									  LEFT JOIN usuarios on usuarios.direccion=po.direccion
									   LEFT JOIN  po_presuntos  on  po.num_accion=po_presuntos.num_accion 
									  WHERE  1=1 $sqlvalor $sqledo $sqlsub $sqlef  $sqlaud  $sqlcp  $sqledoT $sqlpo $sqlSicsa $sqlfecha $sqlpresunto $sqlfondo $sqluaa $sqldirector $limit";
									  
									 

									  
									  
									  
			$sql = $conexion->select($txtsql ,false);
			$total = mysql_num_rows($sql);
		}
		else
		{
			$txtsql="SELECT  po.num_accion pona, entidad_fiscalizada, cp, subdirector, abogado, po.direccion, abogado,detalle_de_estado_de_tramite, numero_de_pliego,prescripcion, po_presuntos.num_accion, fondos.num_accion, fondos.uaa, usuarios.direccion 
									  FROM po 
									  LEFT JOIN fondos on fondos.num_accion= po.num_accion
									  LEFT JOIN usuarios on usuarios.direccion=po.direccion
									   LEFT JOIN  po_presuntos  on  po.num_accion=po_presuntos.num_accion 
									  WHERE direccion = '".$direccion."'  $sqlvalor $sqledo $sqlsub $sqlef  $sqlaud  $sqlcp  $sqledoT $sqlpo $sqlSicsa $sqlfecha $sqlpresunto $sqlfondo $sqluaa $sqldirector  $limit";
			$sql = $conexion->select($txtsql , false);
									  
			$total = mysql_num_rows($sql);
		}
}
else /// si no mandan peticion se carga todo ------------------
{
	if($direccion == 'DG')
	{
		$sql = $conexion->select("SELECT detalle_estado, num_accion,entidad_fiscalizada,cp,subdirector,abogado,direccion,abogado,detalle_de_estado_de_tramite, numero_de_pliego
								  FROM po 
								  INNER JOIN estados_tramite ON detalle_de_estado_de_tramite = id_estado ",false);
		$total = mysql_num_rows($sql);
	}
	else
	{
		$sql = $conexion->select("SELECT detalle_estado, num_accion,entidad_fiscalizada,cp,subdirector,abogado,direccion,abogado,detalle_de_estado_de_tramite
								  FROM po 
								 
								  WHERE direccion = '".$direccion."' ",false);
		$total = mysql_num_rows($sql);
	}
	
}
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
$tabla = '
<form id="mainform" action="" class="formTabla">
            <table border="0" cellpadding="0" cellspacing="0" id="product-table" >
			<tbody>
';

while($r = mysql_fetch_array($sql))
{
	$i++;
	$res = $i%2;
	if($res == 0) $estilo = "class='non'";
	else $estilo = "class='par'";
	
	//------------ MUESTRA FILAS LA FUNCION PROCESO PO SE ENCARGA DE ABRIR EL CUADRO Y CARGAR LA PAGINA ---------------
	$tabla .= '
            <tr '.$estilo.' >
                <td class="accion">'.str_replace($valor,"<span class='b'>".$valor."</span>",$r['pona']).'</td>
                <td class="entidad">'.$r['entidad_fiscalizada'].'</td>
                <td class="direccion">'.$r['direccion'].'</td>
                <td class="subdirector">'.$r['subdirector'].'</td>
                <td class="abogado">'.$r['abogado'].'</td>
				<td class="estado">'.dameEstado($r['detalle_de_estado_de_tramite']).'</td>
					<td class="acciones">
					<a href="#" title="Ver Informacion" class="icon-5 info-tooltip" onclick=\'var cuadro1 = new mostrarCuadro(600,900,"Informacion de la Acción '.$r['pona'].'",20,"cont/po_informacion.php","numAccion='.$r['pona'].'")\'></a>
					<a href="#" title="Modificar" class="icon-1 info-tooltip" onclick=\'var cuadro2 = new mostrarCuadro(500,1100,"Accion '.$r['pona'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['entidad_fiscalizada'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$r['detalle_estado'].'",50,"cont/po_proceso.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'")\'></a>
					<a href="#" title="Presuntos" class="icon-6 info-tooltip" onclick=\'var cuadro3 = new mostrarCuadro(500,800,"Presuntos de la Accion '.$r['pona'].' ",50,"cont/po_presuntos.php","numAccion='.$r['pona'].'&usuario='.$_SESSION['usuario'].'")\'></a>
					</td>
            </tr>
';
flush();
}
	$tabla .= '
			</tbody>
            </table>
            <!--  end product-table................................... --> 
            </form>
			';

if($total == 0) $tabla = "<center><br><br><br><br><br><h3> No se encontraron resultados </h3></center>";

/*echo "<script>document.getElementById('resTotal').innerHTML= '<br><h3>".$total." Acciones encontradas</h3>'</script>";*/
//echo $tabla."-|-".$total."-|-".urlencode($tabla)."-|-";
echo $tabla."|||".$total."|||".urlencode($tabla)."|||".nl2br($txtsql)."|||"."<br><br>".$sql;


//print_r($_POST);
echo $txtsql;
mysql_free_result($sql);
$conexion->desconnectar()
/*mysqli_close($conexion);*/
?>

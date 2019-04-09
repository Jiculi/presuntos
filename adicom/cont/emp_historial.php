<?php
require_once("../includes/clases.php");
require_once("../includes/funciones.php");
$conexion = new conexion;
$conexion->conectar();
//-------------------------- DESINFECTAR VARIABLES -----------------------------
//------------------------------------------------------------------------------
$id = valorSeguro($_REQUEST['id']);
$usu = $_REQUEST['emp'];

$nombre_fichero = "../empleados/credencial/".$id.".png";

if (file_exists($nombre_fichero)) 
{
	echo " <img src='empleados/credencial/".$id.".png' alt='' width='405' height='257' >  ";
} else { ?>
	</br> 
		<H3 align='center'> El fichero <?php echo $nombre_fichero; ?> no existe </H3>
		<form id='scred' name= 'scred' enctype='multipart/form-data' method='POST'>
		</br>
		<input name='uploadedfile' type='file' />
		</br></br>
		<input type='submit' value='Subir archivo' onClick="<? echo subida(); ?>" />
		</br>
		<input type='hidden' value='<?php echo $id; ?>' name='id' id='id' readonly />
	</br>
		</form>	
<?php
}

function subida()
{
	
$id = valorSeguro($_REQUEST['id']);

$uploadedfileload="true";
$uploadedfile_size=$_FILES['uploadedfile'][size];
echo $_FILES[uploadedfile][name];
//if ($_FILES[uploadedfile][size]>200000)
//{$msg=$msg."El archivo es mayor que 200KB, debes reduzcirlo antes de subirlo<BR>";
//$uploadedfileload="false";}
/*
if (!($_FILES[uploadedfile][type] =="image/png"))
{$msg=$msg." Tu archivo tiene que ser PNG. Otros archivos no son permitidos<BR>";
$uploadedfileload="false";} */

$file_name=$_FILES[uploadedfile][name];
$add="../empleados/credencial/".$id;
if($uploadedfileload=="true"){

if(move_uploaded_file ($_FILES[uploadedfile][tmp_name], $add.".png")){
echo " Ha sido subido satisfactoriamente";
}else{echo "Error al subir el archivo";}

} else{echo $msg;}

}
?>

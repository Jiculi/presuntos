<?php
class conexion{
	
	function conexion()
	{
		$this->host = 'localhost';
		$this->db = 'dgr';
		$this->user = 'root';
		$this->pass = '';
	}
	
	function conectar()
	{
	    $conexion = mysql_pconnect($this->host, $this->user, $this->pass)or die("<br><b>Error al conectar Base de Datos</b> <br>".mysql_error);
    	mysql_select_db($this->db, $conexion) or die("<b>Error al conectar Base de Datos</b> <br>".mysql_error);
		mysql_query("SET NAMES 'utf8'");
		//@mysql_query("SET collation_connection = utf8_spanish_ci;"); 
		/*
        try {
            $conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db.'',''.$this->user.'',''.$this->pass.'');
            //echo "Conexión realizada con éxito !!!";
        }
        catch (PDOException $ex) {
            echo $ex->getMessage();
            exit;
        }   
		*/
    } 
	
	function desconnectar()
	{
	    mysql_close();
    }
	//-------------------------------------------------- SELECT -------------------------------------------------------
	function select($sql,$bitacora = false)
	{
		/*
		$conn = $this->conectar();
		$result = $conn->prepare($sql);
		$result->execute();
		return $resultado;
		*/
		
		$resultado = mysql_query($sql) or die("<p style='background:white; color: red; padding:5px'>".mysql_error()." <br> - <b>Consulta Select</b>: ".$sql."</p>");
		return $resultado;
	}
	
	function insert($sql,$bitacora = true)
	{
		$resultado = mysql_query($sql) or die(mysql_error()." <br> - <b>Consulta Insert</b>: ".$sql);
		return $resultado;
	}
	
	function update($sql,$bitacora = true)
	{
		$resultado = mysql_query($sql) or die(mysql_error()." <br> - <b>Consulta Update</b>: ".$sql);
		return $resultado;
	}
	
	function delete($sql,$bitacora = true)
	{
		$resultado = mysql_query($sql) or die(mysql_error()." <br> - <b>Consulta Delete</b>: ".$sql);
		return $resultado;
	}
}
?>
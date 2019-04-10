<?php
header('Content-Type: text/html; charset=UTF-8'); 
 
class libreria
{
  
    public function getJuicios(){
        $pdo = Database::connect();
        $sql = 'SELECT juiciosnew.*,  pfrr.cp, pfrr.entidad FROM juiciosnew
        LEFT JOIN pfrr ON juiciosnew.accion = pfrr.num_accion';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }		
	
    public function getPermisos($llave, $llave2){
        $pdo = Database::connect();
		if (!empty($llave)) {
            $sql  = 'SELECT *, DATE_FORMAT(ultimo_pago_finaliza, "%Y %m %d") AS pago FROM permisos
            WHERE (colonia LIKE :pat) AND (YEAR(ultimo_pago_finaliza) LIKE :pat2)';
 	        $stmt = $pdo->prepare($sql);
		    $stmt->bindParam("pat", $llave, PDO::PARAM_STR);
		    $stmt->bindParam("pat2", $llave2, PDO::PARAM_STR);
		} else {
            $sql  = 'SELECT * FROM permisos';
			$stmt = $pdo->prepare($sql);
		}	
        $stmt->execute();
		return $stmt->fetchAll();
    }



    public function getPermisosPago($mColonia){
        $pdo = Database::connect();
        $sql  = 'SELECT colonia FROM permisos';
		
        $sql  = 'SELECT colonia, Count(cve_unica) AS permisos,
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) = "2017" THEN cve_unica ELSE null END) AS "2017",
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) = "2016" THEN cve_unica ELSE null END) AS "2016",
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) = "2015" THEN cve_unica ELSE null END) AS "2015",
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) = "2014" THEN cve_unica ELSE null END) AS "2014",
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) = "2013" THEN cve_unica ELSE null END) AS "2013",
        COUNT(CASE WHEN YEAR(ultimo_pago_finaliza) <= "2012" THEN cve_unica ELSE null END) AS "2012"
        FROM permisos
        GROUP BY colonia
        ORDER BY Count(cve_unica) DESC';		
		
		$stmt = $pdo->prepare($sql);
        $stmt->execute();
		return $stmt->fetchAll();
    }	

 	
	
    public function dameLider($clave)
    {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT nomrep FROM asociaciones WHERE id=:pat");
            $query->bindParam("pat", $clave, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
				return $resultado->nomrep;
            } else return "no se encuentra";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


	

    public function dameCuadra($clave)
    {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT id, ubic, entre1, entre2 FROM cuadras WHERE id=:pat ORDER BY ubic,entre1");
            $query->bindParam("pat", $clave, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
				$cuadra = $this->dameCalle($resultado->ubic) . ' - ';
				$cuadra .= $this->dameCalle($resultado->entre1) . ' - ';
				$cuadra .= $this->dameCalle($resultado->entre2);				
			
				return $cuadra;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    
    public function dameIdPuesto($clave)
    {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT id FROM puestos WHERE cve_unica=:pat ");
            $query->bindParam("pat", $clave, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
				return $resultado->id;
            } 
			else
			{
				return '*';
		    }
		
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }	

}
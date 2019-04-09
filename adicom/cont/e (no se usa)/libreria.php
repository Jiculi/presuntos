<?php
header('Content-Type: text/html; charset=UTF-8'); 
 
class libreria
{
  

    public function dameEstado($clave) {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT detalle_estado FROM estados_tramite WHERE id_estado =:pat");
            $query->bindParam("pat", $clave, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
                return $resultado->detalle_estado;
            } else return "no se encuentra";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function dameSubdirector($clave) {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT nombre FROM usuarios WHERE nivel =:pat");
            $query->bindParam("pat", $clave, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
                return $resultado->nombre;
            } else return "no se encuentra";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function dameDirector($clave) {
        try {
            $pdo = Database::connect();	
            $query = $pdo->prepare("SELECT nombre FROM usuarios WHERE nivel =:pat");
            $query->bindParam("pat", $clave, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $resultado = $query->fetch(PDO::FETCH_OBJ);
                return $resultado->nombre;
            } else return "no se encuentra";
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getAmparosIn(){
        $pdo = Database::connect();
        $sql = 'SELECT * FROM ai WHERE 1 ';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getTribunal(){
        $pdo = Database::connect();
        $sql = 'SELECT id, tribunal FROM juiciosnew WHERE tribunal IS NOT NULL ';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }
    


    public function getJuicios(){
        $pdo = Database::connect();
        $sql = 'SELECT juiciosnew.*,  pfrr.cp, pfrr.entidad FROM juiciosnew
        LEFT JOIN pfrr ON juiciosnew.accion = pfrr.num_accion';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getJuiciosRRF(){
        $pdo = Database::connect();
        $sql = 'SELECT juiciosnew.*,  pfrr.cp, pfrr.entidad FROM juiciosnew
        LEFT JOIN pfrr ON juiciosnew.accion = pfrr.num_accion
        WHERE juiciosnew.toca_en_revision = "si" ';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getJuiciosAD(){
        $pdo = Database::connect();
        $sql = 'SELECT juiciosnew.*,  pfrr.cp, pfrr.entidad FROM juiciosnew
        LEFT JOIN pfrr ON juiciosnew.accion = pfrr.num_accion
        WHERE juiciosnew.toca_amparo = "si" ';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getJCAcontrol01() {
        $pdo = Database::connect();
        $sql = 'SELECT resultado, count(juicionulidad) as juicios,
        COUNT(CASE WHEN fechanot is null THEN juicionulidad ELSE null END) AS "falta",
        COUNT(CASE WHEN fechanot = "0000-00-00" THEN juicionulidad ELSE null END) AS "ceros",
        COUNT(CASE WHEN fechanot <= "2017-12-31" and fechanot <> "0000-00-00" THEN juicionulidad ELSE null END) AS "Reporte",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" THEN juicionulidad ELSE null END) AS "2018",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "01" THEN juicionulidad ELSE null END) AS "Ene",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "02" THEN juicionulidad ELSE null END) AS "Feb",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "03" THEN juicionulidad ELSE null END) AS "Mar",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "04" THEN juicionulidad ELSE null END) AS "Abr",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "05" THEN juicionulidad ELSE null END) AS "May",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "06" THEN juicionulidad ELSE null END) AS "Jun",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "07" THEN juicionulidad ELSE null END) AS "Jul",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "08" THEN juicionulidad ELSE null END) AS "Ago",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "09" THEN juicionulidad ELSE null END) AS "Sep",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "10" THEN juicionulidad ELSE null END) AS "Oct",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "11" THEN juicionulidad ELSE null END) AS "Nov",
        COUNT(CASE WHEN YEAR(fechanot) = "2018" and MONTH(fechanot) = "12" THEN juicionulidad ELSE null END) AS "Dic",
        COUNT(CASE WHEN YEAR(fechanot) = "2019" THEN juicionulidad ELSE null END) AS "2019"
        From juiciosnew 
        group by resultado';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getJCAcontrol02() {
        $pdo = Database::connect();
        $sql = 'SELECT resultado, count(juicionulidad) as juicios,
        COUNT(CASE WHEN f_resolucion is null THEN juicionulidad ELSE null END) AS "falta",
        COUNT(CASE WHEN f_resolucion = "0000-00-00" THEN juicionulidad ELSE null END) AS "ceros",
        COUNT(CASE WHEN f_resolucion <= "2017-12-31" and f_resolucion <> "0000-00-00" THEN juicionulidad ELSE null END) AS "Reporte",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" THEN juicionulidad ELSE null END) AS "2018",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "01" THEN juicionulidad ELSE null END) AS "Ene",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "02" THEN juicionulidad ELSE null END) AS "Feb",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "03" THEN juicionulidad ELSE null END) AS "Mar",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "04" THEN juicionulidad ELSE null END) AS "Abr",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "05" THEN juicionulidad ELSE null END) AS "May",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "06" THEN juicionulidad ELSE null END) AS "Jun",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "07" THEN juicionulidad ELSE null END) AS "Jul",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "08" THEN juicionulidad ELSE null END) AS "Ago",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "09" THEN juicionulidad ELSE null END) AS "Sep",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "10" THEN juicionulidad ELSE null END) AS "Oct",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "11" THEN juicionulidad ELSE null END) AS "Nov",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2018" and MONTH(f_resolucion) = "12" THEN juicionulidad ELSE null END) AS "Dic",
        COUNT(CASE WHEN YEAR(f_resolucion) = "2019" THEN juicionulidad ELSE null END) AS "2019"
        From juiciosnew 
        group by resultado';

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function getOficios(){
        $pdo = Database::connect();
        $sql = 'SELECT * FROM oficios WHERE tipoOficio = "medios"';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getVolantes($llave){
        $llave = "%$llave%";
        $pdo = Database::connect();
        $sql = 'SELECT id, folio FROM volantes WHERE folio LIKE :pat
                ORDER BY id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("pat", $llave, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
    }


    
    public function getVolantesContenido(){
        $pdo = Database::connect();
        $sql  = 'SELECT volantes_contenido.accion, volantes_contenido.presunto, volantes_contenido.folio, volantes.fecha_actual, 
                        volantes_contenido.tipoMovimiento, volantes_contenido.remitente, volantes_contenido.entidad_dependencia, 
                        volantes_contenido.turnado, volantes_contenido.direccion
                        FROM volantes 
                        LEFT JOIN volantes_contenido 
                        ON volantes.folio = volantes_contenido.folio';
		$stmt = $pdo->prepare($sql);
        $stmt->execute();
		return $stmt->fetchAll();
    }

    public function getPFRR(){
        $pdo = Database::connect();
        $sql = "SELECT * FROM pfrr
                WHERE  detalle_edo_tramite = 11 
                    OR detalle_edo_tramite = 13 
                    OR detalle_edo_tramite = 15 
                    OR detalle_edo_tramite = 30";


		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }


    public function getPFRRnotificaciones(){
        $pdo = Database::connect();
        $sql = "SELECT pfrr.cierre_instruccion AS cierre_instruccion, pfrr.entidad AS entidad,
pfrr.fecha_acuerdo_inicio AS fecha_acuerdo_inicio, pfrr.num_procedimiento AS num_procedimiento,
pfrr.resolucion AS resolucion, pfrr.superveniente AS superveniente, pfrr.fecha_notificacion_resolucion AS fecha_notificacion_resolucion,
pfrr.po AS numero_de_pliego,pfrr_presuntos_audiencias.nombre AS nombre, 
pfrr_presuntos_audiencias.accion_omision AS accion_omision,
pfrr_presuntos_audiencias.prescripcion_accion_omision AS prescripcion_accion_omision,pfrr_presuntos_audiencias.status AS status,
pfrr_presuntos_audiencias.monto AS monto,
pfrr_presuntos_audiencias.fecha_notificacion_oficio_citatorio AS fecha_notificacion_oficio_citatorio,
pfrr_presuntos_audiencias.tipo AS tipo, pfrr_presuntos_audiencias.responsabilidad AS responsabilidad,
pfrr.detalle_edo_tramite AS detalle_edo_tramite, pfrr.num_accion AS num_accion,
pfrr.cp AS cp, estados_sicsa.estado_sicsa AS estado_sicsa,
estados_tramite.detalle_estado AS detalle_estado,pfrr.fecha_edo_tramite AS fecha_edo_tramite 
from (((pfrr 
join pfrr_presuntos_audiencias 
on (((pfrr.num_accion = pfrr_presuntos_audiencias.num_accion)  )))
join estados_tramite on((pfrr.detalle_edo_tramite = estados_tramite.id_estado))) 
join estados_sicsa on((estados_tramite.id_sicsa = estados_sicsa.id_sicsa)))
order by pfrr.num_accion";


		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }


/*
group by pfrr.entidad, pfrr.fecha_acuerdo_inicio, pfrr.num_procedimiento, pfrr.resolucion,
pfrr.fecha_notificacion_resolucion, pfrr.po,pfrr.superveniente, pfrr_presuntos_audiencias.nombre,
pfrr_presuntos_audiencias.accion_omision, pfrr_presuntos_audiencias.prescripcion_accion_omision,
pfrr_presuntos_audiencias.status, pfrr_presuntos_audiencias.monto,
pfrr_presuntos_audiencias.fecha_notificacion_oficio_citatorio,pfrr.detalle_edo_tramite,pfrr.fecha_edo_tramite,
pfrr.num_accion,pfrr.cp,estados_sicsa.estado_sicsa,estados_tramite.detalle_estado,estados_sicsa.id_sicsa 
having ((estados_sicsa.id_sicsa = 8) and (pfrr_presuntos_audiencias.tipo <> 'titularICC')
and (pfrr_presuntos_audiencias.tipo <> 'titularTESOFE') and (pfrr_presuntos_audiencias.tipo <> 'responsableInforme')) 

*/


/* 
BETWEEN 23 AND 26 -->> Con Resolución 1a. Instancia
46

*/

    public function getPFRRplazo(){
        $pdo = Database::connect();

         $sql ="SELECT 	*,
                    DATEDIFF(limite_emision_resolucion,resolucion) AS difEmiRes,
                    DATEDIFF(limite_notificacion_resolucion,fecha_notificacion_resolucion) AS difNotRes 
            FROM pfrr 
            WHERE (detalle_edo_tramite BETWEEN 23 
                    AND 26 OR detalle_edo_tramite = 45 OR detalle_edo_tramite = 46 OR et_impugnacion = 45 OR et_impugnacion = 46) 
                    AND fecha_acuerdo_inicio <> '' 
            ORDER BY num_accion";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
    }


    public function getPFRRvencimiento(){
        $pdo = Database::connect();
        $sql = "SELECT *,  
                        (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) * -1) AS DifDias
                FROM pfrr
                WHERE (DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=30 
                || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <=60 
                || DATEDIFF( CURDATE( ) , limite_cierre_instruccion) <= 90) 
                AND (detalle_edo_tramite <> 29 
                AND detalle_edo_tramite <> 23 
                AND detalle_edo_tramite <> 24 
                AND detalle_edo_tramite <> 25 
                AND detalle_edo_tramite <> 26 
                AND detalle_edo_tramite < 32) 
                ORDER BY DifDias";

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
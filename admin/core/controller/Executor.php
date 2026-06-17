<?php

class Executor {

	public static function doit($sql){
		$con = Database::getCon();
		$query = $con->prepare($sql);
		$query->execute();
		$data= $query->fetch(PDO::FETCH_ASSOC);	
		Database::closeConnection($con);			
		return $data;
		
	}

	public static function doitAr($sql){
		$con = Database::getCon();
		$query = $con->prepare($sql);
		$query->execute();
		$data= $query->fetchAll(PDO::FETCH_ASSOC);	
		////print_r($query);
	 	//$arrayName = array($data);
		Database::closeConnection($con);			
		return $data;
		
	}	



public static function doitArr($sql, $params = array()) {
    $con = Database::getCon();
    
    try {
        $query = $con->prepare($sql);
        
        // Si hay parámetros, bindearlos
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                // Determinar el tipo de dato para el binding
                if (is_int($value)) {
                    $paramType = PDO::PARAM_INT;
                } elseif (is_bool($value)) {
                    $paramType = PDO::PARAM_BOOL;
                } else {
                    $paramType = PDO::PARAM_STR;
                }
                
                // Los marcadores de posición en PDO empiezan desde 1
                $query->bindValue($key + 1, $value, $paramType);
            }
        }
        
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        
        Database::closeConnection($con);
        return $data;
        
    } catch (PDOException $e) {
        Database::closeConnection($con);
        error_log("Error en la consulta SQL: " . $e->getMessage());
        return array();
    }
}


	public static function doitEx($sql){
		$con = Database::getCon();
		$query = $con->prepare($sql);
		$query->execute();	
		Database::closeConnection($con);
	}
}
?>
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

	


	public static function doitEx($sql){
		$con = Database::getCon();
		$query = $con->prepare($sql);
		$query->execute();	
		Database::closeConnection($con);
	}
}
?>
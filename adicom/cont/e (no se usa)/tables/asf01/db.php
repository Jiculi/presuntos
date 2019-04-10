<?php
	$database_username = 'root';
	$database_password = 'root';
	$pdo_conn = new PDO( 'mysql:host=localhost;dbname=dgr2'.';charset=utf8mb4', $database_username, $database_password );
//	self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName .';charset=utf8mb4', self::$dbUsername, self::$dbUserPassword);

?>
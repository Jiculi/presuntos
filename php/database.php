<?php
header('Content-Type: text/html; charset=UTF-8');   
class Database
{
    private static $dbName = 'dgr' ;
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'root';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
    }
     
    public static function connect()
    {
       // One connection through whole application
       if ( null == self::$cont )
       {     
           try
              {
              self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName .';charset=utf8mb4', self::$dbUsername, self::$dbUserPassword);
              }
            catch(PDOException $e)
              {
              die($e->getMessage()); 
              }
       }
       return self::$cont;
    }
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
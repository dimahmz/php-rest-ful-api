<?php 
require_once(__DIR__.'/../utils/Response.php');
require_once(__DIR__.'/../utils/Logger.php');
require_once(__DIR__.'/../config.php');


class Connection{
  private static $DBH;
  // Connect to the database
  static function connectToDb(){
    try{
      self::$DBH = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD);
      self::$DBH->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_WARNING);
    }catch(PDOException $e){
      // log the error into a file
      $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
      $log->error();
      // respond to the client
      Response::send_server_error();
    }
  }
  // get the database handler instance
  static function  getDbHandler(){
    // if the database connection hasn't been istablished yet
    if(self::$DBH == null){
      self::connectToDb();
      return self::$DBH;
    }
    return self::$DBH;

  }
}

// Test
// Connection::connectToDb();
// var_dump(Connection::getDbHandler());
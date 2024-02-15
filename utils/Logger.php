<?php
class Logger{
  public $message;
  public $datetime;

  public $file;

  function __construct(string $message , string $file){
    $this->message=$message;
    $this->file=$file;
    $this->datetime =  date("Y-m-d H:i:s");
  }

  private function log($logfile){
    $content = "TIME : $this->datetime \nINFO : $this->message\nFILE: $this->file\n\n\n";
    file_put_contents(__DIR__."/../log/$logfile.local.log", $content, FILE_APPEND);
  }

  function debug(){
    $this->log("debug");
  }
  function error(){
    $this->log("error");
  }
  function info(){
    $this->log("info");
  }
}

// // TEST
// $logger  = new Logger("hi hamza", $_SERVER['PHP_SELF']);
// $logger->info();
// var_dump($logger);
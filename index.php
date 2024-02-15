<?php

require_once "utils/Response.php";
require_once "DB/Connection.php";
require_once "utils/Logger.php";
require_once "Controllers/clients/index.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// establish the connection to the database
Connection::connectToDb();
$dbh=Connection::getDbHandler();


// // parse the incoming request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_array = explode("/", $uri);

// debuging
// $logger = new Logger(count($uri_array), __file__);
// $logger->debug();

// accept only the uri that starts with api
if ($uri_array[1] !== 'api') {
  Response::send_uri_not_found();
}

// if the url is uncompleted
if (count($uri_array)==1) {
  Response::send_uri_not_found();
}

$requestMethod= $_SERVER['REQUEST_METHOD'];

// get if it's set the id of the url
$id=null;
if(isset($uri_array[3])){
  $id= (int) $uri_array[3];
  if($id==0) $id=null;
}

switch($uri_array[2]){
  case "clients":{
    $clientController  = new ClientController($dbh, $requestMethod, $id);
    $clientController->processRequest();
    break;
  }
  default :
  Response::send_uri_not_found();
  break;
}


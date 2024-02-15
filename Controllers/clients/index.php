<?php 

require_once(__DIR__."/../../DB/Connection.php");
require_once(__DIR__."/../../utils/Response.php");
require_once(__DIR__."/../../utils/Logger.php");
require_once("validate.php");
require_once("gateway.php");

class ClientController{

  private $dbh;
  private $requestMethod;
  private $clientID;
  private $clientGateWay;

  function processRequest(){
    switch($this->requestMethod){
      case 'GET': {
        if(isset($this->clientID)){
          $this->findById();        
        }
        $this->findAll();
        break;
      }
      case 'POST': {
        $this->insertOne();
        break;
      }
      case 'DELETE': {
        $this->deleteOne();
        exit(0);
      }
      case 'PUT': {
        if(!isset($this->clientID)){
          Response::send_uri_not_found();
        }
        $this->updateOne();
        break;
      }
      default :{
        Response::send_uri_not_found();
      }
    }
  }

  function __construct($dbh, $requestMethod, $clientID){
    $this->dbh = $dbh;
    $this->requestMethod = $requestMethod;
    $this->clientID = (int) $clientID;
    $this->clientGateWay = new ClientGateWay($dbh);
  }
  // get all the clients
  function findAll(){
    $this->clientGateWay->findAll();
  }
  // get one client by id
  function findById(){
    $this->clientGateWay->findById($this->clientID) ;
  }

  function insertOne(){
    $inputs =json_decode(file_get_contents('php://input'), true);
    ValidateClientInsertion($inputs);
    $this->clientGateWay->insert($inputs);
  }

  function updateOne(){
    $inputs = json_decode(file_get_contents('php://input'), true);
    ValidateClientInsertion($inputs);
    $this->clientGateWay->updateOne($this->clientID, $inputs);
  }
  function deleteOne(){
    $this->clientGateWay->deleteById($this->clientID);
  }

}




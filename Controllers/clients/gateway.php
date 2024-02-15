<?php

require_once (__DIR__."/../../utils/Response.php");

class ClientGateWay {
  private $db = null;  
  public function __construct($db) {
      $this->db = $db;
  }
  public function findAll()
  {
    $statement = "select * from clients;";

    try {
      // prepare the statement
      $statement = $this->db->prepare($statement);
      $statement->execute();
      // if the table is empty in the database
      if($statement->rowCount() == 0){
        $response = new Response(true, "", [],"");
        $response->send_json_response();
      }
      // prepare the table rows in a table
      $payload=array("data"=>array());
      while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $client_item=array('client_id'=>$client_id, 'name'=>$name, 'address'=>$address, 'city'=>$city, 'state'=>$state,'phone'=>$phone);
        array_push($payload["data"], $client_item);
      }
      // send the response
      $response = new Response(true, "", $payload,"");
      $response->send_json_response();
    }
     catch (\PDOException $e) {
      $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
      $log->error();
      Response::send_server_error();
    }
  }
  public function findById($id)
    {
      $statement = "SELECT *  FROM clients WHERE client_id = ?;";
      try {
        // prepare the statement
        $statement = $this->db->prepare($statement);
        $statement->execute(array($id));
        
        // if the table is empty in the database
        if($statement->rowCount() == 0){
          $response = new Response(false, "client not found", [],"");
          $response->send_json_response();
        }

        // prepare row in a table
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $payload=array("data"=>array());
        extract($row);
        $client_item=array('client_id'=>$client_id, 'name'=>$name, 'address'=>$address, 'city'=>$city, 'state'=>$state,'phone'=>$phone);
        array_push($payload["data"], $client_item);

        // send the response
        $response = new Response(true, "", $payload,"");
        $response->send_json_response();
      } 
      catch (\PDOException $e) {
        $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
        $log->error();
        Response::send_server_error();
      }
    }

    public function insert(Array $input)
    {
        $statement ="INSERT INTO  clients (name, address, city, state, phone) VALUES (:name, :address, :city, :state, :phone);";

        try {
          // prepare
          $statement = $this->db->prepare($statement);
          $statement->execute(array(
            'name' => $input['name'],
            'address' => $input['address'],
            'city' => $input['city'],
            'phone' => $input['phone'],
            'state' => $input['state'],
          ));

          // row isn't inserted
          if($statement->rowCount()==0){
            Response::send_server_error();
          }

          // ID of the last inserted row
          $id=$this->db->lastInsertId();

          // response 
          $response = new Response(true, "New client has been added successfully",['id'=>$id ], "");
          $response->send_json_response();
        } catch (PDOException $e) {
          $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
          $log->error();
          Response::send_server_error();
        }
    }

    public function updateOne($id, Array $input)
    {
      $statement = "UPDATE clients SET name = :name WHERE client_id=1";
        try {
          $statement = $this->db->prepare($statement);
          $statement->execute(array(
            'id' => $id,
            'name' => $input['name'],
            'address'  => $input['address'],
            'city' => $input['city'],
            'state' => $input['state'],
            'phone' => $input['phone']
          ));
          // user doen't exist
          if($statement->rowCount()==0){
            $response = new Response(false, "client doesn't exist", [],"");
            $response->send_json_response();
          }
            $logger = new Logger($statement , __file__);
            $logger->debug();

            // client has been updated;
            $response = new Response(true, "client with ID : $id has been updated", [],"");
            $response->send_json_response();

        } catch (\PDOException $e) {
          $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
          $log->error();
          Response::send_server_error();
        }
    }

    public function deleteById($id)
    {
        $statement = "DELETE FROM clients WHERE client_id = :id;";
        try {
          $statement = $this->db->prepare($statement);
          $statement->execute(array('id' => $id));
          // row isn't inserted
          if($statement->rowCount()==0){
            $response = new Response(false, "user doesn't exist", [],"");
            $response->send_json_response();
          }
          // response
          $response = new Response(true, "client with ID : $id has been deleted", [],"");
          $response->send_json_response();
        } catch (\PDOException $e) {
          $log = new Logger($e->getMessage(), $_SERVER['PHP_SELF']);
          $log->error();
          Response::send_server_error();
      }
    }
}


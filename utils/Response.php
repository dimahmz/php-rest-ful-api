<?php
class Response{
  public $success;
  public $message;
  public $payload;
  public $description;

  public function __construct(bool  $success , String $message , mixed $payload , String  $description) {
    $this->success = $success;
    $this->message = $message;
    $this->payload = $payload;
    $this->description = $description;
  }

  function json_response(){
    $response_array = get_object_vars($this);
    $json_response=json_encode($response_array) ;
    return $json_response;    
  }

  function send_json_response() : void{
    $response_array = get_object_vars($this);
    $json_response=json_encode($response_array);
    header("Content-type: application/json");
    echo $json_response;    
    exit(0);
  }


  // a requested resource doesn't exist
  static function send_uri_not_found(){
    $response = new self(false, "resource not found",[], "");
    http_response_code(404);
    $response->send_json_response();
  }

  // an error in the server has occurred 
  static function send_server_error(){
    $response = new self(false, "an error in the server has occurred",[], "");
    $response->send_json_response();
  }

}

// Test

// $response = new Response(true, "The response has been prepared", ["name"=>"hamza"], "the data of hamza");
// header('Content-type: application/json');
// echo $response->json_response();
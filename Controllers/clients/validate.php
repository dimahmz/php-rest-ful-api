<?php
require_once (__DIR__."/../../utils/Response.php");
function ValidateClientInsertion(array $inputs){

  $response = new Response(false, "invalid inputs", [], "");

  if (!isset($inputs["name"]) || strlen($inputs["name"]) > 50) {
    $response->payload[] = ["name" => "the field name is required and should be maximum 50 characters"];
  }
  if (!isset($inputs["city"]) || strlen($inputs["city"]) > 50) {
    $response->payload[] = ["city" => "the field city is required and should be maximum 50 characters"];
  }
  if (!isset($inputs["address"]) || strlen($inputs["address"]) > 50) {
    $response->payload[] = ["address" => "the field address is required and should be maximum 50 characters"];
  }
  if (!isset($inputs["state"]) || strlen($inputs["state"]) > 2) {
    $response->payload[] = ["state" => "the field state is required and should be maximum 2 characters"];
  }
  if (!isset($inputs["phone"]) || strlen($inputs["phone"]) > 50) {
    $response->payload[] = ["phone" => "the field phone is required and should be maximum 50 characters"];
  }
  if (!empty($response->payload)) {
    $response->send_json_response();
  }
}
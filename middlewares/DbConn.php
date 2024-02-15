<?php
require_once (__DIR__."/../DB/Connection.php");
require_once (__DIR__."/../Response.php");

if(Connection::getDbHandler()==null) {
  $internallError= new Response(false, "Server Error", [], "an internal server error has occurred");
  echo $internallError->json_response();
  exit(1);
}
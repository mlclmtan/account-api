<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate account object
include_once dirname(__DIR__, 1).'\account.php';
  
$database = new Database();
$db = $database->getConnection();
  
$account = new Account($db);
  
// get account id
$data = json_decode(file_get_contents("php://input"));

// set key property to be deleted
$account->Account = $data->Account;
  
// delete the account
if($account->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("Code" => "0", "Message" => "", "Result" => array("IsOK" => true)));
}
  
// if unable to delete the account
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("Code" => "0", "Message" => "Unable to delete account.", "Result" => array("IsOK" => false)));
}
?>
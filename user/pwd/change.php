<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once dirname(__DIR__, 2).'\config\database.php';
  
// instantiate account object
include_once dirname(__DIR__, 2).'\account.php';
  
$database = new Database();
$db = $database->getConnection();
  
$account = new Account($db);
  
// get id of account to be edited
$data = json_decode(file_get_contents("php://input"));

// set key property of account to be edited
$account->Account = $data->Account;

// set account property values
$account->Password = $data->Password;
  
// edit the account
if($account->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("Code" => "0", "Message" => "", "Result" => array("IsOK" => true)));
}
  
// if unable to edit the account
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("Code" => "0", "Message" => "Unable to update passsword.", "Result" => array("IsOK" => false)));
}
?>
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

// set key property for login
$account->Account = $data->Account;
$account->Password = $data->Password;
  
// query products
$stmt = $account->login();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
    // set response code - 200 OK
    http_response_code(200);
  
    // show account data in json format
    echo json_encode(array("Code" => "0", "Message" => "", "Result" => null));
}else{
    // set response code - 400 StatusBadRequest
    http_response_code(400);
    
    // tell the user no account found
    echo json_encode(array("Code" => "2", "Message" => "Login Failed", "Result" => null));
}
?>
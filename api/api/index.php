<?php
// for strict var types
// declare(strict_types = 1);
// for auto load any class on src
require dirname(__DIR__) ."/vendor/autoload.php";
// calling Error Handler
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
// DOT env i need to create new folder env to keep my data secured 


// url trait 
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$part = explode("/" , $path);
$resource = $part[3]; 
$id  = $part[4] ?? null;

$database =new Database("localhost","php_auth_api","root","");

if($resource == "users"){
    $usergataway = new UsersGataway($database);
    $controller = new UsersController($usergataway);
    $controller->progressRequest($_SERVER['REQUEST_METHOD'],$id);
}
elseif($resource == "delete"){
    $conn = $database->getConnection();
    $sql = "DELETE FROM users 
        WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id" ,$id, PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->rowCount();
        if($row == 1)
            {
                echo json_encode(["message" =>"user Well deleted"]);
            }else{
                echo json_encode(["message" =>"Something went wrong try again later !"]);
            }
}else
{
http_response_code(400);
    exit;
}
// data base 

header('content-type:application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-headers: *");
header('Access-Control-Allow-Credentials: true');




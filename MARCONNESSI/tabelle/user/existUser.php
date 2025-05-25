<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->mail)){
    $user->mail = $data->mail;
    $exists = $user->isAlreadyExist();
    echo json_encode(array("exists" => $exists));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Parametro mail mancante."));
}
?>
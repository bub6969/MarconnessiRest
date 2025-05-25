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

if(!empty($data->mail) && !empty($data->password)){
    $user->mail = $data->mail;
    $user->password = $data->password;

    $result = $user->login();
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Credenziali non valide."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Dati incompleti."));
}
?>
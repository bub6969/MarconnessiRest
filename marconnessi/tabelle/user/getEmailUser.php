<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id > 0){
    $result = $user->getEmail($id);
    if($row = $result->fetch_assoc()){
        echo json_encode($row);
    } else {
        echo json_encode(array("message" => "Utente non trovato."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Parametro id mancante o non valido."));
}
?>
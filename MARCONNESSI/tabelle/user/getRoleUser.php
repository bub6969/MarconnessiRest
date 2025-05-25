<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once 'config/database.php';
include_once 'objects/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$mail = isset($_GET['mail']) ? $_GET['mail'] : '';

if($mail != ''){
    $result = $user->getRuolo($mail);
    if($row = $result->fetch_assoc()){
        echo json_encode($row);
    } else {
        echo json_encode(array("message" => "Utente non trovato."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Parametro mail mancante."));
}
?>
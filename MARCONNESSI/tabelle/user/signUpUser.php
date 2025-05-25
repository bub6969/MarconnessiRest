<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../models/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->mail) &&
    !empty($data->nome) &&
    !empty($data->cognome) &&
    !empty($data->data_nascita) &&
    !empty($data->ruolo) &&
    !empty($data->password) &&
    !empty($data->created)
){
    $user->mail = $data->mail;
    $user->nome = $data->nome;
    $user->cognome = $data->cognome;
    $user->data_nascita = $data->data_nascita;
    $user->ruolo = $data->ruolo;
    $user->password = $data->password;
    $user->created = $data->created;

    if($user->signup()){
        http_response_code(201);
        echo json_encode(array("message" => "Utente registrato correttamente."));
    } else {
        http_response_code(409);
        echo json_encode(array("message" => "Utente già esistente o errore di registrazione."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Dati incompleti."));
}
?>

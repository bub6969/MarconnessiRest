<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once 'risposta.php';

$database = new Database();
$db = $database->getConnection();
$risposta = new Risposta($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if(
        !empty($data->corpo) &&
        !empty($data->oggetto)
    ){
        $risposta->dataora = date('Y-m-d H:i:s');
        $risposta->allegato = isset($data->allegato) ? $data->allegato : null;
        $risposta->oggetto = $data->oggetto;
        $risposta->corpo = $data->corpo;

        if($risposta->create()){
            http_response_code(201);
            echo json_encode(array("message" => "Risposta inviata correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile inviare la risposta."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
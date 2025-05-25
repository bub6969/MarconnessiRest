<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once 'ticket.php';

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if(
        !empty($data->corpo) &&
        !empty($data->oggetto)
    ){
        $ticket->data = date('Y-m-d H:i:s');
        $ticket->allegato = isset($data->allegato) ? $data->allegato : null;
        $ticket->corpo = $data->corpo;
        $ticket->oggetto = $data->oggetto;

        if($ticket->create()){
            http_response_code(201);
            echo json_encode(array("message" => "Ticket creato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile creare il ticket."));
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
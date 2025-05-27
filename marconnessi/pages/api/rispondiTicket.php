<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
session_start();

include_once "../../config/database.php";
include_once "../../models/ticket.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id_ticket) && !empty($data->risposta_txt)) {
        $database = new Database();
        $db = $database->getConnection();
        $ticket = new Ticket($db);

        $ticket->id = $data->id_ticket;
        $ticket->risposta_txt = $data->risposta_txt;
        $ticket->data_risposta = date('Y-m-d H:i:s');

        if ($ticket->updateRisposta()) {
            echo json_encode(["success" => true, "message" => "Risposta inviata."]);
        } else {
            http_response_code(503);
            echo json_encode(["success" => false, "message" => "Errore nell'invio della risposta."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Dati incompleti."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Metodo non consentito."]);
}
?>
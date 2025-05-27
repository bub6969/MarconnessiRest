<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["ruolo"] != 3) {
    http_response_code(401);
    echo json_encode(array("message" => "Non autorizzato."));
    exit;
}

include_once "../../config/database.php";
include_once "../../models/ticket.php";

$database = new Database();
$db = $database->getConnection();

$ticket = new Ticket($db);
// Supponiamo che l'ID della persona sia salvato nella sessione con chiave "id_persona"
$result = $ticket->readByUser($_SESSION["id_persona"]);
$num = $result->num_rows;

if($num > 0){
    $tickets_arr = array();
    $tickets_arr["records"] = array();
    while($row = $result->fetch_assoc()){
        // Estrai i campi dal record
        extract($row);
        $ticket_item = array(
            "id" => $id,
            "oggetto_domanda" => $oggetto_domanda,
            "data_domanda" => $data_domanda,
            "domanda_txt" => $domanda_txt,
            "risposta_txt" => $risposta_txt // Può essere null o vuoto se non ancora risposto
        );
        array_push($tickets_arr["records"], $ticket_item);
    }
    http_response_code(200);
    echo json_encode($tickets_arr);
} else {
    http_response_code(200);
    echo json_encode(array("records" => array()));
}
?>

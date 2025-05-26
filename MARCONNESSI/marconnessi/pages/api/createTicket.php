<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

session_start();

// Usa il percorso corretto per includere i file
include_once "../../config/database.php";
include_once "../../models/ticket.php";

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

// Controlla se l'utente è autenticato
if (!isset($_SESSION["id_persona"])) {
    http_response_code(401);
    echo json_encode(array("message" => "Accesso negato. Effettua il login."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (!empty($data->oggetto_domanda) && !empty($data->domanda_txt)) {
        $ticket->oggetto_domanda = $data->oggetto_domanda;
        $ticket->domanda_txt = $data->domanda_txt;
        $ticket->id_persona = $_SESSION["id_persona"];

        if ($ticket->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Ticket creato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Errore durante la creazione del ticket."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Dati incompleti. Oggetto e testo sono obbligatori."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>

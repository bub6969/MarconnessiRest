<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../models/ticket.php';

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $ticket->read();
    if($result && $result->num_rows > 0){
        $arr = array();
        $arr["records"] = array();
        while ($row = $result->fetch_assoc()) {
            if (!is_null($row["allegato"])) {
                $row["allegato"] = base64_encode($row["allegato"]);
            }
            $arr["records"][] = $row;
        }
        echo json_encode($arr);
    } else {
        echo json_encode(array("message" => "Nessun ticket trovato."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
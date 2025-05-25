<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/user.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Solo GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mail = isset($_GET['mail']) ? $_GET['mail'] : '';
    if($mail != ''){
        $result = $user->getOrarioByMail($mail);
        if($result && $result->num_rows > 0){
            $arr = array();
            $arr["records"] = array();
            while ($row = $result->fetch_assoc()) {
                $arr["records"][] = $row;
            }
            echo json_encode($arr);
        } else {
            echo json_encode(array("message" => "Nessun orario trovato per questa mail."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Parametro mail mancante."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../models/annuncio.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

// Solo GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $annuncio->read();
    $arr = array();
    $arr["records"] = array();
    if($result && $result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            if (!is_null($row["allegato"])) {
                $row["allegato"] = base64_encode($row["allegato"]);
            }
            $arr["records"][] = $row;
        }
    }
    echo json_encode($arr);
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
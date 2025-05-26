<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../../config/database.php";
include_once "../../../models/annuncio.php";

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

$result = $annuncio->read();
$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}
echo json_encode(["records" => $records]);
?>
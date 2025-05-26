<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
session_start();

include_once "../../../config/database.php";
include_once "../../../models/annuncio.php";

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->oggetto_annuncio) && !empty($data->corpo_annuncio)) {
    $database = new Database();
    $db = $database->getConnection();
    $annuncio = new Annuncio($db);
    $annuncio->oggetto_annuncio = $data->oggetto_annuncio;
    $annuncio->corpo_annuncio = $data->corpo_annuncio;
    $annuncio->data_annuncio = date("Y-m-d H:i:s");
    $annuncio->id_persona = $_SESSION["id_persona"] ?? 1; // fallback per test

    if ($annuncio->create()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Errore creazione"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati incompleti"]);
}
?>
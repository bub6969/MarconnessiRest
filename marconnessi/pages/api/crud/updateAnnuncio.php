<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
include_once "../../../config/database.php";
include_once "../../../models/annuncio.php";

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->id_annuncio) && !empty($data->oggetto_annuncio) && !empty($data->corpo_annuncio)) {
    $database = new Database();
    $db = $database->getConnection();
    $annuncio = new Annuncio($db);
    $annuncio->id_annuncio = $data->id_annuncio;
    $annuncio->oggetto_annuncio = $data->oggetto_annuncio;
    $annuncio->corpo_annuncio = $data->corpo_annuncio;
    $annuncio->data_annuncio = date("Y-m-d H:i:s");

    if ($annuncio->update()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Errore update"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati incompleti"]);
}
?>
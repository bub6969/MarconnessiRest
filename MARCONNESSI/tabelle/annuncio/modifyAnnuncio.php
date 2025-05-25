<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../../models/annuncio.php';

$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    if (
        !empty($data->id_annuncio) &&
        !empty($data->oggetto) &&
        !empty($data->corpo) &&
        !empty($data->data_invio)
    ) {
        $annuncio->id_annuncio = $data->id_annuncio;
        $annuncio->oggetto = $data->oggetto;
        $annuncio->corpo = $data->corpo;
        $annuncio->data_invio = $data->data_invio;
        $annuncio->allegato = isset($data->allegato) ? $data->allegato : null;

        if ($annuncio->modify()) {
            http_response_code(200);
            echo json_encode(array("message" => "Annuncio modificato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile modificare l'annuncio."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile modificare l'annuncio: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
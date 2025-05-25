<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../../models/annuncio.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

// Solo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if(
        !empty($data->oggetto_annuncio) &&
        !empty($data->corpo_annuncio) &&
        !empty($data->data_annuncio) &&
        !empty($data->id_persona)
    ){
        $annuncio->oggetto_annuncio = $data->oggetto_annuncio;
        $annuncio->corpo_annuncio = $data->corpo_annuncio;
        $annuncio->data_annuncio = $data->data_annuncio;
        $annuncio->id_persona = $data->id_persona;

        if($annuncio->create()){
            http_response_code(201);
            echo json_encode(array("message" => "Annuncio creato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile creare l'annuncio."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile creare l'annuncio: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
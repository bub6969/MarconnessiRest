<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/classe.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$classe = new Classe($db);

// Solo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->classe)) {
        $classe->classe = $data->classe;

        if ($classe->createClasse()) {
            http_response_code(201);
            echo json_encode(array("message" => "Classe creata correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile creare la classe."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile creare la classe: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>

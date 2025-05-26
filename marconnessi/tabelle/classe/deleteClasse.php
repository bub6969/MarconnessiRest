<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/classe.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$classe = new Classe($db);

// Solo DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id_classe)) {
        $classe->id_classe = $data->id_classe;

        if ($classe->deleteClasse()) {
            http_response_code(200);
            echo json_encode(array("message" => "Classe eliminata correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile eliminare la classe."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile eliminare la classe: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>

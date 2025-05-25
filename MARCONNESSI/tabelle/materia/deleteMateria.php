<?php
// Headers per CORS e JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/materia.php';

// Connessione al database
$database = new Database();
$db = $database->getConnection();
$materia = new Materia($db);

// Solo DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->id_materia)) {
        $materia->id_materia = $data->id_materia;

        if ($materia->deleteMateria()) {
            http_response_code(200);
            echo json_encode(array("message" => "Materia eliminata correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile eliminare la materia."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile eliminare la materia: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>

<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../models/user.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"));
    if (
        !empty($data->id_persona) &&
        !empty($data->mail) &&
        !empty($data->nome) &&
        !empty($data->cognome) &&
        !empty($data->data_nascita) &&
        !empty($data->ruolo) &&
        !empty($data->password)
    ) {
        $user->id = $data->id_persona;
        $user->mail = $data->mail;
        $user->nome = $data->nome;
        $user->cognome = $data->cognome;
        $user->data_nascita = $data->data_nascita;
        $user->ruolo = $data->ruolo;
        $user->password = $data->password;

        if ($user->modify()) {
            http_response_code(200);
            echo json_encode(array("message" => "Utente modificato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile modificare l'utente."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Impossibile modificare l'utente: dati incompleti."));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Metodo non consentito."));
}
?>
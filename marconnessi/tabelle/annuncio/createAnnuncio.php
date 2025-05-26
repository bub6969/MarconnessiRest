<?php
// Set headers for API response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // Assuming create operations are POST
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// --- START: PATH HANDLING ---
// Get the current directory of this file
$current_dir = __DIR__;

// Calculate paths to config/database.php and models/annuncio.php
// Go up two directories (from tabelle/annuncio to marconnessi)
// Then go into 'config' or 'models'
$config_path = $current_dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'database.php';
$model_path = $current_dir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'annuncio.php';

// Check if files exist before attempting to include them
// This will give you a clear error message if the path is still wrong
if (!file_exists($config_path)) {
    http_response_code(500);
    echo json_encode(["message" => "Errore: file database.php non trovato. Percorso tentato: " . $config_path]);
    exit();
}
if (!file_exists($model_path)) {
    http_response_code(500);
    echo json_encode(["message" => "Errore: file annuncio.php non trovato. Percorso tentato: " . $model_path]);
    exit();
}

// Include database and Annuncio model files
include_once $config_path;
include_once $model_path;
// --- END: PATH HANDLING ---

// Instantiate database and Annuncio object
$database = new Database();
$db = $database->getConnection(); // This will be your mysqli object if database.php is mysqli based

// Check for database connection error immediately
if ($db->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Errore di connessione al database: " . $db->connect_error]);
    exit;
}

$annuncio = new Annuncio($db);

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Ensure data is not empty
if (
    !empty($data->oggetto_annuncio) &&
    !empty($data->corpo_annuncio) &&
    !empty($data->id_docente) // Assuming you pass id_docente for creation
) {
    // Set annuncio property values
    $annuncio->oggetto_annuncio = $data->oggetto_annuncio;
    $annuncio->corpo_annuncio = $data->corpo_annuncio;
    $annuncio->id_docente = $_SESSION['id_persona'] ?? $data->id_docente; // Use session id if available, otherwise use posted id
    // Set creation date to current timestamp
    $annuncio->data_annuncio = date('Y-m-d H:i:s');

    // Create the annuncio
    if ($annuncio->create()) { // Assuming Annuncio->create() handles the SQL INSERT
        http_response_code(201); // Created
        echo json_encode(array("message" => "Annuncio creato con successo."));
    } else {
        http_response_code(503); // Service Unavailable
        echo json_encode(array("message" => "Impossibile creare l'annuncio."));
    }
} else {
    // Data is incomplete
    http_response_code(400); // Bad Request
    echo json_encode(array("message" => "Impossibile creare l'annuncio. Dati incompleti."));
}

// Close the database connection (good practice)
$db->close();

?>
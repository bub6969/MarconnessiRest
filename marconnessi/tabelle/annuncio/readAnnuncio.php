<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../../models/annuncio.php";

$database = new Database();
$db = $database->getConnection(); // $db is a mysqli object now

// IMPORTANT: Check for connection error immediately
if ($db->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["message" => "Errore di connessione al database: " . $db->connect_error]);
    exit;
}

$annuncio = new Annuncio($db); // Pass the mysqli object to your Annuncio model

$stmt = $annuncio->read(); // This should now return a mysqli_stmt object

// --- THE FIX FOR ROW COUNT AND FETCHING ---
// For mysqli_stmt with SELECT queries, you need to use store_result() and num_rows
if ($stmt) {
    $result = $stmt->get_result(); // Ottieni mysqli_result direttamente

    if ($result->num_rows > 0) {
        $annunci_arr = array();
        $annunci_arr["records"] = array();

        while ($row = $result->fetch_assoc()) {
            $annuncio_item = array(
                "id_annuncio" => $row['id_annuncio'],
                "oggetto_annuncio" => $row['oggetto_annuncio'],
                "corpo_annuncio" => $row['corpo_annuncio'],
                "data_annuncio" => $row['data_annuncio'],
                "nome" => $row['nome'],
                "cognome" => $row['cognome']
            );
            array_push($annunci_arr["records"], $annuncio_item);
        }

        http_response_code(200);
        echo json_encode($annunci_arr);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Nessun annuncio trovato."));
    }

    $stmt->close(); // sempre chiudere lo statement

} else {
    // Handle error if $annuncio->read() returned false or preparation failed
    http_response_code(500);
    echo json_encode(array("message" => "Errore nella lettura degli annunci: " . $db->error));
}

$db->close(); // Close the database connection
?>
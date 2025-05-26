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
if ($stmt) { // Check if prepare was successful and $stmt is not false
    $stmt->store_result(); // Buffer the result set
    $num = $stmt->num_rows; // Get the number of rows

    if ($num > 0) {
        $annunci_arr = array();
        $annunci_arr["records"] = array();

        // Bind result variables for mysqli_stmt
        // You need to know the columns you are selecting in Annuncio->read()
        // Example: $stmt->bind_result($id_annuncio, $oggetto_annuncio, $corpo_annuncio, $data_annuncio, $nome, $cognome);
        // Let's assume you fetch by name, which is more common in modern MySQLi usage with get_result()
        $result = $stmt->get_result(); // Get a mysqli_result object from the statement

        while ($row = $result->fetch_assoc()) { // Use fetch_assoc() on the mysqli_result object
            // extract($row); // You can still use extract, but it's often safer to access directly
            $annuncio_item = array(
                "id_annuncio" => $row['id_annuncio'], // Access directly
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
    $stmt->close(); // Close the statement
} else {
    // Handle error if $annuncio->read() returned false or preparation failed
    http_response_code(500);
    echo json_encode(array("message" => "Errore nella lettura degli annunci: " . $db->error));
}

$db->close(); // Close the database connection
?>
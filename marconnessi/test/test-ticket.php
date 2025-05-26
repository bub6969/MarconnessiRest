
<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/ticket.php';

$database = new Database();
$db = $database->getConnection();
$ticket = new Ticket($db);

// 1. Test creazione ticket
echo "<h3>Test: Creazione Ticket</h3>";
$ticket->data = date("Y-m-d H:i:s");
$ticket->allegato = null; // oppure base64_encode(file_get_contents('file.pdf'))
$ticket->corpo = "Questo è il corpo del ticket di test.";
$ticket->oggetto = "Oggetto Test " . rand(1, 10000);

if ($ticket->create()) {
    echo "Ticket creato correttamente.<br>";
    $last_id = $db->insert_id;
} else {
    echo "Errore nella creazione del ticket.<br>";
    $last_id = null;
}

// 2. Test lettura ticket
echo "<h3>Test: Lettura Ticket</h3>";
$result = $ticket->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_domanda']} | Data: {$row['data']} | Oggetto: {$row['oggetto']} | Corpo: {$row['corpo']}<br>";
    }
} else {
    echo "Nessun ticket trovato.<br>";
}

// 3. (Opzionale) Test eliminazione ticket appena creato
if ($last_id) {
    echo "<h3>Test: Eliminazione Ticket</h3>";
    $deleteQuery = "DELETE FROM domande WHERE id_domanda = ?";
    $stmt = $db->prepare($deleteQuery);
    $stmt->bind_param("i", $last_id);
    if ($stmt->execute()) {
        echo "Ticket eliminato correttamente.<br>";
    } else {
        echo "Errore nell'eliminazione del ticket.<br>";
    }
}
?>
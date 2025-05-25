// File: profilo.php
<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/risposta.php';

$database = new Database();
$db = $database->getConnection();
$risposta = new Risposta($db);

// 1. Test creazione risposta
echo "<h3>Test: Creazione Risposta</h3>";
$risposta->dataora = date("Y-m-d H:i:s");
$risposta->allegato = null; // oppure base64_encode(file_get_contents('file.pdf'))
$risposta->oggetto = "Oggetto Test " . rand(1, 10000);
$risposta->corpo = "Questo è il corpo della risposta di test.";

if ($risposta->create()) {
    echo "Risposta creata correttamente.<br>";
    // Recupera l'ultimo id inserito
    $last_id = $db->insert_id;
} else {
    echo "Errore nella creazione della risposta.<br>";
    $last_id = null;
}

// 2. Test lettura risposte
echo "<h3>Test: Lettura Risposte</h3>";
$result = $risposta->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_risposta']} | Data: {$row['dataora']} | Oggetto: {$row['oggetto']} | Corpo: {$row['corpo']}<br>";
    }
} else {
    echo "Nessuna risposta trovata.<br>";
}

// 3. Test eliminazione risposta appena creata
if ($last_id) {
    echo "<h3>Test: Eliminazione Risposta</h3>";
    $risposta->id_risposta = $last_id;
    if ($risposta->delete()) {
        echo "Risposta eliminata correttamente.<br>";
    } else {
        echo "Errore nell'eliminazione della risposta.<br>";
    }
}
?>
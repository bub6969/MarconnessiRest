
<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/annuncio.php';

$database = new Database();
$db = $database->getConnection();
$annuncio = new Annuncio($db);

// 1. Test lettura annunci
echo "<h3>Test: Lettura Annunci</h3>";
$result = $annuncio->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_annuncio']} | Oggetto: {$row['oggetto_annuncio']} | Corpo: {$row['corpo_annuncio']} | Data: {$row['data_annuncio']} | Persona: {$row['id_persona']}<br>";
    }
} else {
    echo "Nessun annuncio trovato.<br>";
}

// 2. Test creazione annuncio
echo "<h3>Test: Creazione Annuncio</h3>";
$annuncio->oggetto_annuncio = "Test Oggetto " . rand(1, 10000);
$annuncio->corpo_annuncio = "Questo è un annuncio di test.";
$annuncio->data_annuncio = date("Y-m-d H:i:s");
$annuncio->id_persona = 1; // Sostituisci con un id_persona valido esistente in persone

if ($annuncio->create()) {
    echo "Annuncio creato correttamente.<br>";
} else {
    echo "Errore nella creazione dell'annuncio.<br>";
}
?>
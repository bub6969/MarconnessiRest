<?php

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/edificio.php';

$database = new Database();
$db = $database->getConnection();
$edificio = new Edificio($db);

// 1. Test creazione edificio
echo "<h3>Test: Creazione Edificio</h3>";
$edificio->id_edificio = "Z"; // Scegli un id_edificio non già presente
$edificio->edificio = "Edificio Test";

if ($edificio->createEdificio()) {
    echo "Edificio creato correttamente.<br>";
} else {
    echo "Errore nella creazione dell'edificio (forse id_edificio già esistente).<br>";
}

// 2. Test eliminazione edificio appena creato
echo "<h3>Test: Eliminazione Edificio</h3>";
if ($edificio->deleteEdificio()) {
    echo "Edificio eliminato correttamente.<br>";
} else {
    echo "Errore nell'eliminazione dell'edificio.<br>";
}

// 3. Test lettura edifici
echo "<h3>Test: Lettura Edifici</h3>";
$result = $edificio->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_edificio']} | Nome: {$row['edificio']}<br>";
    }
} else {
    echo "Nessun edificio trovato.<br>";
}
?>
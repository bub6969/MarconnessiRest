<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/aula.php';

$database = new Database();
$db = $database->getConnection();
$aula = new Aula($db);

// 1. Test lettura aule
echo "<h3>Test: Lettura Aule</h3>";
$result = $aula->read();
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id_aula']} | Nome: {$row['aula']} | Edificio: {$row['id_edificio']}<br>";
    }
} else {
    echo "Nessuna aula trovata.<br>";
}

// 2. Test creazione aula
echo "<h3>Test: Creazione Aula</h3>";
$aula->aula = "Aula Test";
$aula->id_edificio = 'm'; // Sostituisci con un id_edificio valido

if ($aula->createAula()) {
    echo "Aula creata correttamente.<br>";
} else {
    echo "Errore nella creazione dell'aula.<br>";
}
?>
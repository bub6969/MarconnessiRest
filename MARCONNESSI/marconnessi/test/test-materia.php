<?php
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../models/materia.php';

$database = new Database();
$db = $database->getConnection();
$materia = new Materia($db);

// 1. Test creazione materia
echo "<h3>Test: Creazione Materia</h3>";
$materia->nome_materia = "Materia Test " . rand(1, 10000);

if ($materia->createMateria()) {
    echo "Materia creata correttamente con id: {$materia->id_materia}<br>";
} else {
    echo "Errore nella creazione della materia.<br>";
}

// 2. Test eliminazione materia appena creata
echo "<h3>Test: Eliminazione Materia</h3>";
if ($materia->deleteMateria()) {
    echo "Materia eliminata correttamente.<br>";
} else {
    echo "Errore nell'eliminazione della materia.<br>";
}

// 3. Test lettura materie (aggiungi questo metodo nella classe se non esiste)
echo "<h3>Test: Lettura Materie</h3>";
if (method_exists($materia, 'read')) {
    $result = $materia->read();
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: {$row['id_materia']} | Nome: {$row['nome_materia']}<br>";
        }
    } else {
        echo "Nessuna materia trovata.<br>";
    }
}
?>